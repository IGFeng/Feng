<?php
error_reporting(E_ALL^E_WARNING);
error_reporting(E_ALL&~E_NOTICE);
session_start();
include 'config.php';include 'preparation.php';include 'page.php';
$pager=new Page();
$page=$_GET['page'];
if(empty($page))
$page=1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>浏览留言-<?php echo $suf_name?></title>
    <script language="JavaScript" type="text/javascript" src="check.js"></script>
    <link href="css.css" rel="stylesheet" type="text/css">
</head>
<body onload="i=0"><!--在页面全部加载完成后运行一段脚本-->
<div id="main">
    <?php include 'head.php';?>
    <div id="list">
    <div id="listmain">
        <?php
        $sql="SELECT * FROM sh_message ORDER BY settop desc ,id desc";
        $result_=$db->execute($sql);
        $total=$db->get_rows($result_);//直接取出记录集行数供分页用
        if($total!=0)//判断记录是否为空
        {
            $pager->pagedate($page_,$total,"?page");
            $rs=$db->execute($sql." limit $pager->offset,$pager->pagesize");
            while($rows=$db->fetch_array($rs)){
                ?>
                <h2>
                <span class="leftarea">
                    <img src="image/用户.png">
                  <?php echo $rows['username'];?>
                    <span style="color:red;font-family:宋体;">于<?php echo date("Y-m-d H:i",strtotime($rows['systime']));?>发表留言:</span><!--注明留言发表的时间-->
                    <?php if (date("Y-m-d",strtotime($rows['systime']))==date("Y-m-d")) echo '<img src="image/新.png">';?><!--此条为新的留言-->
                    <?php if($rows['settop']!=0) echo '<img src="image/已置顶.png" alt="已置顶" title="已置顶">';?>
                </span>
                <span class="midarea">
                    <?php if(!empty($_SESSION['admin_pass'])){
                        if($ifauditing==1){
                            if($rows['ifshow']==0){?>
                            <a href="admin_action.php?ac=setshow&amp;id=<?php echo $rows['id'];?>&page=<?php echo $page;?>"><img src="image/审核中.png"  width=24 height=20 alt="审核并显示"title="审核并显示"></a>
                            <?php }else{?><!--$page变量通过点击超链接直接修改url中变量的值获得-->
                                <a href="admin_action.php?ac=unshow&amp;id=<?php echo $rows['id'];?>&page=<?php echo $page;?>"><img src="image/隐藏.png" alt="隐藏此留言" title="隐藏此留言"></a>
                            <?php }}?>
                            <a href="javascript:if(confirm('确认删除此留言?'))location='admin_action.php?ac=delete&amp;id=<?php echo $rows['id']?>&page=<?php echo $page;?>'"><img src="image/删除图标.png" alt="删除此留言" title="删除此留言"></a>
                            <a href="edit.php?id=<?php echo $rows['id'];?>&page=<?php echo $page?>"><img src="image/回复.png" alt="编辑/回复此留言"title="编辑/回复此留言"></a>
                            <?php if($rows['settop']==0){?>
                                <a href="admin_action.php?ac=settop&amp;id=<?php echo $rows['id'];?>&page=<?php echo $page;?>"><img src="image/置顶.png" alt="将本留言置顶" title="将本留言置顶"></a>
                            <?php }else{?>
                                <a href="admin_action.php?ac=unsettop&amp;id=<?php echo $rows['id'];?>&page=<?php echo $page;?>"><img src="image/取消置顶.png" alt="取消置顶" title="取消置顶"></a>
                            <?php }}?>
                </span>
                <span class="rightarea">
                         <?php if(!empty($rows['email'])){?>
                           <a href="mailto:<?php echo $rows['email']?>"><img src="image/email.png" alt="点击用OutLook发送邮件至：<?php echo $rows['email']?>" title="点击发送邮件至：<?php echo $rows['email']?>"></a> 
                           <?php }?><?php if(!empty($_SESSION['admin_pass'])){?>
                          <?php }?>
                           </span></h2>
    <div class="content">
        <?php
        if(empty($_SESSION['admin_pass'])){
        if($rows['ifqqh']==1){
            echo '<span class=ftcolor_999>（此留言为悄悄话，只有管理员可以看见哦...）</span>';
        }else if($ifauditing==1){
            if($rows['ifshow']==0){
                echo '<span class=ftcolor_999>(此留言正在通过审核，当前不可见...)</span>';
            }else{
                echo $rows['content'];
            }
        }else{
            echo $rows['content'];
        }
    }else{
        echo $rows['content'];
    }
    ?>
    </div>
    <?php
    if(!empty($rows['reply'])){?>
    <div class="reply">
        <p><span class="ftcolor_999"><b><?php echo $replyadmin;?>:</b><?php echo date("Y-m-d H:i",strtotime($rows['replytime']));?></span></p>
        <?php  echo $rows['reply'];?>
    </div>
    <?php }}//记录集循环结束
    $db->free_result($rs);
            }else{
                echo "没有留言...";
            }//外层判断记录集为空结束
        ?>
    </div><!--listmain结束-->
</div><!--list结束-->
<div class="clear"></div>
<div id="pages" text_align="center">留言总数:<?php echo $total;?>条   <?php $pager->pageshow();?></div>
<div class="clear"></div>
<div id="submit">   
    <form name="form1" method="post" action="add.php" onSubmit="validator(this)">
        <label for="user">昵称：</label><input type="text" name="username" id="username" value=""><br>
        <label for="comment">内容:</label><textarea id="content" name="content"></textarea><br>
        <label for="comment"></label><span>留言内容不能少于5个字符!</span><br>
        <label for="email">悄悄话</label>
        <input type="checkbox" name="ifqqh" id="ifqqh" value="1"><span>当选中时，此留言仅管理员可见。</span><br>
        <label for="unum">验证码</label><input type="text" id="unum" size="10"><img src="randnum.php?id=-1" title="点击刷新" style="cursor:pointer" onclick=eval(this.src="randnum.php?id='+i+++'")>
        <br>
        <input type="submit" id="sbutton" value="确 定"><br>
        <input type="hidden" id="ac" value="add">
    </form>
</div>
<!--最外层主要区域结束-->
        </div>
</body>
</html>