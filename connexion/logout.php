<?php
	require('conf.php');
	session_destroy();
	setcookie('auth', $user->id. '----' . sha1($user->username . $user->password), time()+3600 * 24 *3, '/', 'localhost', false, true);
	header('Location:login.php');
?>
