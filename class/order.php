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
	
	
	
	
	
	
}