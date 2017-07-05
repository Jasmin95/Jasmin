<?php
 include_once "./connessione.php";
 header('Content-Type : application/json');
 
 //Seleziono database sul quale lavorare
 $sql = "USE mydb";
 $esito = mysql_query($sql);
 if(! $esito) print("Impossibile selezionare DB: " . mysql_error() . "<br/>"); 
 
 //Creo la query
 $sql = "SELECT content  FROM posts WHERE SESSION[username] = posts.autore";//non va bene deve selezionare solo quella
 
 $esito = mysql_query($sql);
 if(!$esito) print("Impossibile eseguire la query: " . mysql_error() . "<br/>");
 
 //ARRAY DEI DATI ESTRATTI
 $dati = array();
 
 //ESEGUO LA QUERY
 while($row = mysql_fetch_array($esito))
 {
 //Array del sigolo dato
 $dato = array(
/* "nome" => $row['nome'],
 "cognome" => $row['cognome'],
 "eta" => $row['eta'],
 "indirizzo" => array (
 "via" => $row['via'],
 "civico" => $row['civico'],
 "citta" => $row['citta'],
 "cap" => $row['cap'],
 )
 );*/
 
 //Appendo l'array dei dati della singola ($dato) persona all'arrai dei dati contenete tutte le persone
 $dati[] = $dato;
 }
 
 // Invio al client i dati in frmato json
 print json_encode($dati);
?>