<?php
	session_start();
	if(!isset($_SESSION["User"])){
		$_SESSION['User'] = "Guest";
	}
?>
<!DOCTYPE html>
<HTML>
<HEAD>
	<TITLE>Register</TITLE>
	<link rel="stylesheet" type="text/css" href="StandaardOpmaak.css" />
	<style>
		.box{
			margin: 25px 25% 25%;
			background-color:#3F48CC;
			color:white;
			font-weight:bold;
			overflow:hidden;
			padding: 15px; 
		}
		.collum1{
			float: left;
			width: 19%;
			overflow:hidden;
			padding: 10px;
		}
		.collum2{
			padding: 10px;
			float: right;
			width:70%;
			overflow:hidden;
		}
	</style>
</HEAD>

<BODY>
	<div class="banner">
		<div style="float:left;margin-left:7px">
			Account creation
		</div>
		<div align="right"  style="overflow: hidden;margin-right:7px;">
			<?php
				echo "Welcome ".$_SESSION['Permission'];
			?>
		</div>
		
	</div>
	<div class="menu">
		<a href = "index.php"> Forum </a> |
		<a href = "profile.php"> User page </a> |
		<a href = "login.php"> Login </a> | 
		<a href = "config page.php"> Admin Pannel </a> |
		<a href = "issues.html"> Bugreport </a> |
		<a href = "contact.php"> Contact </a> 
	</div>
	
	<div class=box>
		<?php
			if(isset($_SESSION['Error'])){
				echo $_SESSION['Error'];
				unset($_SESSION['Error']);
			}
		?>
		<form method ="post" action="addMember.php">
				User Name:<br>
				<input name="name" /><br>
				<br>
				Password:<br>
				<input name="password" type="password"/><br>
				<br>
				Re-Type Password:<br>
				<input name="verify_password" type="password"/><br>
				<br>
				
				E-mail addres:<br>
				<input name="email" size="35"/><br>
				<br>
				Gender:<br>
				<input name="gender" type="radio" value="male" />Male<br>
				<input name="gender" type="radio" value="female" />Female<br>
				<br>
				<button type="submit"> Submit </button>
			</form>
	</div>
</body>
</html>