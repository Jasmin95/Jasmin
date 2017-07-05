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
   <!--<?php include('header.php'); ?>-->
   
   <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"  ></script>  
   <script type="text/javascript" src="https://netdna.bootstrapcdn.com/bootstrap/3.0.2/js/bootstrap.min.js" ></script>   
   <link rel="stylesheet" id="themeStyles" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/> 
   
   <link rel="stylesheet" type="text/css" href="/atatau/css/includes.css"> 
   
   <script type="text/javascript">
        var Messaggio = "";
        

        function saveTextBoxes() {
            Messaggio = $("#Messaggio").val();
           
        }
        function alertSavedValues() {
            alert("box 1: " + Messaggio)
        }
		</script>
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
		   echo '<td>' . '<a name="fb_share" type="button_count" href="http://www.facebook.com/sharer.php">
            Condividi su Facebook</a>'     .'</td>'; // tasto condividi
			
			
			if ($p['author'] == ($_SESSION['username'])) {
				
			  echo '<td>' . '<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal" id="modifica_mex"> Modifica</button><br>'.'</td>';
				}
			
			echo '</tr>';
		}

	  ?>
	  
	</table>
	
	<br>
	<form action="message.php" method="POST" >
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
  		<li><a href="register.php">Home</a></li>
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
	
	

    
	  <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    
                </div>
                <div class="modal-body">
                    Messaggio <input type="textbox" id="Messaggio"> </input><br>
                    
                </div>
                <div class="modal-footer">
                   <button type="button" class="btn btn-primary" onclick="saveTextBoxes()">Salva modifiche</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</body>
</html>
