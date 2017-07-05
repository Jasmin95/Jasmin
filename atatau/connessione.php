<?php
 // Connection's Parameters
 //$db_host="indirizzo_host";
 //$db_name="nome_database";
 //$username="username";
 //$password="password";
 
 
        $username = $_POST["username"];
		$password = md5($_POST["password"]); 
        $dbpath = __DIR__ . '/mydb.sqlite';
	    $dbh = new SQLite3($dbpath);
 
 // Connection
 $link = mysql_connect($db_host,$username,$password);
 if (!$link)
 {
 die('Could not connect: ' . mysql_error());
 }
 else {
 //echo "Db connesso correttamente <br/>";
 mysql_select_db($db_name);
 }
?>