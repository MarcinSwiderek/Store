<?php
class user {
	public    $id;
	public    $email;
	public    $name;
	public    $address;
	protected $password;
	
	public function createUser($user_id,$user_email,$user_name,$user_address,$user_password,$conn){
		$sql="INSERT INTO Users VALUES "
	}
	public function removeUser($conn){
		
	}
	public function changeData($userid,$conn) {
		
	}
	public function getUserById($userid,$conn){
		
	}
	public function authenticate() {
		
	}
	public function getAllOrders() {
		
	}
	public function getAllUsers() {
		
	}
	
	
	
	
	
}