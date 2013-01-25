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

$dbpost = $db->prepare('INSERT INTO Replys (Text, User_ID, Thread_ID) 
VALUES (:message, :User_ID, :Thread_ID)');
$dbpost->bindValue(':message', $post);
$dbpost->bindValue(':User_ID', $_SESSION['User_ID']);
$dbpost->bindValue(':Thread_ID', $_SESSION['Thread_ID']);
$dbpost->execute();

header("Location: http://webdb.science.uva.nl/webdb13IN6B/thread.php");
?>