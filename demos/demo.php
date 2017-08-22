<?php
require dirname(__DIR__).'/build/imageDragAuth.php';

$imageDragAuth = new imageDragAuth(imagecreatefromjpeg('images/1.jpg'), imagecreatefrompng('images/3.png'), imagecreatefrompng('images/2.png'), 65280);
$sessionArr = $imageDragAuth->generator();

print_r($sessionArr);
?>

<img src="big.php?<?php echo http_build_query($sessionArr)?>" style="display: block;clear:both;" />
<img src="small.php?<?php echo http_build_query($sessionArr)?>" style="display: block;clear:both;" />