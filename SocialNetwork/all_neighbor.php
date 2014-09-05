<?php
session_start();
$email=$_SESSION['email'];
$hobby1=$_SESSION['hobby1'];
$hobby2=$_SESSION['hobby2'];
$hobby3=$_SESSION['hobby3'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>

<body>
<img src="images/tabs/vicini_suggeriti_tab.png" width="200" height="40" alt="Vicini Suggeriti" />

 <?php 

        $db=myconnect();
	
        $queryAmico = "SELECT utenteA as mail FROM richiestaamicizia WHERE stato=\"accettata\" AND utenteB=\"$email\" UNION
                       SELECT utenteB as mail FROM richiestaamicizia WHERE stato=\"accettata\" AND utenteA=\"$email\"";
        
        // subquery (non funzionanate standalone, amncano le parentesi per ogni SELECT tra gli UNION) che crea la lista di hobby dell'utente
        $queryHobby="SELECT hobby1 FROM utenti WHERE email=\"$email\" UNION DISTINCT SELECT hobby2 FROM utenti WHERE email=\"$email\" UNION DISTINCT SELECT hobby3 FROM utenti WHERE email=\"$email\"";

        // query funzionante standalone che restituisce la lista degli hobby dell'utente loggato
        $hobbies="(SELECT hobby1 FROM utenti WHERE email=\"$email\") UNION DISTINCT (SELECT hobby2 FROM utenti WHERE email=\"$email\") UNION DISTINCT (SELECT hobby3 FROM utenti WHERE email=\"$email\")";

        // query che tira fuori gli utente che hanno almeno un hobby in comune con l'utente loggato
        $query="SELECT name,surname,email,id FROM utenti WHERE (hobby1 IN ($queryHobby) OR hobby2 IN ($queryHobby) OR hobby3 IN ($queryHobby)) AND  email<>\"$email\" AND (email NOT IN ($queryAmico)) ;";
        
        
        $result = $db->Query($query);
	
        $num_res = $result->numRows();
        
               
        if (MDB2::isError($result)){ 

            echo "<div class='big_empty_slot'>";
            printf("<p class='testo_semplice'>Impossibile determinare i tuoi vicini</p>");
            echo "</div>";
            
        }
        else{
            $num_res = $result->numRows();
            
            for($i=0; $i<$num_res; $i++){
                
                $row = $result->fetchRow();
                
                $name=$row[0];
                $surname=$row[1];
                $email=$row[2];
                $plain_id=$row[3];
                
              
                print_neighbours($name,$surname,$email, $plain_id);
                

            }
            
            $db->disconnect();
            
            
            
        }
        
?>

    </body>
</html>
    