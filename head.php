<?php 
error_reporting(0);
?>
<div id="top"> 
<!--logo-->
<div id="logoarea">
<a href="index.php"><img src="image/留言板.png" alt="">留言板</a></div>
<!--菜单-->
<div id="menu">
<ul>
<li><a href="index.php"><img src="image/浏览.png" ><br>浏览留言</a></li>
<li><a href="add.php"><img src="image/写.png"><br>签写留言</a></li>
<?php 
if(empty($_SESSION['admin_pass'])){?>
<li><a href="admin_login.php"><img src="image/基础 管 理 .png"><br>管理留言</a></li>
<?php } else{?>
<li><a href="javascript:if(confirm('您确定要退出吗')) location='admin_action.php?ac=logout'"><img src="image/退出.png"><br>退出管理</a></li>
<?php }?>
<!--<?php if(!empty($_SESSION['admin_pass'])){?>-->
<!--<li><a href="admin_set.php"><img src="设 置.png"><br>系统设置</a></li>-->
<!--<?php }?>-->
<li><a href="<?php echo $index_url?>"></a></li>
</ul>
</div>
</div>