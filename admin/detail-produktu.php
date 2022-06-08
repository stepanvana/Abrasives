<?php

include '../admin/class_autoload.php';

if (isset($_SESSION['userId']) && isset($_GET['id'])) {

	$id = $_GET['id'];
	


	$productsObj = new admin\products\ProductsView();
	$productsSaveObj = new admin\products\ProductsContr();

	$row = $productsObj->showProduct($id);
	if (empty($row) || is_bool($row) === true) {
		header("Location: ?error=not_existing_product");
		exit();
	}
	$filterUsed = explode(";", $row['product_related']);
	$rowNotUsedProducts = $productsObj->showProducts($filterUsed);

	$filterNotUsed = array_column($rowNotUsedProducts, 'product_id');
	$rowUsedProducts = $productsObj->showProducts($filterNotUsed);
	$rowCategories = $productsObj->showCategories();
	$subCatArray = $productsObj->showSubCat();
	$paramsArray = $productsObj->showParams();
	$paramsValuesArray = $productsObj->showParamsValues();

	if (isset($_POST['saveProduct'])) {
		if (!empty($_FILES["uploadImage"])) {
	      $existingImages = $_POST['existingImage'];
	      $fileArray = array();
	      for ($p=0; $p < count($_FILES["uploadImage"]["name"]); $p++) {
	        move_uploaded_file($_FILES["uploadImage"]["tmp_name"][$p],"../images/".$_FILES["uploadImage"]["name"][$p]);
	        $file=$_FILES["uploadImage"]["name"][$p];
	        array_push($fileArray, $file);
	      }
	      $arrayImageMerge = array_merge($existingImages, $fileArray);
	      if (!empty($_POST['deletePhoto'])) {
	        $deletePhoto = $_POST['deletePhoto']; //array
	        $filtered = array_diff($arrayImageMerge, $deletePhoto);
	        $filteredFotografie = implode(";", $filtered);

	        $filteredFotografie = trim($filteredFotografie, ';');
	        
	      } else {
	        $filteredFotografie = implode(";", $arrayImageMerge);

	        $filteredFotografie = trim($filteredFotografie, ';');
	      }
	    } else {
	      $existingImages = $_POST['existingImage'];
	      $filteredFotografie = implode(";", $existingImages);

	      $filteredFotografie = trim($filteredFotografie, ';');
	    }
		$productsSaveObj->saveProduct($_POST['nazevProduktu'], $_POST['urlProduktu'], $_POST['kodProduktu'], $_POST['kratkyPopis'], $_POST['podrobnyPopis'], $_POST['podKategorieProdukt'], $_POST['param'], $_POST['paramValue'], $_POST['viditelnostProdukt'], $_POST['cenaProduktu'], $_POST['nakupniCenaProduktu'], $_POST['slevaProduktu'], $_POST['stavSkladuProduktu'], $_POST['dostupnostProduktu'], $_POST['minusovyProduktu'], $_POST['odstranitProdukt'], $_POST['souvisejiciProdukt'], $filteredFotografie, $id);
	}

	if (isset($_POST['deleteProduct'])) {
		$productsSaveObj->deleteProduct($id);
	}

	if (isset($_POST['copyProduct'])) {
		$productsSaveObj->copyProduct($id);
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
			              	<button id="save" type="submit" name="saveProduct" class="btn btn-outline-success btn-md waves-effect">Uložit</button>
			            </li>
			            <li class="nav-item">
			              	<button type="submit" name="deleteProduct" class="btn btn-outline-danger btn-md waves-effect" onclick="return confirm('Opravdu si přejete produkty odstranit?')">Smazat</button>
			            </li>
			            <li class="nav-item">
			              	<button type="submit" name="copyProduct" class="btn btn-outline-info btn-md waves-effect" onclick="return confirm('Opravdu si přejete vytvořit kopii produktu?')">Kopie</button>
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
											  	<input name="nazevProduktu" type="text" id="nazevProduktu" class="form-control unsaved" value="<?php echo $row['product_name']; ?>" required>
											  	<label for="nazevProduktu">Název</label>
											</div>	
						            	</div>
						            	<div class="col">
							            	<h4 class="h4-responsive">URL produktu</h4>
											<div class="md-form md-outline">
											  	<input name="urlProduktu" type="text" id="urlProduktu" class="form-control unsaved" value="<?php echo $row['product_url']; ?>" required>
											  	<label for="urlProduktu">https://xxx.cz/</label>
											</div>	
						            	</div>
						            	<div class="col">
							            	<h4 class="h4-responsive">Kód produktu</h4>
											<div class="md-form md-outline">
											  	<input name="kodProduktu" type="text" id="kodProduktu" class="form-control unsaved" value="<?php echo $row['product_code']; ?>" required>
											  	<label for="kodProduktu">Kód</label>
											</div>	
						            	</div>	
								    </div>
									<hr>
									<h4 class="h4-responsive" style="margin-top: 2%;">Popis produktu</h4>
									<div class="form-group blue-border-focus mt-3">
									  	<label for="kratkyPopis">Krátký popis</label>
									  	<textarea name="kratkyPopis" class="form-control unsaved" id="kratkyPopis" rows="3"><?php echo $row['product_shortDesc']; ?></textarea>
									</div>
									<div class="form-group blue-border-focus">
									  	<label for="podrobnyPopis">Podrobný popis</label>
									  	<textarea name="podrobnyPopis" class="form-control unsaved" id="podrobnyPopis" rows="3"><?php echo $row['product_desc']; ?></textarea>
									</div>
									<hr>
									<h4 class="h4-responsive" style="margin-top: 2%;">Fotografie</h4>
									<div class="input-group mt-3">
										<?php
										$fotoArray = $row['product_image'];
		                    			$fotoArray = explode(";",$fotoArray);
		                    			for ($i=0; $i < count($fotoArray); $i++) { 
		                    				?>
		                    				<div>
			                    				<img class="img-thumbnail" style="width: 150px;margin: 10px;" src="../images/<?php echo $fotoArray[$i]; ?>">
			                    				<div class="custom-control custom-checkbox text-center">
												    <input name="deletePhoto[]" type="checkbox" class="custom-control-input unsaved" id="defaultUnchecked<?php echo $fotoArray[$i]; ?>" value="<?php echo $fotoArray[$i]; ?>">
												    <label class="custom-control-label" for="defaultUnchecked<?php echo $fotoArray[$i]; ?>">Odstranit</label>
												</div>	
		                    				</div>
											<input type="hidden" name="existingImage[]" value="<?php echo $fotoArray[$i]; ?>">
		                    				<?php
		                    			}
										?>
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
					            	<select class="custom-select custom-select-md mt-3" name="viditelnostProdukt">
										<option value=1 <?php if($row['product_visibility']==1) echo "selected"; ?>>Viditelný</option>
										<option value=2 <?php if($row['product_visibility']==2) echo "selected"; ?>>Skrytý</option>
									</select>
									<hr>
									<h4 class="h4-responsive" style="margin-top: 2%;">Související produkty</h4>
									<table class="table table-hover table-bordered table-sm mt-3">
										<thead class="blue lighten-4">
					                  		<tr>
					                    		<th class="th-sm">Kód produktu</th>
					                    		<th class="th-sm">Název produktu</th>
					                    		<th class="th-sm">#</th>
					                  		</tr>
					                	</thead>
						  				<tbody>
						  					<?php
						  					foreach ($rowUsedProducts as $productsUsedRow) {
						  						?>
						  						<tr>
					                  				<td><?php echo $productsUsedRow['product_code']; ?></td>
					                  				<td><?php echo $productsUsedRow['product_name']; ?></td>
					                  				<th scope="row">
														<div class="custom-control custom-checkbox">
														    <input name='odstranitProdukt[]' type="checkbox" class="custom-control-input unsaved" id="defaultUnchecked<?php echo $productsUsedRow['product_id']; ?>" value="<?php echo $productsUsedRow['product_id']; ?>">
														    <label class="custom-control-label" for="defaultUnchecked<?php echo $productsUsedRow['product_id']; ?>"><i class="fas fa-trash-alt fa-lg red-text pr-3"></i></label>
														</div>
													</th>
					                  			</tr>
					                  			<input type="hidden" name="souvisejiciProdukt[]" value="<?php echo $productsUsedRow['product_id']; ?>">
					                  			<?php
						  					}
						  					?>
						  				</tbody>
						  			</table>
						  			<h4 class="h4-responsive" style="margin-top: 4%;">Přidat další související produkty</h4>
							  		<table id="dtBasicExample" class="table table-hover table-bordered table-sm mt-3" cellspacing="0" width="100%">
					                	<thead class="blue lighten-4">
					                  		<tr>
					                    		<th class="th-sm">#</th>
					                    		<th class="th-sm">Kód produktu</th>
					                    		<th class="th-sm">Název produktu</th>
					                  		</tr>
					                	</thead>
						  				<tbody>
						  					<?php
						  					if ($rowNotUsedProducts == false) {
						  						echo "Žádné související produkty k přidání.";
						  					} else {
							  					foreach ($rowNotUsedProducts as $productsRow) {
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
						                  			</tr>
						                  			<?php
							  					}	
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
				            	<!-- <div class="card-body text-left">
					            	<select class="custom-select custom-select-sm unsaved" name="kategorieProdukt" id="kategorieProdukt" style="border: none;border-bottom: 1px solid #ced4da;border-radius: 0px;">
					            		<option value="" selected disabled>Vyberte kategorii ...</option>
					            		<?php
						            	foreach ($rowCategories as $category) {
						            		echo "<option value=".$category['category_id']." " . (($category['category_id']==$row['product_category'])?"selected":"") . ">".$category['category_name']."</option>";
						            	}
						            	?>
									</select>
				            	</div>
				            	<div class="card-body text-left">
					            	<select class="custom-select custom-select-sm unsaved" name="podKategorieProdukt" id="podKategorieProdukt" style="border: none;border-bottom: 1px solid #ced4da;border-radius: 0px;">
					            		<option value="" selected disabled>Vyberte nejprve kategorii ...</option>
					            		<?php
					            		foreach ($subCatArray as $subCat) {
					            			if ($subCat['sub_categories_category']!==$row['product_category']) {
					            				continue;
					            			} else {
					            				echo "<option value=".$subCat['sub_categories_id']." " . (($subCat['sub_categories_id']==$row['product_sub_category'])?"selected":"") . ">".$subCat['sub_categories_name']."</option>";
					            			}
										}
					            		?>
									</select>
				            	</div> -->















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
									            	foreach ($rowCategories as $catRow) {
									            		?>
														<li>
															<div class="category">
																<h5 style="margin-top: 20px;">
														        	<span><?php echo $catRow['category_name']; ?></span>
															    </h5>
															</div>
													      	<ul style="list-style: none;padding-left: 0;">
											            		<?php
											            		foreach ($subCatArray as $subRow) {
											            			if ($subRow['sub_categories_category'] !== $catRow['category_id']) {
											            				continue;
											            			} else {
											            				?>
											            				<li>
											            					<div class="category">
											            						<div class="custom-control custom-radio">
																				  	<input id="podKategorieProdukt<?php echo $subRow['sub_categories_id']; ?>" type="radio" class="custom-control-input unsaved" name="podKategorieProdukt" value="<?php echo $subRow['sub_categories_id']; ?>" <?php if($subRow['sub_categories_id']==$row['product_sub_category']) { echo "checked"; } ?>>
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
										<div class="col p-5 text-left">
											<h4 class="h4-responsive">Parametry</h4>
											<p>Pokud chcete změnit parametry, vyberte znovu podkategorii.</p>
							            	<div id="parametry">
							            		<?php
							            		foreach ($paramsArray as $param) {
							            			if ($param['param_sub_cat']!==$row['product_sub_category']) {
							            				continue;
							            			} else {
							            				?>
														<div class="form-row mb-4" style="margin-top: 2%;">
							            				<?php
							            				foreach ($paramsValuesArray as $paramVal) {
								            				if ($paramVal['value_product_id'] == $row['product_id'] && $paramVal['value_param_id'] == $param['param_id']) {
								            					?>
								            					<div class="col">
																	<div class="form-row mb-4" style="margin-top: 2%;">
																		<div class="md-form md-outline" style="margin: 0;padding: 0;">
																		  	<input id="paramValue" class="form-control unsaved" type='text' name='paramValue[]' value="<?php echo $paramVal['value_value']; ?>" disabled>
																		  	<label for="paramValue"><?php echo $param['param_name']; ?></label>
																		</div>
																    </div>
														    	</div>
								            					<?php
								            				}	
							            				}
							            				?>
														</div>
							            				<?php
							            			}
												}
							            		?>
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
											  	<input name="cenaProduktu" type="text" id="cenaProduktu" class="form-control unsaved" value="<?php echo $row['product_price']; ?>" required>
											  	<label for="cenaProduktu">Cena</label>
											</div>
						            	</div>
						            	<div class="col">
							            	<h4 class="h4-responsive">Nákupní cena produktu</h4>
							            	<div class="md-form md-outline">
											  	<input name="nakupniCenaProduktu" type="text" id="nakupniCenaProduktu" class="form-control unsaved" value="<?php echo $row['product_purchase_price']; ?>" required>
											  	<label for="nakupniCenaProduktu">Nákupní cena</label>
											</div>
						            	</div>
						            </div>
						            <div class="form-row mb-4" style="margin-top: 2%;">
						            	<div class="col">
							            	<h4 class="h4-responsive">Sleva produktu</h4>
							            	<div class="md-form md-outline">
											  	<input name="slevaProduktu" type="text" id="slevaProduktu" class="form-control unsaved" value="<?php echo $row['product_discount']; ?>">
											  	<label for="slevaProduktu">Sleva</label>
											</div>
						            	</div>
								    </div>
									<hr>
									<h4 class="h4-responsive">Cena po slevě</h4>
					            	<div class="md-form md-outline">
									  	<input name="cenaPoSleveProduktu" type="text" id="cenaPoSleveProduktu" class="form-control unsaved" value="<?php echo $row['product_price']*(1-($row['product_discount']/100)); ?>" disabled>
									  	<label for="cenaPoSleveProduktu">Cena po slevě</label>
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
											  	<input name="stavSkladuProduktu" type="text" id="stavSkladuProduktu" class="form-control unsaved" value="<?php echo $row['product_storage']; ?>" required>
											  	<label for="stavSkladuProduktu">Sklad</label>
											</div>
						            	</div>
						            	<div class="col">
							            	<h4 class="h4-responsive">Dostupnost při vyprodání</h4>
										  	<select class="custom-select custom-select-md mt-3 unsaved" name="dostupnostProduktu">
												<option value=1 <?php if($row['product_availibility']==1) echo "selected"; ?>>Skladem</option>
												<option value=2 <?php if($row['product_availibility']==2) echo "selected"; ?>>Vyprodáno</option>
												<option value=3 <?php if($row['product_availibility']==3) echo "selected"; ?>>Momentálně nedostupné</option>
												<option value=4 <?php if($row['product_availibility']==4) echo "selected"; ?>>Objednáno</option>
												<option value=5 <?php if($row['product_availibility']==5) echo "selected"; ?>>Na dotaz</option>
											</select>
						            	</div>
						            	<div class="col">
							            	<h4 class="h4-responsive">Povolit zásobování do mínusu</h4>
										  	<select class="custom-select custom-select-md mt-3 unsaved" name="minusovyProduktu">
												<option value=1 <?php if($row['product_minus_shopping']==1) echo "selected"; ?>>Ano</option>
												<option value=2 <?php if($row['product_minus_shopping']==2) echo "selected"; ?>>Ne</option>
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