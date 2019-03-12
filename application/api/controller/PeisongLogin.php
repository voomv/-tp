<?php
namespace app\api\controller;

use think\Session;
use think\Cache;
use app\common\controller\ApiBase;
use app\common\model\PeisongMember as PeisongMemberModel;
use app\common\model\VerificationCode as VerificationCodeModel;
use app\common\model\User as UserModel;

/**
 * 配送登录注册管理
 * Class PeisongLogin
 * @package app\api\controller
 */
class PeisongLogin extends ApiBase 
{
    protected $checkPeisongLogin = false;
    protected $peisong_member_model;
    protected $verification_code_model;
    protected $user_model;
    protected function _initialize()
    {
        parent::_initialize();
        $this->peisong_member_model = new PeisongMemberModel();//配送员表
        $this->verification_code_model = new VerificationCodeModel();//短信验证码表
        $this->user_model = new UserModel();//微信用户信息表

    }

    /**
     * @Author   admin
     * @Email    无
     * @DateTime 2018-11-26
     * 微信登录
     */
    public function WxLogin(){
        //接收数据
        $code  = $this->request->param('code');
        $username  = $this->request->param('username');
        $headimg  = $this->request->param('headimg');

        // 判断接受参数是否完整
        if(empty($code)){
            $this->err(400,"系统操作错误,请重试!");
        }
        if(empty($username)){$username = "匿名";}
        if(empty($headimg)){$headimg = HTTP_URL."/public/static/images/user.png";}

//        $appid = config('custom.CUSTOM_DISTRIBUTIONAPPID');
//        $appsecret = config('custom.CUSTOM_DISTRIBUTIONAPPSECRET');
        $appid = 'wxc4f4627a16418eac';
        $appsecret = 'c08df567dd27b323ff1c5cd15d1fa9ea';

        $url = "https://api.weixin.qq.com/sns/jscode2session?appid=$appid&secret=$appsecret&js_code=$code&grant_type=authorization_code";
        $data = send_get($url);

        //判断返回值是否完整
        $data = json_decode($data,true);

        if(empty($data['openid'])){
            $this->err(400,"系统操作错误,请重试!");
        }
        //判断使用是否登录过
        if($this->user_model->where(['openid'=>$data['openid'],'type'=>2])->find() == false){
            //未登录,执行第一次登录
            $user['openid'] = $data['openid'];
            $user['username'] = $username;
            $user['headimg'] = $headimg;
            $user['type'] = 2;
            $user['create_time'] = time();
            $user['last_login_time'] = time();
            $user['last_login_ip'] = $this->request->ip();
            //添加用户数据
            $user_id = $this->user_model->insertGetId($user);

            if($user_id){
                $this->datas = ['user_id'=>$user_id,'openid'=>$data['openid'],'username'=>$username,'headimg'=>$headimg,'msg'=>"登录成功!"];
            }else{
                $this->err(400,"系统操作错误,请重试!");
            }
        }else{
            // 已登录过,判断用户是否被禁用
            if($this->user_model->where(['openid' => $data['openid']])->value("status") == 0){
                $this->err(400,"抱歉,您的账号已被禁用!");
            }

            //已登录过,更新用户信息
            $user['username'] = $username;
            $user['headimg'] = $headimg;
            $user['last_login_time'] = time();
            $user['last_login_ip'] = $this->request->ip();

            //更新用户数据
            $this->user_model->save($user,['openid' => $data['openid']]);

            //获取用户ID
            $user_id = $this->user_model->where(['openid'=>$data['openid']])->value("id");

            $this->datas = ['user_id'=>$user_id,'openid'=>$data['openid'],'username'=>$username,'headimg'=>$headimg,'msg'=>"登录成功!"];
        }
    }

    /**
     * @Author   admin
     * @Email    无
     * @DateTime 2018-11-22
     * 用户七天免登陆处理
     */
    public function memberCache(){
        $member_id = $this->request->param('member_id');
        if(empty($member_id)){
            $this->err(400,'参数错误,请重试!' );
        }
        if(!$data = $this->peisong_member_model->where(['id'=>$member_id])->find()){
            $this->err(400,'用户不存在,请注册!');
        }

        $this->datas = $data;
    }

    /**
     * @Author   admin
     * @Email    无
     * @DateTime 2018-11-22
     * 配送员登录
     */
    public function login(){
        $mobile = $this->request->param('mobile');
        if(empty($mobile)){
            $this->err(400,'请输入登录手机号!');
        }
        if(!$this->peisong_member_model->where(['mobile'=>$mobile])->find()){
            $this->err(400,'抱歉,用户不存在');
        }
        $password = $this->request->param('password');
        if(empty($password)){
            $this->err(400,'请输入登录密码!');
        }
        $member = $this->peisong_member_model->where(['mobile'=>$mobile,'password'=>md5($password)])->find();
        if($member){
            if($member['review'] == 0){
                $this->err(400,'抱歉,您目前未通过审核,请等待审核后进行此操作!');
            }else{
                $this->datas = ['code'=>200,'msg'=>"登录成功!",'member_id'=>$member['id']];
            }
        }else{ 
            $this->err(400,'账号或密码错误,请重试!');
        }
    }

    /**
     * @Author   admin
     * @Email    无
     * @DateTime 2018-11-22
     * 配送员注册
     */
    public function registered(){
        $code = $this->request->param('code');
        $data['mobile'] = $this->request->param('mobile');
        if (empty($code) || empty($data['mobile'])) {
            $this->err(400,'验证码和手机号不能为空!' );
        }
        if ($this->peisong_member_model->where(['mobile' => $data['mobile']])->find()) {
            $this->err(400,'已存在该用户!' );
        }
        if (!$codeInfo = $this->verification_code_model->where(['mobile' => $data['mobile'],'code' => $code,'type'=>2])->order('id DESC')->find()) {
            $this->err(400,'短信验证码不正确');
        }
        if ($codeInfo['create_time']+600 < time()) {
            $this->err(400,'短信验证码已经过期');
        }
        if ($codeInfo['code'] != $code) {
            $this->err(400,'短信验证码不正确');
        }
        $data['password'] = $this->request->param('password');
        $confirm_password = $this->request->param('confirm_password');
        if (empty($data['password'])) {
            $this->err(400,'请输入密码!' );
        } else {
            $data['password'] = md5($data['password']);
        }
        if ($data['password'] != md5($confirm_password)) {
            $this->err(400,'两次密码不一致!' );
        }

        $data['name'] = $this->request->param('name');
        if(empty($data['name'])){
            $this->err(400,'请填写昵称!' );
        } 
        $data['card'] = $this->request->param('card');
        if(empty($data['card'])){
            $this->err(400,'请填写身份证号!' );
        }    
        $carl = '/(^[1-9]\d{5}(18|19|([23]\d))\d{2}((0[1-9])|(10|11|12))(([0-2][1-9])|10|20|30|31)\d{3}[0-9Xx]$)|(^[1-9]\d{5}\d{2}((0[1-9])|(10|11|12))(([0-2][1-9])|10|20|30|31)\d{3}$)/';
        if (!preg_match($carl, $data['card'])) {
            $this->err(400,'身份证格式不正确!' );
        }
        $data['card_positive'] = $this->request->param('card_positive');  
        if(empty($data['card_positive'])){
            $this->err(400,'身份证正面照片不能为空!' );
        }
        $data['card_back'] = $this->request->param('card_back');  
        if(empty($data['card_back'])){
            $this->err(400,'身份证反面照片不能为空!' );
        }
        $data['place'] = $this->request->param('place');
        if(empty($data['place'])){
            $this->err(400,'请填写地址!' );
        }
        $data['create_time'] = time();
        $data['review'] = 0;
        $data['status'] = 0;

        if($member_id = $this->peisong_member_model->insertGetId($data)){
            $this->datas = ['code'=>200,'msg'=>"注册成功!",'member_id'=>$member_id];
        }else{
            $this->err(400,'注册失败,请稍候再试!' );
        }
    }

    /**
     * @Author   admin
     * @Email    无
     * @DateTime 2018-11-26
     * 重置密码
     */
    public function findpwd(){
        $code = $this->request->param('code');
        $data['mobile'] = $this->request->param('mobile');
        if (empty($code) || empty($data['mobile'])) {
            $this->err(400,'验证码和手机号不能为空!' );
        }
        if (!$this->peisong_member_model->where(['mobile' => $data['mobile']])->find()) {
            $this->err(400,'不存在该用户!' );
        }
        if (!$codeInfo = $this->verification_code_model->where(['mobile' => $data['mobile'],'code' => $code,'type'=>2])->order('id DESC')->find()) {
            $this->err(400,'短信验证码不正确');
        }
        if ($codeInfo['create_time']+600 < time()) {
            $this->err(400,'短信验证码已经过期');
        }
        if ($codeInfo['code'] != $code) {
            $this->err(400,'短信验证码不正确');
        }
        $data['password'] = $this->request->param('password');
        $confirm_password = $this->request->param('confirm_password');
        if (empty($data['password'])) {
            $this->err(400,'请输入密码!' );
        } else {
            $data['password'] = md5($data['password']);
        }
        if ($data['password'] != md5($confirm_password)) {
            $this->err(400,'两次密码不一致!' );
        }

        if($this->peisong_member_model->save($data,['mobile'=>$data['mobile']])){
            $this->datas = ['code'=>200,'msg'=>"修改成功!"];
        }else{
            $this->err(400,'重置密码失败,请稍候再试!' );
        }
    }

    /**
     * @Author   admin
     * @Email    无
     * @DateTime 2018-11-26
     * 配送员状态切换
     */
    public function status(){
        $member_id = $this->request->param('member_id');
        $status = $this->request->param('status');

        if(empty($member_id) || $status == ""){
            $this->err(400,'参数错误!' );
        }
        if(!$this->peisong_member_model->where(['id'=>$member_id])->find()){
            $this->err(400,'抱歉,用户不存在');
        }
        
        if($this->peisong_member_model->where(['id'=> $member_id])->update(['status' => $status])){
            $this->datas = ['code'=>200,'msg'=>"切换成功!"];
        }else{
            $this->err(400,'切换失败,请重试!');
        }
    }

    /**
     * @Author   admin
     * @Email    无
     * @DateTime 2018-11-22
     * 获取短信验证码
     */
    public function sendSms()
    {   
        $openid = $this->request->param('openid');
        if(empty($openid)){
            $this->err(400,'参数错误,请重试!' );
        }
        $mobile = $this->request->param('mobile');
        if (!$this->checkMobile($mobile)) {
            $this->err(400,'请填写正确的是手机号!' );
        }
        $verify = $this->request->param('verify');
        $verify2 = Cache::get($openid);

        if($verify == '' || strtolower($verify) != strtolower($verify2)){
            $this->err(400,'请填写正确的验证码!' );
        }
      
        // 查询上个验证码是否过期
        $info = $this->verification_code_model->where(['mobile'=>$mobile,'type'=>2])->find();
        if(!empty($info)){
            if($info['create_time']+600 > time()){
                // 未过期
                $code = $info['code'];
                $res = 1;
            }else{
                $code = rand(100000,999999);
                $res = $this->verification_code_model->save(['mobile'=>$mobile,'code'=>$code,'create_time'=>time(),'type'=>2]);
            }
        }else{
            $code = rand(100000,999999);
            $res = $this->verification_code_model->save(['mobile'=>$mobile,'code'=>$code,'create_time'=>time(),'type'=>2]);
        }
        if($res !== 1){
            $this->err(400,"发送失败,请稍候再试!");
        }
        // 发送短信
        $result = send_tencent_sms($mobile,[$code]);
        if (!empty($result->errmsg) && $result->errmsg == "OK") {
            Cache::rm($openid);
            $this->datas = ['code'=>200,'msg'=>"短信发送成功10分钟内有效"];
        } else {
            $this->err(400,"短信发送失败!");
        }
    }

    /**
     * @Author   admin
     * @Email    无
     * @DateTime 2018-11-22
     * 验证手机号
     */
    public function checkMobile($tel)
    {
        $search = '/^1[0-9]{1}\d{9}$/';
        if (preg_match($search, $tel)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @Author   admin
     * @Email    无
     * @DateTime 2018-11-22
     * 获取图片验证码
     */
    public function code(){
        $openid = $this->request->param('openid');
        if(empty($openid)){
            $this->err(400,'参数错误,请重试!' );
        }
        $image = new \app\common\library\Captcha();
        $url = $image->create($openid);
        $this->datas = ['code'=>200,'image'=>HTTP_URL.substr($url,1)];
    }   
}