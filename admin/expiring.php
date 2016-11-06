<?php
  session_start();
  if(!isset($_SESSION['adminid'])){
    die("Please Login To View This !");
  }
  require_once('connection.php');
  $emails = Array();
  $stmt = $conn->prepare("SELECT owner,vehicleNumber,rcbook,rcfrom,rctill,insurance,insurancefrom,insurancetill,sdate,ABS(datediff(rcfrom,rctill)) as rcdiff,ABS(datediff(insurancefrom,insurancetill)) as insdiff  FROM vehicles WHERE ABS(datediff(rcfrom,rctill)) < 30 OR ABS(datediff(insurancefrom,insurancetill)) < 30 ");
  $stmt->execute(array(':ve'=>0));
  $sendAllBtn = '';
  if($stmt->rowCount() > 0){
    $sendAllBtn = "<form action='expireNotification.php' method='post'>

      <input style='margin-top:2em;' type='submit' class='w3-btn w3-teal'  value='Send Notifications to All Owners ' name='all'/>
    </form>";
    $table = "<table class='w3-table w3-small w3-striped w3-responsive w3-bordered'>";
    $table .= "<tr>
    <th>Owner</th>
    <th>Vehicle Number</th>
    <th>RC Days Remaining</th>
    <th>Insurance Days Remaining</th>
    <th>Action</th>
    </tr>";
    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
      $num = $row['vehicleNumber'];
      $owner = $row['owner'];
      array_push($emails,$owner);
      $table .= "<tr><td>".$row['owner']."</td>";
      $table .= "<td>".$row['vehicleNumber']."</td>";
        $table .= "<td>".$row['rcdiff']."</td>";
        $table .= "<td>".$row['insdiff']."</td>";
      $table .= "<td>"."<a type='button' class='w3-btn w3-teal' href='expireNotification.php?email=$owner'><i class='fa fa-envelope' aria-hidden='true'></i>
 Send Email Notification</a>"."</td>";

    }

    $_SESSION['emails'] = $emails;
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
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css"> -->
  <link rel="stylesheet" href="../css/fa/css/font-awesome.min.css" />
</head>
<body>
  <header class="w3-container w3-blue-grey">
     <h1>Admin <i class="fa fa-cogs" aria-hidden="true"></i></h1>
  </header>
  <ul class="w3-navbar w3-card-8 w3-light-grey">
    <li ><a href="verifyDocuments.php"><i class="fa fa-check-square-o" aria-hidden="true"></i> Verify Documents </a></li>
    <li ><a class="w3-text-indigo" href="expiring.php"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Expiring Documents </a></li>
    <li><a href="complaints.php"><i class="fa fa-bullseye" aria-hidden="true"></i> Complaints </a></li>
    <li style="margin-left:51em"><a type="button" class="w3-btn w3-red" href="logout.php"> Logout </a></li>

  </ul>

  <div class="w3-row">
    <div class="w3-col m9 w3-card-8 w3-center" style="width:70%;margin-left:1em">
      <header class=w3-blue-grey>
        <h3>Expiring Documents</h3>
      </header>
      <div >
        <?php
          echo "$table";
         ?>
      </div>

    </div>

    <div class="w3-col m3">

      <div style="" class="w3-container">

        <?php echo $sendAllBtn; ?>
      </div>
      <div  style="" class="w3-container ">

      <?php
        if(isset($_GET['res'])){
          if($_GET['res'] == 1){
           $responseModal = '<div  class="w3-container w3-green w3-card-8  w3-center">
            <span onclick="this.parentElement.style.display=\'none\'" class="w3-closebtn">&times;</span>
    <h6>  Notifications Was Send!</h6>

    </div> ';
          }
          else{
            $responseModal = '<div  class="w3-container w3-red w3-card-8  w3-center">
             <span onclick="this.parentElement.style.display=\'none\'" class="w3-closebtn">&times;</span>
       <h6>Sending Failed ! </h6>

     </div> ';
          }
        }
        else{
          $responseModal = "";
        }
        echo $responseModal;
       ?>
     </div>
     </div>
  </div>


</body>
</html>
