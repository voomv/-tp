<?php

namespace app\index\controller;

use app\common\controller\HomeBase;
use app\common\model\Order;

class Order extends HomeBase {

    public function index() {

        $orderM = new Order();

        $order_data = $orderM->save([
            'member_id' => $this->user_id, //用户ID
            'total_money' => $price, //总金额
            'need_pay' => $sum_price, //实际支付的金额
            'pay_money' => $weixin_money, //在线支付的金额
            'pay_coupon' => empty($Coupon_info->price) ? 0 : $Coupon_info->price, //优惠卷支付金额
            'coupon_id' => empty($Coupon_info->id) ? 0 : $Coupon_info->id, //优惠卷的ID
            'pay_yue' => $yve_pirce, //余额支付
            'mobile' => $address->mobile, //收货人手机
            'name' => $address->name, //收货人姓名
            'address' => $address->address, //收货人地址
            'province' => $address->province, //省市区
            'lat' => $address->lat, //收货人精度
            'lng' => $address->lng, //收货人维度
            'info' => '备注', //订单备注
            'status' => $is_weixin_paty ? 0 : 1,
            'last_time' => $this->request->time() + 1800, //订单过期时间  30分钟有效期；
            'add_time' => time(),
        ]);
        
       
    }

}
