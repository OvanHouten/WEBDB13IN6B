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
<!DOCTYPE html>
<HTML>
<HEAD>
	<TITLE>Login</TITLE>
	<link rel="stylesheet" type="text/css" href="StandaardOpmaak.css" />
	<style>
        .box {
			text-align: left;
			background-color:#3F48CC;
			color:white;
			font-weight:bold;
			margin:120px auto;
			width: 50%;
			padding:7px;
			overflow: hidden;
			box-shadow: 0px 5px 20px #888888;
        }
		.box a:link {color:white;text-decoration: none;}     
		.box a:visited {color:white;text-decoration: none;} 
		.box a:hover {color:white;text-decoration: none;}  
		.box a:active {color:white;text-decoration: none;}
    </style>
</HEAD>

<BODY>
	<div class="banner">
		<div style="float:left;margin-left:7px">
			Login
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

	<center>
	<?php if($user === "Guest"){ ?>
	<div class=box>
		Login<center><br>
		<?php
			if(isset($_SESSION['Error'])){
				echo $_SESSION['Error'];
				unset( $_SESSION['Error']);
			}
		?>
		<form method ="post" action="loginscript.php">
			<label for="name">Username:</label><br>
			<input name="name" /><br>
			<label for="password">Password:</label><br>
			<input name="password" type="password"/><br>
			<button type="submit"> Submit </button>
            </center>
			<div style="float:left;margin-left:7px">
				<h6><a href="register.php">Register</a></h6>
			</div>
			<div align="right"  style="overflow: hidden;margin-right:7px;">
			</div>
      </form>
	</div>
	<?php } else {?>
	<div class=box>
		<center><a href = "logout.php"> Log out </a> </center>
	</div>
	<?php } ?>
	</center>
</BODY>
</HTML>
