<?php 

	require('menu.php');
	start();
	if(!isset($_SESSION['User_ID'])){
		$_SESSION['Error'] = 'You need to log in to see this page';
		header( 'Location: login.php' );
		exit;
	} else if($_SESSION['Acces_ID'] != 0){
		header('HTTP/1.0 404 Not Found');
		echo "<h1>404 Not Found</h1>";
		echo "The page that you have requested could not be found.";
		echo $_SESSION['Acces_ID'] . " = Acces_ID";
		exit;
	}
	$dbusername='webdb13IN6B';
	$dbpassword='stafrana';
	$db = new PDO("mysql:host=localhost;dbname=webdb13IN6B;charset=UTF-8", $dbusername, $dbpassword);

?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
	<link rel="stylesheet" type="text/css" href="StandaardOpmaak.css" />
	<style>
		#line {
			bottom: 10%;
			height: 2px;
			background-color: #3F48CC;
		}
		.settingbox{
			float: rigth;
			margin-top: 25px;
			padding: 7px;
		}
		.submenu{
			margin-top: 25px;
			padding: 7px;
			width: 20%;
			float: left;
			text-align: left;
			background-color:#3F48CC;
			color:white;
			font-weight:bold;
		}
		.submenu a:link {color:white;text-decoration: none;}     
		.submenu a:visited {color:white;text-decoration: none;} 
		.submenu a:hover {color:white;text-decoration: none;}  
		.submenu a:active {color:white;text-decoration: none;}
		
		.options{
			height: auto;
			width: 70%;
			border-style: solid;
			border-color:#3F48CC;
			float: right;
			margin-top: 25px;
			padding: 7px;
			overflow: visible;
		}
	
	</style>
</head>
<body>
	<?php
		banner("Admin pannel");
		menu();
	?>
<div>
	<div class="submenu">
		<h3>Submenu</h3><br>
		<a href="config_page.php?submenu=General">General</a><br>
		<a href="config_page.php?submenu=Accounts">Accounts</a><br>
		<a href="config_page.php?submenu=Ranks">Ranks</a><br>
		<a href="config_page.php?submenu=Forums">Forums</a><br>
		<a href="config_page.php?submenu=Moderators">Moderators</a>
	</div>
	<div class='options'>
		<?php
			if(isset($_GET['submenu'])){
				if($_GET['submenu'] === 'General'){
					echo "This is GENERAL!";
				} else if($_GET['submenu'] === 'Accounts'){
					echo "This is Accounts!";
				} else if($_GET['submenu'] === 'Ranks'){
					echo "This is Ranks!";
				} else if($_GET['submenu'] === 'Forums'){
				
					$profile=$db->prepare('SELECT Name FROM Access_Name');
					$profile->execute();
					$AccessNames = $profile->fetchAll();
					
					$profile=$db->prepare('SELECT Forum_name FROM Forums');
					$profile->execute();
					$ForumNames= $profile->fetchAll();
					
					if(isset($_SESSION['Error'])) {
						echo $_SESSION['Error'];
						unset($_SESSION['Error']);
					}?>
					Here you can create new forums or catagories for the forums.<br>
					By default there will not be any catagories.<br><br>
					<form method ="post" action="addforum.php">
						<label for="name">Forum Name:</label><br>
						<input name="name" /><br><br>
						Permissions:<br><br>
						Select a Permission Rank for every of the following attributes:<br> 
						Can see:<br>
						<select name="mydropdown">
							<?php foreach($AccessNames as $rank) {?>
							<option value="<?php echo $rank['Name'];?>"><?php echo $rank['Name'];?></option>
							<?php } ?>
						</select><br>
						<button type="submit"> Submit </button>
					</form>
					<br><div id="line">&nbsp;</div><br>
					
					<form method ="post" action="addcatagory.php">
						<label for="name">Catagory Name:</label><br>
						<input name="name" /><br><br>
						Permissions:<br><br>
						Select a Permission Rank for every of the following attributes:<br> 
						Can see:<br>
						<select name="forum_name">
							<?php foreach($ForumNames as $name) {?>
							<option value="<?php echo $name['Forum_name'];?>"><?php echo $name['Forum_name'];?></option>
							<?php } ?>
						</select><br>
						<button type="submit"> Submit </button>
					</form>
					<?php
				} else if($_GET['submenu'] === 'Moderators'){
					echo "This is Moderators!";
				}
			} else {
				echo "This is the config page";
			}
			?>
	</div>
	<br>
	<br>
</div>


</body>
</html>
