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

/* 
 * connectie met de sql database maken.
 */
$dbusername='webdb13IN6B';
$dbpassword='stafrana';
$dbuser = new PDO("mysql:host=localhost;dbname=webdb13IN6B;charset=UTF-8", $dbusername, $dbpassword);

/*
 * Ophalen van de User gegevens en in php-variabelen zetten
 */
$profile=$dbuser->prepare('SELECT * FROM User WHERE ID = :ID');
$profile->bindValue(':ID', $_SESSION['User_ID']);
$profile->execute();
$row = $profile->fetch();
$username = $row['Name'];
$since = $row['Since'];
$fname = $row['FirstName'];
$lname = $row['LastName'];
$aboutme = $row['AboutMe'];
$job = $row['Job'];

/*
 * Tellen van het aantal posts van een user.
 */
$replynmr = $dbuser->prepare('SELECT COUNT(User_ID) FROM Replys WHERE
								User_ID=:ID');
$replynmr->bindValue(':ID', $_SESSION['User_ID']);
$replynmr->execute();
$row2 = $replynmr->fetch();
$posts = $row2['COUNT(User_ID)'];

/*
 * Ophalen van de bijpassende ranks(kijkt naar het aantal posts)
 */
$ranks = $dbuser->prepare('SELECT Name FROM Ranks WHERE ID = (SELECT MAX(ID) FROM Ranks WHERE number_of_posts < :posts)');
$ranks->bindValue(':posts', $posts);
$ranks->execute();
$row3 = $ranks->fetch();
$rank = $row3['Name'];
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
	<!-- Banner en Menubalk -->
	<?php  
		banner("Profile");
		menu();
	?>
	
	<!-- Edit-Profile-blok, alle variabelen zijn al geladen en worden alleen 
	opgeroepen  hier staat ook het formulier.-->
	<div style="box-shadow: 0px 5px 20px #888888;">
	<form action="edit.php" method="post">
		<div class="profilebar">
			<center><?php echo $username ?><br><br>
			<img src="steve.jpg" width="40px" height="40px"><br>
			<p style="font-size:10pt;">
				Rank: <?php echo $rank ?><br>
				Posts: <?php echo $posts ?><br>
				Joined:<br>
				<?php echo (date("d-m-Y H:i", strtotime($since))); ?>
			</p></center>
		</div>

		<div align="right" class="upperbar">
			<input type="submit" value="Change"/>
		</div>

		<div class="column">
			<table width="80%" style="font-size:12px;">
<!--			
			<tr>
				<td width="50%"><b>In-game name:</b></td>
				<td><input type="text" name="ign" value="<?php echo $username ?>"/></td>
			</tr>
-->
			<tr>
				<td width="50%"><b>Firstname:</b></td>
				<td><input type="text" name="fname" value="<?php echo $fname ?>"  /></td>
			</tr>
			<tr>
				<td><b>Lastname:</b></td>
				<td><input type="text" name="lname" value="<?php echo $lname ?>" /></td>
			</tr>
			<tr>
				<td><b>Job:</b></td>
				<td><input type="text" name="job" value="<?php echo $job ?>" /></td>
			</tr>
			</table>
		</div>
	
		<div class="infobox">
			<b>Info about me: </b><br>
			<textarea class="textarea" name="aboutme"><?php echo $aboutme ?></textarea>
		</div>
		<input method="post" type="hidden" name="Username" value="<?php echo $username ?>" >
	</form>
	</div>
</body>
</html> 