<?php
include 'Includes/header.php';
$loggedResult = mysql_query("select logged from user where username='Guest'");
$Logged = mysql_result($loggedResult,0);
setcookie("logged","");
setcookie("logged","$Logged",time()+3600*24);
echo '<meta http-equiv="refresh" content="0;url=index.php">';
?>
