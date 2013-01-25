<?php

session_start();
if($_POST['password'] != $_POST['verify_password']){
	$_SESSION['Error'] = "Passwords do not match";
	header( 'Location: register.php' );
	exit;
} //preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])?*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $_POST['email'])
if(!filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL )){
	$_SESSION['Error'] = "Invailid email _ 1";
	header( 'Location: register.php' );
	exit;
}
list($username,$domain)=split('@',$email);
if(!checkdnsrr($domain,'MX')) {
	$_SESSION['Error'] = "Invailid emaild _ 2";
	header( 'Location: register.php');
	exit;
}

$dbusername='webdb13IN6B';
$dbpassword='stafrana';
$db = new PDO("mysql:host=localhost;dbname=webdb13IN6B;charset=UTF-8", $dbusername, $dbpassword);

$profile=$db->prepare('INSERT INTO User (Name, Password, Email)
    VALUES (?,?,?)');
$profile->bindValue(1, $_POST['name']);
$profile->bindValue(2, $_POST['password']);
$profile->bindValue(3, $_POST['email']);
$profile->execute();
header( 'Location: login.php' ) ;
?>