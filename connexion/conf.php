<?php
	require './../db.class.php';
	$db = new DB();
	session_start();
		
	if(isset($_COOKIE['auth']) && !isset($_SESSION['Auth'])){
		$auth = $_COOKIE['auth'];
		$auth = explode('----', $auth);
		$user = $db->row('SELECT * FROM users WHERE id=:id', array('id' => $auth[0]));
		$key = sha1($user->username . $user->password .$_SERVER['REMOTE_ADDR']);
		
		if( $key == $auth[1]){
		$_SESSION['Auth'] = (array)$user;
			/*TODO fonction avec celle de login */
			setcookie('auth', $user->id. '----' . sha1($user->username . $user->password), time()+3600 * 24 *3, '/', 'localhost', false, true);
			header('Location:index.php');
		}
		else{
			setcookie('auth', '' , time() - 3600, '/', 'localhost', false, true);
			header('Location:index.php');
		}
		
	}

?>

