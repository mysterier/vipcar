<div class="account-right-head">
	<h3>我的喜好</h3>
</div>

<div class="account-container">
	<?php
        $form = $this->beginWidget('CActiveForm', [
            'id' => 'address-form',
            'action' => '/favorite/create',
            'htmlOptions' => [
                'class' => 'form-horizontal'
            ]
        ]);
    ?>
		<div class="form-group ">
			<ul class="likeselect">
				<li class="<?php if($favorite['shutdownac']) echo 'selected';?>">
				    <img src="/images/account/icon-air.png" />
				    <input type="hidden" name="favorite[shutdownac]" value="<?php echo $favorite['shutdownac']?>" />
				</li>
				<li class="<?php if($favorite['slowdrive']) echo 'selected';?>">
				    <img src="/images/account/icon-car.png" />
				    <input type="hidden" name="favorite[slowdrive]" value="<?php echo $favorite['slowdrive']?>" />
				</li>
				<li class="<?php if($favorite['music']) echo 'selected';?>">
				    <img src="/images/account/icon-music.png" />
				    <input type="hidden" name="favorite[music]" value="<?php echo $favorite['music']?>" />
				</li>
				<li class="<?php if($favorite['nosay']) echo 'selected';?>">
				    <img src="/images/account/icon-nosay.png" />
				    <input type="hidden" name="favorite[nosay]" value="<?php echo $favorite['nosay']?>" />
				</li>
				<li class="<?php if($favorite['firstline']) echo 'selected';?>">
				    <img src="/images/account/icon-chair.png" />
				    <input type="hidden" name="favorite[firstline]" value="<?php echo $favorite['firstline']?>" />
				</li>
			</ul>
		</div>
		<div class="from-group">
			<div class="col-md-offset-3 col-md-6">
				<button type="submit" class="btn btn-info btn-block all-btn-color">保存</button>
			</div>
		</div>
	<?php $this->endWidget(); ?>
</div>
<script>
$('.likeselect li').click(function(){
	if($(this).prop('class')=='selected') {
		$(this).removeClass('selected');
		$(this).children("input").val('0');
	} else {
		$(this).addClass('selected');
	    $(this).children("input").val('1');
	}
});
</script>