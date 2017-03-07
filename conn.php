<?php
$con = mysql_connect("localhost","","");
if(!$con){
	die('Could not connect: '.mysql_error());
}
mysql_select_db("bbs",$con);
?>
