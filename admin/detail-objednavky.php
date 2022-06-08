<?php

include '../admin/class_autoload.php';

if (isset($_SESSION['userId'])) {

	$id = $_GET['id'];

	$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

	$ordersDetailObj = new admin\orders\OrdersView();
	$ordersDetailSaveObj = new admin\orders\OrdersContr();
	$productsObj = new admin\products\ProductsView();

	$row = $ordersDetailObj->showOrderDetail($id);
	if (empty($row)) {
		header("?error=not_existing_order");
	}
	$rowOrderProducts = $ordersDetailObj->showOrderProducts($id);
	$usedIds = array_column($rowOrderProducts, 'product_id');
	if (empty($usedIds)) {
		$usedIds = NULL;
	}
	$rowProducts = $productsObj->showProducts($usedIds);
	$rowComments = $ordersDetailObj->showComments($id);

	if (isset($_POST['saveOrder'])) {

		if ($ordersDetailSaveObj->saveOrderDetails($id, $_POST['customerName'], $_POST['customerSirname'], $_POST['customerCompany'], $_POST['orderDate'], $_POST['orderCode'], $_POST['customerEmail'], $_POST['customerPhone'], $_POST['billingCountry'], $_POST['billingCity'], $_POST['billingStreet'], $_POST['billingDescNumber'], $_POST['billingZip'], $_POST['shippingCountry'], $_POST['shippingCity'], $_POST['shippingStreet'], $_POST['shippingDescNumber'], $_POST['shippingZip'], $_POST['orderCondition'], $_POST['orderShipping'], $_POST['paymentMethod'], $_POST['paymentStatus'], $_POST['productQuantity'], $_POST['completedQuantity'], $_POST['productIds']) == true) {
			$newProductAmount = array_values(array_filter($_POST['newProductAmount']));
			if ($ordersDetailSaveObj->addOrderProducts($id, $_POST['newProduct'], $newProductAmount) == true) {
				if ($ordersDetailSaveObj->addComments($id, $_POST['commentField']) == true) {
					header("Location: ?id=" . $id . "&success");
				} else {
					header("Location: ?id=" . $id . "&error=order_edit");
				}
			} else {
				header("Location: ?id=" . $id . "&error=order_edit");
			}
		} else {
			header("Location: ?id=" . $id . "&error=order_edit1");
		}
	}

	if (isset($_POST['deleteOrder'])) {
		if ($ordersDetailSaveObj->deleteOrder($id) == true) {
			header("Location: objednavky.php?orderDelete=success");
		} else {
			header("Location: ?id=" . $id . "&error=order_edit");
		}
	}

	if (isset($_POST['copyOrder'])) {
		$ordersDetailSaveObj->duplicateOrder($id);
	}

	if (isset($_POST['deleteProducts'])) {
		if ($ordersDetailSaveObj->deleteProducts($id, $_POST['checkbox']) == true) {
			header("Location: ?id=" . $id . "&success");
		} else {
			header("Location: ?id=" . $id . "&error=order_edit");
		}
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
			              	<button id="save" type="submit" name="saveOrder" class="btn btn-outline-success btn-md waves-effect">Uložit</button>
			            </li>
			            <li class="nav-item">
			              	<button type="submit" name="deleteOrder" class="btn btn-outline-danger btn-md waves-effect" onclick="return confirm('Opravdu si přejete objednávku odstranit?')">Smazat</button>
			            </li>
			            <li class="nav-item">
			              	<button type="submit" name="copyOrder" class="btn btn-outline-info btn-md waves-effect">Kopie</button>
			            </li>
			            <li class="nav-item">
							<div class="btn-group">
							  <button type="button" class="btn btn-outline-info btn-md dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							    Výběr
							  </button>
							  <div class="dropdown-menu dropdown-menu-right">
							    <button class="dropdown-item" type="submit" name="deleteProducts" onclick="return confirm('Opravdu si přejete produkty objednávky odstranit?')">Odstranit</button>
							    <!-- <button class="dropdown-item" type="submit" name="notPaidOrder">Nezaplaceno</button>
							    <button class="dropdown-item" type="submit" name="createPdfOrder">Vytvořit PDF</button>
							    <button class="dropdown-item" type="submit" name="exportOrder">Export</button>
							    <button class="dropdown-item" type="submit" name="deleteOrder">Odstranit</button> -->
							  </div>
							</div>
			            </li>
			            <li class="nav-item">
				            <a href="user.php">
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
				<div class="col-md-12 mb-4">
					<?php
					if (isset($_GET['error']) && $_GET['error'] == 'order_edit') {
						?>
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
						  	<strong>Objednávka se nepodařila upravit!</strong> Zkontrolujte, zda byly zadány správné data, pokud problém setrvává kontaktujte správce webu.
						  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						    	<span aria-hidden="true">&times;</span>
						  	</button>
						</div>
						<?php
					} elseif (isset($_GET['error']) && $_GET['error'] == 'get_order_data') {
						?>
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
						  	<strong>Nepovedlo se získat data!</strong> Pokud problém setrvává kontaktujte správce webu.
						  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						    	<span aria-hidden="true">&times;</span>
						  	</button>
						</div>
						<?php
					} elseif (isset($_GET['error']) && $_GET['error'] == 'get_products') {
						?>
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
						  	<strong>Nepovedlo se získat data!</strong> Pokud problém setrvává kontaktujte správce webu.
						  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						    	<span aria-hidden="true">&times;</span>
						  	</button>
						</div>
						<?php
					} elseif (isset($_GET['success'])) {
						?>
						<div class="alert alert-success alert-dismissible fade show" role="alert">
						  	<strong>Objednávka byla upravena!</strong>
						  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						    	<span aria-hidden="true">&times;</span>
						  	</button>
						</div>
						<?php
					}
					?>
				</div>
				<div class="col-md-8">
					<div class="card mb-4">
						<div class="card-header text-center">
			              	Osobní údaje
			            </div>
			            <div class="card-body text-center">
			            	<table class="table">
			                	<thead class="blue lighten-4">
			                  		<tr>
			                    		<th>#</th>
			                    		<th>Kontakt</th>
			                    		<th>Fakturační adresa</th>
			                    		<th>Dodací adresa</th>
			                  		</tr>
			                	</thead>
				  				<tbody>
				  					<tr>
				  						<td>
				  							<div class="md-form">
											  	<input name="customerName" type="text" id="customerName" class="form-control unsaved" value="<?php echo $row['customer_name']; ?>">
											  	<label for="customerName">Jméno</label>
											</div>
											<div class="md-form">
											  	<input name="customerSirname" type="text" id="customerSirname" class="form-control unsaved" value="<?php echo $row['customer_sirname']; ?>">
											  	<label for="customerSirname">Přijmení</label>
											</div>
											<div class="md-form">
											  	<input name="customerCompany" type="text" id="customerCompany" class="form-control unsaved" value="<?php echo $row['customer_sirname']; ?>">
											  	<label for="customerCompany">Firma</label>
											</div>
											<div class="md-form">
											  	<input name="orderDate" type="date" id="orderDate" class="form-control unsaved" value="<?php echo date('Y-m-d', strtotime($row['order_date'])); ?>" style="margin: 0;padding: 0;">
											  	<label for="orderDate" style="margin-top: 10px;padding: 0;">Datum</label>
											</div>
											<div class="md-form">
											  	<input name="orderCode" type="text" id="orderCode" class="form-control unsaved" value="<?php echo $row['order_code']; ?>">
											  	<label for="orderCode">Kód</label>
											</div>
				  						</td>
				  						<td>
				  							<div class="md-form">
											  	<input name="customerEmail" type="text" id="customerEmail" class="form-control unsaved" value="<?php echo $row['customer_email']; ?>">
											  	<label for="customerEmail">E-mail</label>
											</div>
											<div class="md-form">
											  	<input name="customerPhone" type="text" id="customerPhone" class="form-control unsaved" value="<?php echo $row['customer_phone']; ?>">
											  	<label for="customerPhone">Telefon</label>
											</div>
				  						</td>
				  						<td>
				  							<div class="md-form">
											  	<input name="billingCountry" type="text" id="billingCountry" class="form-control unsaved" value="<?php echo $row['billing_country']; ?>">
											  	<label for="billingCountry">Země</label>
											</div>
				  							<div class="md-form">
											  	<input name="billingCity" type="text" id="billingCity" class="form-control unsaved" value="<?php echo $row['billing_city']; ?>">
											  	<label for="billingCity">Město</label>
											</div>
											<div class="md-form">
											  	<input name="billingStreet" type="text" id="billingStreet" class="form-control unsaved" value="<?php echo $row['billing_street']; ?>">
											  	<label for="billingStreet">Ulice</label>
											</div>
											<div class="md-form">
											  	<input name="billingDescNumber" type="text" id="billingDescNumber" class="form-control unsaved" value="<?php echo $row['billing_descNumber']; ?>">
											  	<label for="billingDescNumber">Číslo popisné</label>
											</div>
											<div class="md-form">
											  	<input name="billingZip" type="text" id="billingZip" class="form-control unsaved" value="<?php echo $row['billing_zip']; ?>">
											  	<label for="billingZip">PSČ</label>
											</div>
				  						</td>
				  						<td>
				  							<div class="md-form">
											  	<input name="shippingCountry" type="text" id="shippingCountry" class="form-control unsaved" value="<?php echo $row['shipping_country']; ?>">
											  	<label for="shippingCountry">Země</label>
											</div>
				  							<div class="md-form">
											  	<input name="shippingCity" type="text" id="shippingCity" class="form-control unsaved" value="<?php echo $row['shipping_city']; ?>">
											  	<label for="shippingCity">Město</label>
											</div>
											<div class="md-form">
											  	<input name="shippingStreet" type="text" id="shippingStreet" class="form-control unsaved" value="<?php echo $row['shipping_street']; ?>">
											  	<label for="shippingStreet">Ulice</label>
											</div>
											<div class="md-form">
											  	<input name="shippingDescNumber" type="text" id="shippingDescNumber" class="form-control unsaved" value="<?php echo $row['shipping_descNumber']; ?>">
											  	<label for="shippingDescNumber">Číslo popisné</label>
											</div>
											<div class="md-form">
											  	<input name="shippingZip" type="text" id="shippingZip" class="form-control unsaved" value="<?php echo $row['shipping_zip']; ?>">
											  	<label for="shippingZip">PSČ</label>
											</div>
				  						</td>
				  					</tr>
				  				</tbody>
				  			</table>
			            </div>
			        </div>
			    </div>

			    <div class="col-md-4">
					<div class="card mb-4">
						<div class="card-header text-center">
			              	Informace o objednávce
			            </div>
			            <div class="card-body text-center">
			            	<table>
				  				<tbody>
				  					<tr>
				  						<td>
				  							<label class="mdb-main-label" for="RoleID">Stav objednávky</label>
				  							<select class="custom-select custom-select-sm unsaved" name="orderCondition" style="border: none;border-bottom: 1px solid #ced4da;border-radius: 0px">
												<option value=1 <?php if($row['condition_condition']=='Nevyřízeno') echo "selected"; ?>>Nevyřízeno</option>
												<option value=2 <?php if($row['condition_condition']=='Vyřizuje se') echo "selected"; ?>>Vyřizuje se</option>
												<option value=3 <?php if($row['condition_condition']=='Vyřízeno') echo "selected"; ?>>Vyřízeno</option>
												<option value=4 <?php if($row['condition_condition']=='Odesláno') echo "selected"; ?>>Odesláno</option>
												<option value=5 <?php if($row['condition_condition']=='Stornováno') echo "selected"; ?>>Stornováno</option>
											</select>
											<label class="mdb-main-label" for="RoleID" style="margin-top: 15px;">Způsob dopravy</label>
											<select class="custom-select custom-select-sm unsaved" name="orderShipping" style="border: none;border-bottom: 1px solid #ced4da;border-radius: 0px">
												<option value=1 <?php if($row['shipping_method']=='PPL') echo "selected"; ?>>PPL</option>
												<option value=2 <?php if($row['shipping_method']=='DPD') echo "selected"; ?>>DPD</option>
												<option value=3 <?php if($row['shipping_method']=='Česká pošta') echo "selected"; ?>>Česká pošta</option>
											</select>
											<label class="mdb-main-label" for="RoleID" style="margin-top: 15px;">Způsob platby</label>
											<select class="custom-select custom-select-sm unsaved" name="paymentMethod" style="border: none;border-bottom: 1px solid #ced4da;border-radius: 0px">
												<option value=1 <?php if($row['paymentMethod_method']=='Kreditní karta') echo "selected"; ?>>Kreditní karta</option>
												<option value=2 <?php if($row['paymentMethod_method']=='Bankovní převod') echo "selected"; ?>>Bankovní převod</option>
												<option value=3 <?php if($row['paymentMethod_method']=='GoPay') echo "selected"; ?>>GoPay</option>
											</select>
											<label class="mdb-main-label" for="RoleID" style="margin-top: 15px;">Stav platby</label>
											<select class="custom-select custom-select-sm unsaved" name="paymentStatus" style="border: none;border-bottom: 1px solid #ced4da;border-radius: 0px;">
												<option value=1 <?php if($row['paymentStatus_status']=='Zaplaceno') echo "selected"; ?>>Zaplaceno</option>
												<option value=2 <?php if($row['paymentStatus_status']=='Nezaplaceno') echo "selected"; ?>>Nezaplaceno</option>
											</select>
				  						</td>
				  					</tr>
				  				</tbody>
				  			</table>
			            </div>
			        </div>
			    </div>
			</div>

			<div class="row wow fadeIn">
				<div class="col-md-12">
					<div class="card mb-4">
			            <div class="card-body text-center">
						    <ul class="nav nav-pills nav-fill" id="pills-tab" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Položky objednávky</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Kompletace položek</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Přidat položku</a>
								</li>
							</ul>
						</div>
			            <div class="card-body">
			            	<div class="tab-content pt-2 pl-1" id="pills-tabContent">
							  	<div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
							  		<table class="table">
					                	<thead class="blue lighten-4">
					                  		<tr>
					                    		<th>#</th>
					                    		<th>KÓD</th>
					                    		<th>NÁZEV</th>
					                    		<th>KATEGORIE</th>
					                    		<th>PODKATEGORIE</th>
					                    		<th>OBJEDNANÉ MNOŽSTVÍ</th>
					                    		<th>SKLADEM</th>
					                    		<th>CENA ZA KUS	</th>
					                    		<th>SLEVA</th>
					                    		<th>CENA</th>
					                  		</tr>
					                	</thead>
						  				<tbody>
						  					<?php
					                  		foreach ($rowOrderProducts as $rowProduct) {
					                  			?>
						                  		<tr>
							  						<td>
							  							<div class="custom-control custom-checkbox">
														    <input name='checkbox[]' type="checkbox" class="custom-control-input" id="defaultUnchecked<?php echo $rowProduct['product_id'] ?>" value="<?php echo $rowProduct['product_id'] ?>">
														    <label class="custom-control-label" for="defaultUnchecked<?php echo $rowProduct['product_id'] ?>"></label>
														</div>
							  						</td>
							  						<td>
							  							<?php echo $rowProduct['product_code']; ?>
							  						</td>
							  						<td>
							  							<?php echo $rowProduct['product_name']; ?>
							  						</td>
							  						<td>
							  							<?php echo $rowProduct['category_name']; ?>
							  						</td>
							  						<td>
							  							<?php echo $rowProduct['sub_categories_name']; ?>
							  						</td>
							  						<td>
														<div class="md-form form-sm" style="margin: 0;padding: 0;width: 60%;">
														  	<input name="productQuantity[]" type="text" id="inputSMEx" class="form-control form-control-sm unsaved" value="<?php echo $rowProduct['quantity']; ?>">
														</div>
							  						</td>
							  						<td>
							  							<?php echo $rowProduct['product_storage']; ?> kusů
							  						</td>
							  						<td>
							  							<?php echo $rowProduct['price']; ?> Kč
							  						</td>
							  						<td>
							  							<?php echo $rowProduct['discount']; ?> %
							  						</td>
							  						<td>
							  							<?php echo $rowProduct['quantity']*$rowProduct['price']; ?> Kč
							  						</td>
							  					</tr>
							  					<input type="hidden" name="productIds[]" value="<?php echo $rowProduct['product_id'] ?>">
					                  			<?php
					                  		}
					                  		?>
						  				</tbody>
						  			</table>
							  	</div>
							  	<div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
							  		<table class="table">
					                	<thead class="blue lighten-4">
					                  		<tr>
					                    		<th class="th-sm">KÓD</th>
					                    		<th class="th-sm">NÁZEV</th>
					                    		<th class="th-sm">KATEGORIE</th>
					                    		<th class="th-sm">PODKATEGORIE</th>
					                    		<th class="th-sm">Přidat množství</th>
					                    		<th class="th-sm">Zkompletované množství</th>
					                    		<th class="th-sm">SKLADEM</th>
					                  		</tr>
					                	</thead>
						  				<tbody>
						  					<?php
					                  		foreach ($rowOrderProducts as $rowCompleted) { 
					                  			?>
						                  		<tr>
							  						<td>
							  							<?php echo $rowCompleted['product_code']; ?>
							  						</td>
							  						<td>
							  							<?php echo $rowCompleted['product_name']; ?>
							  						</td>
							  						<td>
							  							<?php echo $rowCompleted['category_name']; ?>
							  						</td>
													<td>
							  							<?php echo $rowCompleted['sub_categories_name']; ?>
							  						</td>
							  						<td>
														<div class="def-number-input number-input safari_only" style="padding: 0;margin: 0 auto;">
														  	<button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()" class="minus"></button>
														  	<input class="quantity unsaved" min="-<?php echo $rowCompleted['completed']; ?>" max="<?php echo $rowCompleted['quantity']-$rowCompleted['completed']; ?>" name="completedQuantity[]" value="0" type="number">
														  	<button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepUp()" class="plus"></button>
														</div>
							  						</td>
							  						<td>
							  							<?php echo $rowCompleted['completed']; ?> z <?php echo $rowCompleted['quantity']; ?> kusů
							  						</td>
							  						<td>
							  							<?php echo $rowCompleted['product_storage']; ?> kusů
							  						</td>
							  					</tr>
					                  			<?php
					                  		}
					                  		?>
						  				</tbody>
						  			</table>
							  	</div>
							  	<div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
							  		<table id="dtBasicExample" class="table table-hover table-bordered table-sm" cellspacing="0" width="100%">
					                	<thead class="blue lighten-4">
					                  		<tr>
					                    		<th class="th-sm">#</th>
					                    		<th class="th-sm">Kód</th>
					                    		<th class="th-sm">Název</th>
					                    		<th class="th-sm">Cena</th>
					                    		<th class="th-sm">Kategorie</th>
					                    		<th class="th-sm">Podkategorie</th>
					                    		<th class="th-sm">Kusů</th>
					                  		</tr>
					                	</thead>
						  				<tbody>
						  					<?php
						  					foreach ($rowProducts as $productsRow) {
						  						?>
						  						<tr>
					                  				<th scope="row">
														<div class="custom-control custom-checkbox">
														    <input name='newProduct[]' type="checkbox" class="custom-control-input" id="defaultUnchecked<?php echo $productsRow['product_id']; ?>" value="<?php echo $productsRow['product_id']; ?>">
														    <label class="custom-control-label" for="defaultUnchecked<?php echo $productsRow['product_id']; ?>"></label>
														</div>
													</th>
					                  				<td>
					                  					<?php echo $productsRow['product_code']; ?>
					                  				</td>
					                  				<td>
					                  					<?php echo $productsRow['product_name']; ?>
					                  				</td>
					                  				<td>
					                  					<?php echo $productsRow['product_price']; ?> Kč
					                  				</td>
					                  				<td>
					                  					<?php echo $productsRow['category_name']; ?>
					                  				</td>
					                  				<td>
							  							<?php echo $productsRow['sub_categories_name']; ?>
							  						</td>
					                  				<td>
					                  					<div class="def-number-input number-input safari_only" style="padding: 0;margin: 0 auto;">
														  	<button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()" class="minus"></button>
														  	<input class="quantity unsaved" name="newProductAmount[]" min=0 value=0 type="number">
														  	<button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepUp()" class="plus"></button>
														</div>
					                  				</td>
					                  			</tr>
					                  			<?php
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

			<div class="row wow fadeIn">
				<div class="col-md-5">
					<div class="card mb-4">
			            <div class="card-header text-center">
			              	Přidat komentář
			            </div>
			            <div class="card-body">
						    <div class="form-group">
						        <textarea name="commentField[]" class="form-control rounded-0 unsaved" id="exampleFormControlTextarea2" rows="3" placeholder="Zpráva"></textarea>
						    </div>
						    <div id="anotherComment">
						        
						    </div>
						    <button class="btn btn-info btn-block" type="button" name="addComment">Další</button>
						    <script type="text/javascript">
						    	$(document).ready(function(){
						    		$("button[name='addComment']").click(function() {
						    			$("#anotherComment").append("<div class='form-group'><textarea name='commentField[]' class='form-control rounded-0 unsaved' id='exampleFormControlTextarea2' rows='3' placeholder='Zpráva'></textarea></div>");	
						    		})
								});
						    </script>
			            </div>
			        </div>
			    </div>
			    <div class="col-md-7">
					<div class="card mb-4">
			            <div class="card-header text-center">
			              	Komentáře
			            </div>
			            <div class="card-body">
			            	<?php
			            	foreach ($rowComments as $comment) {
			            		?>
								<div class="media mb-3">
									<img class="card-img-100 rounded-circle z-depth-1-half d-flex mr-3" src="https://mdbootstrap.com/img/Photos/Avatars/img (8).jpg" alt="Generic placeholder image">
									<div class="media-body">
										<a>
											<h5 class="user-name font-weight-bold"><?php echo $comment['user_name']; ?></h5>
										</a>
										<div class="card-data">
											<ul class="list-unstyled mb-1">
												<li class="comment-date font-small grey-text">
												<i class="far fa-clock"></i> <?php echo date('d-m-Y H:i:s', strtotime($comment['comment_date'])); ?></li>
											</ul>
										</div>
										<p class="dark-grey-text article"><?php echo $comment['comment_comment']; ?></p>
									</div>
							    </div>
							    <hr>
			            		<?php
			            	}
			            	?>
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