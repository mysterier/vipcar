<!--标题栏-->
<!--         <div>
            <div class="text-center col-xs-offset-2 col-xs-4 btn brown-btn">
                进行中
            </div>
            <div class="text-center col-xs-4 brown-border-btn">
                已完成
            </div>            
        </div> -->

<div class="btn-group btn-group-justified" role="group" aria-label="...">
	<div class="btn-group" role="group">
		<a id="running" class="btn brown-btn">进行中</a>
	</div>

	<div class="btn-group" role="group">
		<a id="finished" class="btn brown-border-btn">已完成</a>
	</div>
</div>

<!--页面-->
<?php 
if($orders):
	foreach($orders as $order):
?>
<a href="/order/detail/<?php echo $order->id . (($order->status==ORDER_STATUS_PAY) ? '?showwxpaytitle=1' : '');?>" class="alllist btn btn-default <?php echo ($order->status==ORDER_STATUS_END) ? 'finished' : 'running';?>">
	<div class="onelist">
		<div class="leixin pull-left <?php echo ($order->type==ORDER_TYPE_AIRPORTPICKUP) ? 'bg-primary' : 'bg-airportsend';?>">
			<?php echo ($order->type==ORDER_TYPE_AIRPORTPICKUP) ? '接机' : '送机';?>
		</div>
		<div class="paizhao pull-left"><?php echo ($order->driver) ? $order->driver->vehicle[0]->license_no : '&nbsp;';?></div>
		<div class="ddpadd"><?php echo ($order->driver) ? $order->driver->name : '&nbsp;';?></div>
	</div>
	<div class="twolist">
		<div class="ddicon pull-left">起点：</div>
		<div class="ddpadd text-left"><?php echo $order->pickup_place;?></div>
	</div>
	<div class="threelist">
		<div class="ddicon pull-left">终点：</div>
		<div class="ddpadd text-left"><?php echo $order->drop_place;?></div>
	</div>
	<div class="fourlist">
		<?php
			switch($order->status) {
				case ORDER_STATUS_NOT_DISTRIBUTE:
					echo '<div class="ddicon pull-left text-muted">未分配</div>';
					break;
				case ORDER_STATUS_DISTRIBUTE:
					echo '<div class="ddicon pull-left text-primary">已分配</div>';
					break;
				case ORDER_STATUS_RUN:
					echo '<div class="ddicon pull-left text-warning">执行中</div>';
					break;
				case ORDER_STATUS_END:
					echo '<div class="ddicon pull-left text-success">已完成</div>';
					break;
				case ORDER_STATUS_PAY:
					echo '<div class="ddicon pull-left text-danger">待付款</div>';
					break;
			}
		?>
		<div class="ddpadd text-right"><?php echo ($order->status==ORDER_STATUS_END) ? date('Y-m-d H:i:s', $order->last_update) : $order->created;?></div>
	</div>
</a>
<?php
	endforeach;
endif;
?>
<script>
$(function(){
	$(".finished").hide();
});

$("#running").click(function(){
	$("#finished").removeClass("brown-btn").addClass("brown-border-btn");
	$(this).removeClass("brown-border-btn").addClass("brown-btn");
	// $("#finished").removeClass("brown-btn").addClass("btn-default");
	// $(this).removeClass("btn-default").addClass("brown-btn");
	$(".running").show();
	$(".finished").hide();
});

$("#finished").click(function(){
	$("#running").removeClass("brown-btn").addClass("brown-border-btn");
	$(this).removeClass("brown-border-btn").addClass("brown-btn");
	// $("#running").removeClass("brown-btn").addClass("btn-default");
	// $(this).removeClass("btn-default").addClass("brown-btn");
	$(".finished").show();
	$(".running").hide();
});
</script>