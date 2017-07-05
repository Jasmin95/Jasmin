<?php
session_start();

function logout() {
	session_unset();
	session_destroy();
}

if(isset($_POST['logout'])) {
	logout();
}

?>

<!DOCTYPE html>
<html lang="IT">
<html>
	<head>
		<!--<?php include('header.php'); ?>-->
		
		<title>Atatau</title>
		
		
	</head>
	<body>
		

		<?php if(isset($_SESSION['username'])) { ?>	
        <br>
		<br>
		<br>
	    <br>
		<h1><text x=”50″ y=”80″><p align="center">A presto!</p></text></h1>
	
		<!--<form method="POST" action="index.php">-->
		<form method="POST" action="register.php">
		<div align="center">
        <h1 ><button input type="submit"  name ="logout" value="Logout">Logout</button></h1></div>
	    
			
		</form>
		</br>
		</br>
		</br>
		</br>
		<?php } else { ?>	
            
			<a href="register.php">Registrati</a> <!-- mettili al centro-->
			<br>
			<a href="board.php">Login</a>
		<?php } ?>
	</body>
</html>
