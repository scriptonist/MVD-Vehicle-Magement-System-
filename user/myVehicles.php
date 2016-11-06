
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
	//Get User Profile Picture if presents
	$photo = $userRow['profilephoto'];
}

if($_SERVER['REQUEST_METHOD'] == "POST"){
	if(isset($_FILES['rcbook']) && isset($_FILES['insurance']) && isset($_POST['vehicleNumber'])){

		$vehicleNumber = $_POST['vehicleNumber'];
		$rcfrom = $_POST['RcDateFrom'];
		$rctill = $_POST['RcDateTill'];
		$infrom = $_POST['insuranceDateFrom'];
		$intill = $_POST['insuranceDateTill'];
		$rc=strtotime($rctill);
	 	$rcrem=ceil(($rc-time())/60/60/24);
	 	$in=strtotime($intill);
		$inrem=ceil(($in-time())/60/60/24);
		if(file_exists("../vehicleDocuments/$email") == 0){
		mkdir("../vehicleDocuments/$email");
		}
		$uploadOk = 1;
		$theDir = "../vehicleDocuments";
		$theDir .= "/$email/";
		$filename_rc = $theDir.basename($_FILES["rcbook"]["name"]);
		$filename_ins = $theDir.basename($_FILES["insurance"]["name"]);
		$imageFileType = pathinfo($filename_rc,PATHINFO_EXTENSION);
		if(isset($_POST["submit"])) {
		    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		    if($check !== false) {
		        echo "File is an image - " . $check["mime"] . ".";
		        $uploadOk = 1;
		    } else {
		        echo "File is not an image.";
		        $uploadOk = 0;
		    }
		}
		// Check file size
		if ($_FILES["rcbook"]["size"] > 5000000 && $_FILES["rcbook"]["size"] > 5000000) {
		    $message .= '<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong>Failed !</strong> Sorry,File Is Too Large!.
				</div>';
		    $uploadOk = 0;
		}
		// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    $message .='<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<strong>Failed !</strong> Sorry, only JPG, JPEG, PNG & GIF files are allowed. !.
		</div>';
    $uploadOk = 0;
}
		if ($uploadOk == 0) {
		      $message .= '<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong>Failed !</strong> Sorry, File Upload Failed !.
					</div>';;
		// if everything is ok, try to upload file
		}
		else{
		if (move_uploaded_file($_FILES["rcbook"]["tmp_name"], $filename_rc) && move_uploaded_file($_FILES["insurance"]["tmp_name"], $filename_ins)) {
			if($user->registerVehicle($email,$vehicleNumber,$filename_rc,$rcfrom,$rctill,$filename_ins,$infrom,$intill)){
				$message =  '<div class="alert alert-success alert-dismissible" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				  Updated SuccessFully!
				</div>';
			}


    } else {
			$message =  '<div class="alert alert-danger alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong>Failed !</strong> The Records Was Not Updated !.
			</div>';
    }
	}
}
}
}
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
			<li class="active"><a href="/mvd/user/myVehicles.php">My Vehicles</a></li>
			<li ><a href="/mvd/user/complaints.php">Complaints</a></li>
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
					<li><a href="userLogin.php">Login</a></li>
					<li><a href="userReg.php">Register</a></li>
				</ul>
			</li>
			<li class="dropdown"><!--Dropdown Menu for an MVD Official Login & register-->
				<a class="dropdown-toggle" data-toggle="dropdown" href="" >MVD <b class="caret"></b></a>

				<ul class="dropdown-menu">
					<li><a href="../mvd/mvdLogin.php">Login</a></li>
					<li><a href="../mvd/mvdreg.php">Register</a></li>
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
  <!-- Vehicle Details Upload Modal  -->
  <div class="modal fade" id="addVehicle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add New Vehicle</h4>
      </div>
      <div class="modal-body">

        <form action="" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label for="vehicleNumber">Vehicle Number</label>
            <input type="text" name="vehicleNumber" class="form-control" id="vehicleNumber" placeholder="vehicle Number" required>
          </div>
					<hr />
          <div class="form-group">

            <label for="RCBook">RC Book</label>
						<span class="label label-info">Upload Images less than 500kb</span>
            <input type="file" name="rcbook"  id="rcbook" required>
          </div>
					<div class="form-group">
            <label for="RCDateFrom">Valid From : </label>
            <input type="date" name="RcDateFrom"  id="RcDateFrom"  required>
						<label for="RCDateTill">Valid Till : </label>
						  <input type="date" name="RcDateTill"  id="RcDateTill" required>
          </div>
				<hr />
          <div class="form-group">

            <label for="insurance">Insurance</label>
						<span class="label label-info">Upload Images less than 500kb</span>
            <input type="file" name="insurance" id="insurance">
					</div>
					<div class="form-group">
            <label for="insuranceDateFrom">Valid From : </label>
            <input type="date" name="insuranceDateFrom"  id="RcDateFrom" required>
						<label for="RCDateTill">Valid Till : </label>
							<datepicker type="grid" value="2007-03-26"/>
						  <input type="date" name="insuranceDateTill"  id="insuranceDateTill" required>
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
    </div>
  </div>

  <!-- Modal End -->
	<div class="fluid-container">
		<div class="row">
			<div class="col-sm-2">
        <blockquote>Personal Details</blockquote>
        <table class="table table-hover">
            <tr>
              <td>Name</td>
              <td><?php echo $fname.' '.$lname ;?></td>

            </tr>
            <tr>
              <td>Email</td>
              <td><?php echo $email ;?></td>

            </tr>
            <tr>
              <td>Phone</td>
              <td><?php if($phone != '') echo $phone ; else echo "<span class='text-danger'>Not Present</span>";?></td>

            </tr>
        </table>
			</div>
			<div class="col-sm-offset-1 col-sm-5">
        <blockquote >
          <h2 style="display:inline-block;margin-bottom:2em">My Vehicles</h2>  &nbsp&nbsp&nbsp<button class='btn btn-success btn-sm' data-toggle="modal" data-target='#addVehicle'>Add New </button>
					<button class='btn btn-danger btn-sm' data-toggle="modal" data-target='#deleteVehicle'>Remove </button>

        </blockquote>
				<?php
					$vehicles = $user->getVehicles($email);
          $count = $vehicles[1];
          $vehicles = $vehicles[0];
					if($vehicles != ''){
						echo $vehicles;

					}


				 ?>

			</div>

		</div>
		<div class="row">
			<div class="col-sm-3">
        <?php echo $message?>
		  </div>
		</div>
	</div>

	<?php
		}
		else{
			echo "<h1 class='text-center text-danger'>You Must Be Logged in to continue !<h1>";
		}
	?>

	<!-- Vehicle Delete  -->
	<div class="modal fade" id="deleteVehicle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Delete Vehicle</h4>
			</div>
			<div class="modal-body">
				<form action="" method="post" enctype="multipart/form-data">
					<div class="form-group">
						<label for="vehicleNumber">Vehicle Number</label>
						<input type="text" name="vehicleNumber" class="form-control" id="vehicleNumber" placeholder="vehicle Number" required>
					</div>
					<hr />


			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-danger" name="deleteVehicle">Delete</button>
			</div>
			</form>
		</div>
		</div>
	</div>

	<!-- Modal End -->
	<?php

		if(isset($_POST['deleteVehicle'])){
			$vno = $_POST['vehicleNumber'];
			if($user->deleteVehicle($vno)){
				echo "<h1 class='alert'>Removed</h1>";
			}
		}
	?>
	<script src="../js/jquery-2.1.4.js"></script>
	<script src="../js/bootstrap.min.js"></script>


</body>

</html>
