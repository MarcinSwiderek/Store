<?php
require_once ("/home/marcinswiderek/public_html/store/class/item.php");
require_once ("/home/marcinswiderek/public_html/store/class/category.php");
require_once ("/home/marcinswiderek/public_html/store/class/user.php");
class itemTest extends PHPUnit_Extensions_Database_TestCase {
	public static $conn;
	
	public function getConnection() {
		$conn=new PDO($GLOBALS['DB_DSN'],
					  $GLOBALS['DB_USER'],
					  $GLOBALS['DB_PASSWD'] );
		return new PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection
												($conn,$GLOBALS['DB_DBNAME']);
	}
	public function getDataSet() {
		$dataFlatXML = $this->createFlatXmlDataSet('items.xml');
		return $dataFlatXML;
	}
	public static function setUpBeforeClass() {
		itemTest::$conn = new mysqli('localhost','root','password','StoreTest');
		
	}
	public static function tearDownAfterClass() {
		itemTest::$conn->close();
		itemTest::$conn=NULL;
	}
	public function testCRUDCategory(){
		$cat = new category();
		$cat->name = "My Test Category";
		$cat->id =null;
		
		$cat->createCategory(itemTest::$conn);
		$this->assertNotNull($cat->id);		
		
		$cat2 = new category();
		$cat2->loadCategory($cat->name, itemTest::$conn);
		$this->assertEquals($cat->id, $cat2->id);
		
		$cat3 = new category();
		$cat3->loadCategory($cat->name, itemTest::$conn);
		$this->assertEquals($cat3->name, $cat->name);
		
		$cat3->removeCategory(itemTest::$conn);
		$this->assertEquals($cat3->id,NULL);
		$this->assertEquals($cat3->name,NULL);
		
		$cat3->loadCategory($cat3->name, itemTest::$conn);
		$this->assertEquals($cat3->id,NULL);
	}
	
	
}