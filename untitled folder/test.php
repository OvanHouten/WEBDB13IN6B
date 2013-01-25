<?php
$con = mysql_connect("localhost","webdb13IN6B","stafrana");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
mysql_select_db( "webdb13IN6B", $con);

$result = mysql_query("SELECT * FROM Users");

while($row = mysql_fetch_array($result))
  {
  echo $row['UserName'] . " " . $row['Email'];
  echo "<br />";
  }

mysql_close($con);
?>