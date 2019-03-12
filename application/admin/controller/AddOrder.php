<?php

/*
 * cyy 2019.2.20
 */

namespace app\admin\controller;

use app\common\controller\AdminBase;
use app\common\model\Order;
use app\common\model\OrderGoods;
use app\common\model\PeisongMemberPosition;
use think\Db;
use think\Session;
use app\common\model\SettingPriceModel;

class AddOrder extends AdminBase {

    public function add() {
        return $this->fetch();
    }

    // 下单
    public function save() {
        $member_id = session('admin_id');
        $pay_money = $this->request->param('pay_money');
        $weight_money = $this->request->param('weight_money');
        if($weight_money){
            $pay_money = $weight_money + $pay_money;
        }
        // 物品名称
        $goods = (string) $this->request->param('goods');
        // 物品重量
        $weight = (int) $this->request->param('weight');
        $mobile = (int) $this->request->param('mobile');
        $name = $this->request->param('name');
        $address = $this->request->param('address');
        $province = '河北省廊坊市';
        $lat = $this->request->param('lat');
        $lng = $this->request->param('lng');
        //取货地址
        $name2 = $this->request->param('name2');
        $mobile2 = $this->request->param('mobile2');
        $address2 = $this->request->param('address2');
        $lat2 = $this->request->param('lat2');
        $lng2 = $this->request->param('lng2');

        $distance = $this->request->param('distance');
        $orderM = new Order();
        Db::startTrans();
        $map = [
            'member_id' => $member_id, //用户ID 
            'pay_money' => $pay_money, //支付的金额
            'weight' => $weight, //在线支付的金额
            'mobile' => $mobile, //收货人手机
            'name' => $name, //收货人姓名
            'address' => $address, //收货人地址
            'province' => $province, //省市区
            'lat' => $lat, //收货人精度
            'lng' => $lng, //收货人维度
            'name2' => $name2, //取货人地址
            'mobile2' => $mobile2, //取货人地址
            'address2' => $address2, //取货人地址
            'lat2' => $lat2, //取货人精度
            'lng2' => $lng2, //取货人维度
            'distance' => $distance, //取货人维度
            'info' => '备注', //订单备注
            'status' => 1,
            'last_time' => $this->request->time() + 1800, //订单过期时间  30分钟有效期；
            'add_time' => time(),
        ];
        $re = $orderM->save($map);
        // 商品名称
        $OrderGoodsM = new OrderGoods();
        $data['order_id'] = $orderM->order_id;
        $data['member_id'] = $member_id;
        $data['goods_name'] = $goods;
        $data['price'] = $pay_money;
        $data['num'] = 1;
        $data['add_time'] = time();
        $res = $OrderGoodsM->save($data);
        if ($re && $res) {
            Db::commit();
            $this->success('保存成功');
        } else {
            Db::rollback();
            $this->error('保存失败');
        }
    }

    /**
     * 配送员位置
     */
    public function position() {
        return $this->fetch();
    }

    /**
     * 获取配送员经纬度
     */
    public function getMemberPosition() {
        $peisongM = new PeisongMemberPosition();
        $res = $peisongM->alias('p')
                ->join('dp_peisong_member m', 'm.id = p.member_id', 'left')
                ->where(['m.status' => 1, 'm.review' => 1])
                ->field('m.name,m.status,m.review,p.lat,p.lng')
                ->select();
        return $res;
    }

    //地图
    public function map($type = 1) {
        $this->assign('type', $type);
        return $this->fetch();
    }

    /**
     * 高德地图接口
     */
    public function getAddressParse($adress = 0) {
        if ($adress) {
            $url = 'https://restapi.amap.com/v3/geocode/geo?key=0e8dd43b72fc47794d2d6a5c5147b17e&address=' . $adress;
            $list = $this->send_get2($url);
            $listOb = json_decode($list, TRUE);

            if ($listOb['status'] === "1") {
                return $listOb['geocodes'][0]["location"];
            } else {
                return '获取失败' . $list['infocode'];
            }
        } else {
            echo 0;
        }
    }

    /**
     * 发送GET请求
     */
    public function send_get2($url) {
        $options = array(
            'http' => array(
                'method' => 'GET',
                'header' => 'Content-type:application/x-www-form-urlencoded',
                'timeout' => 15 * 60 // 超时时间（单位）    
            )
        );
        $result = file_get_contents($url);
        return $result;
    }

    /**
     * 设置配送金额
     * @return type
     */
    public function setting() {
        $setpriceM = new SettingPriceModel();
        $list = $setpriceM->find();
        $this->assign('special', json_decode($list['special']));
        $this->assign('list', $list);
        return $this->fetch();
    }

    /**
     * 保存配送金额
     * @return type
     */
    public function setinfo() {
        $data['qijia'] = (int) ($this->request->param('qijia'));
        $data['range'] = (string) ($this->request->param('range'));
        $data['mi'] = (int) $this->request->param('mi');
        $data['miprice'] = (int) ($this->request->param('miprice'));
        $tsshiqu = (array) $this->request->param('data/a');
        $special = [];
        // 修改送餐配送地址无法提交修改
        if ($tsshiqu) {
            foreach ($tsshiqu['s_time'] as $key => $val) {
                if (empty($tsshiqu['s_time'][$key]) || empty($tsshiqu['e_time'][$key])) {
                    $this->error('请输入正确的时间1', null, 101);
                }

                if ($tsshiqu['s_time'][$key] > $tsshiqu['e_time'][$key]) {
                    $this->error('请输入正确的时间1', null, 101);
                }

                $special[] = [
                    's_time' => $tsshiqu['s_time'][$key],
                    'e_time' => $tsshiqu['e_time'][$key],
                    'peisong' => (int) ($tsshiqu['peisong'][$key]),
                    'qijia' => (int) ($tsshiqu['qijia'][$key]),
                ];
            }
        }
        $data['special'] = json_encode($special);
        $setpriceM = new SettingPriceModel();
        $re = $setpriceM->find();
        if ($re) {
            $res = $setpriceM->save($data, ['id' => $re->id]);
        } else {
            $res = $setpriceM->save($data);
        }
        if ($res) {
            $this->success('操作成功', null, 101);
        }
    }

    /**
     * 保存配送金额
     * @return type
     */
    public function getOrderMoney($range) {
        if (empty($range)) {
            $this->error('距离不能为空', null, 101);
        }
        //获取当前的时间
        $setpriceM = new SettingPriceModel();
        $list = $setpriceM->find();
        $qijia = $list->qijia;
        $miprice = $list->miprice;
        $this_time = date("Hi");
        $special = json_decode($list['special']);
        foreach ($special as $val) {
            $s_time = (int) str_replace(':', '', $val->s_time);
            $e_time = (int) str_replace(":", '', $val->e_time);
            
            if ($this_time >= $s_time && $this_time <= $e_time) {
                $miprice = round($val['qijia'], 2);
//                $peisong = round($val['peisong'], 2);
                //在范围内距离在特殊时间里
                $qijia = round($val['peisong'], 2);
                break;
            }
        }

        if ($range > $list->range) {
            $pay_monrygt = ceil(($range - $list->range) / $list->mi) * $miprice;
            $pay_money = $qijia + $pay_monrygt;
        } else {
            $pay_money = $qijia;
        }
        return $pay_money;
    }

}
