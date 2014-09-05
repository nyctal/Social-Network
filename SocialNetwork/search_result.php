<?php
session_start();
?>
<img src="images/tabs/risultati_ricerca_tab.png" width="200" height="40" alt="Risultati Ricerca" />

<?php


$input=trim(strip_tags($_GET['q'])); //togliamo gli spazi ed i tag potenzialmente pericolosi 

$search_result=search_users($input);        //cerchiamo gli utenti possibili che rispettino il pattern     
       
        if($search_result!=NULL)
            while($row=$search_result->fetchRow())  //finchè ci sono risultati li stampa con la funzione 
                print_user_search_big($row[0],$row[1],$row[2],$row[3]);
                
?>
