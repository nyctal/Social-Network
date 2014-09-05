<?php 
session_start();
require_once("common/connectdb.php");
require_once("common/utility.php");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head> 
<script type="text/javascript" src="JS/jquery.js"></script>    
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>



<?php
// onsubmit="return check_form(this)"
if(isset($_SESSION['logged']) && $_SESSION['logged']){ //se sono loggato mi salvo tutte le variabili per il riempimento del profilo
      
	$studytitle=$_SESSION['study_title'];       
	$name=$_SESSION['user_name'];
        $surname=$_SESSION['user_surname'];
        $birthplace=$_SESSION['birthplace'];
	$email=$_SESSION['email'];
	$password=$_SESSION['password'];
        $hobby1=$_SESSION['hobby1'];
        $hobby2=$_SESSION['hobby2'];
        $hobby3=$_SESSION['hobby3'];
        $visibility=$_SESSION['visibility'];

echo <<<PROFILE

<form id="EditProfile" name="EditProfile" method="post"   enctype="multipart/form-data" action="edit_data.php">
    <fieldset id="edit"><legend id="edit_leg">Modifica Profilo</legend>
      <fieldset class="edit_std">
        <legend class="inside_leg">Informazioni su di te</legend>
        <p>
          <label id="label_name" for="name">Name</label>
          <input id="name" type="text" name="name" tabindex="300" value="$name"  />
        </p>
        <p>
          <label for="surname">Surname</label>
          <input id="surname" type="text" name="surname"  tabindex="310" value="$surname" />
        </p>
        <p>
          <label for="birthplace">Birthplace</label>
          <input id="birthplace" type="text" name="birthplace"  tabindex="320" value="$birthplace" />
        </p>
	<span id="error"  class="error"></span>
      </fieldset>
      <fieldset class="edit_std"><legend class="inside_leg">Il tuo profilo</legend>
        <p>
          <label for="email">E-mail</label>
          <input id="email" type="text" name="email"  tabindex="330" value="$email" disabled />
        </p>
        <p>
          <label for="password">Password</label>
          <input id="password" type="password" name="password"  tabindex="340" value="$password" />
        </p>
        <p>
          <label for="confirm_password">Confirm password</label>
          <input id="confirm_password" type="password" name="confirm_password"  tabindex="350" value="$password" />
        </p>
	<span id="error2" class="error"></span>
      </fieldset>
      <fieldset class="edit_std"><legend class="inside_leg">Informazioni aggiuntive</legend>
        <p>
          <label for="studio">Titolo di studio</label>
          <input id="studio" type="text" name="studio"  tabindex="360" value="$studytitle" />
        </p>
        
        <p>
          <label for="hobby1">Hobby1</label>
          
          <select name="hobby1" id="hobby1" class="hobbies" tabindex="370" title="Hobby" >
PROFILE;
	print_hobbies($hobby1); //funziona di stampa delle opzioni degli hobby

?>
            
        </select>
        </p>
        <p id="hobby2">
        <label for="hobby2">Hobby2</label>
        <select name="hobby2"  class="hobbies" tabindex="380" title="Hobby" >
            
          
<?php 
        print_hobbies($hobby2); //funziona di stampa delle opzioni degli hobby
?>            
        </select>
        </p>
        
        <p id="hobby3"> <label for="hobby3">Hobby3</label>
        <select name="hobby3"  class="hobbies" tabindex="390" title="Hobby" >
<?php 
        print_hobbies($hobby3); //funziona di stampa delle opzioni degli hobby
?>               
        </select>
        </p>  
        <p>
        <label for="visibility">Visibilità Profilo</label>    
        <select name="visibility" id="visibility" class="hobbies" tabindex="400" title="Visibilità Profilo" >
        <?php      print_visibility($visibility); ?>
            
        </select>    
        </p>
        
        <p>
          <label for="avatar">Avatar</label>
          <input id="avatar" type="file" name="avatar"  tabindex="410" />
          <br><br>
           (max 200 x 200 px, JPG or PNG)
        </p>
      </fieldset>
	
        <input name="Modify" type="submit" value="Modify" id="Modify"  tabindex="420" />
      </fieldset>
    </form>
<?php 

}

else redirect('access_denied.php'); //se non sono loggato accesso negato
?>

</html>

<script> //script per il controllo dei campi obbligatori tramite jquery
            $("#name").click(function()             {  $("#name").removeClass("h_lighted");       }); //quando click tolgo il bordo rosso
            $("#surname").click(function()          {  $("#surname").removeClass("h_lighted");       });
            $("#email").click(function()            {  $("#email").removeClass("h_lighted");       });
            $("#password").click(function()         {  $("#password").removeClass("h_lighted");       });
            $("#confirm_password").click(function() {  $("#confirm_password").removeClass("h_lighted");       });
            $("#bithplace").click(function()        {  $("#birthplace").removeClass("h_lighted");       });
            
            $("#EditProfile").submit(function() { //viene eseguita on submit
               var error=false;
               var pass_error=false;
               var email_error=false;
               
               if ($("#confirm_password").val()==""){ //se il campo è vuoto
                    $("#confirm_password").addClass("h_lighted"); //setto il bordo rosso
                    $("#confirm_password").focus(); //gli imposto il focus
                    error=true; //segnalo che c'è un errore
               }
               if ($("#password").val()==""){
                    $("#password").addClass("h_lighted");
                    $("#password").focus();
                    error=true;
               }
                              
               if ($("#birthplace").val()==""){
                    $("#birthplace").addClass("h_lighted");
                    $("#bithplace").focus();
                    error=true;
               }
               if ($("#surname").val()==""){
                    $("#surname").addClass("h_lighted");
                    $("#surname").focus();
                    error=true;
               }
               if ($("#name").val()==""){
                    $("#name").addClass("h_lighted");
                    $("#name").focus();
                    error=true;
               }
                              
               if ($("#password").val()!=$("#confirm_password").val()){ //controllo che la password sia uguale
                   $("#password").addClass("h_lighted"); //aggiungo il bordo rosso
                   $("#password").focus(); //imposto il focus
                   $("#confirm_password").addClass("h_lighted"); //aggiungo il bordo rosso
                   pass_error=true; //segnalo che c'è un errore
               
                }
                
               if(error)$("#error").text("Inserire i campi obbligatori").show().fadeOut(3000); //scrivo nelle variabili l'errore
               if(pass_error)$("#error2").text("Le due password non coincidono").show().fadeOut(3000); 
               
               
               return !error && !pass_error && !email_error; //ritorna true solo se non ci sono errori
            });
        </script>
