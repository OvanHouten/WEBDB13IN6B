<?php 
include_once('menu.php');
start();
include_once('db.php');

if(!isset($_SESSION['Acces_ID']) && $_SESSION['Acces_ID'] !== 1) {
	$_SESSION['Error'] = "This page is for admins only!";
}
?>

<HTML>
<HEAD>
	<TITLE>BugReports</TITLE>
	<link rel="stylesheet" type="text/css" href="StandaardOpmaak.css" />
	<link rel="stylesheet" type="text/css" href="index.css">
</HEAD>

<BODY>
	<?php 
		banner("Login");
		menu();
	?>
	<div style="box-shadow: 0px 5px 20px #888888;">
	<table class="topic-table">
	    <tr>
	        <th width="20%">Username</th>
    	    <th width="20%">Date</th>
			<th width="60%">Bug Report</th>
    	</tr>

		<?php
		$buglist = $db->prepare('SELECT * FROM Bugreport ORDER BY Bugreport.ID  DESC');
		$buglist->execute();
		$arraybuglist = $buglist->fetchAll();
		
		foreach ($arraybuglist as $row) {
			$date = $row['Time'];
			$bugreport = $row['Bugreport'];
			$User_ID = $row['User_ID'];
			
			$user=$db->prepare('SELECT Name FROM User WHERE ID = :ID');
			$user->bindValue(':ID', $User_ID);
			$user->execute();
			$row = $user->fetch();
			$username = $row['Name'];
		?>
		<tr>
	        <td><a href="profile.php?username=<?php echo $username ?>"><?php echo $username ?></a></td>
	        <td><?php echo (date("d M Y H:i", strtotime($date))) ?></td>
	        <td><?php echo $bugreport ?></td>
	    </tr>
		<?php } ?>
	</table>
	</div>
</BODY>