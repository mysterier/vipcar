<div class="form-group">
	<div class="input-group">
		<div class="input-group-addon iconfont">&#xe738;</div>
		<input type="text" class="form-control" id="datetimepicker"
			placeholder="上车时间" name="pickup_time">

	</div>
</div>

<div class="form-group">
    <div class="input-group">
        <div class="input-group-addon iconfont">&#xe630;</div>
      <input type="text" class="form-control" id="hangban_j" placeholder="航班号">

    </div>
</div>
<button id="getflight" type="button" class="btn btn-primary btn-block search">查询</button>
<div class="form-group hangban-title">
	<div id="flight-content">
	</div>
</div>
<script>
$("#getflight").click(function(){
	var flight_no = $("#hangban_j").val();
	var date = $("#datetimepicker").val();
	$.post('/order/getflight',{flight:flight_no,date:date,contacter_name:'<?php echo $contacter_name;?>',contacter_phone:'<?php echo $contacter_phone;?>'},function(data){
		if (data.error_code == 0) {
			$("#flight-content").html(data.html);
		}
	},'json');
});
</script>
