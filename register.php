

<?php 
	if($_SERVER['REQUEST_METHOD']==="POST") {
		if(!isset($_SESSION['user_id'])) {		
			if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password2'])) {
				$email=trim($_POST['email']);
				$password=trim($_POST['password']);
				$passwordrepeat=trim($_POST['password2']);
				$name=trim($_POST['name']);
				$address=trim($_POST['address']);
				
				if($password==$passwordrepeat) {
					//filtry,sanityzacja 
						/*$email=filter_var($email,FILTER_SANITIZE_EMAIL);
						$name=filter_var($name,FILTER_SANITIZE_ENCODED);
						$address=filter_var($address,FILTER_SANITIZE_ENCODED);
						 */
						$email=addslashes($email);
						$name=addslashes($name);
						$address=addslashes($address);
						/*$options= [
								'cost' => 5,
								'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
						];*/
						$user=user::CreateUser($email, $password, $name, $address, $conn);
						
						$_SESSION['user_id']=$user->getID();
						$_SESSION['user_email']=$user->getEmail();
						$_SESSION['user_name']=$user->getName();
						header("Location: /store/index.php");
						
						
				}
				else return false;
				header("Location: store/register2");
				echo "Spróbuj jeszcze raz";
			}
			else return false;
		}
		else{
			echo "Jesteś już zalogowany!";
			
			
		}
	}
		
		
		
	


?>







<?php if(!isset($_SESSION['user_id'])) { ?>

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

<?php } else {?>
<h2>Jesteś już zalogowany!</h2>
<?php }?>
