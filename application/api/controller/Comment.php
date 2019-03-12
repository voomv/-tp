<?php
namespace app\api\controller;

use app\common\model\Comment as CommentModel;
use app\common\model\Mall as MallModel;
use app\common\model\User as UserModel;
use app\common\model\Order as OrderModel;
use app\common\model\OrderGoods as OrderGoodsModel;
use app\common\controller\ApiBase;
use think\Db;

/**
 * 评论管理
 * Class Commen
 * @package app\api\controller
 */
class Comment extends ApiBase
{
    protected $checkUserLogin = true;//是否验证登录
    protected $comment_model;
    protected $mall_model;
    protected $user_model;
    protected $order_model;
    protected $order_goods_model;

    protected function _initialize()
    {
        parent::_initialize();
        $this->comment_model = new CommentModel();//评论表
        $this->mall_model = new MallModel();//商品表
        $this->user_model = new UserModel();//用户信息表
        $this->order_model = new OrderModel();//订单表
        $this->order_goods_model = new OrderGoodsModel(); // 订单商品表
    }

    /**
     * @Author   admin
     * @Email    无
     * @DateTime 2018-11-30
     * 商品评论列表
     */
    public function comment(){       
        $id  = $this->request->param('id');//商品id
        $page  = $this->request->param('page');//分页
        if (empty($id) || empty($page)) {
            $this->err(400,"参数错误,请重试!");
        }                       
        if(!$this->mall_model->get($id)){
            $this->err(400,"抱歉,此商品不存在!");
        }
        // 评论列表
        $comment_list = $this->comment_model->where(['mid'=>$id])->order(['add_time' => 'DESC'])->paginate(10, false, ['page' => $page]);
        // 封装数据
        foreach ($comment_list as $k => $v) {
            // 评论用户信息
            $user = $this->user_model->where(['id'=>$v->uid])->find();
            $comment_list[$k]['username'] = $user->username;
            $comment_list[$k]['headimg'] = $user->headimg;
            $comment_list[$k]['photo'] = json_decode($v->photo);
            // 时间转化
            $comment_list[$k]['add_time'] = date("Y-m-d H:i:s",$v->add_time);
        }

        $this->datas = $comment_list;
    }


    /**
     * @Author   admin
     * @Email    无
     * @DateTime 2018-11-30
     * 添加评论
     */
    public function add_comment(){
        $id  = $this->request->param('id');//商品id
        $order_id  = $this->request->param('order_id');//订单id
        $content  = $this->request->param('content');//评论内容
        $score  = $this->request->param('score');//评分
        $photo  = $this->request->param('photo/a');//评论图册
        if (empty($id) || empty($order_id)) {
            $this->err(400,"参数错误,请重试!");
        }
        if(!$this->mall_model->get($id)){
            $this->err(400,"抱歉,此商品不存在!");
        }
        if(!$this->order_model->get($order_id)){
            $this->err(400,"抱歉,此订单不存在!");
        }
        if(!$this->order_goods_model->where(['order_id'=>$order_id,'goods_id'=>$id])->find()){
            $this->err(400,"抱歉,此订单中不存在此商品!");
        }
        // 判断当前用户是否已评论
        if($this->comment_model->where(['mid'=>$id,'order_id'=>$order_id,'uid'=>$this->user_id])->find()){
            $this->err(400,"抱歉,您已评论过,不能重复评论!");
        }
        if (empty($content)) {
            $this->err(400,"请填写评论内容!");
        }
        if (empty($score)) {
            $this->err(400,"请选择评分!");
        }
        if(!empty($photo)){
            $data['photo'] = json_encode($photo);
        }

        $data['uid'] = $this->user_id;
        $data['mid'] = $id;
        $data['order_id'] = $order_id;
        $data['content'] = $content;
        $data['score'] = $score;
        $data['add_time'] = time();

        if($this->comment_model->save($data)){
            $this->datas = ['code'=>200,'msg'=>"评论成功!"];
        }else{
            $this->err(400,"评论失败,请重试!");
        }
    }
}