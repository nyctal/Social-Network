<?php
session_start();
require_once("common/connectdb.php");
require_once("common/utility.php");
include("grafo.php");

$email=$_SESSION['email'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="JS/js.js"></script>
<script type="text/javascript" src="JS/jquery.js"></script>



<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>DisiBook</title>
<link href="css/master.css" rel="stylesheet" type="text/css" /></head>

<body>


    
<?php 

$arr=get_cookie(); //Richiamo la funzione set_cookie() in utility

$last_email=$arr["cookie"][0];  //recupero la mail dall'array dei cookie
$last_password=$arr["cookie"][1]; //recupero la password dall'array dei cookie

if(!isset($_SESSION['login_fail']) || $_SESSION['login_fail']) //se il login è fallito o non è stato effettuato
     $_SESSION['logged']=false; //setto logged come falso
else $_SESSION['logged']=true; //altrimenti come vero


?>    
      
<div id="container"> <!-- apro il div contenitore principale -->
     
<?php 

$_SESSION['view']=$_GET['view']; //setto la variabile di sessione view che mi mostrerà il contenuto in base al suo valore
$update=$_GET['update']; //setto il valore di update per poter aggiornare in seguito lo stato di lettura delle notifiche




include('header.php'); //inclusioni per il layout della pagina
include("menu.php");
include('leftmenu.php');
include('main.php');
include('rightmenu.php');
include('footer.php');

?>
</div>  <!-- chiudo il div contenitore principale -->
</body>
</html>
