<?php
	$dbusername='webdb13IN6B';
	$dbpassword='stafrana';
	$db = new PDO("mysql:host=localhost;dbname=webdb13IN6B;charset=UTF-8", $dbusername, $dbpassword);

	$del=$db->prepare('DELETE FROM User WHERE ID = :ID');
	$del->bindValue(':ID', $_REQUEST['id']);
	$del->execute();
	
	header( 'Location: config_page.php?submenu=Accounts');
?>