<div class="imgtop">

</div>
<div class="wrapper-width padding50">
<?php foreach ($model as $item):?>
	<div class="activitieslist col-md-12">
		<div class="activitiesimg col-md-5">
			<img src="http://<?php echo DEFAULT_CDN_URL . $item->cover;?>">
		</div>
		<div class="activitiesspan col-md-7 padnone">
			<h3><?php echo $item->title;?></h3>
			<p><?php echo $item->desc;?></p>
		</div>

		<a class="btn btn-info col-md-offset-5" href="/eventdetail/<?php echo $item->id;?>">点击详情</a>
	</div>
<?php endforeach;?>
</div>

<div class="clearfix"></div>