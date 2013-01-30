<?php
require 'menu.php';

session_start();
if(!isset($_SESSION['User_ID'])){
	header("Location: http://webdb.science.uva.nl/webdb13IN6B/login.php");
	$_SESSION['Error'] = "You need to log in to see this page";
	exit;
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
		.upperbar a:link {color:white;text-decoration: none;}     
		.upperbar a:visited {color:white;text-decoration: none;} 
		.upperbar a:hover {color:white;text-decoration: none;}  
		.upperbar a:active {color:white;text-decoration: none;}
		.column{
			background-color:white;
			padding-top:5px;
			padding-left:5px;
			height:110px;
			width:*%;
			color:black;
			font-family:sans-serif;
			font-size:13pt;
			}
		.infobox{
			background-color:white;
			padding-left:5px;
			padding-top:5px;
			margin-left:20%;
			height:155px;
			width:*%;
			color:black;
			font-family:sans-serif;
			font-size:10pt;
		}
	</style>
</head>

<body>
	<?php  
		banner("Profile");
		menu();
	?>
	
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

		<div class="upperbar" align="right">
			<a href="editprofile.php">Edit</a>
		</div>

		<!--Let op, als de lijst langer word, moeten de hoogtes worden aangepast!!!-->
		
		<div class="column">
			<table width="80%" style="font-size:12px;">
			<tr>
				<td style="padding-top:5px; padding-bottom:6px;" width="50%" ><b>In-game name:</b></td>
				<td><?php echo $username ?></td>
			</tr>
			<tr>
				<td style="padding-top:5px; padding-bottom:6px;" ><b>Firstname:</b></td>
				<td><?php echo $fname ?></td>
			</tr>
			<tr>
				<td style="padding-top:5px; padding-bottom:6px" ><b>Lastname:</b></td>
				<td><?php echo $lname ?></td>
			</tr>
			<tr>
				<td style="padding-top:5px; padding-bottom:6px" ><b>Bought Minecraft:</b></td>
				<td>Yes</td>
			</tr>
			
			</table>
		</div>
	
		<div class="infobox">
			<b>Info about me: </b><br>
			<?php echo $aboutme?>
		</div>
	</div>
</body>
</html>
