# image_drag_auth
php image drag auth plugin, php写的图片拖动验证插件, php写的滑动旋转图片验证插件      

## 一、php运行要求 ##   
用到了php GD库的imagecrop方法，此方法对php版本有要求(PHP 5 >= 5.5.0, PHP 7)   

## 二，使用说明 ##   
直接down下来就可以使用了，根据自己的情况更换背景图，以及拖动区的形状[两张图，同样大小和形状，一个镂空，一个填充]   

## 三、注意事项 ##   
图片拖动验证的本质是分步验证！ 所以在调用validation方法的时候，需要传一个第二步验证的session名，默认session名是setpSession，在提交之后在你自己的后续逻辑里面需要对setpSession进行验证，验证成功之后需要及时把它设置unset掉，或者设置成false，否则就会形成第二次提交无需验证的漏洞。

## 四、应用Demo ##  
zf3框架下的实现[结合redis，应对更高的并发]    
yaf框架下也有实现[结合redis，应对更高的并发]   
之前的放demo的网站出售掉了，go+原生js重写，地址是 https://www.yuceai.com/rotate/rotate.html 无依赖。  

## 五、成品源码赞赏后获得 ##  
* 滑动拼图验证yaf版源码 50  
* 滑动拼图验证zf3(laminas)版源码 100  
* 滑动图片旋转向上yaf版源码 50  
* 滑动图片旋转向上zf3(laminas)版源码 100  
* 滑动图片旋转向上go编译版(一个编译好的可执行文件+混淆的前端代码) 10    
* 滑动图片旋转向上go源码(go源码+js打包前的代码) 1000    
* 滑动图片旋转向上go在线版(一对key，远程调用我的接口) 20    

## 欢迎联系我 ##  

抖音：  
<img width="280" height="280" src="https://www.yuceai.com/img/zanshang/douyin.png"/>

## 赞赏多少是您的心意，感谢支持！ ##  
微信赞赏码： <img width="200" height="200" src="https://www.yuceai.com/img/zanshang/weixinzanshang.png"/>
支付宝赞助码： <img width="200" height="200" src="https://www.yuceai.com/img/zanshang/alipay.png"/>