<?php
$con = mysql_connect("localhost","root","ydzy2wsx");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("slide", $con);
