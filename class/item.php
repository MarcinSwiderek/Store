<?php
/*Class item {
	public $id;
	public $name;
	public $price;
	public $description;
	public $category;
	

	public function createItem($newName,$newPrice,$newDescription,$newCategory, $conn) { //działa bez walidacji
		
		$sql="SELECT * FROM Items WHERE item_name='$newName'";
		$res=$conn->query($sql);
		if($res->num_rows > 0) {
			return null;
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
			else return null;
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
		else return null;
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
			$this->category    = $row['item_category_id'];
		}
		else return null;
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
		else return null;
		
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
*/
class item {
	private $id;
	private $name;
	private $price;
	private $description;
	private $category;
	
	public function __construct($newID,$newName,$newPrice,$newDescription,$newCategory){
		$this->id=$newID;
		$this->name=$newName;
		$this->price=$newPrice;
		$this->description=$newDescription;
		$this->category=$newCategory;
	} 
	public static function createItem($newName,$newPrice,$newDescription,$newCategory,$conn) {
		$sql="SELECT * FROM Items WHERE item_name=$newName";
		$result=$conn->query($sql);
		if($result->num_rows == 0) {
			$sql="INSERT INTO Items(item_name,item_price,item_description,item_category) VALUES 
									('$newName','$newPrice','$newDescription','$newCategory')";
			if($conn->query($sql) === TRUE){
				return new item($conn->insert_id,$newName,$newPrice,$newDescription,$newCategory);
			}
		}
		return null;
	}
	public static function getItem($id,$conn) {
		$sql="SELECT * FROM Items WHERE item_id=$id";
		$result=$conn->query($sql);
		if($result->num_rows == 1) {
			$itemData=$result->fetch_assoc();
			return new item($itemData['item_id'],$itemData['item_name'],$itemData['item_price'],$itemData['item_description'],$itemData['item_category']);	 
		}
		return -1;
	}
	public static function deleteItem(item $toDelete,$conn){
		$sql="DELETE FROM Items WHERE item_id=$toDelete->getID()";
		if($conn->query($sql)===TRUE) {
			return true;
		}
		return false;
	}
	public static function getAllItems(){
		$ret=array();
		$sql="SELECT item_id FROM Items";
		$result=$conn->query($sql);
		if($result->num_rows > 0) {
			while($row=$result->fetch_assoc()) {
				$item=item::getItem($row['item_id'], $conn);
				array_push($ret, $item);
			}
			return $ret;
		}
		return null;
		
	}
	public static function getItemInfo($id,$conn){
		$sql="SELECT * FROM Items WHERE item_id=$id";
		$result=$conn->query($sql);
		if($result->num_rows=1) {
			return $result->fetch_assoc();
		}
		return null;
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
	public function getID() {
		return $this->id;
	}
	public function getName(){
		return $this->name;
	}
	public function getPrice() {
		return $this->price;
	}
	public function getDescription(){
		return $this->description;
	}
	public function getCategory(){
		return $this->category;
	}
	public function setName($newName){
		$this->name=$newName;
	}
	public function setPrice($newPrice){
		$this->price=$newPrice;
	}
	public function setDescription($newDescription){
		$this->description=$newDescription;
	}
	public function setCategory($newCategory){
		$this->category=$newCategory;
	}
	public function setToDB($conn){
		$sql="UPDATE Items SET item_name='$this->name',item_price=$this->price,item_description='$this->description',item_category=$this->category";
		return $conn->query($sql);
	}
	 
}

?>