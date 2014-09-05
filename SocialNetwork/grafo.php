<?php
session_start();

function CreaGrafo($email)
  {
    
    $email_file=$_SESSION['email'];
    $persona_provvisoria=str_replace("@","_at_",$email); //sostituiamo con la stringa _at_ la @ che causa problemi sul comando
	$persona=str_replace(".","_",$persona_provvisoria); //sostituiamo con la stringa _ il . che causa problemi sul comando 
        
	$file=fopen("user/".$email_file."/graph.txt","w"); //apro il file in scrittura 
	fwrite($file,"Graph ".$persona.
        "{ \n 
	 { \n 
         node[width =.2,height=.1, shape=ellipse,style=filled,color=Skyblue];\n"); //inserisco il nodo utente con colore blue
	fclose($file); //chiudo il file
	pulisci($email); //setto tutti i miei amici come non visitati
	auxGrafoNode($email); //aggiunge i nodi degli amici con relativa mail e colore grigio
	
	$file=fopen("user/".$email_file."/graph.txt","a"); //apro il file in append
	fwrite($file,"}\n{ \n edge[len=.3]; \n"); //aggiungo l'edge lenght
	fclose($file); //chiudo il file
	Pulisci($email); //risetto di nuovo tutti gli amici a non visitati per produrre gli edge
	auxGrafoEdge($email); //aggiungo gli edge degli amici
        $file=fopen("user/".$email_file."/graph.txt","a"); //apro il file in append
	fwrite($file,"} overlap=false;};"); //non sovrappongo i nodi
        fclose($file); //chiudo il file
        
      return;
  }

function auxGrafoNode($email)
{
     
     $email_file=$_SESSION['email'];
     $persona_provvisoria=str_replace("@","_at_",$email); //sostituiamo con la stringa _at_ la @ che causa problemi sul comando
     $persona=str_replace(".","_",$persona_provvisoria);  //sostituiamo con la stringa _ il . che causa problemi sul comando 
     
     $db=myconnect(); //mi connetto al database
	
	$query = "SELECT utenteA FROM richiestaamicizia WHERE stato=\"accettata\" AND utenteB=\"$email\" UNION
                  SELECT utenteB FROM richiestaamicizia WHERE stato=\"accettata\" AND utenteA=\"$email\"";
	
        $queryNames="SELECT email,visited FROM utenti WHERE (email IN ($query))"; //query per selezionare gli amici
        
	$amicizie = $db->Query($queryNames);
	
        if (MDB2::isError($amicizie)) { //in caso di errore redirect a pagina di errore
            redirect('error.php');
            
        }
        
        else $amici = $amicizie->fetchAll(); //nel caso ci siano risultati li salvo tutti nella variabile amici
	   
              
            
	$file=fopen("user/".$email_file."/graph.txt","a"); //apriamo il file in append
	fwrite($file,$persona."[label=\"".$persona."\"] \n"); //scriviamo l'etichetta che verrà poi visualizzata nel nodo
        
	
        fwrite($file,"node[width =.3,height=.4, shape=ellipse,style=filled,color=Gray];\n"); //scriviamo le carattereistiche del nodo
       
        
	fclose($file); //chiudiamo il file
	
        for($i=0;$i<sizeof($amici);$i++) //per ogni amico
          {
          if($amici[$i][1]==0) //se non è visitato
                {
                $friendmail=$amici[$i][0];
                $queryUpdate="UPDATE utenti SET visited='1' WHERE email=\"$friendmail\"  ";
                $up=$db->Query($queryUpdate); //lo setto a visitato

                $db->disconnect();   //mi disconnetto dal database 
                auxGrafoNode($amici[$i][0]); //richiamo ricorsivamente la funzione di crezione dei nodi
                }

          } 
     

$db->disconnect();

return;
}

function auxGrafoEdge($email)
{
    $email_file=$_SESSION['email'];
    $persona_provvisoria=str_replace("@","_at_",$email); //sostituiamo con la stringa _at_ la @ che causa problemi sul comando
    $persona=str_replace(".","_",$persona_provvisoria); //sostituiamo con la stringa _ il . che causa problemi sul comando 
    
    $db=myconnect();
	
	$query = "SELECT utenteA FROM richiestaamicizia WHERE stato=\"accettata\" AND utenteB=\"$email\" UNION
                  SELECT utenteB FROM richiestaamicizia WHERE stato=\"accettata\" AND utenteA=\"$email\"";
	
        $queryNames="SELECT email,visited FROM utenti WHERE (email IN ($query))"; //query per selezionare gli amici
        
	$amicizie = $db->Query($queryNames);
	
        if (MDB2::isError($amicizie)) 
               die($result->getMessage . ', ' . $amicizie->getDebugInfo());
        
        else $amici = $amicizie->fetchAll();
        
        $queryUpdate1="UPDATE utenti SET visited='1' WHERE email=\"$email\"  ";
        $up=$db->Query($queryUpdate1);
        
        if (MDB2::isError($up)) 
            die($up->getMessage . ', ' . $up->getDebugInfo());
        
    for($i=0;$i<sizeof($amici);$i++) //per ogni amico
      {
	  if($amici[$i][1]==0) //se non è visitato
	{
		
	$amico_provvisorio=str_replace("@","_at_",$amici[$i][0]); //sostituiamo con la stringa _at_ la @ che causa problemi sul comando
	$amico=str_replace(".","_",$amico_provvisorio); //sostituiamo con la stringa _ il . che causa problemi sul comando 	
	$file=fopen("user/".$email_file."/graph.txt","a"); //apro il file in append
	
	fwrite($file,"\"".$persona."\"--\"".$amico."\"; \n"); //inserisco l'edge
	fclose($file); //chiudo il file
	       
        $friend=$amici[$i][0]; //salvo la mail dell'amico corrente
	       
        $queryUpdate2="UPDATE utenti SET visited='1' WHERE email=\"$friend\" "; //setto visitato l'amico corrente
        $up2=$db->Query($queryUpdate2);
        
	if (MDB2::isError($up2)) 
             die($result->getMessage . ', ' . $up2->getDebugInfo()); 
		
	auxGrafoEdge($amici[$i][0]); //creo gli edge per gli amici dell'amico corrente
	}
      }
$db->disconnect();


return;
}

function Pulisci($email) //risetto a non visitato tutti gli amici 
{
        $db=myconnect();
	
	$query = "SELECT utenteA FROM richiestaamicizia WHERE stato=\"accettata\" AND utenteB=\"$email\" UNION
                  SELECT utenteB FROM richiestaamicizia WHERE stato=\"accettata\" AND utenteA=\"$email\"";
	
        $queryNames="SELECT email,visited FROM utenti WHERE (email IN ($query))"; 
        
	$amicizie = $db->Query($queryNames);
	
        
        if (MDB2::isError($amicizie)) 
               die($result->getMessage . ', ' . $amicizie->getDebugInfo());
        
        else $amici = $amicizie->fetchAll();
        
      for($i=0;$i<sizeof($amici);$i++)
      {
        if($amici[$i][1]==1)
	{
	$friend=$amici[$i][0];
	$queryUpdate="UPDATE utenti SET visited=0 WHERE email=\"$friend\" ";
        $up=$db->Query($queryUpdate);
        
	$db->disconnect();
        
	Pulisci($friend); //pulisco gli amici dell'amico
	}
      }  


$db->disconnect();
return;
}
 

?> 
