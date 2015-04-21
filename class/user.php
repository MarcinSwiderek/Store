<?php

/*
 * UWAGA ! KOLUMNA Z ADRESEM W BAZIE DANYCH 'Users' Nazywa się 'user_adres' , a nie 'user_address' 
 * 
 * 
 */


 
class user {
	private $id;
	private $email;
	private $name;
	private $address;
	private $password;
	
	public function __construct($newID,$newName,$newEmail,$newAddress,$password){
		$this->id=$newID;
		$this->name=$newName;
		$this->email=$newEmail;
		$this->address=$newAddress;
		$this->password=$password;
	}
	
	public static function CreateUser($userMail,$password,$name,$address,$conn) {
		$sql="SELECT * FROM Users WHERE user_email='$userMail'";
		$result=$conn->query($sql);
		if($result->num_rows == 0) {
			/*$options= [
					'cost' => 11,
					'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM)
			];*/
			
			$hashed_password=password_hash($password, PASSWORD_BCRYPT);
			$sql="INSERT INTO Users(user_name,user_email,user_password,user_adres) VALUES ('$name','$userMail','$hashed_password','$address')";
			if($conn->query($sql) === TRUE) {
				return new user($conn->insert_id,$name,$userMail,$address,$hashed_password);
			}
			
		}
		return null;
	}
	public static function GetUser($id,$conn) {
		$sql="SELECT * FROM Users WHERE user_id=$id";
		$result=$conn->query($sql);
		if($result->num_rows == 1) {
			$userData=$result->fetch_assoc();
			return new user($userData['user_id'],$userData['user_name'],$userData['user_email'],$userData['user_adres'],$userData['user_password']);
		}
		return -1;
	}
	
	public static function DeleteUser(user $toDelete,$password,$conn) {
		if($toDelete->authenticate($password)) {
			$sql="DELETE FROM Users WHERE user_id={$toDelete->getID()}";
			if($conn->query($sql)===TRUE) {
				return true;
			}
		}
		return false;
	}
	public static function AuthenticateUser($userMail,$password,$conn) {
		$sql="SELECT * FROM Users WHERE user_email='$userMail'";
		$result=$conn->query($sql);
		if($result->num_rows !=1 ) {
			$userData=$result->fetch_assoc();
			$user= new user($userData['user_id'],$userData['user_name'],$userData['user_email'],$userData['user_adres'],$userData['user_password']);
		
			if($user->authenticate($password)){
				return $user;
			}
		}
		return null;
	}
	public static function GetAllUserNames($conn){
		$ret=array();
		$sql="SELECT user_id,user_email,user_name,user_adres FROM Users";
		$result=$conn->query($sql);
		if($result->num_rows < 0) {
			while($row=$result->fetch_assoc()) {
				$ret[]=$row;
			}
		}
		return $ret;
	}
	public static function GetUserInfo($id,$conn) {
		$sql="SELECT user_id,user_name,user_email,user_adres FROM Users WHERE id=$id";
		$result=$conn->query($sql);
		if($result->num_rows > 0){ 
			return $result->fetch_assoc();
		}
		return null;
	}
	public function getID(){
		return $this->id;
	}
	public function getName(){
		return $this->name;
	}
	public function getEmail() {
		return $this->email;
	}
	public function setName($newName) {
		$this->name=$newName;
	}
	public function setEmail($newEmail) {
		$this->email=$newEmail;
	}
	public function setAddress($newAddress){
		$this->address=$newAddress;
	}
	public function getAddress() {
		return $this->address;
	}
	public function setPassword($newPassword){
		/*$options=[
				'cost' => 11,
				'salt' => mcrypt_create_iv(22,MCRYPT_DEV_URANDOM)
		];*/
		$this->password=password_hash($password, PASSWORD_BCRYPT);
	}
	public function setToDB($conn){
		$sql="UPDATE Users SET user_name='$this->name',user_email='$this->email',user_adres='$this->address',user_password='$this->password' WHERE id=$this->id";
		return $conn->query($sql);
	}
	public function authenticate($password) {
		$hashed_pass=$this->password;
		if(password_verify($password, $hashed_pass)) {
			return true;//false u Jacka
		}
		return false;
	}
	
}