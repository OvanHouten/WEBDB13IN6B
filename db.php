<?php

$dbhost = 'localhost';
$dbuser = 'webdb13IN6B';
$dbpass = 'stafrana';
$dbname = 'webdb13IN6B';

$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die('MySQL connection'
    + ' error:' + mysql_error());

mysql_select_db($dbname);

?>
