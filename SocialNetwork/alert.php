<?php
session_start();

$confirm=take_notifications_changes($email);
?>
<img src="images/tabs/notifiche_tab.png" width="200" height="40" alt="Notifiche " />
<?php
if (MDB2::isError($res_ricevute)){  
     echo "<div class='big_empty_slot'>";
    printf("<p class='testo_semplice'>Impossibile recuperare le notifiche al momento</p>");
    echo "</div>";
 }else{
    
    while( $alert=$confirm->fetchRow() ) 
            print_notification_alert_big($alert[0],$alert[1],$alert[2],$alert[3]); 
    
}

?>
