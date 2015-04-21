<?php 
require_once ('connection.php');
require 'vendor/autoload.php';
include dirname(__FILE__) . '/vendor/altorouter/altorouter/AltoRouter.php';
include ('./class/item.php');
include ('./class/category.php');
include ('./class/user.php');
include ('./class/order.php');
session_start();

header("Content-Type: text/html");


$router=new AltoRouter();
$router->setBasePath('/store');
$router->map('GET','/test2','test.php');
$router->map('GET','/panel/test','test.php');
$router->map('GET','/register2','register.php');
$router->map('GET','/admin2','admin.php');
$router->map('POST','/registercheck','register.php');
$router->map('GET','/main','index.php');
$router->map('GET','/logout2','logout.php');
$router->map('GET','/category/{i:id}','showCategory.php');
$router->map('POST','/category/{i:id}','showCategory.php')
/*function __autoload($className) {
	include ("'./class/'.$className.'.php'");
}*/



?>
<!DOCTYPE html>
<html lang="pl-PL">
	<head>
		
		<meta charset="UTF-8">
		<title>Store</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script src="/store/js/bootstrap.min.js"></script>
		<link href="/store/css/bootstrap.min.css" rel="stylesheet">
	</head>
	<body>
			
	
			<div class="container-fluid">
			
				<div class="row">
					<div class="col-md-12 text-center"><!-- Miejsce na nawigacje -->
						
						<a href="/store/index.php">Strona główna</a>
						<a href="/store/koszyk2">Koszyk</a>
						<a href="/store/user2">Użytkownik</a>
						<a href="/store/kontakt2">Kontakt</a>
						<a href="/store/onas2">O nas</a>
						<a href="/store/logout.php">Wyloguj</a>
						<?php if(!isset($_SESSION['user_id'])) {?>
						<a href="/store/register2">Zarejestruj się</a>
						<a href="/store/admin2">Admin</a>
						
						<?php }?>
				
					</div>
				
				</div>
				<div class="row">
					<div class="col-md-2">
						
						<ul class="list-group text-left">
						<?php
							$categories=category::getAllCategories($conn);
							foreach($categories as $category){
								$count=category::countItems($category['category_id'], $conn);
								echo "<li class='list-group-item'>
										<span class='badge'>".$count."</span>
										<a href='/store/category/{$category['category_id']}'>".$category['category_name']."</a>
										</li>		";
							}
							
						
						?>	
						</ul>				
					</div>
					<div class="col-md-8">
					druga kol , zmienna zawartość
					<?php 
					$match=$router->match();
					if($match) {
						require $match['target'];
					}
					else {
						header("HTTP/1.0 404 Not Found");
					}
					?>
					</div>
					<div class="col-md-2">
					logowanie/koszyk
					<?php 
					if(!isset($_SESSION['user_id'])){
					?>
					<form method="post" action="/store/login.php">
						<fieldset>
							<legend>Zaloguj się</legend>
							<label>Email:</label><br>
							<input type="email" name="email" class="form-control"><br>
							<label>Hasło:</label><br>
							<input type="password" name="password" class="form-control"><br>
							<button type="submit" name="loginbutton">Zaloguj!</button>
						</fieldset>
					</form>
					<?php }?>
					
					</div>			
				
				</div>
			
			
	
			</div>
	
	</body>

</html>
<?php $conn->close(); $conn=null;?>
