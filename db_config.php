<?php

$dbname="customer_db";
$username="root";
$password="test";  
$hostname="localhost";

$dbh = mysqli_connect($hostname, $username, $password) 
	or die("Unable to connect to database");

mysqli_select_db($dbh,$dbname);
mysqli_query($dbh,"SET NAMES 'utf8'");
mysqli_query($dbh,'SET CHARACTER SET utf8');
?>