<?php 
session_start();

require_once("common/utility.php");


unset_session_var();

redirect('index.php');

?>
