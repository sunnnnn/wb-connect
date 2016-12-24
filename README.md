# wb-connect - ThinkPHP 5 微博登录

用于tp5框架下的微博快捷登录

composer安装: composer require sunnnnn/wb-connect

添加公共配置:
config.php
// 微博互联配置
'wbconnect' => [
    'key' => '',  //AKEY
    'appkey' => '', //SKEY
    'callback' => '', //回调地址
]

## 示例代码

### 页面编写:
#<a href="{:url('/oauth/wbLogin')}">QQ登录</a>

### 控制器编写:

登录
Oauth.php
use sunnnnn\wbconnect\WcTp5;
class oauthController extends \think\Controller{
    public function qqLogin()
    {
        $oauth = new WcTp5();
        return $this->redirect(oauth->getLoginUrl());
    }
}

回调
Callback.php
use sunnnnn\wbconnect\WcTp5;
class CallbackController extends \think\Controller
{
    public function callback()
    {
        $oauth = new WcTp5();
		$userInfo = $oauth->getUserInfo($_GET['code']);
    }
}