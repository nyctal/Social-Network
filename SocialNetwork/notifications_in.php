<?php
session_start();
$email=$_SESSION['email'];

$res_ricevute=$notifies=take_notifications_in($email,$id); //estraiamo le richieste di amicizia in entrata
?>

<img src="images/tabs/richieste_in_tab.png" width="200" height="40" alt="Notifiche IN" />
<?php

if (MDB2::isError($res_ricevute)){  
    echo "<div class='big_empty_slot'>";
    printf("<p class='testo_semplice'>Impossibile recuperare le tue richieste d'amicizie in entrata al momento</p>");
    echo "</div>";
 }else{ //se ci sono risultati
    
    while( $received=$res_ricevute->fetchRow() ) 
            print_notification_in_big($received[0],$received[1],$received[2],$received[3]); 
    
}

?>