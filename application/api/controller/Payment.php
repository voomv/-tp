<?php
namespace app\api\controller;

use app\common\controller\ApiBase;
use think\Config;
use think\Db;

/**
 * 支付回调控制器
 * Class Payment
 * @package app\api\controller
 */
class Payment extends ApiBase
{
    /**
     * @Author   admin
     * @Email    无
     * @DateTime 2018-11-27
     * 余额充值回调
     */
    public function pay_balance()
    {
        define('WX_APPID', config('custom.CUSTOM_USERAPPID'));
        define('WX_MCHID', config('custom.CUSTOM_MCHID'));
        define('WX_KEY', config('custom.CUSTOM_WXKEY'));
        define('WX_APPSECRET', config('custom.CUSTOM_USERAPPSECRET'));
        define('WX_SSLCERT_PATH', config('custom.CUSTOM_APICLIENTCERT'));
        define('WX_SSLKEY_PATH', config('custom.CUSTOM_APICLIENTKEY'));
        define('WX_CURL_PROXY_HOST', '0.0.0.0');
        define('WX_CURL_PROXY_PORT', 0);
        define('WX_REPORT_LEVENL', 0);
        
        require_once ROOT_PATH . '/vendor/weixinpay/lib/PaybalanceCallback.php';
        $WxPay = new \PaybalanceCallback();
        $WxPay->Handle(false);
    }
    /**
     * @Author   康梓航
     * @Email    1275910740@qq.com
     * @DateTime 2018-11-28
     * @return   [type]            [description]
     * 商品微信购买支付回调
     */
    public function pay_mall(){

        define('WX_APPID', config('custom.CUSTOM_USERAPPID'));
        define('WX_MCHID', config('custom.CUSTOM_MCHID'));
        define('WX_KEY', config('custom.CUSTOM_WXKEY'));
        define('WX_APPSECRET', config('custom.CUSTOM_USERAPPSECRET'));
        define('WX_SSLCERT_PATH', config('custom.CUSTOM_APICLIENTCERT'));
        define('WX_SSLKEY_PATH', config('custom.CUSTOM_APICLIENTKEY'));
        define('WX_CURL_PROXY_HOST', '0.0.0.0');
        define('WX_CURL_PROXY_PORT', 0);
        define('WX_REPORT_LEVENL', 0);

        require_once ROOT_PATH . '/vendor/weixinpay/lib/PaymallCallback.php';
        $WxPay = new \PaymallCallback();
        $WxPay->Handle(false);        

    }
}