<?php 
session_start();
if(!isset($_SESSION['User_ID'])){
	$user = 'Guest';
	$login = 'Log in';
} else {
	$login = 'Log out';
	$user = $_SESSION['User'];
}
if(!isset($_SESSION['User_ID'])){
	//header("Location: http://webdb.science.uva.nl/webdb13IN6B/login.php");
}

$dbusername='webdb13IN6B';
$dbpassword='stafrana';
$db = new PDO("mysql:host=localhost;dbname=webdb13IN6B;charset=UTF-8", $dbusername, $dbpassword);

$thread=$db->prepare('SELECT * FROM Threads WHERE ID = :ID');
$thread->bindValue(':ID', 1);
$thread->execute();
$row = $thread->fetch();
$titel = $row['Title'];
$UserID = $row['User_ID'];
$since = $row['Time'];
$post = $row['Message'];
$threadID = $row['ID'];
?>

<html>
<head>
	<title><?php $titel ?></title>
	<link rel="stylesheet" type="text/css" href="StandaardOpmaak.css" />

	<style type="text/css">
	.template{
		height:205px;
		margin-top:10px;
	}
	.profilebar{
		background-color:#3F48CC;
		height:200px;
		width:20%;
		float:left;
		color:white;
		padding-top:5px;
		font-family:sans-serif;
		font-size:13pt;
	}
	.upperbar{
		background-color:#3F48CC;
		padding-top:7px;
		padding-right:7px;
		margin-left:20%;
		height:23px;
		width:*%;
		color:white;
		font-size:12pt;
	}
	.upperbar a:link {color:white;text-decoration: none;}     
	.upperbar a:visited {color:white;text-decoration: none;} 
	.upperbar a:hover {color:white;text-decoration: none;}  
	.upperbar a:active {color:white;text-decoration: none;}
	
	.post{
		background-color:white;
		padding:5px;
		margin-left:20%;
		height:140px;
		width:*%;
		color:black;
		font-family:sans-serif;
		font-size:10pt;
	}
	.timeofpost{
		background-color:white;
		padding:5px;
		margin-left:20%;
		height:15px;
		width:*%;
		color:grey;
		font-family:sans-serif;
		font-size:8pt;
	}
	.path{
		font-size:10pt;
		margin-top:10px;
	}
	.textarea {
		left:20%;
		width:100%;
		height:165px;
		font-family:sans-serif;
		font-size:10pt;
		resize:none;
	}
	</style>
</head>

<body>
		<div class="banner">
		<div style="float:left;margin-left:7px">
			Thread
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


	<div class="path">
		<a href="index.php">Forum</a> > <a href="thread.php">subonderwerp</a> >
		<a href="thread.php">Dit is mijn draad yeah!</a>
	</div>

	<!-- -->
	<div class="template">
		<div class="profilebar">
			<center><?php echo $threadposter ?><br><br>
			<img src="steve.jpg" width="40px" height="40px"><br>
			<p style="font-size:10pt;">
				Level 1<br>
				Posts: <?php $threadposterposts ?> <br>
				Joined:<br>
				99 Dec 9999
			</p></center>
		</div>

		<div class="upperbar">
			<?php echo $titel ?>
		</div>

		<div class="post">
			<?php echo $message ?>
		</div>

		<div class="timeofpost" align="right">
			<?php echo (date("d M Y H:i", strtotime($threadsince))); ?>
		</div>
	</div>

	<!--topicpost/question(Post 0)-->
<!--
	<div class="template">
		<div class="profilebar">
			<center>Steve<br><br>
			<img src="steve.jpg" width="40px" height="40px"><br>
			<p style="font-size:10pt;">
				Level 99<br>
				Posts: 9999<br>
				Joined:<br>
				99 Dec 9999
			</p></center>
		</div>

		<div class="upperbar">
			Dit is mijn draad yeah!
		</div>

		<div class="post">
			Hier komt een mooie vraag/opmerking of iets anders waar de draad (thread) mee begint maar wat gebeurt er nu als de tekst lang wordt zonder te enteren, niet de piratenmanier dus... dat was een lame joke...
		</div>

		<div class="timeofpost" align="right">
			13:34 13 jan 2013
		</div>
	</div>
-->

	<!--antwoord/reply(post 1)-->
<!--
	<div class="template">
		<div class="profilebar">
			<center>Steve<br><br>
			<img src="steve.jpg" width="40px" height="40px"><br>
			<p style="font-size:10pt;">
				Level 99<br>
				Posts: 9999<br>
				Joined:<br>
				99 Dec 9999
			</p></center>
		</div>

		<div class="upperbar" align="right">
			<a href="Reply.php">Reply</a> #1
		</div>

		<div class="post">
			Waarom reageert niemand op mijn post!
		</div>

		<div class="timeofpost" align="right">
			13:35 13 jan 2013
		</div>
	</div>
-->

	<!-- New post textarea -->
	<?php
	if(isset($_SESSION['User_ID'])) {
		$userlogin = $db->prepare('SELECT * FROM User WHERE ID = :ID');
		$userlogin->bindValue(':ID', $_SESSION['User_ID']);
		$userlogin->execute();
		$row = $userlogin->fetch();
		$useruname = $row['Name'];
		$usersince = $row['Since'];
	
		$replynmr = $db->prepare('SELECT COUNT(User_ID) FROM Replys 
									WHERE User_ID=:ID');
		$replynmr->bindValue(':ID', $_SESSION['User_ID']);
		$replynmr->execute();
		$row2 = $replynmr->fetch();
		$posts = $row2['COUNT(User_ID)'];
	?>
	
	<div class="template">
		<div class="profilebar">
			<center><?php echo $useruname ?><br><br><!---->
			<img src="steve.jpg" width="40px" height="40px"><br>
			<p style="font-size:10pt;">
				Level 1<br>
				Posts: <?php echo $posts?><br><!---->
				Joined:<br>
				<?php echo (date("d M Y H:i", strtotime($usersince))); ?><!---->
			</p></center>
			</div>

		<form name="newpost" action="reply.php" method="post">
			<div class="upperbar" align="right">
				<input type="submit" value="Reply">
				<!--<a href="Reply.php" type="submit">Reply</a>-->
			</div>

			<div class="post">
				<textarea name="message" class="textarea" name="NewPost"></textarea>
			</div>
		</form>
	</div>
	<?php } ?>
	
</body>
</html>
