<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_SESSION['start']) && (time() - $_SESSION['start'] > 15) && (time() - $_SESSION['last_activity'] > 15)) {
    session_unset();
    session_destroy();
} else {
	$_SESSION['last_activity'] = time();
}

/* if (!isset($_SESSION['customerId']) || $_SESSION['customerType'] !== 'customer') {
	header("Location: ../prihlaseni");
} */

if ($_SESSION['fingerprint'] != md5($_SERVER['HTTP_USER_AGENT'] . 'PHRASE' . $_SERVER['REMOTE_ADDR'])) {       
    session_destroy();
    header("Location: ../prihlaseni");
    exit();     
}

require '../vendor/autoload.php';
$customersViewObj = new customers\CustomersView();
$customersContrObj = new customers\CustomersContr();

$customerArray = $customersViewObj->showCustomer($_SESSION['customerUid']);

if (isset($_POST['save'])) {
	$customersContrObj->saveCustomer($_POST, $_SESSION['customerId']);
}

?>

<!DOCTYPE html>
    <html lang="cs">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <meta http-equiv="x-ua-compatible" content="ie=edge">

            <meta name="description" content="Dovoz, výroba a prodej brusiva a brusných materiálů od firem Starcke, VSM, Awuko a Granit. Vyrábíme brusné pásy, výseky a lamelové talíře.">
            <meta name="keywords" content="brusiva, houbičky">
            <meta name="author" content="Štěpán Váňa">

            <title>Abrasives | Dovoz, výroba a prodej brusiva a brusných materiálů</title>

            <base href="http://127.0.0.1/edsa-Abrasives/www/">
            <link rel="stylesheet" type="text/css" href="css/style.css">

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

            <!-- BOOTSTRAP -->
            <!-- MDB icon -->
            <link rel="icon" href="img/mdb-favicon.ico" type="image/x-icon">
            <!-- Font Awesome -->
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
            <!-- Google Fonts Roboto -->
            <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
            <!-- Bootstrap core CSS -->
            <link rel="stylesheet" href="css/bootstrap.min.css">
            <!-- Material Design Bootstrap -->
            <link rel="stylesheet" href="css/mdb.min.css">
        </head>
        <body>

        	<main class="text-center mt-5">
        		<div class="container">
        			<div class="row">
	        			<div class="col-md-4">
	        				<h3 class="h3-responsive text-uppercase font-weight-bold" style="letter-spacing: 1px;">
		        				<a class="navbar-brand waves-effect" href="http://127.0.0.1/edsa-Abrasives/www/">
					                <img src="https://mdbootstrap.com/wp-content/uploads/2018/06/logo-mdb-jquery-small.png" alt="Logo">
					            </a>
					        </h3>
	        			</div>
        			</div>
        			<div class="row">
        				<div class="col-md-4">
        					<div class="card text-left">
        						<div class="list-group list-group-flush" id="list-tab" role="tablist">
    								<h5 class="text-muted text-center py-4 mt-5 mb-5">
									    <strong><?php echo $customerArray['registred_name'] . " " . $customerArray['registred_sirname']; ?></strong>
									</h5>
									<a href="zakaznik/" class="list-group-item active list-group-item-action waves-effect">
										<i class="fas fa-home mr-3" style="width: 15px;text-align: center;"></i> Přehled
									</a>
									<a href="zakaznik/objednavky" class="list-group-item list-group-item-action waves-effect">
										<i class="fas fa-box-open mr-3" style="width: 15px;text-align: center;"></i> Objednávky
									</a>
									<a href="zakaznik/adresy" class="list-group-item list-group-item-action waves-effect">
										<i class="fas fa-map-marked-alt mr-3" style="width: 15px;text-align: center;"></i> Adresy
									</a>
									<a href="zakaznik/platebni_brany" class="list-group-item list-group-item-action waves-effect">
										<i class="far fa-credit-card mr-3" style="width: 15px;text-align: center;"></i> Platební metody
									</a>
								</div>
        					</div>
        					<div class="card mt-3">
        						<a class="list-group-item list-group-item-action" href="logout_customer.php">
									<i class="fas fa-sign-out-alt"></i> Odhlásit se
								</a>
        					</div>
        				</div>
        				<div class="col-md-8">
        					<div class="card text-left mb-5">
								<div class="tab-pane fade show">
									<h5 class="card-header primary-color white-text text-center py-4">
									    <strong>Detaily účtu</strong>
									</h5>
									<form class="text-center border-light p-5" action="" method="POST">
										<div class="row">
											<div class="col">
												<div class="md-form">
												  	<input name="customerName" type="text" id="customerName" class="form-control" value="<?php echo $customerArray['registred_name']; ?>">
												  	<label for="customerName">Jméno</label>
												</div>		
											</div>
											<div class="col">
												<div class="md-form">
												  	<input name="customerSirname" type="text" id="customerSirname" class="form-control" value="<?php echo $customerArray['registred_sirname']; ?>">
												  	<label for="customerSirname">Přijmení</label>
												</div>
											</div>
										</div>
										<div class="md-form">
										  	<input type="text" id="customerEmail" class="form-control" value="<?php echo $customerArray['registred_email']; ?>" disabled>
										  	<label for="customerEmail">E-mail</label>
										</div>
										<div class="md-form">
										  	<input name="customerCompany" type="text" id="customerCompany" class="form-control" value="<?php echo $customerArray['registred_company']; ?>">
										  	<label for="customerCompany">Společnost</label>
										</div>
										<div class="md-form">
										  	<input name="customerPhone" type="text" id="customerPhone" class="form-control" value="<?php echo $customerArray['registred_phone']; ?>">
										  	<label for="customerPhone">Telefon</label>
										</div>
										<hr class="hr">
										<div class="row">
											<div class="col">
												<div class="md-form">
												  	<input name="customerNewPsw" type="password" id="customerNewPsw" class="form-control">
												  	<label for="customerNewPsw">Nové heslo</label>
												</div>
											</div>
											<div class="col">
												<div class="md-form">
												  	<input name="customerOldPsw" type="password" id="customerOldPsw" class="form-control">
												  	<label for="customerOldPsw">Staré heslo</label>
												</div>
											</div>
										</div>
									    <button class="btn btn-primary btn-block my-4" type="submit" name="save">Uložit</button>
									    <a href="#" class="mx-2" role="button"><i class="fab fa-facebook-f light-blue-text"></i></a>
									    <a href="#" class="mx-2" role="button"><i class="fab fa-twitter light-blue-text"></i></a>
									    <a href="#" class="mx-2" role="button"><i class="fab fa-linkedin-in light-blue-text"></i></a>
									    <a href="#" class="mx-2" role="button"><i class="fab fa-github light-blue-text"></i></a>
									</form>
								</div>
							</div>
        				</div>
        			</div>
        		</div>
        	</main>

		<!-- jQuery -->
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<!-- Bootstrap tooltips -->
		<script type="text/javascript" src="js/popper.min.js"></script>
		<!-- Bootstrap core JavaScript -->
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<!-- MDB core JavaScript -->
		<script type="text/javascript" src="js/mdb.min.js"></script>
		<!-- Your custom scripts (optional) -->
		<script type="text/javascript">
			$( document ).ready(function() {
				new WOW().init();
			});
		</script>
  	</body>
</html>