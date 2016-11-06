<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Motor Vehicles Department</title>
	<link rel="stylesheet" href="../css/bootstrap.css">
</head>
<style>
body { padding-top: 30px; }
.navbar {
    margin-bottom: 0;
}
		html, body {
    		height: 100%;

    	}

</style>
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
			<li class="active"><a href="/mvd/">Home</a></li>
		</ul>

		<!-- Right Side Navbar Links -->
		<ul class="nav navbar-nav navbar-right" style="margin-right:1vh">
			<li class="dropdown"><!--Dropdown Menu for the citizen Login & register-->
				<a class="dropdown-toggle" data-toggle="dropdown" href="" >Citizen <b class="caret"></b></a>

				<ul class="dropdown-menu">
					<li><a href="../user/userLogin.php">Login</a></li>
					<li><a href="../user/userReg.php">Register</a></li>
				</ul>
			</li>
			<li class="dropdown"><!--Dropdown Menu for an MVD Official Login & register-->
				<a class="dropdown-toggle" data-toggle="dropdown" href="" >MVD <b class="caret"></b></a>

				<ul class="dropdown-menu">
					<li><a href="mvdLogin.php">Login</a></li>
					<li><a href="mvdreg.php">Register</a></li>
				</ul>
			</li>

		</ul>
		<!-- Right Side Navbar Links End -->

		<!-- ****END NAVBAR LINKS*** -->
	</nav>
	<!-- Navbar End -->

	<h3 class="text-center jumbotron" >MVD Registration</h3></h3><br>
  <div class="container">
		<div class="row">

			<form role="form" class="form-horizontal" method="post" action="handleMvdReg.php" >
				<div id="emailFormGroup" class="form-group has-feedback">
					<label for="uemail" class="col-xs-3 col-sm-2 control-label">Email</label>
					<div class="col-xs-6 col-sm-4">
						<input type="email" class="form-control " id="uemail" name="uemail" placeholder="email" required>
						<span id="avialable" style="font-size:1.5em;"></span>
					</div>
					<div class="col-xs-3 col-sm-4">
						<p id="EmailErMessage" class="text-danger"></p>
					</div>

				</div>
				<div class="form-group">
					<label for="ufname" class="col-xs-6 col-sm-2 control-label">Name</label>
					<div class="col-xs-6 col-sm-4">
						<input type="text" placeholder="first name" class="form-control" id="ufname" name="ufname"required>
					</div>
				</div>
        <div class="form-group">
					<label for="ufname" class="col-xs-6 col-sm-2 control-label">Phone</label>
					<div class="col-xs-6 col-sm-4">
						<input type="number" placeholder="Phone Number" class="form-control" id="ufname" name="phone" required>
					</div>
				</div>
				<div class="form-group">
					<label for="upass" class="col-xs-6 col-sm-2 control-label">Password</label>
					<div class="col-xs-6 col-sm-4">
						<input type="password" class="form-control" id="upass" placeholder="password" name="upass" required>
					</div>
					<span id="helpBlock-Password" class="help-block"></span>
				</div>
				<div class="form-group">
					<label for="uconfpass" class="col-xs-6 col-sm-2 control-label">Confirm Password</label>
					<div class="col-xs-6 col-sm-4">
						<input type="password" class="form-control" id="uconfpass" name="uconfpass" placeholder="Confirm Password" required>
					</div>
					<span id="helpBlock-confPassword" class="help-block"></span>
				</div>
				<div class="form-group">

					<div class="col-xs-offset-6 col-sm-offset-2 col-xs-6 col-sm-4">
						<button id="sbutton" type="submit" class="btn btn-primary" disabled="disabled"><span class="glyphicon glyphicon-user"></span> Register</button>
					</div>
				</div>
			</form>
		</div>
	</div>


	<script src="../js/jquery-2.1.4.js"></script>
  <script src="../js/checkEmailExistMvd.js"></script>
	<script src="../js/bootstrap.min.js"></script>

</body>
</html>
