<?php

/*
 * UWAGA ! KOLUMNA Z ADRESEM W BAZIE DANYCH 'Users' Nazywa się 'user_adres' , a nie 'user_address' 
 * 
 * 
 */
class user {
	public    $id;
	public    $email;
	public    $name;
	public    $address;
	protected $password;
	
	public function createUser($user_email,$user_password,$user_name,$user_address,$conn){
		$sql="SELECT * FROM Users WHERE user_email='$user_email'";
		$result=$conn->query($sql);
		if($result->num_rows > 0) {
			return false;
		}
		else {
			$sql="INSERT INTO Users(user_password,user_name,user_email,user_adres) VALUES 
			                       ('$user_password','$user_name','$user_email','$user_address')";
			$result=$conn->query($sql);
			$this->id		=	$conn->insert_id;
			$this->name		=	$user_name;
			$this->email	=	$user_email;
			$this->address	=	$user_address;
			$this->password	=	$user_password;
			return true;
		}
		
	}
	public function removeUser($conn){
		$sql="DELETE FROM Users WHERE user_id=$this->id";
		$conn->query($sql);
		
		$this->id=NULL;
		$this->email=NULL;
		$this->name=NULL;
		$this->address=NULL;
		$this->password=NULL;
	}
	public function changeData($conn) {
		$sql="UPDATE Users SET 
							user_name		=	'$this->name',
							user_email		=	'$this->email',
							user_password	=	'$this->password',
							user_adres		=	'$this->address'
														WHERE user_id=$this->id";
		$result=$conn->query($sql);
		
	}
	public function getUserDataById($userid,$conn){
		$sql="SELECT * FROM Users WHERE user_id=$userid";
		$result=$conn->query($sql);
		if($result->num_rows > 0) {
			$row=$result->fetch_assoc();
			return array( 
					'user_id' 		=>	$row['user_id'],
					'user_name'		=>	$row['user_name'],
					'user_email'	=>	$row['user_email'],
					'user_address'	=>	$row['user_adres']
					);
					//nie wiem czy hasło jest tu konieczne wiec nie zawarłem 
			
		}
		else return false;
	}
	public function loadUser($userid,$conn) {
		$sql="SELECT * FROM Users WHERE user_id=$userid";
		$result=$conn->query($sql);
		if($result->num_rows > 0) {
			$row=$result->fetch_assoc();
			
			$this->id			=	$row['user_id'];
			$this->name			=	$row['user_name'];
			$this->email		=	$row['user_email'];
			$this->address		=	$row['user_adres'];
			$this->password		=	$row['user_password'];
		}
		else return false;
	}
	public function authenticate($user_email,$user_pass) {
		
	}
	public function getAllOrders($conn) {
		
	}
	public function getAllUsers($conn) {
		$sql="SELECT * FROM Users";
		$result=$conn->query($sql);
		$usersArr=array();
		if($result->num_rows > 0) {
			while($row=$result->fetch_assoc()) {
				$user=$this->loadUser($row['user_id'], $conn);
				array_push($usersArr, $user);
			}
		}
		else return false;
		
		return $usersArr;
		
	}
	public function getName(){
		return $this->name;
	}
	
	
	
	
	
}