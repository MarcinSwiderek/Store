<?php
Class item {
	public $id;
	public $name;
	public $price;
	public $description;
	public $category;
	

	public function createItem($newName,$newPrice,$newDescription,$newCategory, $conn) { //działa bez walidacji
		
		$sql="SELECT * FROM Items WHERE item_name='$newName'";
		$res=$conn->query($sql);
		if($res->num_rows > 0) {
			return false;
		}
		else {
			
			
			
			$sql="SELECT category_id,category_name FROM Categories WHERE Categories.category_name='".$newCategory."'";
			$result=$conn->query($sql);
			if($result->num_rows > 0) {
				$this->name=$newName;
				$this->price=$newPrice;
				$this->description=$newDescription;
				$row=$result->fetch_assoc();
				$cat=$row['category_id'];
				$this->category=$cat;
				$sql='Insert INTO Items(item_name,item_price,item_description,item_category_id) VALUES ("'.$newName.'",'.$newPrice.',"'.$newDescription.'",'.$cat.')';
				$result=$conn->query($sql);
				$this->id=$conn->insert_id;
				
			}
			else return false;
		}
	}
	public function removeItem($conn){ //działa
		
		$sql="DELETE FROM Items WHERE item_id=$this->id";
		$result=$conn->query($sql);
		$this->id=NULL;
		$this->name=NULL;
		$this->price=NULL;
		$this->description=NULL;
		$this->category=NULL;
		
	}
	public function changeData($conn) {
		$sql="UPDATE Items SET
							item_name='$this->name',
							item_price=$this->price,
							item_description='$this->description',
							item_category_id='$this->category'
																WHERE item_id=$this->id";
		$result=$conn->query($sql);
	}
	public function getItemData($itemName,$conn) { 
		$sql="SELECT * FROM Items WHERE item_name='$itemName'";
		
		$result=$conn->query($sql);
		if($result->num_rows > 0) {
			$row=$result->fetch_assoc();
			return array (
					'id'          =>$row['item_id'],
					'name'        =>$row['item_name'],
					'description' =>$row['item_description'],
					'price'       =>$row['item_price'],
					'category' 	  =>$row['category_id'] //trzeba połączyć z Categories w selekcie wyżej
			);
		}
		else return false;
	}
	public function loadItem($itemName,$conn) { //działa
		$sql="SELECT * FROM Items WHERE item_name='$itemName'";
		
		$result=$conn->query($sql);
		if($result->num_rows > 0) {
			$row=$result->fetch_assoc();
			
			$this->id          = $row['item_id'];
			$this->name        = $row['item_name'];
			$this->description = $row['item_description'];
			$this->price       = $row['item_price'];
		}
		else return false;
	}
	
	public function printInformation() { //działa
		echo 'item_id: '.$this->id.', item_name: '.$this->name.', item_price: '.$this->price.', item_description: '.$this->description;
		
	}
	public function getPicturesIDs($conn) {
		$sql="SELECT * FROM Pictures WHERE picture_user_id=$this->id";
		echo $sql;
		$result=$conn->query($sql);
		$retArr=array();
		if($result->num_rows > 0) {
			while($row=$result->fetch_assoc()) {
				array_push($retArr, $row['picture_id']);	
			}
		}
		else return false;
		
		return $retArr;
	} 
	public function addPicture($fileDir,$conn) {
		$sql="INSERT INTO Pictures(picture_path,picture_item_id) VALUES ('$fileDir',$this->id)";
		//$result=$conn->query($sql);
		echo ($sql); 	//wersja testowa	
	}
	public function delPicture($id,$conn) {
		$sql="DELETE FROM Pictures WHERE picture_id=$id";
		$result=$conn->query($sql);
	}
	public function getName(){
		return $this->name;
	}
	
}
?>