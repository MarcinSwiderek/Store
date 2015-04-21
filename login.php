<?php
require_once ('connection.php');
include ('./class/item.php');
include ('./class/category.php');
include ('./class/user.php');
include ('./class/order.php');
session_start();
if($_SERVER['REQUEST_METHOD']==="POST") {
	if(isset($_POST['email']) && isset($_POST['password'])) {
		$email=trim($_POST['email']);
		$pass=trim($_POST['password']);
	
		$email=addslashes($email);
		$pass=addslashes($pass);
		echo $email."<br>".$pass;
		$user=user::AuthenticateUser($email, $pass, $conn);
		if(user::AuthenticateUser($email, $pass, $conn)) {
			$_SESSION['user_id']=$user->getID();
			$_SESSION['user_name']=$user->getName();
			$_SESSION['user_email']=$user->getEmail();
			header("Location: /store/index.php");
		}
		else echo "Błąd logowania!";
	}
	else header("Location: /store/index.php");
	
}
else header("Location: /store/index.php");
