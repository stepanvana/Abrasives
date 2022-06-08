<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require '../vendor/autoload.php';

$statisticsObj = new admin\statistics\StatisticsView();

$page = basename($_SERVER['PHP_SELF']);

$userViewObj = new admin\users\UsersView();
$userArray = $userViewObj->showUser($_SESSION['userId']);
$tasksArray = $userViewObj->showTasks($_SESSION['userId']);

$messagesViewObj = new admin\messages\MessagesView();
$messagesArray = $messagesViewObj->ShowMessages();
$count = array_column($messagesArray, 'contact_condition');
$count = count(array_keys($count, 2));

if (isset($_POST['searchOrder'])) {
    $searchOrder = $_POST['searchField'];
    header("Location: ?searchField=" . $searchOrder . "");
}