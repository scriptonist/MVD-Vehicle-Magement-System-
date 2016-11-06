<?php
  require_once('connection.php');
  if(isset($_POST['login'])){
    try
    {
      $id = $_POST['id'];
      $pass = $_POST['pass'];
       $stmt = $conn->prepare("SELECT * FROM admin WHERE id=:id LIMIT 1");
       $stmt->execute(array(':id'=>$id));
       $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
       if($stmt->rowCount() > 0)
       {

          if( $pass == $userRow['password'])
          {
             session_start();
             $_SESSION['adminid'] = $userRow['id'];
             header('Location:verifyDocuments.php');
          }
          else
          {
               die("Login Failed Check The Credentials");
          }
       }
    }
    catch(PDOException $e)
    {
        echo $e->getMessage();
    }
  }

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="../css/w3.css" />
  <link rel="stylesheet" href="../css/fa/css/font-awesome.min.css" />
</head>
<body onload="document.getElementById('id01').style.display='block'">


  <div id="id01" class="w3-modal">
    <span onclick="document.getElementById('id01').style.display='none'" class="w3-closebtn w3-hover-red w3-container w3-padding-hor-16 w3-display-topright">&times;</span>
    <div class="w3-modal-content w3-card-8 w3-animate-zoom" style="max-width:600px">
      <header class="w3-light-grey w3-center">
        <h3>Login</h3>
      </header>


      <div class="w3-container">
        <div class="w3-section">
          <form action="" method="post">
          <label><b>Admin ID</b></label>
          <input name="id" class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Admin ID" required>

          <label><b>Password</b></label>
          <input name="pass" class="w3-input w3-border" type="password" placeholder="Enter Password" required>

          <button type="submit" name="login" class="w3-btn w3-btn-block w3-green">Login</button>

          </form>
        </div>

      </div>

      <div class="w3-container w3-border-top w3-padding-hor-16 w3-light-grey">
        <button onclick="document.getElementById('id01').style.display='none'" type="button" class="w3-btn w3-red">Cancel</button>

      </div>

    </div>
  </div>
</body>
</html>
