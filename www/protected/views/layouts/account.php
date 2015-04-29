<?php $this->beginContent('//layouts/main'); ?>
<div class="account">
	<div class="account-left">
		<h3>我的账户</h3>
		<ul>
			<li><a <?php echo ($this->id == 'order' && $this->action->id == 'index') ? 'class="account-left-select" href="#"' : 'href="/order/index"';?>>我的订单</a> <span></span></li>
			<li><a href="/account-balance.html">余额和充值</a><span></span></li>
			<li><a <?php echo $this->id == 'coupon' ? 'class="account-left-select" href="#"' : 'href="/coupon/index"';?>>我的优惠券</a><span></span></li>
			<li></li>
			<li><a <?php echo ($this->id == 'client' && $this->action->id == 'edit' )? 'class="account-left-select" href="#"' : 'href="/client/edit"';?>>个人资料</a><span></span></li>
			<li><a <?php echo $this->id == 'address' ? 'class="account-left-select" href="#"' : 'href="/address/index"';?>>常用地址</a><span></span></li>
			<li><a href="/account-invoice.html">发票管理</a><span></span></li>
			<li><a href="/account-like.html">我的喜好</a><span></span></li>
			<li><a <?php echo ($this->id == 'client' && $this->action->id == 'editpwd' )? 'class="account-left-select" href="#"' : 'href="/client/editpwd"';?>>修改密码</a><span></span></li>
			<li></li>
			<li><a <?php echo ($this->id == 'order' && $this->action->id == 'comment') ? 'class="account-left-select" href="#"' : 'href="/order/comment"';?>>服务评价</a><span></span></li>
		</ul>
	</div>
	<div class="account-right">
	<?php echo $content; ?>
	</div>
	<div class="clearfix"></div> 
</div>
<?php $this->endContent(); ?>