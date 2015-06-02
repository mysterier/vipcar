<div class="account-right-head">
	<h3>账号充值</h3>
</div>
<div class="account-container">	
	<div class="form-group">
		<label class="col-md-2 control-label">我要充</label>
		<div class="col-md-5">
			<select id="fee" class="form-control" name="fee">
				<option value="100">100</option>
				<option value="200">200</option>
				<option value="300">300</option>
				<option value="400">400</option>
				<option value="500">500</option>
				<option value="1000">1000</option>
				<option value="2000">2000</option>
			</select>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-offset-2 col-md-5 margintop10">
			<button class="btn btn-info btn-block all-btn-color" id="gotoali">支付宝充值</button>
		</div>
	</div>
</div>
<script>
function getfrom(fee) {
	$.post('/jsonp/getAliform',{'fee':fee},function(data){
	    $(".account-container").append(data);
	});
}

$(function(){
	fee = $("#fee").val();
	getfrom(fee);
	$("#fee").change(function(){
	    $("#alipaysubmit").remove();
	    fee = $(this).val();
	    getfrom(fee);
	});
	$("#gotoali").click(function() {
		out_trade_no = $("input[name=out_trade_no]").val();
		subject = $("input[name=subject]").val();
		body = $("input[name=body]").val();
		$.post('/jsonp/recharge',{'fee':fee, 'trade_no':out_trade_no,'subject':subject,'body':body},function(data){
		    if (data.status == '1') {
		    	document.forms['alipaysubmit'].submit();
			}
		},'json');		
	});
})
</script>