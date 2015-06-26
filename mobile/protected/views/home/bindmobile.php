<div class="phone-bg">
	<div>
	<div class="phone-logo">
		<img src="/img/logo.png">
	</div>
	<?php if(!$client || (is_object($client) && $client->getErrors())):?>
	<p class="text-center phone-h">小择</p>
	<p class="text-center phone-p">送您一张50元专车券</p>
	<form method="post" action="/home/bindmobile">
		<div class="phone-formgroup">
			<div class="phone-formlist">
				<input name="mobile" type="text" id="tel" value="<?php echo is_object($client) ? $client->mobile : ''; ?>" placeholder="请输入您的手机号">
			</div>
		</div>
		<div class="phone-formgroup">
			<div class="phone-formlist">
				<input class="pull-left" type="text" name="msg_code" placeholder="手机验证码">
				<input type="button" class="phone-btn-form pull-right" id="getcode" value="获取验证码" />
			</div>

		</div>
		<div class="clearfix"></div>
		<button type="submit" class="btn-block phone-btn">领取专车券</button>
	</form>
	<p class="phone-p-bottom text-center">50元可全额一次性作为车费抵用</p>
	<?php else:?>
		<p class="text-center phone-p">您已是众择用车注册会员<br/>50元专车券已存入<span>137****1234</span>账户中</p>
	<?php endif;?>
	</div>
</div>
<script>
<?php 
if (is_object($client) && $client->getErrors()) {
    $error = '';
    foreach ($client->getErrors() as $item) {
           $error .= array_shift($item);
    }
    echo '$(function(){alertError(\'' . $error . '\');});'; 
}
?>

var wait=<?php echo VERIFY_CODE_RESEND;?>;
function time(o) {
    if (wait == 0) {
        o.removeAttr("disabled"); 
        o.val("获取验证码");
        wait = <?php echo VERIFY_CODE_RESEND;?>;
    } else {
        o.attr("disabled", true);
        o.val("重新发送(" + wait + ")");
        wait--;
        setTimeout(function() {
            time(o)
        },
        1000)
    }
}
$("#getcode").click(function(){
    mobile = $("#tel").val();
	if (!mobile)
		alertError('请先填写手机号码！');
	else {
		reg = /^(?:(?:1(?:3[4-9]|5[012789]|8[78])\d{8}|1(?:3[0-2]|5[56]|8[56])\d{8}|18[0-9]\d{8}|1[35]3\d{8})|14[57]\d{8}|170[059]\d{7}|17[67]\d{8})$/;
		if (reg.exec(mobile)) {
			time($(this));
			$.post('/home/sendcode',{'mobile':mobile},function(data){
			    error_code = data.error_code;
			},'json');
		} else {
		    alertError('手机号码格式不正确！');
		}		
	}	
});
</script>