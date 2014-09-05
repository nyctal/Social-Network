<?php
session_start();
require_once("common/connectdb.php");
require_once("common/utility.php");

if(isset($_SESSION['logged']) && $_SESSION['logged'] && $_SESSION['admin']){
    
    $friendEmail=$_POST['mail'];
    
    $db=myconnect();
       
    $query="UPDATE utenti
            SET banned=CURDATE()+INTERVAL 7 DAY
            WHERE email=\"$friendEmail\"
            ";
    
    $res=$db->Query($query);
    
     
    
    $db->disconnect();
    $id=$_SESSION['view'];
    redirect("index.php?view=$id");
    
}
?>
