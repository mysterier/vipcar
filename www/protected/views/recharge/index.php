<div class="balance-money">
	<div>
		账户余额<span><?php echo $balance ? $balance : 0;?></span>元
	</div>
	<a href="/recharge/cash" class="btn btn-info btn-color all-btn-color">充值</a>
</div>
<div class="account-record">
	<form class="form-inline">
		<div class="form-inline accound-record-head">
			<label>交易记录查询</label>
		</div>
		<br />

		<div class="form-group">
			<label for="exampleInputEmail3">预定时间</label> <input type="datetime"
				class="form-control" id="exampleInputEmail3"
				placeholder="2015-10-10"> <label for="exampleInputEmail3">至</label>
			<input type="datetime" class="form-control" id="exampleInputEmail3"
				placeholder="2015-10-11">
		</div>


		<button type="submit" class="btn btn-info all-btn-color">查询</button>

	</form>

</div>

<div class="account-container">
	<div>
		<table class="table table-hover">
			<thead>

				<th>流水号</th>
				<th>充值时间</th>
				<th>金额（元）</th>
				<th>充值状态</th>
			</thead>
			<tbody>
			<?php if($model):?>
			    <?php foreach ($model as $item):?>
				<tr>
					<td><?php echo $item->recharge_no;?></td>
					<td><?php echo $item->created;?></td>
					<td><?php echo $item->amount;?></td>
					<td><?php echo ($item->status == 1) ? '成功' : '未成功';?></td>
				</tr>
				<?php endforeach;?>
            <?php else:?>
                <tr>
					<td>未找到相关数据！</td>
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
