<?php
	$dbusername='webdb13IN6B';
	$dbpassword='stafrana';
	$db = new PDO("mysql:host=localhost;dbname=webdb13IN6B;charset=UTF-8", $dbusername, $dbpassword);
	
	$profile=$db->prepare('SELECT ID FROM Forums WHERE Forum_name = :Name');
	$profile->bindValue(':Name',$_POST['forum_name']);
	$profile->execute();
	$row = $profile->fetch();
	$forumID = $row['ID'];
	
	$profile=$db->prepare('SELECT Name FROM (SELECT * FROM Categories WHERE ID = :ID) AS F WHERE Name = :Name');
	$profile->bindValue(':Name',$_POST['name']);
	$profile->bindValue(':ID',$forumID);
	$profile->execute();
	$row = $profile->fetch();

	if($row['name'] == $_POST['name']){
		$_SESSION['Error'] = $_POST['name'] . " already exists in " . $_POST['forum_name'];
		header( 'Location: config_page.php?submenu=Forums');
		exit;
	}
	
	$profile=$db->prepare('INSERT INTO Categories (Forum_ID, Name, Permission_level)
			VALUES(?,?,?)');
	$profile->bindValue(1, $forumID);
	$profile->bindValue(2, $_POST['name']);
	$profile->bindValue(3, 0);
	$profile->execute();
	
	header( 'Location: config_page.php?submenu=Forums');
	
?>