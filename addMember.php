<?php
$con = mysql_connect("localhost","webdb13IN6B","stafrana");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
mysql_select_db( "webdb13IN6B", $con);

echo $_POST["name"], $_POST["password"],$_POST["email"], 2;

$sql="INSERT INTO Users (UserName, Password, Email)
VALUES
('$_POST[name]','$_POST[password]','$_POST[email]')";

mysql_query($sql);

mysql_close($con);

?>