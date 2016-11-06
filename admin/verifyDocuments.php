<?php
  session_start();
  if(!isset($_SESSION['adminid'])){
    die("Please Login To View This !");
  }
  require_once('connection.php');
  $stmt = $conn->prepare("SELECT owner,vehicleNumber,rcbook,rcfrom,rctill,insurance,insurancefrom,insurancetill,verified,sdate,ABS(datediff(sdate,curdate())) as diff FROM vehicles WHERE verified=:ve ORDER BY diff DESC");
  $stmt->execute(array(':ve'=>0));

  if($stmt->rowCount() > 0){
    $table = "<table class='w3-table w3-small w3-striped w3-responsive w3-bordered'>";
    $table .= "<tr>
    <th>Owner</th>
    <th>Vehicle Number</th>
    <th>Submitted On</th>
    <th>No of days Elapsed</th>
    <th>Validate</th>
    </tr>";
    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
      $num = $row['vehicleNumber'];
      $table .= "<tr><td>".$row['owner']."</td>";
      $table .= "<td>".$row['vehicleNumber']."</td>";
        $table .= "<td>".$row['sdate']."</td>";
          $table .= "<td>".$row['diff']."</td>";
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
    <li><a class="w3-text-indigo" href="verifyDocuments.php"><i class="fa fa-check-square-o" aria-hidden="true"></i> Verify Documents </a></li>
    <li><a href="expiring.php"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Expiring Documents </a></li>
    <li><a href="complaints.php"><i class="fa fa-bullseye" aria-hidden="true"></i> Complaints </a></li>
    <li style="float:right"><a type="button" class="w3-btn w3-red" href="logout.php"> Logout </a></li>

  </ul>


<div class="w3-row">
  <div class="w3-col m4 w3-card-8 w3-center" style="margin-left:10%;width:80%;margin-top:2%">
    <header class=w3-blue-grey>
      <h3>Documents To Be Verified</h3>
    </header>
    <div>
      <?php
        echo "$table";
       ?>
    </div>

  </div>


</div>

</body>
</html>
