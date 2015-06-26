<div class="imgtop">

</div>
<div class="wrapper-width padding50">
<?php foreach ($model as $item):?>
	<div class="activitieslist col-md-12">
		<div class="activitiesimg col-md-5">
			<img width="281px" height="196px"> src="http://<?php echo DEFAULT_CDN_URL . $item->cover;?>">
		</div>
		<div class="activitiesspan col-md-7 padnone">
			<h3><?php echo $item->title;?></h3>
			<p><?php echo $item->desc;?></p>

			<a class="btn eventbtn" href="/eventdetail/<?php echo $item->id;?>">点击详情</a>
			<div class="pull-right" onmouseover="setShare('<?php echo $item->title;?>','http://<?php echo Yii::app()->homeUrl . '/eventdetail/' . $item->id;?>');"> 
		      <div class="jiathis_style">
		      <a class="jiathis_button_tsina">新浪微博</a>
		      <a class="jiathis_button_weixin">微信</a>
		      </div>
		    </div>
		</div>
	</div>
<?php endforeach;?>
</div>

<div class="clearfix"></div>

<script type="text/javascript">
                          function setShare(title, url) {
                              jiathis_config.title = title;
                              jiathis_config.url = url;
                          }
                            var jiathis_config = {}
                          </script>   
<script type="text/javascript" src="http://v1.jiathis.com/code/jia.js" charset="utf-8"></script>
