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
<div id="right_menu_content_up">

<?php 

        $db=myconnect();
	
        $queryAmico = "SELECT utenteA as mail FROM richiestaamicizia WHERE stato=\"accettata\" AND utenteB=\"$email\" UNION
                       SELECT utenteB as mail FROM richiestaamicizia WHERE stato=\"accettata\" AND utenteA=\"$email\"";
    
        
	$query = "SELECT name,surname,email,id FROM utenti WHERE birthplace=\"$birthplace\" AND email<>\"$email\" AND (email NOT IN ($queryAmico));";
	
	$result = $db->Query($query);
	
        $num = $result->numRows();
        
	if (MDB2::isError($result)){ 
            echo "<div class='empty_slot'>";
            printf("<p class='testo_semplice'>Impossibile trovare le persone che potresti conoscere</p>");
            echo "</div>";
             echo "<div class='empty_slot'>";
            echo "</div>";
            echo "<div class='empty_slot'>"; 
            echo "</div>";
        }
        else if($num==0){
            
            
        
            echo "<div class='empty_slot'>";
            printf("<p class='testo_semplice'>Non esistono potenziali tuoi amici nel sistema</p>");
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

                do{

                    $choice2=rand(0,$num_res-1);

                }while($choice2==$choice1);

                do{

                    $choice3=rand(0,$num_res-1);

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
            
            if($_SESSION['view']!='all_friends'){
            ?>
    
            <div class="mostra_tutti">
                <a href="index.php?view=all_friends" accesskey="8" onkeydown="linka(event,'all_friends')">
                    <img src="images/menu buttons/tabs/mostra_tutti.png" onmouseover="this.src='images/menu buttons/tabs/mostra_tutti_over.png'" onmouseout="this.src='images/menu buttons/tabs/mostra_tutti.png'" onfocusin="this.src='images/menu buttons/tabs/mostra_tutti_over.png'" onfocusout="this.src='images/menu buttons/tabs/mostra_tutti.png'" alt="Mostra Tutti" name="Mostra_Tutti2" width="200" height="28" border="0" id="Mostra_Tutti2" tabindex="230"/>
                </a>
            </div>
  
            
            
<?php      }
    }
    
?>

    


</div>
</body>
</html>