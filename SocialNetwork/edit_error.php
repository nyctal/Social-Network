<?php
session_start();

require_once("common/utility.php");

?>

<head>
<link href="css/master.css" rel="stylesheet" type="text/css" />
</head>
        <body>
        <center><h1><br><br>ERRORE NELLA MODIFICA DEI DATI </h1></center>;
        <center><h3>...tra pochi secondi verrai reindirizzato al tuo profilo...</h4></center>;
        
<?php if($_SESSION['avatar_ext_error']) echo "<center><h3>- Estensione file avatar non supportata, solo jpeg o png</h3>"; 
      if($_SESSION['avatar_dim_error']) echo "<center><h3>- Dimensione file avatar non supportata, 500kb</h3>"; 
      if($_SESSION['avatar_res_error']) echo "<center><h3>- Risoluzione file avatar non supportata, max 200x200</h3>"; 


      if(!$_SESSION['all_set']) echo "<center><h3>- Inserire tutti i dati obbligatori</h3>";
      if(!$_SESSION['pass_ok']) echo "<center><h3>- Le due password non coincidono</h3>";

?>



        </body>

        
<?php	redirect('index.php?view=edit_profile','2');?>
