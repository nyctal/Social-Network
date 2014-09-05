<?php
$utente=$_POST['mail'];

//creazione cartella utente
chdir("../");
opendir(".");
mkdir("../user/".$utente);


//controllo che non ci siano stati errori in upload

if($_FILES['avatar']['error'] == 0){ //UPLOAD_ERR_OK

//controllo sul formato del file
if($_FILES['avatar']['type'] != "image/jpeg") die("Formato non valido");

//controllo il peso del file
if($_FILES['avatar']['size'] > 500*1024) die("File troppo grande");

//assegno alla variabile immagine l'immagine uploadata
$immagine = $_FILES['avatar']['tmp_name'];

$dimensioni = getimagesize ($immagine);
$larghezza = $dimensioni['0'];
$altezza = $dimensioni['1'];

if($larghezza > 200 || altezza > 200) die ("Dimensioni troppo grandi");

copy($_FILES['avatar']['tmp_name'], "../user/".$utente.$_FILES['avatar']['name']) or die ("Impossibile caricare l'immagine");

}
?>