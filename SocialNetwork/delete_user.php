<?php
session_start();
require_once("common/connectdb.php");
require_once("common/utility.php");

if(isset($_SESSION['logged']) && $_SESSION['logged'] && $_SESSION['admin']){
    
    
    $friendEmail=$_POST['mail'];
    
    $db=myconnect();
    
    $query=" DELETE FROM utenti
             WHERE email=\"$friendEmail\"
            ";
    
    $res=$db->Query($query);
    
     
    
    
     chdir("user");
     opendir(".");

     rmdirr($friendEmail);
     
     
    $db->disconnect();
    $id=$_SESSION['view'];
    redirect("index.php?view=$id");
    
}


?>
