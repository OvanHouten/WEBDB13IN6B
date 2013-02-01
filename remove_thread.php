<?php
	$dbusername='webdb13IN6B';
	$dbpassword='stafrana';
	$db = new PDO("mysql:host=localhost;dbname=webdb13IN6B;charset=UTF-8", $dbusername, $dbpassword);
	
	$sql = 'UPDATE Threads SET Hidden = 1 WHERE ID = ?';
	$profile=$db->prepare($sql);
	$profile->bindValue(1, $_POST['thread_id']);
	$profile->execute();
	
	header( 'Location:topics.php?category_id=' . $_POST['category_id']);
	
?>