<?php 
require 'menu.php';

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

//hier moet nog wat gebeuren met het linken van de threads via sessies(denk ik).
$thread_ID = 1;

$thread=$db->prepare('SELECT * FROM Threads WHERE ID = :ID');
$thread->bindValue(':ID', $thread_ID);
$thread->execute();
$row = $thread->fetch();
$titel = $row['Title'];
$UserID = $row['User_ID'];
$since = $row['Time'];
$post = $row['Message'];
$threadID = $row['ID'];

$posterinfo = $db->prepare('SELECT * FROM User WHERE ID = :ID');
$posterinfo->bindValue(':ID', $UserID);
$posterinfo->execute();
$row = $posterinfo->fetch();
$username=$row['Name'];
$usersince=$row['Since'];

$replynmr = $db->prepare('SELECT COUNT(User_ID) FROM Replys WHERE
								User_ID=:ID');
$replynmr->bindValue(':ID', $UserID);
$replynmr->execute();
$row = $replynmr->fetch();
$posts = $row['COUNT(User_ID)'];
?>

<html>
<head>
	<title><?php echo $titel ?></title>
	<link rel="stylesheet" type="text/css" href="StandaardOpmaak.css" />

	<style type="text/css">
	.template{
		height:205px;
		margin-top:10px;
		box-shadow: 0px 5px 20px #888888;
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
		font-family:sans-serif;
		color:black;
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
	<?php  
		banner("Profile");
		menu();
	?>


	<div class="path">
		<a href="index.php">Forum</a> > <a href="thread.php">subonderwerp</a> >
		<a href="thread.php">Dit is mijn draad yeah!</a>
	</div>

	<!-- FIRST POST THREADSTARTER -->
	<div class="template">
		<div class="profilebar">
			<center><?php echo $username ?><br><br>
			<img src="steve.jpg" width="40px" height="40px"><br>
			<p style="font-size:10pt;">
				Level 1<br>
				Posts: <?php echo $posts ?> <br>
				Joined:<br>
				<?php echo (date("d M Y H:i", strtotime($usersince))); ?>
			</p></center>
		</div>

		<div class="upperbar">
			<?php echo $titel ?>
		</div>

		<div class="post">
			<?php echo $post ?>
		</div>

		<div class="timeofpost" align="right">
			<?php echo date("d M Y H:i", strtotime($since)); ?>
		</div>
	</div>

	<!-- PostLoading Algorithm -->
	<?php
	$thread=$db->prepare('SELECT * FROM Replys WHERE Thread_ID = :ID');
	$thread->bindValue(':ID', $thread_ID);
	$thread->execute();
	$arrayrows = $thread->fetchAll();

	foreach ($arrayrows as $row) {
		$nmrpost = $row['Post_number'];
		$timepost = $row['Time'];
		$post = $row['Text'];
		$UserID = $row['User_ID'];
		
		$userinfo=$db->prepare('SELECT * FROM User WHERE ID = :ID');
		$userinfo->bindValue(':ID', $UserID);
		$userinfo->execute();
		$row = $userinfo->fetch();
		
		$userpost = $row['Name'];
		$timejoined = $row['Since'];
		
		$replynmr = $db->prepare('SELECT COUNT(User_ID) FROM Replys WHERE
								User_ID=:ID');
		$replynmr->bindValue(':ID', $UserID);
		$replynmr->execute();
		$row2 = $replynmr->fetch();
		$posts = $row2['COUNT(User_ID)']
	?>
	<div class="template">
		<div class="profilebar">
			<center><?php echo $userpost ?><br><br>
			<img src="steve.jpg" width="40px" height="40px"><br>
			<p style="font-size:10pt;">
				Level 1<br>
				Posts: <?php echo $posts ?><br>
				Joined:<br>
				<?php echo date("d M Y H:i", strtotime($timejoined)) ?>
			</p></center>
		</div>

		<div class="upperbar" align="right">
		#<?php echo $nmrpost ?>
		</div>

		<div class="post">
			<?php echo $post ?>
		</div>

		<div class="timeofpost" align="right">
			<?php echo date("d M Y H:i", strtotime($timepost)) ?>
		</div>
	</div>
	<?php } ?>

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
