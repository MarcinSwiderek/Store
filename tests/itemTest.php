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
		$dataFlatXML = $this->createFlatXmlDataSet('./tests/items.xml');
		return $dataFlatXML;
	}
	public static function setUpBeforeClass() {
		itemTest::$conn = new mysqli('localhost','root','password','StoreTest');
		
	}
	public static function tearDownAfterClass() {
		itemTest::$conn->close();
		itemTest::$conn=NULL;
	}
	
	public function testCRUDItems() {
		$cat=new category();
		$cat->name="My Test Category";
		$cat->id=null;
		
		$cat->createCategory(itemTest::$conn);
		$this->assertNotNull($cat->id);
		
		$myitem=new item();
		$myitem->createItem('orzech', 3.99, 'twardy orzech do zgryzienia', 'My Test Category', itemTest::$conn);
		$this->assertEquals($myitem->category,$cat->id); //id w obiekcie item oraz w obiekcie category się zgadzają
		//$this->assertEquals($myitem->id,3); 
		
		$loadeditem=new item();
		$loadeditem->loadItem('orzech', itemTest::$conn);
		$this->assertEquals($loadeditem->id,$myitem->id);
		$this->assertEquals($loadeditem->name,$myitem->name);
		$this->assertEquals($loadeditem->category,$myitem->category);
		$this->assertEquals($loadeditem->price,$myitem->price);
		$this->assertEquals($loadeditem->description,$myitem->description);
		/*
		$loadeditem->name='orzech laskowy';
		$loadeditem->changeData(itemTest::$conn);
		
		$changeditem= new item();
		$changeditem->loadItem('orzech laskowy', itemTest::$conn);
		$this->assertNotNull($changeditem->name);
		$this->assertNotEquals($changeditem->name,$myitem->name);
		$this->assertEquals($changeditem->category,$loadeditem->category);
		$this->assertEquals($changeditem->description,$loadeditem->description);
		$this->assertEquals($changeditem->price,$loadeditem->price);
		$this->assertEquals($changeditem->id,$loadeditem->id);
		*/
		$changeditem=new item();
		$changeditem->loadItem($loadeditem->name, itemTest::$conn);
		
		$changeditem->name='orzech laskowy';
		$changeditem->price=3.66;
		$changeditem->description='Opis orzecha laskowego';
		$changeditem->category=2;
		$changeditem->changeData(itemTest::$conn);
		
		$this->assertEquals($changeditem->id,$loadeditem->id);
		$this->assertNotEquals($changeditem->name,$loadeditem->name);
		$this->assertNotEquals($changeditem->description,$loadeditem->description);
		$this->assertEquals($changeditem->category,$loadeditem->category);
		$this->assertNotEquals($changeditem->price,$loadeditem->price);
		
	
		
		
		
		
		$changeditem->removeItem(itemTest::$conn);
		$this->assertNull($changeditem->id);
		$this->assertNull($changeditem->name);
		$this->assertNull($changeditem->description);
		$this->assertNull($changeditem->price);
		$this->assertNull($changeditem->category);
		
		
	}
	
}