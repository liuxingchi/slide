<!-- 把如下代码加入<body>区域中 -->
<html>
<head>
<title>正在载入...</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<meta name="viewport" content="initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
<meta content="yes" name="apple-mobile-web-app-capable">
<meta content="yes" name="apple-touch-fullscreen">
<meta name="viewport" content="width=720, user-scalable=0" id="meteID">
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0">
<table border=0 cellpadding=0 cellspacing=0 width="100%" height="100%">
<tr>
<form name=loading>
<td align=center>
<p><img src="images/loading.png"/></p>
<p>
<input type=text name=chart size=46 style="font-size:20px;font-family:Arial;
font-weight:bolder; color:#d35622;
background-color:white; padding:0px; border-style:none;">
<br>
<input type=text name=percent size=20 style="font-size:30px;font-family:Arial;
color:gray; text-align:center;
border-width:medium; border-style:none;">
<script>var bar = 0
var line = "||"
var amount ="||"
count()
function count(){
bar= bar+2
amount =amount + line
document.loading.chart.value=amount
document.loading.percent.value=bar+"%"
if (bar<99)
{setTimeout("count()",100);}
else
{window.location = "http://slide.yingdongzhuoyue.com/start.php";}
}
</script>
</p>
</td>
</form>
</tr>
</table>
<?php require_once 'cs.php';echo '<img src="'._cnzzTrackPageView(1256605779).'" width="0" height="0"/>';?>
</body>
</html>