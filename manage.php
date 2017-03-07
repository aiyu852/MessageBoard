<?php
include 'Includes/header.php';
if(!$logged){
	echo "请登录，将跳转到登录页面。";
    echo '<meta http-equiv="refresh" content="0;url=login.php">';
}
if($logged != "Guest"&&$logged != "admin"){
	$userResult = mysql_query("select * from user where username='$logged'");
	$row = mysql_fetch_array($userResult);
	$Userid = $row["userid"];
	$Username = $row["username"];
	$Gender = $row["gender"];
	$QQ = $row["qq"];
	$Email = $row["email"];
	$Blog = $row["blog"];
	if(empty($Blog)){
		$Blog = "none";
	}
	if(empty($QQ)){
		$QQ = "none";
	}
	if($Gender == 1){
		$Gender = "Man";
	}
	else{
		$Gender = "Woman";
	}
	echo '		
<br/>	
<br/>
<div class="information">
	<div class="information-title">个人信息：</div>
<br/>
	<table>
		<tr>
			<td width="200px">UserID:</td>
			<td>'.$Userid.'</td>
		</tr>
		<tr>
			<td>UserName:</td>	
			<td>'.$Username.'</td>
		</tr>
	</table>
</div>';
}
echo '
<br/>
<br/>
<ul class="list-ul">
	<br/>
	<li class="list-li">
		<a href="message.php" class="list-a">新的留言</a></li><br/>
	<li class="list-li">
		<a href="searchmessage.php" class="list-a">留言查询</a></li><br/>
	<li class="list-li">
		<a href="searchuser.php" class="list-a">用户查询</a></li><br/>';
if($logged == "Guest"){
	echo '</ul>';
}
else{
	echo '
	<li class="list-li">
		<a href="setting.php" class="list-a">修改信息</a></li><br/>
	<li class="list-li">
		<a href="updatepassword.php" class="list-a">修改密码</a></li><br/>
</ul>';
}

include 'Includes/footer.php';
?>
