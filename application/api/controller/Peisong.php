<?php

namespace app\api\controller;

use think\Session;
use think\Cache;
use app\common\controller\ApiBase;
use app\common\model\PeisongMember as PeisongMemberModel;
use app\common\model\PeisongMemberPosition as PeisongMemberPositionModel;
use app\common\model\PeisongOrder as PeisongOrderModel;
use app\common\model\Order as OrderModel;
use app\common\model\OrderGoods as OrderGoodsModel;
use app\common\model\MallSku as MallSkuModel;
use app\common\controller\ServerAPI;

class Peisong extends ApiBase {

    protected $checkPeisongLogin = true;
    protected $checkPeisongWxLogin = false;
    protected $peisong_member_model;
    protected $peisong_member_position_model;
    protected $peisong_order_model;
    protected $order_model;
    protected $order_goods_model;
    protected $mall_sku_model;

    public function _initialize() {
        parent::_initialize();
        $this->peisong_member_model = new PeisongMemberModel(); //配送员表
        $this->peisong_member_position_model = new PeisongMemberPositionModel(); //配送员位置表
        $this->peisong_order_model = new PeisongOrderModel(); //配送订单表
        $this->order_model = new OrderModel(); //订单表
        $this->order_goods_model = new OrderGoodsModel(); //订单商品表
        $this->mall_sku_model = new MallSkuModel(); //商品SKU表
    }

    /**
     * @Author   admin
     * @Email    无
     * @DateTime 2018-11-29
     * 当前用户状态
     */
    public function status() {
        $this->datas = $this->member->status;
    }

    /**
     * @Author   admin
     * @Email    无
     * @DateTime 2018-11-26
     * 更新配送员位置
     */
    public function position() {
        $lat = $this->request->param('lat');
        $lng = $this->request->param('lng');
        $member_id = $this->request->param('member_id');

        if (empty($lat) || empty($lng) || empty($member_id)) {
            $this->err(400, '参数错误,请重试!');
        }

        $data['lat'] = $lat;
        $data['lng'] = $lng;
        $data['member_id'] = $member_id;
        $data['add_time'] = time();
        if ($this->peisong_member_position_model->get($member_id)) {
            $res = $this->peisong_member_position_model->save($data, ['member_id' => $member_id]);
        } else {
            $res = $this->peisong_member_position_model->save($data);
        }

        $this->datas = ['code' => 200, 'msg' => "更新成功!"];
    }

    /**
     * @Author   admin
     * @Email    无
     * @DateTime 2018-11-26
     * 配送员登录推送之前未抢单的订单
     */
    public function before_order() {
        // 查出未配送的订单记录
        $peisong_order_list = $this->peisong_order_model->where(['status' => 0])->order(['order_id' => 'desc'])->select();
        $orders = [];
        if (!empty($peisong_order_list)) {
            foreach ($peisong_order_list as $k => $v) {
                // 订单信息
                $order = $this->order_model->where(['order_id' => $v['order_id']])->find();
                if (!empty($order)) {
                    //订单商品信息
                    $order_goods = $this->order_goods_model->where(['order_id' => $v['order_id']])->select();
                    if (!empty($order_goods)) {
                        foreach ($order_goods as $k2 => $v2) {
                            $order_goods[$k2]['is_sel'] = false;
//                            if (!empty($v2['sku_id'])) {
//                                $order_goods[$k2]['sku'] = $this->mall_sku_model->where(['sku_id' => $v2['sku_id']])->find();
//                            } else {
//                                $order_goods[$k]['sku'] = [];
//                            }
                        }
                        //分装订单和订单商品以及店铺信息,为推送数据
                        $order['time'] = date("Y-m-d H:i:s", $order['add_time']); //封装时间格式
                        $order['goods'] = $order_goods; //订单商品信息

                        $orders[] = $order;
                    }
                }
            }
        }
        $this->datas = $orders;
    }

    /**
     * @Author   admin
     * @Email    无
     * @DateTime 2018-11-26
     * 配送订单列表 type==1--取货中订单   type==2--配送中订单
     */
    public function order_list() {
        $type = $this->request->param('type'); //订单状态
        if (empty($type)) {
            $this->err(400, '参数错误,请重试!');
        }

        // 查出订单记录
        $where['member_id'] = $this->member_id;
        $where['status'] = $type;
        $peisong_order_list = $this->peisong_order_model->where($where)->order(['id' => 'desc'])->select();

        $orders = [];
        if (!empty($peisong_order_list)) {
            foreach ($peisong_order_list as $val) {
                // 订单信息
                $order = $this->order_model->where(['order_id' => $val['order_id']])->find();
                if (!empty($order)) {
                    // 订单商品信息
                    $order_goods = $this->order_goods_model->where(['order_id' => $val['order_id']])->select();
                    if (!empty($order_goods)) {
                        foreach ($order_goods as $k => $v) {
                            $order_goods[$k]['is_sel'] = false;
                            if (!empty($v['sku_id'])) {
                                $order_goods[$k]['sku'] = $this->mall_sku_model->where(['sku_id' => $v['sku_id']])->find();
                            } else {
                                $order_goods[$k]['sku'] = [];
                            }
                        }
                        // 分装订单和订单商品以及店铺信息
                        $order['time'] = date("Y-m-d H:i:s", $order['add_time']); //封装时间格式
                        $order['goods'] = $order_goods; //订单商品信息

                        $orders[] = $order;
                    }
                }
            }
        }
        $this->datas = $orders;
    }

    /**
     * @Author   admin
     * @Email    无
     * @DateTime 2018-11-26
     * 配送员抢单
     */
    public function robbing() {
        $order_id = $this->request->param('order_id'); //订单id
        $type = $this->request->param('type'); //订单类型
        if (empty($order_id) || $type == "") {
            $this->err(400, '参数错误,请重试!');
        }

        $re = $this->peisong_member_model->where(['id' => $this->member_id])->find();
        if ($re->review === 0) {
            $this->err(400, '此账号已被禁用!，请联系管理员');
        }

        // 商品订单详情
        $order = $this->order_model->where(['order_id' => $order_id])->find();
        // 配送订单详情
        $peisong_order = $this->peisong_order_model->where(['order_id' => $order_id, 'type' => $type])->find();
        if (empty($order) || empty($peisong_order)) {
            $this->err(400, '系统错误,请稍候再试!');
        }
        if ($order['status'] == 12) {
            $this->err(400, '抱歉,该商品订单已取消!');
        }

        if ($peisong_order['status'] == 1 && !empty($peisong_order['member_id'])) {
            $this->err(400, '抱歉,该订单已被抢!');
        }

        // 开启事务
        $this->peisong_order_model->startTrans();

        // 更新配送订单
        $data['member_id'] = $this->member_id;
        $data['status'] = 1;
        $data['add_time'] = time();
        $res = $this->peisong_order_model->save($data, ['order_id' => $order_id, 'type' => $type]);

        // 订单正常发货时,更新订单状态添加订单记录
        if ($order['status'] == 2) {
            // 更新订单状态为取货中
            $res2 = $this->order_model->save(['status' => 3], ['order_id' => $order_id]);
            // 添加订单状态记录
            $res3 = $this->order_model->log($order_id, $order['member_id'], 3);
        } else {
            $res2 = $res3 = 1;
        }
        // 配送
//        $res4 = $this->order_model->save(['peisong_member_id' => $this->member_id], ['order_id' => $order_id]);

        if ($res && $res2 && $res3) {
            $member_ids = json_decode($peisong_order['member_ids']); //推送用户
            $datas = ['type' => 2, 'data' => $order_id]; //推送信息
            // 执行推送,抢单成功,删除小程序端抢单列表中当前订单信息
            if (send_socket($member_ids, $datas) == "ok") {
                // 提交事务
                $this->peisong_order_model->commit();
                $this->datas = ['code' => 200, 'msg' => "抢单成功!"];
            } else {
                // 回滚事务
                $this->peisong_order_model->rollback();
                $this->err(400, "抢单失败!");
            }
        } else {
            // 回滚事务
            $this->peisong_order_model->rollback();
            $this->err(400, "抢单失败!");
        }
    }

    /**
     * @Author   admin
     * @Email    无
     * @DateTime 2018-11-26
     * 完成取货
     */
    public function complete_meal() {
        $order_id = $this->request->param('order_id'); //订单id
        $type = $this->request->param('type'); //订单类型
        if (empty($order_id) || $type == "") {
            $this->err(400, '参数错误,请重试!');
        }

        //外卖订单详情
        $order = $this->order_model->where(['order_id' => $order_id])->find();
        //配送订单详情
        $peisong_order = $this->peisong_order_model->where(['order_id' => $order_id, 'type' => $type])->find();
        if (empty($order) || empty($peisong_order) || $peisong_order['member_id'] !== $this->member_id) {
            $this->err(400, '系统错误,请稍候再试!');
        }
        if ($order['status'] == 12) {
            $this->err(400, '抱歉,该商品订单已取消!');
        }

        //开启事务
        $this->peisong_order_model->startTrans();

        //更新配送订单为已取货
        $res = $this->peisong_order_model->save(['status' => 2], ['order_id' => $order_id, 'type' => $type]);

        // 订单正常发货时,更新订单状态添加订单记录
        if ($order['status'] == 3) {
            //更新订单状态为配送中
            $res2 = $this->order_model->save(['status' => 4], ['order_id' => $order_id]);
            // 添加订单状态记录
            $res3 = $this->order_model->log($order_id, $order['member_id'], 4);
        } else {
            $res2 = $res3 = 1;
        }

        if ($res && $res2 && $res3) {
            // 提交事务
            $this->peisong_order_model->commit();
            $this->datas = ['code' => 200, 'msg' => "取货成功!"];
        } else {
            // 回滚事务
            $this->peisong_order_model->rollback();
            $this->err(400, "取货失败!");
        }
    }

    /**
     * @Author   admin
     * @Email    无
     * @DateTime 2018-11-26
     * 完成配送
     */
    public function complete_order() {
        $order_id = $this->request->param('order_id'); //订单id
        $type = $this->request->param('type'); //订单类型
        if (empty($order_id) || $type == "") {
            $this->err(400, '参数错误,请重试!');
        }

        //外卖订单详情
        $order = $this->order_model->where(['order_id' => $order_id])->find();
        //配送订单详情
        $peisong_order = $this->peisong_order_model->where(['order_id' => $order_id, 'type' => $type])->find();
        if (empty($order) || empty($peisong_order)) {
            $this->err(400, '系统错误,请稍候再试!');
        }
        if ($order['status'] == 12) {
            $this->err(400, '抱歉,该商品订单已取消!');
        }

        //开启事务
        $this->peisong_order_model->startTrans();

        //更新配送订单为已完成
        $res = $this->peisong_order_model->save(['status' => 3, 'complete_time' => time()], ['order_id' => $order_id, 'type' => $type]);

        // 根据发货修改订单状态
        if ($order['status'] == 4) {
            //更新订单状态为已收货
            $res2 = $this->order_model->save(['status' => 5], ['order_id' => $order_id]);
            // 添加订单状态记录
            $res3 = $this->order_model->log($order_id, $order['member_id'], 5);
        } elseif ($order['status'] == 7) {
            //更新订单状态为已完成退货
            $res2 = $this->order_model->save(['status' => 13], ['order_id' => $order_id]);
            // 添加订单状态记录
            $res3 = $this->order_model->log($order_id, $order['member_id'], 13);
        } elseif ($order['status'] == 9) {
            //更新订单状态为换货成功
            $res2 = $this->order_model->save(['status' => 10], ['order_id' => $order_id]);
            // 添加订单状态记录
            $res3 = $this->order_model->log($order_id, $order['member_id'], 10);
        }

        if ($res && $res2 && $res3) {
            // 提交事务
            $this->peisong_order_model->commit();
            $this->sendSms($order_id);
            $this->datas = ['code' => 200, 'msg' => "收货成功!"];
        } else {
            // 回滚事务
            $this->peisong_order_model->rollback();
            $this->err(400, "收货失败!");
        }
    }

    /**
     * 发送模板短信
     * @author  cyy
     * * */
    public function sendSms2() {
        $mobile = $this->order_model->where(['order_id' => $order_id])->value('mobile');
        $code = rand(100000, 999999);
        //网易云信分配的账号，请替换你在管理后台应用下申请的Appkey
        $AppKey = '90fb793aa20ed91de22164670e488505';
        //网易云信分配的账号，请替换你在管理后台应用下申请的appSecret
        $AppSecret = 'cb551caf99d2';
        $p = new ServerAPI($AppKey, $AppSecret, 'fsockopen');     //fsockopen伪造请求
        //发送模板短信
        print_r($p->sendSMSTemplate('6272', array('13522224914'), array('0571')));
    }

}
