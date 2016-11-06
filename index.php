<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Motor Vehicles Department</title>
	<link rel="stylesheet" href="css/bootstrap.css">
</head>
<style>
body { padding-top: 30px; }
.navbar {
    margin-bottom: 0;
}
.wrapper {
			min-height: 100%;
			background: url('img/IMG_1890.JPG');
		}
		html, body {
    		height: 100%;

    	}
.img-captions{
	padding-top:6em;
	color:white;
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
					<li><a href="user/userLogin.php">Login</a></li>
					<li><a href="user/userReg.php">Register</a></li>
				</ul>
			</li>
			<li class="dropdown"><!--Dropdown Menu for an MVD Official Login & register-->
				<a class="dropdown-toggle" data-toggle="dropdown" href="" >MVD <b class="caret"></b></a>

				<ul class="dropdown-menu">
					<li><a href="mvd/mvdLogin.php">Login</a></li>
					<li><a href="mvd/mvdreg.php">Register</a></li>
				</ul>
			</li>

		</ul>
		<!-- Right Side Navbar Links End -->

		<!-- ****END NAVBAR LINKS*** -->
	</nav>
	<!-- Navbar End -->
	<div class="wrapper">
			<h1 class="text-center img-captions">Forget About The Paper Work Of Your Vehicle !</h1>
			<h1 class="text-center" style="color:white">Simply Enjoy The fredom.</h1>
			<div class="text-center">
				<a type="button" href="user/userReg.php" class="btn btn-lg btn-default">Register Now</a><br />
				<a style="margin-top:2em;text-decoration:none" href="user/userLogin.php"><span class="label label-primary">Login</span></a>
			</div>
	</div>


	<script src="js/jquery-2.1.4.js"></script>
	<script src="js/bootstrap.min.js"></script>

</body>
</html>
