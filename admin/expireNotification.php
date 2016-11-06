<?php
require_once('../mailsender.php');
$sub = "[important] Expiring Vehicle Documents";
$con = "Dear User\n
  <h1 style='color:red'>Your Vehicle Documents will Expire Soon please Renew It As soon as Possible !</h1>

";
$alt = "Dear User\n
  Your Vehicle Documents will Expire Soon please Renew It As soon as Possible !

";
  if(isset($_GET['email'])){
    $to = $_GET['email'];

    if(mailsender($to,$sub,$con,$alt) == 0)
      header("Location:expiring.php?res=1");
    else
      header("Location:expiring.php?res=0");
  }
  else if(isset($_GET['compl'])){
    $to = $_GET['compl'];
    $id = $_GET['id'];
    $sub = "[Reply To Complaint] Motor vehicles Departmet";
    $con = "Dear User\n
      Your Complaint was reviewed and nescessary action was taken. Thank you for your Response.

    ";
    $alt = "Dear User\n
      Your Complaint was reviewed and nescessary action was taken. Thank you for your Response.

    ";

    if(mailsender($to,$sub,$con,$alt) == 0)
      header("Location:complaints.php?id=$id");
    else
      header("Location:complaints.php?res=0");
  }
  else if(isset($_POST['all'])){
    session_start();
    if(isset($_SESSION['emails']))
    {
      $emails = $_SESSION['emails'];
      foreach($emails as $to){
        if(mailsender($to,$sub,$con,$alt) == 1){
          header("Location:expiring.php?res=0");
          $fl = false;
          break;

          }
          else{
            $fl = true;
          }


      }
      if($fl != false){
        header("Location:expiring.php?res=1");
      }

    }
  }
else{
  header("Location:expiring.php?res=0");
}
 ?>
