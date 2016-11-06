<?php
	require_once('connection.php');
	$user->logout();
	$user->redirect('/mvd/');
	
?>
