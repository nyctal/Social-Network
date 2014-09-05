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

<div id="right_menu_content_down">
<body>
   
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
        
        
        if($hobby1 == NULL && $hobby2 == NULL && $hobby3 == NULL ){
            
            echo "<div class='empty_slot'>";
            printf("<p class='testo_semplice'>Non hai impostato nessun hobby nel tuo profilo, Modifica il tuo Profilo inserendo almeno un hobby per visualizzare i tuoi vicini</p>");
            echo "</div>";
            echo "<div class='empty_slot'>";
            echo "</div>";
            echo "<div class='empty_slot'>"; 
            echo "</div>";
        }
        
        else{
            
        
	$result = $db->Query($query);
	
        $num_res = $result->numRows();
        
               
        if (MDB2::isError($result)){ 

            echo "<div class='empty_slot'>";
            printf("<p class='testo_semplice'>Impossibile determinare i tuoi vicini</p>");
            echo "</div>";
            echo "<div class='empty_slot'>";
            echo "</div>";
            echo "<div class='empty_slot'>"; 
            echo "</div>";
             
        }
        else if($num_res==0){
            
            echo "<div class='empty_slot'>";
            printf("<p class='testo_semplice'>Non esistono persone nel sistema che condividono i tuoi hobby</p>");
            echo "</div>";
            echo "<div class='empty_slot'>";
            echo "</div>";
            echo "<div class='empty_slot'>"; 
            echo "</div>";
            
        }
        else {
            
                $num_res = $result->numRows();
            
            	if($num_res>3){
                    $choice1=rand(0,$num_res-1);

                do{ $choice2=rand(0,$num_res-1);
                }while($choice2==$choice1);

                do{ $choice3=rand(0,$num_res-1);
                }while($choice3==$choice2 || $choice3==$choice1);
              }   
            
            

            
            for($i=0; $i<$num_res; $i++){
                
                $row = $result->fetchRow();
                
                if($num_res>3){
                   if($i==$choice1 || $i==$choice2 || $i==$choice3)
                        print_suggested_friends_or_neighbours($row[0],$row[1],$row[2],$row[3]);
                   
                }
                else
                       print_suggested_friends_or_neighbours($row[0],$row[1],$row[2],$row[3]);

            }
            
            $db->disconnect();
            
            if($_SESSION['view']!='all_neighbor'){
            ?>
            <div class="mostra_tutti">
                <a href="index.php?view=all_neighbor" accesskey="9" onkeydown="linka(event,'all_neighbor')">
                    <img src="images/menu buttons/tabs/mostra_tutti.png" onmouseover="this.src='images/menu buttons/tabs/mostra_tutti_over.png'" onmouseout="this.src='images/menu buttons/tabs/mostra_tutti.png'" onfocusin="this.src='images/menu buttons/tabs/mostra_tutti_over.png'" onfocusout="this.src='images/menu buttons/tabs/mostra_tutti.png'" alt="Mostra Tutti" name="Mostra_Tutti2" width="200" height="28" border="0" id="Mostra_Tutti2" tabindex="250"/>
                </a>
            </div>
  
            
    <?php    }
    
        }
        
        
  }
        
  ?>
    
    
    
</div>
</body>
</html>