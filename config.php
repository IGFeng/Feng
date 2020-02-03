<?php
include 'sql.php';
$db=new db_mysql();
$db->dbServer ='localhost';
$db->dbbase ='messageboard';
$db->dbUser='sherman';
$db->dbPwd='';
$db->dbconnect();
?>