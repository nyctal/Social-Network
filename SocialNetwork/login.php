<?php 
session_start();
require_once("common/connectdb.php");
require_once("common/utility.php");



$_SESSION['email_ok']=false; 
$_SESSION['email']=trim(strip_tags( $_POST["mail"]));
$_SESSION['password']=trim(strip_tags( $_POST["password"]));
$_SESSION['login_fail']=false; 

$email = $_SESSION['email'];
$password  = $_SESSION['password'];
$remember = $_POST['ricordami'];

if($remember){
	
	$anno=3600*24*365;
	$res1=setcookie('last_email',encrypt_id($email),time()+$anno);
	$res2=setcookie('last_password',encrypt_id($password),time()+$anno);
	
}



$_SESSION['email_ok']=ControlloEmail($email); //controllo che la mail rispetti il formato

if(!$_SESSION['email_ok']){
	$_SESSION['login_fail']=true; 
        $_SESSION['logged']=false;
	$_SESSION['email_ok']=true;
	redirect("login_error.php"); //se non � ok rimando all'errore
}
else{

	$db=myconnect(); //mi connetto al database
	
	$encpwd=sha1($password); //criptiamo la password da salvare nel database
	
	$query = "SELECT name,surname,birthplace,titolo_studio,hobby1,hobby2,hobby3,visibility,admin,banned FROM utenti WHERE email=\"$email\" AND password=\"$encpwd\";";
	//estraiamo i dati dell'utente loggato
	$result = $db->Query($query);
		

	if (MDB2::isError($result)){  
	
		$_SESSION['login_fail']=true; 
                $_SESSION['logged']=false;
		
		$db->disconnect();
                redirect('error.php');
		

	}
	else if (($result->numRows())==1){ //se non ci sono errori e si ottiene un risultato unico
                $row = $result->fetchRow(); //lo memorizzo in row
                
              
                
                if($row[9]!=null){ //se l'utente � bannato
                    $current_date=date("Y-m-d");
                    if($row[9]>$current_date){ //controllo che la data di scadenza del ban sia maggiore della data odierna
                    
                    $_SESSION['login_fail']=true; 
                    $_SESSION['logged']=false;
                    
                    
                    redirect("banned.php?date=$row[9]");
                    }
                    else { //se la data di ban � stata superata salvo tutti i dati come in ogni login di successo
                        
                        $_SESSION['login_fail']=false; 
                        $_SESSION['logged']=true;

                        $_SESSION['user_name']=$row[0];
                        $_SESSION['user_surname']=$row[1];
                        $_SESSION['birthplace']= $row[2];
                        $_SESSION['study_title']=$row[3];
                        $_SESSION['hobby1']=$row[4];
                        $_SESSION['hobby2']=$row[5];
                        $_SESSION['hobby3']=$row[6];
                        $_SESSION['visibility']=$row[7];
                        $_SESSION['admin']=$row[8];

                        $_SESSION['view']='welcome';

                        $update_banned_state="UPDATE utenti SET banned=NULL WHERE email=\"$email\"  "; //setto a null il ban
                        $db->Query($update_banned_state);
                        $db->disconnect();

                        redirect('index.php?view=welcome');
                        
                        
                    }
                    
                }
            
                else{ //se l'utente non � bannato salvo tutti i dati per un login di successo
		$_SESSION['login_fail']=false; 
		$_SESSION['logged']=true;
				
		$_SESSION['user_name']=$row[0];
		$_SESSION['user_surname']=$row[1];
		$_SESSION['birthplace']= $row[2];
		$_SESSION['study_title']=$row[3];
		$_SESSION['hobby1']=$row[4];
		$_SESSION['hobby2']=$row[5];
		$_SESSION['hobby3']=$row[6];
                $_SESSION['visibility']=$row[7];
                $_SESSION['admin']=$row[8];
                
		$_SESSION['view']='welcome';
                
                $db->disconnect();
                
                redirect('index.php?view=welcome');
                }
	}
	else {	
			$_SESSION['login_fail']=true; 
                        $_SESSION['logged']=false;
			printf('Errore login: num row %d',$num_res); 
			
			$db->disconnect();
			
			redirect('login_error.php');		
		}
}

?>
