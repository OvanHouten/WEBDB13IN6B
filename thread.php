<?php 
require 'menu.php';
start();
include_once('db.php');

/*
 * Ophalen van gegevens van de Titelpost
 */
$thread_ID = intval($_REQUEST['thread_id']);

$thread=$db->prepare('SELECT * FROM Threads WHERE ID = :ID');
$thread->bindValue(':ID', $thread_ID);
$thread->execute();
$row = $thread->fetch();
$titel = $row['Title'];
$UserID = $row['User_ID'];
$since = $row['Time'];
$post = $row['Message'];
$category_id = $row['Categorie_ID'];
$threadID = $row['ID'];

/*
 * Ophalen van gegevens van Thread-poster
 */
$posterinfo = $db->prepare('SELECT * FROM User WHERE ID = :ID');
$posterinfo->bindValue(':ID', $UserID);
$posterinfo->execute();
$row = $posterinfo->fetch();
$username=$row['Name'];
$usersince=$row['Since'];

/*
 * Tellen van aantal posts van Thread-poster
 */
$replynmr = $db->prepare('SELECT COUNT(User_ID) FROM Replys WHERE
								User_ID=:ID');
$replynmr->bindValue(':ID', $UserID);
$replynmr->execute();
$row = $replynmr->fetch();
$posts = $row['COUNT(User_ID)'];

/*
 * Rank ophalen van de Thread-poster
 */
$ranks = $db->prepare('SELECT Name FROM Ranks WHERE ID = (SELECT MAX(ID) FROM Ranks WHERE number_of_posts < :posts)');
$ranks->bindValue(':posts', $posts);
$ranks->execute();
$row3 = $ranks->fetch();
$rank = $row3['Name'];

/*
 * ophalen van de categorie-naem waarin de thread zich bevindt
 */
$category_results = $db->prepare('SELECT Name FROM Categories WHERE
								ID =:ID');
$category_results->bindValue(':ID', $category_id);
$category_results->execute();
$row = $category_results->fetch();
$category_name = $row['Name'];
?>

<html>
<head>
	<title><?php echo $titel ?></title>
	<link rel="stylesheet" type="text/css" href="StandaardOpmaak.css" />

	<style type="text/css">
	.template{
		height:205px;
		margin-top:10px;
		box-shadow: 0px 5px 20px #888888;
	}
	.profilebar{
		background-color:#3F48CC;
		height:200px;
		width:20%;
		float:left;
		color:white;
		padding-top:5px;
		font-family:sans-serif;
		font-size:13pt;
	}
	.profilebar a:link {color:white;text-decoration: none;}     
	.profilebar a:visited {color:white;text-decoration: none;} 
	.profilebar a:hover {color:white;text-decoration: none;}  
	,profilebar a:active {color:white;text-decoration: none;}
	.upperbar{
		background-color:#3F48CC;
		padding-top:7px;
		padding-right:7px;
		margin-left:20%;
		height:23px;
		width:*%;
		color:white;
		font-size:12pt;
	}
	.upperbar a:link {color:white;text-decoration: none;}     
	.upperbar a:visited {color:white;text-decoration: none;} 
	.upperbar a:hover {color:white;text-decoration: none;}  
	.upperbar a:active {color:white;text-decoration: none;}

	.post{
		background-color:white;
		padding:5px;
		margin-left:20%;
		height:140px;
		width:*%;
		color:black;
		font-family:sans-serif;
		font-size:10pt;
	}
	.timeofpost{
		background-color:white;
		padding:5px;
		margin-left:20%;
		height:15px;
		width:*%;
		color:grey;
		font-family:sans-serif;
		font-size:8pt;
	}
	.path{
		font-size:10pt;
		margin-top:10px;
		font-family:sans-serif;
		color:black;
	}
	.path a:link {color:black;text-decoration: none;}     
	.path a:visited {color:black;text-decoration: none;} 
	.path a:hover {color:black;text-decoration: none;}  
	.path a:active {color:black;text-decoration: none;}
	
	.textarea {
		left:20%;
		width:100%;
		height:165px;
		font-family:sans-serif;
		font-size:10pt;
		resize:none;
	}
	</style>
</head>

<body>
	<!-- Banner en Menubalk -->
	<?php  
		banner("Forum - " . htmlentities($titel));
		menu();
	?>

	<!-- afgelopen path van the forumboom -->
	<div class="path">
		<a href="index.php">Forum</a> &gt;
        <a href="topics.php?category_id=<?php echo $category_id ?>"><?php echo htmlentities($category_name); ?></a> &gt;
        <?php echo htmlentities($titel); ?>
	</div>

	<!-- FIRST POST THREADSTARTER -->
	<div class="template">
		<div class="profilebar">
			<center><a href="profile.php?username=<?php echo $username ?>"><?php echo $username ?></a><br><br>
			<img src="steve.jpg" width="40px" height="40px"><br>
			<p style="font-size:10pt;">
				Rank: <?php echo $rank ?><br>
				Posts: <?php echo $posts ?> <br>
				Joined:<br>
				<?php echo (date("d M Y H:i", strtotime($usersince))); ?>
			</p></center>
		</div>

		<div class="upperbar">
			<?php echo $titel ?>
		</div>

		<div class="post">
			<?php echo $post ?>
		</div>

		<div class="timeofpost" align="right">
			<?php echo date("d M Y H:i", strtotime($since)); ?>
		</div>
	</div>

	<!-- PostLoading Algorithm -->
	<?php
	/*
	 *	Ophalen van alle gegevens van de reply's van een thread
	 */
	$thread=$db->prepare('SELECT * FROM Replys WHERE Thread_ID = :ID');
	$thread->bindValue(':ID', $thread_ID);
	$thread->execute();
	$arrayrows = $thread->fetchAll();

	/* 
	 * Door de array van rows heen loopen tot het eind
	 */
	foreach ($arrayrows as $row) {
		/*
		 * van elke row de gegevens ophalen
		 */
		$nmrpost = $row['Post_number'];
		$timepost = $row['Time'];
		$post = $row['Text'];
		$UserID = $row['User_ID'];
		
		/*
		 * ophalen van poster-gegevens van desbetreffende post
		 */
		$userinfo=$db->prepare('SELECT * FROM User WHERE ID = :ID');
		$userinfo->bindValue(':ID', $UserID);
		$userinfo->execute();
		$row = $userinfo->fetch();
		
		$userpost = $row['Name'];
		$timejoined = $row['Since'];
		
		/*
		 * Aantal posts van desbetreffende poster tellen
		 */
		$replynmr = $db->prepare('SELECT COUNT(User_ID) FROM Replys WHERE
								User_ID=:ID');
		$replynmr->bindValue(':ID', $UserID);
		$replynmr->execute();
		$row2 = $replynmr->fetch();
		$posts = $row2['COUNT(User_ID)'];
		
		/*
		 * Rank van desbetreffende poster ophalen
		 */
		$ranks = $db->prepare('SELECT Name FROM Ranks WHERE ID = (SELECT MAX(ID) FROM Ranks WHERE number_of_posts < :posts)');
		$ranks->bindValue(':posts', $posts);
		$ranks->execute();
		$row3 = $ranks->fetch();
		$rank = $row3['Name'];
	?>
	<!-- Alle php-variabelen op hun plek in de tamplate zetten -->
	<div class="template">
		<div class="profilebar">
			<center><a href="profile.php?username=<?php echo $userpost ?>"><?php echo $userpost ?></a><br><br>
			<img src="steve.jpg" width="40px" height="40px"><br>
			<p style="font-size:10pt;">
				Rank: <?php echo $rank ?><br>
				Posts: <?php echo $posts ?><br>
				Joined:<br>
				<?php echo date("d M Y H:i", strtotime($timejoined)) ?>
			</p></center>
		</div>

		<div class="upperbar" align="right">
		#<?php echo $nmrpost ?>
		</div>

		<div class="post">
			<?php echo $post ?>
		</div>

		<div class="timeofpost" align="right">
			<?php echo date("d M Y H:i", strtotime($timepost)) ?>
		</div>
	</div>
	<?php } ?>

	<!-- New post textarea -->
	<?php
	/*
	 * Gebeurd alleen als de gebruiker ingelogd is
	 */
	if(isset($_SESSION['User_ID'])) {
		/*
		 * Alles van de ingelogde gebruiker laden
		 */
		$userlogin = $db->prepare('SELECT * FROM User WHERE ID = :ID');
		$userlogin->bindValue(':ID', $_SESSION['User_ID']);
		$userlogin->execute();
		$row = $userlogin->fetch();
		$useruname = $row['Name'];
		$usersince = $row['Since'];
		
		/*
		 * Aantal posts van de ingelogde gebruiker wordt geteld
		 */
		$replynmr = $db->prepare('SELECT COUNT(User_ID) FROM Replys 
									WHERE User_ID=:ID');
		$replynmr->bindValue(':ID', $_SESSION['User_ID']);
		$replynmr->execute();
		$row2 = $replynmr->fetch();
		$posts = $row2['COUNT(User_ID)'];
		
		/*
		 * Rang van de ingelogde gebruiker wordt opgehaald
		 */
		$ranks = $db->prepare('SELECT Name FROM Ranks WHERE ID = (SELECT MAX(ID) FROM Ranks WHERE number_of_posts < :posts)');
		$ranks->bindValue(':posts', $posts);
		$ranks->execute();
		$row3 = $ranks->fetch();
		$rank = $row3['Name'];
	?>

    <div id="ajax-replies"></div>

	<!-- Reply-blok, kan alleen gezien worden door ingelogde gebruikers -->
	<div class="template">
		<div class="profilebar">
			<center><a href="profile.php?username=<?php echo $useruname ?>"><?php echo $useruname ?></a><br><br>
			<img src="steve.jpg" width="40px" height="40px"><br>
			<p style="font-size:10pt;">
				Rank: <?php echo $rank ?><br>
				Posts: <?php echo $posts?><br>
				Joined:<br>
				<?php echo (date("d M Y H:i", strtotime($usersince))); ?>
			</p></center>
        </div>

        <script>
        var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 
                      'Sep', 'Oct', 'Nov', 'Dec'];
        function createReply(msg) {
            if (document.querySelectorAll) {
                var post_elems = document.querySelectorAll('.template .post');
                var post_nr = post_elems.length - 1;
            } else {
                var post_nr = 1;
            }

            var today=new Date();
            var minutes = today.getMinutes();

            if (minutes < 10) {
                minutes = '0' + minutes;
            }

            var timepost = today.getUTCDate() + ' ' + months[today.getMonth()] + ' '
                + today.getFullYear() + ' ' + today.getHours() + ':' + minutes;


            // 'date("d M Y H:i", strtotime($

            var html = '<div class="template">'
                     + '<div class="profilebar">'
                     + '<center>' + username + '<br><br>'
                     + '<img src="steve.jpg" width="40px" height="40px"><br>'
                     + '<p style="font-size:10pt;">'
                     + 'Rank: ' + rank + '<br>'
                     + 'Posts: ' + posts + '<br>'
                     + 'Joined:<br>' + time_joined
                     + '</p></center>'
                     + '</div>'

                     + '<div class="upperbar" align="right">' + '#' + post_nr + '</div>'

                     + '<div class="post">' + msg + '</div>'

                     + '<div class="timeofpost" align="right">' + timepost + '</div>'
                     + '</div>';
            var elem = document.getElementById('ajax-replies');
            elem.innerHTML += html;
        }

        function submitReply(msg) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "reply.php?thread_id=" + thread_id, true);
            xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            xhr.send('message=' + msg);
        }

        function checkIfLeeg() {
            try {
            var msg = document.forms["newpost"]["message"].value.replace(/^\s+|\s+$/g,'');

            if (msg) {
                createReply(msg);
                submitReply(msg);

                document.forms["newpost"]["message"].value = '';
            }
            } catch(e) {
                if (console && console.log)
                    console.log(e);
            }

            return false;
        }
        </script>

        <form name="newpost" action="reply.php" method="post" onsubmit="return checkIfLeeg()">
			<div class="upperbar" align="right">
				<input name="thread_id" type="hidden" value="<?php echo $thread_ID;?>">
				<input type="submit" value="Reply">
			</div>

			<div class="post">
				<textarea name="message" class="textarea"></textarea>
			</div>
		</form>
	</div>
    <script>
    var time_joined = '<?php echo (date("d M Y H:i", strtotime($usersince))); ?>';
    var posts = <?php echo $posts?>;
<?php
$profile=$db->prepare('SELECT * FROM User WHERE ID = :ID');
$profile->bindValue(':ID', $_SESSION['User_ID']);
$profile->execute();
$row = $profile->fetch();
$username = $row['Name'];

/*
 * Tellen van aantal posts van ingelogde user
 */
$replynmr = $db->prepare('SELECT COUNT(User_ID) FROM Replys WHERE
								User_ID=:ID');
$replynmr->bindValue(':ID', $_SESSION['User_ID']);
$replynmr->execute();
$row = $replynmr->fetch();
$posts = $row['COUNT(User_ID)'];

/*
 * Rank ophalen van de ingelogde user
 */
$ranks = $db->prepare('SELECT Name FROM Ranks WHERE ID = (SELECT MAX(ID) FROM Ranks WHERE number_of_posts < :posts)');
$ranks->bindValue(':posts', $posts);
$ranks->execute();
$row3 = $ranks->fetch();
$rank = $row3['Name'];
?>
    var username = "<?php echo htmlentities($username)?>";
    var thread_id = <?php echo $thread_ID;?>;
    var rank = "<?php echo $rank; ?>";
    </script>
	<?php } else { ?>
    <p>Login as a user to post a reply</p>
	<?php } ?>
</body>
</html>
