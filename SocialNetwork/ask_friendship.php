<?php
session_start();
require_once("common/connectdb.php");
require_once("common/utility.php");

$email=$_SESSION['email'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>

<body>


<?php
    if(isset($_POST['asked'])){
        
        $id=$_GET['view']; //setto l'id cifrato passato in get da show_profile
        $email2=$_POST['asked'];//setto l'email di chi riceverà la richiesta passata in post dal form
        $db=myconnect();
	
	$query="INSERT INTO richiestaamicizia VALUES (\"$email\",\"$email2\",\"in attesa\");";
        
	$result = $db->Query($query); //aggiorno il database mettendo la richiesta in attesa
	

	if (MDB2::isError($result)){  //se c'è un errore nel database informo
        
            echo "<div class='big_empty_slot'>";
            printf("<p class='testo_semplice'>Impossibile effettuare la richiesta d'amicizia ora</p>");
            echo "</div>";
        
        }
        else redirect("index.php?view=$id"); //altrimenti faccio un redirect su index sul profilo di chi ha ricevuto la richiesta
        
        
        }
?>
    
    
    
</body>
</html>
