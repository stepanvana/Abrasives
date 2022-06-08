<?php

include '../admin/class_autoload.php';

if (isset($_SESSION['userId'])) {

	$productsObj = new admin\products\ProductsView();
	$productsSaveObj = new admin\products\ProductsContr();
	$rowProducts = $productsObj->showProducts();
	$rowCategories = $productsObj->showCategories();
	$rowSubCat = $productsObj->showSubCat();

	if (isset($_POST['newProduct'])) {
		if (!empty($_FILES["uploadImage"])) {
          	$fileArray = array();
          	for ($p=0; $p < count($_FILES["uploadImage"]["name"]); $p++) {
            	move_uploaded_file($_FILES["uploadImage"]["tmp_name"][$p],"../images/".$_FILES["uploadImage"]["name"][$p]);
            	$file=$_FILES["uploadImage"]["name"][$p];
            	array_push($fileArray, $file);
          	}
          	$filteredFotografie = implode(";", $fileArray);
          	$filteredFotografie = trim($filteredFotografie, ';');
        } else {
          	$filteredFotografie = "";
        }
        if (empty($_POST['slevaProduktu'])) {
        	$_POST['slevaProduktu'] = 0;
        }
		$productsSaveObj->newProduct($_POST['nazevProduktu'], $_POST['urlProduktu'], $_POST['kodProduktu'], $_POST['kratkyPopis'], $_POST['podrobnyPopis'], $_POST['podKategorieProdukt'], $_POST['param'], $_POST['paramValue'], $_POST['viditelnostProdukt'], $_POST['cenaProduktu'], $_POST['nakupniCenaProduktu'], $_POST['slevaProduktu'], $_POST['stavSkladuProduktu'], $_POST['dostupnostProduktu'], $_POST['minusovyProduktu'], $_POST['souvisejiciProdukt'], $filteredFotografie);
	}

	include '../admin/headerAdmin.php';

?>

<form enctype="multipart/form-data" name="changer" method="POST" action="" id="managerForm">
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
			              	<button id="save" type="submit" name="newProduct" class="btn btn-outline-success btn-md waves-effect">Uložit</button>
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
				<div class="col-md-12">
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
					} elseif (isset($_GET['error']) && $_GET['error'] == 'get_category') {
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
						  	<strong>Nepovedlo se přidat produkt!</strong> Zkontrolujte, zda byly zadány správné data, pokud problém setrvává kontaktujte správce webu.
						  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						    	<span aria-hidden="true">&times;</span>
						  	</button>
						</div>
						<?php
					} elseif (isset($_GET['error']) && $_GET['error'] == 'not_existing_product') {
						?>
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
						  	<strong>Zvolený produkt neexistuje!</strong> Zde ho můžete vytvořit.
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
				</div>
				<div class="col-md-12">
					<div class="card mb-4">
						<div class="card-body text-center">
						    <ul class="nav nav-pills nav-fill" id="pills-tab" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" id="pills-main-tab" data-toggle="pill" href="#pills-main" role="tab" aria-controls="pills-main" aria-selected="true">Hlavní údaje</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="pills-kategorie-tab" data-toggle="pill" href="#pills-kategorie" role="tab" aria-controls="pills-kategorie" aria-selected="false">Kategorie</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="pills-cenik-tab" data-toggle="pill" href="#pills-cenik" role="tab" aria-controls="pills-cenik" aria-selected="false">Ceník</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="pills-sklad-tab" data-toggle="pill" href="#pills-sklad" role="tab" aria-controls="pills-sklad" aria-selected="false">Sklad</a>
								</li>
							</ul>
						</div>
					</div>

					<div class="card mb-4">	
				        <div class="tab-content" id="pills-tabContent">
							<div class="tab-pane fade show active" id="pills-main" role="tabpanel" aria-labelledby="pills-main-tab">
								<div class="card-header text-center">
					              	Hlavní Údaje
					            </div>
					            <div class="card-body text-left">
								    <div class="form-row mb-4" style="margin-top: 2%;">
									    <div class="col">
							            	<h4 class="h4-responsive">Název produktu</h4>
							            	<div class="md-form md-outline">
											  	<input name="nazevProduktu" type="text" id="nazevProduktu" class="form-control unsaved" required>
											  	<label for="nazevProduktu">Název</label>
											</div>	
						            	</div>
						            	<div class="col">
							            	<h4 class="h4-responsive">URL produktu</h4>
											<div class="md-form md-outline">
											  	<input name="urlProduktu" type="text" id="urlProduktu" class="form-control unsaved" required>
											  	<label for="urlProduktu">https://xxx.cz/</label>
											</div>	
						            	</div>
						            	<div class="col">
							            	<h4 class="h4-responsive">Kód produktu</h4>
											<div class="md-form md-outline">
											  	<input name="kodProduktu" type="text" id="kodProduktu" class="form-control unsaved" required>
											  	<label for="kodProduktu">Kód</label>
											</div>	
						            	</div>
								    </div>
									<hr>
									<h4 class="h4-responsive" style="margin-top: 2%;">Popis produktu</h4>
									<div class="form-group blue-border-focus mt-3">
									  	<label for="kratkyPopis">Krátký popis</label>
									  	<textarea name="kratkyPopis" class="form-control unsaved" id="kratkyPopis" rows="3"></textarea>
									</div>
									<div class="form-group blue-border-focus">
									  	<label for="podrobnyPopis">Podrobný popis</label>
									  	<textarea name="podrobnyPopis" class="form-control unsaved" id="podrobnyPopis" rows="3"></textarea>
									</div>
									<hr>
									<h4 class="h4-responsive" style="margin-top: 2%;">Fotografie</h4>
									<div class="input-group mt-3">
										<div class="custom-file" style="width: 100%;margin-top: 30px;">
											<input name="uploadImage[]" class="unsaved" type="file" multiple>
										</div>
										<div id="appendPhoto" style="width: 100%;"></div>
									</div>
									<button id="nextButton" type="button" class="btn btn-primary">Další</button>
									<script type="text/javascript">
										$( document ).ready(function() {
										    $("#nextButton").click(function(){
											  	$('#appendPhoto').append("<div class='custom-file' style='margin-top: 15px;'><input name='uploadImage[]' class='unsaved' type='file' multiple></div>");   
											});
										});
									</script>
									<hr>
									<h4 class="h4-responsive" style="margin-top: 2%;">Viditelnost produktu</h4>
					            	<select class="custom-select custom-select-md mt-3 unsaved" name="viditelnostProdukt">
										<option value=1>Viditelný</option>
										<option value=2>Skrytý</option>
									</select>
									<hr>
									<h4 class="h4-responsive" style="margin-top: 2%;">Související produkty</h4>
							  		<table id="dtBasicExample" class="table table-hover table-bordered table-sm mt-3" cellspacing="0" width="100%">
					                	<thead class="blue lighten-4">
					                  		<tr>
					                    		<th class="th-sm">#</th>
					                    		<th class="th-sm">Kód</th>
					                    		<th class="th-sm">Název</th>
					                    		<th class="th-sm">Kategorie</th>
					                    		<th class="th-sm">Podkategorie</th>
					                  		</tr>
					                	</thead>
						  				<tbody>
						  					<?php
						  					foreach ($rowProducts as $productsRow) {
						  						?>
						  						<tr>
					                  				<th scope="row">
														<div class="custom-control custom-checkbox">
														    <input name='souvisejiciProdukt[]' type="checkbox" class="custom-control-input unsaved" id="defaultUnchecked<?php echo $productsRow['product_id']; ?>" value="<?php echo $productsRow['product_id']; ?>">
														    <label class="custom-control-label" for="defaultUnchecked<?php echo $productsRow['product_id']; ?>"></label>
														</div>
													</th>
					                  				<td><?php echo $productsRow['product_code']; ?></td>
					                  				<td><?php echo $productsRow['product_name']; ?></td>
					                  				<td><?php echo $productsRow['category_name']; ?></td>
					                  				<td><?php echo $productsRow['sub_categories_name']; ?></td>
					                  			</tr>
					                  			<?php
						  					}
						  					?>
						  				</tbody>
						  			</table>
				            	</div>
					        </div>
				            <div class="tab-pane fade" id="pills-kategorie" role="tabpanel" aria-labelledby="pills-kategorie-tab">
								<div class="card-header text-center">
					              	Kategorie a parametry
					            </div>
				            	<div class="card-body text-center">
				            		<div class="row">
					            		<div class="col text-left p-5">
					            			<h4 class="h4-responsive">Kategorie</h4>
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
															    </h5>
															</div>
													      	<ul style="list-style: none;padding-left: 0;">
											            		<?php
											            		foreach ($rowSubCat as $subRow) {
											            			if ($subRow['sub_categories_category'] !== $row['category_id']) {
											            				continue;
											            			} else {
											            				?>
											            				<li>
											            					<div class="category">
											            						<div class="custom-control custom-radio">
																				  	<input id="podKategorieProdukt<?php echo $subRow['sub_categories_id']; ?>" type="radio" class="custom-control-input unsaved" name="podKategorieProdukt" value="<?php echo $subRow['sub_categories_id']; ?>">
																				  	<label class="custom-control-label" for="podKategorieProdukt<?php echo $subRow['sub_categories_id']; ?>">
																				  		<?php echo $subRow['sub_categories_name'] . $subRow['sub_categories_id']; ?>
																				  	</label>
																				</div>
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
										</div>
										<div class="col text-left p-5">
											<h4 class="h4-responsive">Parametry</h4>
							            	<div id="parametry">
							            		
											</div>		
										</div>
				            		</div>
					            </div>
				            </div>

				            <div class="tab-pane fade" id="pills-cenik" role="tabpanel" aria-labelledby="pills-cenik-tab">
				            	<div class="card-header text-center">
					              	Ceník
					            </div>
					            <div class="card-body text-left">
					            	<div class="form-row mb-4" style="margin-top: 2%;">
									    <div class="col">
							            	<h4 class="h4-responsive">Cena produktu</h4>
							            	<div class="md-form md-outline">
											  	<input name="cenaProduktu" type="text" id="cenaProduktu" class="form-control unsaved" required>
											  	<label for="cenaProduktu">Cena</label>
											</div>
						            	</div>
						            	<div class="col">
							            	<h4 class="h4-responsive">Nákupní cena produktu</h4>
							            	<div class="md-form md-outline">
											  	<input name="nakupniCenaProduktu" type="text" id="nakupniCenaProduktu" class="form-control unsaved" required>
											  	<label for="nakupniCenaProduktu">Nákupní cena</label>
											</div>
						            	</div>
						            	<div class="col">
							            	<h4 class="h4-responsive">Sleva produktu</h4>
							            	<div class="md-form md-outline">
											  	<input name="slevaProduktu" type="text" id="slevaProduktu" class="form-control unsaved">
											  	<label for="slevaProduktu">Sleva</label>
											</div>
						            	</div>	
								    </div>
				            	</div>
				            </div>
			            	<div class="tab-pane fade" id="pills-sklad" role="tabpanel" aria-labelledby="pills-sklad-tab">
			            		<div class="card-header text-center">
					              	Sklad
					            </div>
					            <div class="card-body text-left">
						            <div class="form-row mb-4" style="margin-top: 2%;">
									    <div class="col">
							            	<h4 class="h4-responsive">Stav skladu</h4>
							            	<div class="md-form md-outline">
											  	<input name="stavSkladuProduktu" type="text" id="stavSkladuProduktu" class="form-control unsaved" required>
											  	<label for="stavSkladuProduktu">Sklad</label>
											</div>
						            	</div>
						            	<div class="col">
							            	<h4 class="h4-responsive">Dostupnost při vyprodání</h4>
										  	<select class="custom-select custom-select-md mt-3 unsaved" name="dostupnostProduktu">
												<option value=1>Skladem</option>
												<option value=2>Vyprodáno</option>
												<option value=3>Momentálně nedostupné</option>
												<option value=4>Objednáno</option>
												<option value=5>Na dotaz</option>
											</select>
						            	</div>
						            	<div class="col">
							            	<h4 class="h4-responsive">Povolit zásobování do mínusu</h4>
										  	<select class="custom-select custom-select-md mt-3 unsaved" name="minusovyProduktu">
												<option value=1>Ano</option>
												<option value=2>Ne</option>
											</select>
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