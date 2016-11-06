<?php
require_once('connection.php');

if(isset($_GET['email'])){
	$email = filter_var($_GET['email'],FILTER_SANITIZE_STRING);
	$stmt = $conn->prepare("SELECT email FROM mvd where email='$email' ");
	$c = $stmt->execute();
	if($stmt->rowCount() > 0){
		$result['status'] = "FALSE";
	}
	else{
		$result['status'] = "TRUE";
	}
	echo json_encode($result);
}
