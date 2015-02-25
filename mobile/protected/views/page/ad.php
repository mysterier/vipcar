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
wx.config({
    debug: true,
    appId: '<?php echo $signPackage["appId"];?>',
    timestamp: <?php echo $signPackage["timestamp"];?>,
    nonceStr: '<?php echo $signPackage["nonceStr"];?>',
    signature: '<?php echo $signPackage["signature"];?>',
    jsApiList: [
      // 所有要调用的 API 都要加到这个列表中
	  'onMenuShareTimeline',
	  'onMenuShareAppMessage'
    ]
  });
  wx.ready(function () {
    wx.onMenuShareTimeline({
    title: 'xxx', // 分享标题
    link: '', // 分享链接
    imgUrl: '', // 分享图标
    success: function () { 
        // 用户确认分享后执行的回调函数
		alert(123);
    },
    cancel: function () { 
        // 用户取消分享后执行的回调函数
		alert(321);
    }
});
  });
</script>