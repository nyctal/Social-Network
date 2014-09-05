<?php

require_once("common/utility.php");
$date=$_GET['date'];

?>
<head>
<link href="css/master.css" rel="stylesheet" type="text/css" />
        <body>
        <center><h1><br><br>SEI STATO BANNATO </h1></center>;
        <?php printf("<center><h3>fino al %s</h3></center>",$date)?>
        <center><h4>...tra pochi secondi verrai reindirizzato alla homepage...</h4></center>;
        </body>
        </head>
        
<?php	redirect('index.php','3');?>
