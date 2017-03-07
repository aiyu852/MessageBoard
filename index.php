<?php
include 'Includes/header.php';
$MessageResult = mysql_query("select * from message order by messageid desc");
while($row == mysql_fetch_array($MessageResult)){
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
<br/>
';
}
echo'
	<div class="bottom">
		如有问题请联系e-mail：1205105078@qq.com		
			</div>
';
?>
