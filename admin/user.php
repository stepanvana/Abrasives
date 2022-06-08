<?php

include '../admin/class_autoload.php';

if (isset($_SESSION['userId'])) {

	$userContrObj = new admin\users\UsersContr();

	if (isset($_POST['saveSettings'])) {
		if ($_FILES['newImage']['size'] !== 0 && $_FILES['newImage']['error'] == 0) {
			move_uploaded_file($_FILES["newImage"]["tmp_name"],"../images/" . $_FILES["newImage"]["name"]);
			$file=$_FILES["newImage"]["name"];
		} else {
			$file = $userArray['user_image'];
		}
		$userContrObj->saveSettings($_POST['userName'], $_POST['userEmail'], $_POST['userPhone'], $_POST['oldPassword'], $_POST['newPassword'], $_SESSION['userId'], $file);
	}

	if (isset($_POST['deleteImage'])) {
		$userContrObj->deleteImage($_SESSION['userId']);
	}

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
			<div class="row wow fadeIn">
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
					} elseif (isset($_GET['error']) && $_GET['error'] == 'edit_settings') {
						?>
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
						  	<strong>Nepodařilo se upravit data!</strong> Zkontrolujte, zda byly zadány správné data, pokud problém setrvává kontaktujte správce webu.
						  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						    	<span aria-hidden="true">&times;</span>
						  	</button>
						</div>
						<?php
					} elseif (isset($_GET['error']) && $_GET['error'] == 'wrong_password') {
						?>
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
						  	<strong>Špatné heslo!</strong> Zadejte správné údaje a akci opakujte.
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
				<div class="col-md-12 mt-5">
	            	<section>
						<div class="list-group list-group-flush z-depth-1 rounded">
							<div class="list-group-item active d-flex justify-content-start align-items-center py-3">
								<?php echo "<img src='../images/".$userArray['user_image']."' alt='avatar image' class='rounded-circle z-depth-0' width='50'>"; ?>	
								<div class="d-flex flex-column pl-3">
									<p class="font-weight-normal mb-0"><?php echo $_SESSION['userUid']; ?></p>
									<p class="small mb-0">Web Designer</p>
								</div>
							</div>
							<a href="#!" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">Objednávky
								<span class="badge badge-info badge-pill"><?php echo count($tasksArray); ?></span>
							</a>
							<?php
							$count = 0;
							foreach ($tasksArray as $row) {
								$count++;
								echo "
								<p style='margin: 20px 0 0 20px;padding: 0;'>
									<span class='badge badge-info badge-pill' style='margin-right: 10px;'>
										" . $count . "
									</span>
									Nová objednávka <strong><a href='detail-objednavky.php?id=" . $row['order_id'] . "'>" . $row['order_code'] . "</a></strong>. Podaná dne " . $row['order_date'] . ".
								</p><br>";
							}

							?>
							<a href="#!" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">Ostatní úkoly
								<span class="badge badge-warning badge-pill">0</span>
							</a>
						</div>
					</section>
				</div>			
			</div>
			<div class="row wow fadeIn" style="margin-top: 2%;">
				<div class="col-md-6">
					<div class="card mb-4">
						<div class="card-header text-center">
			              	Profilová fotka
			            </div>
			            <div class="card-body text-center">
			            	<div class="row">
			            		<div class="col">
			            			<?php echo "<img src='../images/".$userArray['user_image']."' alt='thumbnail' class='img-thumbnail' style='width: 200px'>"; ?>		
			            		</div>
			            	</div>
			            	<div class="row" style="margin-top: 5%;">
			            		<div class="col text-right">
			            			<div style="height: 45px;" class="btn btn-success">
			            				<label for="upload-photo">Vybrat...</label>
										<input name="newImage" class="unsaved" type="file" name="image/jpeg" id="upload-photo" value="" />
			            			</div>
			            		</div>
			            		<div class="col text-left">
			            			<button style="height: 45px;" name="deleteImage" type="submit" class="btn btn-danger">Odstranit</button>
			            		</div>
			            	</div>
			            </div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="card mb-4">
						<div class="card-header text-center">
			              	Informace o profilu
			            </div>
			            <div class="card-body text-right">
			            	<div class="row">
			            		<div class="col">
			            			<div class="md-form">
										<input name="userName" type="text" id="userName" class="form-control unsaved" value="<?php echo $userArray['user_name']; ?>">
										<label for="userName">Jméno</label>
									</div>
			            		</div>
			            		<div class="col">
			            			<div class="md-form">
										<input name="userEmail" type="text" id="userEmail" class="form-control unsaved" value="<?php echo $userArray['user_email']; ?>">
										<label for="userEmail">E-mail</label>
									</div>
			            		</div>
			            	</div>
			            	<div class="md-form">
								<input name="userPhone" type="text" id="userPhone" class="form-control unsaved" value="<?php echo $userArray['user_phone']; ?>">
								<label for="userPhone">Telefon</label>
							</div>
							<hr>
							<h6 class="h6-responsive text-center">Změna hesla</h6>
							<div class="row">
			            		<div class="col">
			            			<div class="md-form">
										<input name="oldPassword" type="password" id="oldPassword" class="form-control">
										<label for="oldPassword">Staré heslo</label>
									</div>
			            		</div>
			            		<div class="col">
			            			<div class="md-form">
										<input name="newPassword" type="password" id="newPassword" class="form-control">
										<label for="newPassword">Nové heslo</label>
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