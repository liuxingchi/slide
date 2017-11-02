<?php
header("Content-type: text/html; charset=utf-8");
include_once 'connect.php';

class Functions
{
	public function showSlides(){
		$result = mysql_query("SELECT * FROM slide where status = 0 order by id asc");
		$array = array();
		while($row = mysql_fetch_array($result,MYSQL_ASSOC))
		{
			$array[] = $row;
		}
		return json_encode($array);
	}	
	
	public function getSlideWay(){
		
		$result = mysql_query("SELECT value FROM system where `key`= 'slideway' ");
		$way = mysql_result($result,0);
		return $way;
	}
	
	public function getSlideNum(){
	
		$result = mysql_query("SELECT count(*) FROM slide where status = 0 ");
		$num = mysql_result($result,0);
		return $num;
	}
	
	public function getAllBtn(){
	
		$result = mysql_query("SELECT * FROM button");
		$array = array();
		while($row = mysql_fetch_array($result,MYSQL_ASSOC))
		{
			$array[] = $row;
		}
		return json_encode($array);
	}
}