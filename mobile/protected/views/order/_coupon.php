<?php if ($coupons):?>
<!--优惠券-->
<a href="#" style="text-align: left;" class="btn btn-default btn-block"
	data-toggle="modal" data-target="#youhuiquan" type="button"><span class="pull-right text-muted positionright">您目前有<span
		class="text-danger allpadding"><?php echo count($coupons);?></span>张优惠券</span> <span class="text-left">优惠券</span>
</a>
<!-- Modal -->
<div class="modal fade" id="youhuiquan" tabindex="-1" role="dialog"
	aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">我的优惠券</h4>
			</div>
			<div class="modal-body">
				<!--content-->
				<div class="container-fluid">
				<?php foreach($coupons as $coupon):?>
					<div class="bgcolor text-right mycoupon" data-dismiss="modal" coupon_id="<?php echo $coupon->id;?>" coupon_cost="<?php echo $coupon->value;?>">
						<div>
							<p class="logo-left">
								<img src="/img/50.png" width="50" height="50">
							</p>
							<strong><?php echo $coupon->value;?>元优惠券</strong>
						</div>
					</div>
				<?php endforeach;?>
				</div>
			</div>
			<div class="modal-footer">
				<button id="nouse" type="button" class="btn btn-default" data-dismiss="modal">不使用优惠券</button>
			</div>
		</div>
	</div>
</div>
<input id="coupon_id" type="hidden" name="coupon_id" value="" />
<script>
$(".mycoupon").click(function(){
	var coupon_id = $(this).attr("coupon_id");
	var coupon_cost = $(this).attr("coupon_cost");
	var income = getIncome()-coupon_cost;
	$("#coupon_id").val(coupon_id);
	$(".rmb").text(income);
	$("#estimated_cost").val(income);
	$(".positionright").html('已选择<span class="text-danger allpadding">'+coupon_cost+'</span>元优惠券');
});
$("#nouse").click(function(){
	$("#coupon_id").val('');
	$(".positionright").html('您目前有<span class="text-danger allpadding"><?php echo count($coupons);?></span>张优惠券');
	$(".rmb").text(income);
	$("#estimated_cost").val(income);
});
</script>
<?php endif;?>