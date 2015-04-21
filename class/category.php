<?php
/*
Class category {
	public $id;
	public $name;
	
	public function createCategory($conn) { //działa bez walidacji
		$sql="SELECT * FROM Categories WHERE category_name='{$this->name}'";
		$res=$conn->query($sql);
		if($res->num_rows > 0) {
			return null;
		}
		else {
			$sql="INSERT INTO Categories(category_name) VALUES ('".$this->name."')";
			$result=$conn->query($sql);
			$this->id=$conn->insert_id;
		}
	}
	
	public function removeCategory($conn) { //działa podstawowo bez walidacji
		
		$itemsIDsTab=$this->getAllItemsIDs($conn);
		 //pobranie wszystkich id itemów z bieżącej kategorii
		foreach($itemsIDsTab as $id) { 
			//łączę items oraz categories na bieżącym id
			$sql="SELECT * FROM Items JOIN Categories ON Categories.category_id=Items.item_category_id WHERE Items.item_id=$id";
			
			$result=$conn->query($sql);	
			if($result->num_rows > 0) {
				$row=$result->fetch_assoc();
				$itemName=$row['item_name'];
				
				$item=new item();
				$item->loadItem($itemName, $conn);
				
				var_dump($item);
				$item->category='other'; //zmieniam category na obiekcie na 'other'
				$sql2="UPDATE Items SET item_category_id=9 WHERE item_id=$id"; //zmieniam rubrykę w bazie danych na 'other'
				$res=$conn->query($sql2);
				
			}	
		}
		
		
		$sql="DELETE FROM Categories WHERE category_id=$this->id";
		$result=$conn->query($sql);
		$this->id=NULL;
		$this->name=NULL;
		
	}
	
	public function loadCategory($categoryName,$conn) { //działa
		$sql="SELECT * FROM Categories WHERE category_name='$categoryName'";
		$result=$conn->query($sql);
		if($result->num_rows > 0) {
			$row=$result->fetch_assoc();
			$this->id=$row['category_id'];
			$this->name=$row['category_name'];
		}
	}
	
	public function removeCategoryByName($name,$conn) { //prawie działa ,problem z foreign keyem,ale da sie poprzez metode removeCategory
		$sql="DELETE FROM Categories WHERE category_name='$name'";
		echo $sql;
		//$result=$conn->query($sql);
		$item=$this->loadCategory($name, $conn);
		$item->id=NULL;
		$item->name=NULL;		
		//wczytanie kategorii i usuniecie
	}
	public function getAllItemsIDs($conn){ //działa
		$sql="SELECT * FROM Items JOIN Categories ON Items.item_category_id=Categories.category_id WHERE Categories.category_id=$this->id";
		$result=$conn->query($sql);
		$ItemArr=array();
		
		if($result->num_rows > 0) {
			while($row=$result->fetch_assoc()) {
					$id=$row['item_id'];	
				array_push($ItemArr,$id);
			}
		}
		return $ItemArr;
	}
	public function getName(){
		return $this->name;
	}
	
}
*/


class category{
	private $id;
	private $name;
	
	public function __construct($newID,$newName){
		$this->id=$newID;
		$this->name=$newName;
	}
	public static function createCategory($newName,$conn){
		$sql="SELECT * FROM Categories WHERE category_name='$newName'";
		$result=$conn->query($sql);
		if($result->num_rows == 0) {
			$sql="INSERT INTO Categories(category_name) VALUES ('$newName')";
			if($conn->query($sql) === TRUE){
				return new category($conn->insert_id,$newName);
			} 
		}
		return null;
	}
	public static function deleteCategory(category $toDelete,$conn){
		$DEFAULT_CATEGORY_ID=9;
		
		$sql="SELECT * FROM Items WHERE item_category_id=$toDelete->getID()";
		$result=$conn->query($sql);
		if($result->num_rows > 0) {
			while($row=$result->fetch_assoc()) {
				$item=item::getItem($row['item_id'], $conn);
				$item->setCategory($DEFAULT_CATEGORY_ID);
				$item->setToDB($conn);
			}
		}
		$sql="DELETE FROM Categories WHERE category_id=$toDelete->getID()";
		if($conn->query($sql)===TRUE){
			return true;
		}
		return false;
	}
	public static function getCategory($id,$conn){
		$sql="SELECT * FROM Categories WHERE category_id=$id";
		$result=$conn->query($sql);
		if($result->num_rows == 1) {
			$categoryData=$result->fetch_assoc();
			return new category($categoryData['category_id'],$categoryData['category_name']);
		}
		return -1;
	}
	public function getName(){
		return $this->name;
	}
	public function getID(){
		return $this->id;
	}
	public function setName($newName){
		$this->name=$newName;
	}
	public function getAllItems(){
		$sql="SELECT * FROM Items WHERE item_category_id=$this->id";
		$result=$conn->query($sql);
		
	}
	public function setToDB($conn) {
		$sql="UPDATE Categories set category_name='$this->name' WHERE category_id=$this->id";
		return $conn->query($sql);
	}
}