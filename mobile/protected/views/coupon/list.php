<?php foreach($coupons as $coupon):?>
<div class="bgcolor text-right">
	<div>
		<p class="logo-left">
			<img src="/img/<?php echo $coupon->value;?>.png" width="50" height="50">
		</p>
		<strong><?php echo $coupon->value;?>元优惠券</strong>
	</div>
</div>
<?php endforeach;?>