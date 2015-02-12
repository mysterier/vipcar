
<!-- 订单信息 -->
<div class="panel panel-default alltop">

	<div class="panel-heading">
		<div>
			<strong>订单详情</strong>
		</div>
	</div>



	<ul class="list-group">
		<li class="list-group-item text-muted listind ">联系人：<span><?php echo $contacter_name; ?></span></li>
		<li class="list-group-item text-muted">联系电话：<span><?php echo $contacter_phone; ?></span></li>
		<li class="list-group-item text-muted">上车时间：<span><?php echo $pickup_time; ?></span></li>
		<li class="list-group-item text-muted">上车地点：<span><?php echo $pickup_place; ?></span></li>
		<li class="list-group-item text-muted">下车地点：<span><?php echo $drop_place; ?></span></li>
		<li class="list-group-item text-muted">车型款式：
		<span>
		<?php 
		      switch ($vehicle_type) {
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
		</span>
		</li>
		<li class="list-group-item text-muted">其他需求：<span><?php echo $summary; ?></span></li>


	</ul>

</div>
<h4 class=" text-center allmargin">
	预付款:<span class="text-danger allsizelg allpadding"><?php echo $estimated_cost ?></span>元
</h4>
<button id="wxpay" type="button" class="btn btn-primary btn-lg btn-block">确认付款</button>
<script type="text/javascript">
//调用微信JS api 支付
function jsApiCall()
{
	WeixinJSBridge.invoke(
		'getBrandWCPayRequest',
		<?php echo $jsApiParameters; ?>,
		function(res){
			//WeixinJSBridge.log(res.err_msg);
			if (res.err_msg == "get_brand_wcpay_request:ok") {
				window.location.href='/order/success';
			}
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