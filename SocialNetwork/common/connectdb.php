<?php
require_once("MDB2.php");


function myconnect(){

$db = & MDB2::connect("mysql://root:@"."localhost/disibook");

	if (MDB2::isError($db)) {
	
	 die($db->getMessage . ', ' . $db->getDebugInfo());
	 print('errore connessione db');
	 }
	 

	 return $db;	 
	 

}
?>