$(document).ready(function(e) {
 $("#modifica_mex").click(function() {
 
 $.ajax({
 //URL a cui viene mandata la richiesta
 url : "./php/message.php",
 //Tipo doi richiesta (GET o POST)
 type : "POST",
 //Imposta il tipo di risposta da ricevere dal server
 dataType : "json",
 //Sa la chiamata è asincrona (true) oppure sincrona (false) e quindi blocca tutti gli altri codici
 async : false,
 //Imposta una funzione se la richiesta ha successo
 success : function(data) {riceviDati(data)},
 //Funzione che si esegue inc aso di errore
 error: function(){alert("Errore nell'estrazione dei dati");}
});
});
});
