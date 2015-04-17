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
	public function testCRUDUsers() {
		$usr=new user();
		
	    $returned = $usr->createUser('test@test.pl','haslo','Jan Kowalski','Willowa 7' , itemTest::$conn);
		$this->assertEquals(true, $returned);
	    
	    $this->assertEquals($usr->email,'test@test.pl');
		$this->assertEquals($usr->name,'Jan Kowalski');
		$this->assertEquals($usr->address,'Willowa 7');
		
		$loadedusr=new user();
		$loadedusr->loadUser($usr->id, itemTest::$conn);
		
		$this->assertEquals($loadedusr->name,$usr->name);
		$this->assertEquals($loadedusr->id,$usr->id);
		$this->assertEquals($loadedusr->email,$usr->email);
		$this->assertEquals($loadedusr->address,$usr->address);
		
		$changedusr=new user();
		$changedusr->loadUser($loadedusr->id, itemTest::$conn);
		
		$changedusr->name='Janusz Kowalski';
		$changedusr->email='Janusz@test.pl';
		$changedusr->address='Wiejska 5';
		
		$this->assertEquals($changedusr->id,$loadedusr->id);
		$this->assertNotEquals($changedusr->name,$loadedusr->name);
		$this->assertNotEquals($changedusr->email,$loadedusr->email);
		$this->assertNotEquals($changedusr->address,$loadedusr->address);
		
		$changedusr->removeUser(itemTest::$conn);
		
		$this->assertNull($changedusr->id);
		$this->assertNull($changedusr->name);
		$this->assertNull($changedusr->address);
		$this->assertNull($changedusr->email);
		
		
		
	}
}