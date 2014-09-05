<?php 
include('AES.class.php');

/*
 * <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="../JS/js.js"></script>
<script type="text/javascript" src="../JS/jquery.js"></script>


<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>DisiBook</title>
<link href="css/master.css" rel="stylesheet" type="text/css" /></head>
 */
function hex2bin($h)
  {
    if (!is_string($h)) return null;
    $r='';
    for ($a=0; $a<strlen($h); $a+=2) { 
        $r.=chr(hexdec($h{$a}.$h{($a+1)})); 
     }
    return $r;
  }  

function init_AES(){
    
    //$z = "abcdefghijuklmno0123456789012345"; 
    $z=    "ilnostrovettoredinizializzazione";
    $aes = new AES($z);
    
    return $aes;
    
}  
  
function encrypt_id($data){
    
    $aes=init_AES();
    
    $id_p=$aes->encrypt($data);
    $id=bin2hex($id_p);
    
    return $id;
    
    
}

function decrypt_id($data){
    
    $aes=init_AES();
        
    $data2=hex2bin($data);
		
    $decryp=$aes->decrypt($data2);

    $id=stripslashes($decryp);
    
    return $id;
        
}


function rmdirr($dir) {             // funzione ricorsiva per cancellare una cartella con contenuto (rmdir standard non funzione se la cartella ha contenuto interno)
   $objs = @glob($dir."/*");    // salvo tutti glo oggetti all'interno della directory (sudirectory e file) nell'array $objs
        foreach($objs as $obj) {    // per ogi oggetto all'interno della directory ( quindi dell'array $objs )
	 @is_dir($obj)? rmdirr($obj) : @unlink($obj); // controllo: se è un directory, richiamo rmdirr sulla subdirectory, se è un file loc ancello con unlink
	  }
 
@rmdir($dir);                       // infine rimuovo la directory con rmdir standards di php, visto che ormai è vuota
}		


function print_notification_in_small($name,$surname,$email,$plain_id){
        
    $id=encrypt_id($plain_id); //cripto l'id
    echo "<div class='small_slot'>"; //apro il div per lo slot piccolo
    echo "<a href='index.php?view=$id'><img src='user/$email/avatar.jpg' class=preview_mini_img /> </a>"; //stampo l'avatar piccolo
    echo "<p class='testo_semplice4'> Ti ha chiesto l'amicizia<br>"; 
    echo "<a href='index.php?view=$id'>$name $surname</a></p> </a>"; //stampo nome e congome
    echo "</div>"; //chiudo il div del mini slot
}

function print_notification_out_small($name,$surname,$email,$plain_id){
    
    $id=encrypt_id($plain_id); //cripto l'id
    echo "<div class='small_slot'>"; //apro il div per lo slot piccolo
    echo "<a href='index.php?view=$id'><img src='user/$email/avatar.jpg' class=preview_mini_img /> </a>"; //stampo l'avatar piccolo
    echo "<p class='testo_semplice4'> Hai chiesto l'amicizia a<br>"; 
    echo "<a href='index.php?view=$id'>$name $surname</a></p> </a>"; //stampo nome e congome
    echo "</div>";//chiudo il div del mini slot
}

function print_notification_alert_small($name,$surname,$email,$plain_id){
        
    $id=encrypt_id($plain_id); //cripto l'id
    echo "<div class='small_slot'>"; //apro il div per lo slot piccolo
    echo "<a href='index.php?view=$id&update=true' ><img src='user/$email/avatar.jpg' class=preview_mini_img /> </a>"; //stampo l'avatar piccolo
    echo "<p class='testo_semplice4'> Sei ora amico di<br>"; 
    echo "<a href='index.php?view=$id&update=true'>$name $surname</a></p> </a>"; //stampo nome e congome 
    echo "</div>"; //chiudo il div del mini slot
}

function print_notification_alert_big($name,$surname,$email,$plain_id){
        
    $id=encrypt_id($plain_id);
    echo "<div class='big_slot'>";
    echo "<a href='index.php?view=$id&update=true'><img src='user/$email/avatar.jpg' class=preview_little_img /> </a>";
    echo "<p class='testo_semplice3'> Sei ora amico di<br>"; 
    echo "<a href='index.php?view=$id&update=true'>$name $surname</a></p> </a>"; //stampo nome e congome 
    echo "</div>";
}

function print_user_search_small($name,$surname,$email,$plain_id){
        
    $amico=false;
    $logged_email=$_SESSION['email'];
    
    $id=encrypt_id($plain_id);
        
    $db=myconnect();
	
	$amici="SELECT utenteA  FROM richiestaamicizia WHERE stato=\"accettata\" AND utenteB=\"$logged_email\" UNION
                  SELECT utenteB  FROM richiestaamicizia WHERE stato=\"accettata\" AND utenteA=\"$logged_email\"";
	
    $query="SELECT email FROM utenti WHERE email IN ($amici) AND email=\"$email\";";
    
    $res=$db->Query($query);
    
    if (MDB2::isError($res))
        die($res->getMessage . ', ' . $res->getDebugInfo());
            
    else{
			$numres=$res->numRows();
			if( $numres>0 ) $amico=true;
			
			
		} 
	
	
    
    echo "<div class='small_slot2'>";
    echo "<a href='index.php?view=$id'><img src='user/$email/avatar.jpg' class=preview_mini_img /> </a>";
    echo "<a href='index.php?view=$id'><br><b class='testo_semplice'>$name</b><br><b class='testo_semplice'>$surname </b></a>";
    if($amico==true) echo "<br><b class='friend'>FRIEND</b>";
    
    echo "</div>";
}

function print_user_search_big($name,$surname,$email,$plain_id){
        
    $amico=false;
    $logged_email=$_SESSION['email'];
    
    $id=encrypt_id($plain_id);
        
    $db=myconnect();
	
	$amici="SELECT utenteA  FROM richiestaamicizia WHERE stato=\"accettata\" AND utenteB=\"$logged_email\" UNION
                  SELECT utenteB  FROM richiestaamicizia WHERE stato=\"accettata\" AND utenteA=\"$logged_email\"";
	
    $query="SELECT email FROM utenti WHERE email IN ($amici) AND email=\"$email\";";
    
    $res=$db->Query($query);
    
    if (MDB2::isError($res))
        die($res->getMessage . ', ' . $res->getDebugInfo());
            
    else{
			$numres=$res->numRows();
			if( $numres>0 ) $amico=true;
			
			
		} 
	
	
    
    echo "<div class='big_slot'>";
    echo "<a href='index.php?view=$id'><img src='user/$email/avatar.jpg' class=preview_little_img /> </a>";
    echo "<a href='index.php?view=$id'><b class='testo_semplice3'><br>$name<br>$surname</b> </a>";
    if($amico==true) echo "<br><br><b class='friend'>FRIEND</b>";
    
    echo "</div>";
}

function print_notification_in_big($name,$surname,$email,$plain_id){
        
    $id=encrypt_id($plain_id);
    echo "<div class='big_slot'>";
    echo "<a href='index.php?view=$id'><img src='user/$email/avatar.jpg' class=preview_little_img /> </a>";
    echo "<p class='testo_semplice3'> Ti ha chiesto l'amicizia<br>";
    echo "<a href='index.php?view=$id'>$name $surname</a></p> </a>";
    echo "</div>";
}

function print_notification_out_big($name,$surname,$email,$plain_id){
    
    $id=encrypt_id($plain_id);
    echo "<div class='big_slot'>";
    echo "<a href='index.php?view=$id'><img src='user/$email/avatar.jpg' class=preview_little_img /> </a>";
    echo "<p class='testo_semplice3'> Hai chiesto l'amicizia a <br>";
    echo "<a href='index.php?view=$id'>$name $surname</a></p> </a>";
    echo "</div>";
}

function take_notifications_in($email){
    
    $db=myconnect(); //mi connetto al database
    
    $amicizie_ricevute="SELECT name,surname,email,id
                        FROM utenti JOIN richiestaamicizia ON email=utenteA
                        WHERE utenteB=\"$email\" AND stato='in attesa'"; //tutte le richieste di amicizia in attesa ricevute
    
    $res_ricevute = $db->Query($amicizie_ricevute); //memorizzo il risultato della query
    $db->disconnect(); //mi disconnetto il database
    return $res_ricevute; //ritorno l'oggetto mdb2 del risultato
    
    
}
function take_notifications_out($email){
    
    $db=myconnect(); //mi connetto al database
    
    $amicizie_inviate ="SELECT name,surname,email,id
                        FROM utenti JOIN richiestaamicizia ON email=utenteB
                        WHERE utenteA=\"$email\" AND stato='in attesa'"; //tutte le richieste di amicizia in attesa inviate
    
    $res_inviate=$db->Query($amicizie_inviate); //memorizzo il risultato della query
    $db->disconnect(); //mi disconnetto il database
    
    return $res_inviate; //ritorno l'oggetto mdb2 del risultato
    
}
function take_notifications_changes($email,$idFriend=false,$update=false){
    
    $db=myconnect(); //mi connetto al database
    
    if($update==true)update_notification($email,$idFriend); //se update viene passato allora aggiorno lo stato di lettura delle notifiche
    
    
    
    $cambi_notifiche = "SELECT name,surname,email,id
                        FROM utenti JOIN notifiche ON email=utenteB
                        WHERE utenteA=\"$email\" AND stato='non letta'"; //seleziono le notifiche ancora non lette
    
    $notify=$db->Query($cambi_notifiche); //memorizzo il risultato della query in notify
    $db->disconnect(); //mi disconnetto il database
    
    return $notify; //ritorno il risultato della query
    
}
function update_notification($email,$plain_id){
    
	$idFriend=decrypt_id($plain_id); //decripto l'id
    $db=myconnect(); //mi connetto al databse
    
    $recuperaEmail="SELECT email FROM utenti WHERE id=\"$idFriend\"; "; //recupero la mail partendo da un id passato come parametro
    $res_recuperaEmail=$db->Query($recuperaEmail); //eseguo la query e ne memorizzo il risultato
    $friend=$res_recuperaEmail->FetchRow(); //memorizzo in friend la riga
    $friendMail=$friend[0]; //memorizzo in friendMail la prima colonna ovvero l'email

    $notifica_letta="UPDATE notifiche SET stato='letta' WHERE utenteA=\"$email\" AND utenteB=\"$friendMail\"  "; //creo la query per impostare come letta la notifica
    $res_notifica_letta=$db->Query($notifica_letta); //eseguo la query 
            
    
    
    $db->disconnect();
    
}
function search_users($input){
    
    
    
    $len=strlen($input); //memorizzo la lunghezza dell'input

        list($name,$surname)=explode(" ",$input); //memorizzo in name e surname in base allo spazio

        $len_name=strlen($name); //memorizzo la lunghezza del nome
        $len_surname=strlen($surname); //memorizzo la lunghezza del cognome
               
        $email=$_SESSION['email']; //salvo l'e-mail
       
        if($len>0){ //se la lunghezza della stringa è maggiore di zero
            
      	    $db=myconnect(); //mi connetto al database
            
            if($len_name>2 && $len_surname>2){ //sia nome che cognome hanno più di due lettere

                $query = "(SELECT name, surname, email, id 
                          FROM utenti
                          WHERE email <> \"$email\" AND (
                          surname LIKE '%$surname%'
                          OR name LIKE '%$name%' ))
                          UNION DISTINCT
                          (SELECT name, surname, email, id
                          FROM utenti
                          WHERE email <> \"$email\" AND (
                          name LIKE '%$surname%'
                          OR surname LIKE '%$name%' ))
                          "; 
            }
            else if($len_name>2){ //nome ha più di due lettere

                $query = "SELECT name, surname, email, id
                          FROM utenti
                          WHERE email <> \"$email\" AND (
                          name LIKE '%$name%' 
                          OR surname LIKE '%$name%' )
                          ";

            }
			else if($len_surname>2){ //cognome ha più di due lettere

                $query = "SELECT name, surname, email, id
                          FROM utenti
                          WHERE email <> \"$email\" AND (
                          name LIKE '%$surname%' 
                          OR surname LIKE '%$surname%' )
                          ";

            }
            else if($len_name>0){ //se il nome ha solo 1 o 2 lettere

                $query = "SELECT name, surname, email, id 
                          FROM utenti
                          WHERE email <> \"$email\" AND (
                          name LIKE '$input%' 
                          OR surname LIKE '$input%' )";

            }


            $result = $db->Query($query); //eseguo la query e salvo il risultato in result

            if (MDB2::isError($result))
                  return NULL;

            $db->disconnect(); //mi disconnetto

            return $result; //ritorno il risultato
    
    }
    
    return NULL;
}



function print_users_bannable($name,$surname,$email, $plain_id, $banned_date){
    
   $id=encrypt_id($plain_id);
    
   echo "<div class='big_slot'>";
                           
   echo "<a href='index.php?view=$id'><img src='user/$email/avatar.jpg' class=preview_little_img /> </a>";

   echo "<a href='index.php?view=$id'><b class='testo_semplice'><br>$name $surname</b> </a>";
   
   if($banned_date==null){
   
   echo "<form action='ban.php' method='post' name='ban_form'>
	<input id='submit_ban' name='submit_ban' value='Ban' type='submit' class='button_generic'/>
	<input name='mail' type='hidden' value=$email />
	</form>";
   }
   else{
       
       echo "<br><b class='banned'>BANNED UNTIL ". $banned_date ."</b><br>";
       
   }

   echo"<form action='delete_user.php' method='post' name='delete_form' onsubmit='return alert_delete(this)' >
	<input id='submit_delete' name='delete' type='submit' value='Delete' class='button_generic' />
	<input name='mail' type='hidden' value=$email />
	</form>	";
   echo "</div>";
    
}

function print_friends($name,$surname,$email, $plain_id){
    
   $id=encrypt_id($plain_id); //cripto l'id
    
   echo "<div class='big_slot'>";
                           
   echo "<a href='index.php?view=$id'><img src='user/$email/avatar.jpg' class=preview_little_img </a>"; //stampa immagine

   echo "<a href='index.php?view=$id'><b class='testo_semplice'><br>$name<br>$surname</b> </a>"; //stampa nome e cognome

   echo "</div>";
    
}

function print_suggested_friends_or_neighbours($name,$surname,$email, $plain_id){
    
   $id=encrypt_id($plain_id); //cripto l'id
    
   echo "<div class='slot'>";
                           
   echo "<a href='index.php?view=$id'><img src='user/$email/avatar.jpg' class=preview_little_img </a>"; //stampa immagine

   echo "<a href='index.php?view=$id'><b class='testo_semplice'><br>$name<br>$surname</b> </a>"; //stampa nome e cognome

   echo "</div>";
    
}

function print_neighbours($name,$surname,$email, $plain_id){
    
   $id=encrypt_id($plain_id); //cripto l'id
    
   echo "<div class='big_slot'>";
                           
   echo "<a href='index.php?view=$id'><img src='user/$email/avatar.jpg' class=preview_little_img </a>"; //stampa immagine

   echo "<a href='index.php?view=$id'><b class='testo_semplice'><br>$name<br>$surname</b> </a>"; //stampa nome e cognome

   echo "</div>";
    
}

function redirect($url,$tempo = FALSE ){
	 if(!headers_sent() && $tempo == FALSE ){
	  
	  header('Location:' . $url);
	 
	 }
	 elseif(!headers_sent() && $tempo != FALSE ){
  		
  		header('Refresh:' . $tempo . ';' . $url);
 	}else{
 	
  		if($tempo == FALSE ){
    		$tempo = 0;
  	}
        
   echo "<meta http-equiv=\"refresh\" content=\"" . $tempo . ";" . $url . "\">";
  
  }
}

function get_cookie(){
    
      if(isset($_COOKIE['last_email']) && isset($_COOKIE['last_password'])){  //controllo che i cookie siano settati

	$last_email=$_COOKIE['last_email']; //salvo il cookie per la mail
	$last_password=$_COOKIE['last_password']; //salvo il cookie per la password
	
        $arr = array("cookie" => array(0 => $last_email, 1 => $last_password)); //salvo in un array la mail e la password per poter ritornare due valori
    }
    else{
	$last_email=""; //se non sono settati ritorno valori vuoti
	$last_password="";
        $arr = array("cookie" => array(0 => "", 1 => ""));
	}
    return $arr;
}

function ControlloEmail($email){
		
	return	preg_match('/^[^@]+@[a-zA-Z0-9._-]+\.[a-zA-Z]+$/', $email);
}

function print_login_menu($last_email,$last_password){

    $email=decrypt_id($last_email); //decriptiamo la mail
    $password=decrypt_id($last_password); //decriptiamo la password
    
        
echo <<<PRINT
          <div id=menu>
	  <form action="login.php" method="post" name="login" id="login">
    	    
   	  <label for="mail">mail</label>
          <input name="mail" type="text" value='$email'  tabindex="10"     />
         
          <label for="password">password</label>
          <input name="password" type="password" value='$password' tabindex="20"/>

          <label for="ricordami">ricordami</label>
          <input name="ricordami" type="checkbox" tabindex="30"/>
    
        <input name="logga" id="logga" type="submit" value="Login" tabindex="40"/></form>
        </div>
PRINT;


}

function print_logged_menu($in=0, $out=0, $notifies=0){

echo "<div id=\"menu\">"; //apro il div contenitore principale per il menu

echo "<div class='icon_div'>"; //apro il div contenitore delle icone per le notifiche

if($notifies==0) //selettore per l'icona non attiva oppure attiva
    echo "<img src='images/menu buttons/menu_bar/alert_icon_inactive.png' onkeydown=view(event,'alert') onclick=view(event,'alert')  width='94' height='78' alt='Notifiche' id='alert' class='menu_icons' tabindex='120'/>";
else echo "<img src='images/menu buttons/menu_bar/alert_icon.png' onkeydown=view(event,'alert') onclick=view(event,'alert')  width='94' height='78' alt='Notifiche' id='alert' class='menu_icons' tabindex='120'/>";

if($in==0) //selettore per l'icona non attiva oppure attiva
     echo "<img src='images/menu buttons/menu_bar/inbox_inactive.png' onkeydown=view(event,'inbox') onclick=view(event,'inbox')  width='94' height='78' alt='Richieste in arrivo' id='inbox' class='menu_icons' tabindex='130'/>";
else echo "<img src='images/menu buttons/menu_bar/inbox.png' width='94' height='78' onkeydown=view(event,'inbox') onclick=view(event,'inbox')  alt='Richieste in arrivo' id='inbox' class='menu_icons' tabindex='130'/>";

if($out==0) //selettore per l'icona non attiva oppure attiva
     echo "<img src='images/menu buttons/menu_bar/out_inactive.png' onkeydown=view(event,'outbox') onclick=view(event,'outbox')  width='94' height='78' alt='Richieste in uscita' id='outbox' class='menu_icons' tabindex='140'/>";
else echo "<img src='images/menu buttons/menu_bar/out.png' onkeydown=view(event,'outbox') onclick=view(event,'outbox')  width='94' height='78' alt='Richieste in uscita' id='outbox' class='menu_icons' tabindex='140'/>";


echo "</div>"; //chiudo il div per le icone notifiche


echo <<<SEARCH_FORM
<div id="search_form_div" class="search_form_div"> 
<form id="search_form" name="user_search" method="get"  action="index.php" onFocusIn="clear_search_user(this)" onFocusOut="close_pane('livesearch')" >
        
<input id="q" type="text" name="q" value="Ricerca Utenti"  tabindex="150" onkeyup="showResult(this.value)"/>

<input id="view" type="hidden" name="view" value="search_result" "/>

<input name="search_register" type="submit" id="search_register" class="button_generic" value="Search" tabindex="160" style="margin-top:4px;"/>
<div id="livesearch"></div>
</form>
</div>

SEARCH_FORM;



printf('<b id="loggedin"> Logged as <STRONG>%s %s</STRONG> <a class="logout_button" href="logout.php" tabindex="170">Logout</a></b>', $_SESSION['user_name'], $_SESSION['user_surname']);
echo "</div>";

}

function print_hobbies($hobby){ //funzione per la stampa degli hobby nel form di edita profilo

        $db=myconnect();
	
	$query = "SELECT name FROM hobbies;";
	
	$result = $db->Query($query);
	
	while($row = $result->fetchRow())
            if($row[0]==$hobby) //se l'hobby è lo stesso che abbiamo passato lo metto come selected
                 echo "<option selected>$row[0]</option>";
            else echo "<option >$row[0]</option>"; //altrimenti lo stampo non selezionato
	
	$db->disconnect();
        
        
}

function print_visibility($visibility){ //funzione di stampa per il riempimento del campo visibilità in edit_profile
    
    if($visibility=='pubblico')
        echo "<option selected>pubblico</option>";
    else echo "<option>pubblico</option>";
    
    if($visibility=='privato')
        echo "<option selected>privato</option>";
    else echo "<option>privato</option>";
    
    if($visibility=='solo amici')
        echo "<option selected>solo amici</option>";
    else echo "<option>solo amici</option>";
    
    
}

function default_edit_data(){ //setto tutti i valori di controllo settaggio a true

	$_SESSION['email_ok']            =true;
	$_SESSION['pass_ok']	         =true;
	$_SESSION['all_set']	         =true;
	$_SESSION['name_set']	         =true;
	$_SESSION['surname_set']         =true;
	$_SESSION['email_set']	         =true;
        $_SESSION['birthplace_set']      =true;
	$_SESSION['password_set']        =true;
	$_SESSION['confirm_password_set']=true;

}

function default_register_data(){

	$_SESSION['login_fail']          =true; 
	$_SESSION['email_ok']            =true;
	$_SESSION['pass_ok']             =true;
	$_SESSION['all_set']             =true;
	$_SESSION['name_set']            =true;
	$_SESSION['surname_set']         =true;
	$_SESSION['email_set']           =true;
        $_SESSION['birthplace_set']      =true;
	$_SESSION['password_set']        =true;
	$_SESSION['confirm_password_set']=true;

}

function unset_session_var(){

	unset($_SESSION['login_fail']);
	unset($_SESSION['email_ok']);
	unset($_SESSION['pass_ok']);
	unset($_SESSION['all_set']);
	unset($_SESSION['name_set']);
	unset($_SESSION['birthplace_set']);
	unset($_SESSION['surname_set']);
	unset($_SESSION['password_set']);
	unset($_SESSION['confirm_password_set']);
	unset($_SESSION['user_name']);
	unset($_SESSION['user_surname']);
        session_destroy();
    
}



?>
