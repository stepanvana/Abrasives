<?php

if (empty($_GET['email']) || empty($_GET['key'])) {
	header("Location: /");
} else {
	require 'vendor/autoload.php';
	$customersContrObj = new customers\CustomersContr();
	if ($customersContrObj->confirmEmail($_GET['email'], $_GET['key']) == true) {
		header("Location: /zakaznik?success");
	} else {
		header("Location: ?error");
	}
}