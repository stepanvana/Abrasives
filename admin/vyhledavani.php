<?php

include '../admin/class_autoload.php';

if (isset($_SESSION['userId'])) {

	$searchViewObj = new admin\search\SearchView();

	$ordersArray = $searchViewObj->showOrders($_GET['searchField']);
	$productsArray = $searchViewObj->showProducts($_GET['searchField']);
	$customersArray = $searchViewObj->showCustomers($_GET['searchField']);

	include '../admin/headerAdmin.php';

?>

<form enctype="multipart/form-data" name="changer" method="POST" action="">
	<header>
    	<nav class="navbar fixed-top navbar-expand-lg navbar-light white scrolling-navbar">
      		<div class="container-fluid">
        		<a class="navbar-brand waves-effect" href="https://mdbootstrap.com/docs/jquery/" target="_blank">
          			<strong class="blue-text">MDB</strong>
        		</a>
        		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          			<span class="navbar-toggler-icon"></span>
        		</button>
        		<div class="collapse navbar-collapse" id="navbarSupportedContent">
          			<!-- Left -->
          			<ul class="navbar-nav mr-auto">
          				<div id="asd">
				            <li class="nav-item <?php if($page == 'prehled.php'){ echo 'active';}?>">
				              	<a class="nav-link waves-effect" href="prehled.php" target="_blank">Přehled</a>
				            </li>
				            <li class="nav-item <?php if($page == 'objednavky.php'){ echo 'active';}?>">
				              	<a class="nav-link waves-effect" href="objednavky.php" target="_blank">Objednávky</a>
				            </li>
				            <li class="nav-item <?php if($page == 'produkty.php'){ echo 'active';}?>">
				              	<a class="nav-link waves-effect" href="produkty.php" target="_blank">Produkty</a>
				            </li>
				            <li class="nav-item <?php if($page == 'produkty-ceny.php'){ echo 'active';}?>">
				              	<a class="nav-link waves-effect" href="produkty-ceny.php" target="_blank">Ceny produktů</a>
				            </li>
				            <li class="nav-item <?php if($page == 'produkty-sklad.php'){ echo 'active';}?>">
				              	<a class="nav-link waves-effect" href="produkty-sklad.php" target="_blank">Sklad produktů</a>
				            </li>
				            <li class="nav-item <?php if($page == 'novy-produkt.php'){ echo 'active';}?>">
				              	<a class="nav-link waves-effect" href="novy-produkt.php" target="_blank">Nový produkt</a>
				            </li>
				            <li class="nav-item <?php if($page == 'zakaznici.php'){ echo 'active';}?>">
				              	<a class="nav-link waves-effect" href="zakaznici.php" target="_blank">Zákazníci</a>
				            </li>
				            <li class="nav-item <?php if($page == 'statistiky.php'){ echo 'active';}?>">
				              	<a class="nav-link waves-effect" href="statistiky.php" target="_blank">Statistiky</a>
				            </li>
				            <li class="nav-item <?php if($page == 'contact-messages.php'){ echo 'active';}?>">
				              	<a class="nav-link waves-effect" href="contact-messages.php" target="_blank">Zprávy</a>
				            </li>

          				</div>
          			</ul>
		          	<!-- Right -->
		          	<ul class="navbar-nav nav-flex-icons">
			            <li class="nav-item">
				            <a href="http://localhost/mujProjekt/admin/user.php">
							  	<?php echo "<img src='../images/".$userArray['user_image']."' style='margin-right: -20px;margin-left: 15px;' alt='avatar image' class='rounded-circle z-depth-0' width='50'>"; ?>
							  	<span class="badge badge-danger ml-2"><?php echo count($tasksArray); ?></span>
				            </a>
			            </li>
		          	</ul>
        		</div>
      		</div>
    	</nav>
    	<?php include 'includes/nav.inc.php'; ?>
    </header>

    <main class="pt-5 mx-lg-5">
    	<div class="container-fluid mt-5">
			<div class="row wow fadeIn" style="margin-top: 7%;">
				<?php
				if (isset($_GET['error']) && $_GET['error'] == 'get_data') {
					?>
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
					  	<strong>Nepodařilo se získat data!</strong> Zkontrolujte, zda byly zadány správné data, pokud problém setrvává kontaktujte správce webu.
					  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    	<span aria-hidden="true">&times;</span>
					  	</button>
					</div>
					<?php
				}
				?>
				<div class="col-md-12">
					<div class="card mb-4">
						<div class="card-body text-center">
						    <ul class="nav nav-pills nav-fill" id="pills-tab" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" id="pills-objednavky-tab" data-toggle="pill" href="#pills-objednavky" role="tab" aria-controls="pills-objednavky" aria-selected="true">Objednávky (<?php echo count($ordersArray); ?>)</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="pills-produkty-tab" data-toggle="pill" href="#pills-produkty" role="tab" aria-controls="pills-produkty" aria-selected="false">Produkty (<?php echo count($productsArray); ?>)</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="pills-zakaznici-tab" data-toggle="pill" href="#pills-zakaznici" role="tab" aria-controls="pills-zakaznici" aria-selected="false">Zákazníci (<?php echo count($customersArray); ?>)</a>
								</li>
							</ul>
						</div>
					</div>

					<div class="card mb-4">	
				        <div class="tab-content" id="pills-tabContent">
							<div class="tab-pane fade show active" id="pills-objednavky" role="tabpanel" aria-labelledby="pills-objednavky-tab">
								<div class="card-header text-center">
					              	Objednávky
					            </div>
					            <div class="card-body text-left">
								    <table id="dtBasicExample" class="table table-hover table-bordered table-sm" cellspacing="0" width="100%">
					                	<thead class="blue lighten-4">
					                  		<tr>
					                    		<th class="th-sm">Kód a datum</th>
					                    		<th class="th-sm">Jméno a přijmení</th>
					                    		<th class="th-sm">Způsob dopravy</th>
					                    		<th class="th-sm">Platba</th>
					                    		<th class="th-sm">Stav</th>
					                    		<th class="th-sm">Cena</th>
					                  		</tr>
					                	</thead>
						  				<tbody>
					                  		<?php
					                  		foreach ($ordersArray as $row) { ?>
												<tr>
							                    	<td><a href="detail-objednavky.php?id=<?php echo $row['order_id'] ?>"><?php echo $row['order_code'] . "<br>" . $row['order_date']; ?></a></td>
							                    	<td><?php echo $row['customer_name'] . " " . $row['customer_sirname']; ?></td>
							                    	<td><?php echo $row['shipping_method']; ?></td>
							                    	<td><?php echo $row['paymentMethod_method'] . "<br>" . $row['paymentStatus_status']; ?></td>
							                    	<td><?php echo $row['condition_condition']; ?></td>
							                    	<td><?php echo $row['payment_amount']; ?></td>
						                    	</tr> <?php
					                  		}
					                  		?>
					                  	</tbody>
					              	</table>
				            	</div>
					        </div>
				            <div class="tab-pane fade" id="pills-produkty" role="tabpanel" aria-labelledby="pills-produkty-tab">
								<div class="card-header text-center">
					              	Produkty
					            </div>
					            <div class="card-body text-left">
								    <table id="dtBasicExample" class="table table-hover table-bordered table-sm" cellspacing="0" width="100%">
					                	<thead class="blue lighten-4">
					                  		<tr>
					                    		<th class="th-sm">Kód produktu</th>
					                    		<th class="th-sm">Název</th>
					                    		<th class="th-sm">Cena</th>
					                    		<th class="th-sm">Kategorie</th>
					                    		<th class="th-sm">Sklad</th>
					                  		</tr>
					                	</thead>
						  				<tbody>
					                  		<?php
					                  		foreach ($productsArray as $row) { ?>
												<tr>
							                    	<td><a href="detail-produktu.php?id=<?php echo $row['product_id'] ?>"><?php echo $row['product_code']; ?></a></td>
							                    	<td><a href="detail-produktu.php?id=<?php echo $row['product_id'] ?>"><?php echo $row['product_name']; ?></a></td>
							                    	<td><?php echo $row['product_price']; ?></td>
							                    	<td><?php echo $row['category_name']; ?></td>
							                    	<td><?php echo $row['product_storage']; ?></td>
						                    	</tr> <?php
					                  		}
					                  		?>
					                  	</tbody>
					              	</table>
				            	</div>
				            </div>
				            <div class="tab-pane fade" id="pills-zakaznici" role="tabpanel" aria-labelledby="pills-zakaznici-tab">
				            	<div class="card-header text-center">
					              	Zákazníci
					            </div>
					            <div class="card-body text-left">
								    <table id="dtBasicExample" class="table table-hover table-bordered table-sm" cellspacing="0" width="100%">
					                	<thead class="blue lighten-4">
					                  		<tr>
					                    		<th class="th-sm">E-mail</th>
					                    		<th class="th-sm">Jméno a přijmení</th>
					                    		<th class="th-sm">Společnost</th>
					                    		<th class="th-sm">Celkem objednávek</th>
					                    		<th class="th-sm">Fakturační adresa</th>
					                    		<th class="th-sm">Dodací adresa</th>
					                    		<th class="th-sm">Telefon</th>
					                  		</tr>
					                	</thead>
						  				<tbody>
					                  		<?php
					                  		foreach ($customersArray as $row) { ?>
												<tr>
							                    	<td><a href="detail-zakaznika.php?customer=<?php echo $row['customer_email'] ?>"><?php echo $row['customer_email']; ?></a></td>
							                    	<td><?php echo $row['customer_name'] . " " . $row['customer_sirname']; ?></td>
							                    	<td><?php echo $row['customer_company']; ?></td>
							                    	<td><?php echo $row['totalOrders']; ?></td>
							                    	<td><?php echo $row['billing_country'] . "<br>" . $row['billing_city'] . ", " . $row['billing_zip'] . "<br>" . $row['billing_street'] . ", " . $row['billing_descNumber']; ?></td>
					                  				<td><?php echo $row['shipping_country'] . "<br>" . $row['shipping_city'] . ", " . $row['shipping_zip'] . "<br>" . $row['shipping_street'] . ", " . $row['shipping_descNumber']; ?></td>
					                  				<td><?php echo $row['customer_phone']; ?></td>
						                    	</tr> <?php
					                  		}
					                  		?>
					                  	</tbody>
					              	</table>
				            	</div>
				            </div>
					    </div>
				    </div>
		        </div>
		    </div>
		</div>
	</main>
</form>

<?php
include 'footer.php';
} else {               
	header("Location: ../index.php");
}
?>