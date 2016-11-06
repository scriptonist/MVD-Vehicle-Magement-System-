<?php
require('../mailsender.php');
if(isset($_GET['to']) && isset($_GET['subject']) && isset($_GET['content']) && isset($_GET['alt'])){
  $to = $_GET['to'];
  $sub = $_GET['subject'];
  $con = $_GET['content'];
  $alt = $_GET['alt'];
  mailsender($to,$sub,$con,$alt);
}


 ?>
