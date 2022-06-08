<?php
session_start();
if (isset($_SESSION['customerId'])) {
	require 'vendor/autoload.php';
	$customersViewObj = new customers\CustomersView();
	if ($customersViewObj->logOutCustomer() == true) {
	 	header("Location: /");
	} else {
		header("Location: /produkty");
	}
} else {
	header('Location: /prihlaseni');
}