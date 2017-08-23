<?php
/* 此验证是为只横向拖动预设的，要下发一个y坐标 */
require dirname(__DIR__).'/build/imageDragAuth.php';

$imageDragAuth = new imageDragAuth(imagecreatefromjpeg('images/1.jpg'), imagecreatefrompng('images/3.png'), imagecreatefrompng('images/2.png'), 65280);
$result = $imageDragAuth->validation($_GET['x'], $_GET['y']);
echo json_encode(array('status' => $result,'msg' => $result ? '验证成功' : '验证失败','y' => $_SESSION['imageDragAuthY'].'px'));
?>