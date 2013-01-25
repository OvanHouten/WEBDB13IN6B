<?php
session_start();
$db = new PDO("mysql:host=localhost;dbname=webdb13IN6B;charset=UTF-8", webdb13IN6B , stafrana);

if (!$db){
	die('Could not connect: ' . mysql_error());
}

$to = "olaf.ajax@hotmail.com";
$email = $_REQUEST['email'];
$name = $_REQUEST['name'];
$subject = "Bugreport";
$text = $_REQUEST['Bugreport'];
$Bugreport = "From: " . $name . "\nEmail: " . $email . "\n\n" . $text;

$send_mail = mail($to, $subject, $Bugreport);

$dbbug = $db->prepare('INSERT INTO Bugreport (Bugreport, User_ID) 
VALUES (:Bugreport, :User_ID)');
$dbbug->bindValue(':Bugreport', $Bugreport);
$dbbug->bindValue(':User_ID', $_SESSION['User_ID']);

$dbbug->execute();

if($send_mail) {
	echo "Thank You, your bug report has been sent";
	header("Location: http://webdb.science.uva.nl/webdb13IN6B/profile.php");
}
else {
	echo "ERROR Something went wrong!";
}
?>