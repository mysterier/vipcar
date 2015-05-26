<div class="imgtop">

</div>
<div class="wrapper-width padding100">
<?php foreach ($model as $item):?>
	<div class="activitieslist col-md-12">
		<div class="activitiesimg col-md-5">
			<img src="http://<?php echo DEFAULT_CDN_URL . $item->cover;?>">
		</div>
		<div class="activitiesspan col-md-7">
			<h3><?php echo $item->title;?></h3>
			<p><?php echo $item->desc;?></p>
		</div>

		<a class="btn btn-info pull-right" href="/eventdetail/<?php echo $item->id;?>">马上参与</a>
	</div>
<?php endforeach;?>
</div>

<div class="clearfix"></div>