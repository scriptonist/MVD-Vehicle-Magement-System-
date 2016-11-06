
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
	if($photo == ""){
		$photoUploaded = false;
		$photoPath = "../img/profile-placeholder.png";
	}
	else{
		$photoUploaded = true;
		$photoPath = $photo;
	}
}
//Profile Picture Upload Script
if(isset($_FILES['proPic'])){

		if(file_exists("../profilePictures/$email") == 0){
		mkdir("../profilePictures/$email");
		}
		else{
		array_map('unlink', glob("../profilePictures/$email/*"));
		}

		$theDir = "../profilePictures";
		$theDir .= "/$email/";
		$filename = $theDir.basename($_FILES["proPic"]["name"]);

		if (move_uploaded_file($_FILES["proPic"]["tmp_name"], $filename)) {
				$message =  '<div class="alert alert-success alert-dismissible" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				  Updated SuccessFully!
				</div>';
				$user->UploadProfilePic($filename);
    } else {
			$message =  '<div class="alert alert-danger alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong>Failed !</strong> The Picture Was Not Updated  !.
			</div>';
    }
	}


}
/* Handle The Update Profile */
  if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['updateFname']) && isset($_POST['updateLname']) && isset($_POST['updatePhone']) ){
    $updateResp = "";
      $fname = $_POST['updateFname'];
        $lname = $_POST['updateLname'];
        $phone  = $_POST['updatePhone'];
        if($user->update($email,$fname,$lname,$phone)){
          $updateResp = '<div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  Updated SuccessFully !
</div>';

        }
        else{
          $updateResp = '<div class="alert alert-danger alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  Failed To Update !
</div>';
        }
  }
/* Update Done */
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
      <li class="active"><a href="/mvd/user/userDash.php">Profile</a></li>
			<li ><a href="/mvd/user/myVehicles.php">My Vehicles</a></li>
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
			<div class="col-sm-4">
				<!-- For Profile picture  -->
				<?php if($photoUploaded == true){
					echo "<img src='$photoPath' style='display:block' class='img-circle' width='200px' alt='profilePhoto'> ";
					echo "<button type='button' style='margin-left:16%;margin-top:5px;' data-toggle='modal' data-target='.profile-photo-upload' class='btn btn-default'>Change</button>";
				}
				else{
					echo "<img src='$photoPath' style='display:block' class='img-circle' width='200px' alt='profilePhoto'> ";
					echo "<button type='button' style='margin-left:16%;margin-top:5px;'  data-toggle='modal' data-target='.profile-photo-upload' class='btn btn-default'>Upload</button>";
				}
				?>
				<!-- File Upload Modal Start -->
				<div class="modal fade profile-photo-upload" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
				  <div class="modal-dialog modal-sm">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				        <h4 class="modal-title" id="myModalLabel">Upload Your Picture</h4>
				      </div>
				      <div class="modal-body">
				        <form id="profilePhotoUpload" action="" method="post"  enctype="multipart/form-data">
							<input type="file" name="proPic">
							<button type="submit" class="btn btn-primary btn-sm">Upload</button>
				        </form>
				      </div>
				    </div>
				  </div>
				</div>
				<!--  File Upload Modal End-->
			</div>
			<div class="col-sm-5">
				<blockquote><h3>Personal Details</h3></blockquote><br>
        <form action="" method="post">
        <table class="table table-hover">
  					<tr>
  						<td>Fname</td>
  						<td><input type="text" value="<?php echo $fname ;?>" name="updateFname"</td>

  					</tr>
            <tr>
              <td>Lname</td>
              <td><input type="text" value="<?php echo $lname ;?>" name="updateLname"</td>

            </tr>
  					<tr>
  						<td>Email</td>
  						<td><?php echo $email ;?></td>

  					</tr>
						<tr>
							<td>Phone</td>
							<td><input type="number" value="<?php if($phone != '') echo $phone ;?>" name="updatePhone"</td>

						</tr>
				</table>
				<button type="submit" class="btn btn-default">Update</a>
        </form>
			</div>
			<div class="col-sm-offset-1 col-sm-2">

			</div>
		</div>
    <br />
		<div class="row">
			<div class="col-offset-sm-3 col-sm-5">
			<?php if(isset($updateResp)) echo $updateResp ;?>
      <?php if(isset($message)) echo $message ;?>
		</div>
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
