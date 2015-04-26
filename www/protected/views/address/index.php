<div class="account-right-head">
	<h3>常用地址</h3>
</div>

<div class="account-container">
	<div>
		<table class="table table-hover">
			<thead>
				<th>联系人</th>
				<th>联系电话</th>
				<th>详细地址</th>
				<th>操作</th>

			</thead>
			<tbody>
			<?php if($model):?>
			    <?php foreach ($model as $address):?>
				<tr>
					<td><?php echo $address->contacter_name;?></td>
					<td><?php echo $address->contacter_mobile;?></td>
					<td><?php echo $address->address_info;?></td>
					<td>/</td>
				</tr>
				<?php endforeach;?>
		    <?php else:?>
		        <tr>
					<td>未找到数据</td>
				</tr>
			<?php endif;?>
			</tbody>
		</table>
	</div>
</div>
<div>
	<a href="#" class="btn btn-info btn-color marginright">新增常用地址</a>
</div>

</div>