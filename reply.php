<?php
include_once('menu.php');
start();
include('db.php');

if(!isset($_SESSION['User_ID'])){
	header("Location: login.php");
}

/*
 * Nieuwe post nummer bepalen
 */
$post = $_REQUEST['message'];
$thread_id = intval($_REQUEST['thread_id']);

$query = 'SELECT MAX(Post_number) FROM Replys WHERE Thread_ID = :Thread_ID';
$db_post_nr = $db->prepare($query);
$db_post_nr->bindValue(':Thread_ID', $thread_id);
$db_post_nr->execute();
$tmp = $db_post_nr->fetch();
$post_nr = $tmp[0] ? $tmp[0] + 1 : 1;

/*
 * Invoegen van een nieuwe post
 */
$query = 'INSERT INTO Replys (Text, User_ID, Thread_ID, 
Post_number) VALUES (:message, :User_ID, :Thread_ID, :Post_NR)';

$dbpost = $db->prepare($query);
$dbpost->bindValue(':message', $post);
$dbpost->bindValue(':User_ID', $_SESSION['User_ID']);
$dbpost->bindValue(':Thread_ID', $thread_id);
$dbpost->bindValue(':Post_NR', $post_nr);
$dbpost->execute();

/*
 * Als het geen AJAX request is, dan wordt er doorverwezen naar de thread pagina
 */
if(empty($_SERVER['HTTP_X_REQUESTED_WITH']) 
        || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
    header("Location: thread.php?thread_id=" . $thread_id);
}
?>
