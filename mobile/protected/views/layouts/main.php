<!DOCTYPE html>
<html manifest="/m.manifest">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link rel="stylesheet" type="text/css" href="/font/iconfont.css">
<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="/css/songji.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $this->title; ?></title>
</head>

<body>
	<div class="head">
		<p style="color: #fff; padding: 0.3em; font-size: 2em;"
			class="text-center">
			<strong><?php echo $this->title; ?></strong>
		</p>
	</div>
<?php echo $content;?>
</body>

</html>