<!DOCTYPE html>
<html manifest="m.manifest">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport"
	content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>红包</title>
<link rel="stylesheet" type="text/css" href="/css/mystyle.css">
<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
</head>
<body>
	<!--content-->

	<div class="container-fluid">
		<h3>高潮了，上不上？？你要或者不要，450元的红包就在这里！</h3>
		<p class="text-muted">2015-02-16众择用车</p>
		<div class=" alltop">
			<img src="/img/gaoduan.png" width="100%">
		</div>
		<div class=" alltop">
			<img src="/img/chaoliu.png" width="100%">
		</div>
		<div class=" alltop">
			<img src="/img/shangwoba.png" width="100%">
		</div>
		<div class=" alltop">
			<img src="/img/qrcode_for_gh_c0dd535c24d0_258.jpg">
		</div>
		<p>搜索关注众择用车或长按二维码关注公众号，微信直接下单，下单拿红包</p>
	</div>
	</div>
</body>
<script>
var lineLink    = 'http://../....';    // 要分享的页面的URL
var imgUrl      = 'http://.../...';    // 显示在微信里的缩略图
var shareTitle  = '页面标题';          // 页面标题
var descContent = "页面内容简介";      // 内容简介
var appid       = '<?php echo WECHAT_APP_ID;?>';                  // APP ID, 可以为空


function wx_shareFriend() {  
  WeixinJSBridge.invoke('sendAppMessage',{  
     "appid": appid,  
     "img_url": imgUrl,  
     "img_width": "640",  
     "img_height": "640",  
     "link": lineLink,  
     "desc": descContent,  
     "title": shareTitle  
     }, function(res) {  
       //alert(res.err_msg);
		alert(123);
     })  
}  

function wx_shareTimeline() {  
  WeixinJSBridge.invoke('shareTimeline',{  
    "img_url": imgUrl,  
    "img_width": "640",  
    "img_height": "640",  
    "link": lineLink,  
    "desc": descContent,  
    "title": shareTitle  
    }, function(res) {  
       //alert(res.err_msg); 
alert(12222);	   
    });  
}  

function wx_shareWeibo() {  
  WeixinJSBridge.invoke('shareWeibo',{  
    "content": descContent,  
    "url": lineLink,  
    }, function(res) {  
      //alert(res.err_msg);  
    });  
}  

function onBridgeReady(){
  WeixinJSBridge.on('menu:share:appmessage', wx_shareFriend);   // 发送给朋友
  WeixinJSBridge.on('menu:share:timeline',   wx_shareTimeline); // 分享到朋友圈
  //WeixinJSBridge.on('menu:share:weibo',      wx_shareWeibo);    // 分享到微博
}

if (typeof WeixinJSBridge == "undefined"){
  if( document.addEventListener ){
      document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
  }else if (document.attachEvent){
      document.attachEvent('WeixinJSBridgeReady', onBridgeReady); 
      document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
  }
}else{
  onBridgeReady();
}
</script>