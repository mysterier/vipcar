<div class="ddfukuan">
<?php if($status == ORDER_STATUS_END):?>
	<div class="ddimg pull-left">
		<img src="/img/iconfont-lltakeoutflowthirddisabled.png" width="70"
			height="70" alt="" />
	</div>
	<p class="text-muted">
		<strong>订单已完成</strong><br />谢谢您的支持
	</p>
<?php elseif($status == ORDER_STATUS_PAY):?>
<div class="ddimg pull-left"><img src="/img/iconfont-fukuan.png" width="70" height="70" alt=""/></div>
    <p class="text-muted"><strong>订单待付款</strong><br/>订单超过30天自动完成</p>
     <button id="wxpay" type="button" class="btn btn-success btn-block">付款</button>	
<?php else:?>
	<div class="ddimg pull-left"><img src="/img/iconfont-weiwancheng.png" width="70" height="70" alt=""/></div>
    <p class="text-muted"><strong>订单未完成</strong><br/>您的订单正在执行中</p>
<?php endif;?>
</div>
<?php if($status == ORDER_STATUS_PAY || $status == ORDER_STATUS_END):?>
<!-- 费用 -->
<div class="panel panel-default alltop">

	<div class="panel-heading">
		<strong>总计</strong><span class=" pull-right text-danger">￥<?php echo number_format($all_cost,'2','.',',');?></span>
	</div>

	<ul class="list-group">
		<li class="list-group-item text-muted">用车费<span
			class=" pull-right text-info ">￥<?php echo number_format(($all_cost-$packing_fee-$highway_fee),'2','.',',');?></span></li>
		<li class="list-group-item text-muted">停车费<span
			class=" pull-right text-info">￥<?php echo number_format($packing_fee,'2','.',',');?></span></li>
		<li class="list-group-item text-muted">过路费<span
			class=" pull-right text-info">￥<?php echo number_format($highway_fee,'2','.',',');?></span></li>
	</ul>
</div>
<?php endif;?>
<!-- 订单信息 -->
<div class="panel panel-default alltop">

	<div class="panel-heading">
		<strong>订单详情</strong>
	</div>
	<ul class="list-group">
		<li class="list-group-item text-muted listind">联系人：<span><?php echo $contacter_name;?></span></li>
		<li class="list-group-item text-muted">联系电话：<span><?php echo $contacter_mobile?></span></li>
		<?php if($flight_number):?>
		<li class="list-group-item text-muted listind">航班号：<span><?php echo $flight_number;?></span></li>
		<?php endif;?>
		<li class="list-group-item text-muted">上车时间：<span><?php echo $pickup_time;?></span></li>		
		<li class="list-group-item text-muted">上车地点：<span><?php echo $pickup_place;?></span></li>
		<li class="list-group-item text-muted">下车地点：<span><?php echo $drop_place;?></span></li>
		<li class="list-group-item text-muted">车型款式：
		<span>
		<?php
			switch($vehicle_type) {
				case VEHICLE_TYPE_COMFORTABLE:
					echo '舒适型';
					break;
				case VEHICLE_TYPE_BUSINESS:
					echo '商务型';
					break;
				case VEHICLE_TYPE_LUXURY:
					echo '豪华型';
					break;
			}
		?>
		</span></li>
		<li class="list-group-item text-muted">其他需求：<span><?php echo $summary;?></span></li>
	</ul>
</div>
<?php if($status == ORDER_STATUS_PAY):?>
<script type="text/javascript">
//调用微信JS api 支付
function jsApiCall()
{
	WeixinJSBridge.invoke(
		'getBrandWCPayRequest',
		<?php echo $jsApiParameters; ?>,
		function(res){
			WeixinJSBridge.log(res.err_msg);
			//alert(res.err_code+res.err_desc+res.err_msg);
		}
	);
}

$("#wxpay").click(function(){
	if (typeof WeixinJSBridge == "undefined"){
		if( document.addEventListener ){
			document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
		}else if (document.attachEvent){
			document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
			document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
		}
	}else{
		jsApiCall();
	}
});

</script>
<?php endif;?>