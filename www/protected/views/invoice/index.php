<div class="account-right-head">
	<div class="pull-left">
		可开发票：<span><?php echo $available_invoice_amount;?>元</span>
	</div>
	<a href="/invoice/new" class="btn pull-right all-btn-color">我要开票</a>
	<div class="clearfix"></div>
	<h3>开票记录</h3>
</div>

<div class="account-container">
	<table class="table table-hover ">
		<thead>
			<th>发票抬头</th>
			<th>收件人</th>
			<th>开票金额</th>
			<th>申请时间</th>
		</thead>
		<tbody>
		<?php foreach ($model as $item):?>
			<tr>
				<td><?php echo $item->invoice_title;?></td>
				<td><?php echo $item->contacter_name;?></td>
				<td><?php echo $item->invoice_amount;?></td>
				<td><?php echo $item->created;?></td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
</div>