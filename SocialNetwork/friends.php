<?php
    session_start();
    $email=$_SESSION['email'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>

<body><img src="images/tabs/tuoi_amici_tab.png"  width="200" height="40" alt="I tuoi amici" />
 
<?php

        $db=myconnect();
	
	$query = "SELECT utenteA FROM richiestaamicizia WHERE stato=\"accettata\" AND utenteB=\"$email\" UNION
                  SELECT utenteB FROM richiestaamicizia WHERE stato=\"accettata\" AND utenteA=\"$email\""; 
	
        $queryNames="SELECT name,surname,email,id FROM utenti WHERE (email IN ($query))";
        
	$result = $db->Query($queryNames);
	
        $num_res = $result->numRows();
        
	if (MDB2::isError($result)){  //se c'è un errore non ti fa visualizzare gli amici
            
            echo "<div class='big_empty_slot'>";
            printf("<p class='testo_semplice'>Impossibile visualizzare i tuoi amici al momento</p>");
            echo "</div>";
            
        }
        else if($num_res==0){ //se non hai amici
            
            echo "<div class='big_empty_slot'>";
            printf("<p class='testo_semplice'>Non hai nessun amico al momento :(</p>");
            echo "</div>";
        }
        else{ //nel caso ci fosse qualche amico lo stampo
            
          
                
                while($row = $result->fetchRow())
                print_friends($row[0],$row[1],$row[2], $row[3]);	//stampo gli amici		
               
                        
                
            
            
            $db->disconnect();
            
        }





?>
    
</body>
</html>