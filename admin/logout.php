<?php
	require_once('connection.php');
	session_destroy();
	unset($_SESSION['adminid']);
	header('Location:/mvd/admin/');

?>
