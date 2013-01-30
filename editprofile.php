<?php
require 'menu.php';

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
			padding:5px;
			height:20px;
			width:*%;
			color:white;
			font-size:13pt;
		}
		.column{
			background-color:white;
			padding-top:5px;
			padding-left:5px;
			height:115px;
			width:*%;
			color:black;
			font-family:sans-serif;
			font-size:13pt;
		}
		.infobox{
			background-color:white;
			padding-left:5px;
			padding-right:5px;
			margin-left:20%;
			height:155px;
			width:*%;
			color:black;
			font-family:sans-serif;
			font-size:10pt;
		}
		.textarea {
			left:20%;
			width:100%;
			height:135px;
			font-family:sans-serif;
			font-size:10pt;
			resize:none;
		}
	</style>
</head>

<body>
	<?php  
		banner("Profile");
		menu();
	?>
	
	<div style="box-shadow: 0px 5px 20px #888888;">
	<form action="edit.php" method="post">
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

		<div align="right" class="upperbar">
			<input type="submit" value="submit"/>
		</div>

		<div class="column">
			<table width="80%" style="font-size:12px;">
			<tr>
				<td width="50%"><b>In-game name:</b></td>
				<td><input type="text" name="fname" value="<?php echo $username ?>"/></td>
			</tr>
			<tr>
				<td><b>Firstname:</b></td>
				<td><input type="text" name="fname" value="<?php echo $fname ?>" /></td>
			</tr>
			<tr>
				<td><b>Lastname:</b></td>
				<td><input type="text" name="lname" value="<?php echo $lname ?>" /></td>
			</tr>
			<tr>
				<td><b>Bought Minecraft:</b></td>
				<td><input type="text" name="lname" value="yes" /></td>
			</tr>
			</table>
		</div>
		<!--Let op, als de lijst langer word, moeten de hoogtes worden aangepast!!!-->
	
		<div class="infobox">
			<b>Info about me: </b><br>
			<textarea class="textarea" name="aboutme"><?php echo $aboutme ?></textarea>
		</div>	
	</form>
	</div>
</body>
</html> 