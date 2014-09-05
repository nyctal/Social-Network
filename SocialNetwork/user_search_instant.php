<?php
session_start();
include('common/utility.php');
include('common/connectdb.php');

$input=trim(strip_tags($_GET['q'])); //togliamo gli spazi ed i tag potenzialmente pericolosi 

$search_result=search_users($input);   //cerchiamo gli utenti possibili che rispettino il pattern     
       
        if($search_result!=NULL) 
            while($row=$search_result->fetchRow()) //finchè ci sono risultati li stampa con la funzione 
                print_user_search_small($row[0],$row[1],$row[2],$row[3]);
                
          
?>
