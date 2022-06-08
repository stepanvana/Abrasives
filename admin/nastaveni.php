<?php

include '../admin/class_autoload.php';

if (isset($_SESSION['userId'])) {

	$customerViewObj = new admin\customers\CustomersView();
	$customerContrObj = new admin\customers\CustomersContr();
	$ratingSettings = $customerViewObj->showRatingSettings();

	if (isset($_POST['saveSettings'])) {
		$customerContrObj->saveRatingSettings($_POST['ratingSpending'], $_POST['ratingPurchase'], $_POST['ratingStorno'], $_POST['ratingStornoPercentual'], $_POST['ratingNumber'], $_POST['ratingAutoStorno']);
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
			              	<button id="save" type="submit" name="saveSettings" class="btn btn-outline-success btn-md waves-effect">Uložit</button>
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
					if (isset($_GET['error']) && $_GET['error'] == 'get_data') {
						?>
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
						  	<strong>Nepodařilo se získat data!</strong> Pokud problém setrvává kontaktujte správce webu.
						  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						    	<span aria-hidden="true">&times;</span>
						  	</button>
						</div>
						<?php
					} elseif (isset($_GET['error']) && $_GET['error'] == 'settings_edit') {
						?>
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
						  	<strong>Nepodařilo se změnit nastavení!</strong> Zkontrolujte, zda byly zadány správné data, pokud problém setrvává kontaktujte správce webu.
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
				<div class="col-md-12">
					<h4 class="h4-responsive text-center">Nastavení hodnocení zákazníků</h4>
			    </div>
			</div>
			<div class="row wow fadeIn" style="margin-top: 2%;">
				<div class="col-md-6">
					<div class="card mb-4">
						<div class="card-header text-center">
			              	Kdy zobrazovat pozitivní hodnocení
			            </div>
			            <div class="card-body text-right">
			            	<table class="table">
			            		<tbody>
			            			<tr>
			            				<td style="margin-top: 5px;">
			            					Celkově nakoupil nad částku (Kč) 
			            				</td>
			            				<td>
			            					<input name="ratingSpending" style="width: 60%;" class="form-control form-control-sm unsaved" type="text" value="<?php echo $ratingSettings[0]['rating_spending']; ?>">
			            				</td>
			            			</tr>
			            			<tr>
			            				<td>
			            					Nad počet vyřízených objednávek
			            				</td>
			            				<td>
			            					<input name="ratingPurchase" style="width: 60%;" class="form-control form-control-sm unsaved" type="text" value="<?php echo $ratingSettings[0]['rating_purchase']; ?>">
			            				</td>
			            			</tr>
			            		</tbody>
			            	</table>
			            </div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="card mb-4">
						<div class="card-header text-center">
			              	Kdy zobrazovat negativní hodnocení
			            </div>
			            <div class="card-body text-right">
			            	<table class="table">
			            		<tbody>
			            			<tr>
			            				<td style="margin-top: 5px;">
			            					Nad počet storno objednávek
			            				</td>
			            				<td>
			            					<input name="ratingStorno" style="width: 60%;" class="form-control form-control-sm unsaved" type="text" value="<?php echo $ratingSettings[0]['rating_storno']; ?>">
			            				</td>
			            			</tr>
			            			<tr>
			            				<td>
			            					Nad % stornovaných objednávek
			            				</td>
			            				<td>
			            					<input name="ratingStornoPercentual" style="width: 60%;" class="form-control form-control-sm unsaved" type="text" value="<?php echo $ratingSettings[0]['rating_storno_percentual']; ?>">
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
			            	<table class="table">
			            		<thead>
			            			<tr>
			            				<th style="width: 50%;"></th>
			            				<th style="width: 50%;"></th>
			            			</tr>
			            		</thead>
			            		<tbody>
			            			<tr>
			            				<td style="margin-top: 5px;" class="text-right">
			            					Hodnotit nad počet objednávek
			            				</td>
			            				<td>
			            					<input name="ratingNumber" style="width: 50%;" class="form-control form-control-sm unsaved" type="text" value="<?php echo $ratingSettings[0]['rating_number']; ?>">
			            				</td>
			            			</tr>
			            			<tr>
			            				<td class="text-right">
			            					Automaticky stornovat objednávku u negativního hodnocení
			            				</td>
			            				<td>
			            					<div class="custom-control custom-checkbox text-left">
											    <input name="ratingAutoStorno" type="checkbox" class="custom-control-input unsaved" id="defaultUnchecked"  <?php if ($ratingSettings[0]['rating_auto_storno'] == 1) { echo "checked"; } ?>>
											    <label class="custom-control-label" for="defaultUnchecked"></label>
											</div>
			            				</td>
			            			</tr>
			            		</tbody>
			            	</table>
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