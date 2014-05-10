<?php
header('Content-Type: text/html; charset=UTF-8');
$db_info   = 'book';  
$db_config = 'config';
$conn = mysql_connect($db_host,$db_user,$db_pswd);
if(!$conn) exit('<br/>无法连接数据库！请检查数据库设置！');
mysql_query('SET NAME GBK');
if(mysql_select_db($db_name,$conn)){
    $sql = "CREATE TABLE $db_config(
        name  varchar(50) NOT NULL,
        pswd  varchar(32) NOT NULL,
        audit int(1)      NOT NULL,
        info  text,
        PRIMARY KEY(name)
    )";
    mysql_query($sql,$conn);
    $sql = "CREATE TABLE $db_info(
        id    int NOT NULL AUTO_INCREMENT,
        ip    varchar(12) NOT NULL,
        time  varchar(10) NOT NULL,
        info  text,
        reply text,
        audit int(1) NOT NULL,
        PRIMARY KEY(id)
    )";
    mysql_query($sql,$conn);

    
}else{
    mysql_query("CREATE DATABASE $db_name",$conn) or die('无法创建数据库!');
    header('location:?');
}
?>