<div class="wrapper">
<?php if($actived): foreach($actived as $item):?>
	<div class="y-formgroup">
		<div class="yhq-bg">
			<h4>专车券</h4>
			<div class="y-content">
				<div class="y-left">
					<p>
						￥<span><?php echo $item->ticket->name;?></span>
					</p>
				</div>
				<div class="y-right">
					<h3>专车券「<?php echo $type[$item->coupon_type]?>专享」</h3>
					<p><?php echo date('Y-m-d', $item->expire);?>日到期</p>
				</div>
			</div>
		</div>
	</div>
<?php endforeach;else:?>
<h3 class="text-center grey-title">暂无优惠券</h3>
<?php endif;?>
</div>