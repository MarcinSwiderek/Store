<?php 
require_once ('connection.php');
require 'vendor/autoload.php';
include dirname(__FILE__) . '/vendor/altorouter/altorouter/AltoRouter.php';
include ('./class/item.php');
include ('./class/category.php');


header("Content-Type: text/html");


$router=new AltoRouter();
$router->setBasePath('/store');
$router->map('GET','/test2','test.php');
$router->map('GET','/panel/test','test.php');
/*function __autoload($className) {
	include ("'./class/'.$className.'.php'");
}*/



?>
<!DOCTYPE html>
<html>
	<head>
		
		<meta charset="UTF-8">
		<title>Store</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script src="/store/js/bootstrap.min.js"></script>
		<link href="/store/css/bootstrap.min.css" rel="stylesheet">
	</head>
	<body>
			
	
			<div class="container-fluid">
			Zawartosc kontenera
				<div class="row">
					<div class="col-md-12">
					menu
					</div>
				
				</div>
				<div class="row">
					<div class="col-md-3">
					pierwsza kol
					<?php
					
					
					//$gruszka->createItem('gruszka1', 1.99, 'owoc ', 'test', $conn);
					//$pomidor=new item();
					//$pomidor->loadItem('pomidor', $conn);
					$kategoria=new category();
					$kategoria->createCategory('testowakat', $conn);
										
					?>					
					</div>
					<div class="col-md-6">
					druga kol 
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
					<div class="col-md-3">
					trzecia kol
					
					</div>			
				
				</div>
			
			
	
			</div>
		</main>
		
	</body>

</html>
<?php $conn->close(); $conn=null;?>
