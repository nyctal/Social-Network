<?php
session_start();

$res_inviate=take_notifications_out($email);
?>
<img src="images/tabs/richieste_out_tab.png" width="200" height="40" alt="Notifiche OUT" />
<?php
if (MDB2::isError($res_ricevute)){  
    echo "<div class='big_empty_slot'>";
    printf("<p class='testo_semplice'>Impossibile recuperare le tue richieste d'amicizie in uscita al momento</p>");
    echo "</div>";
 }else{
    
    while( $sent=$res_inviate->fetchRow() ) 
            print_notification_out_big($sent[0],$sent[1],$sent[2],$sent[3]); 
    
}

?>
