<div style="clear:both;" class="checkbox">
      <label>
        <input id="orderText" type="checkbox">
        勾选同意<a href="#" data-toggle="modal" data-target="#myModal">《众择用车》</a>协议 </label>
    </div>
    
    
    
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
       
        <h4 class="modal-title text-center" id="myModalLabel">用车协议</h4>
      </div>
      <div class="modal-body">
客户在进行申请注册时应完整仔细地阅读本协议，客户完成用户注册将被视为完全理解并接受以下全部条款。
会员注册：用户根据“众择用车”的要求填写真实有效的会员信息，并接受本协议后方可申请成为会员。用户应妥善使用及保管会员ID及密码，禁止会员将ID和密码交付给第三人使用，否则视为该会员自身行为，由此引起的一切法律后果由会员承担。
会员可享受的服务：拥有会员信息管理系统，长期有效地保存在众择用车数据库，并可随时查询会员信息及历史接收机记录。享受众择用车的最近优惠活动。在完成预约等相关程序后接收众择用车的全程短信免费提醒服务。
 “众择用车”安卓版适用于安卓操作系统手机，对于其他操作系统平台使用本应用可能出现的问题，众择用车恕不承担任何责任。
“众择用车”及服务的所有权和运营权以及收费规则及活动解释权均归众择用车所有。本应用及在提供服务过程中，需经您的同意并提供手机位置数据，电话号码等属于您的私人信息。我方将采取合理的措施保护您的个人隐私，除法律或有法律赋予权限的政法部门要求或您本人同意等原因外，众择用车未经您的同意不会向除合作单位以外的第三方公开透露您的个人隐私。
“众择用车”应用使用过程中将产生通讯数据流量费用，该服务与费用由您的通讯运营商提供，众择用车不提供通讯服务和流量费用的收取。
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<button id="orderCommit" type="button" class="btn btn-primary btn-block" disabled>提交订单</button>
<script>
$(function(){
    var commit = $("#orderCommit");
    $("#orderText").change(function(){
        var that = $(this);
        that.prop("checked",that.prop("checked"));
        if(that.prop("checked")){
            commit.prop("disabled",false)
        }else{
            commit.prop("disabled",true)
        }
    });
});

function getIncome() {
	var vehicle_type = $("#vehicle_type").val();
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

$("#vehicle_type,#terminal").change(function(){
	income = getIncome();
	$(".rmb").text(income);
	$("#estimated_cost").val(income);
	$("#coupon_id").val('');
	$(".positionright").html('您目前有<span class="text-danger allpadding"><?php echo count($coupons);?></span>张优惠券');
});

$(function(){
	income = getIncome();
	$(".rmb").text(income);
	$("#estimated_cost").val(income);
});

//订单验证
$("#orderCommit").click(function(){
	$(".alert-danger").remove();
	var validate = true;
	var contacter_name = $("input[name=contacter_name]");
	var contacter_phone = $("input[name=contacter_phone]");
	var pickup_time = $("input[name=pickup_time]");
	var pickup_place = $("input[name=pickup_place]");
	var drop_place = $("input[name=drop_place]");
	
	var drop_val = drop_place.val() ? drop_place.val() : $("#terminal").val();
	
	var obj = [contacter_name,contacter_phone,pickup_time,pickup_place,drop_place];
	var error_msg = [
		'联系人不能为空',
		'联系电话不能为空',
		'上车时间不能为空',
		'上车地点不能为空',
		'下车地点不能为空',		
	];
	var params = [contacter_name.val(),contacter_phone.val(),pickup_time.val(),pickup_place.val(),drop_val];
	for (i=0;i<params.length;++i) {
		if (!params[i]) {
			obj[i].parents(".form-group").after('<div class="alert alert-danger" role="alert">'+error_msg[i]+'</div>');
			validate = false;
		}
	}
	
	if (validate) {
		$("form").submit();
	}
});

//百度地图

	var ac = new BMap.Autocomplete(
		{"input" : "suggestId",
		"location" : "上海"
	});

</script>