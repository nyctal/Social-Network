<?php
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


</head>

<body>
<div id="leftmenu">

<?php
if(isset($_SESSION['logged']) && $_SESSION['logged']){ //se sono loggato includo la parte superiore sinistra del menu
    include('left_menu_upperside.php');
}
?>
</div>   

</body>
    
</html>