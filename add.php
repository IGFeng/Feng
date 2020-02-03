<?php
error_reporting(E_ALL^E_WARNING);
error_reporting(E_ALL&~E_NOTICE);
session_start();
include 'config.php';
include 'preparation.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>签写留言-<?php echo $suf_name?></title>
    <script language="javascript" type="text/javascript" src="check.js"></script>
    <link href="css.css" rel="stylesheet" type="text/css">
</head>
<body onload="i=0">
<div id="main">
<?php include 'head.php';?>
<div id="submit">
<?php if(isset($_SESSION['timer'])&&time()-$_SESSION['timer']<$timejg){?>
<div id="alertmsg">
对不起，您不是刚留言过吗?请<?php echo $timejg;?>秒后再留言......您还需等待：<?php echo abs($timejg-(time()-$_SESSION['timer']));?>秒<br>
</div>
<?php 
echo "<meta http-equiv=\"refresh\" content=\"3;url=index.php\">";
}else{if(empty($_POST['ac'])){?>
<form name="form1"method="post" action="<?php echo $_SERVER['PHP_SELF']?>" onSubmit="return validator(this)">
<p><img src=""><img src="" ></p><br>
<label for="user">昵称:</label><input type="text" id="username" name="username" value=""><br>
<label for="email">Email:</label><input type="text" id="email" name="email" value=""><br>
<label for="comment">内容:</label><textarea id="content" name="content" cols="70" rows="9"></textarea> <br>
<label for="comment"></label><span>提交之前请先按CTRL+C保存您的留言内容，以免程序出错而丢失!留言内容最少五个字符</span><br>
<label for="email">悄悄话</label>
<input name="ifqqh" type="checkbox" id="ifqqh" value="1"><span>当选中时，此留言仅有管理员可见</span><br>
<label for="unum">验证码</label><input name="unum" type="text" id="unum" size="10"><img src="randnum.php?id=-1" title="点击刷新" style="cursor:pointer" onclick=eval(this.src="randnum.php?id='+i+++'")><br>
<input type="submit" id="sbutton" value="确 定"><br><input name="ac" type="hidden" id="ac" value="add">
</form>
<?php }else{?>
<div id="alertmsg">
<?php if($_POST['unum']==$_SESSION['randvalid']){
    $username=$_POST['username'];
    $content=$_POST['content'];
    $userip=$_SERVER['REMOTE_ADDR'];
    $ifqqh=$_POST['ifqqh'];
    if(empty($ifqqh))$ifqqh=0;
    $systime=date("Y-m-d H:i:s");
    if(!empty($content)||(!empty($username))){
        $ifshow="";
        if(!empty($content)){
            $content=str_replace("　","",$content);
        }
         if($ifauditing==1){$ifshow=0;}else{$ifshow=1;}
         $sql="INSERT INTO sh_message (`username`,`content`,`userip`,`systime`,`ifshow`,`ifqqh`)values('".$username."','".$content."','".$userip."','".$systime."',".$ifshow.",".$ifqqh.")";
         if(($db->insert($sql))>0){
             $_SESSION['timer']=time();
             echo "留言成功,正在返回请稍候...<br><a href=index.php>您可以点此手动返回</a>";
             echo "<meta http-equiv=\"refresh\" content=\"3;url=index.php\">";
         }else{
            echo "留言失败！信息中可能含有敏感字符或不利于程序运行的特殊字符……";
            echo "<meta http-equiv=\"refresh\" content=\"5; url=".$_SERVER['PHP_SELF']."\">";
         }
         }
         else{
            echo "昵称和留言内容不能空，请重填！正在返回……<br><a href=index.php>您可以点此手动返回</a>";
            echo "<meta http-equiv=\"refresh\" content=\"3; url=".$_SERVER["HTTP_REFERER"]."\">";
         }
    }
    else{
        echo "<script language=\"javascript\">alert('对不起，验证码不正确，请重新输入……');history.back()</script>";
    }
?>
</div>
<?php }}?>
</div>
</div>
    
</body>
</html>