<!--magazine-->
<div class="wrapper-width">
<?php foreach ($model as $magazine):?>
    <a href="<?php echo $magazine->out_link;?>" class="magazinelist btn" target="_blank"><img width="960px" height="978px" src="http://<?php echo DEFAULT_CDN_URL . $magazine->cover;?>" title="<?php echo $magazine->title?>"></a>
<?php endforeach;?>
</div>
<div class="clearfix"></div>