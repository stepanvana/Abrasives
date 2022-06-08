<?php

include '../admin/class_autoload.php';

if (isset($_SESSION['userId']) && isset($_GET['customer'])) {

	$email = $_GET['customer'];

	$customerViewObj = new admin\customers\CustomersView();
	$customerContrObj = new admin\customers\CustomersContr();
	$ordersViewObj = new admin\orders\OrdersView();
	$customerInfoArray = $customerViewObj->showInfoCustomer($email);
	if (empty($customerInfoArray)) {
		header("Location: ?error=not_existing_customer");
		exit();
	}
	$customerBillingArray = $customerViewObj->showBillingCustomer($email);
	$customerShippingArray = $customerViewObj->showShippingCustomer($email);
	$customerOrdersArray = $ordersViewObj->showCustomerOrders($email);
	$ratingSettings = $customerViewObj->showRatingSettings();
	$utrataSum = $customerViewObj->showSpendings($email);

	$counts = array_column($customerOrdersArray, 'condition_condition');

	$vyrizenoCount = count(array_keys($counts, "Vyřizuje se"));
	$vyrizenoCount = $vyrizenoCount + count(array_keys($counts, "Vyřízeno"));
	$vyrizenoCount = $vyrizenoCount + count(array_keys($counts, "Odesláno"));
	$stornovanoCount = count(array_keys($counts, "Stornováno"));
	$latestOrder = max(array_column($customerOrdersArray,'order_date'));
	$celkemCount = count($customerOrdersArray);

	if (isset($_POST['saveCustomer'])) {
		$customerContrObj->saveCustomer($_POST['customerName'], $_POST['customerSirname'], $_POST['customerCompany'], $_POST['customerPhone'], $_POST['billingCountry'], $_POST['billingCity'], $_POST['billingZip'], $_POST['billingStreet'], $_POST['billingDescNumber'], $_POST['shippingCountry'], $_POST['shippingCity'], $_POST['shippingZip'], $_POST['shippingStreet'], $_POST['shippingDescNumber'], $_POST['customerNote'], $email, $_POST['customerIds'], $_POST['billingIds'], $_POST['shippingIds']);
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
			              	<button id="save" type="submit" name="saveCustomer" class="btn btn-outline-success btn-md waves-effect">Uložit</button>
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
		    <div class="row wow fadeIn" style="margin-top: 5%;">
		      	<div class="col-md-6 col-lg-3 mb-4">
		        	<div class="card primary-color white-text">
		          		<div class="card-body d-flex justify-content-between align-items-center">
		            		<div>
		              			<p class="h2-responsive font-weight-bold mt-n2 mb-0"><?php echo $celkemCount; ?></p>
		              			<p class="mb-0">Počet objednávek</p>
		            		</div>
		            		<div>
		              			<i class="fas fa-shopping-bag fa-4x text-black-40"></i>
		            		</div>
		          		</div>
		          		<a class="card-footer footer-hover small text-center white-text border-0 p-2">More info<i class="fas fa-arrow-circle-right pl-2"></i></a>
		        	</div>
		      	</div>
		      	<div class="col-md-6 col-lg-3 mb-4">
		        	<div class="card warning-color white-text">
		          		<div class="card-body d-flex justify-content-between align-items-center">
		            		<div>
		              			<p class="h2-responsive font-weight-bold mt-n2 mb-0"><?php echo $utrataSum['suma']; ?> Kč</p>
		              			<p class="mb-0">Celková útrata</p>
		            		</div>
		            		<div>
		              			<i class="fas fa-chart-bar fa-4x text-black-40"></i>
		            		</div>
		          		</div>
		          		<a class="card-footer footer-hover small text-center white-text border-0 p-2">More info<i class="fas fa-arrow-circle-right pl-2"></i></a>
		        	</div>
		      	</div>
		      	<div class="col-md-6 col-lg-3 mb-4">
		        	<div class="card light-blue lighten-1 white-text">
		          		<div class="card-body d-flex justify-content-between align-items-center">
		            		<div>
		              			<p class="h2-responsive font-weight-bold mt-n2 mb-0"><?php echo date("d.m.Y H:i:s", strtotime($latestOrder)); ?></p>
		              			<p class="mb-0">Poslední nákup</p>
		            		</div>
			            	<div>
			              		<i class="fas fa-user-plus fa-4x text-black-40"></i>
			            	</div>
		          		</div>
		          		<a class="card-footer footer-hover small text-center white-text border-0 p-2">More info<i class="fas fa-arrow-circle-right pl-2"></i></a>
		        	</div>
		      	</div>
		      	<div class="col-md-6 col-lg-3 mb-4">
		        	<div class="card red accent-2 white-text">
		          		<div class="card-body d-flex justify-content-between align-items-center">
		            		<div>
		              			<p class="h2-responsive font-weight-bold mt-n2 mb-0"><?php echo $stornovanoCount; ?></p>
		              			<p class="mb-0">Stornovaných objednávek</p>
		            		</div>
		            		<div>
		              			<i class="fas fa-chart-pie fa-4x text-black-40"></i>
		            		</div>
		          		</div>
		          		<a class="card-footer footer-hover small text-center white-text border-0 p-2">More info<i class="fas fa-arrow-circle-right pl-2"></i></a>
		        	</div>
		      	</div>
		    </div>
		    <div class="col-md-12">
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
					  	<strong>Nepovedlo se upravit zíkazníka!</strong> Zkontrolujte, zda byly zadány správné data, pokud problém setrvává kontaktujte správce webu.
					  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    	<span aria-hidden="true">&times;</span>
					  	</button>
					</div>
					<?php
				} elseif (isset($_GET['error']) && $_GET['error'] == 'get_data') {
					?>
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
					  	<strong>Nepovedlo se upravit zíkazníka!</strong> Zkontrolujte, zda byly zadány správné data, pokud problém setrvává kontaktujte správce webu.
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
		    </div>
			<div class="row wow fadeIn" style="margin-top: 3%;">
				<div class="col-md-12">
					<div class="card mb-4">
						<div class="card-body text-center">
						    <ul class="nav nav-pills nav-fill" id="pills-tab" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" id="pills-main-tab" data-toggle="pill" href="#pills-main" role="tab" aria-controls="pills-main" aria-selected="true">Údaje zákazníka</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="pills-objednavky-tab" data-toggle="pill" href="#pills-objednavky" role="tab" aria-controls="pills-objednavky" aria-selected="false">Objednávky zákazníka</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="pills-hodnoceni-tab" data-toggle="pill" href="#pills-hodnoceni" role="tab" aria-controls="pills-hodnoceni" aria-selected="false">Hodnocení zákazníka</a>
								</li>
							</ul>
						</div>
					</div>

					<div class="card mb-4" style="margin-top: 3%;">	
				        <div class="tab-content" id="pills-tabContent">
							<div class="tab-pane fade show active" id="pills-main" role="tabpanel" aria-labelledby="pills-main-tab">
								<div class="card-header text-center">
					              	Údaje zákazníka
					            </div>
					            <div class="card-body text-left">
					            	<h3 class="h4-responsive">Osobní údaje</h3>
					            	<?php
									if (count($customerInfoArray) > 1) {
					            		?>
					            		<div class="alert alert-danger alert-dismissible fade show" role="alert">
										  	<strong>Více údajů!</strong> Zákazník s touto e-mailovou adresou (<?php echo $email; ?>) při objednání vypnil odlišné osobní údaje. Upravte je tak, aby byly totožné.
										  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										    	<span aria-hidden="true">&times;</span>
										  	</button>
										</div>
										<?php
					            	} elseif (count($customerInfoArray) == 0) {
					            		?>
					            		<div class="alert alert-danger alert-dismissible fade show" role="alert">
										  	<strong>Žádné údaje!</strong> Zákazník s touto e-mailovou adresou (<?php echo $email; ?>) nemá přiřazené žádné osobní údaje. Doplňte je.
										  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										    	<span aria-hidden="true">&times;</span>
										  	</button>
										</div>
										<?php
					            	}
					            	?>
					            	<div class="form-row mb-4" style="margin-top: 2%;">
					            	<?php
					            	$id = 1;
					            	foreach ($customerInfoArray as $infoRow) {
					            		?>
									    <div class="col">
									    	<h5 class="h4-responsive"><?php echo $id; ?>. verze údajů</h5>
							            	<div class="md-form md-outline">
											  	<input name="customerName[]" type="text" id="customerName" class="form-control unsaved" value="<?php echo $infoRow['customer_name']; ?>" required>
											  	<label for="customerName">Jméno</label>
											</div>
											<div class="md-form md-outline">
											  	<input name="customerSirname[]" type="text" id="customerSirname" class="form-control unsaved" value="<?php echo $infoRow['customer_sirname']; ?>" required>
											  	<label for="customerSirname">Přijmení</label>
											</div>
											<div class="md-form md-outline">
											  	<input name="customerCompany[]" type="text" id="customerCompany" class="form-control unsaved" value="<?php echo $infoRow['customer_company']; ?>" required>
											  	<label for="customerCompany">Společnost</label>
											</div>
											<div class="md-form md-outline">
											  	<input name="customerEmail[]" type="text" id="customerEmail" class="form-control unsaved" value="<?php echo $infoRow['customer_email']; ?>" required disabled>
											  	<label for="customerEmail">E-mail</label>
											</div>
											<div class="md-form md-outline">
											  	<input name="customerPhone[]" type="text" id="customerPhone" class="form-control unsaved" value="<?php echo $infoRow['customer_phone']; ?>" required>
											  	<label for="customerPhone">Telefonní číslo</label>
											</div>	
						            	</div>
						            	<input type="hidden" name="customerIds[]" value="<?php echo $infoRow['customer_id']; ?>">
					            		<?php
					            		$id++;
					            	}
					            	?>
					            	</div>
					            	<hr>

					            	<h3 class="h4-responsive">Fakturační adresa</h3>
					            	<?php
									if (count($customerBillingArray) > 1) {
					            		?>
					            		<div class="alert alert-danger alert-dismissible fade show" role="alert">
										  	<strong>Více údajů!</strong> Zákazník s touto e-mailovou adresou (<?php echo $email; ?>) při objednání vypnil odlišné fakturační údaje. Upravte je tak, aby byly totožné.
										  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										    	<span aria-hidden="true">&times;</span>
										  	</button>
										</div>
										<?php
					            	} elseif (count($customerBillingArray) == 0) {
					            		?>
					            		<div class="alert alert-danger alert-dismissible fade show" role="alert">
										  	<strong>Žádné údaje!</strong> Zákazník s touto e-mailovou adresou (<?php echo $email; ?>) nemá přiřazené žádné fakturační údaje. Doplňte je.
										  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										    	<span aria-hidden="true">&times;</span>
										  	</button>
										</div>
										<?php
					            	}
					            	?>
					            	<div class="form-row mb-4" style="margin-top: 2%;">
					            	<?php
					            	$id = 1;
					            	foreach ($customerBillingArray as $billingRow) {
					            		?>
									    <div class="col">
									    	<h5 class="h4-responsive"><?php echo $id; ?>. verze adresy</h5>
							            	<div class="md-form md-outline">
											  	<input name="billingCountry[]" type="text" id="billingCountry" class="form-control unsaved" value="<?php echo $billingRow['billing_country']; ?>" required>
											  	<label for="billingCountry">Země</label>
											</div>
											<div class="md-form md-outline">
											  	<input name="billingCity[]" type="text" id="billingCity" class="form-control unsaved" value="<?php echo $billingRow['billing_city']; ?>" required>
											  	<label for="billingCity">Město</label>
											</div>
											<div class="md-form md-outline">
											  	<input name="billingZip[]" type="text" id="billingZip" class="form-control unsaved" value="<?php echo $billingRow['billing_zip']; ?>" required>
											  	<label for="billingZip">PSČ</label>
											</div>
											<div class="md-form md-outline">
											  	<input name="billingStreet[]" type="text" id="billingStreet" class="form-control unsaved" value="<?php echo $billingRow['billing_street']; ?>" required>
											  	<label for="billingStreet">Ulice</label>
											</div>
											<div class="md-form md-outline">
											  	<input name="billingDescNumber[]" type="text" id="billingDescNumber" class="form-control unsaved" value="<?php echo $billingRow['billing_descNumber']; ?>" required>
											  	<label for="billingDescNumber">Číslo popisné</label>
											</div>
						            	</div>
						            	<input type="hidden" name="billingIds[]" value="<?php echo $billingRow['billing_id']; ?>">
					            		<?php
					            		$id++;
					            	}
					            	?>
					            	</div>
					            	<hr>

					            	<h3 class="h4-responsive">Doručovací adresa</h3>
					            	<?php
									if (count($customerShippingArray) > 1) {
					            		?>
					            		<div class="alert alert-danger alert-dismissible fade show" role="alert">
										  	<strong>Více údajů!</strong> Zákazník s touto e-mailovou adresou (<?php echo $email; ?>) při objednání vypnil odlišné dodací údaje. Upravte je tak, aby byly totožné.
										  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										    	<span aria-hidden="true">&times;</span>
										  	</button>
										</div>
										<?php
					            	} elseif (count($customerShippingArray) == 0) {
					            		?>
					            		<div class="alert alert-danger alert-dismissible fade show" role="alert">
										  	<strong>Žádné údaje!</strong> Zákazník s touto e-mailovou adresou (<?php echo $email; ?>) nemá přiřazené žádné dodací údaje. Doplňte je.
										  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										    	<span aria-hidden="true">&times;</span>
										  	</button>
										</div>
										<?php
					            	}
					            	?>
					            	<div class="form-row mb-4" style="margin-top: 2%;">
					            	<?php
					            	$id = 1;
					            	foreach ($customerShippingArray as $shippingRow) {
					            		?>
									    <div class="col">
									    	<h5 class="h4-responsive"><?php echo $id; ?>. verze adresy</h5>
							            	<div class="md-form md-outline">
											  	<input name="shippingCountry[]" type="text" id="shippingCountry" class="form-control unsaved" value="<?php echo $shippingRow['shipping_country']; ?>" required>
											  	<label for="shippingCountry">Země</label>
											</div>
											<div class="md-form md-outline">
											  	<input name="shippingCity[]" type="text" id="shippingCity" class="form-control unsaved" value="<?php echo $shippingRow['shipping_city']; ?>" required>
											  	<label for="shippingCity">Město</label>
											</div>
											<div class="md-form md-outline">
											  	<input name="shippingZip[]" type="text" id="shippingZip" class="form-control unsaved" value="<?php echo $shippingRow['shipping_zip']; ?>" required>
											  	<label for="shippingZip">PSČ</label>
											</div>
											<div class="md-form md-outline">
											  	<input name="shippingStreet[]" type="text" id="shippingStreet" class="form-control unsaved" value="<?php echo $shippingRow['shipping_street']; ?>" required>
											  	<label for="shippingStreet">Ulice</label>
											</div>
											<div class="md-form md-outline">
											  	<input name="shippingDescNumber[]" type="text" id="shippingDescNumber" class="form-control unsaved" value="<?php echo $shippingRow['shipping_descNumber']; ?>" required>
											  	<label for="shippingDescNumber">Číslo popisné</label>
											</div>
						            	</div>
						            	<input type="hidden" name="shippingIds[]" value="<?php echo $shippingRow['shipping_id']; ?>">
					            		<?php
					            		$id++;
					            	}
					            	?>
					            	</div>
				            	</div>
					        </div>
				            <div class="tab-pane fade" id="pills-objednavky" role="tabpanel" aria-labelledby="pills-objednavky-tab">
								<div class="card-header text-center">
					              	Objednávky zákazníka
					            </div>
					            <?php
					            if (empty($customerOrdersArray)) {
					            	?>
				            		<div class="alert alert-danger alert-dismissible fade show" role="alert">
									  	<strong>Žádné objednávky!</strong> Zákazník s touto e-mailovou adresou (<?php echo $email; ?>) nevytvořil zatím žádnou objednávku.
									  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									    	<span aria-hidden="true">&times;</span>
									  	</button>
									</div>
									<?php
					            }
					            ?>
					            <div class="card-body text-left">
					            	<table id="dtBasicExample" class="table table-hover table-bordered table-sm" cellspacing="0" width="100%">
					                	<thead class="blue lighten-4">
					                  		<tr>
					                    		<th class="th-sm">Kód objednávky</th>
					                    		<th class="th-sm">Datum objednávky</th>
					                    		<th class="th-sm">Celková cena</th>
					                    		<th class="th-sm">Stav objednávky</th>
					                  		</tr>
					                	</thead>
						  				<tbody>
					                  		<?php
					                  		foreach ($customerOrdersArray as $ordersRow) {
					                  			?>
					                  			<tr>
					                  				<td><a href="detail-objednavky.php?id=<?php echo $ordersRow['order_id']; ?>"><?php echo $ordersRow['order_code']; ?></a></td>
					                  				<td><a href="detail-objednavky.php?id=<?php echo $ordersRow['order_id']; ?>"><?php echo date("d.m.Y H:i:s", strtotime($ordersRow['order_date'])); ?></a></td>
					                  				<td><?php echo $ordersRow['payment_amount']; ?> Kč</td>
					                  				<td><?php echo $ordersRow['condition_condition']; ?></td>
					                  			</tr>
					                  			<?php
					                  		}
					                  		?>
					                  	</tbody>
					              	</table>
				            	</div>
				            	<div class="card-foot text-center m-3">
				            		
				            	</div>
				            </div>
				            <div class="tab-pane fade" id="pills-hodnoceni" role="tabpanel" aria-labelledby="pills-hodnoceni-tab">
				            	<div class="card-header text-center">
					              	Hodnocení zákazníka
					            </div>
					            <div class="card-body text-left">
					            	<div class="row wow fadeIn">
					            		<div class="col" style="padding-right: 3%;">
					            			<table class="table">
					            				<thead>
					            					<tr>
					            						<th style="width: 80%;">Informace</th>
					            						<th style="width: 20%;"></th>
					            					</tr>
					            				</thead>
					            				<tbody>
					            					<tr>
						            					<td>
						            						Počet nákupů
						            					</td>
						            					<td>
						            						<?php echo $celkemCount; ?>
						            					</td>
					            					</tr>
					            					<tr>
						            					<td>
						            						Celková útrata
						            					</td>
						            					<td>
						            						<?php 
						            						echo $utrataSum['suma'];
						            						?> Kč
						            					</td>
					            					</tr>
					            					<tr>
						            					<td>
						            						Počet storno objednávek
						            					</td>
						            					<td>
						            						<?php echo $stornovanoCount; ?>
						            					</td>
					            					</tr>
					            					<tr>
						            					<td>
						            						% stornovaných objednávek
						            					</td>
						            					<td>
						            						<?php echo ($stornovanoCount/$celkemCount)*100; ?> %
						            					</td>
					            					</tr>
					            					<tr>
						            					<td>
						            						Počet vyřízených objednávek
						            					</td>
						            					<td>
						            						<?php echo $vyrizenoCount; ?>
						            					</td>
					            					</tr>
					            				</tbody>
					            			</table>
					            			<table class="table">
					            				<thead>
					            					<tr>
					            						<th style="width: 80%;">Hodnocení</th>
					            						<th style="width: 20%;"></th>
					            					</tr>
					            				</thead>
					            				<tbody>
					            					<tr>
							            				<?php
									            		if ($celkemCount < $ratingSettings[0]['rating_number']) {
									            			?>
															<td>
																Neutrální
															</td>
															<td>
																<i class="far fa-meh" style="font-size: 26px;font-weight: 100;"></i>
															</td>
									            			<?php
									            		} elseif ($stornovanoCount > $ratingSettings[0]['rating_storno'] && (($stornovanoCount/$celkemCount)*100) >= $ratingSettings[0]['rating_storno_percentual']) {
									            			?>
									            			<td>
																Záporné
															</td>
															<td>
																<i class="far fa-frown" style="font-size: 26px;font-weight: 100;"></i>
															</td>
									            			<?php
									            		} elseif ($vyrizenoCount > $ratingSettings[0]['rating_purchase'] && $utrataSum['suma'] > $ratingSettings[0]['rating_spending']) {
									            			?>
									            			<td>
																Pozitivní
															</td>
															<td>
																<i class="far fa-smile" style="font-size: 26px;font-weight: 100;"></i>
															</td>
									            			<?php
									            		} else {
									            			?>
															<td>
																Neutrální
															</td>
															<td>
																<i class="far fa-meh" style="font-size: 26px;font-weight: 100;"></i>
															</td>
									            			<?php
									            		}
									            		?>	
					            					</tr>
					            				</tbody>
					            			</table>	
					            		</div>
					            		<div class="col" style="padding-left: 3%;">
					            			<table class="table">
					            				<thead>
					            					<tr>
					            						<th>Poznámky</th>
					            					</tr>
					            				</thead>
					            				<tbody>
					            					<tr>
					            						<td>
					            							<textarea name="customerNote" class="form-control unsaved" id="customerNote" rows="4"><?php
					            								echo trim($customerOrdersArray[0]['customer_admin_notes']);
					            								?></textarea>
					            						</td>
					            					</tr>
					            				</tbody>
					            			</table>	
					            		</div>
					            	</div>
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