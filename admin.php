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

//$functions = new \Functions();
//$btnlist = json_decode($functions->getAllBtn(),true);
// echo $functions->showtables();

/* $result = mysql_query("SELECT * FROM slide");

while($row = mysql_fetch_array($result))
{
	echo $row['url'] . " " . $row['question'];
	echo "<br />";
} */
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

<title>后台管理中心</title>
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
			//执行插入，将背景图和问题框插入到slide表	
			$.ajax({
				type:"GET",
				url:'actions.php?action=insert&url='+data.filename,
				dataType:"json",
				timeout:5000,
				cache:true,
				async:true,
				success: function (data, textStatus) {
					//alert("here");
					$("#uploadModal").modal("hide");
					reload();
					//location.reload(true);
					},
				error: function(XMLHttpRequest, textStatus, errorThrown) {}
			});			
		},
		error: function (data, status,e){}
	}
)
return false;
}



function ajaxFileUploadAgain(id)
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
				//执行插入，将背景图和问题框插入到slide表	
				$.ajax({
					type:"GET",
					url:'actions.php?action=update&url='+data.filename+"&id="+id,
					dataType:"json",
					timeout:5000,
					cache:true,
					async:true,
					success: function (data, textStatus) {
						//alert("here");
						$("#uploadModal").modal("hide");
						reload();
						//location.reload(true);
						},
					error: function(XMLHttpRequest, textStatus, errorThrown) {}
				});			
			},
			error: function (data, status,e){}
		}
	)
return false;
}


function ajaxBtnUpload()
{
	
	$.ajaxFileUpload
	(
		{
			url:'uploadBtn.php',
			secureuri:false,
			fileElementId:'btn',
			dataType:'json',
			success: function (data, status)
			{	
				alert("上传成功，赶紧填写下面的定位距离");
				$("#btn_url").val(data.filename);	
			},
			error: function (data, status,e){alert("error");}
		}
)
return false;
}
</script>
<script>
$(function(){
	//$("[name='my-checkbox']").bootstrapSwitch();

	//获得初始状态
	$.ajax({
			type:"GET",
			url:'actions.php?action=get',
			dataType:"json",
			timeout:5000,
			cache:true,
			async:true,
			success: function (data, textStatus) {
				if(data=="1"){
					$("[name='my-checkbox']").bootstrapSwitch('state',true);
					}else{
						$("[name='my-checkbox']").bootstrapSwitch('state',false);
						}
				},
			error: function(XMLHttpRequest, textStatus, errorThrown) {}
		});


	
	//$("#uploadModal").modal();
	$('#slideWay').on('switchChange.bootstrapSwitch', function(event, state) {
		  /* console.log(this); // DOM element
		  console.log(event); // jQuery event
		  console.log(state); // true | false */
		$.ajax({
			type:"GET",
			url:'actions.php?action=post&way='+state,
			dataType:"json",
			timeout:5000,
			cache:true,
			async:true,
			success: function (data, textStatus) {},
			error: function(XMLHttpRequest, textStatus, errorThrown) {}
		});
		  
	});
	reload();
	reloadBtn();
});


function reload(){
	$("#list").html("");
	$.ajax({
		type:"GET",
		url:'actions.php?action=retrieve',
		dataType:"json",
		timeout:5000,
		cache:true,
		async:true,
		success: function (data, textStatus) {
				for(var i=0;i<data.length;i++){
					$("#list").append("<tr id='"+data[i].id+"'><td><img width='300' src='upload/"+data[i].url+"'></td><td><a href='#' onclick='update("+data[i].id+")'>编辑</a>/<a href='#' onclick='del("+data[i].id+")'>删除</a></td></tr>");
					}
			},
		error: function(XMLHttpRequest, textStatus, errorThrown) {}
	});
}

function reloadBtn(){
	$("#btnlist").html("");
	$.ajax({
		type:"GET",
		url:'actions.php?action=retrieveAllBtn',
		dataType:"json",
		timeout:5000,
		cache:true,
		async:true,
		success: function (data, textStatus) {
				for(var i=0;i<data.length;i++){
					$("#btnlist").append("<tr id='"+data[i].id+"'><td><img src='upload/"+data[i].url+"'></td><td>"+data[i].left+"</td><td>"+data[i].top+"</td><td>"+data[i].score+"</td><td><a href='#' onclick=\"updateBtn("+data[i].id+",'"+data[i].url+"','"+data[i].top+"','"+data[i].left+"','"+data[i].score+"');\">编辑</a>/<a href='#' onclick='del("+data[i].id+")'>删除</a></td></tr>");
					}
			},
		error: function(XMLHttpRequest, textStatus, errorThrown) {}
	});
}
function updateBtn(id,url,top,left,score){
	$("#btnModal").modal("hide");
	$("#c_btn_url").val(url);
	$("#c_left").val(left);
	$("#c_top").val(top);
	$("#c_btn_id").val(id);
	$("#c_score").val(score);
	$("#changeBtnModal").modal("show");
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
	$("#saveBtn").attr("onclick","return ajaxFileUpload();");
	$("#uploadModal").modal();
}
function update(id){
	//alert(id);
	$("#saveBtn").attr("onclick","return ajaxFileUploadAgain("+id+");");
	$("#uploadModal").modal();
}
function saveBtnImg(){
	//执行插入，将按钮图片和left，top保存到button表
	var left = $("#left").val();
	var top = $("#top").val();
	var score = $("#score").val();
	var filename = $("#btn_url").val();
	$.ajax({
		type:"GET",
		url:'actions.php?action=insertBtn&url='+filename+"&left="+left+"&top="+top+"&score="+score,
		dataType:"json",
		timeout:5000,
		cache:true,
		async:true,
		success: function (data, textStatus) {
			//alert("here");
			$("#btnModal").modal("hide");
			},
		error: function(XMLHttpRequest, textStatus, errorThrown) {}
	});		
}

function updateBtnImg(){
	//执行插入，将按钮图片和left，top保存到button表
	var left = $("#c_left").val();
	var top = $("#c_top").val();
	var id = $("#c_btn_id").val();
	var score = $("#c_score").val();
	var filename = $("#c_btn_url").val();
	$.ajax({
		type:"GET",
		url:'actions.php?action=updateBtn&url='+filename+"&left="+left+"&top="+top+"&id="+id+"&score="+score,
		dataType:"json",
		cache:true,
		async:false,
		success: function (data, textStatus) {
			//alert("here");
			$("#changeBtnModal").modal("hide");
			reloadBtn();
			$("#btnModal").modal();
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
            <button type="button" class="btn btn-success" onclick="create()">新增场景和问题</button>
          	<button type="button" class="btn btn-success" data-toggle="modal" data-target="#btnModal">调整按钮位置和数量</button>
          	<a type="button" class="btn btn-success" href="result.php">新增结果页图片</a>
          	<input type="checkbox" id="slideWay" name="my-checkbox" data-on-color="danger" data-off-color="primary" data-on-text="上滑" data-off-text="左滑" checked>
          </form>
        </div><!--/.navbar-collapse -->
        
      </div>
</nav>
    
    
<div class="jumbotron">   
	<div class="container">
	   <h1>欢迎使用(￢_￢)</h1>
       <p>右上角可以新增场景，并且可以设置前端场景轮换方式</p>
	   
	</div><!-- /.container -->
</div>

<div class="container">
	   <table class="table table-hover">
	   <thead>
	   <th>场景图片</th>
	   <th width="20%">操作</th>
	   </thead>
	   <tbody id="list"></tbody>
	   </table>
	
	
	
	
	</div><!-- /.container -->

	
<div class="modal fade" id="btnModal">
  <div class="modal-dialog" style="width:700px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">新增按钮</h4>
      </div>
      <div class="modal-body">
      
	      <table class="table table-hover">
		   <thead>
		   <th>现有按钮图片</th>
		   <th>左边界距离</th>
		   <th>上边界距离</th>
		   <th>分数</th>
		   <th width="20%">操作</th>
		   </thead>
		   <tbody id="btnlist">
		   </tbody>
		  </table>
	   
	   
        <form>
		  <div class="form-group">
		    <label>上传按钮图片</label>
		    <input type="file" id="btn" name="btn">
		    <p class="help-block">点击和未点击图片拼到一张上啊:)确认无误后，点击<button type="button" class="btn btn-default" onclick="return ajaxBtnUpload();">上传</button></p>
		    <input type="hidden" name="btn_url" id = "btn_url" />
		    <input type="text" class="form-control" id="left" name="left" placeholder="距离屏幕左边的距离（必填）" required>
		    <input type="text" class="form-control" id="top" name="top" placeholder="距离屏幕顶部的距离（必填）" required>
		    <input type="text" class="form-control" id="score" name="score" placeholder="分数（必填）" required>
		  </div>
		
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <button type="submit" onclick="saveBtnImg()" class="btn btn-primary">保存了啊</button>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
	
<div class="modal fade" id="changeBtnModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">更改按钮图片和位置</h4>
      </div>
      <div class="modal-body">
        
        <form>
		  <div class="form-group">
		    <label>上传按钮图片</label>
		    <input type="file" id="btn" name="btn">
		    <p class="help-block">点击和未点击图片拼到一张上啊:)确认无误后，点击<button type="button" class="btn btn-default" onclick="return ajaxBtnUpload();">上传</button>,如果为改动图片，可以不用点击！！切记！！</p>
		    <input type="hidden" name="c_btn_url" id = "c_btn_url" />
		    <input type="hidden" name="c_btn_id" id = "c_btn_id" />
		    <label>距离屏幕左边的距离</label>
		    <input type="text" class="form-control" id="c_left" name="c_left" placeholder="距离屏幕左边的距离（必填）" required>
		    <label>距离屏幕顶部的距离</label>
		    <input type="text" class="form-control" id="c_top" name="c_top" placeholder="距离屏幕顶部的距离（必填）" required>
			<label>分数</label>
		    <input type="text" class="form-control" id="c_score" name="c_score" placeholder="分数（必填）" required>
		  </div>
		    
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <button type="submit" onclick="updateBtnImg()" class="btn btn-primary">保存了啊</button>
        </form>
        
        
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->	
	
	
<div class="modal fade" id="uploadModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">新增场景和问题</h4>
      </div>
      <div class="modal-body">
        
        <form>
		  <!-- <div class="form-group">
		    <label>问题</label>
		    <input type="text" class="form-control" id="question" placeholder="输入问题（必填）" required>
		  </div> -->
		  <div class="form-group">
		    <label>上传场景图片</label>
		    <input type="file" id="file" name="file">
		    <p class="help-block">场景和问题会在一张图片上哦:)</p>
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
