<?php
namespace app\api\controller;

use app\common\model\User as UserModel;
use app\common\controller\ApiBase;
use think\Config;
use think\Db;

/**
 * 用户登录控制器
 * Class Login
 * @package app\api\controller
 */
class Login extends ApiBase
{
    protected $user_model;

    protected function _initialize()
    {
        parent::_initialize();
        
        $this->user_model = new UserModel();
    }
    
    /**
     * @Author   admin
     * @Email    无
     * @DateTime 2018-08-22
     * 用户登录
     */
    public function Login(){
        //接收数据
        $code  = $this->request->param('code');
        $username  = $this->request->param('username');
        $headimg  = $this->request->param('headimg');

        // 判断接受参数是否完整
        if(empty($code)){
            $this->err(400,"系统操作错误,请重试!");
        }
        if(empty($username)){$username = "匿名";}
        if(empty($headimg)){$headimg = "https://cjimg.mendian51.cn/564c0201809051156047724.png";}

        $appid = config('custom.CUSTOM_USERAPPID');
        $appsecret = config('custom.CUSTOM_USERAPPSECRET');

        $url = "https://api.weixin.qq.com/sns/jscode2session?appid=$appid&secret=$appsecret&js_code=$code&grant_type=authorization_code";
        $data = send_get($url);

        //判断返回值是否完整
        $data = json_decode($data,true);

        if(empty($data['openid'])){
            $this->err(400,"系统操作错误,请重试!");
        }
        //判断使用是否登录过
        if($this->user_model->where(['openid'=>$data['openid'],'type'=>1])->find() == false){
            //未登录,执行第一次登录
            $user['openid'] = $data['openid'];
            $user['username'] = $username;
            $user['headimg'] = $headimg;
            $user['type'] = 1;
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
}