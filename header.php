<?php
include 'conn.php';
function test_input($data){
	$data = str_replace("'","\"","$data");
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
$logged = "";
if(isset($_COOKIE["logged"])){
	$logged = $_COOKIE["logged"];
	$usernameResult = mysql_query("select username from user where logged='$logged'");
	if(!mysql_num_rows($usernameResult)){
		$logged = "";
		setcookie("logged","");
	}
	else{
		$logged = mysql_result($usernameResult,0);
	}
}
echo '
<!DOCTYPE html>
<html>
<head>	
	<title >
        MessageBoard
    </title>
	<link rel="stylesheet" type="text/css" href="Styles/mystyle.css">
</head>
<body>

		<div class="menu">';
if($logged){
    echo $logged." , welcome! ";
	echo '
			<button type="button" onclick="window.location.href=(\'index.php\')" class="button">首页</button>';
	if($_SERVER['PHP_SELF'] != '/discuss/manage.php'){
		echo '
			<button type="button" onclick="window.location.href=(\'manage.php\')" class="button">管理</button>';
	}
	echo '
			<button type="button" onclick="window.location.href=(\'logout.php\')" class="button">注销</button>';
}
else{
	echo '
			<button type="button" onclick="window.location.href=(\'index.php\')" class="button">首页</button>';
    if($_SERVER['PHP_SELF'] != '/discuss/login.php'){
		echo '
			<button type="button" onclick="window.location.href=(\'login.php\')" class="button">登录</button>';
	}
    if($_SERVER['PHP_SELF'] != '/discuss/signup.php'){
		echo '
			<button type="button" onclick="window.location.href=(\'signup.php\')" class="button">注册</button>';
	}
	echo '
			<button type="button" onclick="window.location.href=(\'anonymous.php\')" class="button">匿名</button>';
}
echo '
		</div>
		<br/>';
echo'			<table class="main">
			<tr>
				<td align="right"><b><font color="#444444" size="15">
					留言板</font></b><hr />
					<b><a href="index.php" class="home">主页</a></b>
				</td>
			</tr>
			</table>   
	'
?>
