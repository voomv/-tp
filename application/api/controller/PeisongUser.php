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

class PeisongUser extends ApiBase
{
    protected $checkPeisongLogin = true;
    protected $checkPeisongWxLogin = true;
    protected $peisong_member_model;
    protected $peisong_member_position_model;
    protected $peisong_order_model;
    protected $order_model;
    protected $order_goods_model;
    protected $mall_sku_model;

    public function _initialize(){
        parent::_initialize();
        $this->peisong_member_model = new PeisongMemberModel();//配送员表
        $this->peisong_member_position_model = new PeisongMemberPositionModel();//配送员位置表
        $this->peisong_order_model = new PeisongOrderModel();//配送订单表
        $this->order_model = new OrderModel();//订单表
        $this->order_goods_model = new OrderGoodsModel();//订单商品表
        $this->mall_sku_model = new MallSkuModel();//商品SKU表
    }

    /**
     * @Author   admin
     * @Email    无
     * @DateTime 2018-11-26
     * 配送员信息
     */
    public function user(){
        // 用户昵称头像
        $this->datas['username'] = $this->peisong_user->username;
        $this->datas['headimg'] = $this->peisong_user->headimg;

        /*统计*/
        // 今日
        $today = $this->peisong_order_model->where(['member_id'=>$this->member_id])->whereTime('add_time', 'today')->count();
        // 本月
        $month = $this->peisong_order_model->where(['member_id'=>$this->member_id])->whereTime('add_time', 'month')->count();
        // 全部
        $count = $this->peisong_order_model->where(['member_id'=>$this->member_id])->count();
        
        // 本月收入
        $monthMoney =$this->order_model->where(['member_id'=>$this->member_id,'status'=>11])->whereTime('add_time', 'month')->sum('pay_money');
        

        $this->datas['today'] = $today;
        $this->datas['month'] = $month;
        $this->datas['count'] = $count;
        $this->datas['monthMoney'] = $monthMoney;
    }

    /**
     * @Author   admin
     * @Email    无
     * @DateTime 2018-11-27
     * 交易记录
     */
    public function recording(){
        $page = $this->request->param('page');
        if(empty($page)){
            $this->err(400,"参数错误!");
        }
        $list = $this->peisong_order_model->where(['member_id'=>$this->member_id])->field("order_id,status,add_time")->order('id DESC')->paginate(15, false, ['page' => $page]);
        if(!empty($list)){
            foreach($list as $k=>$v){
                // 封装时间格式
                $list[$k]['add_time'] = date("Y-m-d H:i:s",$v['add_time']);
                // 配送订单状态
                if($v['status'] == 0){
                    $list[$k]['status'] = "待接单";
                }elseif($v['status'] == 1){
                    $list[$k]['status'] = "取货中";
                }elseif($v['status'] == 2){
                    $list[$k]['status'] = "配送中";
                }elseif($v['status'] == 3){
                    $list[$k]['status'] = "已完成";
                }

                // 订单信息
                $order = $this->order_model->where(['order_id'=>$v['order_id']])->find();
                if(!empty($order)){
                    // 订单商品信息
                    $order_goods = $this->order_goods_model->where(['order_id'=>$v['order_id']])->field("goods_name")->select();
                    if(!empty($order_goods)){
                        // 商品信息
                        $list[$k]['order_goods'] = $order_goods;
                    }else{
                        $list[$k]['order_goods'] = [];
                    }
                }else{
                    $list[$k]['order_goods'] = [];
                }
            }
        }

        $this->datas = $list;
    }
}