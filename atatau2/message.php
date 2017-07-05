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
	$message = $_POST["message"];  // Get the message

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
			$infmsg = "Messaggio pubblicato!";		
			break;
		case 1:
			$errormsg = "Devi scrivere qualcosa.";
			break;
		case 2:
			$errormsg = "Impossibile pubblicare il messaggio. Riprova più tardi.";
			break;
	}
}

?>
<html>
<head>
  <?php include('header.php'); ?>
</head>
	<body>
		<div id="welcome_container">
			<div id="welcome">
				<span id="welcome_message">È bello rivederti, <?php echo $_SESSION['fullname']  ; ?>!</span>
			</div>
		</div>  
		<br>
		<br>
<form action="message.php" method="POST">
		<fieldset>
			<textarea name="message" rows="4" cols="40" id="message_area" placeholder="Scrivi un messaggio..."></textarea>
			<input type="submit" name="create_post" value="Pubblica" id="message_submit" />
			<span style="color:red"><?php echo $errormsg;?></span>
			<span style="color:green"><?php echo $infmsg;?></span>
		</fieldset>
	</form>
		<br>
		<br>
		<table id="message_table">
	  <?php
		$posts = get_posts();
		
		foreach($posts as $p) {
			echo '<tr id="message_table_row">';
			echo '<td id="username">'. $p['author'] .'</td>';
			echo '<td>'. $p['content'] .'</td>';
			echo '<td>'. $p['created'] .'</td>';
					   echo '<td>' . '<a name="fb_share" type="button_count" href="http://www.facebook.com/sharer.php">
            Condividi</a>'     .'</td>'; // tasto condividi
			
			
			if ($p['author'] == ($_SESSION['username'])) {
				
			  echo '<td>' . '<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal" id="modifica_mex"> Modifica</button><br>'.'</td>';
				}
			
			echo '</tr>';
		}

	  ?>
	</table>
	<?php include('footer.php'); ?>
</body>
</html>