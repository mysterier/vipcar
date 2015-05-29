<div class="account-search">
	<form class="form-inline" method="get" action="/order/index">
		<div class="form-group">
			<label for="from">预定时间</label>
				<?php
    $this->widget('zii.widgets.jui.CJuiDatePicker', [
        'language' => 'zh_cn',
        'name' => 'from',
        'value' => $this->getParam('from'),
        'options' => [
            'showAnim' => 'fold',
            'minDate' => '-1 m',
            'dateFormat' => 'yy-mm-dd',
            'onClose' => 'function( selectedDate ) {
                $("#to").datepicker( "option", "minDate", selectedDate );
            }'
        ],
        'htmlOptions' => [
            'class' => 'form-control',
            'placeholder' => Date('Y-m-d'),
            'readonly' => 'readonly'
        ]
    ]);
    ?>
				
				<label for="to">至</label>					
					<?php
    $this->widget('zii.widgets.jui.CJuiDatePicker', [
        'language' => 'zh_cn',
        'name' => 'to',
        'value' => $this->getParam('to'),
        'options' => [
            'showAnim' => 'fold',
            'maxDate' => '+1 m',
            'dateFormat' => 'yy-mm-dd',
            'onClose' => 'function( selectedDate ) {
                $("#from").datepicker( "option", "maxDate", selectedDate );
            }'
        ],
        'htmlOptions' => [
            'class' => 'form-control',
            'placeholder' => Date('Y-m-d'),
            'readonly' => 'readonly'
        ]
    ]);
    ?> 
			</div>
		<div class="form-group">
			<label for="exampleInputPassword3">订单类型</label> <select
				class="form-control" name="status">
				<option value="" <?php if ($status == '') echo 'selected';?>>全部</option>
				<option value="0" <?php if ($status == '0') echo 'selected';?>>未分配</option>
				<option value="1" <?php if ($status == '1') echo 'selected';?>>已分配</option>
				<option value="2" <?php if ($status == '2') echo 'selected';?>>服务中</option>
				<option value="6" <?php if ($status == '6') echo 'selected';?>>已完成</option>
			</select>
		</div>

		<button type="submit" class="btn btn-info all-btn-color">搜索</button>

	</form>

</div>
<div class="account-tab account-bill-tab">
	<ul nav nav-tabs>
		<a href="/order/index"><li
			class="<?php if ($status == '') echo 'account-tab-hover';?>">全部</li></a>
		<a href="/order/index?status=0"><li
			class="<?php if ($status == '0') echo 'account-tab-hover';?>">待分配</li></a>
		<a href="/order/index?status=1"><li
			class="<?php if ($status == '1') echo 'account-tab-hover';?>">已分配</li></a>
		<a href="/order/index?status=2"><li
			class="<?php if ($status == '2') echo 'account-tab-hover';?>">服务中</li></a>
		<a href="/order/index?status=6"><li
			class="<?php if ($status == '6') echo 'account-tab-hover';?>">已完成</li></a>
	</ul>
</div>
<div class="clearfix"></div>

<div class="account-container">
	<div>
		<table class="table table-hover ">
			<thead>
				<th class="table-width100">订单号</th>
				<th class="table-width80">订单类型</th>
				<th class="table-width80">服务类型</th>
				<th class="table-width60">联系人</th>
				<th class="table-width100">上车时间</th>
				<th class="table-width120">出发地</th>
				<th class="table-width120">目的地</th>
				<?php if ($status == '0' || $status == '1' || $status == '2'): ?>
				<th >操作</th>
				<?php endif;?>
			</thead>
			<tbody>
			<?php if ($model):?>
			    <?php foreach($model as $order):?>
				<tr>
					<td><?php echo $order->order_no;?></td>
					<td><?php echo $this->formatType($order->type)?></td>
					<td><?php echo $this->formatService($order->vehicle_type)?></td>
					<td><?php echo $order->contacter_name;?></td>
					<td><?php echo $order->pickup_time;?></td>
					<td><?php echo $order->pickup_place;?></td>
					<td><?php echo $order->drop_place;?></td>
					<?php if ($status == '0' || $status == '1' || $status == '2'): ?>
					<td><a href="#" class="cancel" order_id="<?php echo $order->id;?>">取消</a></td>
					<?php endif;?>
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
<div>
    	<?php
    $this->widget('CLinkPager', [
        'header' => '',
        'pages' => $pages,
        'maxButtonCount' => 5,
        'firstPageLabel' => '首页',
        'lastPageLabel' => '末页'
    ]);
    ?>
</div>
<script>
$(function(){
	$(".cancel").click(function(){
		if(window.confirm( '您确定要取消订单么？')) {
			tr = $(this).parents("tr");
			id = $(this).attr("order_id");
 
			//取消已分配订单
			$.post('/jsonp/cancelorder', {'id':id, 'confirm':1}, function(data){
			    if (data.error_code == 0) {
			    	tr.remove();
				}
			    //已分配且上车时间和当前时间小于2小时
				if (data.error_code == 1) {
					if(window.confirm( '取消该笔订单需要收取空驶费（20%的价钱）')) {
						$.post('/jsonp/cancelorder', {'id':id, 'confirm':0}, function(data){
							if (data.error_code == 0) {
						    	tr.remove();
							}
						},'json');
					}
				}	    	
			},'json');
					
		}
	});
});
</script>