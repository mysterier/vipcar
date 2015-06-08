<div class="account-search">
	<form class="form-inline">
		<div class="form-group ">
			<input id="coupon_code" type="text"
				class="form-control account-coupon-input" placeholder="请输入优惠券号码">
			<button id="getticket" type="button" class="btn btn-coupon all-btn-color">兑换优惠券</button>
		</div>
	</form>

	<script>
		   $("#getticket").click(function(){
			   var coupon_code = $("#coupon_code").val();
			   $.post('/coupon/getticket', {'coupon_code':coupon_code}, function(data){
				        alert(data); 
				        window.location.href="/coupon/index";
				   });
			 });	   
		</script>
</div>
<div class="account-tab">
	<ul>
		<li class="col-md-6 account-tab-hover">未使用优惠券</li>
		<li class="col-md-6">已使用优惠券</li>

	</ul>
</div>
<div class="clearfix"></div>
<?php 
    $scope = [
        COUPON_COMMON => '通用',
        COUPON_PICKUP => '接机可用',
        COUPON_COMFORTABLE_PICKUP => '舒适型接机可用',
        COUPON_BUSINESS_PICKUP => '商务型接机可用',
        COUPON_LUXURY_PICKUP => '豪华型接机可用',
        COUPON_SEND => '送机可用',
        COUPON_COMFORTABLE_SEND => '舒适型送机可用',
        COUPON_BUSINESS_SEND => '商务型送机可用',
        COUPON_LUXURY_SEND => '豪华型送机可用'
    ];
?>
<div class="account-container">
	<div>
		<table class="table table-hover">
			<thead>
				<th>面值</th>
				<th>适用范围</th>
				<th>获取时间</th>
				<th>使用时间</th>
			</thead>
			<tbody>
				<?php if($actived):?>
				    <?php foreach ($actived as $ucp):?>
					<tr>
					<td><?php echo $ucp->ticket->name;?> 元</td>
					<td><?php echo $scope[$ucp->coupon_type];?></td>
					<td><?php echo $ucp->created;?></td>
					<td><?php echo date('Y-m-d H:i:s', $ucp->expire);?></td>
				</tr>
					<?php endforeach;?>
				<?php else:?>
				    <tr>
					<td>无相关数据</td>
				</tr>
				<?php endif;?>
			</tbody>
			
		</table>
	</div>
	<div class="loginhide">
		<table class="table table-hover">
			<thead>
				<th>面值</th>
				<th>适用范围</th>
				<th>获取时间</th>
				<th>过期时间</th>
			</thead>
			<tbody>
				<?php if($used):?>
				    <?php foreach ($used as $acp):?>
					<tr>
					<td><?php echo $acp->ticket->name;?> 元</td>
					<td><?php echo $scope[$acp->coupon_type];?></td>
					<td><?php echo $acp->created;?></td>
					<td><?php echo date('Y-m-d H:i:s', $acp->last_update);?></td>
				</tr>
					<?php endforeach;?>
				<?php else:?>
				    <tr>
					<td>无相关数据</td>
				</tr>
				<?php endif;?>
			</tbody>
		</table>
	</div>
</div>
