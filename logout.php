<?php
session_start();
if (isset($_SESSION['userId'])) {
	require 'vendor/autoload.php';
	$usersViewObj = new users\UsersView();
	if ($usersViewObj->logOutUser() == true) {
	 	header("Location: http://127.0.0.1/edsa-Abrasives/www/");
	} else {
		header("Location: http://127.0.0.1/edsa-Abrasives/www/");
	}
} else {
	header('Location: http://127.0.0.1/edsa-Abrasives/www/');
}