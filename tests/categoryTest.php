<?php
require_once ("/home/marcinswiderek/public_html/store/class/category.php");

class categoryTest extends PHPUnit_Extensions_Database_TestCase {
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
		categoryTest::$conn = new mysqli('localhost','root','password','StoreTest');

	}
	public static function tearDownAfterClass() {
		categoryTest::$conn->close();
		categoryTest::$conn=NULL;
	}
	public function testCRUDCategory(){
		$cat = new category();
		$cat->name = "My Test Category";
		$cat->id =null;
	
		$cat->createCategory(categoryTest::$conn);
		$this->assertNotNull($cat->id);
	
		$cat2 = new category();
		$cat2->loadCategory($cat->name, categoryTest::$conn);
		$this->assertEquals($cat->id, $cat2->id);
	
		$cat3 = new category();
		$cat3->loadCategory($cat->name, categoryTest::$conn);
		$this->assertEquals($cat3->name, $cat->name);
	
		$cat3->removeCategory(categoryTest::$conn);
		$this->assertEquals($cat3->id,NULL);
		$this->assertEquals($cat3->name,NULL);
	
		$cat3->loadCategory($cat3->name, categoryTest::$conn);
		$this->assertEquals($cat3->id,NULL);
	}
	
	
}