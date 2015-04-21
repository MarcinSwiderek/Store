<?php
require_once ("/home/marcinswiderek/public_html/store/class/user.php");

class userTest extends PHPUnit_Extensions_Database_TestCase {
	public static $conn;
	
	public function getConnection() {
		$conn=new PDO($GLOBALS['DB_DSN'],
				$GLOBALS['DB_USER'],
				$GLOBALS['DB_PASSWD'] );
		return new PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection
		($conn,$GLOBALS['DB_DBNAME']);
	}
	public function getDataSet() {
		$dataFlatXML = $this->createFlatXmlDataSet('./tests/items.xml');
		return $dataFlatXML;
	}
	public static function setUpBeforeClass() {
		userTest::$conn = new mysqli('localhost','root','password','StoreTest');
	
	}
	public static function tearDownAfterClass() {
		userTest::$conn->close();
		userTest::$conn=NULL;
	}
	
	public function testCRUDUsers() {
		$user=user::CreateUser('a@b.c', 'pass', 'Jan Kowalski', 'Kowalska 8', userTest::$conn);
		
		$this->assertEquals($user->getID(),'2');
		$this->assertEquals($user->getName(),'Jan Kowalski');
		$this->assertEquals($user->getAddress(),'Kowalska 8');
		$this->assertEquals($user->getEmail(),'a@b.c');
		
		$user=user::DeleteUser($user, 'pass', userTest::$conn);
		$this->assertTrue($user);
	
	
	}
	
	
	
}