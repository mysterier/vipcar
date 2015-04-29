<link rel="stylesheet" type="text/css" href="/css/star.css"/>
<div class="account-tab">
	<ul>
		<a href="/order/comment?status=0"><li class="col-md-6 <?php if (!$status) echo 'account-tab-hover';?>">
		待评价订单
		</li></a>
		<a href="/order/comment?status=1"><li class="col-md-6 <?php if ($status) echo 'account-tab-hover';?>">
		已评价订单
		</li></a>

	</ul>
</div>
<div class="clearfix"></div>
<div class="account-container">
	<div>
		<table class="table table-hover">
			<thead>
				<th>订单号</th>
				<th>订单类型</th>
				<th>服务类型</th>
				<th>联系人</th>
				<th>上车时间</th>
				<th>星评</th>
			</thead>
			<tbody>
				<?php if ($model):?>
				    <?php foreach($model as $order):?>
					<tr>
					<td><?php echo $order->order_no;?></td>
					<td><?php echo Yii::app()->controller->formatType($order->type)?></td>
					<td><?php echo Yii::app()->controller->formatService($order->vehicle_type)?></td>
					<td><?php echo $order->contacter_name;?></td>
					<td><?php echo $order->pickup_time;?></td>
					<td>
					  <ul class="rev_pro xin-clearfix">
                        <li>                   
                          <div class="revinp" status="<?php echo $status;?>" order_id="<?php echo $order->id;?>">
                            <span class="level">
                              <i class="<?php echo ($order->star > 0) ? 'level_solid' : 'level_hollow' ;?>" cjmark=""></i>
                              <i class="<?php echo ($order->star > 1) ? 'level_solid' : 'level_hollow' ;?>" cjmark=""></i>
                              <i class="<?php echo ($order->star > 2) ? 'level_solid' : 'level_hollow' ;?>" cjmark=""></i>
                              <i class="<?php echo ($order->star > 3) ? 'level_solid' : 'level_hollow' ;?>" cjmark=""></i>
                              <i class="<?php echo ($order->star > 4) ? 'level_solid' : 'level_hollow' ;?>" cjmark=""></i>
                            </span>
                          </div>
                        </li>
                       </ul>
					</td>
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
