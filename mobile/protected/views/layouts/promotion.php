<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport"
	content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title><?php echo $this->title; ?></title>
<link href="/css/bootstrap.min.css" rel="stylesheet">
<link href="/css/promystyle.css" rel="stylesheet">
<script type="text/javascript" src="/js/jquery-1.11.2.js"></script>
<script type="text/javascript" src="/js/bootstrap.min.js"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=xKTm9GM58nRtGkBATG6jGwui"></script>
<script>
function alertError(msg) {
	$(".tips").html(msg).fadeIn(1000).fadeOut(1500);
}
</script>
</head>
<body>
    <?php echo $content;?>
<div style="display: none;position:fixed;bottom:200px;right:1%;left:1%;" class="tips"></div>
</body>
</html>
