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
<html>
<head>
	
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Contact</title>
    <link rel="stylesheet" type="text/css" href="./contact_files/StandaardOpmaak.css">
</head>

<body>
	<div class="banner">
		<div style="float:left;margin-left:7px">
			Contact
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


<form id="contactform" action="contact.php#" method="post">
    <div class="row">
        <label for="name">Name*</label>
        <span class="fieldbox"><input type="text" name="name" id="name" value=""></span>
    </div>
    <div class="row">
        <label for="email">Email*</label>
        <span class="fieldbox"><input type="text" name="email" id="email" value=""></span>
    </div>
    <div class="row">
        <label for="msg">Message</label>
        <span class="msgbox"><textarea class="area" id="msg" name="msg" rows="8" cols="30"></textarea></span>
    </div>

    <input type="submit" value="Send" id="sendbutton" name="sendbutton">
    <p>Fields with "*" are required field.</p>
</form>
</body>
</html>