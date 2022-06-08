<?php

include '../admin/class_autoload.php';

if (isset($_SESSION['userId'])) {

	$ordersObj = new admin\orders\OrdersView();
	$ordersSaveObj = new admin\orders\OrdersContr();

	$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

	if (isset($_GET['condition'])) {
		if ( !in_array($_GET['condition'], ['NULL','1', '2', '3', '4', '5'], true ) ) {
			header("Location: ?error=wrongInput");
		} else {
			if ($_GET['condition'] == 'NULL') {
				$condition = NULL;
			} else {
				$condition = $_GET['condition'];
			}	
		}
	} else {
		$condition = NULL;
	}

	if (isset($_POST['saveOrder'])) {
		if ($ordersSaveObj->saveOrders($_POST['ids'], $_POST['condition']) == true) {
			header("Location: ?success");
		} else {
			header("Location: ?error=order_edit");
		}
	}

	if (isset($_POST['paidOrder'])) {
		if ($ordersSaveObj->saveOrders($_POST['ids'], $_POST['condition']) == true) {
			if ($ordersSaveObj->paidOrders($_POST['checkbox'], 1) == true) {
				header("Location: ?success");
			} else {
				header("Location: ?error=order_edit");
			}
		} else {
			header("Location: ?error=order_edit");
		}
	}

	if (isset($_POST['notPaidOrder'])) {
		if ($ordersSaveObj->saveOrders($_POST['ids'], $_POST['condition']) == true) {
			if ($ordersSaveObj->paidOrders($_POST['checkbox'], 2) == true) {
				header("Location: ?success");
			} else {
				header("Location: ?error=order_edit");
			}
		} else {
			header("Location: ?error=order_edit");
		}
	}

	if (isset($_POST['deleteOrder'])) {
		if ($ordersSaveObj->saveOrders($_POST['ids'], $_POST['condition']) == true) {
			if ($ordersSaveObj->deleteOrders($_POST['checkbox']) == true) {
				header("Location: ?success");
			} else {
				header("Location: ?error=order_edit2");
			}
		} else {
			header("Location: ?error=order_edit1");
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
				            <a href="novy-produkt.php">
				                <button type="button" class="btn btn-outline-info btn-md waves-effect">Nový produkt</button>
				            </a>
			            </li>
			            <li class="nav-item">
				            <a href="order-create.php">
				                <button type="button" class="btn btn-outline-info btn-md waves-effect">Nová objednávka</button>
				            </a>
			            </li>
			            <li class="nav-item">
			              	<button type="submit" name="saveOrder" class="btn btn-outline-success btn-md waves-effect" id="save">Uložit</button>
			            </li>
			            <li class="nav-item">
							<div class="btn-group">
							  <button type="button" class="btn btn-outline-info btn-md dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							    Výběr
							  </button>
							  <div class="dropdown-menu dropdown-menu-right">
							    <button class="dropdown-item" type="submit" name="paidOrder">Zaplaceno</button>
							    <button class="dropdown-item" type="submit" name="notPaidOrder">Nezaplaceno</button>
							    <button class="dropdown-item" type="submit" name="createPdfOrder">Vytvořit PDF</button>
							    <button class="dropdown-item" type="submit" name="exportOrder">Export</button>
							    <button class="dropdown-item" type="submit" name="deleteOrder" onclick="return confirm('Opravdu si přejete objednávku odstranit?')">Odstranit</button>
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
						  	<strong>Objednávku se nepodařilo upravit!</strong> Prosím kontaktujte správce webu o tomto problému.
						  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						    	<span aria-hidden="true">&times;</span>
						  	</button>
						</div>
						<?php
					} elseif (isset($_GET['error']) && $_GET['error'] == 'wrongInput') {
						?>
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
						  	<strong>Špatný vstup filtru!</strong> Prosím zadejte platnou hodnotu.
						  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						    	<span aria-hidden="true">&times;</span>
						  	</button>
						</div>
						<?php
					} elseif (isset($_GET['success'])) {
						?>
						<div class="alert alert-success alert-dismissible fade show" role="alert">
						  	<strong>Dokončeno!</strong> Objednávky byly upraveny.
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
						<div class="card-header text-center">
			              	Objednávky
			            </div>
			            <div class="card-body text-center">
						    <ul class="nav nav-pills nav-fill" id="pills-tab">
							  	<li class="nav-item">
							    	<a class="nav-link <?php if($condition == NULL){ echo 'active';}?>" id="pills-vse-tab" href="objednavky.php?condition=NULL">Všechny</a>
							  	</li>
							  	<li class="nav-item">
							    	<a class="nav-link <?php if($condition == 1){ echo 'active';}?>" id="pills-nevyrizeno-tab" href="objednavky.php?condition=1">Nevyřízeno</a>
							  	</li>
							  	<li class="nav-item">
							    	<a class="nav-link <?php if($condition == 2){ echo 'active';}?>" id="pills-vyrizujeSe-tab" href="objednavky.php?condition=2">Vyřizuje se</a>
							  	</li>
							  	<li class="nav-item">
							    	<a class="nav-link <?php if($condition == 3){ echo 'active';}?>" id="pills-vyrizeno-tab" href="objednavky.php?condition=3">Vyřízeno</a>
							  	</li>
							  	<li class="nav-item">
							    	<a class="nav-link <?php if($condition == 4){ echo 'active';}?>" id="pills-odeslano-tab" href="objednavky.php?condition=4">Odesláno</a>
							  	</li>
							  	<li class="nav-item">
							    	<a class="nav-link <?php if($condition == 5){ echo 'active';}?>" id="pills-stornovano-tab" href="objednavky.php?condition=5">Stornováno</a>
							  	</li>
							</ul>
						</div>
			            <div class="card-body">
			            	<div class="tab-content" id="pills-tabContent">

			            		<div class="tab-pane fade show active" id="pills-vse">
			            			<table id="dtBasicExample" class="table table-hover table-bordered table-sm" cellspacing="0" width="100%">
					                	<thead class="blue lighten-4">
					                  		<tr>
					                    		<th class="th-sm">#</th>
					                    		<th class="th-sm">Kód</th>
					                    		<th class="th-sm">Datum</th>
					                    		<th class="th-sm">Jméno a přijmení</th>
					                    		<th class="th-sm">Způsob dopravy</th>
					                    		<th class="th-sm">Platba</th>
					                    		<th class="th-sm">Stav</th>
					                    		<th class="th-sm">Cena</th>
					                  		</tr>
					                	</thead>
						  				<tbody>
					                  		<?php
					                  		$ordersArray = $ordersObj->showOrders($condition);
					                  		if (empty($ordersArray)) {
												?>
												<div class="alert alert-danger alert-dismissible fade show" role="alert">
												  	<strong>Žádné data ve výběru!</strong> Ve zvoleném rozsahu dat se nenachází žádné objednávky.
												  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
												    	<span aria-hidden="true">&times;</span>
												  	</button>
												</div>
												<?php
											} elseif ($ordersArray == false) {
												?>
												<div class="alert alert-danger alert-dismissible fade show" role="alert">
												  	<strong>Něco se pokazilo!</strong> Pokud problém setrvává informujte správce webu.
												  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
												    	<span aria-hidden="true">&times;</span>
												  	</button>
												</div>
												<?php
											} else {
												foreach ($ordersArray as $row) { ?>
													<tr>
														<th scope="row">
															<div class="custom-control custom-checkbox">
															    <input name='checkbox[]' type="checkbox" class="custom-control-input" id="defaultUnchecked<?php echo $row['order_id'] ?>" value="<?php echo $row['order_id'] ?>">
															    <label class="custom-control-label" for="defaultUnchecked<?php echo $row['order_id'] ?>"></label>
															</div>
														</th>
								                    	<td>
								                    		<a href=detail-objednavky.php?id=<?php echo $row['order_id'] ?>>
								                    			<?php echo $row['order_code'] . "<br>"; ?>
								                    		</a>
								                    	</td>
								                    	<td><?php echo date("d.m.Y H:i:s", strtotime($row['order_date'])); ?></td>
								                    	<td><?php echo $row['customer_name'] . " " . $row['customer_sirname']; ?></td>
								                    	<td><?php echo $row['shipping_method']; ?></td>
								                    	<td><?php echo $row['paymentMethod_method'] . "<br>" . $row['paymentStatus_status']; ?></td>
								                    	<td>
								                    		<select class="custom-select custom-select-sm unsaved" name="condition[]" style="border: none;">
																<option value=1 <?php if($row['condition_condition']=='Nevyřízeno') echo "selected"; ?>>Nevyřízeno</option>
																<option value=2 <?php if($row['condition_condition']=='Vyřizuje se') echo "selected"; ?>>Vyřizuje se</option>
																<option value=3 <?php if($row['condition_condition']=='Vyřízeno') echo "selected"; ?>>Vyřízeno</option>
																<option value=4 <?php if($row['condition_condition']=='Odesláno') echo "selected"; ?>>Odesláno</option>
																<option value=5 <?php if($row['condition_condition']=='Stornováno') echo "selected"; ?>>Stornováno</option>
															</select>
								                    	</td>
								                    	<td><?php echo $row['payment_amount']; ?></td>
								                    	<input type="hidden" name="ids[]" value="<?php echo $row['order_id']; ?>">	
							                    	</tr> <?php
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