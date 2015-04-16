<?php
Class item {
	public $id;
	public $name;
	public $price;
	public $description;
	

	public function createItem($newName,$newPrice,$newDescription,$newCategory, $conn) {
		
		$sql="SELECT * FROM Items WHERE item_name='$newName'";
		$res=$conn->query($sql);
		if($res->num_rows > 0) {
			return false;
		}
		else {
			//sprawdzenie czy element o danej nazwie istnieje
			
			
			$sql="SELECT category_id,category_name FROM Categories WHERE Categories.category_name='".$newCategory."'";
			$result=$conn->query($sql);
			if($result->num_rows > 0) {
				$this->name=$newName;
				$this->price=$newPrice;
				$this->description=$newDescription;
				$row=$result->fetch_assoc();
				$cat=$row['category_id'];
			
				$sql='Insert INTO Items(item_name,item_price,item_description,item_category_id) VALUES ("'.$newName.'",'.$newPrice.',"'.$newDescription.'",'.$cat.')';
				$result=$conn->query($sql);
				$this->id=$conn->insert_id;
				
			}
			else return false;
		}
	}
	public function removeItem(){
		
		$sql="DELETE FROM Items WHERE item_id=$this->id";
		$result=$conn->query($sql);
		$this->id=NULL;
		$this->name=NULL;
		$this->price=NULL;
		$this->description=NULL;
		
	}
	public function getItem($itemName,$conn) {
		$sql="SELECT * FROM Items WHERE item_name='$itemName'";
		
		$result=$conn->query($sql);
		if($result->num_rows > 0) {
			$row=$result->fetch_assoc();
			return array (
					'id'          =>$row['item_id'],
					'name'        =>$row['item_name'],
					'description' =>$row['item_description'],
					'price'       =>$row['item_price']
			);
		}
		else return false;
	}
	public function loadItem($itemName,$conn) {
		$sql="SELECT * FROM Items WHERE item_name='$itemName'";
		
		$result=$conn->query($sql);
		if($result->num_rows > 0) {
			$row=$result->fetch_assoc();
			$this->id          = $row['item_id'];
			$this->name        = $row['item_name'];
			$this->description = $row['item_description'];
			$this->price       = $row['item_price'];
		}
	}
	
	public function printInformation() {
		echo 'item_id: '.$this->id.', item_name: '.$this->name.', item_price: '.$this->price.', item_description: '.$this->description;
		
	}
	public function getPictures() {
		
	} 
	public function addPicture() {
		
	}
	public function delPicture() {
	
	}
	
}
?>