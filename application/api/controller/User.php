<?php
namespace app\api\controller;

use think\Session;
use think\Cache;
use app\common\controller\ApiBase;
use app\common\model\User as UserModel;
use app\common\model\UserBalanceLog as UserBalanceLogModel;
use app\common\model\UserCoupon as UserCouponModel;

/**
 * 个人中心管理
 * Class User
 * @package app\api\controller
 */
class User extends ApiBase 
{
    protected $checkUserLogin = true;
    protected $user_model;
    protected $user_balance_log_model;
    protected $user_coupon_model;
    protected function _initialize()
    {
        parent::_initialize();
        $this->user_model = new UserModel();//用户信息表
        $this->user_balance_log_model = new UserBalanceLogModel();//用户余额记录表
        $this->user_coupon_model = new UserCouponModel();//用户优惠卷表
    }

    /**
     * @Author   admin
     * @Email    无
     * @DateTime 2018-11-30
     * 个人信息
     */
    public function index(){
        // 昵称
        $this->datas['username'] = $this->user->username;
        // 头像
        $this->datas['headimg'] = $this->user->headimg;
        // 余额
        $this->datas['balance'] = $this->user->balance;
        // 优惠券个数
        $where['member_id'] = $this->user_id;
        $where['is_use'] = 0;
        $where['bg_data'] = ['elt',time()];
        $where['end_data'] = ['egt',time()];
        $this->datas['coupon_count'] = $this->user_coupon_model->where($where)->count();
    }

    /**
     * @Author   admin
     * @Email    无
     * @DateTime 2018-11-27
     * 我的余额
     */
    public function balance(){
        $this->datas = $this->user->balance;
    }

    /**
     * @Author   admin
     * @Email    无
     * @DateTime 2018-11-29
     * 余额记录
     */
    public function balance_log(){
        $where['uid'] = $this->user_id;
        $where['status'] = 1;
        $list = $this->user_balance_log_model->where($where)->field("type,money,create_time")->order('create_time DESC')->select();
        $log = [];
        foreach ($list as $k => $v) {
            // 封装状态
            if($v['type'] == 1){
                $list[$k]['type_name'] = "用户充值";
            }elseif($v['type'] == 2){
                $list[$k]['type_name'] = "消费支出";
            }elseif($v['type'] == 3){
                $list[$k]['type_name'] = "购物退款";
            }elseif($v['type'] == 4){
                $list[$k]['type_name'] = "余额提现";
            }
            // 封装时间
            $list[$k]['create_time'] = date("Y-m-d H:i:s",$v['create_time']);
        }

        $this->datas = $list;
    }

    /**
     * @Author   admin
     * @Email    无
     * @DateTime 2018-11-27
     * 余额充值
     */
    public function balance_recharge(){
        // 判断是否配置支付
        if(empty(config('custom.CUSTOM_USERAPPID')) || empty(config('custom.CUSTOM_MCHID')) || empty(config('custom.CUSTOM_WXKEY')) || empty(config('custom.CUSTOM_USERAPPSECRET')) || empty(config('custom.CUSTOM_APICLIENTCERT')) || empty(config('custom.CUSTOM_APICLIENTKEY'))){
            $this->err(400,"抱歉,未配置微信支付,请联系管理员!");
        }

        $money = $this->request->param('money');
        if(empty($money)){
            $this->err(400,"请输入充值金额!");
        }
        // 判断充值金额
        if($money < 0.01){
            $this->err(400,"充值金额不能小于0.01!");
        }
        // 添加充值订单记录
        $data['uid'] = $this->user_id;
        $data['type'] = 1;
        $data['money'] = $money;
        $data['status'] = 0;
        $data['create_time'] = time();
        if(!$log_id = $this->user_balance_log_model->insertGetId($data)){
            $this->err(400,"充值失败,请稍候再试!");
        }

        define('WX_APPID', config('custom.CUSTOM_USERAPPID'));
        define('WX_MCHID', config('custom.CUSTOM_MCHID'));
        define('WX_KEY', config('custom.CUSTOM_WXKEY'));
        define('WX_APPSECRET', config('custom.CUSTOM_USERAPPSECRET'));
        define('WX_SSLCERT_PATH', ROOT_PATH . config('custom.CUSTOM_APICLIENTCERT'));
        define('WX_SSLKEY_PATH', ROOT_PATH . config('custom.CUSTOM_APICLIENTKEY'));
        define('WX_CURL_PROXY_HOST', '0.0.0.0');
        define('WX_CURL_PROXY_PORT', 0);
        define('WX_REPORT_LEVENL', 0);
        require_once ROOT_PATH . "/vendor/weixinpay/lib/WxPay.Api.php";
        require_once ROOT_PATH . "/vendor/weixinpay/example/WxPay.JsApiPay.php";
        $tools = new \JsApiPay();
        $input = new \WxPayUnifiedOrder();
        $input->SetBody("余额充值");
        $input->SetAttach($log_id);
        $input->SetOut_trade_no(WX_MCHID . rand(1000, 9999) . $log_id);
        $input->SetTotal_fee($money*100);
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetNotify_url("http://" . $_SERVER['HTTP_HOST'] . "/api/Payment/pay_balance");
        $input->SetTrade_type("JSAPI");
        $input->SetOpenid($this->openid);
        $order = \WxPayApi::unifiedOrder($input);
        $jsApiParameters = $tools->GetJsApiParameters($order);

        $this->datas= json_decode($jsApiParameters, true);
    }

    /**
     * @Author   admin
     * @Email    无
     * @DateTime 2018-12-03
     * 余额提现
     */
    public function withdraw(){
        // 判断是否配置支付
        if(empty(config('custom.CUSTOM_USERAPPID')) || empty(config('custom.CUSTOM_MCHID')) || empty(config('custom.CUSTOM_WXKEY')) || empty(config('custom.CUSTOM_USERAPPSECRET')) || empty(config('custom.CUSTOM_APICLIENTCERT')) || empty(config('custom.CUSTOM_APICLIENTKEY'))){
            $this->err(400,"抱歉,未配置微信支付,请联系管理员!");
        }

        $money = $this->request->param('money');
        if(empty($money)){
            $this->err(400,"请输入提现金额!");
        }
        // 判断充值金额
        if($money < 0.01){
            $this->err(400,"充值金额不能小于0.01!");
        }
        // 判断账户余额是否充足
        $balance = $this->user_model->where(['id'=>$this->user_id])->value("balance");
        if(empty($balance) || $balance<$money){
            $this->err(400,"抱歉,账户余额不足!");
        }
        //开启事务
        $this->user_balance_log_model->startTrans();

        // 添加充值订单记录
        $data['uid'] = $this->user_id;
        $data['type'] = 4;
        $data['money'] = $money;
        $data['status'] = 1;
        $data['create_time'] = time();
        $log_id = $this->user_balance_log_model->insertGetId($data);
        // 扣除账户余额
        $res2 = $this->user_model->where(['id'=>$this->user_id])->setDec('balance',$money);

        if(empty($log_id) || empty($res2)){
            // 回滚事务
            $this->user_balance_log_model->rollback();
            $this->err(400,"提现失败,请稍候再试!");
        }

        $partner_trade_no = config('custom.CUSTOM_MCHID') . rand(1000, 9999) . $log_id;//提现订单号

        define('WX_APPID', config('custom.CUSTOM_USERAPPID'));
        define('WX_MCHID', config('custom.CUSTOM_MCHID'));
        define('WX_KEY', config('custom.CUSTOM_WXKEY'));
        define('WX_APPSECRET', config('custom.CUSTOM_USERAPPSECRET'));
        define('WX_SSLCERT_PATH', ROOT_PATH . config('custom.CUSTOM_APICLIENTCERT'));
        define('WX_SSLKEY_PATH', ROOT_PATH . config('custom.CUSTOM_APICLIENTKEY'));
        define('WX_CURL_PROXY_HOST', '0.0.0.0');
        define('WX_CURL_PROXY_PORT', 0);
        define('WX_REPORT_LEVENL', 0);
        require_once ROOT_PATH . "/vendor/weixinpay/lib/WxMchPay.php";
        $WxMchPay = new \WxMchPay();
        $result = $WxMchPay->MchPayOrder($this->openid, $money*100, $partner_trade_no);
        
        if($result['return_code'] == "SUCCESS" && $result['result_code'] == "SUCCESS" && $result['return_msg'] == []){
            // 更新提现信息
            $this->user_balance_log_model->save(['pay_info'=>json_encode($result),'pay_money'=>$money,'pay_time'=>time()],['id'=>$log_id]);
            // 提交事务
            $this->user_balance_log_model->commit(); 
            $this->datas = ['code'=>200,'msg'=>"提现成功!"];
        }else{
            // 回滚事务
            $this->user_balance_log_model->rollback();
            $this->err(400,"提现失败,请稍候再试!");
        }
    }
}