<?php
	require_once('connection.php');
  session_destroy();
	unset($_SESSION['mvdemail']);
	header('Location:/mvd/mvd/mvdLogin.php');

?>
