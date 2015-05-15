<div class="wrapper-width">
<?php foreach ($model as $notice):?>
	<div class="noticelist">
		<h3 class="text-center"><?php echo $notice->title?></h3>
		<p>尊敬的众择用户：</p>
		<p>您好！</p>
		<p class="indent">
		<?php echo $notice->content;?>
		</p>
		<p class="indent">感谢您对众择的关注与支持！</p>		
		<p class="text-right">众择用车</p>
		<p class="text-right"><?php echo date('Y年m月d日', strtotime($notice->created));?></p>
	</div>
<?php endforeach;?>
</div>
