<?php $this->beginContent('//layouts/main'); ?>
<div class="wrapper-width paddingfifty">
<div class="list-group col-md-3">
	<a class="list-group-item disabled cursor-txt">首次使用</a> 
	<a href="/help/login" class="list-group-item <?php if($this->action->id == 'login') echo 'active';?>">注册登录</a> 
	<a href="/help/password" class="list-group-item <?php if($this->action->id == 'password') echo 'active';?>">找回密码</a>
<!-- 	<a class="list-group-item disabled cursor-txt">如何支付</a>  -->
<!-- 	<a href="/help/webpay" class="list-group-item <?php if($this->action->id == 'webpay') echo 'active';?>">在线支付</a> -->
<!-- 	<a href="/help/apppay" class="list-group-item <?php if($this->action->id == 'apppay') echo 'active';?>">手机app支付</a> --> 
	<a class="list-group-item disabled cursor-txt">用车帮助</a> 
	<a href="/help/car" class="list-group-item <?php if($this->action->id == 'car') echo 'active';?>">如何订车</a> 
	<a href="/help/billing" class="list-group-item <?php if($this->action->id == 'billing') echo 'active';?>">计费标准</a> 
	<a href="/help/service" class="list-group-item <?php if($this->action->id == 'service') echo 'active';?>">车辆服务</a> 
<!-- 	<a href="/help/order" class="list-group-item <?php if($this->action->id == 'order') echo 'active';?>">查看/取消订单</a>  -->
	<a href="/help/faq" class="list-group-item <?php if($this->action->id == 'faq') echo 'active';?>">常见问题</a>
</div>
	<div class="about-right col-md-9">
	<?php echo $content; ?>
	</div>
	<div class="clearfix"></div>
</div>
<?php $this->endContent(); ?>