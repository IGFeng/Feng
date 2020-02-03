<?php
include 'check.php';
include 'preparation.php';
include 'config.php';
$pageUrl="index.php?page=".$_GET['page'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>管理留言-<?php echo $suf_name;?></title>
</head>
<body>
  <div id="main">
  <?php include 'head.php';?>
  <div id="list">
  <div id="alerting">
    <?php if(!empty($_GET['ac'])){
        $id=$_GET['id'];
        $ac=$_GET['ac'];
        if($ac=='delete'){
            $db->delete("DELETE FROM sh_message where id=".$id);
            echo "留言已删除";
        }
        else if($ac=='settop'){
            $db->update("UPDATE sh_message SET settop=1 where id=".$id);
            echo "留言已置顶";
        }
        else if($ac=='unsettop'){
            $db->update("UPDATE sh_message set settop=0 where id=".$id);
            echo "已取消置顶";
        }
        else if($ac=='setshow'){
            $db->update("UPDATE sh_message set ifshow=1 where id=".$id);
            echo "留言已显示";
        }
        else if($ac=='unshow'){
            $db->update("UPDATE sh_message set ifshow=0 where id=".$id);
            echo "留言已隐藏";
        }
        else if($ac=='logout'){
            session_unset('admin_pass');
            session_destroy();
            echo "您已退出";
        }
        else{
            echo "无此项操作";
        }
        echo "<br><a href=".$pageUrl.">如果您的浏览器没有自动返回，请点击此处手动返回</a>";
        echo "<meta http-equiv=\"refresh\" content=\"3;url=".$pageUrl."\">";
    }?>
  </div>
  </div>
  </div>  
</body>
</html>