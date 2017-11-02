<?php
header("Content-type: text/html; charset=utf-8");
include_once 'connect.php';
require_once 'Functions.php';
//if login
session_start();
if(!isset($_SESSION['login'])||$_SESSION['login']!=1){
	header("Location:login.php");
	exit;
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
<meta name="description" content="">
<meta name="author" content="">

<title>新增结果页图片</title>
<!-- Bootstrap core CSS -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/bootstrap-switch.min.css" rel="stylesheet">

<!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
<!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
<script src="js/ie-emulation-modes-warning.js"></script>

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-switch.min.js"></script>
<script src="js/functions.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="js/ie10-viewport-bug-workaround.js"></script>
</head>
<script src="js/ajaxfileupload.js"></script> 
<script>	
function ajaxFileUpload()
{
$.ajaxFileUpload
(
	{
		url:'upload.php',
		secureuri:false,
		fileElementId:'file',
		dataType:'json',
		success: function (data, status)
		{	
			//alert(data.filename);
			alert("上传成功");
			$("#url").val(data.filename);
						
		},
		error: function (data, status,e){}
	}
)
return false;
}
</script>
<script>
$(function(){
	reload();
});


function reload(){
	$("#list").html("");
	$.ajax({
		type:"GET",
		url:'actions.php?action=retrieveResult',
		dataType:"json",
		timeout:5000,
		cache:true,
		async:true,
		success: function (data, textStatus) {
				for(var i=0;i<data.length;i++){
					$("#list").append("<tr id='"+data[i].id+"'><td><img width='300' src='upload/"+data[i].url+"'></td><td>"+data[i].minnum+"</td><td>"+data[i].maxnum+"</td><td><a href='#' onclick=\"update("+data[i].id+","+data[i].minnum+","+data[i].maxnum+",'"+data[i].url+"')\">编辑</a>/<a href='#' onclick='del("+data[i].id+")'>删除</a></td></tr>");
					}
			},
		error: function(XMLHttpRequest, textStatus, errorThrown) {}
	});
}
function del(id){
	$.ajax({
		type:"GET",
		url:'actions.php?action=del&id='+id,
		dataType:"json",
		timeout:5000,
		cache:true,
		async:true,
		success: function (data, textStatus) {
			$("#"+id).remove();
			},
		error: function(XMLHttpRequest, textStatus, errorThrown) {}
	});
}
function create(){
	$("#saveBtn").attr("onclick","save()");
	$("#Modal").modal();
}
function update(id,minnum,maxnum,url){
	//alert(id);
	$("#minnum").val(minnum);
	$("#maxnum").val(maxnum);
	$("#url").val(url);
	$("#saveBtn").attr("onclick","myupdate("+id+")");
	$("#Modal").modal();
}
function myupdate(id){
	var minnum = $("#minnum").val();
	var maxnum = $("#maxnum").val();
	var filename = $("#url").val();
	$.ajax({
		type:"GET",
		url:'actions.php?action=updateResult&url='+filename+"&minnum="+minnum+"&maxnum="+maxnum+"&id="+id,
		dataType:"json",
		timeout:5000,
		cache:true,
		async:true,
		success: function (data, textStatus) {
			//alert("here");
			$("#Modal").modal("hide");
			reload();
			},
		error: function(XMLHttpRequest, textStatus, errorThrown) {}
	});		
}
function save(){
	var minnum = $("#minnum").val();
	var maxnum = $("#maxnum").val();
	var filename = $("#url").val();
	$.ajax({
		type:"GET",
		url:'actions.php?action=insertResult&url='+filename+"&minnum="+minnum+"&maxnum="+maxnum,
		dataType:"json",
		timeout:5000,
		cache:true,
		async:true,
		success: function (data, textStatus) {
			//alert("here");
			$("#Modal").modal("hide");
			},
		error: function(XMLHttpRequest, textStatus, errorThrown) {}
	});		
}

</script>
<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"><strong>HTML5图片轮播系统后台管理</strong></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <form class="navbar-form navbar-right">
          	<button type="button" class="btn btn-success" onclick="create()">新增</button>
          	<a type="button" class="btn btn-success" href="admin.php">返回</a>
          </form>
        </div><!--/.navbar-collapse -->
        
      </div>
</nav>
    
    
<div class="jumbotron">   
	<div class="container">
	   <h1>欢迎您接着使用￣へ￣</h1>
       <p>右上角可以新增不同分数显示的不同的结果页</p>
	   
	</div><!-- /.container -->
</div>

<div class="container">
	   <table class="table table-hover">
	   <thead>
	   <th>图片</th>
	   <th>最小分数(包括)</th>
	   <th>最大分数(包括)</th>
	   <th width="20%">操作</th>
	   </thead>
	   <tbody id="list"></tbody>
	   </table>
	
	
	
	
</div><!-- /.container -->	
	
<div class="modal fade" id="Modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">新增</h4>
      </div>
      <div class="modal-body">
        
        <form>
		  <div class="form-group">
		    <label>上传按钮图片</label>
		    <input type="file" id="file" name="file">
		    <p class="help-block">:)确认无误后，点击<button type="button" class="btn btn-default" onclick="return ajaxFileUpload();">上传</button></p>
		    <input type="hidden" name="url" id = "url" />
		    <input type="text" class="form-control" id="minnum" placeholder="最小分数(包括)" required>
		    <input type="text" class="form-control" id="maxnum" placeholder="最小分数(包括)" required>
		  </div>
		
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <button type="submit" id="saveBtn" class="btn btn-primary">保存了啊</button>
        </form>
        
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

</body>
</html>
