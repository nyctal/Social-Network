<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


</head>

<?php 
$utente=$_SESSION['email'];
echo <<<VIEWIMAGE

<body>

<div id="left_menu_upperside">

<p><img src="user/$utente/avatar.jpg"  alt="Avatar" name="img_avatar" width=170px height=170px id="img_avatar" />  </p>
  
    
<a href="index.php?view=edit_profile" accesskey="1"> <img src="images/menu buttons/edit.png"   onkeydown="linka(event,'edit_profile')" onmouseover="this.src='images/menu buttons/edit_over.png'" onmouseout="this.src='images/menu buttons/edit.png'" onfocusin="this.src='images/menu buttons/edit_over.png'" onfocusout="this.src='images/menu buttons/edit.png'" " alt="edit_profile" name="Edit Profile" width="180" height="46" border="0" class="ponted_links" id="edit_profile" tabindex="180"/></a>


<a href="index.php?view=friends" accesskey="2"><img src="images/menu buttons/amici.png"   onkeydown="linka(event,'friends')" onmouseover="this.src='images/menu buttons/amici_over.png'" onmouseout="this.src='images/menu buttons/amici.png'" onfocusin="this.src='images/menu buttons/amici_over.png'" onfocusout="this.src='images/menu buttons/amici.png'"  alt="Amici" name="Amici" width="180" height="46" class="ponted_links" border="0" id="amici" tabindex="190"/></a>
     

<a href="index.php?view=friends_graph" accesskey="3"><img src="images/menu buttons/rete.png"   onkeydown="linka(event,'friends_graph')" onmouseover="this.src='images/menu buttons/rete_over.png'" onmouseout="this.src='images/menu buttons/rete.png'" onfocusin="this.src='images/menu buttons/rete_over.png'" onfocusout="this.src='images/menu buttons/rete.png'" alt="Rete" name="Rete" width="180" height="46" class="ponted_links" border="0" id="rete" tabindex="200"/></a>

VIEWIMAGE;

if($_SESSION['admin']==1){ //se sei admin aggiunge il tasto admin
?>
    <a href="index.php?view=admin" accesskey="4"  onkeydown="linka(event,'admin')">
    <img src="images/menu buttons/admin.png" onmouseover="this.src='images/menu buttons/admin_over.png'" onmouseout="this.src='images/menu buttons/admin.png'" onfocusin="this.src='images/menu buttons/admin_over.png'" onfocusout="this.src='images/menu buttons/admin.png'" alt="Admin " name="admin" width="180" height="46" border="0" class="ponted_links" id="admin" tabindex="210"/>
    </a>
<?php } ?>
    
</p>
</div>





</body>
</html>
