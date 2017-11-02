(function browserRedirect() {
    var wid = 720;
    var rate=window.screen.width/wid;
    var sUserAgent = navigator.userAgent.toLowerCase();
    var bIsIpad = sUserAgent.match(/ipad/i) == "ipad";
    var bIsIphoneOs = sUserAgent.match(/iphone os/i) == "iphone os";
    var bIsMidp = sUserAgent.match(/midp/i) == "midp";
    var bIsUc7 = sUserAgent.match(/rv:1.2.3.4/i) == "rv:1.2.3.4";
    var bIsUc = sUserAgent.match(/ucweb/i) == "ucweb";
    var bIsAndroid = sUserAgent.match(/android/i) == "android";
    var bIsCE = sUserAgent.match(/windows ce/i) == "windows ce";
    var bIsWM = sUserAgent.match(/windows mobile/i) == "windows mobile";
    if(!(bIsIpad||bIsIphoneOs)){
        document.getElementById('meteID').content = 'width=device-dpi, user-scalable=0';
    }
    if(sUserAgent.match(/windows/)=='windows')return;
    if(rate<1){
    var deviceWidth = window.screen.width, // 设备的宽度
        devicePixelRatio = window.devicePixelRatio || 1, // 物理像素和设备独立像素的比例，默认为1
        targetDensitydpi = wid / deviceWidth * devicePixelRatio * 160;
    document.getElementById('meteID').content = 'width='+wid+',target-densityDpi=' + targetDensitydpi + ',initial-scale='+rate+', maximum-scale='+rate+', user-scalable=0';
    
    }else{
        document.getElementById('meteID').content = 'width='+wid+',target-densityDpi=device-dpi,initial-scale='+rate+', maximum-scale='+rate+', user-scalable=0';
        
    }
    if (bIsIpad||bIsIphoneOs ||bIsMidp || bIsUc7 || bIsUc || bIsAndroid || bIsCE || bIsWM) {
        document.getElementsByTagName('html')[0].style.fontSize = parseFloat(window.screen.width/wid/rate*100).toFixed(2)+'px';
        
    }
})();
