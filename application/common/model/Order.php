<?php
namespace app\common\model;

use think\Model;

use app\common\model\OrderLog as OrderLogModel;

class Order extends Model
{
    /**
     * @Author   admin
     * @Email    无
     * @DateTime 2018-11-30
     * 记录订单状态
     */
    public function log($order_id="",$uid="",$status="",$type="0"){
    	// 判断参数是否完整
    	if(empty($order_id) || empty($uid) || empty($status)){
    		return false;
    	}
    	// 判断订单是否存在
    	if(!$order = $this->get($order_id)){
    		return false;
    	}
//    	// 判断订单是否是当前用户的
//    	if($uid !== $order['member_id']){
//    		return false;
//    	}

    	$data['order_id'] = $order_id;
    	$data['uid'] = $uid;
        $data['status'] = $status;
    	$data['type'] = $type;
    	$data['add_time'] = time();
    	// 添加记录
    	$order_log = new OrderLogModel();
    	if($order_log->save($data)){
    		return true;
    	}else{
    		return false;
    	}
    }
}