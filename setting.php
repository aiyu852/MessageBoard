<?php 
include 'Includes/header.php';
$success = 1;
$qqErr = $emailErr = $blogErr = $genderErr = $passwordErr = "";
$check1 = $check2 = "";
$userResult = mysql_query("select * from user where username='$logged'");
$row = mysql_fetch_array($userResult);
$Username = $row['username'];
$QQ = $row['qq'];
$Email = $row['email'];
$Blog = $row['blog'];
$Gender = $row['gender'];
if($Gender == 1){
	$check1 = "checked";
	$check2 = "";
}
else if($Gender == 2){
	$check2 = "checked";
	$check1 = "";
}
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
	$Blog = test_input($_POST["blog"]);
	$Password = $_POST["password"];
	if(empty($Blog)){
		$blogErr = "请输入新博客";
		$success = 0;
	}
	if(empty($Password)){
		$passwordErr = "请输入密码";
		$success = 0;
	}
	if($success){
		$permit = 1;
		$passwordResult = "";
		$passwordResult = mysql_query("select password from user where username='$Username'");
		if(mysql_result($passwordResult,0) != $Password){
			$passwordErr = "密码错误";
			$permit = 0;
		}
		if($permit){
			echo "修改成功，将在 3 秒后跳转到首页。";
			mysql_query("update user set qq='$QQ',email='$Email',blog='$Blog',gender='$Gender' where username='$Username'");
			echo '<meta http-equiv="refresh" content="3;url=index.php">';
		}
	}
}
?>
<br/>
<br/>
	<div class="form">
		<form action="setting.php" method="post">
			Q Q：<input type="text" name="qq" value="<?php echo $QQ; ?>" size="30" maxlength="30">
			<span class="error"><?php echo $qqErr; ?></span>
<br/>
<br/>
			邮箱：<input type="text" name="email" value="<?php echo $Email; ?>" size="30" maxlength="30">
			<span class="error"><?php echo $emailErr; ?></span>
<br/>
<br/>
			博客：<input type="text" name="blog" value="<?php echo $Blog; ?>" size="30" maxlength="30">
			<span class="error"><?php echo $blogErr; ?></span>
<br/>
<br/>
			性别：<input type="radio" name="gender" value="1" <?php echo $check1; ?>>男性
				  <input type="radio" name="gender" value="2" <?php echo $check2; ?>>女性
			<span class="error"><?php echo $genderErr; ?></span>
<br/>
<br/>
			密码：<input type="password" name="password" size="30" maxlength="30">
			<span class="error"><?php echo $passwordErr; ?></span>
<br/>
<br/>
			<input type="submit" name="submit" value="确认修改"></form></div>
