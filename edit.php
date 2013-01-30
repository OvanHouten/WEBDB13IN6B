<?php 
session_start();
if(!isset($_SESSION['User_ID'])){
	header("Location: login.php");
	$_SESSION['Error'] = "You need to log in to see this page";
	exit;
}

/* 
 * connectie met de sql database maken.
 */
$dbusername='webdb13IN6B';
$dbpassword='stafrana';
$db = new PDO("mysql:host=localhost;dbname=webdb13IN6B;charset=UTF-8", $dbusername, $dbpassword);

/*
 * Updaten van de User gegevens
 */
$dbedit = $db->prepare('UPDATE User SET FirstName= :fname, LastName= :lname, AboutMe= :aboutme WHERE ID = :ID');
$dbedit->bindValue(':ID', $_SESSION['User_ID']);
$dbedit->bindValue(':fname', $_REQUEST['fname']);
$dbedit->bindValue(':lname', $_REQUEST['lname']);
$dbedit->bindValue(':aboutme', $_REQUEST['aboutme']);
$dbedit->execute();

header("Location: profile.php");
?>