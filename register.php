

<?php 
	if($_SERVER['REQUEST_METHOD']==="POST") {
		if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password2'])) {
			$email=trim($_POST['email']);
			$password=trim($_POST['password']);
			$passwordrepeat=trim($_POST['password2']);
			$name=trim($_POST['name']);
			$address=trim($_POST['address']);
			
			if($password===$passwordrepeat) {
				//filtry,sanityzacja 
				$sql="SELECT * FROM Users WHERE user_email='$email'";
				$result=$conn->query($sql);
				if($result->num_rows=0) {
					$options= [
							'cost' => 5,
							'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
					];
					$hashedPass=password_hash($password, PASSWORD_BCRYPT,$options);
					$sql="INSERT INTO Users(user_name,user_password,user_address,user_email) VALUES 
											('$name','$hashedPass','$address','$email'";
					$res=$conn->query($sql);
					$_SESSION['user_id']=$conn->insert_id;
					$_SESSION['user_email']=$email;
					$_SESSION['user_name']=$name;
					header("Location: /store/index.php");
				}
				else return false;
			}
			else return false;
			
		}
		
		
		
	}


?>









<div class="form-group">
<form action="/store/registercheck" method="post">
	<fieldset>
		<legend>Formularz rejestracyjny</legend>
		<label>*Email:</label><br>
		<input type="email" name="email" class="form-control"><br>
		<label>*Hasło:</label><br>
		<input type="password" name="password" class="form-control"><br>
		<label>*Powtórz hasło</label><br>
		<input type="password" name="password2" class="form-control"><br>
	</fieldset>
	<fieldset>
		<legend>Dane do wysyłki</legend>
		<label>Imię i Nazwisko</label><br>
		<input type="text" name="name" class="form-control"><br>
		<label>Adres</label><br>
		<input type="text" name="address" class="form-control"><br>
	</fieldset>
	<fieldset>
		<input type="checkbox" name="agreement" checked="checked" disabled="disabled">Zgadzam się...<br>
		<input type="submit" name="submit" value="Prześlij" class="form-control">
	
	</fieldset>
</form>
</div>