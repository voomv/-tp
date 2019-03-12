<?php
namespace app\common\controller;

use org\Auth;
use think\Loader;
use think\Cache;
use think\Controller;
use think\Db;
use think\Session;

/**
 * @Author   admin
 * @Email    无
 * @DateTime 2018-08-22
 * API接口公用基础控制器
 * Class ApiBase
 * @package app\common\controller
 */
class ApiBase extends Controller
{
    protected $datas = [];//返回的数据
    protected $code = 200;//返回的code  [200--成功  400--失败  500--服务器错误]
    protected $error = '';//返回的错误信息
    protected $isReturn = false;
    protected $checkUserLogin = false;
    protected $checkPeisongLogin = false;
    protected $checkPeisongWxLogin = false;

    protected function _initialize()
    {
        parent::_initialize();

        /*用户端登录验证*/
        if($this->checkUserLogin == true){
            $this->checkUser();
        }

        /*配送端微信登录验证*/
        if($this->checkPeisongWxLogin == true){
            $this->checkPeisongWx();
        }

        /*配送端手机登录验证*/
        if($this->checkPeisongLogin == true){
            $this->checkPeisong();
        }

        // 更新订单状态--已失效
        update_order();
    }

    /**
     * @Author   admin
     * @Email    无
     * @DateTime 2018-11-22
     * 判断用户是否登录--用户端
     */
    protected function checkUser(){
        $User = new \app\common\model\User();
        $openid = $this->request->param('openid');
        if(empty($openid)){
            $this->err(400,"抱歉,请先登录!");
        }
        if(!$user = $User->where(['openid'=>$openid,'type'=>1])->find()){
            $this->err(400,"抱歉,请先登录!");
        }

        // 判断用户是否被禁用
        if($user['status'] == 0){
            $this->err(400,"抱歉,您的账号已被禁用!");
        }

        $this->openid = $openid;
        $this->user_id = $user['id'];
        $this->user  = $user;
    }

    /**
     * @Author   admin
     * @Email    无
     * @DateTime 2018-11-22
     * 判断用户是否登录(微信)--配送端
     */
    protected function checkPeisongWx(){
        $User = new \app\common\model\User();
        $openid = $this->request->param('openid');
        if(empty($openid)){
            $this->err(400,"抱歉,请先登录!");
        }
        if(!$user = $User->where(['openid'=>$openid,'type'=>2])->find()){
            $this->err(400,"抱歉,请先微信授权!");
        }

        $this->peisong_openid = $openid;
        $this->peisong_user  = $user;
    }

    /**
     * @Author   admin
     * @Email    无
     * @DateTime 2018-11-22
     * 判断用户是否登录(手机)--配送端
     */
    protected function checkPeisong(){
        $PeisongMember = new \app\common\model\PeisongMember();
        $member_id = $this->request->param('member_id');
        if(empty($member_id)){
            $this->err(400,"抱歉,请先登录!");
        }
        if(!$Member = $PeisongMember->where(['id'=>$member_id])->find()){
            $this->err(400,"抱歉,请先登录!");
        }

        $this->member_id = $Member['id'];
        $this->member  = $Member;
    }

    /**
     * @Author   admin
     * @Email    无
     * @DateTime 2018-08-22
     * 抛出异常处理
     */
    protected function err($errCode,$msg){
        $this->code  = $errCode;
        $this->error = $msg;
        $this->isReturn = true;
        $this->result($this->datas,  $this->code,  $this->error,'json');
    }

    /**
     * @Author   admin
     * @Email    无
     * @DateTime 2018-08-22
     * 返回数据
     */
    protected  function  btt($msg = ''){
        $this->err(200,$msg);
    }

//    public function __destruct() {
//       if(!$this->isReturn){
//           $this->btt('访问成功');
//       }
//    }
}