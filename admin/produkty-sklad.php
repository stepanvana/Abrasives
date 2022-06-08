<?php

include '../admin/class_autoload.php';

if (isset($_SESSION['userId'])) {

	$productsObj = new admin\products\ProductsView();
	$productsContrObj = new admin\products\ProductsContr();
	$productsArray = $productsObj->showProducts();

	if (isset($_POST['saveProductsStorage'])) {
		$productsContrObj->saveProductsStorage($_POST['ids'], $_POST['productStorage'], $_POST['minusovyProduktu'], $_POST['dostupnostProduktu']);
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
				            <a href="novy-produkt.php">
				                <button type="button" class="btn btn-outline-info btn-md waves-effect">Nový produkt</button>
				            </a>
			            </li>
			            <li class="nav-item">
			              	<button id="save" type="submit" name="saveProductsStorage" class="btn btn-outline-success btn-md waves-effect">Uložit</button>
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
				<?php
				if (isset($_GET['error']) && $_GET['error'] == 'get_products') {
					?>
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
					  	<strong>Nepovedlo se získat data!</strong> Pokud problém setrvává kontaktujte správce webu.
					  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    	<span aria-hidden="true">&times;</span>
					  	</button>
					</div>
					<?php
				} elseif (isset($_GET['error']) && $_GET['error'] == 'set_product') {
					?>
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
					  	<strong>Nepovedlo se upravit produkt!</strong> Zkontrolujte, zda byly zadány správné data, pokud problém setrvává kontaktujte správce webu.
					  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    	<span aria-hidden="true">&times;</span>
					  	</button>
					</div>
					<?php
				} elseif (isset($_GET['success'])) {
					?>
					<div class="alert alert-success alert-dismissible fade show" role="alert">
					  	<strong>Produkty byly úspěšně upraveny!</strong>
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
			              	Produkty
			            </div>
			            <div class="card-body">
			            	<div class="tab-content" id="pills-tabContent">
			            		<div class="tab-pane fade show active" id="pills-vse">
			            			<table id="dtBasicExample" class="table table-hover table-bordered table-sm" cellspacing="0" width="100%">
					                	<thead class="blue lighten-4">
					                  		<tr>
					                    		<th class="th-sm">Kód produktu</th>
					                    		<th class="th-sm">Název</th>
					                    		<th class="th-sm">Kategorie</th>
					                    		<th class="th-sm">Podkategorie</th>
					                    		<th class="th-sm">Sklad</th>
					                    		<th class="th-sm">Nákup do mínusu</th>
					                    		<th class="th-sm">Dostupnost při vyprodání</th>
					                  		</tr>
					                	</thead>
						  				<tbody>
					                  		<?php
					                  		if (empty($productsArray)) {
					                  			?>
												<div class="alert alert-danger alert-dismissible fade show" role="alert">
												  	<strong>Žádné data ve výběru!</strong> Ve zvoleném rozsahu dat se nenachází žádné produkty.
												  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
												    	<span aria-hidden="true">&times;</span>
												  	</button>
												</div>
												<?php
					                  		} else {
						                  		foreach ($productsArray as $row) {
						                  			?>
						                  			<tr>
						                  				<td><a href="detail-produktu.php?id=<?php echo $row['product_id']; ?>"><?php echo $row['product_code']; ?></a></td>
						                  				<td><a href="detail-produktu.php?id=<?php echo $row['product_id']; ?>"><?php echo $row['product_name']; ?></a></td>
						                  				<td><?php echo $row['category_name']; ?></td>
						                  				<td><?php echo $row['sub_categories_name']; ?></td>
						                  				<td>
						                  					<div class="md-form form-sm" style="margin: 0;padding: 0;">
															  	<input name="productStorage[]" type="text" id="productStorage" class="form-control form-control-sm unsaved" value="<?php echo $row['product_storage']; ?>" required>
															</div>
														</td>
						                  				<td>
						                  					<select class="custom-select custom-select-md mt-3 unsaved" name="minusovyProduktu[]" style="margin-top: 0!important;border: none;border-bottom: 1px solid #ced4da;border-radius: 0px;">
																<option value=1 <?php if($row['product_minus_shopping']==1) echo "selected"; ?>>Ano</option>
																<option value=2 <?php if($row['product_minus_shopping']==2) echo "selected"; ?>>Ne</option>
															</select>
														</td>
														<td>
						                  					<select class="custom-select custom-select-md mt-3 unsaved" name="dostupnostProduktu[]" style="margin-top: 0!important;border: none;border-bottom: 1px solid #ced4da;border-radius: 0px;">
																<option value=1 <?php if($row['product_availibility']==1) echo "selected"; ?>>Skladem</option>
																<option value=2 <?php if($row['product_availibility']==2) echo "selected"; ?>>Vyprodáno</option>
																<option value=3 <?php if($row['product_availibility']==3) echo "selected"; ?>>Momentálně nedostupné</option>
																<option value=4 <?php if($row['product_availibility']==4) echo "selected"; ?>>Objednáno</option>
																<option value=5 <?php if($row['product_availibility']==5) echo "selected"; ?>>Na dotaz</option>
															</select>
														</td>
														<input type="hidden" name="ids[]" value="<?php echo $row['product_id']; ?>">
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

