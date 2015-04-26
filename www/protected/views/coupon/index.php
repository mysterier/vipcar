<div class="account-right">
	<div class="account-search">
		<form class="form-inline">
			<div class="form-group ">
				<input id="coupon_code" type="text" class="form-control account-coupon-input" placeholder="请输入优惠券号码">
				<button id="getticket" type="button" class="btn btn-info">兑换优惠券</button>
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
			<li class="col-md-6 account-tab-hover">已使用优惠券</li>
			<li class="col-md-6">未使用优惠券</li>

		</ul>
	</div>
	<div class="clearfix"></div>

	<div class="account-container">
		<div>
			<table class="table table-hover">
				<thead>
                    <th>面值</th>
					<th>获取时间</th>					
					<th>使用时间</th>

				</thead>
				<tbody>
				<?php if($used):?>
				    <?php foreach ($used as $acp):?>
					<tr>
						<td><?php echo $acp->ticket->name;?> 元</td>
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
		<div class="loginhide">
			<table class="table table-hover">
				<thead>
                    <th>面值</th>
					<th>获取时间</th>					
					<th>过期时间</th>

				</thead>
				<tbody>
				<?php if($actived):?>
				    <?php foreach ($actived as $ucp):?>
					<tr>
						<td><?php echo $ucp->ticket->name;?> 元</td>
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

	</div>
</div>