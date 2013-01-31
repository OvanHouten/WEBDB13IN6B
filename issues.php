<?php
require 'menu.php';
start();

/*
 * kijk of iemand is ingelogd, anders stuur je em daar naar de inlog pagina.
 */
if(!isset($_SESSION['User_ID'])){
	header("Location: login.php");
	$_SESSION['Error'] = "You need to log in to see this page";
	exit;
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
			height:260px;
			font-family:sans-serif;
		   	font-size:10pt;
			resize:none;
		}
	</style>
</head>

<body>
	<!-- Banner en Menubalk -->
	<?php  
		banner("Profile");
		menu();
	?>
	
	<!-- Formulier voor verzenden van een report -->
	<div class="box">
	<form action="Bugreport.php" method="post" >
<!--		
		<label for="name">Name:</label><br>
		<input type="text" name="name" /><br><br>
		<label for="email">E-mail:</label><br>
		<input name="email" type="email" /><br><br>
-->	
		<div class="row">
			<label for="Bugreport">Bug report</label><br>
			<textarea class="textarea" name="Bugreport" placeholder="Type your bug report here, this may also include grammar and spelling mistakes."></textarea><br>
		<input type="submit" value="Send" style="float:right;">
		</div>
	</form>
	</div>

</body>
</html>
