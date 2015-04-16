<?php
Class category {
	public $id;
	public $name;
	
	public function createCategory($newName,$conn) {
		$sql="SELECT * FROM Categories WHERE category_name='$newName'";
		$res=$conn->query($sql);
		if($res->num_rows > 0) {
			return false;
		}
		else {
			$this->name=$newName;
			$sql="INSERT INTO Categories(category_name) VALUES ('".$newName."')";
			$result=$conn->query($sql);
			$this->id=$conn->insert_id;
		}
	}
	
	public function removeCategory($conn) {
		$sql="DELETE FROM Categories WHERE category_id=$this->id";
		$result=$conn->query($sql);
		$this->id=NULL;
		$this->name=NULL;
	}
	
	public function loadCategory($categoryName,$conn) { 
		$sql="SELECT * FROM Categories WHERE category_name='$categoryName'";
		$result=$conn->query($sql);
		if($result->num_rows > 0) {
			$row=$result->fetch_assoc();
			$this->id=$row['category_id'];
			$this->name=$row['category_name'];
		}
	}
	
	public function removeCategoryByName($name,$conn) { //prawie działa ,problem z foreign keyem
		$sql="DELETE FROM Categories WHERE category_name='$name'";
		echo $sql;
		//$result=$conn->query($sql);
		$item=$this->loadCategory($name, $conn);
		$item->id=NULL;
		$item->name=NULL;		
		//wczytanie kategorii i usuniecie
	}
	public function getAllItemsIDs($conn){
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
	
}