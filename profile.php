<?php
session_start();
if(!isset($_SESSION['User_ID'])){
	header("Location: http://webdb.science.uva.nl/webdb13IN6B/login.php");
}

$dbusername='webdb13IN6B';
$dbpassword='stafrana';
$dbuser = new PDO("mysql:host=localhost;dbname=webdb13IN6B;charset=UTF-8", $dbusername, $dbpassword);

$username = "niet opgehaald";

$profile=$dbuser->prepare('SELECT * FROM User WHERE ID = :ID');
$profile->bindValue(':ID', $_SESSION['User_ID']);
$profile->execute();
$row = $profile->fetch();
$username = $row['Name'];
$since = $row['Since'];
$fname = $row['FirstName'];
$lname = $row['LastName'];
$aboutme = $row['AboutMe'];

$replynmr = $dbuser->prepare('SELECT COUNT(User_ID) FROM Replys WHERE
								User_ID=:ID');
$replynmr->bindValue(':ID', $_SESSION['User_ID']);
$replynmr->execute();
$row2 = $replynmr->fetch();
$posts = $row2['COUNT(User_ID)']
?>

<html>
<head>
	<title><?php echo $username ?></title>
	<link rel="stylesheet" type="text/css" href="StandaardOpmaak.css" />
	<style type="text/css">
		.profilebar{
			background-color:#3F48CC;
			height:300px;
			width:20%;
			float:left;
			color:white;
			padding-top:5px;
			font-family:sans-serif;
			font-size:13pt;
		}
		.upperbar{
			background-color:#3F48CC;
			margin-top:35px;
			margin-left:20%;
			height:30px;
			width:*%;
			color:white;
			font-size:13pt;
		}
		.column{
			background-color:white;
			padding-top:5px;
			padding-left:5px;
			height:70px;
			width:38%;
			color:black;
			font-family:sans-serif;
			font-size:10pt;
			float:left;
			}
		.infobox{
			background-color:white;
			padding-left:5px;
			margin-left:20%;
			margin-top:75px;
			height:200px;
			width:*%;
			color:black;
			font-family:sans-serif;
			font-size:10pt;
		}
	</style>
</head>

<body>
	<div class="banner">
		Profile
	</div>
	<div class="menu">
	<a href = "index.php"> Forum </a> |
	<a href = "profile.php"> Profile </a> |
	<a href = "login.php"> Login </a> | 
	<a href = "config_page.php"> Admin Panel </a> |
	<a href = "issues.php"> Issues </a> |
	<a href = "contact.php"> Contact </a> 
	</div>
	
	<div style="box-shadow: 0px 5px 20px #888888;">
		<div class="profilebar">
			<center><?php echo $username ?><br><br>
			<img src="steve.jpg" width="40px" height="40px"><br>
			<p style="font-size:10pt;">
				Level 1<br>
				Posts: <?php echo $posts ?><br>
				Joined:<br>
				<?php echo (date("d-m-Y h:m", strtotime($since))); ?>
			</p></center>
		</div>

		<div class="upperbar">
		</div>

		<!--Let op, als de lijst langer word, moeten de hoogtes worden aangepast!!!-->
		<div class="column">
			<b>Surname:</b><br>
			<b>Lastname:</b><br>
			<b>In-game name:</b><br>
			<b>Bought Minecraft:</b>
		</div>
	
		<div class="column">
			<?php echo $fname ?> <br>
			<?php echo $lname ?> <br>
			<?php echo $username ?> <br>
			Yes <br>
		</div>
	
		<div class="infobox">
			<b>Info about me: </b><br>
			<?php echo $aboutme?>
		</div>
	</div>
</body>
</html>
