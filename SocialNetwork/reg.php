<html>
    <head>
        
        
<form id="Registration" name="Registration" method="post" action="register_data.php" >
    <fieldset id="reg"><legend id="reg_leg">Registrazione</legend>
      <fieldset class="reg_std">
        <legend class="inside_leg">Informazioni su di te</legend>
        <p>
          <label id="label_name" for="name">Name</label>
          <input id="name" type="text" name="name" tabindex="230" />
        </p>
        <p>
          <label for="surname">Surname</label>
          <input id="surname" type="text" name="surname"  tabindex="240" />
        </p>
        <p>
          <label for="birthplace">Birthplace</label>
          <input id="birthplace" type="text" name="birthplace"  tabindex="250" />
        </p>
	<span id="error"  class="error"></span>
      </fieldset>
      <fieldset class="reg_std"><legend class="inside_leg">Il tuo profilo</legend>
        <p>
          <label for="email">E-mail</label>
          <input id="email" type="text" name="email"  tabindex="260" />
        </p>
        <p>
          <label for="password">Password</label>
          <input id="password" type="password" name="password"  tabindex="270" />
        </p>
        <p>
          <label for="confirm_password">Confirm password</label>
          <input id="confirm_password" type="password" name="confirm_password"  tabindex="280" />
        </p>
	<div id="error3"  class="error"></div><div id="error2"  class="error"></div>
      </fieldset>
<?php 
        if( isset($_SESSION['all_set']) && !$_SESSION['all_set'])
            echo "Inserire i dati obbligatori<br>";
              
        if( isset($_SESSION['email_ok']) && !$_SESSION['email_ok'])           
            echo "La mail inserita non è valida<br>";
        
        if(isset($_SESSION['pass_ok']) && !$_SESSION['pass_ok'])           
            echo "le due password inserite non coincidono<br>";
        
?>
        
        <input name="Register" type="submit" value="Register" id="Register"  tabindex="290" />
    </fieldset>
    </form>
    

    <script>
            $("#name").click(function()             {  $("#name").removeClass("h_lighted");       });
            $("#surname").click(function()          {  $("#surname").removeClass("h_lighted");       });
            $("#email").click(function()            {  $("#email").removeClass("h_lighted");       });
            $("#password").click(function()         {  $("#password").removeClass("h_lighted");       });
            $("#confirm_password").click(function() {  $("#confirm_password").removeClass("h_lighted");       });
            $("#bithplace").click(function()        {  $("#birthplace").removeClass("h_lighted");       });
            
            $("#Registration").submit(function() {
               var error=false;
               var pass_error=false;
               var email_error=false;
               
               if ($("#confirm_password").val()==""){
                    $("#confirm_password").addClass("h_lighted");
                    $("#confirm_password").focus();
                    error=true;
               }
               if ($("#password").val()==""){
                    $("#password").addClass("h_lighted");
                    $("#password").focus();
                    error=true;
               }
               if ($("#email").val()==""){
                    $("#email").addClass("h_lighted");
                    $("#email").focus();
                    error=true;
		    email_error=true;
               }
               else if(!controllomail($("#email").val())){
                   $("#email").addClass("h_lighted");
                   $("#email").focus();
                   email_error=true;
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
                              
               if ($("#password").val()!=$("#confirm_password").val()){
                   $("#password").addClass("h_lighted");
                   $("#password").focus();
                   $("#confirm_password").addClass("h_lighted");
                   pass_error=true;
               
                }
                
               if(error)$("#error").text("Inserire i campi obbligatori").show().fadeOut(3000); 
               if(pass_error)$("#error2").text("-Le due password non coincidono").show().fadeOut(3000); 
               if(email_error)$("#error3").text("-L'email inserita non è valida").show().fadeOut(3000); 
               
               return !error && !pass_error && !email_error;
            });
        </script>

    </head>
</html>
