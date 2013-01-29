<?php
include_once('menu.php');
start();
include_once('db.php');

$category_id = intval($_REQUEST['category_id']);

$query = 'SELECT Name FROM Categories WHERE ID = ?';

$categories_results = $db->prepare($query);
$categories_results->bindValue(1, $category_id);
$categories_results->execute();

$tmp = $categories_results->fetch();
$category_title = $tmp['Name'];

$page_title = 'Topics of category "'. $category_title .'"';

?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title><?php echo $page_title ?></title>
    <link rel="stylesheet" type="text/css" href="StandaardOpmaak.css">
    <link rel="stylesheet" type="text/css" href="index.css">
</head>

<body>

<?php banner($page_title); ?>

<?php menu(); ?>

<table class="topic-table">
<tbody>
    <tr>
        <th width="50%">Topic name</th>
        <th width="20%">Author</th>
        <th width="30%">Last posted</th>
    </tr>
<?php
    $query = 'SELECT T.ID, T.Title, U.Name, MAX(R.Time) as last_posted'
           . ' FROM Threads as T'
           . ' LEFT JOIN User as U ON U.ID = T.User_ID'
           . ' LEFT JOIN Replys as R ON R.Thread_ID = T.ID'
           . ' WHERE T.Categorie_ID = ?'
           . ' GROUP BY T.ID'
           . ' ORDER BY T.ID, T.Title';

    $threads_results = $db->prepare($query);
    $threads_results->bindValue(1, $category_id);
    $threads_results->execute();

    $thread_count = 0;

    while ($thread = $threads_results->fetch()) {
        $thread_count++;
?>
    <tr>
        <td><a href="thread.php?thread_id=<?php echo $thread['ID'] ?>"><?php echo $thread['Title'] ?></a></td>
        <td><?php echo $thread['Name'] ?></td>
<?php
    if ($thread['last_posted']) {
?>
        <td><?php echo $thread['last_posted'] ?></td>
<?php
    } else {
?>
        <td><em>No replies</em></td>
<?php
    }
?>
    </tr>
<?php
    }

    if (!$thread_count) {
?>
    <tr>
        <td colspan=3><em>There are no topics created in this category yet.</em></td>
    </tr>
<?php
    }
?>
</tbody>
</table>

<div class="new-thread-bar">
    <a href="new_thread.php?category_id=<?php echo $category_id; ?>">New thread</a>
</div>

</body>
</html>
