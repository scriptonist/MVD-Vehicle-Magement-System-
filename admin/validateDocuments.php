<?php
require_once('connection.php');

if(isset($_GET['no'])){
  $no = $_GET['no'];
	$stmt = $conn->prepare("UPDATE vehicles set verified=1 where vehicleNumber ='$no' ");
	$c = $stmt->execute();
	if($stmt->rowCount() > 0){
		$result['status'] = "TRUE";
	}
	else{
		$result['status'] = "FALSE";
	}
	echo json_encode($result);
}
