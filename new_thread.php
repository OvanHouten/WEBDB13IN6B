<?php
include_once('menu.php');
start();
include_once('db.php');

if (!isset($_SESSION['User_ID'])) {
    header('Location: login.php');
    die();
}

$category_id = intval($_REQUEST['category_id']);

$query = 'SELECT Name FROM Categories WHERE ID = ?';

$categories_results = $db->prepare($query);
$categories_results->bindValue(1, $category_id);
$categories_results->execute();

$tmp = $categories_results->fetch();
$category_title = $tmp['Name'];

$page_title = 'Create new topic in category "'. $category_title .'"';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $query = 'INSERT INTO Threads (Categorie_ID, Title, User_ID, Tag_id,'
        . ' Time, Message) VALUES (:category_id,:title,:user_id,:tag_id,'
        . ' NOW(),:message)';
    $threads_results = $db->prepare($query);
    $threads_results->execute(array(':category_id' => $category_id,
                                    ':title' => $_POST['title'],
                                    ':user_id' => $_SESSION['User_ID'],
                                    ':tag_id' => 0,
                                    ':message' => $_POST['post']));

    header('Location: thread.php?thread_id='.$db->lastInsertId());
    die();
}

?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title><?php echo $page_title ?></title>
    <link rel="stylesheet" type="text/css" href="./index_files/StandaardOpmaak.css">
</head>

<body>

<?php banner($page_title); ?>

<?php menu(); ?>

<form class="new-thread-form" action="new_thread.php?category_id=<?php echo $category_id; ?>" method="post">
    <div class="row">
        <label for="name">Thread title</label>
        <span class="fieldbox"><input type="text" name="title" id="title" value=""></span>
    </div>
    <div class="row">
        <label for="post">Post</label>
        <span class="postbox"><textarea class="area" id="post" name="post" rows="8" cols="30"></textarea></span>
    </div>

    <input type="submit" value="Create thread" name="create_thread_button">
</form>

</body>
</html>
