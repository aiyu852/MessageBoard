<?php
include 'Includes/header.php';
$success = 1;
$searched = 0;
$textErr = "";
if(isset($_POST["submit"])){
	$Text = test_input($_POST["text"]);
	if(empty($Text)){
		$textErr = "请输入查询内容";
		$success = 0;
	}
	if($_POST["submit"] == "在用户中查询"){
		$textResult = mysql_query("select * from message where username='$Text' and anonymous='2' order by messageid desc");
	}
	else if($_POST["submit"] == "在标题中查询"){
		$textResult = mysql_query("select * from message where title like '%$Text%' order by messageid desc");	
	}
	else if($_POST["submit"] == "在留言中查询"){
		$textResult = mysql_query("select * from message where message like '%$Text%' order by messageid desc");
	}
	if(!mysql_num_rows($textResult)){
		$textErr = "无查询结果";
		$success = 0;
	}
}
?>
<br/>
<br/>
	<div class="form">
		<form action="searchmessage.php" method="post">
			<input type="text" name="text" value="<?php echo $_POST["text"]; ?>" size="30" maxlength="30">
			<span class="error"><?php echo $textErr; ?></span>
<br/>
<br/>
			<input type="submit" name="submit" value="在用户中查询">
			<input type="submit" name="submit" value="在标题中查询">
			<input type="submit" name="submit" value="在留言中查询"></form></div>
<?php
if($success){
	while($row = mysql_fetch_array($textResult)){
		$Function = "";
		$Messagename = $row['username'];
		$Messageid = $row['messageid'];
		if($row['anonymous'] == "1"){
			$Messagename = "用户匿名发表";
		}
		if($logged){
			$Function = '
<form action="reply.php" method="post" class="form-left">
	<input type="hidden" name="messageid" value="'.$Messageid.'">
	<input type="submit" name="submit" value="回复">
</form>';					
		}
		if(($logged == $row['username']&&$logged != "Guest")||($logged == "admin")){
			$Function = $Function.'
<form action="updatemessage.php" method="post" class="form-left">
	<input type="hidden" name="messageid" value="'.$Messageid.'">
	<input type="hidden" name="title" value="'.$row['title'].'">
	<input type="hidden" name="message" value="'.$row['message'].'">
	<input type="hidden" name="anonymous" value="'.$row['anonymous'].'">
	<input type="submit" name="submit" value="修改">
</form>
<form action="deletemessage.php" method="post" class="form-left">
	<input type="hidden" name="messageid" value="'.$Messageid.'">
	<input type="submit" name="submit" value="删除">
</form>';					
		}
		echo '	
<br/>
<br/>	
	<table class="table">
		<tr>
			<td class="table-a">'.$Messagename.'<br/>'.$row['time'].'</td>
			<td class="table-b">'.$row['title'].'</td>
			<td class="table-c">'.$Function.'</td>
		</tr>
		<tr>
			<td colspan="3" class="table-d">'.$row['message'].'</td>
		</tr>';
		$replyResult = mysql_query("select * from reply where replyto='$Messageid' order by replyid desc");
		while($rowrow = mysql_fetch_array($replyResult)){
			$Replyname = $rowrow['username'];
			if($rowrow['anonymous'] == "1"){
				$Replyname = "用户匿名发表";
			}
			echo '
		<tr>
			<td class="table-e">'.$Replyname.'<br/>'.$rowrow['time'].'</td>
			<td colspan="2" class="table-f">'.$rowrow['reply'].'</td>
		</tr>';
		}
		echo '
	</table>
<br/>';
	}
}
?>
