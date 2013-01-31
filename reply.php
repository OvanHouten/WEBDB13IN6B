<?php
include_once('menu.php');
start();

if(!isset($_SESSION['User_ID'])){
	header("Location: login.php");
}

/* 
 * connectie met de sql database maken.
 */
$dbusername='webdb13IN6B';
$dbpassword='stafrana';
$db = new PDO("mysql:host=localhost;dbname=webdb13IN6B;charset=UTF-8", $dbusername, $dbpassword);

/*
 * Nieuwe post nummer bepalen
 */
$post = $_REQUEST['message'];

$dbpostnmr = $db->prepare('SELECT MAX(Post_number) AS lastPost FROM Replys WHERE Thread_ID = :ID');
$dbpostnmr->bindValue(':ID', $_REQUEST['Thread_ID']);
$dbpostnmr->execute();
$row = $dbpostnmr->fetch();
$postnumber = $row['lastPost'];
++$postnumber;

/*
 * Invoegen van een nieuwe post
 */
$dbpost = $db->prepare('INSERT INTO Replys (Text, User_ID, Thread_ID, 
Post_number) VALUES (:message, :User_ID, :Thread_ID, :Post_number)');
$dbpost->bindValue(':message', $post);
$dbpost->bindValue(':User_ID', $_SESSION['User_ID']);
$dbpost->bindValue(':Thread_ID', $_REQUEST['Thread_ID']);
$dbpost->bindValue(':Post_number', $postnumber);
$dbpost->execute();

/*
 * Text-veld mag niet leeg zijn
 */

if(empty($_SERVER['HTTP_X_REQUESTED_WITH']) 
        && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    header("Location: thread.php?thread_id=" . $_REQUEST['Thread_ID']);
}

header("Location: thread.php?thread_id=" . $_REQUEST['Thread_ID']);
?>