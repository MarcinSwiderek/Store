<?php
require_once ("/home/marcinswiderek/public_html/store/class/order.php");


class orderTest extends PHPUnit_Extensions_Database_TestCase {
	public static $conn;

	public function getConnection() {
		$conn=new PDO($GLOBALS['DB_DSN'],
				$GLOBALS['DB_USER'],
				$GLOBALS['DB_PASSWD'] );
		return new PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection
		($conn,$GLOBALS['DB_DBNAME']);
	}
	public function getDataSet() {
		$dataFlatXML = $this->createFlatXmlDataSet('./tests/orders.xml');
		return $dataFlatXML;
	}
	public static function setUpBeforeClass() {
		orderTest::$conn = new mysqli('localhost','root','password','StoreTest');

	}
	public static function tearDownAfterClass() {
		orderTest::$conn->close();
		orderTest::$conn=NULL;
	}
	public function testCRUDorder(){
		$order=new order();
		
		$order->id=NULL;
		$order->date=NULL;
		$order->status=NULL;
		$order->user_id=NULL;
		
		$order->createOrder(1, orderTest::$conn);
		
		$this->assertNotNull($order->id);
		$this->assertNotNull($order->date);
		$this->assertNotNull($order->status);
		$this->assertNotNull($order->user_id);
		
		$loadedOrder=new order();
		
		$loadedOrder->loadOrderByID($order->id, orderTest::$conn);
		
		$this->assertEquals($order->id,$loadedOrder->id);
		//$this->assertEquals($order->date,$loadedOrder->date);
		$this->assertEquals($order->status,$loadedOrder->status);
		$this->assertEquals($order->user_id,$loadedOrder->user_id);
		
	    $loadedOrder->removeOrder($loadedOrder->id, orderTest::$conn);
	    
	    $this->assertNull($loadedOrder->id);
	    $this->assertNull($loadedOrder->user_id);
	    $this->assertNull($loadedOrder->status);
	    $this->assertNull($loadedOrder->date);
		
	}	
	
	
}