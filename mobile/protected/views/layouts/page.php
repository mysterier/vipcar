<!DOCTYPE html>
<html manifest="/m.manifest">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $this->title;?></title>
<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="/css/mystytle.css">
</head>
<body>
	<div id="blue">
		<span class="text"><h5><?php echo $this->title;?></h5></span>
	</div>
<?php echo $content;?>
</body>

</html>