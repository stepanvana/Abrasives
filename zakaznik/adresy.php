<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['customerId']) || $_SESSION['customerType'] !== 'customer') {
	header("Location: /prihlaseni");
}

require '../vendor/autoload.php';
$customersViewObj = new customers\CustomersView();
$customersContrObj = new customers\CustomersContr();
$ordersObj = new admin\orders\OrdersView();
$productsViewObj = new products\ProductsView();

$customerArray = $customersViewObj->showCustomer($_SESSION['customerUid']);

if (isset($_POST['create'])) {
    $customersContrObj->createAddress($_POST, $_SESSION['customerId']);
}

if (isset($_POST['save'])) {
    $customersContrObj->saveAddress($_POST, $_SESSION['customerId']);
}

if (isset($_POST['delete'])) {
    $customersContrObj->deleteAddress($_SESSION['customerId']);
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
									    <strong><?php echo $customerArray['registred_name']; ?></strong>
									</h5>
									<a href="zakaznik/" class="list-group-item list-group-item-action waves-effect">
                                        <i class="fas fa-home mr-3" style="width: 15px;text-align: center;"></i> Přehled
                                    </a>
                                    <a href="zakaznik/objednavky" class="list-group-item list-group-item-action waves-effect">
                                        <i class="fas fa-box-open mr-3" style="width: 15px;text-align: center;"></i> Objednávky
                                    </a>
                                    <a href="zakaznik/adresy" class="list-group-item active list-group-item-action waves-effect">
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
                                    <strong>Adresy</strong><br>
                                    <small>Nastavení výchozí adresy</small>
                                </h5>
                                <div class="card-body p-5">
                                    <form action="" method="POST">
                                        <?php
                                        $addresses = $customersViewObj->showAddress($_SESSION['customerId']);
                                        ?>
                                        <div class="row">
                                            <div class="col-6">
                                                <small class="grey-text text-downcase font-weight-bold">
                                                    Osobní údaje
                                                </small>
                                                <p>
                                                    <div class="md-form">
                                                        <input name="customerName" type="text" id="customerName" class="form-control unsaved" value="<?php echo $customerArray['registred_name'] . " " . $customerArray['registred_sirname']; ?>" disabled>
                                                        <label for="customerName">Jméno</label>
                                                    </div>
                                                    <div class="md-form">
                                                        <input name="customerCompany" type="text" id="customerCompany" class="form-control unsaved" value="<?php echo $customerArray['registred_company']; ?>" disabled>
                                                        <label for="customerCompany">Společnost</label>
                                                    </div>
                                                </p>
                                            </div>
                                            <div class="col-6">
                                                <small class="grey-text text-downcase font-weight-bold">
                                                    Fakturační údaje
                                                </small>
                                                <p>
                                                    <div class="md-form">
                                                        <input name="billingCountry" type="text" id="billingCountry" class="form-control unsaved" value="<?php echo $addresses['billing_country']; ?>">
                                                        <label for="billingCountry">Země</label>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="md-form">
                                                                <input name="billingCity" type="text" id="billingCity" class="form-control unsaved" value="<?php echo $addresses['billing_city']; ?>">
                                                                <label for="billingCity">Město</label>
                                                            </div>        
                                                        </div>
                                                        <div class="col">
                                                            <div class="md-form">
                                                                <input name="billingZip" type="text" id="billingZip" class="form-control unsaved" value="<?php echo $addresses['billing_zip']; ?>">
                                                                <label for="billingZip">PSČ</label>
                                                            </div>        
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="md-form">
                                                                <input name="billingStreet" type="text" id="billingStreet" class="form-control unsaved" value="<?php echo $addresses['billing_street']; ?>">
                                                                <label for="billingStreet">Ulice</label>
                                                            </div>        
                                                        </div>
                                                        <div class="col">
                                                            <div class="md-form">
                                                                <input name="billingDescNum" type="text" id="billingDescNum" class="form-control unsaved" value="<?php echo $addresses['billing_desc_num']; ?>">
                                                                <label for="billingDescNum">Číslo popisné</label>
                                                            </div>        
                                                        </div>
                                                    </div>
                                                </p>
                                                <small class="grey-text text-downcase font-weight-bold">
                                                    Dodací údaje
                                                </small>
                                                <p>
                                                    <div class="md-form">
                                                        <input name="shippingCountry" type="text" id="shippingCountry" class="form-control unsaved" value="<?php echo $addresses['shipping_country']; ?>">
                                                        <label for="shippingCountry">Země</label>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="md-form">
                                                                <input name="shippingCity" type="text" id="shippingCity" class="form-control unsaved" value="<?php echo $addresses['shipping_city']; ?>">
                                                                <label for="shippingCity">Město</label>
                                                            </div>        
                                                        </div>
                                                        <div class="col">
                                                            <div class="md-form">
                                                                <input name="shippingZip" type="text" id="shippingZip" class="form-control unsaved" value="<?php echo $addresses['shipping_zip']; ?>">
                                                                <label for="shippingZip">PSČ</label>
                                                            </div>        
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="md-form">
                                                                <input name="shippingStreet" type="text" id="shippingStreet" class="form-control unsaved" value="<?php echo $addresses['shipping_street']; ?>">
                                                                <label for="shippingStreet">Ulice</label>
                                                            </div>        
                                                        </div>
                                                        <div class="col">
                                                            <div class="md-form">
                                                                <input name="shippingDescNum" type="text" id="shippingDescNum" class="form-control unsaved" value="<?php echo $addresses['shipping_desc_num']; ?>">
                                                                <label for="shippingDescNum">Číslo popisné</label>
                                                            </div>        
                                                        </div>
                                                    </div>
                                                </p>
                                            </div>
                                        </div>
                                        <?php
                                        if (empty($addresses)) {
                                            ?>
                                            <div class="row">
                                                <div class="col-9"></div>
                                                <div class="col-3 text-right">
                                                    <button class="btn btn-primary btn-sm btn-block my-4" type="submit" name="create">Uložit</button>
                                                </div>
                                            </div> 
                                            <?php
                                        } else {
                                            ?>
                                            <div class="row">
                                                <div class="col-6"></div>
                                                <div class="col-3 text-right">
                                                    <button class="btn btn-primary btn-sm btn-block my-4" type="submit" name="save">Uložit</button>
                                                </div>
                                                <div class="col-3">
                                                    <button class="btn btn-danger btn-sm btn-block my-4" type="submit" name="delete">Odstranit</button>
                                                </div>
                                            </div> 
                                            <?php
                                        }
                                        ?>
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