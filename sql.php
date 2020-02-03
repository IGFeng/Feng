<?php
error_reporting(E_ALL^E_WARNING);
error_reporting(E_ALL&~E_NOTICE);
class db_mysql{
    var $dbServer;
    var $dbDatabase;
    var $dbbase;
    var $dbUser;
    var $dbPwd;
    var $dbLink;
    var $result;
    var $num_rows;
    var $insert_id;
    var $affected_rows;

    function dbconnect(){
        $this->dbLink=@mysqli_connect($this->dbServer,$this->dbUser,$this->dbPwd);
        if(!$this->dbLink)$this->dbhalt("不能连接数据库");
        if($this->dbbase=="")$this->dbbase=$this->dbDatabase;
        if(!@mysqli_select_db($this->dbLink,$this->dbbase))
        $this->dbhalt("数据库不可用");
        $sql="CREATE TABLE `sh_message`(
            `id` int(12) NOT NULL AUTO_INCREMENT,
            `username` varchar(32) NOT NULL,
            `content` text NOT NULL,
            `reply` text DEFAULT NULL,
            `userid` int(12) DEFAULT NULL,
            `settop` tinyint(1) NOT NULL DEFAULT '0',
            `ifshow` tinyint(1) NOT NULL DEFAULT '0',
            `ifqqh` tinyint(1) NOT NULL DEFAULT '0',
           `systime` datetime DEFAULT NULL,
           `replytime` datetime DEFAULT NULL,
            `userip` varchar(32) DEFAULT NULL COMMENT '用户ip',
            PRIMARY KEY (`id`),
            KEY `userid` (`userid`),
            CONSTRAINT `userid` FOREIGN KEY (`userid`) 
         )";
         mysqli_query($this->dbLink,$sql);
        /* $sql="CREATE TABLE mb_users (
            id int(12) NOT NULL AUTO_INCREMENT COMMENT '用户主键',
            account varchar(32) NOT NULL COMMENT '用户账号',
            name varchar(32) DEFAULT '无名' COMMENT '用户名',
            password varchar(32) NOT NULL COMMENT '用户密码',
            email varchar(32) DEFAULT NULL COMMENT '用户邮件',
            role int(11) DEFAULT '4' COMMENT '0为管理员；1为会员；4为普通用户；',
            created datetime DEFAULT NULL COMMENT '最后登录时间',
            lastlogin datetime DEFAULT NULL COMMENT '最后登录时间',
            PRIMARY KEY (id)
          )";
          mysqli_query($this->dbLink,$sql);
          $sql="INSERT INTO mb_users values('1','sherman','午'，'Fdy135246','2218785142@qq.com','0','2020-1-20 21:00:01','2020-1-20 21:00:03')";
          mysqli_query($this->dbLink,$sql);*/
        //mysql_query("SET NAMES 'gbk'");
    }//数据库连接和选取数据库
    function execute($sql){
        $this->result=mysqli_query($this->dbLink,$sql);
        return $this->result;
    }//对数据库进行操作
    function fetch_array($result){
        if (!$result) {
            printf("Error: %s\n", mysqli_error($this->dbLink));
            exit();
        }
        return mysqli_fetch_array($result);
    }//选取特定的行并生成数组
    function get_rows($result){
            if (!$result) {
                printf("Error: %s\n", mysqli_error($this->dbLink));
                exit();
            }
        return mysqli_num_rows($result);
    }//返回结果集中行的数目
    function data_seek($result,$rowNumber){
        return mysqli_data_seek($result,$rowNumber);
    }//移动集中行指针的位置
    function dbhalt($errmsg){
        $msg="database is wrong!";
        $msg=$errmsg;
        echo $msg;
        die();
    }//报错并终止脚本
    function delete($sql){
        $result=$this->execute($sql);
        $this->affected_rows=mysqli_affected_rows($this->dbLink);
        $this->free_result($result);
        return $this->affected_rows;
    }
    function insert($sql){
        $result=$this->execute($sql);
        $this->affected_rows=mysqli_affected_rows($this->dbLink);
        $this->free_result($result);
        return $this->affected_rows;
    }
    function update($sql){
        $result=$this->execute($sql);
        $this->affected_rows=mysqli_affected_rows($this->dbLink);
        $this->free_result($result);
        return $this->affected_rows;
    }
    function free_result($result){
        if (!$result) {
            printf("Error: %s\n", mysqli_error($this->dbLink));
            exit();
        }
       mysqli_free_result($result);
    }
    function dbclose(){
        mysqli_close($this->dbLink);
    }
}
?>