<?php
$servername="localhost";
$username="root";
$password="password";
$baseName="Store";

$conn=new mysqli($servername,$username,$password,$baseName);

if($conn->connect_error) {
	die('Połączenie nieudane. Błąd: '.$conn->connect_error);
}
//else echo "Połączenie udane";
?>