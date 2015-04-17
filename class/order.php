<?php
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
	    
	    $this->id=$conn->insert_id;
		$this->status=0;
		$this->user_id=$user_id;
		$this->date=$date;
		
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
		else return false;
		
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
				$order=$this->loadOrderByID($row['order_id'], $conn);
				array_push($ordArr, $order);
			}
		}
		else return false;
		
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
		else return false;
		
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
		else return false;
		
		return $price;
	}
	
	
	
	
	
}















