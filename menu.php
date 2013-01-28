<?php

session_start();

if(!isset($_SESSION['User_ID'])){
	$user = 'Guest';
	$login = 'Log in';
} else {
	$login = 'Log out';
	$user = $_SESSION['User'];
}

$menu_html = '
    <div class="menu">
    <a href="index.php">Forum</a> |
    <a href="profile.php">Profile</a> |
    <a href="login.php">'.$login.'</a> |
    <a href="config_page.php">Admin Panel</a> |
    <a href="issues.php">Issues</a> |
    <a href="contact.php">Contact</a>
    </div>
';
