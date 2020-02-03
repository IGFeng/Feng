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
    <title>管理登陆-<?php echo $suf_name;?></title>
    <link href="css.css" rel="stylesheet" type="text/css">
    <script language=javascript>
    function validator(theForm) {
        if(theForm.admin_user.value==""){
            alert("请输入管理员账号!");
            theForm.admin_user.focus();
            return (false);
        }
        if(theForm.admin_pass.value==""){
            alert("请输入管理员密码!");
            theForm.admin_pass.focus();
            return (false);
        }
        if(theForm.unum.value==""){
            alert("请您输入验证码!");
            theForm.unum.focus();
            return (false);
        }
        return (true);
    }
    </script>
</head>
<body onload="i=0;document.getElementByName('unum')[0].value=''">
<div id="main">
<?php include 'head.php';?>
<div id="submit">
<?php if(empty($_POST['action'])){?>
<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" onSubmit="return validator(this)">
<p><img src=""><img src=""></p><br>
<div id="submit_div">
<label for="admin_user"> 管理员账号</label><input name="admin_user" type="text" id="admin_user"><br>
<label for="admin_pass">管理员密码</label><input name="admin_pass" type="password" id="admin_pass"><br>
<label for="unum">登陆验证码</label>
<input name="unum" type="text" id="unum" size="10">*<img src="randnum.php?id=-1" title="点击刷新" style="cursor:pointer" onclick=eval(this.src="randnum.php?id='+i+++'") ><br>
<input type="submit" id="sbutton"value="确 定"><br>
<input name="action" type="hidden" value="add">
</div>
</form>
<?php }else{?>
<div id="alertmsg">
<?php if($_POST['unum']==$_SESSION['randvalid']){
    $admin_user=$_POST['admin_user'];
    $admin_pass=$_POST['admin_pass'];
           if($admin_user=="sherman"){
               if($admin_pass=="Fdy135246"){
            $_SESSION['admin_pass']=$admin_pass;
            echo "成功登陆，请稍候...<br><a href=".$pageUrl.">如果浏览器没有自动返回，请点击此处返回</a>";
            echo "<meta http-equiv=\"refresh\" content=\"2; url=index.php\">";
        }else{
            echo "<script language=\"javascript\">alert('密码不正确!');history.go(-1)</script>";

        }
    }else{
        echo "<script language=\"javascript\">alert('管理账号不正确!');history.go(-1)</script>";
    }
}else{
    echo "<script language=\"javascript\">alert('验证码不正确，请重新输入……');history.go(-1)</script>";
}
?>
</div>
<?php }?>
</div>
</div>
    
</body>
</html>