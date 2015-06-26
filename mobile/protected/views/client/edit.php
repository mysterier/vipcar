<div class="wrapper">
	<form method="post" action="/client/edit">
		<div class="formgroup">
			<div class="formlist">
				<div class="col-xs-2">
					<img src="/img/mingzi.png">
				</div>
				<div class="col-xs-10">
					<input type="text" class="form-control" name="real_name" value="<?php echo $model->real_name;?>" placeholder="姓名">
				</div>
			</div>
			<div class="formline"></div>
			<div class="formlist">
				<div class="col-xs-2">
					<img src="/img/xingbie.png">
				</div>
				<div class="col-xs-4">
					<div class="sex-radio"> <input type="radio" name="client_title" id="" value="1" <?php if($model->client_title==1) echo 'checked';?> > 
					</div>
					<div class="p-select sex-p">先生</div>
				</div>
				<div class="col-xs-4">
					<div class="sex-radio"> <input type="radio" name="client_title" id="" value="2" <?php if($model->client_title==2) echo 'checked';?>>
					</div>
					<div class="p-select sex-p">女士</div>
				</div>
			</div>
		</div>
		<div class="formgroup">
			<div class="formlist">
				<div class="col-xs-2">
					<img src="/img/youxiang.png">
				</div>
				<div class="col-xs-10">
					<input type="text" class="form-control" name="email" value="<?php echo $model->email;?>" placeholder="电子邮箱">
				</div>
			</div>
		</div>
		<div class="width98">
			<div class="width47 pull-left">
				<button type="submit" class="btn btn-block orange-btn">编辑</button>
			</div>
			<div class="width47 pull-right">
				<a href="/client" class="btn btn-block blue-btn">返回</a>
			</div>
		</div>
	</form>
	<div class="clearfix"></div>
</div>
<?php if($error):?>
<script>
$(function() {
    alertError("<?php echo $error;?>");
});
<?php endif;?>
</script>