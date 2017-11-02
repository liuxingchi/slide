<?php
include_once 'connect.php';
require_once 'Functions.php';
require_once "jssdk.php";
$jssdk = new JSSDK("wxfba8a23be3bb4304", "91c47272ddc7de7be89feaf295d8ee0c");
$signPackage = $jssdk->GetSignPackage();

$functions = new \Functions();

//$slidenum = $functions->getSlideNum();

//获得滑动方式
$slideWay = $functions->getSlideWay();

$slides = json_decode($functions->showSlides(),true);
$btns = json_decode($functions->getAllBtn(),true);
?>
<!doctype html>
<html lang="en" style="font-size:60px">
<head>
	<meta charset="UTF-8">
	<title>测测家里室温多少度</title>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="yes" name="apple-touch-fullscreen">
    <meta name="viewport" content="width=720, user-scalable=0" id="meteID">
    <script src="js/jquery.min.js"></script>
    <script src="js/weixin.js"></script>
    <script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>



</head>
<body  onLoad="start()">
<!-- <audio src="timegoingwhere.mp3" loop="loop" autoplay="autoplay"></audio> -->
</p>
	<script src="js/adaption.js"></script>
	<link rel="stylesheet" href="css/common.css">
	<link rel="stylesheet" href="css/index.css">
	<div style=" width:100px; height:55px; position:fixed; right:10px; top:10px; z-index:999999; overflow:hidden;">
	    <audio id="audioobj" src="whenyougetold.mp3" loop="loop">
	    	Your browser does not support the audio element.
	    </audio>
	   <img src="images/music1.png" id="music1" style="width: 50px; position: absolute; right: 0px; top: 0px; z-index: 999; ">
	   <img src="images/music2.png" id="music2" style="width: 50px; position: absolute; right: 0px; top: 0px; z-index: 999; display: none;">
	</div>

	<!-- moveto：1表示向上滑 0表示想左滑 -->
	<div class="wrapper" moveto="<?php echo $slideWay?>">
		<img src="images/lodding.gif" alt="" class="lodding">
		<div class="oflow">
			<div class="outbox">
				<!-- <div class="imgbox">
					<img  url="images/1st.jpg" alt="" class="mainpic">
				</div> -->
				<?php foreach ($slides as $key=>$slide){?>
					<div class="imgbox">
					<img  url="upload/<?php echo $slide['url']?>" alt="" class="mainpic">
					<!-- <div class="btn" url="images/btn1.png" style="left:2.96rem;top:9rem;"></div>
					<div class="btn" url="images/btn2.png" style="left:4.96rem;top:9rem;"></div> -->
					<?php foreach ($btns as $btn){?>
					<div class="btn" score="<?php echo $btn['score']?>" url="upload/<?php echo $btn['url']?>" style="left:<?php echo $btn['left']?>rem;top:<?php echo $btn['top']?>rem;"></div>
					<?php }?>
					</div>
				<?php }?>

			</div>
		</div>
    </div>

    <!-- 分享遮罩 -->
    <div class="page" id="page" style="display: none;">
            <img class="fx" id="pageImage" src="images/cover1new.png" style="position: absolute;top: 0;right: 0;
            ">.
    </div>



<script type="text/javascript">
var mp3=$('#audioobj')[0];
document.getElementById('music1').addEventListener('touchstart', function (e) {
	mp3.pause();
	$('#music1').hide();
	$('#music2').show();
	})
document.getElementById('music2').addEventListener('touchstart', function (e) {
	mp3.play();
	$('#music2').hide();
	$('#music1').show();
	})
document.getElementById('pageImage').addEventListener('click', function (e) {
	hidePage();
	return;
	})
function start(){
		mp3.play();
}
function showPage(){
	$('#music2').hide();
	$('#music1').hide();
	$("#page").attr("style","display:block");
	//$("#page").attr("display","none");
}
function hidePage(){
	$("#page").attr("style","display:none");
}
	//91c47272ddc7de7be89feaf295d8ee0c
	var config = {
			debug: false,
			appId: '<?php echo $signPackage["appId"];?>',
			timestamp: <?php echo $signPackage["timestamp"];?>,
			nonceStr: '<?php echo $signPackage["nonceStr"];?>',
			signature: '<?php echo $signPackage["signature"];?>',
			jsApiList: ['onMenuShareTimeline', 'onMenuShareAppMessage'],
            titleline: '测测家里室温多少度',
            titleMessage: '测测家里室温多少度',
            descMessage: "爸、妈，我想回家啦！",
            link: 'http://slide.yingdongzhuoyue.com/main.php',
            imgUrl: 'http://slide.yingdongzhuoyue.com/images/share.jpg',
		};

	WeiXinJSSDKSet(config);
</script>
	<script src="js/sea.js"></script>
	<script>
seajs.config({
    base:'/',
    alias:{
        zepto:'js/zepto.min.js'
    }
});
seajs.use('js/main.js');
	</script>
<?php require_once 'cs.php';echo '<img src="'._cnzzTrackPageView(1256605779).'" width="0" height="0"/>';?>
</body>
</html>