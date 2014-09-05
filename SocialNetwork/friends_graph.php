 <?php 
 session_start();
 
 $email=$_SESSION['email'];
 
 
 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script language="JavaScript">	
	function openwindow()
	{
            width='width='+(screen.width-200);              // setto al dimensione della finestra
            height='height='+(screen.height-200);           // un po più piccola di quella dello schermo
            topx='top='+70;                                 // e la centro, impostamdo la scrollabrs solo se servr (auto)
            left='left='+100;                               // i parametri creati li passo alla funzione window. open, col file da visulaizzare ed i ltitolo della finestra
            params=width+','+height+','+topx+','+left+',scrollbars=auto';
            
           
	window.open('view_graph.php', 'Your Friends Graph', params); //apro una nuova finestra sul click 
	}
	</script>
</head>

<body>
    <img src="images/tabs/grafo_amici_tab.png" width="200" height="40" alt="Grafo Amici" />
 <?php 
   
 
   creaGrafo($email); //creo il grafo passanto l'email
   
   
   $input="user/".$email."/graph.txt"; //utile in preparazione del comando
   $output="user/".$email."/graph.svg"; //utile in preparazione del comando
   
   $command="neato -Tsvg -Nstyle=filled -Nlabel= -Nshape=circle -o ". $output ." ". $input; //comando di creazione del grafo
   
   system($command,$retval); //esecuzione del comando
   
  
  
   
   echo "<img width=400  src=$output onclick='javascript:openwindow()' class='clickkable_image'</img>";
 
   
 ?>   
    
    
  
</body>
</html>