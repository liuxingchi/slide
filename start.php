<?php
require_once "jssdk.php";
$jssdk = new JSSDK("wxfba8a23be3bb4304", "91c47272ddc7de7be89feaf295d8ee0c");
$signPackage = $jssdk->GetSignPackage();
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
    
<script type="text/javascript">    
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
</head>
<body>
<a href='index.php'><img src="images/3st.jpg" width="100%"/></a>
<?php require_once 'cs.php';echo '<img src="'._cnzzTrackPageView(1256605779).'" width="0" height="0"/>';?>
</body></html>