

 <?php
 require 'PHPMailer-master/PHPMailerAutoload.php';
function mailsender($sendTo,$subject,$body,$altbody){
   $mail = new PHPMailer;

   //$mail->SMTPDebug = 3;                               // Enable verbose debug output

   $mail->isSMTP();                                      // Set mailer to use SMTP
   $mail->Host = 'smtp.gmail.com;smtp.gmail.com';  // Specify main and backup SMTP servers
   $mail->SMTPAuth = true;                               // Enable SMTP authentication
   $mail->Username = 'aravind.techbridge@gmail.com';                 // SMTP username
   $mail->Password = 'Techbr!dgelabs1';                           // SMTP password
   $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
   $mail->Port = 587;                                    // TCP port to connect to

   $mail->setFrom('aravind.techbridge@gmail.com', 'Motor Vehicles Department');
   $mail->addAddress($sendTo);     // Add a recipient
  $mail->isHTML(true);                                  // Set email format to HTML

   $mail->Subject = $subject;
   $mail->Body    = $body;
   $mail->AltBody = $altbody;

   if(!$mail->send()) {
      // echo 'Message could not be sent.';
       //echo 'Mailer Error: ' . $mail->ErrorInfo;
       return 1;
   } else {
       return 0;
   }
}
