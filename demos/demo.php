<?php
require dirname(__DIR__).'/build/imageDragAuth.php';

$imageDragAuth = new imageDragAuth(imagecreatefromjpeg('images/1.jpg'), imagecreatefrompng('images/3.png'), imagecreatefrompng('images/2.png'), 65280);
$sessionArr = $imageDragAuth->generator();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>图片拖动验证</title>
</head>
<body>
    <script src=”http://libs.baidu.com/jquery/1.11.1/jquery.min.js”></script>
    <div class="">x:<?php echo $sessionArr['x'] ?><br />y:<?php echo $sessionArr['y'] ?></div>
    <img src="big.php?<?php echo http_build_query($sessionArr)?>" style="display: block;clear:both;" />
    <img src="small.php?<?php echo http_build_query($sessionArr)?>" style="display: block;clear:both;" />
</body>
</html>