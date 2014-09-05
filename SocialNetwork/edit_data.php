<?php 
session_start();
require_once("common/connectdb.php");
require_once("common/utility.php");



if(isset($_SESSION['logged']) && $_SESSION['logged']){ //se sono loggato

default_edit_data();


$utente=$_SESSION['email'];

//creazione cartella utente
chdir("user");
opendir(".");

if(!is_dir($utente))
    mkdir($utente);




//controllo che non ci siano stati errori in upload

if($_FILES['avatar']['error'] == 0){ //UPLOAD_ERR_OK

//controllo sul formato del file
if($_FILES['avatar']['type'] != "image/jpeg" && $_FILES['avatar']['type'] != "image/png"){ 
    $_SESSION['avatar_ext_error']=true;
    redirect('edit_error.php');

}
else $_SESSION['avatar_ext_error']=false;
//controllo il peso del file
if($_FILES['avatar']['size'] > 500*1024){
    $_SESSION['avatar_dim_error']=true;
    redirect('edit_error.php');
    
}
else $_SESSION['avatar_dim_error']=false;

//assegno alla variabile immagine l'immagine uploadata
$immagine = $_FILES['avatar']['tmp_name'];

$dimensioni = getimagesize ($immagine);
$larghezza = $dimensioni['0'];
$altezza = $dimensioni['1'];

if($larghezza > 200 || altezza > 200){
    $_SESSION['avatar_res_error']=true;
    redirect('edit_error.php');
    
}
else $_SESSION['avatar_res_error']=false;


if(!$_SESSION['avatar_ext_error'] && !$_SESSION['avatar_dim_error'] && !$_SESSION['avatar_res_error'] ){

$_FILES['avatar']['name']="avatar.jpg";
copy($_FILES['avatar']['tmp_name'], "../user/".$utente."/".$_FILES['avatar']['name']);
    }
}

$email=$_SESSION['email'];
//mi salvo tutti i dati provenienti in post dal form di modifica profilo
$name=trim(strip_tags($_POST['name']));
$surname=trim(strip_tags($_POST['surname']));
$password=trim(strip_tags($_POST['password']));
$confirm_password=trim(strip_tags($_POST['confirm_password']));
$birthplace=trim(strip_tags($_POST['birthplace']));
$studytitle=trim(strip_tags($_POST['studio']));
$hobby1=trim(strip_tags($_POST['hobby1']));
$hobby2=trim(strip_tags($_POST['hobby2']));
$hobby3=trim(strip_tags($_POST['hobby3']));

$visibility=trim($_POST['visibility']);


//setto le variabili di sessione inerenti al settaggio dei campi obbligatori
if($name=="" ){$_SESSION['name_set']=false;	  $_SESSION['all_set']=false; }

if($surname==""){$_SESSION['surname_set']=false;  $_SESSION['all_set']=false; }

if($password==""){$_SESSION['password_set']=false; $_SESSION['all_set']=false; }

if($confirm_password==""){$_SESSION['confirm_password_set']=false; $_SESSION['all_set']=false; }

if($birthplace==""){$_SESSION['birthplace_set']=false; $_SESSION['all_set']=false; }


if( $_SESSION['all_set']==false ){ redirect('edit_error.php',1);}

else{

        if($password != $confirm_password){
                $_SESSION['pass_ok']=false;
                redirect('edit_error.php',1);
        }
        else{
                
                $db=myconnect(); //mi connetto al server

                $encpwd=sha1($password); //cripto la password
               
                $s=sprintf( "UPDATE utenti 
                            SET name=\"%s\",
                            surname=\"%s\",
                            birthplace=\"%s\",
                            password=\"%s\",
                            titolo_studio=\"%s\",
                            hobby1=\"%s\",
                            hobby2=\"%s\",
                            hobby3=\"%s\",
                            visibility=\"%s\"
                            WHERE email=\"%s\";", $name,$surname,$birthplace,$encpwd,$studytitle,$_POST['hobby1'],$_POST['hobby2'],$_POST['hobby3'],$visibility,$email );
                            
                            //definisco l query di update sui campi
                
                
                $result = $db->Query($s); //eseguo la query

                if (MDB2::isError($result)){ //se c'è un errore facciamo un redirect su una pagina di errore
                                        
                    redirect('edit_error.php',1);                   
                    
                    }
                else{ //in caso contrario setto le variabili di sessione aggiornate circa i dati del profilo
                        $_SESSION['user_name']=$name;
                        $_SESSION['user_surname']=$surname;
                        $_SESSION['birthplace']=$birthplace;
                        $_SESSION['study_title']=$studytitle;
                        $_SESSION['hobby1']=$hobby1;
                        $_SESSION['hobby2']=$hobby2;
                        $_SESSION['hobby3']=$hobby3;
                        $_SESSION['visibility']=$visibility;
                    
                }
                
		$db->disconnect(); //mi disconnetto
                redirect('index.php?view=welcome',2); //redirect alla pagina iniziale
                  
            }

    }

}
else redirect('access_denied.php');//se non sei loggato accesso negato



?>
