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

$("#Orders_vehicle_type,#terminal").change(function(){
	income = getIncome();
	$(".rmb").text(income);
	$("#estimated_cost").val(income);
});

$(function(){
	income = getIncome();
	$(".rmb").text(income);
	$("#estimated_cost").val(income);
});

$(".mycoupon").change(function(){
	var coupon_cost = $(".mycoupon option:selected").attr("coupon_cost");
	var income = getIncome()-coupon_cost;
	income = (income > 0) ? income : 0;
	$(".rmb").text(income);
	$("#estimated_cost").val(income);
});

//百度地图
var ac = new BMap.Autocomplete(
	{"input" : "suggestId",
	"location" : "上海"
});
</script>
