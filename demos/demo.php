<?php
/* 这个demo是横向和竖向都验证的 */
require dirname(__DIR__).'/build/imageDragAuth.php';

$imageDragAuth = new imageDragAuth(imagecreatefromjpeg('images/1.jpg'), imagecreatefrompng('images/3.png'), imagecreatefrompng('images/2.png'), 65280);
$imageDragAuth->generator();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>图片拖动验证</title>
<link rel="stylesheet" href="https://cdn.bootcss.com/jqueryui/1.12.1/jquery-ui.css" />
<style>
* {border:0;outline:0;margin:0;padding:0;}
html {width:100%;height:100%;overflow:hidden;background: #ededed;}
body {width:100%;height:100%;font-size:14px;font-family:"微软雅黑",STHeiti,Arial;text-align:center;background: #ededed;}
.someInsctruction {height:30px;line-height:30px;clear:both;overflow:hidden;font-size:22px;font-weight:bold;}
.sessionxy {}
.dragHolder {position: relative;    width: 868px;    height: 390px;   margin: 10px auto;   overflow: hidden;}
.dragHolder .dragBar {position: absolute;width:149px;height:149px;overflow: hidden;background:transparent;border:none;top:0;left:0;}
</style>
</head>
<body>
    <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script>
    $( function() {
    	$( "#draggable" ).draggable({
    		stop: function() {
            	$.getJSON('valid.php?x='+parseInt($( "#draggable" ).css("left"))+'&y='+parseInt($( "#draggable" ).css("top")),function(result){
                	setTimeout(function(){alert(result['msg']);},100);
                	if (!result['status']){
                    	$(".bgimg").attr("src","big.php?r="+Math.random());
                    	$(".dragImg").attr("src","small.php?r="+Math.random());
                    	$("#draggable").css({"top":"0px","left":"0px"});
                	}else{
                		$( "#draggable" ).draggable( "disable" );
                	}
            	});
            }
    	});
    } );
    </script>
    <div class="someInsctruction">此demo是x坐标和y坐标都验证的</div>
    <div class="sessionxy">x:<?php echo $_SESSION['imageDragAuthX'] ?><br />y:<?php echo $_SESSION['imageDragAuthY'] ?></div>
    <div class="dragHolder">
    	<img class="bgimg" src="big.php" style="display: block;clear:both;" />
    	<div id="draggable" class="dragBar ui-widget-content">
    		<img class="dragImg" src="small.php" style="display: block; overflow:hidden;" />
    	</div>
    </div>
</body>
</html>