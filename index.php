<?php
include_once('db.php');

$forum_results = mysql_query('SELECT * FROM Forums') or die(mysql_error());

$page_title = "Forum index";
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title><?php echo $page_title; ?></title>
	<link rel="stylesheet" type="text/css" href="./index_files/StandaardOpmaak.css">
</head>

<body>

<h1 class="banner"><?php echo $page_title; ?></h1>

<div class="menu">
	<a href = "index.html"> Forum </a> |
	<a href = "profile.html"> Profile </a> |
	<a href = "login.html"> Login </a> | 
	<a href = "config page.html"> Admin Panel </a> |
	<a href = "bugreport.html"> Issues </a> |
	<a href = "contact.html"> Contact </a>
</div>

<?php
while ($forum = mysql_fetch_array($forum_results)) {
?>
<table class="subject-table">
<tbody>
    <tr>
        <th width="30%"><?php echo $forum['Forum_name'] ?></th>
        <th width="50%">Last post</th>
        <th width="10%">Topics</th>
        <th width="10%">Reactions</th>
    </tr>
<?php
    $query = 'SELECT C.ID as CID, C.Name as CName,'
           . ' COUNT(T.ID) as Topics, COUNT(R.ID) as Replies'
           . ' FROM Catagories as C'
           . ' LEFT JOIN Threads as T ON T.Catagorie_ID = C.ID'
           . ' LEFT JOIN Replys as R ON R.Thread_ID = T.ID'
           . ' WHERE C.Forum_ID = '.$forum['ID']
           . ' GROUP BY C.ID'
           . ' ORDER BY C.Name';

    $category_results = mysql_query($query) or die(mysql_error());

    while ($category = mysql_fetch_array($category_results)) {
        $query = 'SELECT T.ID, T.Title FROM Threads as T'
               . ' WHERE T.Catagorie_ID = '.$category['CID']
               . ' ORDER BY T.ID DESC LIMIT 1';

        $last_post_result = mysql_query($query) or die(mysql_error());
        $last_post = mysql_fetch_array($last_post_result);
?>
    <tr>
        <td><a href="topics.php?category_id=<?php echo $category['CID']; ?>"><?php echo $category['CName']; ?></a></td>
        <td>
<?php if ($last_post) { ?>
            <a href="thread.php?thread_id=<?php echo $last_post['ID']; ?>"><?php echo $last_post['Title']; ?></a></td>
<?php } else { ?>
            <em>No threads in this category.</em>
<?php } ?>
        <td><?php echo $category['Topics']; ?></td>
        <td><?php echo $category['Replies']; ?></td>
    </tr>
<?php
    }
?>
</tbody>
</table>
<?php
}
?>

<!--
<table class="subject-table">
<tbody>
    <tr>
        <th width="50%">Subjects</th>
        <th width="30%">Last post</th>
        <th width="10%">Topics</th>
        <th width="10%">Reactions</th>
    </tr>
    <tr>
        <td><a href="topics.html">Subject 1</a></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td><a href="topics.html">Subject 2</a></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td><a href="topics.html">Subject 3</a></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td><a href="topics.html">Subject 4</a></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
</tbody>
</table>
-->

</body>
</html>
