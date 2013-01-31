<?php
include_once('menu.php');
start();
include_once('db.php');

$page_title = "Forum index";
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" type="text/css" href="StandaardOpmaak.css">
    <link rel="stylesheet" type="text/css" href="index.css">
</head>

<body>

<?php banner($page_title); ?>

<?php menu(); ?>

<?php

// TODO: ORDER BY 'rank' instead of Forum_Name
$forums_result = $db->prepare('SELECT ID, Forum_Name FROM Forums ORDER BY  Forums.Order ASC');
$forums_result->execute();

while ($forum = $forums_result->fetch()) {
    $forum_id = $forum['ID'];
?>
<table class="subject-table">
<tbody>
    <tr>
        <th width="30%"><?php echo $forum['Forum_Name'] ?></th>
        <th width="50%">Last post</th>
        <th width="10%">Topics</th>
        <th width="10%">Reactions</th>
    </tr>
<?php
    $query = 'SELECT C.ID, C.Name,'
           . '  (SELECT COUNT(_T.ID) FROM Threads as _T WHERE _T.Categorie_ID = C.ID) as Topics,'
           . '  COUNT(R.ID) as Replies'
           . ' FROM Categories as C'
           . ' LEFT JOIN Threads as T ON T.Categorie_ID = C.ID'
           . ' LEFT JOIN Replys as R ON R.Thread_ID = T.ID'
           . ' WHERE C.Forum_ID = ?'
           . ' GROUP BY C.ID'
           . ' ORDER BY C.Name';
    $categories_result = $db->prepare($query);
    $categories_result->bindValue(1, $forum_id);
    $categories_result->execute();
    $catergory_count = 0;

    while ($category = $categories_result->fetch()) {
        $catergory_count++;

        $query = 'SELECT T.ID, T.Title FROM Threads as T'
            . ' WHERE T.Categorie_ID = ?'
            . ' ORDER BY T.ID DESC LIMIT 1';

        $threads_result = $db->prepare($query);
        $threads_result->bindValue(1, $category['ID']);
        $threads_result->execute();
        $last_post = $threads_result->fetch();
?>
    <tr>
        <td><a href="topics.php?category_id=<?php echo $category['ID']; ?>"><?php echo $category['Name']; ?></a></td>
        <td>
<?php if ($last_post) { ?>
            <a href="thread.php?thread_id=<?php echo $last_post['ID']; ?>"><?php echo $last_post['Title']; ?></a></td>
<?php } else { ?>
            <em>There are no topics in this category yet.</em>
<?php } ?>
        <td><?php echo $category['Topics']; ?></td>
        <td><?php echo $category['Replies']; ?></td>
    </tr>
<?php
    }

    if (!$catergory_count) {
?>
    <tr>
        <td colspan="4"><em>There are no categories in this forum yet.</em></td>
    </tr>

<?php
    }
?>
</tbody>
</table>
<?php
}
?>

</body>
</html>
