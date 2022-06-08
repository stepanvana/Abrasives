<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['customerId']) || $_SESSION['customerType'] !== 'customer') {
	header("Location: /prihlaseni");
}

require '../vendor/autoload.php';
$customersViewObj = new customers\CustomersView();
$ordersObj = new admin\orders\OrdersView();
$productsViewObj = new products\ProductsView();

$customerArray = $customersViewObj->showCustomer($_SESSION['customerUid']);

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
									    <strong><?php echo $customerArray['registred_name']; ?></strong>
									</h5>
									<a href="zakaznik/" class="list-group-item list-group-item-action waves-effect">
										<i class="fas fa-home mr-3" style="width: 15px;text-align: center;"></i> Přehled
									</a>
									<a href="zakaznik/objednavky" class="list-group-item active list-group-item-action waves-effect">
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
								<h5 class="card-header primary-color white-text text-center py-4">
								    <strong>Objednávky</strong>
								</h5>
								<div class="card-body p-5">
									<?php
									$customerOrders = $ordersObj->showCustomerOrders($_SESSION['customerUid']);
									foreach ($customerOrders as $row) {
										?>
										<div class="row">
											<div class="col">
												<p class="text-muted">
													Číslo objednávky:
												</p>
												<p>
													<?php echo $row['order_code']; ?>
												</p>
											</div>
											<div class="col">
												<p class="text-muted">
													Datum objednávky:
												</p>
												<p>
													<?php echo date("d.m.Y", strtotime($row['order_date'])); ?>
												</p>
											</div>
											<div class="col">
												<p class="text-muted">
													Cena objednávky:
												</p>
												<p>
													<?php echo $row['payment_amount']; ?> Kč
												</p>
											</div>
										</div>
										<div class="row">
											<?php
											$productsIds = $ordersObj->showOrderProducts($row['order_id']);
											$count = count($productsIds);
											if ($count > 3) {
												$loop = 4;
											} else {
												$loop = $count;
											}
											for ($i=0; $i < $loop; $i++) {
												$image = explode(";", $productsIds[$i]['product_image']);
												if ($i == 3) {
													?>
													<div class="col-3">
														<div class="view">
															<img src="/images/<?php echo $image[0]; ?>" class="img-fluid" alt="placeholder">
															<div class="mask flex-center waves-effect waves-light rgba-black-strong">
																<p class="white-text">+<?php echo $count - $i; ?></p>
															</div>
														</div>
													</div>
													<?php
												} else {
													?>
													<div class="col-3">
														<img src="/images/<?php echo $image[0]; ?>" style="width: 100%;">	
													</div>
													<?php	
												}
											}
											?>
										</div>
										<div class="row text-right">
											<div class="col-9"></div>
											<div class="col-3">
												<a href="/zakaznik/objednavka/<?php echo $row['order_id']; ?>"><button class="btn btn-primary btn-sm btn-block my-4" type="button">Zobrazit</button></a>
											</div>
										</div>
										<hr class="hr">
										<?php
									}
									?>
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