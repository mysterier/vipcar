<!--magazine-->
<div class="magazineimg">
    <div class="magazineimglist"><img src="/img/magazineimg.png"></div>
</div>
<div class="wrapper-width">
<?php foreach ($model as $magazine):?>
    <a href="<?php echo $magazine->out_link;?>" class="magazinelist btn" target="_blank"><img src="http://<?php echo DEFAULT_CDN_URL . $magazine->cover;?>" title="<?php echo $magazine->title?>"></a>
<?php endforeach;?>
</div>
<div class="clearfix"></div>