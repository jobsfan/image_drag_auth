<?php
/**
* @author: Jobs Fan 289047960@qq.com
* @copyright 2012-2017 Jobs Fan
*/
session_start();
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
    * @param $sessionXname 储存x坐标的session的名字
    * @param $sessionYname 储存y坐标的session的名字
    * @return what return
    * @author Jobs Fan
    * @date: 下午3:17:54
    */
    public function __construct($backgroundImgSrc,$fillImgSrc,$transparentImgSrc,$colorTransparentInt,$sessionXname = 'imageDragAuthX',$sessionYname='imageDragAuthY')
    {
        $this->backgroundImgSrc = $backgroundImgSrc;
        $this->fillImgSrc = $fillImgSrc;
        $this->transparentImgSrc = $transparentImgSrc;
        $this->colorTransparentInt = $colorTransparentInt;
        
        $this->sessionXname = $sessionXname;
        $this->sessionYname = $sessionYname;
    }
    
    /**
    * 生成验证码，其实就是生成x坐标和y坐标，原理是一样的都存在服务器端的session里面
    * @param $stepSession 分步验证时候往session记录的session名
    * @return what return
    * @author Jobs Fan
    * @date: 下午3:25:20
    */
    public function generator($stepSession = 'setpSession')
    {
        $bgX = imagesx($this->backgroundImgSrc);
        $bgY = imagesy($this->backgroundImgSrc);
        $smX = imagesx($this->transparentImgSrc);
        $smY = imagesy($this->transparentImgSrc);
        
        $randX = rand(5,($bgX - $smX -5));
        $randY = rand(5,($bgY - $smY - 5));
        
        $_SESSION[$this->sessionXname] = $randX;
        $_SESSION[$this->sessionYname] = $randY;
        $_SESSION[$stepSession] = false;
    }
    
    /** 
    * 验证码验证
    * @param $x 用户通过ajax提交上来的x坐标值
    * @param $y 用户通过ajax提交上来的y坐标值
    * @param $threshold 容错阈值
    * @param $stepSession 分步验证时候往session记录的session名
    * @return boolean
    * @author Jobs Fan
    * @date: 下午3:39:37
    */
    public function validation($x,$y,$threshold=4,$stepSession = 'setpSession')
    {
        $x = (int) $x;
        $y = (int) $y;
        if (!$x || !$y || !isset($_SESSION[$this->sessionXname]) || !isset($_SESSION[$this->sessionYname]))
        {
            $this->generator();
            return false;
        }
        if ($x >= $_SESSION[$this->sessionXname] - $threshold && $x <= $_SESSION[$this->sessionXname] + $threshold && $y >= $_SESSION[$this->sessionYname] - $threshold && $y <= $_SESSION[$this->sessionYname] + $threshold)
        {
            $this->generator();
            $_SESSION[$stepSession] = true; //用户后面步骤的验证
            return true;
        }
        else 
        {
            $this->generator();
            return false;
        }
    }
    
    /**
    * 生成背景图
    * @param $x generator方法返回的x值
    * @param $y generator方法返回的y值
    * @return 直接输出图片
    * @author Jobs Fan
    * @date: 下午4:08:56
    */
    public function createBgImg()
    {
        header('Content-type: image/png');
        
        $bgX = imagesx($this->backgroundImgSrc);
        $bgY = imagesy($this->backgroundImgSrc);
        $smX = imagesx($this->fillImgSrc);
        $smY = imagesy($this->fillImgSrc);
        
        $background = imagecreatetruecolor($bgX,$bgY);
        imagecopy($background, $this->backgroundImgSrc, 0, 0, 0, 0, 868, 390);
        
        imagecopy($background, $this->fillImgSrc, (int)($_SESSION[$this->sessionXname]), (int)($_SESSION[$this->sessionYname]), 0, 0, $smX, $smY);
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
    public function createDragbleImg()
    {
        header('Content-type: image/png');
        
        $bgX = imagesx($this->backgroundImgSrc);
        $bgY = imagesy($this->backgroundImgSrc);
        $smX = imagesx($this->transparentImgSrc);
        $smY = imagesy($this->transparentImgSrc);
        
        $background = imagecreatetruecolor($bgX,$bgY);
        
        imagecopy($background, $this->backgroundImgSrc, 0, 0, 0, 0, $bgX, $bgY);
        imagecopy($background, $this->transparentImgSrc, (int)($_SESSION[$this->sessionXname]), (int)($_SESSION[$this->sessionYname]), 0, 0, $smX, $smY);
        
        $imgCrop = imagecrop($background, array('x' => (int)($_SESSION[$this->sessionXname]),'y' => (int)($_SESSION[$this->sessionYname]), 'width' => $smX, 'height' => $smY));
        
        imagealphablending($imgCrop,true);
        imagecolortransparent($imgCrop,$this->colorTransparentInt);
        imagesavealpha($imgCrop ,false);
        imagepng($imgCrop);
        imagedestroy($imgCrop);
    }
}
