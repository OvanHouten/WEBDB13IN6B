<?php
// eerste function die op elka pagina moet worden aan geroepen
function start(){
	session_start();
	if(!isset($_SESSION['User_ID'])){
		$_SESSION['user'] = 'Guest';
		$_SESSION['login'] = 'Log in';
	} else {
		$_SESSION['login'] = 'Log out';
	}
}
// Menu zoals het hoort
function menu()
{
?>
<div class="menu">
	<a href = "index.php"> Forum </a> |
	<a href = "profile.php?username<?php echo $_SESSION['user'] ?>"> Profile </a> |
	<a href = "login.php"> <?php echo $_SESSION['login']; ?> </a> | <?php if(isset($_SESSION['Acces_ID'])) { if($_SESSION['Acces_ID'] == 1){ ?>
	<a href = "config_page.php"> Admin Panel </a> | <?php } } ?>
	<a href = "issues.php"> Issues </a> |
	<a href = "contact.php"> Contact </a>
</div>
<?php
}
function banner($title){?>
	<div class="banner">
			<div style="float:left;margin-left:7px">
				<?php echo $title; ?>
			</div>
			<div align="right"  style="overflow: hidden;margin-right:7px;">
				<?php
					echo "Welcome ".$_SESSION['user'];
				?>
			</div>
	</div>
<?php } ?>