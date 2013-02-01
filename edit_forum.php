<?php
	$dbusername='webdb13IN6B';
	$dbpassword='stafrana';
	$db = new PDO("mysql:host=localhost;dbname=webdb13IN6B;charset=UTF-8", $dbusername, $dbpassword);
	
	$sql = 'UPDATE Forums SET Permission_level = ? WHERE ID = ?';
	$profile=$db->prepare($sql);
	$profile->bindValue(1, $_POST['forum_acces']);
	$profile->bindValue(2, $_POST['forum_id']);
	$profile->execute();
	
	header( 'Location: config_page.php?submenu=Forums');
	
?>