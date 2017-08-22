<?php
/**
* @author: Jobs Fan 289047960@qq.com
* @copyright 2012-2017 Jobs Fan
*/
class imageDragAuth
{
    public $backgroundImgSrc;
    public $fillImgSrc;
    public $transparentImgSrc;
    public $colorTransparentInt;
    
    public $sessionXname;
    public $sessionYname;
    
    /**
    * 构造函数
    * @param $backgroundImgSrc 背景图的resource，可以是来自imagecreatefromjpeg imagecreatefrompng imagecreatefromgif 等
    * @param $fillImgSrc 填充图[和镂空透明图形状大小一样，不过是反的，一个填充，一个镂空]的resource，来自imagecreatefrompng
    * @param $transparentImgSrc 镂空图[和填充图形状大小一样，不过是反的，一个填充，一个镂空]的resource，来自imagecreatefrompng
    * @param $colorTransparentInt 10进制整数，要替换的颜色的数值
    * @return what return
    * @author Jobs Fan
    * @date: 下午3:17:54
    */
    public function __construct($backgroundImgSrc,$fillImgSrc,$transparentImgSrc,$colorTransparentInt)
    {
        $this->backgroundImgSrc = $backgroundImgSrc;
        $this->fillImgSrc = $fillImgSrc;
        $this->transparentImgSrc = $transparentImgSrc;
        $this->colorTransparentInt = $colorTransparentInt;
    }
    
    /**
    * 生成验证码，其实就是生成x坐标和y坐标，原理是一样的都存在服务器端的session里面
    * @param $sessionXname 储存x坐标的session的名字
    * @param $sessionYname 储存y坐标的session的名字
    * @return what return
    * @author Jobs Fan
    * @date: 下午3:25:20
    */
    public function generator($sessionXname = 'imageDragAuthX',$sessionYname='imageDragAuthY')
    {
        $bgX = imagesx($this->backgroundImgSrc);
        $bgY = imagesy($this->backgroundImgSrc);
        $smX = imagesx($this->transparentImgSrc);
        $smY = imagesy($this->transparentImgSrc);
        
        $randX = rand(5,($bgX - $smX -5));
        $randY = rand(5,($bgY - $smY - 5));
        
        $this->sessionXname = $sessionXname;
        $this->sessionYname = $sessionYname;
        
        $_SESSION[$sessionXname] = $randX;
        $_SESSION[$sessionYname] = $randY;
        
        return array('x' => $randX,'y' => $randY); //5是边距，如果0，0就不需要移动了
    }
    
    /** 
    * 验证码验证
    * @param $x 用户通过ajax提交上来的x坐标值
    * @param $y 用户通过ajax提交上来的y坐标值
    * @param $threshold 容错阈值
    * @return boolean
    * @author Jobs Fan
    * @date: 下午3:39:37
    */
    public function validation($x,$y,$threshold=4)
    {
        $x = (int) $x;
        $y = (int) $y;
        if (!$x || !$y || !isset($_SESSION[$this->sessionXname]) || !isset($_SESSION[$this->sessionYname])) return false;
        return $x >= $_SESSION[$this->sessionXname] - $threshold && $x <= $_SESSION[$this->sessionXname] + $threshold && $y >= $_SESSION[$this->sessionYname] - $threshold && $y <= $_SESSION[$this->sessionYname] + $threshold;
    }
    
    /**
    * 生成背景图
    * @param $x generator方法返回的x值
    * @param $y generator方法返回的y值
    * @return 直接输出图片
    * @author Jobs Fan
    * @date: 下午4:08:56
    */
    public function createBgImg($x, $y)
    {
        header('Content-type: image/png');
        
        $bgX = imagesx($this->backgroundImgSrc);
        $bgY = imagesy($this->backgroundImgSrc);
        
        $background = imagecreatetruecolor($bgX,$bgY);
        imagecopy($background, $this->backgroundImgSrc, 0, 0, 0, 0, 868, 390);
        
        imagecopy($background, $this->fillImgSrc, $x, $y, 0, 0, 149, 149);
        imagepng($background);
        imagedestroy($background);
    }
    
    /**
    * 生成前景图，也就是鼠标拖动的图
    * @param $x generator方法返回的x值
    * @param $y generator方法返回的y值
    * @return 直接输出图片
    * @author Jobs Fan
    * @date: 下午4:15:25
    */
    public function createDragbleImg($x, $y)
    {
        header('Content-type: image/png');
        
        $bgX = imagesx($this->backgroundImgSrc);
        $bgY = imagesy($this->backgroundImgSrc);
        $smX = imagesx($this->transparentImgSrc);
        $smY = imagesy($this->transparentImgSrc);
        
        $background = imagecreatetruecolor($bgX,$bgY);
        
        imagecopy($background, $this->backgroundImgSrc, 0, 0, 0, 0, $bgX, $bgY);
        imagecopy($background, $this->transparentImgSrc, $x, $y, 0, 0, $smX, $smY);
        
        $imgCrop = imagecrop($background, array('x' => $x,'y' => $y, 'width' => $smX, 'height' => $smY));
        
        imagecolortransparent($imgCrop,$this->colorTransparentInt);
        imagepng($imgCrop);
        imagedestroy($imgCrop);
    }
}