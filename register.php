

<?php 
//walidacja


?>









<div class="form-group">
<form action="#" method="post">
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
		<input type="text" name="adress" class="form-control"><br>
	</fieldset>
	<fieldset>
		<input type="checkbox" name="agreement" checked="checked" disabled="disabled">Zgadzam się...<br>
		<input type="submit" name="submit" value="Prześlij" class="form-control">
	
	</fieldset>
</form>
</div>