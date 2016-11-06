<?php
  require_once('connection.php');
  if(isset($_GET['id'])){
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE  FROM complaints where id=$id");
    $stmt->execute();
  }
  $stmt = $conn->prepare("SELECT id,userid,complaint,sdate,ABS(datediff(curdate(),sdate)) as diff FROM complaints ORDER BY diff DESC");
  $stmt->execute();

  if($stmt->rowCount() > 0){
    $table = "<table class='w3-table w3-small w3-striped w3-responsive w3-bordered'>";
    $table .= "<tr>
    <th>Complaint By</th>
    <th>Complaint</th>
    <th>Sumbitted On</th>
    <th>No. Of days Elapsed</th>
    <th>Action</th>

    </tr>";
    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
      $userid = $row['userid'];
      $id = $row['id'];
      $table .= "<tr><td>".$row['userid']."</td>";
      $table .= "<td>".$row['complaint']."</td>";
      $table .= "<td>".$row['sdate']."</td>";
      $table .= "<td>".$row['diff']."</td>";
      $table .= "<td>"."<a type='button' class='w3-btn w3-green' href='expireNotification.php?compl=$userid&id=$id'><i class='fa fa-check' aria-hidden='true'></i> Send reviewed Response</a>"."</td>";


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
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css"> -->
  <link rel="stylesheet" href="../css/fa/css/font-awesome.min.css" />
</head>
<body>
  <header class="w3-container w3-blue-grey">
     <h1>Admin <i class="fa fa-cogs" aria-hidden="true"></i></h1>
  </header>
  <ul class="w3-navbar w3-card-8 w3-light-grey">
    <li ><a href="verifyDocuments.php"><i class="fa fa-check-square-o" aria-hidden="true"></i> Verify Documents </a></li>
    <li ><a  href="expiring.php"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Expiring Documents </a></li>
    <li><a class="w3-text-indigo" href="complaints.php"><i class="fa fa-bullseye" aria-hidden="true"></i> Complaints </a></li>
    <li style="float:right"><a type="button" class="w3-btn w3-red" href="logout.php"> Logout </a></li>


  </ul>


  <div class="w3-row">
    <div class="w3-col m4 w3-card-8 w3-center" style="margin-left:10%;width:80%;margin-top:2%">
      <header class=w3-blue-grey>
        <h3>Complaints</h3>
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
