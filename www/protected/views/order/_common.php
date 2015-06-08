<script>
function getIncome() {
	var vehicle_type = $("#Orders_vehicle_type").val();
	var place = $("#terminal").val();
	switch (vehicle_type) {
		case '2':
			fares = [<?php echo COMFORTABLE_LOW;?>, <?php echo COMFORTABLE_HIGH;?>];
			break;
		case '3':
			fares = [<?php echo BUSINESS_LOW;?>, <?php echo BUSINESS_HIGH;?>];
			break;
		case '4':
			fares = [<?php echo LUXURY_LOW;?>, <?php echo LUXURY_HIGH;?>];
			break;
		default:
			fares = [<?php echo COMFORTABLE_LOW;?>, <?php echo COMFORTABLE_HIGH;?>];
	}
	if (place == '虹桥国际机场T1' || place == '虹桥国际机场T2') {
		fare = fares[0];
	} else {
		fare = fares[1];
	}
	return fare;
}

$("#terminal").change(function(){
	income = getIncome();
	$(".rmb").text(income);
	$("#estimated_cost").val(income);
	//将优惠券重置
	$(".mycoupon")[0].selectedIndex = 0;
});

$("#Orders_vehicle_type").change(function(){
	income = getIncome();
	$(".rmb").text(income);
	$("#estimated_cost").val(income);
	$(".mycoupon").remove();
	$.post('/jsonp/getticket',{'vehicle_type':$(this).val(),'order_type':'<?php echo Yii::app()->controller->action->id;?>'},function(data){
	    $("#showticket").append(data);
	});
});

$(function(){
	income = getIncome();
	$(".rmb").text(income);
	$("#estimated_cost").val(income);
	$.post('/jsonp/getticket',{'vehicle_type':$("#Orders_vehicle_type").val(),'order_type':'<?php echo Yii::app()->controller->action->id;?>'},function(data){
	    $("#showticket").append(data);
	});
});

$(".mycoupon").live('change',function(){
	var coupon_cost = $(".mycoupon option:selected").attr("coupon_cost");
	var income = getIncome()-coupon_cost;
	if (coupon_cost) {
		income = (income > 0) ? income : 0;
		$(".rmb").text(income);
		$("#estimated_cost").val(income);
	} else {
		income = getIncome();
		$(".rmb").text(income);
		$("#estimated_cost").val(income);
	}	
});

//百度地图
var ac = new BMap.Autocomplete(
	{"input" : "suggestId",
	"location" : "上海"
});
</script>
