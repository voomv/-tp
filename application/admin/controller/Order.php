<?php
namespace app\admin\controller;

use app\common\controller\AdminBase;
use app\common\model\OrderGoods as OrderGoodsModel;
use app\common\model\Order as OrderModel;
use app\common\model\User as UserModel;
use app\common\model\MallSku as MallSkuModel;
use app\common\model\PeisongMember as PeisongMemberModel;
use app\common\model\PeisongOrder as PeisongOrderModel;
use app\common\model\UserBalanceLog as UserBalanceLogModel;
use think\Db;

/**
 * 订单管理
 * Class Order
 * @package app\admin\controller
 */
class Order extends AdminBase
{

    protected $order_goods_model;
    protected $order_model;
    protected $user_model;
    protected $mall_sku_model;
    protected $peisong_member_model;
    protected $peisong_order_model;
    protected $user_balance_log_model;

    protected function _initialize()
    {
        parent::_initialize();
        $this->order_goods_model = new OrderGoodsModel();   // 订单商品表
        $this->order_model = new OrderModel();              //订单表
        $this->user_model = new UserModel();                //用户表
        $this->mall_sku_model = new MallSkuModel();         //商品规格表
        $this->peisong_member_model = new PeisongMemberModel();//配送员表
        $this->peisong_order_model = new PeisongOrderModel();//配送订单表
        $this->user_balance_log_model = new UserBalanceLogModel();//用户余额记录表

    }
    /**
     * @Author   康梓航
     * @Email    1275910740@qq.com
     * @DateTime 2018-11-28
     * @return   [type]            [description]
     * 订单页的数据展示
     */
    public function index($page=1,$name="",$status="",$mobile=""){

        $where = [];
        //查找姓名
        if (!empty($name)) {
            $where['name'] = $name;
        }   
        //查找手机号
        if (!empty($mobile)) {
            $where['mobile'] = $mobile;
        } 
        //查找状态
        if (!empty($status)) {
            $where['status'] = $status-1;
        }

        $order_list = $this->order_model->where($where)->order('order_id DESC')->paginate(15, false, ['page' => $page,'query'=>['status'=>$status,'name'=>$name,'mobile'=>$mobile]]);

        foreach ($order_list as $k => $v) {
            // 收获人信息
            $member = $this->user_model->where(['id'=>$v['member_id']])->find();
            $order_list[$k]['member_id'] = $member['id'];
            $order_list[$k]['username'] = $member['username'];   //微信名称
            $order_list[$k]['order_name'] = $v['name'];          //收获人姓名
            $order_list[$k]['order_mobile'] = $v['mobile'];      //收获人电话
            $order_list[$k]['order_address'] = $v['address'];    //收获人地址
            $order_list[$k]['distance'] = round($v['distance'],2);    //收获人地址

            // 购买的商品
            $goods = $this->order_goods_model->where(['order_id'=>$v['order_id']])->find();
            //查询规格
            //$sku = $this->mall_sku_model->where(['sku_id'=>$goods['sku_id']])->find();
            //$order_list[$k]['photo'] = $goods['photo'];              //商品图片
            $order_list[$k]['goods_name'] = $goods['goods_name'];   //商品名称
            //$order_list[$k]['num'] = $goods['num'];                     //购买数量 
            //$order_list[$k]['sku_name'] = $sku['name'];          //规格
            //查询金额
            //$order_list[$k]['need_pay'] = $v['need_pay'] / 100;    //订单金额
            //$order_list[$k]['pay_coupon'] = $v['pay_coupon'] / 100;  //优惠卷金额
            //$order_list[$k]['pay_yue'] = $v['pay_yue'] / 100;   //余额支付
            $order_list[$k]['pay_money']  = $v['pay_money'];   //在线支付

        }

        return $this->fetch('index',['order_list'=>$order_list,'name'=>$name,'status'=>$status,'mobile'=>$mobile]);        

    }

    /**
     * @Author   胡帅康
     * @Email    3024186605@qq.com
     * @DateTime 2018-11-29
     * 发货
     */
    public function ship(){
        $order_id = (int) $this->request->param('order_id');
        $type = (int) $this->request->param('type');//0--发货    1--换货  2--退货
        if(empty($order_id)){
            return ['code'=>0,'msg'=>"参数错误,请重试!"];
        }

        if($this->peisong_order_model->where(['order_id'=>$order_id,'type'=>$type])->find()){
            return ['code'=>0,'msg'=>"抱歉,该订单已发货过!"];
        }

        // 查出在线的配送员
        $member_where['review'] = 1;
        $member_where['status'] = 1;
        $member = $this->peisong_member_model->where($member_where)->select();

        //接收推送用户
        $member_ids = [];
        foreach($member as $k=>$v){
            $member_ids[] =$v['id'];
        }
        if(empty($member_ids)){
            return ['code'=>0,'msg'=>"抱歉,当前没有在线配送员,请稍候再试!"];
        }

        // 订单信息
        $order = $this->order_model->where(['order_id'=>$order_id])->find();
        if(empty($order)){
            return ['code'=>0,'msg'=>"订单不存在,请重试!"];
        }
        // 订单商品信息
        $order_goods = $this->order_goods_model->where(['order_id'=>$order_id])->select();
        if(empty($order_goods)){
            return ['code'=>0,'msg'=>"订单商品为空,请重试!"];
        }
        foreach ($order_goods as $k=>$v) {
            $order_goods[$k]['is_sel'] = false;
            if(!empty($v['sku_id'])){
                $order_goods[$k]['sku'] = $this->mall_sku_model->where(['sku_id'=>$v['sku_id']])->find();
            }else{
                $order_goods[$k]['sku'] = [];
            }
        }
        $order['add_time'] = date("Y-m-d H:i:s",$order['add_time']);//封装时间格式
        $order['goods'] = $order_goods;//订单商品

        //开启事务
        $this->peisong_order_model->startTrans();

        // 添加配送订单记录
        $data['order_id'] = $order_id;
        $data['member_ids'] = json_encode($member_ids);
        $data['status'] = 0;
        $data['type'] = $type;
        $data['add_time'] = time();
        $res = $this->peisong_order_model->save($data);

        // 更新订单状态为待接单
        if($type == 1){
            $status = 9;//换货中
            $is_chang = 1;
        }elseif($type == 2){
            $status = 7;//退货中
            $is_chang = 2;
        }else{
            $status = 2;//已发货,等待接单
            $is_chang = 0;
        }
        $res2 = $this->order_model->save(['status'=>$status,'is_chang'=>$is_chang],['order_id'=>$order_id]);
        // 添加订单状态记录
        $res3 = $this->order_model->log($order_id,$order['member_id'],$status,$type);

        if($res && $res2 && $res3){
            //执行推送,发货成功
            // 订单信息
            $send_order = $this->order_model->where(['order_id'=>$order_id])->find();
            // 订单商品信息
            $order_goods = $this->order_goods_model->where(['order_id'=>$order_id])->select();
            foreach ($order_goods as $k=>$v) {
                $order_goods[$k]['is_sel'] = false;
                if(!empty($v['sku_id'])){
                    $order_goods[$k]['sku'] = $this->mall_sku_model->where(['sku_id'=>$v['sku_id']])->find();
                }else{
                    $order_goods[$k]['sku'] = [];
                }
            }
            $send_order['add_time'] = date("Y-m-d H:i:s",$send_order['add_time']);//封装时间格式
            $send_order['goods'] = $order_goods;//订单商品
            if(send_socket($member_ids,['type'=>1,'data'=>$send_order])){
                // 提交事务
                $this->peisong_order_model->commit(); 
                return ['code'=>1,'msg'=>"发货成功!"];
            }else{
                // 回滚事务
                $this->peisong_order_model->rollback();
                return ['code'=>0,'msg'=>"发货失败,请稍候再试!"];
            }
        }else{
            // 回滚事务
            $this->peisong_order_model->rollback();
            return ['code'=>0,'msg'=>"发货失败,请稍候再试!"];
        }
    }

    /**
     * @Author   胡帅康
     * @Email    3024186605@qq.com
     * @DateTime 2018-11-29
     * 取消发货
     */
    public function cancel_delivery(){
        $order_id = (int) $this->request->param('order_id');
        $type = (int) $this->request->param('type');//0--发货    1--换货  2--退货
        if(empty($order_id)){
            return ['code'=>0,'msg'=>"参数错误,请重试!"];
        }

        if(!$peisong_order = $this->peisong_order_model->where(['order_id'=>$order_id,'type'=>$type])->find()){
            return ['code'=>0,'msg'=>"抱歉,该订单未发货,请先发货!"];
        }

        // 订单信息
        $order = $this->order_model->where(['order_id'=>$order_id])->find();
        if(empty($order)){
            return ['code'=>0,'msg'=>"订单不存在,请重试!"];
        }

        //开启事务
        $this->peisong_order_model->startTrans();

        // 删除配送订单记录
        $res = $this->peisong_order_model->where(['order_id'=>$order_id])->delete();
        // 更新订单状态为等待发货
        $res2 = $this->order_model->save(['status'=>1],['order_id'=>$order_id]);
        // 添加订单状态记录
        $res3 = $this->order_model->log($order_id,$order['member_id'],1,$type);

        if($res && $res2 && $res3){
            //执行推送,取消发货成功
            if(send_socket(json_decode($peisong_order['member_ids']),['type'=>2,'order_id'=>$order_id])){
                // 提交事务
                $this->peisong_order_model->commit(); 
                return ['code'=>1,'msg'=>"取消发货成功!"];
            }else{
                // 回滚事务
                $this->peisong_order_model->rollback();
                return ['code'=>0,'msg'=>"取消发货失败,请稍候再试!"];
            }
        }else{
            // 回滚事务
            $this->peisong_order_model->rollback();
            return ['code'=>0,'msg'=>"取消发货失败,请稍候再试!"];
        }
    }

    /**
     * @Author   康梓航
     * @Email    1275910740@qq.com
     * @DateTime 2018-12-05
     * @return   [type]            [description]
     */
    public function carry(){

        $order_id = (int) $this->request->param('order_id');
        if(empty($order_id)){
            return ['code'=>0,'msg'=>"参数错误,请重试!"];
        }
        // 订单信息
        $order = $this->order_model->where(['order_id'=>$order_id])->find();
        if(empty($order)){
            return ['code'=>0,'msg'=>"订单不存在,请重试!"];
        }
        if($order['status'] !== 5 && $order['status'] !== 10){
            return ['code'=>0,'msg'=>"订单状态有误,请联系管理员!"];
        }

        //更改当前订单状态
        $data['status'] = 11;
        $result = $this->order_model->save($data,['order_id'=>$order_id]);
        if($result){
             return ['code'=>1,'msg'=>"更改已完成订单成功!"];
        }else{
            return ['code'=>0,'msg'=>"更改已完成订单失败"];
        }

    }

    /**
     * @Author   胡帅康
     * @Email    3024186605@qq.com
     * @DateTime 2018-11-29
     * 退款
     */
    public function refund(){
        $order_id = (int) $this->request->param('order_id');
        if(empty($order_id)){
            return ['code'=>0,'msg'=>"参数错误,请重试!"];
        }
        // 订单信息
        $order = $this->order_model->where(['order_id'=>$order_id])->find();
        if(empty($order)){
            return ['code'=>0,'msg'=>"订单不存在,请重试!"];
        }
        if($order['status'] !== 13){
            return ['code'=>0,'msg'=>"订单状态有误,请联系管理员!"];
        }
        // 判断是余额支付还是线上支付
        if(!empty($order['pay_yue'])){
            /*余额退款*/ 
            
            //开启事务
            $this->order_model->startTrans();
            // 更新订单状态为已退款
            $res = $this->order_model->save(['status'=>14],['order_id'=>$order_id]);
            // 添加订单状态记录
            $res2 = $this->order_model->log($order_id,$order['member_id'],14);
            // 用户添加余额
            $res3 = $this->user_model->where(['id'=>$order['member_id']])->setInc('balance',round($order['pay_yue']/100,2));
            // 添加退款记录
            $data['uid'] = $order['member_id'];
            $data['type'] = 3;
            $data['money'] = round($order['pay_yue']/100,2);
            $data['balance'] = $this->user_model->where(['id'=>$order['member_id']])->value("balance");
            $data['status'] = 1;
            $data['create_time'] = time();
            $res4 = $this->user_balance_log_model->save($data);

            if($res && $res2 && $res3 && $res4){
                // 提交事务
                $this->order_model->commit(); 
                return ['code'=>1,'msg'=>"退款成功!"];
            }else{
                // 回滚事务
                $this->order_model->rollback();
                return ['code'=>0,'msg'=>"退款失败,请稍候再试!"];
            }
        }else{
            /*微信退款*/
            //开启事务
            $this->order_model->startTrans();

            // 更新订单状态为已退款
            $res = $this->order_model->save(['status'=>14],['order_id'=>$order_id]);
            // 添加订单状态记录
            $res2 = $this->order_model->log($order_id,$order['member_id'],14);
            if(empty($res) || empty($res2)){
                // 回滚事务
                $this->order_model->rollback();
                return ['code'=>0,'msg'=>"退款失败,请稍候再试!"];
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
            $input = new \WxPayRefund();
            $input->SetOut_trade_no(json_decode($order['pay_info'],true)['out_trade_no']);//商户订单号
            $input->SetOut_refund_no(WX_MCHID . rand(10000, 99999) . $order_id);//商户退款单号
            $input->SetTotal_fee($order['pay_money']);//订单金额  price
            $input->SetRefund_fee($order['pay_money']);//退款金额 
            $result = \WxPayApi::refund($input); 

            if($result['result_code'] !== "FAIL" && $result['result_code'] == "SUCCESS" && $result['return_msg'] == "OK"){
                // 更新退款信息
                $this->order_model->save([ 'refund_info' => json_encode($result)],['order_id'=>$order_id]);
                // 提交事务
                $this->order_model->commit(); 
                return ['code'=>1,'msg'=>"退款成功!"];
            }else{
                // 回滚事务
                $this->order_model->rollback();
                return ['code'=>0,'msg'=>"退款失败,请稍候再试!"];
            }
        }
    }
}