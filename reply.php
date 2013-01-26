<?php
session_start();
if(!isset($_SESSION['User_ID'])){
	header("Location: http://webdb.science.uva.nl/webdb13IN6B/login.php");
}

$_SESSION['Thread_ID'] = 1;

$dbusername='webdb13IN6B';
$dbpassword='stafrana';
$db = new PDO("mysql:host=localhost;dbname=webdb13IN6B;charset=UTF-8", $dbusername, $dbpassword);

$post = $_REQUEST['message'];

//postnumber fixxen!
$dbpostnmr = $db->prepare('SELECT MAX(Post_number) AS lastPost FROM Replys WHERE Thread_ID = :ID');
$dbpostnmr->bindValue(':ID', $_SESSION['Thread_ID']);
$dbpostnmr->execute();
$row = $dbpostnmr->fetch();
$postnumber = $row['lastPost'];
++$postnumber;

$dbpost = $db->prepare('INSERT INTO Replys (Text, User_ID, Thread_ID, 
Post_number) VALUES (:message, :User_ID, :Thread_ID, :Post_number)');
$dbpost->bindValue(':message', $post);
$dbpost->bindValue(':User_ID', $_SESSION['User_ID']);
$dbpost->bindValue(':Thread_ID', $_SESSION['Thread_ID']);
$dbpost->bindValue(':Post_number', $postnumber);
$dbpost->execute();

header("Location: http://webdb.science.uva.nl/webdb13IN6B/thread.php");
?>