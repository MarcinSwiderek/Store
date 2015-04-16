<?php 
header("Content-Type: text/html");
require 'vendor/autoload.php';
include dirname(__FILE__) . '/vendor/altorouter/altorouter/AltoRouter.php';
$router=new AltoRouter();
$router->setBasePath('/store');
$router->map('GET','/test2','test.php');
$router->map('GET','/panel/test','test.php');



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
		<header>
			Tutaj menu
		</header>	
		<main>
			<div class="container-fluid">
			Zawartosc kontenera
				<div class="row">
					<div class="col-md-3">
					pierwsza kol
					
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
		<footer>
		
		</footer>
	</body>

</html>
