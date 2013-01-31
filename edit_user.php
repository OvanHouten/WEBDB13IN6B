<?php
	$dbusername='webdb13IN6B';
	$dbpassword='stafrana';
	$db = new PDO("mysql:host=localhost;dbname=webdb13IN6B;charset=UTF-8", $dbusername, $dbpassword);

	$sql = 'UPDATE User SET Name= ? , Acces_name_ID = ? WHERE ID = ?';   
	$del=$db->prepare($sql);
	$del->bindValue(1,$_REQUEST['name']);
	$del->bindValue(2,$_REQUEST['acces_id']);
	$del->bindValue(3,$_REQUEST['id']);
	$del->execute();
	header( 'Location: config_page.php?submenu=Accounts');
?>