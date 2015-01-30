<form method="post" action="/order/process/<?php echo ORDER_TYPE_AIRPORTPICKUP;?>">
<div style="margin-top: 1em;" class="form-group">
	<div class="input-group">
		<div class="input-group-addon iconfont">&#xf0053;</div>
		<input type="text" class="form-control" id="user_j" placeholder="联系人" name="contacter_name" value="<?php echo $contacter_name;?>">
	</div>
</div>

<div class="form-group">
	<div class="input-group">
		<div class="input-group-addon iconfont">&#xe64a;</div>
		<input type="tel" class="form-control" id="tel_j" placeholder="联系电话" name="contacter_phone" value="<?php echo $contacter_phone;?>">
	</div>
</div>

<div class="form-group">
	<div class="input-group">
		<div class="input-group-addon iconfont">&#xe630;</div>
		<input type="text"
			class="form-control" id="hangban_j" placeholder="航班号" name="flight_number" value="<?php echo $flight_no;?>">
	</div>
</div>

<div class="form-group">
	<div class="input-group">
		<div class="input-group-addon iconfont">&#xe738;</div>
		<input type="text" class="form-control" disabled id="timeup_j"
			placeholder="上车时间" value="<?php echo $pickup_time;?>">
	</div>
</div>
<input type="hidden" name="pickup_time" value="<?php echo $pickup_time;?>">

<div class="form-group">
	<div class="input-group">
		<div class="input-group-addon iconfont">&#xe622;</div>
		<input type="text" class="form-control" disabled id="hangzhanlou_j"
			placeholder="航站楼" value="<?php echo $pickup_place;?>">
	</div>
</div>
<input id="terminal" type="hidden" name="pickup_place" value="<?php echo $pickup_place;?>">

<div class="form-group">
	<div class="input-group">
		<div class="input-group-addon iconfont">&#xe606;</div>
		<input type="text" class="form-control" id="addressdown_j"
			placeholder="下车地点" name="drop_place">
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



<textarea style="width: 100%;" class="form-group" rows="3"
	placeholder="其他需求" name="summary"></textarea>

<label style="float: right;">价格<span class="rmb">0</span>元
<input type="hidden" name="estimated_cost" id="estimated_cost">
</label>

<?php include '_protocol.php';?>
</form>
<script>
$("#hangban_j").focus(function(){
	var contacter_name = $("#user_j").val();
	var contacter_phone = $("#tel_j").val();
	window.location.href="/order/flight?contacter_name=" + contacter_name + "&contacter_phone=" + contacter_phone;
});
</script>