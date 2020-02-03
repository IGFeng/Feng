<?php
//error_reporting(0);
include 'check.php';
include 'config.php';
include 'preparation.php';
if(isset($_GET['page']))$page=$_GET['page'];else $page=1;
$pageUrl="index.php?page=".$page;
$rs=$db->execute("SELECT * FROM sh_message where id=".$_GET['id']);
if($db->get_rows($rs)!=0)
{
	$rows=$db->fetch_array($rs);
    $db->free_result($rs);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>回复/编辑留言-<?php echo $suf_name?></title>
<link href="css.css" rel="stylesheet" type="text/css">
</head>
<script language=JavaScript>
function Validator(theForm)
{
  if (theForm.content.value == "")
  {
    alert("您不能将留言内容编辑为空！");
    theForm.content.focus();
    return (false);
  }
   return (true);
}
</script>
<body>
<div id="main">
<?php include 'head.php';?>
<div id="submit">
<?php if(empty($_POST['ac'])){?>


<form name="form1" method="post" action="<?php $_SERVER['PHP_SELF']?>" onSubmit="return Validator(this)">
<h2>
<img src="image/用户.png" /><?php echo $rows['username']?> <span style="color:#999;">于 <?php echo date("Y-m-d H:i",strtotime($rows["systime"]));?> 发表留言：</span>
</h2>　　 
       <textarea name="content" cols="70" rows="9" id="content"><?php echo $rows['content']; ?></textarea><br>
              
			  <span style="margin-left:80px;">管理员回复的内容：</span><br>
			  <textarea name="reply" cols="50" rows="6" id="reply_textarea"><?php echo $rows['reply']?></textarea><br>
			  
			  <input type="submit" style="margin-left:80px;margin-top:10px;" value="编辑/回复" />
              <input name="ac" type="hidden" id="ac" value="reply"> 
              <input name="id" type="hidden" id="id" value="<?php echo $_GET['id'];?>"> 
                              
</form>

<?php }else{?>

<div id="alertmsg">
<?php

			$id=$_POST['id'];
			$content=addslashes($_POST['content']);
			$reply=addslashes($_POST['reply']);
			$systime=date("Y-m-d H:i:s");
			$db->update("UPDATE sh_message set content='".$content."',reply='".$reply."',replytime='".$systime."' where id=".$id);
			echo "编辑/回复成功，请稍候……<br><a href=".$pageUrl.">如果浏览器没有自动返回，请点击此处返回</a>";
			echo "<meta http-equiv=\"refresh\" content=\"2; url=".$pageUrl."\">";
?>
</div>
<?php }?>
</div></div>
</body>
</html>