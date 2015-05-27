<div class="imgtop"></div>
<div class="wrapper-width padding50">
  <div class="active-detial-wrapper">
    <?php if($model->content_img):?>
    <div class="active-detial-img">
        <img src="http://<?php echo DEFAULT_CDN_URL . $model->content_img;?>">
    </div>
    <?php endif;?>
    <h3><?php echo $model->title?></h3>

    <div class="active-detial-content">
      <p>活动详情</p>
      <p><?php echo $model->content;?></p>
    </div>
  </div>
</div>