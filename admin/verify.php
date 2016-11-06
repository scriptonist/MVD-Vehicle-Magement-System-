<?php
  require_once('connection.php');
  $stmt = $conn->prepare("SELECT owner,vehicleNumber,rcbook,rcfrom,rctill,insurance,insurancefrom,insurancetill,verified,sdate FROM vehicles WHERE verified=:ve");
  $stmt->execute(array(':ve'=>0));

  if($stmt->rowCount() > 0){
    $table = "<table class='w3-table w3-small w3-striped w3-responsive w3-bordered'>";
    $table .= "<tr>
    <th>Owner</th>
    <th>Vehicle Number</th>
    <th>Validate</th>
    <th>Sumbitted On</th>
    </tr>";
    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
      $num = $row['vehicleNumber'];
      $table .= "<tr><td>".$row['owner']."</td>";
      $table .= "<td>".$row['vehicleNumber']."</td>";
        $table .= "<td>".$row['sdate']."</td>";
      $table .= "<td>"."<a href='verify.php?number=$num'>View and Verify</a>"."</td>";

    }
    $table .= "</table>";
  }
  else{
    $table = "No Results Found !";
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
<body>
  <header class="w3-container w3-blue-grey">
     <h1>Admin <i class="fa fa-cogs" aria-hidden="true"></i></h1>
  </header>
  <ul class="w3-navbar w3-card-8 w3-light-grey">
    <li><a class="w3-text-indigo" href="index.php"><i class="fa fa-check-square-o" aria-hidden="true"></i> Verify Documents </a></li>
    <li><a href="expiring.php"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Expiring Documents </a></li>
    <li><a href="complaints.php"><i class="fa fa-bullseye" aria-hidden="true"></i> Complaints </a></li>
    <li style="float:right"><a type="button" class="w3-btn w3-red" href="logout.php"> Logout </a></li>

  </ul>



  <?php
  if(isset($_GET['number']))
  {
    require_once('connection.php');
    $stmt = $conn->prepare("SELECT * FROM vehicles WHERE verified=:ve and vehicleNumber=:no");
    $stmt->execute(array(':ve'=>0,':no'=>$_GET['number']));
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
      $rcpath = $row['rcbook'];
      $inpath = $row['insurance'];
      $owner  = $row['owner'];
      $vnumber= $row['vehicleNumber'];

      $rcfrom = $row['rcfrom'];
      $rctill = $row['rctill'];

      $infrom = $row['insurancefrom'];
      $intill = $row['insurancetill'];
      $stmt = $conn->prepare("SELECT * FROM users WHERE email=:owner");
      $stmt->execute(array(':owner'=>$owner));
      $row=$stmt->fetch(PDO::FETCH_ASSOC);
      $uname = $row['fname'].' '.$row['lname'];
      $phone = $row['phone'];
      $dp = $row['profilephoto'];

    }

?>
<div class="w3-row">
  <div class="w3-col w3-quarter" style='margin-left:4%;margin-top:2%'>
    <div class="w3-card-8 w3-dark-grey">
      <header class='w3-dark-grey'><h3 class="w3-container w3-center">Owner</h3></header>
      <div class="w3-container w3-center">
        <img src='<?php echo $dp ?>' style="width:80%"/>
        <br />
        Name  : <?php echo "$uname" ?><br />
        Phone : <?php echo "$phone" ?><br />
        Email : <?php echo "$owner" ?><br />
      </div>
      <footer>

        </footer>
    </div>

  </div>
  <div class="w3-col w3-half " style='margin-left:2%;margin-top:2%'>
    <div class="w3-card-4">
      <header class="w3-dark-grey">
          <h2>RC Book</h2>
      </header>
      <div class="w3-container w3-center">
        <img src='<?php echo $rcpath ?>' style="width:80%"/>
        <br />

      </div>
      <footer class="w3-dark-grey">
        <div class="w3-container w3-center">
        Valid From  : <?php echo "$rcfrom" ?><br />
        Valid Till : <?php echo "$rctill" ?><br />
        </div>
      </footer>
    </div>
  </div>

</div>
<div class='w3-row'>
  <div class="w3-col w3-quarter"><div class="w3-container w3-center" style='margin-top:2%'>
    <button type="button" id="verify" class="w3-btn w3-green w3-xlarge w3-ripple w3-hover-red">Verify Now</button>

  </div></div>
  <div class="w3-col w3-half" style='margin-left:6%;margin-top:2%'>
    <div class="w3-card-4">
      <header class="w3-dark-grey">
        <h2>Insurance</h2>
      </header>
      <div class="w3-container w3-center">
        <img src='<?php echo $inpath ?>' style="width:80%"/>
        <br />

      </div>
      <footer class="w3-dark-grey">
        <div class="w3-container w3-center">
        Valid From  : <?php echo "$infrom" ?><br />
        Valid Till : <?php echo "$intill" ?><br />
      </div>
      </footer>
    </div>
  </div>
</div>
<br />
<br />
<br />
<footer class="w3-dark-grey">
  <h3 class="w3-container w3-center" style="margin:0">
    Kerala Motor Vehicles Department
  </h3>
</footer>

<input type="hidden" id="number" value="<?php echo $_GET['number'] ?>">
<script src="../js/jquery-2.1.4.js"></script>
<script src="../js/verify.js"></script>
</body>
</html>
