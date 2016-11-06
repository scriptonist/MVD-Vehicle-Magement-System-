<?php
	$servername = "localhost";
	$username = "root";
	$password = "segate";
	try {
    $conn = new PDO("mysql:host=$servername;dbname=MVD", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    require_once('class.mvd.php');
    $mvd = new MVD($conn);
    }
catch(PDOException $e)
    {

    echo "Connection To Database Was Lost !  " . $e->getMessage();
    die();
    }

 ?>
