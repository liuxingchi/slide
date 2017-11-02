var WeiXinJSSDKSet = function(config){
		wx.config({
			debug: config.debug,
			appId: config.appId,
			timestamp: config.timestamp,
			nonceStr: config.nonceStr,
			signature: config.signature,
			jsApiList: config.jsApiList
		});
		wx.ready(function() {
			wx.onMenuShareTimeline({
				title: config.titleline,
				link: config.link,
			   imgUrl: config.imgUrl,
				success: function() {
					//alert("success");
				},
				cancel: function() {}
			});
			wx.onMenuShareAppMessage({
				title: config.titleMessage,
				desc: config.descMessage,
				link: config.link,
				imgUrl: config.imgUrl,
				type: '',
				dataUrl: '',
				success: function() {
					//alert("success");
				},
				cancel: function() {}
			});
		});
	}