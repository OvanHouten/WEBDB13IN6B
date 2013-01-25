<?php

session_start();
if($_POST['password'] != $_POST['verify_password']){
	$_SESSION['Error'] = "Passwords do not match";
	header( 'Location: register.php' );
	exit;
} //preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])?*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $_POST['email'])
if(!filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL )){
	$_SESSION['Error'] = "Invailid email";
	header( 'Location: register.php' );
	exit;
}
list($username,$domain)=split('@',$_POST['email']);
if(!checkdnsrr($domain)) {
	$_SESSION['Error'] = "Invailid email 2";
	header( 'Location: register.php');
	exit;
}

$dbusername='webdb13IN6B';
$dbpassword='stafrana';
$db = new PDO("mysql:host=localhost;dbname=webdb13IN6B;charset=UTF-8", $dbusername, $dbpassword);

$profile=$db->prepare('SELECT 1 FROM User WHERE Name = :Name');
$profile->bindValue(':Name',$_POST['name']);
$profile->execute();
$row = $profile->fetch();

if($row > 0){
	$_SESSION['Error'] = "Username already exists";
	header( 'Location: register.php' );
	exit;
}

$profile=$db->prepare('SELECT 1 FROM User WHERE Email = :Email');
$profile->bindValue(':Email',$_POST['email']);
$profile->execute();
$row = $profile->fetch();

if($row > 0){
	$_SESSION['Error'] = "Email already exists";
	header( 'Location: register.php' );
	exit;
}
	
$profile=$db->prepare('INSERT INTO User (Name, Password, Email)
    VALUES (?,?,?)');
$profile->bindValue(1, $_POST['name']);
$profile->bindValue(2, $_POST['password']);
$profile->bindValue(3, $_POST['email']);
$profile->execute();
header( 'Location: login.php' ) ;
?>