<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_SESSION['start']) && (time() - $_SESSION['start'] > 15)) {
    session_unset();
    session_destroy();
}

require 'vendor/autoload.php';

include 'includes/class-autoload.inc.php';
include_once 'classes/products/Cart.php';
$cartObj = new products\Cart();
$productViewObj = new products\ProductsView();
$productContrObj = new products\ProductsContr();
$usersViewObj = new users\UsersView();
$usersContrObj = new users\UsersContr();

$page = basename($_SERVER['PHP_SELF']);

if(isset($_POST['change_ammount'])) {
    $cartObj->setCartAmount($_POST['change_ammount'], $_POST['quantity']);
    header("Cache-Control: no-cache, must-revalidate");
    header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/edsa-Abrasives/www/kosik");
    exit();
}

if(isset($_POST['remove'])) {
    $cartObj->deleteFromCart($_POST['removeId']);
    header("Cache-Control: no-cache, must-revalidate");
    header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/edsa-Abrasives/www/kosik");
    exit();
}

if (isset($_POST['email_send_submit'])) {
    $usersContrObj->createNewMessage($_POST['contactForm_name'], $_POST['contactForm_email'], $_POST['contactForm_subject'], $_POST['contactForm_message'], $_SERVER['REMOTE_ADDR']);
}

if (isset($_POST['email_sub_submit'])) {
    $usersContrObj->createNewSub($_POST['email_sub'], $_SERVER['REMOTE_ADDR']);
}

if (isset($_POST['searchBtn'])) {
    header('Location: /vyhledavani/' . $_POST['search'] . '');
}

?>

<!DOCTYPE html>
    <html lang="cs">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <meta http-equiv="x-ua-compatible" content="ie=edge">

            <meta name="description" content="Dovoz, výroba a prodej brusiva a brusných materiálů od firem Starcke, VSM, Awuko a Granit. Vyrábíme brusné pásy, výseky a lamelové talíře.">
            <meta name="keywords" content="brusiva, houbičky">
            <meta name="author" content="Štěpán Váňa">

            <title>Abrasives | Dovoz, výroba a prodej brusiva a brusných materiálů</title>

            <base href="http://127.0.0.1/edsa-Abrasives/www/">
            <link rel="stylesheet" type="text/css" href="css/style.css">

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

            <!-- BOOTSTRAP -->
            <!-- MDB icon -->
            <link rel="icon" href="img/mdb-favicon.ico" type="image/x-icon">
            <!-- Font Awesome -->
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
            <!-- Google Fonts Roboto -->
            <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
            <!-- Bootstrap core CSS -->
            <link rel="stylesheet" href="css/bootstrap.min.css">
            <!-- Material Design Bootstrap -->
            <link rel="stylesheet" href="css/mdb.min.css">
        </head>
        <body>