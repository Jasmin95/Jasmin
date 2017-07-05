<?php
error_reporting(E_ALL);
ini_set('display_errors','On');
session_start();
if(isset($_SESSION['username']))
{
	header('Location: index.php');
	exit();
}

$emptyuser = "";
$emptypass = "";
$infomsg = "";

if (isset($_POST["login"]))
{
	// This is to validate whether the Mandatory fields are filled are not
   if (empty($_POST["username"]) || empty($_POST["password"]))
   {
   if (empty($_POST["username"]))
      {
      	$emptyuser = "* Username is required"; // If username is not enter, throw error message
      }
      if (empty($_POST["password"]))
      {
        $emptypass = "* Password is required";   // If Password is not enter, throw error message
      }
   }
   else //blocco connessione database
   {
		// Retrieving the valid login credentials and stored in a variable
		$username = $_POST["username"];
		$password = md5($_POST["password"]);  // md5 methodology is used for password encryption

	  
		$dbpath = __DIR__ . '/mydb.sqlite';
		
        $dbh = new SQLite3($dbpath);
		
        // Validating the login credentials by sending a database query
        $stmt = $dbh->prepare("SELECT * FROM users WHERE username='". $username ."'");
        $execquery = $stmt->execute();

        if($execquery == false)
        {
            $_SESSION['info'] = "Unable to process the query, Please try again";
        }
        else
        {
			$acc = $execquery->fetchArray(SQLITE3_ASSOC);
			if ($acc)
			{
				if($acc['password'] == $password)
				{
					// Assign values to the session variables
					$_SESSION['username'] = $username;
					$_SESSION['fullname'] = $acc['fullname'];
					$_SESSION['status'] = "Active";
					session_write_close();
					// Call the next page that is Message Board page
					header("location: message.php");
					exit();
				}
				else {
					$_SESSION['info'] = "Account o password errati";
				}
			}
			else {  // Counter would remain 0 if it is invalid login
				$_SESSION['info'] = "Account o password errati";
			}
        }
    }
}

// Various informations are passed from different pages, all the messages are verified here and displayed according on the html tag
if(isset($_SESSION['info']))
{
  $infomsg = $_SESSION['info'];
  unset($_SESSION['info']);
}

?>

<!DOCTYPE html>
<html lang="IT">
<html>
	<head>
    	<!--<?php include('header.php'); ?>-->
		
		<title>Login</title>
	</head>
	<body >

		<h1><a href="index.php">Home</a></h1>
		
		<form action="board.php" method="POST">
			<table width="309" border="1" align="center">
		  		<tr>
					<td colspan="2"><b><span>Bacheca</span></b></td>
		  		</tr>
		  		<tr>
					<td width="116"><div align="right">Username</div></td>
					<td width="177"><input name="username" type="text" /></td>
					<td nowrap><span style="color:red"><?php echo $emptyuser;?></span></td>
		  		</tr>
		  		<tr>
					<td><div align="right">Password</div></td>
					<td><input name="password" type="password" /></td>
					<td nowrap><span style="color:red"><?php echo $emptypass;?></span></td>
		 		 </tr>
		 		 <tr>
					<td style="text-align:right"><a href="register.php">Registrati qui</a></td>
					<td align="center"><input name="login" type="submit" value="Login" /></td>
					<td nowrap><span style="color:red"><?php echo $infomsg;?></span></td>
		 		 </tr>
			</table>
		</form>
	</body>
</html>
