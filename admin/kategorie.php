<?php

include '../admin/class_autoload.php';

if (isset($_SESSION['userId'])) {

	$productsObj = new admin\products\ProductsView();
	$productsContrObj = new admin\products\ProductsContr();
	$rowCategories = $productsObj->showCategories();
	$rowSubCat = $productsObj->showSubCat();
	$rowParams = $productsObj->showParams();

	if (isset($_POST['addCategory'])) {
		$productsContrObj->addCategory($_POST['categoryName']);
	}

	if (isset($_POST['addSubCategory'])) {
		$productsContrObj->addSubCategory($_POST['categoryAssoc'], $_POST['subCategoryName']);
	}

	if (isset($_POST['addParam'])) {
		$productsContrObj->addParam($_POST['subCategoryAssoc'], $_POST['paramName']);
	}

	if (isset($_POST['changeName'])) {
		$productsContrObj->changeName($_POST['categoryEdit'], $_POST['categoryNewName']);
	}

	if (isset($_POST['deleteCat'])) {
		$productsContrObj->deleteCategory($_POST['deleteCat']);
	}

	if (isset($_POST['deleteSubCat'])) {
		$productsContrObj->deleteSubCategory($_POST['deleteSubCat']);
	}

	if (isset($_POST['deleteParam'])) {
		$productsContrObj->deleteParam($_POST['deleteParam']);
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
				            <li class="nav-item <?php if($page == 'nastaveni.php'){ echo 'active';}?>">
				              	<a class="nav-link waves-effect" href="nastaveni.php" target="_blank">Nastavení</a>
				            </li>
          				</div>
          			</ul>
		          	<!-- Right -->
		          	<ul class="navbar-nav nav-flex-icons">
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
					if (isset($_GET['error']) && $_GET['error'] == 'delete_cat') {
						?>
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
						  	<strong>Odstraňte všechny záznamy spojené s touto kategorií!</strong> Zvolená kategorie je obsažena k jiné kategorii/podkategorii nebo v jiném produktu, pro vyřešení problému tyto záznamy odstraňte a akci opakujte, pokud problém setrvává informujte správce webu.
						  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						    	<span aria-hidden="true">&times;</span>
						  	</button>
						</div>
						<?php
					} elseif (isset($_GET['error']) && $_GET['error'] == 'category') {
						?>
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
						  	<strong>Kategorie nemohla být vytvořena!</strong> Pokud problém setrvává informujte správce webu.
						  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						    	<span aria-hidden="true">&times;</span>
						  	</button>
						</div>
						<?php
					} elseif (isset($_GET['error']) && $_GET['error'] == 'set_name') {
						?>
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
						  	<strong>Jméno nemohlo být vytvořeno!</strong> Pokud problém setrvává informujte správce webu.
						  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						    	<span aria-hidden="true">&times;</span>
						  	</button>
						</div>
						<?php
					} elseif (isset($_GET['error']) && $_GET['error'] == 'get_category') {
						?>
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
						  	<strong>Nepodařilo se získat data!</strong> Pokud problém setrvává kontaktujte správce webu.
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
				<div class="col-6 col-md-6">
					<div class="card mb-4">
						<div class="card-header text-center">
							Kategorie
						</div>
			            <div class="card-body text-center">
			            	<div class="w-20 text-left p-5">
							  	<ul class="mb-3" style="list-style: none;">
					            	<?php
					            	if (empty($rowCategories) && empty($rowSubCat)) {
					            		?>
										<div class="alert alert-danger alert-dismissible fade show" role="alert">
										  	<strong>Žádné data ve výběru!</strong> Zatím nebyly vytvořeny žádné kategorie.
										  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										    	<span aria-hidden="true">&times;</span>
										  	</button>
										</div>
										<?php
					            	} else {
						            	foreach ($rowCategories as $row) {
						            		?>
											<li>
												<div class="category">
													<h5 style="margin-top: 20px;">
											        	<span><?php echo $row['category_name']; ?></span>
												        <button type="submit" name="deleteCat" class="categoryBtn red-text" style="background-color: transparent;border: none;outline: none;font-size: 12px;" value="<?php echo $row['category_id']; ?>" onclick="return confirm('Opravdu si přejete kategorii odstranit?')"><i class="fa fa-trash"></i></button>
												    </h5>
												</div>
										      	<ul style="list-style: none;padding-left: 30px;">
								            		<?php
								            		foreach ($rowSubCat as $subRow) {
								            			if ($subRow['sub_categories_category'] !== $row['category_id']) {
								            				continue;
								            			} else {
								            				?>
								            				<li>
								            					<div class="category">
													          		<i class="fas fa-level-up-alt fa-rotate-90 mr-3 grey-text"></i><?php echo $subRow['sub_categories_name']; ?>
													          		<button type="submit" name="deleteSubCat" class="categoryBtn red-text" style="background-color: transparent;border: none;outline: none;font-size: 12px;" value="<?php echo $subRow['sub_categories_id']; ?>" onclick="return confirm('Opravdu si přejete podkategorii odstranit?')"><i class="fa fa-trash"></i></button>
													          	</div>	
												          		<ul style="list-style: none;padding-left: 30px;">
												          			<?php
												          			foreach ($rowParams as $param) {
												          				if ($param['param_sub_cat'] !== $subRow['sub_categories_id']) {
												          					continue;
												          				} else {
												          					?>
												          					<li>
												          						<div class="category">
												          							<i class="fas fa-level-up-alt fa-rotate-90 mr-3 grey-text"></i><?php echo $param['param_name']; ?>
												          							<button type="submit" name="deleteParam" class="categoryBtn red-text" style="background-color: transparent;border: none;outline: none;font-size: 12px;" value="<?php echo $param['param_id']; ?>" onclick="return confirm('Opravdu si přejete podkategorii odstranit?')"><i class="fa fa-trash"></i></button>
												          						</div>
												          					</li>
												          					<?php
												          				}
												          			}
												          			?>
												          		</ul>
													        </li>
								            				<?php
								            			}
								            		}
								            		?>
												</ul>
											</li>
						            		<?php
						            	}	
					            	}
					            	?>
								</ul>
							</div>
			            </div>
					</div>
				</div>
				<div class="col-6 col-md-6">
					<div class="card mb-4">
						<div class="card-header text-center">
							Přidat kategorii
						</div>
			            <div class="card-body text-center">
			            	<div class="md-form">
								<input name="categoryName" type="text" id="categoryName" class="form-control">
								<label for="categoryName">Název kategorie</label>
							</div>
							<div class="text-center">
								<button type="submit" name="addCategory" class="btn btn-outline-info btn-md waves-effect">Přidat kategorii</button>
							</div>
			            </div>	
					</div>
					<div class="card mb-4">
						<div class="card-header text-center">
							Přidat podkategorii
						</div>
			            <div class="card-body text-center">
							<select class="custom-select custom-select-md mt-3" name="categoryAssoc" style="margin-top: 0!important;border: none;border-bottom: 1px solid #ced4da;border-radius: 0px;">
								<?php
				            	foreach ($rowCategories as $category) {
				            		?>
				            		<option value=<?php echo $category['category_id']; ?>><?php echo $category['category_name']; ?></option>
				            		<?php
				            	}
				            	?>
							</select>
							<div class="md-form">
								<input name="subCategoryName" type="text" id="subCategoryName" class="form-control">
								<label for="subCategoryName">Název podkategorie</label>
							</div>
							<div class="text-center">
								<button type="submit" name="addSubCategory" class="btn btn-outline-info btn-md waves-effect">Přidat podkategorii</button>
							</div>
			            </div>	
					</div>

					<div class="card mb-4">
						<div class="card-header text-center">
							Přidat parametr
						</div>
			            <div class="card-body text-center">
							<select class="custom-select custom-select-md mt-3" name="subCategoryAssoc" style="margin-top: 0!important;border: none;border-bottom: 1px solid #ced4da;border-radius: 0px;">
								<?php
				            	foreach ($rowSubCat as $subCat) {
				            		?>
				            		<option value=<?php echo $subCat['sub_categories_id']; ?>><?php echo $subCat['sub_categories_name']; ?></option>
				            		<?php
				            	}
				            	?>
							</select>
							<div class="md-form">
								<input name="paramName" type="text" id="paramName" class="form-control">
								<label for="paramName">Název parametru</label>
							</div>
							<div class="text-center">
								<button type="submit" name="addParam" class="btn btn-outline-info btn-md waves-effect">Přidat parametr</button>
							</div>
			            </div>	
					</div>

					<div class="card mb-4">
						<div class="card-header text-center">
							Změnit název
						</div>
			            <div class="card-body text-center">
							<select class="custom-select custom-select-md mt-3" name="categoryEdit" style="margin-top: 0!important;border: none;border-bottom: 1px solid #ced4da;border-radius: 0px;">
								<?php
				            	foreach ($rowCategories as $category) {
				            		?>
				            		<option value=cat_<?php echo $category['category_id']; ?>><?php echo $category['category_name']; ?></option>
				            		<?php
				            	}
				            	foreach ($rowSubCat as $subRow) {
				            		?>
				            		<option value=sub_<?php echo $subRow['sub_categories_id']; ?>><?php echo $subRow['sub_categories_name']; ?></option>
				            		<?php
				            	}
				            	foreach ($rowParams as $param) {
				            		?>
				            		<option value=par_<?php echo $param['param_id']; ?>><?php echo $param['param_name']; ?></option>
				            		<?php
				            	}
				            	?>
							</select>
							<div class="md-form">
								<input name="categoryNewName" type="text" id="categoryNewName" class="form-control">
								<label for="categoryNewName">Nový název kategorie</label>
							</div>
							<div class="text-center">
								<button type="submit" name="changeName" class="btn btn-outline-info btn-md waves-effect">Změnit název</button>
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