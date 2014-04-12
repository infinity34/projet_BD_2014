<?php
	require 'conf.php';
	$error = false;
	if(!empty($_POST)){
	
		$user = $db->row('SELECT id, username, password FROM users WHERE username=:username AND password=:password',
							array ( 'username' => $_POST['username'],
									'password' =>md5($_POST['password'])
									)
						);
		if(isset($_POST['remember'])){
			setcookie('auth', $user->id. '----' . sha1($user->username . $user->password . $_SERVER['REMOTE_ADDR']), time()+3600 * 24 *3, '/', 'localhost', false, true);
			//setcookie('auth', $user->id, time, 'lieu accessible', 'nomdedomaine', securisé https, http only);
			//rajout de l'ip pour que le code varie d'ordinateur a un autre pour eviter les copier coller des valeurs du cookie
		}
		if($user){
			$_SESSION['Auth'] = (array)$user;
			header('Location:index.php');
		}
		else{
			$error = true;
		}
	}
/*http://www.grafikart.fr/tutoriels/php/cookie-php-souvenir-412*/
?>

<form method="post" action="login.php">
	<fieldset>
		<legend>Se Connecter</legend>
		<?php if($error): ?>
			<div class="alert alert-error">
				Identifiants Incorrects
			</div>
		<?php endif ?>
		<input type="text" name="username" placeholder="Identifiant">
		<input type="password" name="password" placeholder="Mot de passe">
		<label class="checkbox">
			<input type="checkbox" name="remember">Se souvenir de moi
		</label>
		<button type="submit" class="btn">Submit</button>
	</fieldset>
</form>

