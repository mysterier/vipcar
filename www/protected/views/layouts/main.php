<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css"/>
<script type="text/javascript" src="/js/jquery-1.11.2.js"></script>
<?php if($this->id == 'order' && ($this->action->id == 'pickup'||$this->action->id == 'send')):?>
<link rel="stylesheet" type="text/css" href="/fonts/iconfont.css">
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=xKTm9GM58nRtGkBATG6jGwui"></script>
<script type="text/javascript" src="/js/bootstrap.min.js"></script>



<?php endif;?>
<link rel="stylesheet" type="text/css" href="/css/mystyle.css"/>
<?php if($this->id == 'favorite'):?>
<link rel="stylesheet" type="text/css" href="/css/account-like.css"/>
<?php endif;?>
<script type="text/javascript" src="/js/jquery.immersive-slider.js"></script>
<link rel="stylesheet" type="text/css" href="/css/immersive-slider.css">
<script type="text/javascript" src="/js/myjs.js"></script>
<?php if($this->id == 'order' && $this->action->id == 'comment'):?>
<script type="text/javascript" src="/js/star.js"></script>
<?php endif;?>
<?php if($this->id == 'client'):?>
<script type="text/javascript" src="/js/ajaxfileupload.js"></script>
<?php endif;?>
<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
	<!--页眉-->
	<div id="header">
		<div class="wrapper-width" id="header-container">
		<a href="/" id="logo"><img src="/img/logo.png"></a>
			<ul class="header-nav">
				<li class="header-topnav"><a href="/order/index">我的账户</a></li>
				<li class="header-topnav"><a href="/appdown">客户端下载</a></li>
				<li class="header-topnav"><a href="/attention">关注众择</a></li>
				<li class="header-topnav"><a href="/notice">众择公告</a></li>
				<?php if(Yii::app()->user->isGuest):?>
				<li class="header-topnav"><a href="/login">登录</a></li>
				<li class="header-topnav"><a href="/register">注册</a></li>
				<?php else:?>
				<li class="header-topnav"><a href="/order/index"><?php echo Yii::app()->user->name;?></a></li>
				<li class="header-topnav"><a href="/logout">[退出]</a></li>				
				<?php endif;?>
				<li class="header-topnav header-tel"><span class="icon-tel"><img src="/img/icon-phone.png" /></span>400-965-2886</li>
			</ul>
		</div>
	</div>
	<!--导航-->
	<div id="nav">
		<div class="nav-container">
			<ul class="main-nav">
				<li class="nav-topnav"><a href="/">首页</a></li>
				<li class="nav-topnav"><a <?php if($this->id == 'home' && $this->action->id == 'service') echo 'class="nav-active"';?> href="/service">服务介绍</a></li>
				<li class="nav-topnav"><a <?php if($this->id == 'order' && ($this->action->id == 'pickup'||$this->action->id == 'send')) echo 'class="nav-active"';?> href="/order/pickup">在线订车</a></li>
				<li class="nav-topnav"><a <?php if($this->id == 'home' && $this->action->id == 'event') echo 'class="nav-active"';?> href="/event">活动优惠</a></li>
                <li class="nav-topnav nav-left"><a <?php if($this->id == 'home' && $this->action->id == 'magazine') echo 'class="nav-active"';?> href="/magazine">聚焦论谈</a></li>
				<li class="nav-topnav"><a <?php if($this->id == 'enterprise' && $this->action->id == 'show') echo 'class="nav-active"';?> href="/enterprise/show">企业用户</a></li>
			</ul>
		</div>
	</div>
<?php echo $content; ?>
<!--footer-->
<div class="footer">
    <div class="footer-container">
        <div class="footer-left">
            <div class="footer-logo"><img src="/img/footerlogo.png" /></div>
            <div class="service-tel">
                <span>400-965-2886</span>
            </div>
            </div>
        <div class="footer-right">
            <ul>
                <li><h5>关于众择</h5></li>
                <li><a href="/about" >关于众择</a></li>
                <li><a href="/culture" >众择文化</a></li>
                <li><a href="/services" >众择服务</a></li>        
                <li><a href="/jobs" >招聘信息</a></li>
                <li><a href="/contact" >联系我们</a></li>
            </ul>
            <ul>
                <li><h5>帮助中心</h5></li>
                <li><a href="/help/login" >首次使用</a></li>
             <!--    <li><a href="/help/webpay" >如何支付</a></li> -->
                <li><a href="/help/car" >用车帮助</a></li>
                <li><a href="/help/service" >车辆服务</a></li>
               <!--  <li><a href="/help/order" >查看/取消订单</a></li> -->
                <li><a href="/help/faq" >常见问题</a></li>
            </ul>
            <ul>
                <li><h5 class="text-center">众择用车官方微信</h5></li>
                <li><img class="img-border" src="/images/index/weixing-code.jpg" /></li>
            </ul>   
            <ul>
                <li><h5 class="text-center">众择用车官方微博</h5></li>
                <li><img class="img-border" src="/images/index/weibo-code.jpg" /></li>
            </ul>           
        </div>
        <div class=" clearfix" ></div>
    </div>  
</div>
<div class="footer-bottom">
    <div class="footer-link">
    <h5>合作伙伴</h5>
    <ul>
        <li><a href="http://www.ctrip.com" target="_blank">携程旅游</a></li>
        <li><a href="http://www.subaozuche.com/" target="_blank">苏宝租车</a></li>
    </ul>
    </div>    
</div>
<div class="copyright">
    Copyright © 2014 ZHONGZE All Rights Reserved. 备案号：沪ICP备14053943号-1
</div>
<!-- vip-car.com.cn Baidu tongji analytics -->
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?fefc1705270abb0dfc8d996218efe2a3";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>
</body>
</html>
