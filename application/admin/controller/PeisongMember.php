<?php
namespace app\admin\controller;

use app\common\controller\AdminBase;
use think\Db;
use think\Session;
use think\Cache;

use app\common\model\PeisongMember as PeisongMemberModel;
use app\common\model\VerificationCode as VerificationCodeModel;

/**
 * 配送员管理
 * Class PeisongMember
 * @package app\admin\controller
 */
class PeisongMember extends AdminBase 
{
    protected $peisong_member_model;
    protected $verification_code_model;
    protected function _initialize()
    {
        parent::_initialize();
        $this->peisong_member_model = new PeisongMemberModel();//配送员表
        $this->verification_code_model = new VerificationCodeModel();//短信验证码表
    }

    /**
     * @Author   admin
     * @Email    无
     * @DateTime 2018-11-22
     * 配送员列表
     */
    public function index($page=1,$name="",$mobile="") {
        $where = [];
        if (!empty($name)) {
            $where['name'] = ['LIKE', '%' . $name . '%'];
        }
        if (!empty($mobile)) {
            $where['mobile'] = ['LIKE', '%' . $mobile . '%'];
        }

        $list = $this->peisong_member_model->where($where)->order('id DESC')->paginate(15, false, ['page' => $page]);

        return $this->fetch('index',['list'=>$list,'name'=>$name,'mobile'=>$mobile]);
    }

    /**
     * @Author   admin
     * @Email    无
     * @DateTime 2018-11-22
     * 添加配送员
     */
    public function add() {
         return $this->fetch();
    }

    /**
     * @Author   admin
     * @Email    无
     * @DateTime 2018-11-22
     * 保存配送员
     */
    public function save(){
        $data['name'] = $this->request->param('name');
        if (empty($data['name'])) {
            $this->error('姓名不能为空');
        }
        $data['mobile'] = $this->request->param('mobile');
        if (empty($data['mobile'])) {
            $this->error('手机号码不能为空');
        }
         $tel = '/^1[3|4|5|6|7|8|9][0-9]{1}[0-9]{8}$/';
        if (!preg_match($tel, $data['mobile'])) {
            $this->error('手机号格式不正确');
        }
        if ($this->peisong_member_model->where(['mobile' => $data['mobile']])->find()) {
            $this->error('已存在该用户');
        }
        $code = $this->request->param('code');
        if (empty($code)) {
            $this->error('短信验证码不能为空');
        }
        if (!$codeInfo = $this->verification_code_model->where(['mobile' => $data['mobile'],'code' => $code,'type'=>1])->order('id DESC')->find()) {
//            $this->error('短信验证码不正确');
        }
        if ($codeInfo['create_time']+600 < time()) {
//            $this->error('短信验证码已经过期');
        }
        if ($codeInfo['code'] != $code) {
//            $this->error('短信验证码不正确');
        }
        $password = $this->request->param('password');  
        $confirm_password = $this->request->param('confirm_password');  
        if(empty($password)){
            $this->error('请输入登入密码');
        }
        if(strlen($password) < 8){
            $this->error('抱歉,密码至少输入八位');
        }
        if(empty($confirm_password)){
            $this->error('重复密码不能为空');
        }
        if($password !== $confirm_password){
            $this->error('两次输入密码不一致');
        }
        $data['password'] = md5($password);
        

        $data['card'] = $this->request->param('card');
        if(empty($data['card'])){
            $this->error('请填写身份证号');
        }    

        $carl = '/(^[1-9]\d{5}(18|19|([23]\d))\d{2}((0[1-9])|(10|11|12))(([0-2][1-9])|10|20|30|31)\d{3}[0-9Xx]$)|(^[1-9]\d{5}\d{2}((0[1-9])|(10|11|12))(([0-2][1-9])|10|20|30|31)\d{3}$)/';
        if (!preg_match($carl, $data['card'])) {
            $this->error('身份证格式不正确');
        }
        $data['card_positive'] = $this->request->param('card_positive');  
        if(empty($data['card_positive'])){
            $this->error('身份证正面照片不能为空');
        }
        $data['card_back'] = $this->request->param('card_back');  
        if(empty($data['card_back'])){
            $this->error('身份证反面照片不能为空');
        }
        $data['place'] = $this->request->param('place');
        if(empty($data['place'])){
            $this->error('请填写地址');
        }
        $data['review'] = $this->request->param('review');  
        if(empty($data['review'])){
            $data['review'] = 0;
        }
        $data['create_time'] = time();

        if($this->peisong_member_model->save($data)){
            $this->success('添加成功',"/admin/peisong_member/index");
        }else{
             $this->error('添加失败');
        }
    }

    /**
     * @Author   admin
     * @Email    无
     * @DateTime 2018-11-22
     * 编辑配送员
     */
    public function edit() {
        $id = (int) $this->request->param('id');
        if(empty($id)){
            $this->error('参数错误!');
        }
        if (!$detail = $this->peisong_member_model->get($id)) {
            $this->error('抱歉,信息不存在!');
        }

        return $this->fetch("edit",['detail'=>$detail]);
    }

    /**
     * @Author   admin
     * @Email    无
     * @DateTime 2018-11-22
     * 配送员更新
     */
    public function update(){
        $id = $this->request->param('id');  
        if (empty($id)) {
            $this->error('参数错误!');
        }
        $data['name'] = $this->request->param('name');
        if (empty($data['name'])) {
            $this->error('姓名不能为空');
        }
        $data['mobile'] = $this->request->param('mobile');
        if (empty($data['mobile'])) {
            $this->error('手机号码不能为空');
        }
         $tel = '/^1[3|4|5|6|7|8|9][0-9]{1}[0-9]{8}$/';
        if (!preg_match($tel, $data['mobile'])) {
            $this->error('手机号格式不正确');
        }
        $data['card'] = $this->request->param('card');
        if(empty($data['card'])){
            $this->error('请填写身份证号');
        }    
        $carl = '/(^[1-9]\d{5}(18|19|([23]\d))\d{2}((0[1-9])|(10|11|12))(([0-2][1-9])|10|20|30|31)\d{3}[0-9Xx]$)|(^[1-9]\d{5}\d{2}((0[1-9])|(10|11|12))(([0-2][1-9])|10|20|30|31)\d{3}$)/';
        if (!preg_match($carl, $data['card'])) {
            $this->error('身份证格式不正确');
        }
        $data['card_positive'] = $this->request->param('card_positive');  
        if(empty($data['card_positive'])){
            $this->error('身份证正面照片不能为空');
        }
        $data['card_back'] = $this->request->param('card_back');  
        if(empty($data['card_back'])){
            $this->error('身份证反面照片不能为空');
        }
        $data['place'] = $this->request->param('place');
        if(empty($data['place'])){
            $this->error('请填写地址');
        }
        $data['review'] = $this->request->param('review');  
        if(empty($data['review'])){
            $data['review'] = 0;
        }

        if($this->peisong_member_model->save($data,['id'=>$id])){
            $this->success('修改成功',"/admin/peisong_member/index");
        }else{
             $this->error('修改失败');
        }
    }

    /**
     * @Author   admin
     * @Email    无
     * @DateTime 2018-11-22
     * 删除配送员
     */
    public function delete($id = 0, $ids = [])
    {
        $id = $ids ? $ids : $id;
        if ($id) {
            if ($this->peisong_member_model->destroy($id)) {
                $this->success('删除成功');
            } else {
                $this->error('删除失败');
            }
        } else {
            $this->error('请选择需要删除的配送员');
        }
    }

    /**
     * @Author   admin
     * @Email    无
     * @DateTime 2018-11-22
     * 审核状态切换
     */
    public function toggle($ids = [], $type = '')
    {
        $data   = [];
        $review = $type == 'audit' ? 1 : 0;

        if (!empty($ids)) {
            foreach ($ids as $value) {
                $data[] = ['id' => $value, 'review' => $review];
            }
            if ($this->peisong_member_model->saveAll($data)) {
                $this->success('操作成功');
            } else {
                $this->error('操作失败');
            }
        } else {
            $this->error('请选择需要操作的配送员');
        }
    }

    /**
     * @Author   admin
     * @Email    无
     * @DateTime 2018-11-22
     * 发送短信验证码
     */
    public function sendSms()
    {   
        $mobile = $this->request->param('mobile');
        if (!$this->checkMobile($mobile)) {
            return json(['code'=>0,'msg'=>"请填写正确的是手机号!"]);
        }
        $verify = $this->request->param('verify');
        if(!captcha_check($verify)){
            return json(['code'=>0,'msg'=>"请填写正确的图片验证码!"]);
        }
        // 查询上个验证码是否过期
        $info = $this->verification_code_model->where(['mobile'=>$mobile,'type'=>1])->find();
        if(!empty($info)){
            if($info['create_time']+600 > time()){
                // 未过期
                $code = $info['code'];
                $res = 1;
            }else{
                $code = rand(100000,999999);
                $res = $this->verification_code_model->save(['mobile'=>$mobile,'code'=>$code,'create_time'=>time(),'type'=>1]);
            }
        }else{
            $code = rand(100000,999999);
            $res = $this->verification_code_model->save(['mobile'=>$mobile,'code'=>$code,'create_time'=>time(),'type'=>1]);
        }
        if($res !== 1){
            return json(['code'=>0,'msg'=>"发送失败,请稍候再试!"]);
        }
        // 发送短信
        $result = send_tencent_sms($mobile,[$code]);
        if (!empty($result->errmsg) && $result->errmsg == "OK") {
            return ['code'=>1,'msg'=>"短信发送成功10分钟内有效"];
        } else {
            return ['code'=>0,'msg'=>"短信发送失败"];
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
}