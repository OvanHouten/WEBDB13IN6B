<?php
	$dbusername='webdb13IN6B';
	$dbpassword='stafrana';
	$db = new PDO("mysql:host=localhost;dbname=webdb13IN6B;charset=UTF-8", $dbusername, $dbpassword);
	
	$profile=$db->prepare('SELECT Name FROM (SELECT * FROM Categories WHERE Forum_ID = :ID) AS F WHERE Name = :Name');
	$profile->bindValue(':Name',$_POST['name']);
	$profile->bindValue(':ID',$_POST['forum_id']);
	$profile->execute();
	$row = $profile->fetch();

	if($row['Name'] == $_POST['name']){
		$_SESSION['Error'] = $_POST['name'] . " already exists in " . $_POST['forum_name'];
		header( 'Location: config_page.php?submenu=Forums');
		exit;
	}
	
	$profile=$db->prepare('INSERT INTO Categories (Forum_ID, Name, Permission_level)
			VALUES(?,?,?)');
	$profile->bindValue(1, $_POST['forum_id']);
	$profile->bindValue(2, $_POST['name']);
	$profile->bindValue(3, $_POST['acces']);
	$profile->execute();
	
	header( 'Location: config_page.php?submenu=Forums');
	
?>