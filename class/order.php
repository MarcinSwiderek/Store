<?php
/*
class order {
	public $id;
	public $status;
	public $user_id;
	public $date;
	//itemy ?
	
	public function createOrder($user_id,$conn) {
		
	    $date=date('Y-m-d');
	  
		$sql="INSERT INTO Orders(order_status,order_user_id,order_date) 
						VALUES   (0,$user_id,$date)";
		$conn->query($sql);
	    
	    $this->id		=	$conn->insert_id;
		$this->status	=	0;
		$this->user_id	=	$user_id;
		$this->date		=	$date;
		
	}
	public function removeOrder($order_id,$conn) {
		$sql="DELETE FROM Orders WHERE order_id=$order_id";
		$result=$conn->query($sql);
		
		$this->id=NULL;
		$this->status=NULL;
		$this->date=NULL;
		$this->user_id=NULL;
	}
	public function loadOrderByID($order_id,$conn) {
		$sql="SELECT * FROM Orders WHERE order_id=$order_id";
		$result=$conn->query($sql);
		if($result->num_rows > 0) {
			$row=$result->fetch_assoc();
			$this->id			=	$row['order_id'];
			$this->status		=	$row['order_status'];
			$this->date			=	$row['order_date'];
			$this->user_id		=	$row['order_user_id'];
			
		}
		else return null;
		
	}
	
	public function setStatusOn($order_id,$conn) {
		$sql="UPDATE Orders SET order_status=1 WHERE order_id=$order_id";
		$result=$conn->query($sql);
	}
	
	public function setStatusOff($order_id,$conn) {
		$sql="UPDATE Orders SET order_status=0 WHERE order_id=$order_id";
		$result=$conn->query($sql);
	}
	public function addItem($item_id,$quantity=1,$conn) {
		$sql="INSERT INTO Orders_items(order_item_order_id,order_item_item_id,order_item_quantity) 
								VALUES ($this->id,$item_id,$quantity)";
		$result=$conn->query($sql);		
	}
	public function removeItem($item_id,$conn) {
		$sql="DELETE FROM Orders_items WHERE order_item_item_id=$item_id";
		$result=$conn->query($sql);
	}
	public static function getAll($conn){
		$sql="SELECT * FROM Orders";
		$result=$conn->query($sql);
			
		$ordArr=array();
		
		if($result->num_rows > 0) {
			while($row=$result->fetch_assoc()) {
				$order=order::loadOrderByID($row['order_id'], $conn);
				array_push($ordArr, $order);
			}
		}
		else return null;
		
		return $ordArr;
	}
	public function getAllItemsFromOrder($conn) {
		$sql="SELECT * FROM Orders JOIN Orders_items ON
					Orders.order_id=Orders_items.order_item_order_id 
					JOIN Items ON Items.item_id=Orders_items.order_item_item_id
					 WHERE order_id=$this->id";
		$result=$conn->query($sql);
		
		$itemsArr=array();
		
		if($result->num_rows > 0) {
			while($row=$result->fetch_assoc()) {
				$item=new item();
				$item->loadItem($row['item_name'], $conn);
				array_push($itemsArr,$item);
			}
		}
		else return null;
		
		return $itemsArr;
	}
	public function getWholePrice($conn){
		$sql="SELECT * FROM Orders JOIN Orders_items ON
					Orders.order_id=Orders_items.order_item_order_id 
					JOIN Items ON Items.item_id=Orders_items.order_item_item_id
					 WHERE order_id=$this->id";
		$result=$conn->query($sql);
		$price=0;
		if($result->num_rows > 0) {
			while($row=$result->fetch_assoc()) {
				$item=new item();
				$item->loadItem($row['item_name'], $conn);
				$price+=$item->price;
			}
		}
		else return null;
		
		return $price;
	}
	
	
	
	
	
}

*/
class order{
	private $id;
	private $status;
	private $user_id;
	private $date;
	
	public function __construct($newID,$newStatus,$newUser_ID,$newDate){
		$this->id-$newID;
		$this->status=$newStatus;
		$this->user_id=$newUser_ID;
		$this->date=$newDate;
	}
	public static function createOrder($newUser_id,$conn){
		 $date=date('Y-m-d');
		 $sql="INSERT INTO Orders(order_status,order_user_id,order_date) VALUES (0,$newUser_id,'$date')";
		 if($conn->query($sql)===TRUE) {
		 	return new order($conn->insert_id,0,$newUser_id,$date);
		 }
		 return null;
	}
	public static function deleteOrder(order $toDelete,$conn){
		$sql="DELETE FROM Orders WHERE order_id=$toDelete->getID()";
		if($conn->query($sql)===TRUE) {
			return true;
		} 
		return false;
	}
	public static function getOrder($orderID,$conn){
		$sql="SELECT * FROM Orders WHERE order_id=$orderID";
		$result=$conn->query($sql);
		if($result->num_rows==1) {
			$orderData=$result->fetch_assoc();
			return new order($orderData['order_id'], $orderData['order_status'], $orderData['order_user_id'], $orderData['order_date']);
			
		}
		return null;
    }
    public static function getAll($conn){
    	
    }
    public static function getAllByStatus(){
    	
    }
    public static function getAllItemsFromOrder(){
    	
    }
    public function getWholePrice() {
    	
    }
    public function getID() {
    	return $this->id;
    }
    public function getStatus() {
    	return $this->status;
    }
    public function getUserID() {
    	return $this->user_id;
    }
    public function setStatus($newStatus){
    	$this->status=$newStatus;
    }
    public function setUserID($newID) {
    	$this->user_id=$newID;
    }
    public function setToDB($conn){
    	$sql="UPDATE Orders SET order_status=$this->status,order_user_id=$this->user_id";
    	return $conn->query($sql);
    }
    
}













