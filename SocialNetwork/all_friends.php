<?php
session_start();
$birthplace=$_SESSION['birthplace'];
$email=$_SESSION['email'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>

<body>
 <img src="images/tabs/amici_suggeriti_tab.png" width="200" height="40" alt="Amici Suggeriti" />  
<?php

    if(isset($_SESSION['logged']) && $_SESSION['logged'])
    {
    $db=myconnect();
	
    $queryAmico = "SELECT utenteA as mail FROM richiestaamicizia WHERE stato=\"accettata\" AND utenteB=\"$email\" UNION
                   SELECT utenteB as mail FROM richiestaamicizia WHERE stato=\"accettata\" AND utenteA=\"$email\"";
        
    
    $query = "SELECT name,surname,email,id FROM utenti WHERE birthplace=\"$birthplace\" AND email<>\"$email\" AND (email NOT IN ($queryAmico)) ;";
	//seleziono tutti i possibili amici che sono nella tua città ma non sono ancora tuoi amici
    $result = $db->Query($query);
	
    $num_res = $result->numRows();
    
  
    
    if (MDB2::isError($result)){ 
            echo "<div class='big_empty_slot'>";
            printf("<p class='testo_semplice'>Impossibile trovare le persone che potresti conoscere</p>");
            echo "</div>";
            
        }
    else{ //se ci sono risultati
          
        
        
        for($i=0; $i<$num_res; $i++){
                
                $row = $result->fetchRow();
                
                $name=$row[0]; //memorizzo i campi di ogni risultato
                $surname=$row[1];
                $email=$row[2];
                $plain_id=$row[3];
                                      
               print_friends($name,$surname,$email, $plain_id); //stampo il risultato
                        
                
            }
            
            $db->disconnect();
        
        
    }
}else redirect('access_denied.php'); //se non sono loggato

?>
    
    
    
    
</body>
</html>