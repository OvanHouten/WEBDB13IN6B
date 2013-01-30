<?php
	$dbusername='webdb13IN6B';
	$dbpassword='stafrana';
	$db = new PDO("mysql:host=localhost;dbname=webdb13IN6B;charset=UTF-8", $dbusername, $dbpassword);
	
	$profile=$db->prepare('SELECT 1 FROM  WHERE Name = :Name');
	$profile->bindValue(':Name',$_POST['name']);
	$profile->execute();
	$row = $profile->fetch();

	if($row > 0){
		$_SESSION['Error'] = "Forum already exists";
		header( 'Location: config_page.php?submenu=Forums');
		exit;
	}
	
	$profile=$db->prepare('INSERT INTO Forums (Forum_name, Permission_level)
			VALUES(?,?)');
	$profile->bindValue(1, $_POST['name']);
	$profile->bindValue(2, 0);
	$profile->execute();
	
	header( 'Location: config_page.php?submenu=Forums');
	
?>