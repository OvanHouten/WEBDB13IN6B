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
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
	<link rel="stylesheet" type="text/css" href="StandaardOpmaak.css" />
	<style>
	
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
<div class="banner">
Control panel
</div>
<div class="menu">
	<a href = "index.php"> Forum </a> |
	<a href = "profile.php"> Profile </a> |
	<a href = "login.php"> <?php echo $login; ?> </a> | 
	<a href = "config_page.php"> Admin Panel </a> |
	<a href = "issues.php"> Issues </a> |
	<a href = "contact.php"> Contact </a>
</div>

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
					?>
					Here you can create new forums.<br>
					By default there will not be any catagories.<br><br>
					<form method ="post" action="addforum.php">
						<label for="name">Forum Name:</label><br>
						<input name="name" /><br>
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
</div>


</body>
</html>
