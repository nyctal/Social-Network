<?php
session_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script>
            visibile1=false;
            visibile2=false;
            
            $(function() {

                    // set effect from select menu value
                    $( "#Amici_Suggeriti" ).click(function() {
                            if(!visibile1)
                                $( "#right_menu_content_up" ).slideDown(1000);
                            else if(visibile1)
                                $( "#right_menu_content_up" ).slideUp(1000);

                            visibile1=!visibile1;
                            return false;
                    });
            });
        
        $( "#right_menu_content_up" ).hide();
        
        $(function() {

                    // set effect from select menu value
                    $( "#Vicini_Suggeriti" ).click(function() {
                            if(!visibile2)
                                $( "#right_menu_content_down" ).slideDown(1000);
                            else if(visibile2)
                                $( "#right_menu_content_down" ).slideUp(1000);

                            visibile2=!visibile2;
                            return false;
                    });
            });
        
         $(document).ready( function() {
                 $( "#right_menu_content_down" ).hide();
                 $( "#right_menu_content_up" ).hide();
                
            });
         
       
</script>

</head>
<body>
<?php
session_start();
if(isset($_SESSION['logged']) && $_SESSION['logged']){

include('right_menu_upper_header.php');
include('content_right_up.php');
include('right_menu_down_header.php');
include('content_right_down.php');
  
}
?>

</body>
</html>