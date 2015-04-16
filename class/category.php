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
		
		$sql="INSERT INTO Categories(category_name) VALUES ('".$newName."')";
		$result=$conn->query($sql);
		}
	}
	
	
	
	
	
	
	
	
	
	
}