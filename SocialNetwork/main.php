<?php
session_start();
    
if(isset($_SESSION['logged']) && $_SESSION['logged']) //se sono loggato
{
    echo "<div id=\"main2\">";
    
    if($_SESSION['view']=='welcome') //visualizziamo il contenuto del main in base al settaggio della variabile di sessione view
    	include('welcome.php');
    else if($_SESSION['view']=='edit_profile')
        include('edit_profile.php');
    else if($_SESSION['view']=='friends')
        include('friends.php');
    else if($_SESSION['view']=='friends_graph')
        include('friends_graph.php');
    else if($_SESSION['view']=='all_friends')
        include('all_friends.php');
    else if($_SESSION['view']=='all_neighbor')
        include('all_neighbor.php');
    else if($_SESSION['view']=='notifications_in')
        include('notifications_in.php');
    else if($_SESSION['view']=='notifications_out')
        include('notifications_out.php');
    else if($_SESSION['view']=='alert')
        include('alert.php');
    else if($_SESSION['view']=='search_result')
         include("search_result.php");
    else if($_SESSION['view']=='admin')
         include("admin.php");    
        
        
    else{
        
        include('show_profile.php');
        
    }
    echo "</div>";
}
else{
    echo "<div id=\"main\">";
    include('reg.php');
    echo "</div>";
}
    
?>

    
  


