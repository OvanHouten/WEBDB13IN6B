<?php 

	require('menu.php');
	start();
	if(!isset($_SESSION['User_ID'])){
		$_SESSION['Error'] = 'You need to log in to see this page';
		header( 'Location: login.php' );
		exit;
	} else if($_SESSION['Acces_ID'] != 1){
		header('HTTP/1.0 404 Not Found');
		echo "<h1>404 Not Found</h1>";
		echo "The page that you have requested could not be found.";
		exit;
	}
	$dbusername='webdb13IN6B';
	$dbpassword='stafrana';
	$db = new PDO("mysql:host=localhost;dbname=webdb13IN6B;charset=UTF-8", $dbusername, $dbpassword);

?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
	<link rel="stylesheet" type="text/css" href="StandaardOpmaak.css" />
	<link rel="stylesheet" type="text/css" href="index.css" />
	<style>
		#line {
			bottom: 10%;
			height: 2px;
			background-color: #3F48CC;
		}
		.settingbox{
			float: rigth;
			margin-top: 25px;
			padding: 7px;
		}
		.submenu{
			margin-top: 25px;
			padding: 7px;
			width: 20%;
			float: left;
			text-align: left;
			background-color:#3F48CC;
			color:white;
			font-weight:bold;
			box-shadow: 0px 5px 20px #888888;
		}
		.submenu a:link {color:white;text-decoration: none;}     
		.submenu a:visited {color:white;text-decoration: none;} 
		.submenu a:hover {color:white;text-decoration: none;}  
		.submenu a:active {color:white;text-decoration: none;}
		
		.options{
			height: auto;
			width: 70%;
			border-style: solid;
			border-color:#3F48CC;
			float: right;
			margin-top: 25px;
			padding: 7px;
			overflow: visible;
		}
		
		.tables{
			background-color:#3F48CC;
			color:white;
			font-weight:bold;
		}
		.tables a:link {color:white;text-decoration: none;}     
		.tables a:visited {color:white;text-decoration: none;} 
		.tables a:hover {color:white;text-decoration: none;}  
		.tables a:active {color:white;text-decoration: none;}
	</style>
</head>
<body>
	<?php
		banner("Admin panel");
		menu();
	?>
<div>
	<div class="submenu">
		<h3>Submenu</h3><br>
		<a href="config_page.php?submenu=Accounts">Accounts</a><br>
		<a href="config_page.php?submenu=Ranks">Ranks</a><br>
		<a href="config_page.php?submenu=Forums">Forums</a><br>
	</div>
	<div class='options'>
		<?php
			if(isset($_GET['submenu'])){
				} if($_GET['submenu'] === 'Accounts'){
					
					if(empty($_GET['page']) || $_GET['page'] < 0){
						$page = 0;
						$page2 = 6;
					} else {
						$page = $_GET['page'];
						$page2 = $page + 5;
				}
					$sql = 'SELECT * FROM User ORDER BY User.ID ASC LIMIT %d,%d';
					$sql = sprintf($sql, $page, $page2);
					$profile=$db->prepare($sql);
					$profile->execute();
					$users = $profile->fetchAll();
					$profile=$db->prepare('SELECT * FROM Access_Name');
					$profile->execute();
					$ranks = $profile->fetchAll();
					?>
					<div class='banner'>
						Accounts
					</div>
					<table border = '1'>
						<tr>
							<th>User Name</th>
							<th>Acces</th>
						</tr>
						<?php
							foreach($users as $user){
						?>
						<tr>
							<form methode="post" action="edit_user.php">
								<td>
									<input type="field" name="name" value=<?php echo $user['Name'];?>>
								</td>
								<td>
									<select name="acces_id" >
										<?php foreach($ranks as $rank) {?>
											<option value=<?php echo $rank['ID'];
													 if( $ranks[$user['Acces_name_ID']-1]['Name'] == $rank['Name']){
														echo ' selected';
													}?>><?php echo $rank['Name'];?></option>
										<?php } ?>
									</select><br>
								</td>
								<td>
									<input type='hidden' value=<?php echo $user['ID'];?> name='id'>
									<button type='submit'>Change</button>
								</td>
								</form>
								
								<form methode='post' action='remove_user.php'>
								<td>
									<input type='hidden' value=<?php echo $user['ID'];?> name='id'>
									<button type='submit'>Remove</button>
								</td>
							</form>
						</tr>
						<?php } ?>
					</table>
					<?php $next = $page + 6; $pre = $page - 6; ?>
					<div class= "submenu" Style="float:left">
						<a href=<?php echo "config_page.php?submenu=Accounts&page=".$pre ; ?>>Previous</a>
					</div>
					<div class= "submenu" Style="float:right"> 
						<a href=<?php echo "config_page.php?submenu=Accounts&page=".$next; ?> >Next</a>
					</div>
					<?php 
				} else if($_GET['submenu'] === 'Ranks'){
				
					$profile=$db->prepare('SELECT * FROM Ranks');
					$profile->execute();
					$ranks = $profile->fetchAll();
					?>
					<div class='banner'>
						Ranks
					</div>
					<?php
						if(isset($_SESSION['Error'])) {
							echo $_SESSION['Error'];
							unset($_SESSION['Error']);
						}
					?><br>
					Here you can add and remove ranks.<br>
					The ranks are based on the amount of posts a User has made<br>
					<table border="1">
						<tr>
							<th>Rank name</th>
							<th>Amount of Posts</th>
						</tr>
						<?php foreach($ranks as $rank){?>
						<tr>
							<td><?php echo $rank['Name'];?></td>
							<td><?php echo $rank['Number_of_posts'];?></td>
							<td>
								<form method="post" action="remove_rank.php">
									<input type="hidden" name='id' value=<?php echo $rank['ID']; ?>>
									<button type="submit"> Remove </button>
								</form>
							</td>
						</tr>
						<?php } ?>
						<tr>
							<form method="post" action="add_rank.php">
								<td> <input type="field" name="name" value="New Rank"></td>
								<td> <input type="number" name="number_of_posts" value="Amount"></td>
								<td> <button type="submit"> Add </button>
							</form>
						</tr>
					</table>
				<?php
				} else if($_GET['submenu'] === 'Forums'){
					
					
					
					$profile=$db->prepare('SELECT * FROM Access_Name');
					$profile->execute();
					$AccessNames = $profile->fetchAll();
					
					$profile=$db->prepare('SELECT * FROM Forums');
					$profile->execute();
					$forums= $profile->fetchAll();
					
					$profile=$db->prepare('SELECT * FROM Categories');
					$profile->execute();
					$catagories= $profile->fetchAll();
					
					if(isset($_SESSION['Error'])) {
						echo $_SESSION['Error'];
						unset($_SESSION['Error']);
					}
					
					foreach($forums as $forum){
					
					if($forum['Hidden'] == 1){
						continue;
					}?>
					<div class='banner'>
						Forums
					</div>
					<table border="1">
					
						<tr><form method='post' action='edit_forum.php'>
							<th Style='width:150px';><?php echo $forum['Forum_name']; ?></th>
							<th><select name="forum_acces">
							<?php foreach($AccessNames as $rank) {?>
							<option value=<?php echo $rank['ID'];
													 if( $AccessNames[$forum['Permission_level']-1]['Name'] == $rank['Name']){
														echo ' selected';
													}?>><?php echo $rank['Name'];?></option>
							<?php } ?>
						</select></th>
							<th>
								<input type='hidden' name='forum_id' value=<?php echo $forum['ID']; ?>>
								<button type='submit'>modify</botton></form>
							</th>
							<th>
								<form method='post' action='remove_forum.php'>
								<input type='hidden' name='forum_id' value= <?php echo $forum['ID'];?> >
								<button type='submit'>remove</button></form>
							</th>
								
						</tr>
						
						
						
						<?php foreach($catagories as $catagorie){ 
							if($catagorie['Hidden'] == 1){ continue;}
							if($catagorie['Forum_ID'] == $forum['ID']) {?>
						<tr>
							<td> <?php echo $catagorie['Name']; ?></td>
							<form method='post' action='edit_catagory.php'>
							<td>
								<select name="catagory_acces">
								<?php foreach($AccessNames as $rank) {?>
								<option value=<?php echo $rank['ID'];
													 if( $AccessNames[$catagorie['Permission_Level']-1]['Name'] == $rank['Name']){
														echo ' selected';
													}?>><?php echo $rank['Name'];?></option>
								<?php } ?>
								</select>
							</td>
							<td>
								<input type='hidden' name='catagory_id' value=<?php echo $catagorie['ID'];?>>
								<button type='submit'>modify</botton>
								</form>
							</td>
							<td>
								<form method='post' action='remove_catagory.php'>
								<input type='hidden' name='catagory_id' value=<?php echo $catagorie['ID'];?>>
								<button>remove</button>
								</td>
						<tr>
						<?php } } ?>
						<tr>
							<form method='post' action='addcatagory.php'>
								<td>
									<input name='name' value='New catagory'>
								</td>
								<td><select name="acces">
							<?php foreach($AccessNames as $rank) {?>
							<option value=<?php echo $rank['ID'];?>><?php echo $rank['Name'];?></option>
							<?php } ?>
						</select></td>
								<td>
									<input type='hidden' name='forum_id' value=<?php echo $forum['ID']; ?>> 
									<button type='Submit'> add</button>
								</td>
							</form>
						</tr>
					</table>
					<?php } ?>
					
					<br>
					<br>
					
					Here you can create new forums or catagories for the forums.<br>
					By default there will not be any catagories.<br><br>
					<form method ="post" action="addforum.php">
						<label for="name">Forum Name:</label><br>
						<input name="name" /><br><br>
						Permissions:<br><br>
						Select a Permission Rank for every of the following attributes:<br> 
						Can see:<br>
						
						<button type="submit"> Submit </button>
					</form>
					<?php
			} else {
				header('Location: config_page.php?submenu=Accounts');
				exit;
			}
			?>
	</div>
	<br>
	<br>
</div>


</body>
</html>
