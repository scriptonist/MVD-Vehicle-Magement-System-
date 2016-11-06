<?php
require('connection.php');
  session_start();
  if(isset($_SESSION['mvdemail'])){
    $mid  = $_SESSION['mvdemail'];
  }
  else{
    die("Please Login to continue !");
  }
  $result = '';
  if($_SERVER["REQUEST_METHOD"] == "POST"){

      $query_string = $_POST['search_query'];
      try
      {
         $stmt =$conn->prepare("SELECT * FROM vehicles WHERE vehicleNumber=:vno and verified=1");
         $stmt->execute(array(':vno'=>$query_string));

         if($stmt->rowCount() > 0)
         {
            $result .="<h3 class='text-success'>Record Was Found !</h3>";
           while( $userRow=$stmt->fetch(PDO::FETCH_ASSOC)){

             $ownerEmail = $userRow['owner'];
             $s =$conn->prepare("SELECT * FROM users WHERE email=:email LIMIT 1");
             $s->execute(array(':email'=>$ownerEmail));
             foreach($s as $r){
               $owner = $r['fname']." ".$r['lname'];
             }

             $rcbook = $userRow["rcbook"];
             $insurance = $userRow['insurance'];
             $rcfrom = $userRow["rcfrom"];
             $rctill = $userRow["rctill"];
             $infrom = $userRow["insurancefrom"];
             $intill = $userRow["insurancetill"];
             $rc=strtotime($rctill);
            $rcrem=ceil(($rc-time())/60/60/24);
            $in=strtotime($intill);
           $inrem=ceil(($in-time())/60/60/24);
           if($rcrem <= 0){
             $result .="<h3 class='text-danger'>RC Book Has Expired !</h3>";
           }
           if($inrem <= 0){
             $result .="<h3 class='text-danger'>Insurance Has Expired !</h3>";
           }
           if($rcrem > 0){
              $result .="<h3 class='text-success'>RC Book Is Valid ! - $rcrem Days of Validity Remaining</h3>";
           }
           if($inrem > 0){
              $result .="<h3 class='text-success'>Insurance Is Valid ! - $inrem Days of Validity Remaining</h3>";
           }


             $result .=  "<table class='table table-hover'>
             <tr>
                <td>
                  Number
                </td>
                <td>".
                  $userRow['vehicleNumber']
                ."</td>
                </tr>
                <tr>
                <tr>
                   <td>
                     Owner
                   </td>
                   <td>".
                     $owner
                   ."</td>
                   </tr>
                   <tr>
                <tr>
                   <td>
                     Owner Email
                   </td>
                   <td>".
                     $ownerEmail
                   ."</td>
                   </tr>
                   <tr>

                   <td>
                     RC Book
                   </td>
                   <td >
                     <a  href='$rcbook' target='_blank'>View</a>
                   </td>
                   </tr><tr>
                      <td>
                        Insurance
                      </td>
                      <td>
                         <a  href='$insurance' target='_blank'>View</a>
                      </td>
                      </tr>
             </table>";
           }
         }
         else{
             $result ="<h3 class='text-danger'>No Record Was Found  !</h3>";
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
  <title>MVD Registration</title>
  <link rel="stylesheet" href="../css/bootstrap.min.css" />
</head>
<body>
  <!-- Navbar start -->
  <!--
    The navbar can be created in bootstrap by using classes navbar and navbar-default
    to the <nav> tag this tag was introduced in html-5
    The role attribute is for accesebility reasons
  -->
  <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <!-- Start of navbar header -->
    <div class="navbar-header">
    <!-- this a builtin class in bootstrap used to give a general
    brand name (the text on leftside of navbar)
    -->

      <a href="/mvd/" class="navbar-brand">Motor Vehicles Department</a>
    </div>
    <!-- Navbar header End -->

    <!-- ****NAVBAR LINKS******* -->
    <!-- To add navbar links just enclose them inside a <ul> with classes nav and
       navbar-nav. Put the corresponding links (<a> tags) between the <li> tags
     -->
    <ul class="nav navbar-nav">
      <li class="active"><a href="#">Home</a></li>
    </ul>

    <!-- Right Side Navbar Links -->
    <ul class="nav navbar-nav navbar-right" style="margin-right:1vh">
      <li >
        <a href="logout.php" type="button" class="btn btn-default">Logout</a>
      </li>

    </ul>
    <!-- Right Side Navbar Links End -->

    <!-- ****END NAVBAR LINKS*** -->
  </nav>
  <!-- Navbar End -->
  <div class="jumbotron">
    <h1 class="text-center">MVD Search</h1>
  </div>
  <div class="container">
    <div class="row">

      <form class="form-horizontal" action="" method="POST">
        <div class="form-group">
          <div class="col-xs-8 col-sm-offset-3 col-sm-6">
            <input type='text' name="search_query" class="form-control" placeholder="Vehicle Number"/>
          </div>
        <div class="col-xs-4 col-sm-2">
          <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Search</button>
        </div>
        </div>
      </form>
    </div>
  <div class="row">
    <div class="col-sm-offset-3">
        <?php echo $result ;?>
    </div>
  </div>
  </div>
  <script src="../js/jquery-2.1.4.js"></script>
  <script src="../js/bootstrap.min.js"></script>
</body>
</html>
