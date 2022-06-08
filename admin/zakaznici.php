<?php

include '../admin/class_autoload.php';

if (isset($_SESSION['userId'])) {

	$customersViewObj = new admin\customers\CustomersView();
	$customersContrObj = new admin\customers\CustomersContr();
	$customersArray = $customersViewObj->showCustomers();

	if (isset($_POST['deleteCustomers'])) {
		$customersContrObj->deleteCustomers($_POST['checkbox']);
	}

	include '../admin/headerAdmin.php';

	?>

<form method="POST" action="">
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
							<div class="btn-group">
							  <button type="button" class="btn btn-outline-info btn-md dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							    Výběr
							  </button>
							  <div class="dropdown-menu dropdown-menu-right">
							    <button class="dropdown-item" type="submit" name="deleteCustomers" onclick="return confirm('Opravdu si přejete zákazníka odstranit?')">Odstranit</button>
							  </div>
							</div>
			            </li>
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
				if (isset($_GET['error']) && $_GET['error'] == 'get_customers') {
					?>
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
					  	<strong>Nepovedlo se získat data!</strong> Pokud problém setrvává kontaktujte správce webu.
					  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    	<span aria-hidden="true">&times;</span>
					  	</button>
					</div>
					<?php
				} elseif (isset($_GET['error']) && $_GET['error'] == 'customers_edit') {
					?>
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
					  	<strong>Nepovedlo se upravit data!</strong> Zkontrolujte, zda byly zadány správné data, pokud problém setrvává kontaktujte správce webu.
					  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    	<span aria-hidden="true">&times;</span>
					  	</button>
					</div>
					<?php
				} elseif (isset($_GET['error']) && $_GET['error'] == 'not_existing_customer') {
					?>
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
					  	<strong>Neexistující zákazník!</strong> Zvolený zákazník nebyl nalezen, zkontrolujte, zda byly zadány správné data, pokud problém setrvává kontaktujte správce webu.
					  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    	<span aria-hidden="true">&times;</span>
					  	</button>
					</div>
					<?php
				} elseif (isset($_GET['success'])) {
					?>
					<div class="alert alert-success alert-dismissible fade show" role="alert">
					  	<strong>Data byly úspěšně upraveny!</strong>
					  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    	<span aria-hidden="true">&times;</span>
					  	</button>
					</div>
					<?php
				}
				?>
				<div class="col-md-12">
					<div class="card mb-4">
						<div class="card-header text-center">
			              	Zákazníci
			            </div>
			            <div class="card-body">
			            	<div class="tab-content" id="pills-tabContent">
			            		<div class="tab-pane fade show active" id="pills-vse">
			            			<table id="dtBasicExample" class="table table-hover table-bordered table-sm" cellspacing="0" width="100%">
					                	<thead class="blue lighten-4">
					                  		<tr>
					                    		<th class="th-sm">#</th>
					                    		<th class="th-sm">E-mail</th>
					                    		<th class="th-sm">Jméno</th>
					                    		<th class="th-sm">Společnost</th>
					                    		<th class="th-sm">Celkem objednávek</th>
					                    		<th class="th-sm">Fakturační adresa</th>
					                    		<th class="th-sm">Dodací adresa</th>
					                    		<th class="th-sm">Telefon</th>
					                  		</tr>
					                	</thead>
						  				<tbody>
					                  		<?php
					                  		if (empty($customersArray)) {
							            		?>
												<div class="alert alert-danger alert-dismissible fade show" role="alert">
												  	<strong>Žádné data ve výběru!</strong> Zatím nebyly vytvořeny žádní zákazníci.
												  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
												    	<span aria-hidden="true">&times;</span>
												  	</button>
												</div>
												<?php
							            	} else {
								            	foreach ($customersArray as $row) {
						                  			?>
						                  			<tr>
						                  				<th scope="row">
															<div class="custom-control custom-checkbox">
															    <input name='checkbox[]' type="checkbox" class="custom-control-input" id="defaultUnchecked<?php echo $row['customer_id']; ?>" value="<?php echo $row['customer_id']; ?>">
															    <label class="custom-control-label" for="defaultUnchecked<?php echo $row['customer_id']; ?>"></label>
															    <input type="hidden" name="ids[]" value="<?php echo $row['customer_id']; ?>">
															</div>
														</th>
						                  				<td><a href="detail-zakaznika.php?customer=<?php echo $row['customer_email']; ?>"><?php echo $row['customer_email']; ?></a></td>
						                  				<td><a href="detail-zakaznika.php?customer=<?php echo $row['customer_email']; ?>"><?php echo $row['customer_name'] . $row['customer_sirname']; ?></a></td>
						                  				<td><?php echo $row['customer_company']; ?></td>
						                  				<td><?php echo $row['totalOrders']; ?></td>
						                  				<td><?php echo $row['billing_country'] . "<br>" . $row['billing_city'] . ", " . $row['billing_zip'] . "<br>" . $row['billing_street'] . ", " . $row['billing_descNumber']; ?></td>
						                  				<td><?php echo $row['shipping_country'] . "<br>" . $row['shipping_city'] . ", " . $row['shipping_zip'] . "<br>" . $row['shipping_street'] . ", " . $row['shipping_descNumber']; ?></td>
						                  				<td><?php echo $row['customer_phone']; ?></td>
						                  			</tr>
						                  			<?php
						                  		}	
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