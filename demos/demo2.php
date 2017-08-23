<?php
/* 这个demo是只验证横向的都验证的 */
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
.sessionxy {clear:both;overflow:hidden;}
.imgDragAuthHolder {width: 870px;    margin: 10px auto;    overflow: hidden;}
.imgDragAuthHolder .reflectStage {position: relative;    width: 868px;    height: 390px;    clear: both;    overflow: hidden;}
.imgDragAuthHolder .reflectStage .bgimg {display: block;    width: 868px;}
.imgDragAuthHolder .reflectStage .reflectimg {position: absolute;    display: block;    width: 149px;    height: 149px;    overflow: hidden;    left: 0;}
.imgDragAuthHolder .dragBarHolder {position: relative;    width: 868px;    height: 40px;    margin: 10px auto;    border: 1px solid #cccccc;}
.imgDragAuthHolder .dragBarHolder #draggable {position: absolute; width: 40px;    height: 40px;  overflow: hidden; border:none; border-left: 1px solid #cccccc; border-right: 1px solid #cccccc;   top:0; left:0;    background: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAANCAYAAACgu+4kAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAABkSURBVDhPYyAGZGYUbcjKLFoA5ZIOsrJKDIAGfBiuhmRmFgVkZhY3kITBgVr8H2wImJNRfIAUDDTkAsgAoN7zYFeQAvLz8wVABoA0g9hQYeLAENUMAkCNG8jWDAKgqMaumYEBAB5ve4AwYBoCAAAAAElFTkSuQmCC") center center no-repeat;    cursor: pointer;}
</style>
</head>
<body>
    <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script>
    $( function() {
    	$( "#draggable" ).draggable({
    		containment: ".dragBarHolder",
    		axis: "x",
    		drag: function( event, ui ) {
    			$(".reflectimg").css({"left":$( "#draggable" ).css("left")});
    		},
    		stop: function() {
            	$.getJSON('valid2.php?x='+parseInt($( "#draggable" ).css("left"))+'&y='+parseInt($( ".reflectimg" ).css("top")),function(result){
                	setTimeout(function(){alert(result['msg']);},100);
                	if (!result['status']){
                    	$(".bgimg").attr("src","big.php?r="+Math.random());
                    	$(".reflectimg").attr("src","small.php?r="+Math.random());
                    	$("#draggable").css({"left":"0px"});
                    	$(".reflectimg").css({"left":"0px","top":result['y']});
                	}else{
                		$( "#draggable" ).draggable( "disable" );
                	}
            	});
            }
    	});
    } );
    </script>
    <div class="someInsctruction">此demo只验证x坐标</div>
    <div class="sessionxy">x:<?php echo $_SESSION['imageDragAuthX'] ?><br />y:<?php echo $_SESSION['imageDragAuthY'] ?></div>
    <div class="imgDragAuthHolder">
    	<div class="reflectStage">
    		<img class="bgimg" src="big.php" />
    		<img class="reflectimg" src="small.php" style="top:<?php echo $_SESSION['imageDragAuthY'] ?>px;" />
    	</div>
    	<div class="dragBarHolder">
    		<div id="draggable" class="draggable ui-widget-content"></div>
    	</div>
    	
    </div>
</body>
</html>