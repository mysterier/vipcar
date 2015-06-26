<div class="wrapper">
		<div class="formgroup">
			<div class="formlist">
				<div class="col-xs-2"><img src="/img/feiji.png"></div>
				<div class="col-xs-10">
			    	<input type="datetime-local" class="" id="datetimepicker" name="" placeholder="航班时间">
			    </div>				    
			</div>
		    <div class="formline"></div>
		  	<div class="formlist">
				<div class="col-xs-2">
                    <img src="/img/shijian.png">
				</div>
                <div class="col-xs-10">
                    <input type="text" class="form-control" id="hangban_j" placeholder="航班号">
                </div>			    
		    </div> 
                            				
		</div>
        <button id="getflight" type="button" class="btn btn-block brown-btn width98">查询</button>        
  	</div>
<script>
$("#getflight").click(function(){
	var flight_no = $("#hangban_j").val();
	var date = $("#datetimepicker").val();
	$.post('/order/getflight',{flight:flight_no,date:date,contacter_name:'<?php echo $contacter_name;?>',contacter_phone:'<?php echo $contacter_phone;?>',seats:'<?php echo $seats;?>'},function(data){
		if (data.error_code == 0) {
			$(".flight-head,.flight-content").remove();
			$(".wrapper").append(data.html);
		}
	},'json');
});

</script>
