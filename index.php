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
        <th width="50%"><?php echo $forum['Forum_name'] ?></th>
        <th width="30%">Last post</th>
        <th width="10%">Topics</th>
        <th width="10%">Reactions</th>
    </tr>
<?php
    $query = 'SELECT * FROM Catagories WHERE Forum_ID = '.$forum['ID']
           . ' ORDER BY Name';
    $category_results = mysql_query($query) or die(mysql_error());

    while ($category = mysql_fetch_array($category_results)) {
?>
    <tr>
        <td><a href="topics.php?forum_id=<?php echo $category['ID']; ?>"><?php echo $category['Name']; ?></a></td>
        <td></td>
        <td></td>
        <td></td>
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
