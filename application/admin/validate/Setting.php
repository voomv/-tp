<?php
namespace app\admin\validate;

use think\Validate;

class Setting extends Validate
{
    protected $rule = [
        'UserAppID'                => 'require',
        'UserAppSecret'                => 'require',
        'DistributionAppID'             => 'require',
        'DistributionAppSecret'             => 'require',
        'MchID'             => 'require',
        'WxKey'             => 'require',
        'ApiclientCert'             => 'require',
        'ApiclientKey'             => 'require',
        'SmsAppID'             => 'require',
        'SmsAppKey'             => 'require',
        'SmsTemplateId'             => 'require',
        'SmsSign'             => 'require',
    ];

    protected $message = [
        'UserAppID.require'                => '请输入用户端小程序ID',
        'UserAppSecret.require'                => '请输入用户端小程序密钥',
        'DistributionAppID.require'                => '请输入配送端小程序appID',
        'DistributionAppSecret.require'                => '请输入配送端小程序密钥',
        'MchID.require'                => '请输入微信支付--商户号',
        'WxKey.require'                => '请输入微信支付--密钥',
        'ApiclientCert.require'                => '请上传微信支付--证书',
        'ApiclientKey.require'                => '请上传微信支付--密钥',
        'SmsAppID.require'                => '请输入腾讯短信--appid',
        'SmsAppKey.require'                => '请输入腾讯短信--appkey',
        'SmsTemplateId.require'                => '请输入腾讯短信--模版id',
        'SmsSign.require'                => '请输入腾讯短信--签名正文',
    ];
}