<?php
session_start();
$email=$_SESSION['email'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script type="text/javascript"> //script per mouseover
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
</head>


<body onload="MM_preloadImages('images/menu buttons/tabs/richiedi_amicizia_over.png')">
<img src="images/tabs/profilo_tab.png" width="200" height="40" alt="Profilo" />
<div class="showP">
    <?php
    
                $cypher_id=$_SESSION['view']; //salvo l'id cifrato
			
                $id=decrypt_id($cypher_id); //lo decripto
        
                $db=myconnect(); //mi connetto al database
        
                $query = 
                "SELECT name,surname,birthplace,email,titolo_studio,hobby1,hobby2,hobby3,visibility,banned
                FROM utenti
                WHERE id=\"$id\";";
                
                $result = $db->Query($query); //mi salvo tutte le informazioni a partire dall'id decifrato
                
                if (MDB2::isError($result)){  
                    
                    include('profile_not_found.php'); //se ci sono errori faccio un redirect su una pagina di errore
                }
                else if( $result->numRows()==0 ){ //idem se non ci sono risultati
                    
                    include('profile_not_found.php');
                    
                }
                else{
                    $row = $result->fetchRow(); //nel caso in cui ci siano risultati setto delle variabili con i campi che mi servono
                    
                    $name=$row[0];
                    $surname=$row[1];
                    $birthplace=$row[2];
                    $emailFriend=$row[3];
                    $titolo_studio=$row[4];
                    $hobby1=$row[5];
                    $hobby2=$row[6];
                    $hobby3=$row[7];
                    $visibility=$row[8];
                    $banned=$row[9];
                
            $queryAmico = "SELECT utenteA as mail FROM richiestaamicizia WHERE stato=\"accettata\" AND utenteB=\"$email\" UNION
                           SELECT utenteB as mail FROM richiestaamicizia WHERE stato=\"accettata\" AND utenteA=\"$email\""; //elenco dei delle mai dei miei amici
            
            $queryAttesaA = "SELECT utenteA as mail FROM richiestaamicizia WHERE stato=\"in attesa\" AND utenteB=\"$email\""; 
            $queryAttesaB = "SELECT utenteB as mail FROM richiestaamicizia WHERE stato=\"in attesa\" AND utenteA=\"$email\"";
            
            $queryAttesa =  $queryAttesaA. " UNION " . $queryAttesaB;  //elenco delle mail degli utenti con cui ho amicizia in attesa
            
            $queryAmicizia="SELECT mail FROM ($queryAmico) as Amicizia WHERE mail=\"$emailFriend\"  "; //seleziono la mail del profilo che voglio visualizzare tra i miei amici
            
            $queryAttese="SELECT mail FROM ($queryAttesa) as Richieste WHERE mail=\"$emailFriend\"  "; //seleziono la mail del profilo che voglio visualizzare tra le mie amicizie in attesa

            $queryRichieste="SELECT mail FROM ($queryAttesaA) as AmicizieRichieste WHERE mail=\"$emailFriend\"  ";
            
            $res_amico = $db->Query($queryAmicizia);
            
            $res_attese = $db->Query($queryAttese);
            
            $res_richieste= $db->Query($queryRichieste);
            
            $amico = $res_amico->numRows(); //numero di amici
            $num_attese = $res_attese->numRows(); //numero di amicizie in attesa
            $num_richieste=$res_richieste->numRows(); //numero di amicizie richieste         
    
    ?>
    
    
    


<?php

echo <<<PROFILE
<p><img src="user/$emailFriend/avatar.jpg" alt="Mini Avatar" name="mini_avatar" width="100" height="100" id="mini_avatar" /></p>
<p id="name_and_surname">$name $surname</p>
PROFILE;


    
    if( $visibility=='pubblico' || ( $visibility=='solo amici' && $amico==1  ) ){ //se il profilo è pubbico o so per amici ed io sono amico
        
        echo "<br><br><br><br><b class='info'>Indirizzo email: </b><b class='testo_semplice3'>$emailFriend</b><br><br>";
        echo "<b class='info'>Luogo di nascita:</b> <b class='testo_semplice3'>$birthplace</b><br><br>";

        if($hobby1!="")echo "<b class='info'>Hobby :</b><b class='testo_semplice3'>$hobby1";
        if($hobby2!="")echo ", $hobby2";
        if($hobby3!="")echo ", $hobby3";
        echo "</b><br><br>";

        if($titolo_studio!="")echo "<b class='info'>Titolo di studio : </b><b class='testo_semplice3'>$titolo_studio</b><br><br><br><br>";

        
        
        
    }
    else echo "<br><br><br><br><br>";
           
            if (MDB2::isError($res_amico)){ 

                printf("errore DB");
                die($res_amico->getMessage . ', ' . $res_amico->getDebugInfo());        
            }
            else {
                
                if($num_attese==0 && $amico==0) //se non ci sono amicizie in attesa e non sono amico mostro il form di richiesta amicizia
		{

?>
      
   
<?php echo "<form action='ask_friendship.php?view=$cypher_id' method='post' name='ask_friend'>"; ?> 
   <center><input name="add_friend" type="submit" value="Aggiungi agli amici" class="button_generic"/></center>
<?php echo "<input name='asked' type='hidden' value = '$emailFriend' />"; ?>
</form>


<?php
         
                }     
                else if($num_richieste==1){ //se è in richiesta allora posso accettare o rifiutare

?>  

<span class="accept_refuse_button"><form action="accept_friend.php" method="post" name="accetta_amico">
<?php echo "<input name='friend_mail' type='hidden' value=$emailFriend />";?>
    <input name="status" type="hidden" value="yes" />
    <center><input name="Accetta" type="submit" value="Accetta" class="button_generic"/></center>
    </form></span>

<span class="accept_refuse_button"><form action="accept_friend.php" method="post" name="rifiuta_amico">
<?php echo "<input name='friend_mail' type='hidden' value=$emailFriend />";?>
    <input name="status" type="hidden" value="no" />
    <input name="Rifiuta" type="submit" value="Rifiuta" class= "button_generic"/>
    </form></span>

<?php                    
                    
                   
                }
                else if($num_attese==1){ //se l'amicizia è ancora in attesa di conferma
                    
                    printf("<p class='friendship_info'>Richiesta d'amicizia in attesa</p>");
                    
                }
                
                else printf("<p class='friendship_info'>Sei amico di $name $surname</p>"); //se sei già amico
                
                
           }
           
           if($banned) //se l'utente è bannato
                echo "<br><br><center><b class='banned'> BANNED UNTIL ".$banned." </b></center>";
            
 }
?>
</div>
</body>
</html>

