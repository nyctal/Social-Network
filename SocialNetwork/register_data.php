<?php
session_start();
require_once("common/connectdb.php");
require_once("common/utility.php");



default_register_data();

$name=trim(strip_tags( $_POST['name']));
$surname=trim(strip_tags($_POST['surname']));
$email=trim(strip_tags($_POST['email']));
$password=trim(strip_tags($_POST['password']));
$confirm_password=trim(strip_tags($_POST['confirm_password']));
$birthplace=trim(strip_tags($_POST['birthplace']));
 
chdir("user");
opendir(".");

if(!is_dir($email))
     mkdir($email);

copy("../user/avatar.jpg", "../user/".$email."/avatar.jpg");


if( $name=="" )	{$_SESSION['name_set']=false;	  $_SESSION['all_set']=false; }

if($surname==""){$_SESSION['surname_set']=false;  $_SESSION['all_set']=false; }

if($email=="")	{$_SESSION['email_set']=false;	  $_SESSION['all_set']=false; }

if($password==""){$_SESSION['password_set']=false; $_SESSION['all_set']=false; }

if($confirm_password==""){$_SESSION['confirm_password_set']=false; $_SESSION['all_set']=false; }

if($birthplace==""){$_SESSION['birthplace_set']=false; $_SESSION['all_set']=false; }

$checkmail=ControlloEmail($email);

if( $_SESSION['all_set']==false ){ 
    
    
    redirect('reg_fail.php');
    
       
    }

else{

        if(!$checkmail){
                $_SESSION['email_ok']=false;
                
                
                
                redirect('reg_fail.php');
            }

        else if($password != $confirm_password){
                $_SESSION['pass_ok']=false;
                
                
                
                redirect('reg_fail.php');
        }

        else{


                $db=myconnect();

                $encpwd=sha1($password);

                $query = "INSERT INTO utenti (name,surname,birthplace,email,password) VALUES ( \"$name\", \"$surname\",  \"$birthplace\" , \"$email\", \"$encpwd\");";

                $result = $db->Query($query);

                if (MDB2::isError($result)){  
                    
                   //die($result->getMessage . ', ' . $result->getDebugInfo());
                    
                    
                    $_SESSION['login_fail']=true;
                    
                    
                    
                    redirect('reg_fail.php');
                
                }
                
		$db->disconnect();
                
               
                redirect('reg_ok.php');
        }

    }
	
	


	
	



?>
