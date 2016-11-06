

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>MVD Login</title>
	<link rel="stylesheet" href="../css/bootstrap.css">
	<style>
	.navbar {
			margin-bottom: 0;
	}
	</style>
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
		<ul class="nav navbar-nav">
			<li class="active"><a href="#">Home</a></li>
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
	<h3 class="text-center text-primary" >MVD Login</h3><br>
	<div class="container">
		<div class="row">


			<form role="form" class="form-horizontal" method="post" action="handleMvdLogin.php" >
				<div id="emailFormGroup" class="form-group">
					<label for="uemail" class="col-xs-3 col-sm-2 control-label">Email</label>
					<div class="col-xs-6 col-sm-4">
						<input type="email" class="form-control " id="uemail" name="uemail" placeholder="email" required>

					</div>


				</div>

				<div class="form-group">
					<label for="upass" class="col-xs-6 col-sm-2 control-label">Password</label>
					<div class="col-xs-6 col-sm-4">
						<input type="password" class="form-control" id="upass" placeholder="password" name="upass" required>
					</div>
				</div>

				<div class="form-group">

					<div class="col-xs-offset-6 col-sm-offset-2 col-xs-6 col-sm-4">
						<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-user"></span>Login</button>
					</div>
				</div>
			</form>
		</div>
		</div>

	<script src="../js/jquery-2.1.4.js"></script>
	<script src="../js/bootstrap.min.js"></script>
</body>
</html>
