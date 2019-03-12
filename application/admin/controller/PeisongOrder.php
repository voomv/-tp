<?php

namespace app\admin\controller;

use app\common\controller\AdminBase;
use think\Db;
use think\Session;
use think\Cache;
use app\common\model\PeisongMember as PeisongMemberModel;
use app\common\model\PeisongOrder as PeisongOrderModel;
use app\common\model\Order as OrderModel;
use app\common\model\OrderGoods as OrderGoodsModel;
use app\common\model\User as UserModel;
use app\common\controller\ServerAPI;

/**
 * 配送订单管理
 * Class PeisongOrder
 * @package app\admin\controller
 */
class PeisongOrder extends AdminBase {

    protected $peisong_member_model;
    protected $peisong_order_model;
    protected $order_model;
    protected $order_goods_model;
    protected $user_model;

    protected function _initialize() {
        parent::_initialize();
        $this->order_goods_model = new OrderGoodsModel();   // 订单商品表
        $this->user_model = new UserModel();                //用户表
        $this->peisong_member_model = new PeisongMemberModel(); //配送员表
        $this->peisong_order_model = new PeisongOrderModel(); //配送订单表
        $this->order_model = new OrderModel(); //订单表
    }

    /**
     * @Author   admin
     * @Email    无
     * @DateTime 2018-11-26
     * 订单列表
     */
    public function index($page = 1, $member_id = "") {
        $where = [];
        if (!empty($member_id)) {
            $where['member_id'] = $member_id;
        }
        $where['status'] = ['neq', 0];
        // 配送订单列表
        $order_list = $this->peisong_order_model->where($where)->order('id DESC')->paginate(15, false, ['page' => $page]);
        foreach ($order_list as $k => $v) {
            // 收货人信息
            $order = $this->order_model->where(['order_id' => $v['order_id']])->find();
            $order_list[$k]['order_name'] = $order['name'];
            $order_list[$k]['order_mobile'] = $order['mobile'];
            $order_list[$k]['order_address'] = $order['address'];
            // 配送员信息
            $member = $this->peisong_member_model->where(['id' => $v['member_id']])->find();
            $order_list[$k]['member_name'] = $member['name'];
            $order_list[$k]['member_mobile'] = $member['mobile'];
            $order_list[$k]['member_place'] = $member['place'];
        }

        // 配送员列表
        $member_list = $this->peisong_member_model->where(['review' => 1])->select();

        return $this->fetch('index', ['order_list' => $order_list, 'member_list' => $member_list, 'member_id' => $member_id]);
    }

    /**
     * @Author   admin
     * @Email    无
     * @DateTime 2018-11-27
     * 呼叫订单管理
     */
    public function call_order($page = 1) {
        // 配送订单列表
        $order_list = $this->peisong_order_model->where(['status' => 0])->order('id DESC')->paginate(15, false, ['page' => $page]);
        foreach ($order_list as $k => $v) {
            // 收货人信息
            $order = $this->order_model->where(['order_id' => $v['order_id']])->find();
            $order_list[$k]['order_name'] = $order['name'];
            $order_list[$k]['order_mobile'] = $order['mobile'];
            $order_list[$k]['order_address'] = $order['address'];
            $order_list[$k]['time'] = time_ago($v['add_time']);
        }

        return $this->fetch('call_order', ['order_list' => $order_list]);
    }

    /**
     * @Author   admin
     * @Email    无
     * @DateTime 2018-11-27
     * 确认派单
     */
    public function paidan() {
        if ($this->request->method() == 'POST') {
            $order_id = (int) $this->request->param('order_id');
            $member_id = $this->request->param('member_id');
            if (empty($order_id) || empty($member_id) || $member_id == "undefined") {
                return ['code' => 0, 'msg' => "参数错误,请重试!"];
            }
            // 订单详情
            $order = $this->order_model->where(['order_id' => $order_id])->find();
            // 配送订单详情
            $peisong_order = $this->peisong_order_model->where(['order_id' => $order_id])->find();
            if (empty($order) || empty($peisong_order)) {
                return ['code' => 0, 'msg' => "参系统错误,请稍候再试!"];
            }
            if ($peisong_order['status'] == 1 && !empty($peisong_order['member_id'])) {
                return ['code' => 0, 'msg' => "抱歉,该订单已被其他配送小程序派单!"];
            }
            //开启事务
            $this->peisong_order_model->startTrans();

            //更新配送订单
            $data['member_id'] = $member_id;
            $data['status'] = 1;
            $data['add_time'] = time();
            $res = $this->peisong_order_model->save($data, ['order_id' => $order_id]);

            //更新订单状态为取货中
            $res2 = $this->order_model->save(['status' => 3], ['order_id' => $order_id]);
            // 添加订单状态记录
            $res3 = $this->order_model->log($order_id, $order['member_id'], 3);

            if ($res && $res2 && $res3) {
                //执行推送,派单成功,删除小程序端抢单列表中当前订单信息
                if (send_socket(json_decode($peisong_order['member_ids']), ['type' => 2, 'order_id' => $order_id]) && send_socket([$member_id], ['type' => 3, 'order_id' => $order_id])) {
                    // 提交事务
                    $this->peisong_order_model->commit();
                    return ['code' => 1, 'msg' => "派单成功!"];
                } else {
                    // 回滚事务
                    $this->peisong_order_model->rollback();
                    return ['code' => 0, 'msg' => "派单失败,请稍候再试!"];
                }
            } else {
                // 回滚事务
                $this->peisong_order_model->rollback();
                return ['code' => 0, 'msg' => "派单失败,请稍候再试!"];
            }
        } else {
            $order_id = (int) $this->request->param('order_id');
            if (empty($order_id)) {
                return ['code' => 0, 'msg' => "参数错误,请重试!"];
            }
            if (!$detail = $this->order_model->find($order_id)) {
                return ['code' => 0, 'msg' => "不存在订单"];
            }
            //取出符合条件的配送员
            $members = $this->peisong_member_model->where(['review' => 1, 'status' => 1])->select();
            if (empty($members)) {
                return ['code' => 0, 'msg' => "抱歉,当前没有配送员!"];
            }

            return ['code' => 1, 'members' => $members];
        }
    }

    /**
     * @Author   admin
     * @Email    无
     * @DateTime 2019-03-04
     * 订单统计
     */
    public function orderInfo($page = 1, $name = "", $status = "", $mobile = "") {

        $where = [];
        //查找姓名
        if (!empty($name)) {
            $where['m.name'] = $name;
        }
        //查找手机号
        if (!empty($mobile)) {
            $where['m.mobile'] = $mobile;
        }
        //查找状态 status = 11 完成订单
//        if (!empty($status)) {
        $where['o.status'] = 11;
//        }
        $order_list = $this->peisong_member_model->alias('m')
                ->join('dp_peisong_order po','po.member_id = m.id','left')
                ->join('dp_order o','po.order_id = o.order_id','left')
                ->where($where)
                ->field('o.order_id,po.member_id as pmember_id,SUM(o.pay_money) as summoney,count(o.order_id) as znum,m.id,m.name as mname,m.mobile,m.id')
                ->group('po.member_id')
                ->order('summoney DESC')
                ->paginate(15);
        
        foreach ($order_list as $key => $val) {
            // 本月
            $month = $this->peisong_order_model->where(['member_id' => $val->pmember_id])->whereTime('add_time', 'month')->count();
            $money = $this->order_model->alias('o')
                     ->join('dp_peisong_order po','po.order_id = o.order_id','left')
                    ->where(['po.member_id' => $val->pmember_id, 'o.status' => 11])
                    ->whereTime('o.add_time', 'month')
                    ->sum('pay_money');
            $order_list[$key]['onlymonth'] = $month;
            $order_list[$key]['onlymoney'] = $money;
        }
        return $this->fetch('orderinfo', ['order_list' => $order_list, 'name' => $name, 'status' => $status, 'mobile' => $mobile]);
    }
    
        /**
     * 发送模板短信
     * @author  cyy
     * * */
    public function sendSms2() {
        //网易云信分配的账号，请替换你在管理后台应用下申请的Appkey
        $AppKey = '90fb793aa20ed91de22164670e488505';
        //网易云信分配的账号，请替换你在管理后台应用下申请的appSecret
        $AppSecret = 'cb551caf99d2';
        $p = new ServerAPI($AppKey, $AppSecret, 'fsockopen');     //fsockopen伪造请求

        //发送短信验证码
            print_r($p->sendSmsCode('3972293','13522224914','','5'));
        //发送模板短信
//        print_r($p->sendSMSTemplate('3972293', array('13522224914'), array('6666')));
    }

}
