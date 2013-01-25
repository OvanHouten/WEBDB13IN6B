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
	<title>Topics of subject "Hoi"</title>
	<link rel="stylesheet" type="text/css" href="./index_files/StandaardOpmaak.css">
</head>

<body>

	<div class="banner">
		<div style="float:left;margin-left:7px">
			Subject
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


<table class="topic-table">
<tbody>
    <tr>
        <th width="60%">Topic name</th>
        <th width="20%">Author</th>
        <th width="20%">Last posted</th>
    </tr>
    <tr>
        <td><a href="thread.html">Topic 1</a></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td><a href="thread.html">Topic 2</a></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td><a href="thread.html">Topic 3</a></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td><a href="thread.html">Topic 4</a></td>
        <td></td>
        <td></td>
    </tr>
</tbody>
</table>

</body>
</html>
