<?php
include 'Includes/header.php';
$success = 1;
$usernameErr = $passwordErr = "";
if(isset($_POST["submit"])){
	$Username = test_input($_POST["username"]);
	$Password = test_input($_POST["password"]);
	if(empty($Username)){
		$userErr = "请输入账号";
		$success = 0;
	}
	if(empty($Password)){
		$passwordErr = "请输入密码";
		$success = 0;
	}
	if($success){
		$permit = 1;
		$usernameResult = $passwordResult = $loggedResult = "";
		$usernameResult = mysql_query("select username from user where username='$Username'");
		$passwordResult = mysql_query("select password from user where username='$Username'");
		$loggedResult = mysql_query("select logged from user where username='$Username'");
		$Logged = mysql_result($loggedResult,0);
		if(!mysql_num_rows($usernameResult)){
			$usernameErr = "此账号不存在";
			$permit = 0;
		}
		else if(mysql_result($passwordResult,0) != $Password){
			$passwordErr = "密码错误，请重试";
			$permit = 0;
		}
		if($permit){
			echo "登录成功，将在 3 秒后跳转到首页。";
			setcookie("logged","");
			setcookie("logged", "$Logged", time()+3600*24);
			echo '<meta http-equiv="refresh" content="3;url=index.php">';
		}
	}
}
?>
<br/>
<br/>
	<div>
		<form action="login.php" method="post" class="qw">
			账号：<input type="text" name="username" value="<?php echo $_POST["username"]; ?>" size="30" maxlength="30">
			<span class="error"><?php echo $usernameErr; ?></span>
<br/>
<br/>
			密码：<input type="password" name="password" value="<?php echo $_POST["password"]; ?>" size="30" maxlength="30">
			<span class="error"><?php echo $passwordErr; ?></span>
<br/>
<br/>
			<input type="submit" name="submit" value="登录"></form></div>
