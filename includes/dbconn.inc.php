<?php

$host = 'localhost';
$user = 'root';
$password = '';
$dba = 'abrasives';

$conn = mysqli_connect($host, $user, $password, $dba);
if ( mysqli_connect_errno() ) {
	die ('Failed to connect to MySQL: ' . mysqli_connect_error());
}