
<?php
session_start();
$message = '';
require_once('connection.php');
// User email in $_SESSION['userEmail'];
//Get all Details of user
if(isset($_SESSION['userEmail'])){
$email = $_SESSION['userEmail'];
$sql = "SELECT * FROM users where email=:uemail LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->execute(array(':uemail'=>$_SESSION['userEmail']));
$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
if($stmt->rowCount() > 0){
	$fname = $userRow['fname'];
	$lname = $userRow['lname'];
	$phone = $userRow['phone'];


}
if(isset($_POST['complaint'])){

  $sql = "INSERT INTO complaints (userid,complaint,sdate) VALUES(:uid,:complaint,curdate())";
  $stmt = $conn->prepare($sql);
  $stmt->execute(array(':uid'=>$email,':complaint'=>$_POST['complaint']));
  if($stmt->rowCount() > 0){
    $message = '<div class="alert alert-success alert-dismissable">
   <button type="button" class="close" data-dismiss="alert"
      aria-hidden="true">
      &times;
   </button>
  Your Complaint Was submitted  ! You will Be Contacted Soon .
</div>';


  }
  else{
    $message = '<div class="alert alert-danger alert-dismissable">
   <button type="button" class="close" data-dismiss="alert"
      aria-hidden="true">
      &times;
   </button>
   Failed ! The Complaint Was Not Submitted
</div>';
  }
}

}
//Profile Picture Upload Script
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>MVD-User- <?php echo $_SESSION['userEmail'];?> </title>
	<link rel="stylesheet" href="../css/bootstrap.css">
</head>
<body>
	<!-- Navbar start -->
	<!--
		The navbar can be created in bootstrap by using classes navbar and navbar-default
		to the <nav> tag this tag was introduced in html-5
		The role attribute is for accesebility reasons
	-->
	<nav class="navbar navbar-default" role="navigation">
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
		 <?php
		 if(isset($_SESSION['userEmail'])){

		 ?>
		<ul class="nav navbar-nav">
			<li ><a href="/mvd/user/userDash.php">Profile</a></li>
			<li ><a href="/mvd/user/myVehicles.php">My Vehicles</a></li>
      <li class="active"><a href="/mvd/user/complaints.php">Complaints</a></li>
		</ul>
		<?php
		}
		else{
		?>
			<ul class="nav navbar-nav">
			<li class="active"><a href="/mvd/">Home</a></li>
			</ul>
		<?php
			}
		?>
		<!-- Right Side Navbar Links -->
		<ul class="nav navbar-nav navbar-right" style="margin-right:1vh">
			<?php
				if(isset($_SESSION['userEmail'])){


			?>
				<ul class="nav navbar-nav">
					<p class="navbar-text"><?php echo $fname.' '.$lname;?></p>
					<li ><a type="button" href="logout.php" class="btn btn-default">Logout</a></li>
				</ul>
				<?php
				}
				else{
				?>
			<li class="dropdown"><!--Dropdown Menu for the citizen Login & register-->

				<a class="dropdown-toggle" data-toggle="dropdown" href="" >Citizen <b class="caret"></b></a>

				<ul class="dropdown-menu">
					<li><a href="user/userLogin.php">Login</a></li>
					<li><a href="user/userReg.php">Register</a></li>
				</ul>
			</li>
			<li class="dropdown"><!--Dropdown Menu for an MVD Official Login & register-->
				<a class="dropdown-toggle" data-toggle="dropdown" href="" >MVD <b class="caret"></b></a>

				<ul class="dropdown-menu">
					<li><a href="#">Login</a></li>
					<li><a href="#">Register</a></li>
				</ul>
			</li>
			<?php
			}
			?>

		</ul>
		<!-- Right Side Navbar Links End -->

		<!-- ****END NAVBAR LINKS*** -->
	</nav>
	<!-- Navbar End -->
	<?php
		if(isset($_SESSION['userEmail'])){


	?>
	<div class="container">
		<div class="row">
      <h2 style="margin-bottom:1em">Register A Complaint</h2>
      <form role="form" action="" method="post">
       <div class="form-group">

          <textarea rows="10"  name="complaint" class="form-control" id="complaint"></textarea>
       </div>

       <button type="submit" class="btn btn-default">Submit</button>
    </form>


	 </div>
   <div class="row">
     <h3><?php echo $message ?></h3>
   </div>
	</div>
	<?php
		}
		else{
			echo "<h1 class='text-center text-danger'>You Must Be Logged in to continue !<h1>";
		}
	?>

	<script src="../js/jquery-2.1.4.js"></script>
	<script src="../js/bootstrap.min.js"></script>


</body>
</html>
