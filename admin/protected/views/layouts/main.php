<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo CHtml::encode($this->pageTitle); ?></title>
<meta name="description"
	content="众择用车,旅游,上海租车,租车,租车网,租车公司,上海租车网,汽车租赁,接送机，旅游租车，汽车租赁公司,上海租车公司,上海汽车租赁公司,汽车租赁网，商务租车，旅游租车，机场接送" />
<link href="/css/main.css" rel="stylesheet" />
<link href="/css/mystyle.css" rel="stylesheet"/>
</head>
<body>
	<div class="container">
		<div class="page-header">
			<h1><img src="/images/logo.png" class="img-rounded"> 众择用车后台管理系统</h1>
		</div>
	
    <?php if($this->action->id != 'login'):?>
    
    <?php
    $this->widget('booster.widgets.TbMenu', [
        'type' => 'pills',
        'items' => $this->menu
    ]
    );
    ?>
	
	<!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php
    $this->widget('booster.widgets.TbBreadcrumbs', array(
        'links' => $this->breadcrumbs
    ));
    ?>
		<!-- breadcrumbs -->
	<?php endif;?>
    <?php endif;?>
    
	<?php echo $content; ?>

	<div class="clear"></div>

		<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by 苏先.<br /> All
			Rights Reserved.<br />
	</div>
		<!-- footer -->

	</div>
	<!-- page -->
</body>
</html>
