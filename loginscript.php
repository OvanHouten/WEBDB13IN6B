<?php
session_start();
$dbusername='webdb13IN6B';
$dbpassword='stafrana';
$dbuser = new PDO("mysql:host=localhost;dbname=webdb13IN6B;charset=UTF-8", $dbusername, $dbpassword);

$profile=$dbuser->prepare('SELECT * FROM User WHERE Name = :Name');
$profile->bindValue(':Name', $_POST['name']);
$profile->execute();
$row = $profile->fetch();
$password = $row['Password'];
echo $row['Password']. ' ' . $password . ' ' . $_POST['password'];
if($password === $_POST['password']){
	$_SESSION['User_ID'] = $row['ID'];
	$_SESSION['user'] = $row['Name'];
	$_SESSION['Acces_ID'] = $row['Acces_name_ID'];
	header( 'Location: profile.php?username=' . $_SESSION['user']);
} else {
	$_SESSION['Error'] = "Wrong password or user name";
	header( 'Location: login.php' ) ;
}
?>