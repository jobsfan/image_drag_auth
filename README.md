# image_drag_auth
php image drag auth plugin, php写的图片拖动验证插件   

## 要求 ##   
用到了php GD库的imagecrop方法，此方法对php版本有要求(PHP 5 >= 5.5.0, PHP 7)   

## 使用 ##   
直接down下来就可以使用了，根据自己的情况更换背景图，以及拖动区的形状[两张图，同样大小和形状，一个镂空，一个填充]   

## 注意事项 ##   
图片拖动验证的本质是分步验证！ 所以在调用validation方法的时候，需要传一个第二步验证的session名，默认session名是setpSession，在提交之后在你自己的后续逻辑里面需要对setpSession进行验证，验证成功之后需要及时把它设置unset掉，或者设置成false，否则就会形成第二次提交无需验证的漏洞。

## 应用Demo ##  
zf3框架下的实现[结合redis，应对更高的并发] https://www.wendangs.com/api/imagedragauth/demo   
yaf框架下也有实现[结合redis，应对更高的并发]，不过是公司项目，不方便贴在这里
