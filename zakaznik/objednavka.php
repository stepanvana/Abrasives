<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['customerId']) || $_SESSION['customerType'] !== 'customer') {
	header("Location: /prihlaseni");
}

if (!isset($_GET['id'])) {
	header("Location: /prihlaseni");
}

require '../vendor/autoload.php';
$customersViewObj = new customers\CustomersView();
$customersContrObj = new customers\CustomersContr();
$ordersObj = new admin\orders\OrdersView();
$productsViewObj = new products\ProductsView();

$customerArray = $customersViewObj->showCustomer($_SESSION['customerUid']);
$orderArray = $ordersObj->showOrderDetail($_GET['id']);

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
								    <strong>Detaily objednávky</strong><br>
								    <small>Děkujeme za Vaší objednávku!</small>
								</h5>
								<div class="card-body p-5">
									<?php
									if ($orderArray == false) {
										echo "Zadali jste neplatné ID objednávky.";
									} elseif ($orderArray['customer_email'] !== $_SESSION['customerUid']) {
										echo "Zadali jste neplatné ID objednávky.";
									} else {
										?>
										<div class="row">
											<div class="col">
												<p class="text-muted">
													Číslo objednávky:
												</p>
												<p class="text-muted">
													Datum objednávky:
												</p>
												<p class="text-muted">
													Cena objednávky:
												</p>
												
											</div>
											<div class="col">
												<p>
													<?php echo $orderArray['order_code']; ?>
												</p>
												<p>
													<?php echo date("d.m.Y", strtotime($orderArray['order_date'])); ?>
												</p>
												<p>
													<?php echo $orderArray['payment_amount']; ?> Kč
												</p>
											</div>
										</div>
										<hr class="hr">
										<div class="row">
											<?php
											$productsIds = $ordersObj->showOrderProducts($orderArray['order_id']);
											foreach ($productsIds as $product) {
												$image = explode(";", $product['product_image']);
						                        $image = $image[0];
						                        ?>
						                        <div class="d-inline-flex col-lg-4 col-md-6 mb-4 productDetail text-left">
						                            <div class="card card-ecommerce">
						                                <div class="view overlay" style="height: 200px;">
						                                    <img src="/images/<?php echo $image; ?>" class="img-fluid p-2" alt="" s>
						                                    <a href="produkt/<?php echo $product['product_id'] ?>/<?php echo $product['product_url'] ?>">
						                                      <div class="mask rgba-white-slight"></div>
						                                    </a>
						                                </div>
						                                <div class="card-body align-bottom">
						                                    <?php
						                                    if ($product['product_discount'] > 0) {
						                                        ?>
						                                        <h5 class="card-title mb-1" style="float: left;">
						                                            <strong>
						                                                <a href="" class="dark-grey-text"><?php echo $product['product_name']; ?></a>
						                                            </strong>
						                                        </h5>
						                                        <span class="badge badge-danger mb-2" style="float: right;">-<?php echo $product['product_discount']; ?>%</span><br>
						                                        <hr class="hr">
						                                        <small><?php echo $product['product_shortDesc']; ?></small>
						                                        <div class="card-footer pb-0" style="background-color: white;">
						                                            <div class="row mb-0">
						                                                <span class="text-left">
						                                                    <strong>
						                                                        <a href="" class="dark-grey-text mr-2"><?php echo number_format($product['price'], 1); ?> Kč</a>
						                                                    </strong>
						                                                </span>
						                                                <span class="text-left">
						                                                    <small>
						                                                        <s><?php echo $product['product_price']; ?> Kč</s>
						                                                    </small>
						                                                </span>
						                                                <span class="text-right">
						                                                    <a href="produkt/<?php echo $product['product_id'] ?>/<?php echo $product['product_url'] ?>" class="" data-toggle="tooltip" data-placement="top" title="Nakoupit">
						                                                        <i class="fas fa-shopping-cart ml-3"></i>
						                                                    </a>
						                                                </span>
						                                            </div>
						                                        </div> 
						                                        <?php
						                                    } else {
						                                        ?>
						                                        <h5 class="card-title mb-1">
						                                            <strong>
						                                                <a href="" class="dark-grey-text"><?php echo $product['product_name']; ?></a>
						                                            </strong>
						                                        </h5>
						                                        <div class="card-footer pb-0" style="background-color: white;">
						                                            <div class="row mb-0">
						                                                <span class="text-left">
						                                                    <strong>
						                                                        <a href="" class="dark-grey-text"><?php echo $product['product_price']; ?> Kč</a>
						                                                    </strong>
						                                                </span>
						                                                <span class="text-right">
						                                                    <a href="produkt/<?php echo $product['product_id'] ?>/<?php echo $product['product_url'] ?>" class="" data-toggle="tooltip" data-placement="top" title="Nakoupit">
						                                                        <i class="fas fa-shopping-cart ml-3"></i>
						                                                    </a>
						                                                </span>
						                                            </div>
						                                        </div>    
						                                        <?php
						                                    }
						                                    ?>
						                                </div>
						                            </div>
						                        </div>
												<?php
											}
											?>
										</div>
										<hr class="hr">
                                        <div class="row">
                                            <div class="col-6">
                                                <small class="grey-text text-downcase font-weight-bold">
                                                    Osobní údaje
                                                </small>
                                                <p>
                                                    <?php echo $orderArray['customer_name'] . " " . $orderArray['customer_sirname']; ?><br>
                                                    <?php echo $orderArray['customer_company']; ?><br>
                                                </p>
                                            </div>
                                            <div class="col-6">
                                                <small class="grey-text text-downcase font-weight-bold">
                                                    Dodací údaje
                                                </small>
                                                <p>
                                                    <?php echo $orderArray['shipping_country']; ?><br>
                                                    <?php echo $orderArray['shipping_city'] . ", " . $orderArray['shipping_zip']; ?><br>
                                                    <?php echo $orderArray['shipping_street'] . ", " . $orderArray['shipping_descNumber']; ?><br>
                                                </p>
                                            </div>
                                        </div>
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