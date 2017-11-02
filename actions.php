<?php
include_once 'connect.php';
if($_GET['action']=="get"){
	$result = mysql_query("SELECT value FROM system where `key`= 'slideway' ");
	$way = mysql_result($result,0);
	echo json_encode($way);
}else if ($_GET['action']=="insert"){
	$url = $_GET['url'];
	$current = time();
	//首先判断是数据库是否已经存在
	$num = mysql_result(mysql_query("select count(*) from slide where url='$url'"),0);
	if($num){
		echo json_encode(1);
		exit;
	}else{
		$sql = "insert into slide set url='$url',creation_date=$current";
		$result = mysql_query($sql);
		echo json_encode(1);
	}
	
}else if ($_GET['action']=="insertBtn"){
	$url = $_GET['url'];
	$left = $_GET['left'];
	$top = $_GET['top'];
	$score = $_GET['score'];
	$current = time();
	//首先判断是数据库是否已经存在
	$num = mysql_result(mysql_query("select count(*) from button where url='$url'"),0);
	if($num){
		echo json_encode(1);
		exit;
	}else{
		$sql = "insert into button set `url`='$url',`top`='$top',`left`='$left',`score`='$score'";
		$result = mysql_query($sql);
		echo json_encode(1);
	}
	
}else if ($_GET['action']=="insertResult"){
	$url = $_GET['url'];
	$minnum = $_GET['minnum'];
	$maxnum = $_GET['maxnum'];
	$current = time();
	//首先判断是数据库是否已经存在
	$num = mysql_result(mysql_query("select count(*) from slide where url='$url'"),0);
	if($num){
		echo json_encode(1);
		exit;
	}else{
		$sql = "insert into slide set `url`='$url',`minnum`='$minnum',`maxnum`='$maxnum',status=1";
		$result = mysql_query($sql);
		echo json_encode(1);
	}
	
}else if ($_GET['action']=="updateResult"){
	$url = $_GET['url'];
	$minnum = $_GET['minnum'];
	$maxnum = $_GET['maxnum'];
	$id = $_GET['id'];
	$current = time();
	//首先判断是数据库是否已经存在
	
	$sql = "update slide set `url`='$url',`minnum`='$minnum',`maxnum`='$maxnum',status=1 where id = $id";
	$result = mysql_query($sql);
	echo json_encode(1);
	
	
}else if ($_GET['action']=="update"){
	$url = $_GET['url'];
	$id = $_GET['id'];
	$current = time();
	//首先判断是数据库是否已经存在
	$num = mysql_result(mysql_query("select count(*) from slide where url='$url'"),0);
	if($num){
		echo json_encode(1);
		exit;
	}else{
		$sql = "update slide set url='$url',creation_date=$current where id = $id";
		$result = mysql_query($sql);
		echo json_encode(1);
	}
	
}else if ($_GET['action']=="updateBtn"){
	$url = $_GET['url'];
	$id = $_GET['id'];
	$left = $_GET['left'];
	$top = $_GET['top'];
	$score = $_GET['score'];
	$current = time();
	//首先判断是数据库是否已经存在
	
	$sql = "update button set `url`='$url',`top`='$top',`left`='$left',`score`='$score' where id = $id";
	$result = mysql_query($sql);
	echo json_encode(1);
	
	
}else if($_GET['action']=="retrieve"){
	
	$result = mysql_query("SELECT * FROM slide where status=0 order by id desc");
	$array = array();
	while($row = mysql_fetch_array($result,MYSQL_ASSOC))
	{
		$array[] = $row;
	}
	echo json_encode($array);
}else if($_GET['action']=="retrieveResult"){
	
	$result = mysql_query("SELECT * FROM slide where status=1 order by id desc");
	$array = array();
	while($row = mysql_fetch_array($result,MYSQL_ASSOC))
	{
		$array[] = $row;
	}
	echo json_encode($array);
}else if ($_GET['action']=="retrieveAllBtn"){
	$result = mysql_query("SELECT * FROM button");
	$array = array();
	while($row = mysql_fetch_array($result,MYSQL_ASSOC))
	{
		$array[] = $row;
	}
	echo json_encode($array);
}else if ($_GET['action']=="del"){
	$id = $_GET['id'];
	mysql_query("delete from slide where id = $id");
	echo json_encode(1);
}else if ($_GET['action']=="showResult"){
	$score = $_GET['allscore'];
	$sql = "SELECT url,`desc` from slide where status=1 and $score>= minnum and maxnum>=$score limit 1";
	$result = mysql_query($sql);
	$array = array();
	while($row = mysql_fetch_array($result,MYSQL_ASSOC))
	{
		$array[] = $row;
	}
	echo json_encode($array);
}else{
	
	if ($_GET['way']=="true"){
		$way = 1;
	}else{
		$way = 0;
	}
	mysql_query("update `system` set value='$way' where `key` = 'slideway'");
}

mysql_close();