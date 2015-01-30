<form method="post" action="/order/process/<?php echo ORDER_TYPE_AIRPORTSEND;?>">
	<div style="margin-top: 1em;" class="form-group">
		<div class="input-group">
			<div class="input-group-addon iconfont">&#xf0053;</div>
			<input type="text" class="form-control" id="user" placeholder="联系人"
				name="contacter_name">
		</div>
	</div>

	<div class="form-group">
		<div class="input-group">
			<div class="input-group-addon iconfont">&#xe64a;</div>
			<input type="tel" class="form-control" id="tel" placeholder="联系电话" name="contacter_phone">
		</div>
	</div>



	<div class="form-group">
		<div class="input-group">
			<div class="input-group-addon iconfont">&#xe738;</div>
			<input type="datetime" class="form-control" id="datetimepicker"
				placeholder="上车时间" name="pickup_time">

		</div>
	</div>

	<div class="form-group">
		<div class="input-group">
			<div class="input-group-addon iconfont">&#xe606;</div>
			<input type="text" class="form-control" id="addressup"
				placeholder="上车地点" name="pickup_place">
		</div>
	</div>

	<div class="form-group">
		<div class="input-group">
			<div class="input-group-addon iconfont">&#xe622;</div>
			<select id="terminal" class="form-control" name="drop_place">
				<optgroup label="航站楼"></optgroup>
				<option value="虹桥国际机场T1">虹桥国际机场T1</option>
				<option value="虹桥国际机场T2">虹桥国际机场T2</option>
				<option value="浦东国际机场T1">浦东国际机场T1</option>
				<option value="浦东国际机场T2">浦东国际机场T2</option>
			</select>
		</div>
	</div>



	<div class="form-group">

		<div class="input-group">

			<div class="input-group-addon iconfont">&#xe603;</div>
			<select id="vehicle_type" class="form-control" name="vehicle_type">
				<optgroup label="车型选择"></optgroup>
				<option value="2">舒适性</option>
				<option value="3">商务型</option>
				<option value="4">豪华型</option>
			</select>
		</div>
	</div>

	<div class="form-group">
		<label for="exampleInputFile">是否往返</label>
		<div style="width: 100%;" class="input-group">


			<select class="form-control" name="is_round_trip">
				<option value="0">否</option>
				<option value="1">是</option>
			</select>
		</div>
	</div>
	<textarea style="width: 100%;" class="form-group" rows="3"
		placeholder="其他需求" name="summary"></textarea>

	<label style="float: right;">价格<span class="rmb">0</span>元
	<input type="hidden" name="estimated_cost" id="estimated_cost">
	</label>
<?php include '_protocol.php';?>
</form>

<script>

</script>