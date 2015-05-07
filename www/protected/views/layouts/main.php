<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="/css/mystyle.css"/>
<?php if($this->id == 'favorite'):?>
<link rel="stylesheet" type="text/css" href="/css/account-like.css"/>
<?php endif;?>
<script type="text/javascript" src="/js/jquery-1.11.2.js"></script>
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
		<a href="/" id="logo"></a>
			<ul class="header-nav">
				<li class="header-topnav"><a href="/order/index">我的账户</a></li>
				<li class="header-topnav"><a href="#">客户端下载</a></li>
				<li class="header-topnav"><a href="#">关注众择</a></li>
				<li class="header-topnav"><a href="/notice">众择公告</a></li>
				<?php if(Yii::app()->user->isGuest):?>
				<li class="header-topnav"><a href="/login">登录</a></li>
				<li class="header-topnav"><a href="/register">注册</a></li>
				<?php else:?>
				<li class="header-topnav"><a href="/login"><?php echo Yii::app()->user->name;?></a></li>
				<li class="header-topnav"><a href="/logout">[退出]</a></li>				
				<?php endif;?>
				<li class="header-topnav header-tel"><span class="icon-tel"><img src="/img/icon-phone.png" /></span>400-684-5505</li>
			</ul>
		</div>
	</div>
	<!--导航-->
	<div id="nav">
		<div class="nav-container">
			<ul class="main-nav">
				<li class="nav-topnav"><a href="/">首页</a></li>
				<li class="nav-topnav"><a <?php if($this->id == 'home' && $this->action->id == 'service') echo 'class="nav-active"';?> href="/service">服务介绍</a></li>
				<li class="nav-topnav"><a <?php if($this->id == 'order' && $this->action->id == 'service') echo 'class="nav-active"';?> href="#">在线订车</a></li>
				<li class="nav-topnav"><a <?php if($this->id == 'home' && $this->action->id == 'event') echo 'class="nav-active"';?> href="/event">活动优惠</a></li>
				<li class="nav-topnav"><a <?php if($this->id == 'enterprise' && $this->action->id == 'show') echo 'class="nav-active"';?> href="/enterprise/show">企业用户</a></li>
				<li class="nav-topnav nav-left"><a <?php if($this->id == 'home' && $this->action->id == 'magazine') echo 'class="nav-active"';?> href="/magazine">众择杂志</a></li>
			</ul>
		</div>
	</div>
<?php echo $content; ?>
<!--footer-->
	<div class="footer">
		<div class="footer-container">
			<div class="footer-left">
				<div class="footer-logo">
					<img src="/img/footerlogo.png" />
				</div>
				<p class="service-tel">
					客服电话:<span>400-684-5505</span>
				</p>
			</div>
			<div class="footer-right">
				<ul>
					<li><h5>关于众择</h5></li>
					<li><a href="#">关于众择</a></li>
					<li><a href="#">品牌文化</a></li>
					<li><a href="#">招聘信息</a></li>
					<li><a href="#">联系我们</a></li>
				</ul>
				<ul>
					<li><h5>帮助中心</h5></li>
					<li><a href="#">支付说明</a></li>
					<li><a href="#">常见问题</a></li>
					<li><a href="#">注册及使用使用流程</a></li>
				</ul>
				<ul>
					<li><h5>合作伙伴</h5></li>
					<li><img src="/img/xiechenglogo.png" /></li>
					<li><img src="/img/subao-logo.png" /></li>

				</ul>
			</div>
			<div class="clearfix"></div>
		</div>

	</div>

	<div class="footer-bottom">
		<div class="footer-link">
			<p>友情链接</p>
			<ul>
				<li><a href="#">携程旅游</a></li>
				<li><a href="#">苏宝租车</a></li>
				<li><a href="#">携程旅游</a></li>
				<li><a href="#">苏宝租车</a></li>
				<li><a href="#">携程旅游</a></li>
				<li><a href="#">苏宝租车</a></li>
			</ul>
		</div>

	</div>
	<div class="clearfix"></div>
	<p class="text-center">Copyright © 2014 ZHONGZE All Rights Reserved.
		备案号：沪ICP备14053943号-1。</p>
</body>
</html>
