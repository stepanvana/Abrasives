<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

if (isset($_SESSION['customerId']) && $_SESSION['customerType'] == 'customer') {
	header("Location: zakaznik/");
} else {
	require 'vendor/autoload.php';
	$customersViewObj = new customers\CustomersView();
	if (isset($_POST['submit'])) {
		if ($customersViewObj->loginCustomer($_POST['customer'], $_POST['psw']) == false) {
			$ipaddress = $_SERVER['REMOTE_ADDR'];
			$webpage = $_SERVER['SCRIPT_NAME'];
			$browser = $_SERVER['HTTP_USER_AGENT'];
			$timestamp = date('d/m/Y h:i:s');
			error_log("Neúspěšné příhlášení. IP: " . $ipaddress . ", Browser: " . $browser . ", TimeStamp: " . $timestamp . ".", 3, "failed-login.log");
			header("Location: prihlaseni");
		} else {
			header("Location: zakaznik/");
		}
	}
	include 'header.php';
	include 'nav.php';
?>

	<div>
		<section style="background-image: url('http://mdbootstrap.com/img/Photos/Others/images/91.jpg'); background-repeat: no-repeat; background-size: cover; background-position: center center;height: 100vh;">
			<div class="mask d-flex" style="height: 100vh;background-color: rgba(0, 0, 0, 0.3);">
				<div class="container py-5 my-5">
					<h3 class="font-weight-bold text-center white-text pb-2 mt-5">Přihlášení</h3>
					<p class="lead text-center white-text pt-2 mb-5">Přihlašte se a získejte zajímavé výhody.</p>
					<div class="row d-flex align-items-center justify-content-center">
						<div class="col-md-6 col-xl-5">
							<div class="card">
								<form action="" method="POST">
									<div class="card-body z-depth-2 px-4">
										<div class="md-form mt-3">
											<i class="fa fa-user prefix grey-text"></i>
											<input name="customer" type="text" id="form3" class="form-control" required>
											<label for="form3">Uživatelský e-mail</label>
										</div>
										<div class="md-form">
											<i class="fas fa-key prefix grey-text"></i>
											<input name="psw" type="password" id="form4" class="form-control">
											<label for="form4">Heslo</label>
										</div>
										<div class="text-center my-3">
											<button type="submit" name="submit" class="btn btn-primary btn-block">Přihlásit se</button>
										</div>
										<div class="alert alert-danger alert-dismissible fade show" role="alert">
											<strong>Použijte jiný e-mail!</strong>
											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
									</div>
								</form>
							</div>
							<div class="card mt-3 text-center">
								<div class="card-body z-depth-2 px-2">
									Nemáte účet? Registrujte se<a href="registrace"><button type="button" class="btn btn-primary btn-sm">zde</button></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>

<?php
	include 'footer.php';
}
?>