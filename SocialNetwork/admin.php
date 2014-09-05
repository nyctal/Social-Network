<?php 
session_start();
$email=$_SESSION['email'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


</head>

<img src="images/tabs/tutti_utenti_tab.png" width="200" height="40" alt="Tutti Gli Utenti" />

<?php

if(isset($_SESSION['logged']) && $_SESSION['logged'] && $_SESSION['admin']){
    
    $db=myconnect();
    
    $query = "SELECT name,surname,email,id,banned FROM utenti WHERE email<>\"$email\";";
	
    
    $result = $db->Query($query);
    

	if (MDB2::isError($result)){ print_error_big(); }
        else{
            while($row = $result->fetchRow())
                print_users_bannable($row[0],$row[1],$row[2], $row[3],$row[4]);
            
            
        }
    
}

else include('access_denied.php');

?>

</html>