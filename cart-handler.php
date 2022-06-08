<?php
require 'vendor/autoload.php';
session_start();

if(isset($_POST['action']) && $_POST['action'] == 'add') {
    $cartObj = new products\Cart();
    $success = $cartObj->addToCart($_POST['id'], $_POST['name'], $_POST['price'], $_POST['costs'], $_POST['discount'], $_POST['quantity'], $_POST['url'], $_POST['image'], $_POST['category']);
    echo count($_SESSION['shopping_cart']);
}

if(isset($_POST['action']) && $_POST['action'] == 'remove') {
    $cartObj = new products\Cart();
    $success = $cartObj->deleteFromCart($_POST['id']);
    echo count($_SESSION['shopping_cart']);
}