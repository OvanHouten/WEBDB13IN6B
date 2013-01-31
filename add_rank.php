<?php
	session_start();
	$dbusername='webdb13IN6B';
	$dbpassword='stafrana';
	$dbuser = new PDO("mysql:host=localhost;dbname=webdb13IN6B;charset=UTF-8", $dbusername, $dbpassword);

	$profile=$dbuser->prepare('SELECT * FROM Ranks WHERE Name = :Name');
	$profile->bindValue(':Name', $_REQUEST['name']);
	$profile->execute();
	$row = $profile->fetch();
	
	if($row['Name'] == $_REQUEST['name'] || empty($_REQUEST['name'])) {
		$_SESSION['Error'] = 'Rank already exsists';
		header('Location: config_page.php?submenu=Ranks');
		exit;
	}
	
	if($_REQUEST['number_of_posts'] == $row['Number_of_posts']  /*empty($_REQUEST['Number_of_posts'])*/){
		$_SESSION['Error'] = 'Amount already exsists';
		header('Location: config_page.php?submenu=Ranks');
		exit;
	}
	if(!is_numeric($_REQUEST['number_of_posts'])) {
		$_SESSION['Error'] = 'Amount is not a number';
		header('Location: config_page.php?submenu=Ranks');
		exit;
	}
	
	$profile=$dbuser->prepare('INSERT INTO Ranks (Name, Number_of_posts)
			VALUES(?,?)');
	$profile->bindValue(1, $_REQUEST['name']);
	$profile->bindValue(2, $_REQUEST['number_of_posts']);
	$profile->execute();
	
	header( 'Location: config_page.php?submenu=Ranks');