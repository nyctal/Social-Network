<?php
session_start();
require_once("common/connectdb.php");
require_once("common/utility.php");

$email=$_SESSION['email'];

$friendMail=$_POST['friend_mail']; //salvo la mail dell'amico proveniente in post
$stato=$_POST['status']; //salvo lo stato proveniente in post 

$db=myconnect();

//aggiorno il database con con la risposta

if($stato=='yes'){
    $amicizia="UPDATE richiestaamicizia SET stato='accettata' WHERE utenteA=\"$friendMail\" AND utenteB=\"$email\"  ";
    }
else if($stato=='no'){
    $amicizia="UPDATE richiestaamicizia SET stato='rifiutata' WHERE utenteA=\"$friendMail\" AND utenteB=\"$email\"  ";
 }
 
 $res_amicizia = $db->Query($amicizia);
 $num_amicizia=$res_amicizia->numRows();
 
 if (MDB2::isError($res_amicizia) || MDB2::isError($res_notifica_letta)){ die($result->getMessage . ', ' . $result->getDebugInfo()); }
 else redirect("index.php?view=friends");

$db->disconnect();
?>
