<?php
namespace app\common\library;

require_once './vendor/tencent_sms/index.php';

use Qcloud\Sms\SmsSingleSender;
use Qcloud\Sms\SmsMultiSender;
use Qcloud\Sms\SmsVoiceVerifyCodeSender;
use Qcloud\Sms\SmsVoicePromptSender;
use Qcloud\Sms\SmsStatusPuller;
use Qcloud\Sms\SmsMobileStatusPuller;

use Qcloud\Sms\VoiceFileUploader;
use Qcloud\Sms\FileVoiceSender;
use Qcloud\Sms\TtsVoiceSender;

class TencentSms
{
    /**
     * @Author   admin
     * @Email    无
     * @DateTime 2018-08-29
     * 初始化
     */
    public function __construct($appid="",$appkey="",$templateId="",$smsSign="") {
        // 短信应用SDK AppID
        $this->appid = $appid;
        // 短信应用SDK AppKey
        $this->appkey = $appkey;
        // 短信模板ID，需要在短信应用中申请
        $this->templateId = $templateId;  // NOTE: 这里的模板ID`7839`只是一个示例，真实的模板ID需要在短信控制台中申请
        // 签名
        $this->smsSign = $smsSign; // NOTE: 这里的签名只是示例，请使用真实的已申请的签名，签名参数使用的是`签名内容`，而不是`签名ID`
    }

    /**
     * @Author   admin
     * @Email    无
     * @DateTime 2018-08-29
     * 指定模板ID单发短信
     */
    public function sendSms($mobile,$content){
        $ssender = new SmsSingleSender($this->appid, $this->appkey);
        $result = $ssender->sendWithParam("86", $mobile, $this->templateId, $content, $this->smsSign);// 签名参数未提供或者为空时，会使用默认签名发送短信
        return json_decode($result);
    }

    /**
     * @Author   admin
     * @Email    无
     * @DateTime 2018-08-29
     * 指定模板ID群发
     */
    public function sendAllSms($mobiles,$content){
        $msender = new SmsMultiSender($this->appid, $this->appkey);
        $result = $msender->sendWithParam("86", $mobiles,$this->templateId, $content, $this->smsSign, "", "");  // 签名参数未提供或者为空时，会使用默认签名发送短信
        return json_decode($result);
    }
}
