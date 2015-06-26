<div class="wrapper">
	<form method="post">
		<div class="formgroup">
			<div class="formlist">
				<div class="col-xs-2">
					<img src="/img/mingzi.png">
				</div>
				<div class="col-xs-10">
					<input type="text" class="form-control" name="contacter_name" placeholder="联系人">
				</div>
			</div>
			<div class="formline"></div>
			<div class="formlist">
				<div class="col-xs-2">
					<img src="/img/shouji.png">
				</div>
				<div class="col-xs-10">
					<input type="text" class="form-control" name="contacter_phone" placeholder="联系电话">
				</div>
			</div>
			<div class="formline"></div>
			<div class="formlist">
				<div class="col-xs-2">
					<img src="/img/renshu.png">
				</div>
				<div class="col-xs-10">
					<select class="form-control" name="seats">
					<?php for($i=1; $i <=6; ++$i): ?>
						<option value="<?php echo $i;?>"><?php echo $i;?>人</option>
                    <?php endfor;?>
					</select>
				</div>
			</div>
		</div>
		<div class="width98">
			<div class="width47 pull-left">
				<button type="submit" class="btn btn-block orange-btn">确定</button>
			</div>
			<div class="width47 pull-right">
				<button  onclick="history.go(-1)" class="btn btn-block blue-btn">返回</button>
			</div>
		</div>
	</form>
	<div class="clearfix"></div>
</div>
<script>
$(function(){	
	$("form").submit(function() {
		name = $("input[name=contacter_name]").val();
		mobile = $("input[name=contacter_phone]").val();
		msg = '';
		msg += name ? '' : '联系人不能为空！';
		msg += mobile ? '' : '联系电话不能为空！';
		if (msg) {
		    alertError(msg);
		    return false;
		}
	    return true;
	});
});
</script>