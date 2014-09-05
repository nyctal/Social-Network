<?php
session_start();


$res_ricevute=take_notifications_in($email); //memorizzo il risultato della query al database per le richieste di amicizia in entrata in attesa
$res_inviate=take_notifications_out($email); //memorizzo il risultato della query al database per le richieste di amicizia in uscita in attesa
$notifies=take_notifications_changes($email,$_SESSION['view'],$update); //memorizzo in notifiche le eventuali accettazioni per le mie richieste di amicizia inviate

if ( MDB2::isError($res_ricevute) || MDB2::isError($res_inviate) || MDB2::isError($notifies) ){  
     //printf("errore DB");
 }else{

    $num_ricevute=$res_ricevute->numRows(); //salvo numero delle richieste ricevute             
    $num_inviate=$res_inviate->numRows(); //salvo numero delle richieste inviate  
    $num_notifiche=$notifies->numRows(); //salvo numero delle notifiche   
}

    if(isset($_SESSION['logged']) && $_SESSION['logged']) //se sono loggato stampo il menu "loggato" altrimenti stampo il menu "login"
           print_logged_menu($num_ricevute,$num_inviate,$num_notifiche); //i parametri passati sono stati inizializzati su index
        
 else   print_login_menu($last_email,$last_password); //i parametri passati sono stati inizializzati su index
    
?>

<link href="css/master.css" rel="stylesheet" type="text/css">
<body>

<div id="alert_panel" onfocusout=close_pane('alert') class="notification_div"> <!-- apro il div principale per le notifiche -->
<div id="notification_main"  class="slide_down_main"> <!-- apro il div main per il contenuto per le notifiche -->
<?php    
    while( $notifiche=$notifies->fetchRow() ) //finche ci sono notifiche
            print_notification_alert_small($notifiche[0],$notifiche[1],$notifiche[2],$notifiche[3]); //chiama la funzione di stampa con nome, congome, mail, id
?>    
</div>
<?php if($num_notifiche>0){    ?>  <!-- se ci sono notifiche mostra il tasto tutte le notifiche -->
<div id="notification_footer" class="slide_down_footer">
    <a href="index.php?view=alert" accesskey="5" onMouseDown="(location.href='index.php?view=alert')">
     <img src="images/menu buttons/menu_bar/tue_notifiche.png" onmouseover="this.src='images/menu buttons/menu_bar/tue_notifiche_over.png'" onmouseout="this.src='images/menu buttons/menu_bar/tue_notifiche.png'" onfocusin="this.src='images/menu buttons/menu_bar/tue_notifiche_over.png'" onfocusout="this.src='images/menu buttons/menu_bar/tue_notifiche.png'" alt="Le tue notifiche" name="Tue_notifiche" width="200" height="15" border="0">
    </a>
</div>


<?php    } ?>
</div>
<div id="inbox_panel" class="received_fl_div"> <!-- apro il div principale per le richieste ricevute -->
<div id="received_main"  class="slide_down_main">  <!-- apro il div main per il contenuto per le richieste ricevute -->
<?php     
        while( $received=$res_ricevute->fetchRow() ) //finche ci sono richieste
            print_notification_in_small($received[0],$received[1],$received[2],$received[3]); //chiama la funzione di stampa con nome, congome, mail, id
     
?>
</div>
<?php if($num_ricevute>0){    ?> <!-- se ci sono richieste mostra il tasto tutte le richieste ricevute -->
<div id="received_footer" class="slide_down_footer"><a href="index.php?view=notifications_in" accesskey="6">
        <img src="images/menu buttons/menu_bar/richieste_ricevute.png" onmouseover="this.src='images/menu buttons/menu_bar/richieste_ricevute_over.png'" onmouseout="this.src='images/menu buttons/menu_bar/richieste_ricevute.png'" onfocusin="this.src='images/menu buttons/menu_bar/richieste_ricevute_over.png'" onfocusout="this.src='images/menu buttons/menu_bar/richieste_ricevute.png'" alt="Richieste ricevute" name="richieste_ricevute" width="200" height="15" border="0" id="richieste_ricevute" /></a>
</div>
<?php    } ?>    
</div>


<div id="outbox_panel"  class="sent_fl_div"> <!-- apro il div principale per le richieste inviate -->
<div id="sent_main" class="slide_down_main">  <!-- apro il div main per il contenuto per le richieste inviate -->
<?php     
    
    while($sent=$res_inviate->fetchRow())       //finche ci sono richieste
        print_notification_out_small($sent[0],$sent[1],$sent[2],$sent[3]); //chiama la funzione di stampa con nome, congome, mail, id
        
?>
</div>

    
    
<?php if($num_inviate>0){    ?> <!-- se ci sono richieste mostra il tasto tutte le richieste inviate -->
<div id="sent_footer" class="slide_down_footer">
    <a href="index.php?view=notifications_out" accesskey="7" onMouseDown="(location.href='index.php?view=notifications_out')">
        <img src="images/menu buttons/menu_bar/tue_richieste.png" onmouseover="this.src='images/menu buttons/menu_bar/tue_richieste_over.png'" onmouseout="this.src='images/menu buttons/menu_bar/tue_richieste.png'" onfocusin="this.src='images/menu buttons/menu_bar/tue_richieste_over.png'" onfocusout="this.src='images/menu buttons/menu_bar/tue_richieste.png'" alt="Tue richieste" name="tue_richieste" width="200" height="15" border="0"></a>
</div>
<?php    } ?> 
    
    
</div>

</body>
