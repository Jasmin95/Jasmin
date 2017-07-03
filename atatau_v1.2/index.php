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
		<?php include('header.php'); ?>
		<title>Atatau</title>
	</head>
	<body>
		<h1><a href="index.php">Home</a></h1>

		<?php if(isset($_SESSION['username'])) { ?>	
	
		<form method="POST" action="index.php">
			<input type="submit" name="logout" value="Logout">
		</form>
		
		<?php } else { ?>		
			<a href="register.php">Registrati</a>
			<br>
			<a href="board.php">Login</a>
		<?php } ?>
	</body>
</html>
