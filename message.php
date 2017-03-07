<?php
include 'Includes/header.php';
$success = 1;
$titleErr = $messageErr = $anonymousErr = "";
$check1 = $check2 = "";
if(!$logged){
	echo '<span class="error">请登录，将跳转到登录页面。</span>';
	echo '<meta http-equiv="refresh" content="0;url=login.php">';
	$success = 0;
}
else if(isset($_POST["submit"])){
	$Username = $logged;
	$Title = test_input($_POST["title"]);
	$Message = test_input($_POST["message"]);
	date_default_timezone_set("Asia/Shanghai");
	$Time = date("Y-m-d H:i:s");
	$Anonymous = $_POST["anonymous"];
	if(empty($Title)){
		$titleErr = "请输入标题";
		$success = 0;
	}
	if(empty($Message)){
		$messageErr = "请输入内容";
		$success = 0;
	}
	if(empty($Anonymous)){
		$anonymousErr = "请选择是否匿名";
		$success = 0;
	}
	else{
		if($Anonymous == "1"){
			$check1 = "checked";
			$check2 = "";
		}
		else if($Anonymous == 2){
			$check2 = "checked";
			$check1 = "";
		}
	}
	if($success){
		echo "发表成功，将在 3 秒后跳转到首页。";
		mysql_query("insert into message (username,title,message,time,anonymous) values ('$Username','$Title','$Message','$Time','$Anonymous')");
		echo '<meta http-equiv="refresh" content="3;url=index.php">';
	}
}
?>
<br/>
<br/>
	<div class="form">
		<form action="message.php" method="post">
			标题：<input type="text" name="title" value="<?php echo $_POST["title"]; ?>" size="50" maxlength="50">
			<span class="error"><?php echo $titleErr; ?></span>
<br/>
<br/>
			内容：<textarea name="message" rows="5" cols="52"><?php echo $_POST["message"]; ?></textarea>
			<span class="error"><?php echo $messageErr; ?></span>
<?php
if($logged == "Guest"){
	echo '
			<input type="hidden" name="anonymous" value="2">';
}
else{
	echo '
<br/>
<br/>
			匿名：<input type="radio" name="anonymous" value="1" '.$check1.'>是
			      <input type="radio" name="anonymous" value="2" '.$check2.'>否
			<span class="error">'.$anonymousErr.'</span>';
}
?>
<br/>		
<br/>
			<input type="submit" name="submit" value="发表"></form></div>
