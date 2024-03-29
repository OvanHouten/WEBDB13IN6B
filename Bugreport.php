<?php
include_once('menu.php');
start();

if(!isset($_SESSION['User_ID'])){
	header("Location: login.php");
	$_SESSION['Error'] = "You need to log in to see this page";
	exit;
}

/*
 connectie met de database maken
 */
session_start();
$db = new PDO("mysql:host=localhost;dbname=webdb13IN6B;charset=UTF-8", webdb13IN6B , stafrana);

if (!$db){
	die('Could not connect: ' . mysql_error());
}

$posterinfo = $db->prepare('SELECT * FROM User WHERE ID = :ID');
$posterinfo->bindValue(':ID', $_SESSION['User_ID']);
$posterinfo->execute();
$row = $posterinfo->fetch();
$name = $row['Name'];
$email = $row['Email'];

/*
 * invullen van de php-variabelen voor het verzenden van een mail
 */
$to = "olaf.ajax@hotmail.com";
//$email = $_REQUEST['email'];
//$name = $_REQUEST['name'];
$subject = "Bugreport";
$text = $_REQUEST['Bugreport'];
$Bugreport = "From: " . $name . "\nEmail: " . $email . "\n\n" . $text;

$send_mail = mail($to, $subject, $Bugreport);

/*
 * Bugreport inde database zetten
 */
$dbbug = $db->prepare('INSERT INTO Bugreport (Bugreport, User_ID) 
VALUES (:Bugreport, :User_ID)');
$dbbug->bindValue(':Bugreport', $Bugreport);
$dbbug->bindValue(':User_ID', $_SESSION['User_ID']);

$dbbug->execute();

if($send_mail) {
	echo "Thank You, your bug report has been sent";
	header("Location: index.php");
}
else {
	echo "ERROR Something went wrong!";
}
?>