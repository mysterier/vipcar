<!DOCTYPE html>
<html manifest="/m.manifest">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport"
	content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<link rel="stylesheet" type="text/css" href="/css/mystyle.css">
<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="/fonts/iconfont.css">
<link rel="stylesheet" type="text/css"
	href="/css/bootstrap-datetimepicker.min.css">
<script src="/js/jquery-1.11.2.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/bootstrap-datetimepicker.min.js"></script>
<script src="/js/locales/bootstrap-datetimepicker.zh-CN.js"></script>
<script type="text/javascript">
$(function(){
    $('#datetimepicker').datetimepicker({
	    format: <?php if($this->action->id == 'flight'):?>'yyyy-mm-dd'<?php else:?>'yyyy-mm-dd hh:ii'<?php endif;?>,
	    language: 'zh-CN',
        autoclose: true
    });
});
</script>
<title><?php echo $this->title; ?></title>
</head>

<body>
	<div class="head">
		<p style="color: #fff; padding: 0.3em; font-size: 2em;"
			class="text-center">
			<strong><?php echo $this->title; ?></strong>
		</p>
	</div>
	<div style="padding-bottom: 1em;" class="container-fluid">
<?php echo $content;?>
</div>
</body>

</html>
