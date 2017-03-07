<?php
include 'Includes/header.php';
$success = 1;
$usernameErr = $passwordErr = $emailErr = $blogErr = $genderErr = "";
$check1 = $check2 = "";
if(isset($_POST["submit"])){
	$Username = test_input($_POST["username"]);
	$Password = test_input($_POST["password"]);
	$Logged = base64_encode(base64_encode("$Username:$Password"));
	if(empty($Username)){
		$usernameErr = "请输入账号";
		$success = 0;
	}
	else if(!preg_match("/^[a-zA-Z0-9]+$/",$Username)){
		$usernameErr = "只允许字母和数字";
		$success = 0;
	}
	if(empty($Password)){
		$passwordErr = "请输入密码";
		$success = 0;
	}
	if($success){
		$permit = 1;
		$UsernameResult = mysql_query("select username from user where user='$Username'");
		if(mysql_num_rows($UsernameResult)){
			$usernameErr = "账号已被注册";
			$permit = 0;
		}
		if($permit){
			mysql_query("insert into user (username,password,email,gender,logged) values ('$Username','$Password','$Logged')");
			echo "注册成功，将在 3 秒后跳转到登录页面。";
			echo '<meta http-equiv="refresh" content="100;url=login.php">';
		}
	}
}
?>
<br/>
<br/>
	<div>
		<form action="signup.php" method="post" class="qw">
			账号：<input type="text" name="username" value="<?php echo $_POST["username"]; ?>" size="30" maxlength="30">
			<span class="error"><?php echo $usernameErr; ?></span>
<br/>
<br/>
			密码：<input type="password" name="password" value="<?php echo $_POST["password"]; ?>" size="30" maxlength="30">
			<span class="error"><?php echo $passwordErr; ?></span>
<br/>
<br/>
			<input type="submit" name="submit" value="注册"></form></div>
