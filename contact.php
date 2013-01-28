<?php
include_once('menu.php');
?>
<!DOCTYPE html>
<html>
<head>
	
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Contact</title>
    <link rel="stylesheet" type="text/css" href="StandaardOpmaak.css">
    <link rel="stylesheet" type="text/css" href="contact.css">
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

<?php echo $menu_html; ?>

<div class="about-us">
<h1>About us</h1>
<table class="tabel">
	<tr>
		<td><h2><a href="http://www.facebook.com/simon.csoma?fref=ts">simon csoma</a></h2></td>
		<td><h2><a href="http://www.facebook.com/kasper.vanveen.7">kasper van veen</a></h2></td>
		<td><h2><a href="http://www.facebook.com/olaf.vanhouten?ref=ts&fref=ts">olaf van houten</a></h2></td>
	</tr>
	<tr>
		<td>informatie</td>
		<td>informatie</td>
		<td>informatie</td>
	</tr>

</table>
</div>
</body>
</html>
