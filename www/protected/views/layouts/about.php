<?php $this->beginContent('//layouts/main'); ?>
<!--about-->
<div class="wrapper-width paddingfifty">
	<div class="about-left list-group col-md-3">
    	<a href="/about" class="list-group-item <?php if($this->action->id == 'about') echo 'active';?>"> 关于众择 </a> 
    	<a href="/culture" class="list-group-item <?php if($this->action->id == 'culture') echo 'active';?>">众择文化</a> 
    	<a href="/services" class="list-group-item <?php if($this->action->id == 'services') echo 'active';?>">众择服务</a> 
    	<a href="/special" class="list-group-item <?php if($this->action->id == 'special') echo 'active';?>">专享服务</a> 
    	<a href="/jobs" class="list-group-item <?php if($this->action->id == 'jobs') echo 'active';?>">招聘信息</a> 
    	<a href="/contact" class="list-group-item <?php if($this->action->id == 'contact') echo 'active';?>">联系我们</a>
    </div>
	<div class="about-right col-md-9">
	<?php echo $content; ?>
	</div>
	<div class="clearfix"></div>
</div>
<?php $this->endContent(); ?>