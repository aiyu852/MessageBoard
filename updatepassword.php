<?php 
include 'Includes/header.php';
$success = 1;
$oldpasswordErr = $newpasswordErr = "";
if(!$logged){
	echo "请登录，将跳转到登录页面。";
	echo '<meta http-equiv="refresh" content="0;url=login.php">';
    $success = 0;
}
else if($logged == "Guest"){
    echo '<span class="error">匿名用户无权限，将跳转到首页。</span>';
    echo '<meta http-equiv="refresh" content="0;url=index.php">';
	$success = 0;
}
else if(isset($_POST["submit"])){
	$Username = $logged;
	$Oldpassword = test_input($_POST["oldpassword"]);
	$Newpassword = test_input($_POST["newpassword"]);
	$Newlogged = base64_encode(base64_encode("$Username:$Newpassword"));
	if(empty($Oldpassword)){
		$oldpasswordErr = "请输入原密码";
		$success = 0;
	}
	if(empty($Newpassword)){
	    $newpasswordErr = "请输入新密码";
		$success = 0;
	}
	if($success){
		$permit = 1;
		$passwordResult = "";
		$passwordResult = mysql_query("select password from user where username='$Username'");
		if(mysql_result($passwordResult,0) != $Oldpassword){
			$oldpasswordErr = "原密码错误";
			$permit = 0;
		}
		if($permit){
			echo "修改成功，将在 3 秒后跳转到登录页面。";
			mysql_query("update user set password='$Newpassword',logged='$Newlogged' where username='$Username'");
			echo '<meta http-equiv="refresh" content="3;url=login.php">';
		}
	}
}
?>
<br/>
<br/>
	<div class="form">
		<form action="updatepassword.php" method="post">
			原密码：<input type="password" name="oldpassword" size="30" maxlength="30">
			<span class="error"><?php echo $oldpasswordErr; ?></span>
<br/>
<br/>
			新密码：<input type="password" name="newpassword" size="30" maxlength="30">
			<span class="error"><?php echo $newpasswordErr; ?></span>
<br/>
<br/>
			<input type="submit" name="submit" value="修改"></form></div>
