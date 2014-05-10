<?php
header('Content-Type: text/html; charset=UTF-8');
include 'config.php';
include 'table.php'; 
$conn = mysql_connect($db_host,$db_user,$db_pswd);
if(!$conn) exit('<br/>无法连接数据库！请检查数据库设置！');
mysql_query('SET NAME GBK');
$admin_pswd = md5('admin');
$web_name = 'web-homework';
$web_audit = 1;
$web_info = '密码：admin ';
mysql_query(
    "INSERT INTO $db_config(name,pswd,info,audit)VALUES ('$web_name','$admin_pswd','$web_info',$web_audit)"
);
$sql = mysql_query("SELECT * FROM $db_config");
$row = mysql_fetch_array($sql);
$name = $row['name'];
$pswd = $row['pswd']; 
$info = $row['info']; 
$audit = $row['audit'];
$id = isset($_GET['id']) ? intval(trim($_GET['id'])) : '';
$cookie = isset($_COOKIE['cookie']) ? $_COOKIE['cookie'] : '';
$cookies = md5('webhomework');
if(isset($_POST['login'])){
    if(md5($_POST['login']) == $pswd){
        setcookie('cookie',$cookies);
        header('location:?');
    }
	else{
		header('refresh:2;url=?login');
		exit('
        <span style="color:red;">密码错误！</span>
        <a href="?login">返回</a>　
        2秒后自动跳转页面...
        ');
    }
}
if(isset($_GET['exit'])){
    setcookie('cookie','');
    header('location:?');
}
echo <<<HTML
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="index.css"> 
<h1 style="background-color:#FF66CC;padding:20px;text-align:center;">
。。。天空没有留下飞鸟的痕迹，但我已经留了言。。。</h1>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="index.css">    
<title>留言板</title>
</head>
<a href="#bottom">返回底部管理按钮</a><br/>
<body>
HTML;
if(isset($_GET['login']) && !$cookie){
    exit('
    <form method="post">
    请输入密码：<input name="login" type="password"/>
    <input type="submit" value=" 提 交 "/>
    </form>
    ');
}
if($cookie == $cookies){ 
   if(isset($_GET['delete'])){ 
        $id = intval(trim($_GET['id']));
        mysql_query("DELETE FROM $db_info WHERE id = $id");
		exit('
        <span style="color:red;">密码错误！</span>
        <a href="?login">返回</a>　
        2秒后自动跳转页面...
        ');
    }
	if(isset($_POST['id'])){ 
        $id = $_POST['id'];
		$value = htmlspecialchars($_POST['content'],ENT_QUOTES);
	    if(get_magic_quotes_gpc()) $value = stripslashes($_POST['content']);
    	$info  =$value;
		$value = htmlspecialchars($_POST['reply'],ENT_QUOTES);
    	if(get_magic_quotes_gpc()) $value = stripslashes($_POST['reply']);
    	$reply  =$value;
        $audit = $_POST['audit'] ? 1 : 0;
        mysql_query("
            UPDATE $db_info SET 
            info  = '$info',
            reply = '$reply',
            audit = $audit
            WHERE id = $id
        ");
        exit('
		<meta http-equiv="refresh" content="2; url=?">
		<span style="color:red;">操作成功！</span>
        <a href="?">点此返回</a>　2秒后自动跳转页面...
	');
    }
    if(isset($_POST['name']) && $_POST['name']){ 
        $pswd = $_POST['pswd'] ? md5($_POST['pswd']) : $pswd;
        $audit = $_POST['audit'] ? 1 : 0;
        $value = htmlspecialchars($_POST['name'],ENT_QUOTES);
    	if(get_magic_quotes_gpc()) $value = stripslashes($_POST['name']);
    	$name =$value;
		$value = htmlspecialchars($_POST['info'],ENT_QUOTES);
    	if(get_magic_quotes_gpc()) $value = stripslashes($_POST['info']);
    	$info =$value;
        mysql_query("
            UPDATE $db_config SET  
            pswd = '$pswd',
            info = '$info',
            audit = $audit,
        ");
        exit('
		<meta http-equiv="refresh" content="2; url=?">
		<span style="color:red;">操作成功！</span>
        <a href="?">点此返回</a>　2秒后自动跳转页面...
	');
    }
}
if(isset($_GET['reply']) && $cookie){
    $sql = mysql_query("SELECT * FROM $db_info WHERE id = $id");
    $row = mysql_fetch_array($sql);
    $ip = $row['ip'];
    $time = $row['time'];
    $time = date('Y-m-d H:i:s',$time);
    $audit = $row['audit'];
    $reply = $row['reply'];
    $content = $row['info'];
    $yes = $audit ? 'checked="checked"' : '';
    $no = $audit ? '' : 'checked="checked"';
    echo <<<HTML
    <a>管理　ID：{$id}</a>　|　TIME：{$time}
    <form method="post">
    修改： <textarea name="content">{$content}</textarea><br />
    楼主回复： <textarea name="reply">{$reply}</textarea><br />
    审核：
    <input type="radio"  name="audit" value="1" {$yes} />已审
    <input type="radio"  name="audit" value="0" {$no}  />未审
    <input type="hidden" name="id"    value="{$id}"    />
    <input type="hidden" name="time"  value="{$time}"  />
    <input type="submit" value=" 提 交 " />　
    <a href="?delete&id={$id}" onclick="return confirm('确定删除？');">删除</a>
    </form>
HTML;
exit;
}
if($cookie){
    $on  = ($audit == 1) ? 'checked="checked"' : '';
    $off = ($audit == 0) ? 'checked="checked"' : '';
    echo <<<HTML
    <form method="post">
    密码：<input name="pswd" type="password" /><br />
    自动审核：<input name="audit" type="radio" value="1" {$on} /> 开
    <input name="audit" type="radio" value="0" {$off} /> 关<br />
    公告：<textarea style="height: 50px " name="info">{$info}</textarea>
	</br> <input type="submit" value="提交修改" />　
    <a style="font-size:30px;border:#3300CC 3px solid" href="?exit">退出管理</a>　
    </form>
HTML;
}
if(!$cookie){
    $ip_all = $_SERVER["REMOTE_ADDR"] ? $_SERVER["REMOTE_ADDR"] : '0.0.0.0';
    $ip = preg_replace('~(\d+)\.(\d+)\.(\d+)\.(\d+)~', '$1.$2.$3.*', $ip_all);
	if(isset($_POST['add']) && $_POST['add']){
        ini_set('max_execution_time','60');
		$time    = time();
		$audit   = $audit ? 0 : 1;
		//$content = neirong($_POST['add']);
		$value = htmlspecialchars($_POST['add'],ENT_QUOTES);
    if(get_magic_quotes_gpc()) $value = stripslashes($_POST['add']);
    $content= $value;
	mysql_query("INSERT INTO $db_info(time,ip,audit,info)VALUES($time,'$ip_all',$audit,'$content')");
	exit('
		<meta http-equiv="refresh" content="2; url=?">
		<span style="color:red;">操作成功！</span>
        <a href="?">点此返回</a>　2秒后自动跳转页面...
	');
	}
	$show = $audit ? '　<span>注： 审核已开启 需等待管理员审核</span>' : '';
	$date = date('Y-m-d',time());
	$info = str_replace('  ','&nbsp;&nbsp;',nl2br($info));
	echo <<<HTML
	{$info}
	<form method="post">
	<textarea name="add"></textarea>
	<p>	<input type="submit" value=" 提 交 " />	{$show}　{$date}	</p>
	</form>
HTML;
}
$size  = 10;
$count = mysql_result(mysql_query("SELECT count(id) FROM $db_info"),0);
$pagecount = ceil($count/$size);
if(isset($_GET['page']))     
$page = trim($_GET['page']);
if(!isset($page) || $page<1) 
	$page = 1;
if($page > $pagecount)       
	$page = $pagecount;
$page = intval($page);
$i = 1;
$jump = ($page - 1) * $size;
$sql = mysql_query("SELECT * FROM $db_info ORDER BY id DESC LIMIT $jump,$size");
while($count && $row = mysql_fetch_array($sql)){
    $id = $row['id'];
    $ip = $row['ip'];
    $audit = $row['audit'];
    $time = $row['time'];
    $time = date('Y-m-d H:i:s',$time);
    $reply = $row['reply'];
    $reply = str_replace('  ','&nbsp;&nbsp;',nl2br($reply));
    $reply = $reply ? "<hr /><span>回复：</span><br />{$reply}" : '';
    $content = $row['info'];
    $content = str_replace('  ','&nbsp;&nbsp;',nl2br($content));
    $content = ($cookie || $audit) ? $content : '<a>未审核内容暂不显示</a>';
    $color = ($i%2) ? 'style="background-color:#FFCCFF;border:#eee 1px solid;"' : '';
    if($cookie){
        $text  = $audit  ? '点击进行管理' : '<span>点击进行审核</span>';
        $admin = "<a href=\"?reply&id={$id}\">{$text}</a>　|　";
    } else {
        $ip    = preg_replace('~(\d+)\.(\d+)\.(\d+)\.(\d+)~', '$1.$2.$3.*', $ip);
        $admin = '';
    }
    $replys  = $reply  ? '<hr /><span>回复：</span><br />' : '';
    $waiting = ($cookie || $audit) ? $content : '<a>等待审核...</a>';
    echo <<<HTML
        <div {$color}><span style="color:#888">
           {$admin}{$id} 楼吐槽   时间:{$time}</span> <br />
            {$content}{$reply}
        </div>
HTML;
$i++;
}
$last = $page - 1;
$next = $page + 1;
echo <<<HTML
<form method="get"><hr />
<a href="?page={$last}">上页</a>第{$page}/{$pagecount}页<a href="?page={$next}">下页</a>　跳至
<input name="page" type="text" size="3"onkeyup="this.value=this.value.replace(/\D/g,'')"
onafterpaste="this.value=this.value.replace(/\D/g,'')"
/> 页|每页 {$size}总数 {$count}　
<a name="bottom" style="font-size:36px;border:#3300CC 3px solid" href="?login">点击进行管理</a>
</form>
</body>
</html>
HTML;
mysql_close($conn);
?>