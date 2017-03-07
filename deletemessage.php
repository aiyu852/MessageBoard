<?php
include 'Includes/header.php';
if(!$logged){
	echo "请登录，将跳转到登录页面。";
	echo '<meta http-equiv="refresh" content="0;url=login.php">';
}
else if($logged == "Guest"){
	echo '<span class="error">匿名用户无权限，将跳转到首页。</span>';
	echo '<meta http-equiv="refresh" content="0;url=index.php">';
}
else if(isset($_POST["submit"])&&$_POST["submit"] != "删除"){
	if($_POST["submit"] == "确认"){
		$Messageid = $_POST["messageid"];
		mysql_query("delete from message where messageid='$Messageid'");
		mysql_query("delete from reply where replyto='$Messageid'");
		echo '<meta http-equiv="refresh" content="0;url=index.php">';
	}
	else if($_POST["submit"] == "取消"){
		echo '<meta http-equiv="refresh" content="0;url=index.php">';
	}
}
?>
<br/>
<br/>
<div class="form">
	<span class="error">确认删除？</span>
	<br/>
	<br/>
		<form action="deletemessage.php" method="post">
			<input type="hidden" name="messageid" value="<?php echo $_POST["messageid"]; ?>">
			<input type="submit" name="submit" value="确认">
			<input type="submit" name="submit" value="取消"></form></div>
