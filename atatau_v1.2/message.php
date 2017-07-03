<?php

error_reporting(E_ALL);
ini_set('display_errors','On');

session_start();

if(!isset($_SESSION['username']))
{
 header("Location: board.php");
 exit();
}


function get_posts() {
	$dbpath = __DIR__ . '/mydb.sqlite';
	$dbh = new SQLite3($dbpath);
      
    // Select query to retrieve the list of messages
    $stmt = $dbh->prepare('SELECT * from posts ORDER BY created DESC');
    $result = $stmt->execute();
	
	if($result == false) {
		return [];
	}

    // Listing the messages into a table based on the Result Set
    $posts = [];
	while ($post = $result->fetchArray(SQLITE3_ASSOC)) {
		$posts[] = $post;
    }
	
	return $posts;
}


function create_post() 
{
	if (empty($_POST["message"]))
	{
		return 1;
	}
		
	$postedby = $_SESSION['username'];  // Get the username as the Post By user
	$message = $_POST["message"];  //F Get the message

	// Connect with the database
	$dbpath = __DIR__ . "/mydb.sqlite";
	$dbh = new SQLite3($dbpath);
	$stmt = $dbh->prepare("INSERT into posts(content, created, author) values('" . $message . "', datetime() ,'" . $postedby . "')");
	$result = $stmt->execute();
	if($result == false) {
		return 2;
	}
	
	return 0;
}


$errormsg = "";
$infmsg = "";

if (isset($_POST["create_post"])) {
	$error = create_post();
	
	switch($error) {
		case 0:
			$infmsg = "Messaggio pubblicato";		
			break;
		case 1:
			$errormsg = "Hai dimenticato di scrivere qualcosa";
			break;
		case 2:
			$errormsg = "Oh no, al momento non è possibile pubblicare il messaggio.";
			break;
	}
}

?>

<!DOCTYPE html>
<html lang="IT">
<html>
<head>
   <?php include('header.php'); ?>
</head>
<body>
<!-- <span class="welcome">È bello rivederti, <?php echo $_SESSION['fullname'] ; ?></span> -->
		<table class="message_table">
		<!--<thead>
	 			 <tr>
					<th>Autore</th>
					<th>Testo</th>
					<th>Postato il</th>
	  			</tr>
	  	</thead>-->
	  <?php
		$posts = get_posts();
		
		foreach($posts as $p) {
			echo '<tr>';
			echo '<td>'. $p['author'] .'</td>';
			echo '<td>'. $p['content'] .'</td>';
			echo '<td>'. $p['created'] .'</td>';
			echo '</tr>';
		}

	  ?>
	</table>
	<br>
	<form action="message.php" method="POST">
		<fieldset class="pubblica_messaggio">
			<textarea name="message" id="message" placeholder="Scrivi un messaggio..."></textarea>
			<br>
			<input type="submit" name="create_post" id="create_post" value="Pubblica"/>
			<br>
			<span style="color:red"><?php echo $errormsg;?></span>
			<br>
			<span style="color:green"><?php echo $infmsg;?></span>
		</fieldset>
	</form>
	
	<div id="nav-cont">
	 <div id="navigation_verticale">
	 <ul>
  		<li><a href="index.php">Home</a></li>
  		<li><a href="index.php">Logout</a></li>
 		<li><a href="index.php">FAQ</a></li>
  		<li><a href="index.php">Contatti</a></li>
  		<li><a href=""></a></li>
  		<li><a href=""></a></li>
  		<li><a href=""></a></li>
  		<li><a href=""></a></li>
  		<li><a href=""></a></li>
  		<li><a href=""></a></li>
  		<li><a href=""></a></li>
  		<li><a href=""></a></li>
  		<li><a href=""></a></li>
  		<li><a href=""></a></li>
  		<li><a href=""></a></li>
  		<li><a href=""></a></li>
  		<li><a href=""></a></li>
  		<li><a href=""></a></li>
  		<li><a href=""></a></li>
  		<li><a href=""></a></li>
  		<li><a href=""></a></li>
  		<li><a href=""></a></li>
  		<li><a href=""></a></li>
  		<li><a href=""></a></li>
  		<li><a href=""></a></li>
  		<li><a href=""></a></li>
  		<li><a href=""></a></li>
  		<li><a href=""></a></li>
  		<li><a href=""></a></li>
  		<li><a href=""></a></li>
  		<li><a href=""></a></li>
  		<li><a href=""></a></li>
  		<li><a href=""></a></li>
  		<li><a href=""></a></li>
  		<li><a href=""></a></li>
  		<li><a href=""></a></li>
  		<li><a href=""></a></li>
  		<li><a href=""></a></li>
  		<li><a href=""></a></li>
  		<li><a href=""></a></li>
  		<li><a href=""></a></li>
  		<li><a href=""></a></li>
  		<li><a href=""></a></li>
  		<li><a href=""></a></li>
  		<li><a href=""></a></li>
	</ul> 
	</div>
	</div>

	<!--<form method="POST" action="index.php">
		<input type="submit" name="logout" value="Logout">
	</form> -->
</body>
</html>
