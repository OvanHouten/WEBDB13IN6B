<?php
session_start();
if(!isset($_SESSION['User_ID'])){
	$user = 'Guest';
	$login = 'Log in';
} else {
	$login = 'Log out';
	$user = $_SESSION['User'];
}
?>
<html>
<head>
	<title>Issues</title>
	<link rel="stylesheet" type="text/css" href="StandaardOpmaak.css" />
	<style>
		.box {
			text-align: left;
			background-color:#3F48CC;
			color:white;
			font-weight:bold;
			margin:35px auto;
			width: 70%;
			padding:7px;
			height:300px;
			box-shadow: 0px 5px 20px #888888;

		}
		
		.box a:link {color:white;text-decoration: none;}     
		.box a:visited {color:white;text-decoration: none;} 
		.box a:hover {color:white;text-decoration: none;}  
		.box a:active {color:white;text-decoration: none;}

		.textarea {
			width:100%;
			height:140px;
			font-family:sans-serif;
		   	font-size:10pt;
			resize:none;
		}
	</style>
</head>

<body>
		<div class="banner">
		<div style="float:left;margin-left:7px">
			Issues
		</div>
		<div align="right"  style="overflow: hidden;margin-right:7px;">
			<?php
				echo "Welcome ".$user;
			?>
		</div>
	</div>
	<div class="menu">
	<a href = "index.php"> Forum </a> |
	<a href = "profile.php"> Profile </a> |
	<a href = "login.php"> <?php echo $login; ?> </a> | 
	<a href = "config_page.php"> Admin Panel </a> |
	<a href = "issues.php"> Issues </a> |
	<a href = "contact.php"> Contact </a>
</div>

	<div class="box">
	<form action="Bugreport.php" method="post" >
		<label for="name">Name:</label><br>
		<input type="text" name="name" /><br><br>
		<label for="email">E-mail:</label><br>
		<input name="email" type="email" /><br><br>
		<div class="row">
			<label for="Bugreport">Bug report</label><br>
			<textarea class="textarea" name="Bugreport" placeholder="Type your bug report here, this may also include grammar and spelling mistakes."></textarea><br>
		<input type="submit" style="float:right;">
		<!--
		<div align="right" style="overflow: hidden;margin-right:7px;">
			<h3><a type="submit" href="Bugreport.php">Send</a></h3>
		</div>
		-->
		</div>
	</form>
	</div>

</body>
</html>
