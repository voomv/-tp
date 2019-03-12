<?php 
namespace app\api\controller;

use app\common\model\Slide as SlideModel;
use app\common\model\Mall as MallModel;
use app\common\model\Address as AddressModel;
use app\common\model\User as UserModel;
use app\common\model\AfterSale as AfterSaleModel;
use app\common\model\OrderGoods as OrderGoodsModel;
use app\common\model\MallSku as MallSkuModel;
use app\common\model\UserCoupon as UserCouponModel;
use app\common\model\Order as OrderModel;
use app\common\model\OrderLog as OrderLogModel;
use app\common\model\UserBalanceLog as UserBalanceLogModel;
use app\common\model\Comment as CommentModel;
use app\common\model\PeisongOrder as PeisongOrderModel;
use app\common\controller\ApiBase;
use think\Config;
use think\Db;

/**
 * 首页信息展示
 * Class Login
 * @package app\api\controller
 */
class Home extends ApiBase
{
    protected $slide_model;
    protected $mall_model;
    protected $mall_sku_model;
    protected $address_model;
    protected $user_coupon_model;
    protected $user_model;
    protected $order_goods_model;
    protected $after_sale_model;
    protected $order_log_model;
    protected $user_balance_log_model;
    protected $comment_model;
    protected $peisong_order_model;

    protected $order_model;
	protected function _initialize()
    {
        parent::_initialize();
        $this->user_model = new UserModel();//用户信息表    
        $this->slide_model = new SlideModel();  //轮播图表
        $this->mall_model = new MallModel();  //商品表
        $this->mall_sku_model = new MallSkuModel();  //商品规格表
        $this->address_model = new AddressModel(); // 用户地址表
        $this->user_coupon_model = new UserCouponModel();//用户优惠卷表
        $this->after_sale_model = new AfterSaleModel(); // 上门售后表
        $this->order_model = new OrderModel();//订单表
        $this->order_goods_model = new OrderGoodsModel(); // 订单商品表
        $this->order_log_model = new OrderLogModel();   //订单更新状态表
        $this->user_balance_log_model = new UserBalanceLogModel();//用户余额记录表
        $this->comment_model = new CommentModel();//评论表
        $this->peisong_order_model = new PeisongOrderModel();//配送订单表
    }
    /**
     * @Author   康梓航
     * @Email    1275910740@qq.com 
     * @DateTime 2018-11-28
     * @return   [type]            [description]
     * 首页数据展示
     */
    public function carousel(){

        //轮播图
        $slide = $this->slide_model->limit('5')->order('sort desc')->where(['status'=>1])->field('id,image,status,sort')->select();
        

        //首页四个商品
        $mall = $this->mall_model->where('stock','>',0)->where(['is_online'=>1])->where(['is_home'=>1])->order('orderby desc')->field('photo,price,goods_id,title,name,add_time,type_id,homeImg')->limit(4)->select();

        $shopping = [];

        if(!empty($mall)){

                foreach($mall as $k=>$v){

                    //查找当前订单第一个规格的以旧换新价格
                    $news_money = $this->mall_sku_model->where(['goods_id'=>$v['goods_id']])->field('news_money')->find();
                    $shopping[$k]['price'] = round($v['price']/100);
                    $shopping[$k]['time'] = date('Y-m-d H:i:s',$v['add_time']);
                    $shopping[$k]['photo'] = $v['photo'];
                    $shopping[$k]['homeImg'] = $v['homeImg'];
                    $shopping[$k]['goods_id'] = $v['goods_id'];
                    $shopping[$k]['name'] = $v['name'];
                    $shopping[$k]['add_time'] = $v['add_time'];
                    $shopping[$k]['type_id'] = $v['type_id'];
                    $shopping[$k]['title'] = $v['title'];
                    $shopping[$k]['news_money'] = $news_money['news_money'] /100;
                }        
        }

        //公司信息
        $service_center = Db::name('system')->field('value')->where('name','company_config')->find();
        $sercice_center = unserialize($service_center['value']);


       return   $this->datas = ['list'=>$shopping,'slide'=>$slide,'sercice_center'=>$sercice_center];

    }
    /**
     * @Author   康梓航
     * @Email    1275910740@qq.com  
     * @DateTime 2018-11-29
     * @return   [type]            [description]
     * 收货地址列表选择
     */
    public function addresslist(){

         $member_id = $this->request->param('member_id');

        if(empty($member_id)){
            $this->err(400,'缺少参数');
        }

          $result  = $this->address_model->where(['member_id'=>$member_id])->select();   

        if($result){

            foreach($result as $v){

                $v['add_time'] = date('Y-m-d H:i:s',$v['add_time']);

            }
            $this->datas = ['code'=>200,'msg'=>'添加成功','list'=>$result];
        }else{
            $this->err(400,'查询失败');
        }           


    }
    /**
     * @Author   康梓航
     * @Email    1275910740@qq.com
     * @DateTime 2018-11-29
     * @return   [type]            [description]
     * 增加用户的地址信息
     */
    public function addressadd(){

        $member_id = $this->request->param('member_id');
        $name = $this->request->param('name');
        $mobile = $this->request->param('mobile');
        $address = $this->request->param('address');
        $province = $this->request->param('province');
        $lat = $this->request->param('lat');
        $lng = $this->request->param('lng');
        if(empty($member_id) || empty($name) || empty($mobile) || empty($address) || empty($province) || empty($lat) || empty($lng)){
            $this->err(400,'缺少参数');
        }
        //查找该用户是否已经存在地址 如不存在第一次添加为默认地址
        $result = $this->address_model->where(['member_id'=>$member_id])->find();
        $arr['is_default'] = 1;
        if($result){
            $arr['is_default'] = 0;
        }
        $arr['member_id'] = $member_id;
        $arr['name'] = $name;
        $arr['mobile'] = $mobile;
        $arr['address'] = $address;
        $arr['add_time'] = time();
        $arr['province'] = $province;
        $arr['lat'] = $lat;
        $arr['lng'] = $lng;
        $result  = $this->address_model->allowField(true)->save($arr);
        if($result){
            $this->datas = ['code'=>200,'msg'=>'添加成功'];
        }else{
            $this->err(400,'添加失败');
        }
    }
    /**
     * @Author   康梓航
     * @Email    1275910740@qq.com
     * @DateTime 2018-11-29
     * @return   [type]            [description]
     * 修改地址为默认地址
     */
    public function deafult(){

         $address_id = $this->request->param('address_id');
         $member_id = $this->request->param('member_id');
         if(empty($address_id) || empty($member_id)){
                $this->err(400,'缺少参数');
         }

         $data['is_default'] = 1;
         //查找用户所有的默认地址
         $result  = $this->address_model->where(['member_id'=>$member_id,'is_default'=>1])->select();

         if($result){
            foreach($result as $v){

                $arr['is_default'] = 0;
                $this->address_model->save($arr,['address_id'=>$v['address_id']]);
            }
         }

        $result  = $this->address_model->save($data,['address_id'=>$address_id]);
        if($result){
            $this->datas = ['code'=>200,'msg'=>'修改成功'];
        }else{
            $this->err(400,'修改失败');
        }

    }
    /**
     * @Author   康梓航
     * @Email    1275910740@qq.com
     * @DateTime 2018-11-30
     * @return   [type]            [description]
     *  收货地址编辑
     */
    public function addressedit(){

        $member_id = $this->request->param('member_id');
        $address_id = $this->request->param('address_id');
        if(empty($member_id) || empty($address_id)){
             $this->err(400,'缺少参数');
        }
        //查找该用户是否存在
        if(!$find = $this->user_model->find($member_id)){
            $this->err(400,'该用户不存在');
        }

        $address = $this->address_model->where(['member_id'=>$member_id])->find($address_id);
        if($address){
            $this->datas = ['list'=>$address,'code'=>200];

        }else{
            $this->err(400,'查询失败');
        }

    }
    /**
     * @Author   康梓航
     * @Email    1275910740@qq.com
     * @DateTime 2018-11-30
     * @return   [type]            [description]
     * 收货地址保存
     */
    public function update(){

        $member_id = $this->request->param('member_id');
        $address_id = $this->request->param('address_id');
        $address = $this->request->param('address');
        $mobile = $this->request->param('mobile');
        $name = $this->request->param('name');
        $province = $this->request->param('province');
        $lat = $this->request->param('lat');
        $lng = $this->request->param('lng');
        if(empty($member_id) || empty($address) || empty($mobile) || empty($name) || empty($address_id) || empty($province) || empty($lat) || empty($lng)){
            $this->err(400,'缺少参数');
        }

        if(! $tt= $this->address_model->find($address_id)){
            $this->err(400,'保存没有该地址');
        }

        $strr['member_id'] = $member_id;
        $strr['address'] = $address;
        $strr['mobile'] = $mobile;
        $strr['name'] = $name;
        $strr['province'] = $province;
        $arr['lat'] = $lat;
        $arr['lng'] = $lng;
        $result = $this->address_model->save($strr,['address_id'=>$address_id]);
        

        if($result){
            $this->datas = ['code'=>200,'msg'=>'修改成功'];
        }else{
            $this->err(400,'修改失败');
        }
    }
    /**
     * @Author   康梓航
     * @Email    1275910740@qq.com
     * @DateTime 2018-11-30
     * @return   [type]            [description]
     * 删除收获地址
     */
    public function deltet(){

        $address_id = $this->request->param('address_id');
        if(empty($address_id)){
            $this->err(400,'缺少参数');
        }

        if(! $tt= $this->address_model->find($address_id)){
            $this->err(401,'没有该地址');
        }

        $result = $this->address_model->destroy($address_id);
        
        if($result){
            $this->datas = ['code'=>200,'msg'=>'删除成功'];
        }else{
            $this->err(400,'修改失败');
        }        

    }

    /**
     * @Author   admin
     * @Email    无
     * @DateTime 2018-11-30
     * 上门售后
     */
    public function after_sale(){
        $this->checkUser();//登录验证


        $name = $this->request->param('name');//姓名
        $tel = $this->request->param('tel');//联系方式
        $address = $this->request->param('address');//地址
        if(empty($name) || empty($tel) || empty($address) || ctype_space($name) || ctype_space($tel) || ctype_space($address)){
            $this->err(400,'参数错误!');
        }
        $data['name'] = $name;
        $data['tel'] = $tel;
        $data['address'] = $address;
        $data['uid'] = $this->user_id;
        $data['create_time'] = time();
        if($this->after_sale_model->save($data)){
            $this->datas = ['code'=>200,'msg'=>'提交成功!'];
        }else{
            $this->err(400,'提交失败,请重试!');
        }
    }

    /**
     * @Author   康梓航
     * @Email    1275910740@qq.com
     * @DateTime 2018-12-01
     * @return   [type]            [description]
     * 查询用户可以使用的优惠卷
     */
    public function available(){

         $this->checkUser();//登录验证

       //接收数据
        $menu = json_decode(htmlspecialchars_decode($this->request->param('menu')));

        if(empty($menu)){
                $this->err(400,"缺少参数");
        }
        $goumai = 0;
        //获取用户所在的地址
               
        $menus = [];
        foreach ($menu as $key=>$val) {
                    if ($val->num != 0) {

                            //接受以旧换新或者直接购买的值
                            $is_news = $val->is_news;
                            if(empty($is_news)){$goumai = 1;}
                            //接收延保的金额
                            $warranty = $val->warranty;
                            //商品信息
                            $menu = $this->mall_model->where(['goods_id'=>$val->goods_id])->find();
                            if (empty($menu) || $menu['is_online'] == 2) {
                                    $this->err(400, "商品ID:{$val['goods_id']}已下架或不存在");
                            }
                            if(!empty($val->sku_id)){
                                    $sku = $this->mall_sku_model->where(['sku_id'=>$val->sku_id])->find();
                                    if($goumai == 1){
                                        if($warranty == 1 ){
                                            //计算立即购买与延保一年的价格
                                            $price = $sku->price + $menu['warrantyone'];
                                        }
                                        if($warranty == 2){
                                            //计算立即购买与延保二年的价格
                                            $price = $sku->price + $menu['warrantytwo'];
                                        }
                                        if($warranty == ''){
                                            //计算立即购买不延保的价格
                                            $price = $sku->price;
                                        }                                           
                                        
                                    }else{
                                        if($warranty == 1 ){
                                            //计算以旧换新延保一年的价格
                                            $price = $sku->news_money + $menu['warrantyone'];
                                        }
                                        if($warranty == 2){
                                            //计算以旧换新延保二年的价格
                                            $price = $sku->news_money + $menu['warrantytwo'];
                                        }
                                        if($warranty == ''){
                                            //计算以旧换新不延保的价格
                                                $price = $sku->news_money;
                                        }

                                        
                                    }
                                    
                                    $sku_id = $val->sku_id;
                            }else{
                                    $price = $menu['price'];
                                    $sku_id = 0;
                            }
                            $menus[$key]['is_online'] = $menu['is_online'];
                            $menus[$key]['photo'] = $menu['photo'];
                            $menus[$key]['price'] = $price;
                            $menus[$key]['num'] = $val->num;
                            $menus[$key]['goods_id'] = $val->goods_id;
                            $menus[$key]['sku_id'] = $sku_id;
                            $menus[$key]['name'] = $menu['name'];
                    }
        }
        //商品总金额
        $price = 0;
        foreach ($menus as $val) {

                $price += ceil($val['price']) * $val['num'];
        }

        $sum_price = $price;

        $where['is_use'] = 0;
        $where['bg_data'] = ['elt',time()];
        $where['end_data'] = ['egt',time()];
        $where['man_price'] = ['elt',$sum_price];
        $where['member_id'] = $this->user_id;

        $result = $this->user_coupon_model->where($where)->select();

        if($result){
            foreach($result as $v){
                $v['man_price'] = $v['man_price'] /100;
                $v['price'] = $v['price'] /100;
                $v['bg_data'] = date('Y-m-d H:i:s',$v['bg_data']);
                $v['end_data'] = date('Y-m-d H:i:s',$v['end_data']);

            }
            $this->datas = ['list'=>$result];
        }else{
            $this->err(400,'暂无可用');
        }

    }
    /**
     * @Author   康梓航
     * @Email    1275910740@qq.com
     * @DateTime 2018-11-30
     * @return   [type]            [description]
     * 个人订单
     */
    public function order($page = 1){

        $this->checkUser();//登录验证

        //接受订单状态 代付款 0  待收货 4 待评价 11
        $status = $this->request->param('status');
        $map = [];
        if($status !== ""){
            $map['status'] = $status;
        }

        if($status == 4){
            $map['status'] = ['in','1,2,3'];  
        }

        //查询该用户下的所有订单
        $order = $this->order_model->where(['member_id'=>$this->user_id])->where($map)->field('order_id,need_pay,status')->order('order_id desc')->paginate(10, false, ['page' => $page]);
        $orders = [];

        if($order){
            foreach($order as  $k=>$v){
                //通过订单查找订单商品
                $v['need_pay'] = $v['need_pay'] /100;
                $mall = $this->order_goods_model->where('order_id',$v['order_id'])->field('goods_id,goods_name,num,photo,price,sku_id')->select();
                foreach($mall as $key=>$vv){
                    //查找订单中对应的SKU规格数据
                    $sku =  $this->mall_sku_model->where(['sku_id'=>$vv['sku_id']])->field('name,price,sku_id,news_money')->find();
                    $vv['price'] = $vv['price'] /100;
                    $sku['price'] = $sku['price'] /100;
                    $sku['news_money'] = $sku['news_money'] /100;
                    $mall[$key]['sku'] = $sku;
                    $order[$k]['goods'] = $mall; 

                    //判断当前订单中的商品是否评论过
                    $style = $this->comment_model->where(['order_id'=>$v['order_id'],'mid'=>$vv['goods_id']])->find();
                    if(empty($style)){
                        //如果未找到该商品未评价
                        $mall[$key]['comment'] = 1; 
                    }else{
                        //如果找到该商品已评价
                        $mall[$key]['comment'] = 2; 
                    }    
                }
            }

            $this->datas = $order;            

        }else{
           $this->err(400,'该用户没有订单');

        }
    }
    /**
     * @Author   康梓航
     * @Email    1275910740@qq.com
     * @DateTime 2018-12-03
     * @return   [type]            [description]
     *
     * 订单详情
     */
    public function ordetail(){
        //接收订单ID
        $order_id = $this->request->param('order_id');

        if(empty($order_id)){
            $this->err(400,'缺少参数');
        }
        //查找订单是否存在
        $order = $this->order_model->where(['order_id'=>$order_id])->find();
        $orders = [];
        if($order){

            switch ($order['status'])
            {
            case 0:
                //当前订单为未支付订单 0 等待支付
                $mall = $this->order_goods_model->where('order_id',$order['order_id'])->field('goods_id,goods_name,num,photo,sku_id')->select();
                //查找订单中所有的商品
                foreach($mall as $key=>$vv){
                    //查找规格数据
                    $sku = $this->mall_sku_model->where(['sku_id'=>$vv['sku_id']])->find();
                    $skuall['sku_id'] = $sku['sku_id'];
                    $skuall['news_money'] = $sku['news_money'] /100;
                    $skuall['price'] = $sku['price'] /100;
                    $skuall['name'] = $sku['name'];
                    $mall[$key]['sku'] = $skuall;
                    $orders['goods'] = $mall;                                       //商品
                    $orders['price'] = $order['need_pay'] /100;                     //支付的总金额
                    $orders['name'] = $order['name'];                               //收获人姓名
                    $orders['mobile'] = $order['mobile'];                           //收获人手机号
                    $orders['address'] = $order['address'];                         //收获人地址
                    $orders['add_time'] = date('Y-m-d H:i:s',$order['add_time']);   //下单时间
                    $orders['is_chang'] = $order['is_chang'];  // 1已换货 2 已退货
                }
                $this->datas = ['code'=>200,'list'=>$orders,'msg'=>'订单未支付'];
                break;
            case 1:
                //当前订单为已经支付的订单
                $mall = $this->order_goods_model->where('order_id',$order['order_id'])->field('goods_id,goods_name,num,photo,sku_id')->select();
                //查找订单中所有的商品
                foreach($mall as $key=>$vv){
                    //查找规格数据
                    $sku = $this->mall_sku_model->where(['sku_id'=>$vv['sku_id']])->find();
                    $skuall['sku_id'] = $sku['sku_id'];
                    $skuall['news_money'] = $sku['news_money'] /100;
                    $skuall['price'] = $sku['price'] /100;
                    $skuall['name'] = $sku['name'];
                    $mall[$key]['sku'] = $skuall;
                    $orders['goods'] = $mall;                                 //商品
                    $orders['price'] = $order['need_pay'] /100;                     //支付的总金额
                    $orders['name'] = $order['name'];                               //收获人姓名
                    $orders['mobile'] = $order['mobile'];                           //收获人姓名
                    $orders['address'] = $order['address'];                         //收获人地址
                    $orders['add_time'] = date('Y-m-d H:i:s',$order['add_time']);   //支付时间
                    $orders['pay_time'] = empty($order['pay_time'])?'':date('Y-m-d H:i:s',$order['pay_time']);
                    $orders['is_chang'] = $order['is_chang'];  // 1已换货 2 已退货
                    

                }
                $this->datas = ['code'=>200,'list'=>$orders,'msg'=>'订单已支付'];
                break;
            case 2:

                //当前订单为已发货,等待接单的订单
                $mall = $this->order_goods_model->where('order_id',$order['order_id'])->field('goods_id,goods_name,num,photo,sku_id')->select();

                $log_time = $this->order_log_model->where(['order_id'=>$order['order_id'],'status'=>2])->value('add_time');
                //查找订单中所有的商品
                foreach($mall as $key=>$vv){
                    //查找规格数据
                    $sku = $this->mall_sku_model->where(['sku_id'=>$vv['sku_id']])->find();
                    $skuall['sku_id'] = $sku['sku_id'];
                    $skuall['news_money'] = $sku['news_money'] /100;
                    $skuall['price'] = $sku['price'] /100;
                    $skuall['name'] = $sku['name'];
                    $mall[$key]['sku'] = $skuall;
                    $orders['goods'] = $mall;                                 //商品
                    $orders['price'] = $order['need_pay'] /100;                     //支付的总金额
                    $orders['name'] = $order['name'];                               //收获人姓名
                    $orders['mobile'] = $order['mobile'];                           //收获人姓名
                    $orders['address'] = $order['address'];                         //收获人地址
                    $orders['add_time'] = date('Y-m-d H:i:s',$order['add_time']);   //支付时间
                    $orders['pay_time'] = empty($order['pay_time'])?'':date('Y-m-d H:i:s',$order['pay_time']);  //微信支付时间
                    $orders['log_time'] = empty($log_time)?'':date('Y-m-d H:i:s',$log_time);  //发货时间
                    $orders['is_chang'] = $order['is_chang'];  // 1已换货 2 已退货                
                }
                $this->datas = ['code'=>200,'list'=>$orders,'msg'=>'订单已发货,等待接单']; 
                break;
            case 3:

                //当前订单为取货中的订单
                $mall = $this->order_goods_model->where('order_id',$order['order_id'])->field('goods_id,goods_name,num,photo,sku_id')->select();

                $log_time = $this->order_log_model->where(['order_id'=>$order['order_id'],'status'=>3])->value('add_time');
                //查找订单中所有的商品
                foreach($mall as $key=>$vv){
                    //查找规格数据
                    $sku = $this->mall_sku_model->where(['sku_id'=>$vv['sku_id']])->find();
                    $skuall['sku_id'] = $sku['sku_id'];
                    $skuall['news_money'] = $sku['news_money'] /100;
                    $skuall['price'] = $sku['price'] /100;
                    $skuall['name'] = $sku['name'];
                    $mall[$key]['sku'] = $skuall;
                    $orders['goods'] = $mall;                                       //商品
                    $orders['price'] = $order['need_pay'] /100;                     //支付的总金额
                    $orders['name'] = $order['name'];                               //收获人姓名
                    $orders['mobile'] = $order['mobile'];                           //收获人姓名
                    $orders['address'] = $order['address'];                         //收获人地址
                    $orders['add_time'] = date('Y-m-d H:i:s',$order['add_time']);   //支付时间
                    $orders['pay_time'] = empty($order['pay_time'])?'':date('Y-m-d H:i:s',$order['pay_time']);  //微信支付时间
                    $orders['log_time'] = empty($log_time)?'':date('Y-m-d H:i:s',$log_time);  //取货时间时间
                    $orders['is_chang'] = $order['is_chang'];  // 1已换货 2 已退货                  
                }
                $this->datas = ['code'=>200,'list'=>$orders,'msg'=>'取货中']; 
                break;
            case 4:

                //当前订单为配送中的订单
                $mall = $this->order_goods_model->where('order_id',$order['order_id'])->field('goods_id,goods_name,num,photo,sku_id')->select();

                $log_time = $this->order_log_model->where(['order_id'=>$order['order_id'],'status'=>4])->value('add_time');
                //查找订单中所有的商品
                foreach($mall as $key=>$vv){
                    //查找规格数据
                    $sku = $this->mall_sku_model->where(['sku_id'=>$vv['sku_id']])->find();    
                    $skuall['sku_id'] = $sku['sku_id'];
                    $skuall['news_money'] = $sku['news_money'] /100;
                    $skuall['price'] = $sku['price'] /100;
                    $skuall['name'] = $sku['name'];
                    $mall[$key]['sku'] = $skuall;                                    
                    $orders['goods'] = $mall;                                 //商品
                    $orders['price'] = $order['need_pay'] /100;                     //支付的总金额
                    $orders['name'] = $order['name'];                               //收获人姓名
                    $orders['mobile'] = $order['mobile'];                           //收获人姓名
                    $orders['address'] = $order['address'];                         //收获人地址
                    $orders['add_time'] = date('Y-m-d H:i:s',$order['add_time']);   //支付时间
                    $orders['pay_time'] = empty($order['pay_time'])?'':date('Y-m-d H:i:s',$order['pay_time']);  //微信支付时间
                    $orders['log_time'] = empty($log_time)?'':date('Y-m-d H:i:s',$log_time);  //配送中时间
                    $orders['is_chang'] = $order['is_chang'];  // 1已换货 2 已退货                  
                }
                $this->datas = ['code'=>200,'list'=>$orders,'msg'=>'配送中']; 
                break;  
            case 5:

                //当前订单为已收货的订单
                $mall = $this->order_goods_model->where('order_id',$order['order_id'])->field('goods_id,goods_name,num,photo,sku_id')->select();

                $log_time = $this->order_log_model->where(['order_id'=>$order['order_id'],'status'=>5])->value('add_time');
                //查找订单中所有的商品
                foreach($mall as $key=>$vv){
                    //查找规格数据
                    $sku = $this->mall_sku_model->where(['sku_id'=>$vv['sku_id']])->find();       
                    $skuall['sku_id'] = $sku['sku_id'];
                    $skuall['news_money'] = $sku['news_money'] /100;
                    $skuall['price'] = $sku['price'] /100;
                    $skuall['name'] = $sku['name'];
                    $mall[$key]['sku'] = $skuall;                                 
                    $orders['goods'] = $mall;                                 //商品
                    $orders['price'] = $order['need_pay'] /100;                     //支付的总金额
                    $orders['name'] = $order['name'];                               //收获人姓名
                    $orders['mobile'] = $order['mobile'];                           //收获人姓名
                    $orders['address'] = $order['address'];                         //收获人地址
                    $orders['add_time'] = date('Y-m-d H:i:s',$order['add_time']);   //支付时间
                    $orders['pay_time'] = empty($order['pay_time'])?'':date('Y-m-d H:i:s',$order['pay_time']);  //微信支付时间
                    $orders['log_time'] = empty($log_time)?'':date('Y-m-d H:i:s',$log_time);  //已收货时间
                    $orders['is_chang'] = $order['is_chang'];  // 1已换货 2 已退货                      
                }
                $this->datas = ['code'=>200,'list'=>$orders,'msg'=>'已收货']; 
                break;    
            case 6:

                //当前订单为申请退货的订单
                $mall = $this->order_goods_model->where('order_id',$order['order_id'])->field('goods_id,goods_name,num,photo,sku_id')->select();

                $log_time = $this->order_log_model->where(['order_id'=>$order['order_id'],'status'=>6])->value('add_time');
                //查找订单中所有的商品
                foreach($mall as $key=>$vv){
                    //查找规格数据
                    $sku = $this->mall_sku_model->where(['sku_id'=>$vv['sku_id']])->find();        
                    $skuall['sku_id'] = $sku['sku_id'];
                    $skuall['news_money'] = $sku['news_money'] /100;
                    $skuall['price'] = $sku['price'] /100;
                    $skuall['name'] = $sku['name'];
                    $mall[$key]['sku'] = $skuall;                                
                    $orders['goods'] = $mall;                                 //商品
                    $orders['price'] = $order['need_pay'] /100;                     //支付的总金额
                    $orders['name'] = $order['name'];                               //收获人姓名
                    $orders['mobile'] = $order['mobile'];                           //收获人姓名
                    $orders['address'] = $order['address'];                         //收获人地址
                    $orders['add_time'] = date('Y-m-d H:i:s',$order['add_time']);   //支付时间
                    $orders['pay_time'] = empty($order['pay_time'])?'':date('Y-m-d H:i:s',$order['pay_time']);  //微信支付时间
                    $orders['log_time'] = empty($log_time)?'':date('Y-m-d H:i:s',$log_time);  //申请退款时间
                    $orders['is_chang'] = $order['is_chang'];  // 1已换货 2 已退货                                
                }
                $this->datas = ['code'=>200,'list'=>$orders,'msg'=>'申请退款']; 
                break;   
            case 7:

                //当前订单为退货中的订单
                $mall = $this->order_goods_model->where('order_id',$order['order_id'])->field('goods_id,goods_name,num,photo,sku_id')->select();

                $log_time = $this->order_log_model->where(['order_id'=>$order['order_id'],'status'=>7])->value('add_time');
                //查找订单中所有的商品
                foreach($mall as $key=>$vv){
                    //查找规格数据
                    $sku = $this->mall_sku_model->where(['sku_id'=>$vv['sku_id']])->find();      
                    $skuall['sku_id'] = $sku['sku_id'];
                    $skuall['news_money'] = $sku['news_money'] /100;
                    $skuall['price'] = $sku['price'] /100;
                    $skuall['name'] = $sku['name'];
                    $mall[$key]['sku'] = $skuall;                                  
                    $orders['goods'] = $mall;                                 //商品
                    $orders['price'] = $order['need_pay'] /100;                     //支付的总金额
                    $orders['name'] = $order['name'];                               //收获人姓名
                    $orders['mobile'] = $order['mobile'];                           //收获人姓名
                    $orders['address'] = $order['address'];                         //收获人地址
                    $orders['add_time'] = date('Y-m-d H:i:s',$order['add_time']);   //支付时间
                    $orders['pay_time'] = empty($order['pay_time'])?'':date('Y-m-d H:i:s',$order['pay_time']);  //微信支付时间
                    $orders['log_time'] = empty($log_time)?'':date('Y-m-d H:i:s',$log_time);  //已退款时间
                    $orders['is_chang'] = $order['is_chang'];  // 1已换货 2 已退货
                }
                $this->datas = ['code'=>200,'list'=>$orders,'msg'=>'已退款']; 
                break;                                        
            case 8:

                //当前订单为申请换货的订单
                $mall = $this->order_goods_model->where('order_id',$order['order_id'])->field('goods_id,goods_name,num,photo,sku_id')->select();

                $log_time = $this->order_log_model->where(['order_id'=>$order['order_id'],'status'=>8])->value('add_time');
                //查找订单中所有的商品
                foreach($mall as $key=>$vv){
                    //查找规格数据
                    $sku = $this->mall_sku_model->where(['sku_id'=>$vv['sku_id']])->find();   
                    $skuall['sku_id'] = $sku['sku_id'];
                    $skuall['news_money'] = $sku['news_money'] /100;
                    $skuall['price'] = $sku['price'] /100;
                    $skuall['name'] = $sku['name'];
                    $mall[$key]['sku'] = $skuall;                                     
                    $orders['goods'] = $mall;                                 //商品
                    $orders['price'] = $order['need_pay'] /100;                     //支付的总金额
                    $orders['name'] = $order['name'];                               //收获人姓名
                    $orders['mobile'] = $order['mobile'];                           //收获人姓名
                    $orders['address'] = $order['address'];                         //收获人地址
                    $orders['add_time'] = date('Y-m-d H:i:s',$order['add_time']);   //支付时间
                    $orders['pay_time'] = empty($order['pay_time'])?'':date('Y-m-d H:i:s',$order['pay_time']);  //微信支付时间
                    $orders['log_time'] = empty($log_time)?'':date('Y-m-d H:i:s',$log_time);  //申请换货时间
                    $orders['is_chang'] = $order['is_chang'];  // 1已换货 2 已退货
                }
                $this->datas = ['code'=>200,'list'=>$orders,'msg'=>'申请换货']; 
                break; 
            case 9:

                //当前订单为换货中的订单
                $mall = $this->order_goods_model->where('order_id',$order['order_id'])->field('goods_id,goods_name,num,photo,sku_id')->select();

                $log_time = $this->order_log_model->where(['order_id'=>$order['order_id'],'status'=>9])->value('add_time');
                //查找订单中所有的商品
                foreach($mall as $key=>$vv){
                    //查找规格数据
                    $sku = $this->mall_sku_model->where(['sku_id'=>$vv['sku_id']])->find();   
                    $skuall['sku_id'] = $sku['sku_id'];
                    $skuall['news_money'] = $sku['news_money'] /100;
                    $skuall['price'] = $sku['price'] /100;
                    $skuall['name'] = $sku['name'];
                    $mall[$key]['sku'] = $skuall;                                     
                    $orders['goods'] = $mall;                                 //商品
                    $orders['price'] = $order['need_pay'] /100;                     //支付的总金额
                    $orders['name'] = $order['name'];                               //收获人姓名
                    $orders['mobile'] = $order['mobile'];                           //收获人姓名
                    $orders['address'] = $order['address'];                         //收获人地址
                    $orders['add_time'] = date('Y-m-d H:i:s',$order['add_time']);   //支付时间
                    $orders['pay_time'] = empty($order['pay_time'])?'':date('Y-m-d H:i:s',$order['pay_time']);  //微信支付时间
                    $orders['log_time'] = empty($log_time)?'':date('Y-m-d H:i:s',$log_time);  //换货中时间
                    $orders['is_chang'] = $order['is_chang'];  // 1已换货 2 已退货
                }
                $this->datas = ['code'=>200,'list'=>$orders,'msg'=>'换货中']; 
                break; 
            case 10:

                //当前订单为换货成功的订单
                $mall = $this->order_goods_model->where('order_id',$order['order_id'])->field('goods_id,goods_name,num,photo,sku_id')->select();

                $log_time = $this->order_log_model->where(['order_id'=>$order['order_id'],'status'=>10])->value('add_time');
                //查找订单中所有的商品
                foreach($mall as $key=>$vv){
                    //查找规格数据
                    $sku = $this->mall_sku_model->where(['sku_id'=>$vv['sku_id']])->find(); 
                    $skuall['sku_id'] = $sku['sku_id'];
                    $skuall['news_money'] = $sku['news_money'] /100;
                    $skuall['price'] = $sku['price'] /100;
                    $skuall['name'] = $sku['name'];
                    $mall[$key]['sku'] = $skuall;                                       
                    $orders['goods'] = $mall;                                 //商品
                    $orders['price'] = $order['need_pay'] /100;                     //支付的总金额
                    $orders['name'] = $order['name'];                               //收获人姓名
                    $orders['mobile'] = $order['mobile'];                           //收获人姓名
                    $orders['address'] = $order['address'];                         //收获人地址
                    $orders['add_time'] = date('Y-m-d H:i:s',$order['add_time']);   //支付时间
                    $orders['pay_time'] = empty($order['pay_time'])?'':date('Y-m-d H:i:s',$order['pay_time']);  //微信支付时间
                    $orders['log_time'] = empty($log_time)?'':date('Y-m-d H:i:s',$log_time);  //已完成时间
                    $orders['is_chang'] = $order['is_chang'];  // 1已换货 2 已退货
                }
                $this->datas = ['code'=>200,'list'=>$orders,'msg'=>'换货成功']; 
                break; 
            case 11:
                //当前订单为已完成的订单
                $mall = $this->order_goods_model->where('order_id',$order['order_id'])->field('goods_id,goods_name,num,photo,sku_id')->select();
                $log_time = $this->order_log_model->where(['order_id'=>$order['order_id'],'status'=>11])->value('add_time');
                //查找订单中所有的商品
                foreach($mall as $key=>$vv){
                    //查找规格数据
                    $sku = $this->mall_sku_model->where(['sku_id'=>$vv['sku_id']])->find();  
                    $skuall['sku_id'] = $sku['sku_id'];
                    $skuall['news_money'] = $sku['news_money'] /100;
                    $skuall['price'] = $sku['price'] /100;
                    $skuall['name'] = $sku['name'];
                    $mall[$key]['sku'] = $skuall;                                      
                    $orders['goods'] = $mall;                                 //商品
                    $orders['price'] = $order['need_pay'] /100;                     //支付的总金额
                    $orders['name'] = $order['name'];                               //收获人姓名
                    $orders['mobile'] = $order['mobile'];                           //收获人姓名
                    $orders['address'] = $order['address'];                         //收获人地址
                    $orders['add_time'] = date('Y-m-d H:i:s',$order['add_time']);   //支付时间
                    $orders['pay_time'] = empty($order['pay_time'])?'':date('Y-m-d H:i:s',$order['pay_time']);  //微信支付时间
                    $orders['log_time'] = empty($log_time)?'':date('Y-m-d H:i:s',$log_time);  //已完成时间
                    $orders['is_chang'] = $order['is_chang'];  // 1已换货 2 已退货
                }
                $this->datas = ['code'=>200,'list'=>$orders,'msg'=>'已完成']; 
                break;
            case 12:
                //当前订单为用户已取消的订单
                $mall = $this->order_goods_model->where('order_id',$order['order_id'])->field('goods_id,goods_name,num,photo,sku_id')->select();
                $log_time = $this->order_log_model->where(['order_id'=>$order['order_id'],'status'=>12])->value('add_time');
                //查找订单中所有的商品
                foreach($mall as $key=>$vv){
                    //查找规格数据
                    $sku = $this->mall_sku_model->where(['sku_id'=>$vv['sku_id']])->find();     
                    $skuall['sku_id'] = $sku['sku_id'];
                    $skuall['news_money'] = $sku['news_money'] /100;
                    $skuall['price'] = $sku['price'] /100;
                    $skuall['name'] = $sku['name'];
                    $mall[$key]['sku'] = $skuall;                                   
                    $orders['goods'] = $mall;                                 //商品
                    $orders['price'] = $order['need_pay'] /100;                     //支付的总金额
                    $orders['name'] = $order['name'];                               //收获人姓名
                    $orders['mobile'] = $order['mobile'];                           //收获人姓名
                    $orders['address'] = $order['address'];                         //收获人地址
                    $orders['add_time'] = date('Y-m-d H:i:s',$order['add_time']);   //支付时间
                    $orders['pay_time'] = empty($order['pay_time'])?'':date('Y-m-d H:i:s',$order['pay_time']);  //微信支付时间
                    $orders['log_time'] = empty($log_time)?'':date('Y-m-d H:i:s',$log_time);  //已完成时间
                    $orders['is_chang'] = $order['is_chang'];  // 1已换货 2 已退货
                }
                $this->datas = ['code'=>200,'list'=>$orders,'msg'=>'用户已取消订单']; 
                break;                       
            case 13:
                //当前订单为已完成退货的订单
                $mall = $this->order_goods_model->where('order_id',$order['order_id'])->field('goods_id,goods_name,num,photo,sku_id')->select();
                $log_time = $this->order_log_model->where(['order_id'=>$order['order_id'],'status'=>13])->value('add_time');
                //查找订单中所有的商品
                foreach($mall as $key=>$vv){
                    //查找规格数据
                    $sku = $this->mall_sku_model->where(['sku_id'=>$vv['sku_id']])->find();  
                    $skuall['sku_id'] = $sku['sku_id'];
                    $skuall['news_money'] = $sku['news_money'] /100;
                    $skuall['price'] = $sku['price'] /100;
                    $skuall['name'] = $sku['name'];
                    $mall[$key]['sku'] = $skuall;                                      
                    $orders['goods'] = $mall;                                 //商品
                    $orders['price'] = $order['need_pay'] /100;                     //支付的总金额
                    $orders['name'] = $order['name'];                               //收获人姓名
                    $orders['mobile'] = $order['mobile'];                           //收获人姓名
                    $orders['address'] = $order['address'];                         //收获人地址
                    $orders['add_time'] = date('Y-m-d H:i:s',$order['add_time']);   //支付时间
                    $orders['pay_time'] = empty($order['pay_time'])?'':date('Y-m-d H:i:s',$order['pay_time']);  //微信支付时间
                    $orders['log_time'] = empty($log_time)?'':date('Y-m-d H:i:s',$log_time);  //已完成时间
                    $orders['is_chang'] = $order['is_chang'];  // 1已换货 2 已退货
                }
                $this->datas = ['code'=>200,'list'=>$orders,'msg'=>'已完成退货']; 
                break;                       
            case 14:
                //当前订单为已退款的订单
                $mall = $this->order_goods_model->where('order_id',$order['order_id'])->field('goods_id,goods_name,num,photo,sku_id')->select();
                $log_time = $this->order_log_model->where(['order_id'=>$order['order_id'],'status'=>14])->value('add_time');
                //查找订单中所有的商品
                foreach($mall as $key=>$vv){
                    //查找规格数据
                    $sku = $this->mall_sku_model->where(['sku_id'=>$vv['sku_id']])->find();       
                    $skuall['sku_id'] = $sku['sku_id'];
                    $skuall['news_money'] = $sku['news_money'] /100;
                    $skuall['price'] = $sku['price'] /100;
                    $skuall['name'] = $sku['name'];
                    $mall[$key]['sku'] = $skuall;                                 
                    $orders['goods'] = $mall;                                 //商品
                    $orders['price'] = $order['need_pay'] /100;                     //支付的总金额
                    $orders['name'] = $order['name'];                               //收获人姓名
                    $orders['mobile'] = $order['mobile'];                           //收获人姓名
                    $orders['address'] = $order['address'];                         //收获人地址
                    $orders['add_time'] = date('Y-m-d H:i:s',$order['add_time']);   //支付时间
                    $orders['pay_time'] = empty($order['pay_time'])?'':date('Y-m-d H:i:s',$order['pay_time']);  //微信支付时间
                    $orders['log_time'] = empty($log_time)?'':date('Y-m-d H:i:s',$log_time);  //已完成时间
                    $orders['is_chang'] = $order['is_chang'];  // 1已换货 2 已退货
                }
                $this->datas = ['code'=>200,'list'=>$orders,'msg'=>'已退款']; 
                break;                                                                    
            }
        }
    }
    /**
     * @Author   康梓航
     * @Email    1275910740@qq.com
     * @DateTime 2018-12-03
     * @return   [type]            [description]
     * 用户申请换货接口
     */
    public function exchange(){

        $this->checkUser();//登录验证

        //接收订单ID
        $order_id = $this->request->param('order_id');
        if(empty($order_id)){
            $this->err(400,'缺少参数');
        }
        //查找订单是否存在
        $order_min = $this->order_model->where(['order_id'=>$order_id])->where('is_chang',0)->find();
        if(!$order_min){
            $this->err(401,'该订单不存在');
        }      
        //更改当前订单状态
        $data['status'] = 8;
        $result = $this->order_model->save($data,['order_id'=>$order_id]);

        if($result){
            $status = 8;
            $this->order_model->log($order_id,$this->user_id,$status);
            $this->datas = ['code'=>200,'msg'=>'申请换货成功'];
        }else{
            $this->err(402,'申请失败');
        }

    }
    /**
     * @Author   康梓航
     * @Email    1275910740@qq.com
     * @DateTime 2018-12-04
     * @return   [type]            [description]
     * 用户申请退货接口
     */
    public function returned(){

        $this->checkUser();//登录验证

        //接收订单ID
        $order_id = $this->request->param('order_id');
        if(empty($order_id)){
            $this->err(400,'缺少参数');
        }
        //查找订单是否存在
        $order_min = $this->order_model->where(['order_id'=>$order_id])->find();
        if(!$order_min){
            $this->err(401,'该订单不存在');
        }       
        //更新订单状态为6 退货中
        $data['status'] = 6;
        $result = $this->order_model->save($data,['order_id'=>$order_id]);

        if($result){
            $status = 6;
            $this->order_model->log($order_id,$this->user_id,$status);
            $this->datas = ['code'=>200,'msg'=>'申请退货成功'];
        }else{
            $this->err(402,'申请失败');
        }        

    }
    /**
     * @Author   康梓航
     * @Email    1275910740@qq.com
     * @DateTime 2018-12-04
     * @return   [type]            [description]
     * 用户点击确认收货
     */
    public function confirm(){

        $this->checkUser();//登录验证

        //接收订单ID
        $order_id = $this->request->param('order_id');
        if(empty($order_id)){
            $this->err(400,'缺少参数');
        }
        //查找订单是否存在
        $order_min = $this->order_model->where(['order_id'=>$order_id])->find();
        if(!$order_min){
            $this->err(401,'该订单不存在');
        }       
        //更新订单状态为6 退货中
        $data['status'] = 5;
        $result = $this->order_model->save($data,['order_id'=>$order_id]);

        if($result){
            $status = 5;
            $this->order_model->log($order_id,$this->user_id,$status);
            $this->datas = ['code'=>200,'msg'=>'确认收货成功'];
        }else{
            $this->err(402,'收货失败');
        }        

    }
    /**
     * @Author   康梓航
     * @Email    1275910740@qq.com
     * @DateTime 2018-12-04
     * @return   [type]            [description]
     * 用户取消订单
     */
    public function cancel(){

        $this->checkUser();//登录验证

        //接收订单ID
        $order_id = $this->request->param('order_id');
        if(empty($order_id)){
            $this->err(400,'缺少参数');
        }
        //查找订单是否存在
        $order = $this->order_model->where(['order_id'=>$order_id])->find();
        if(!$order){
            $this->err(401,'该订单不存在');
        }
        if($order['status'] == 0){
            $res = $this->order_model->save(['status'=>12],['order_id'=>$order_id]);
            $this->err(400,'未支付');
        }
        if(!empty($order['pay_yue'])){
            /*余额退款*/ 
            //开启事务
            $this->order_model->startTrans();
            // 更新订单状态为已退款
            $res = $this->order_model->save(['status'=>12],['order_id'=>$order_id]);
            // 添加订单状态记录
            $res2 = $this->order_model->log($order_id,$order['member_id'],12);
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

            $peisong_order = $this->peisong_order_model->where(['order_id'=>$order_id,'type'=>0])->find();     

            //删除配送订单
            $res5 = $this->peisong_order_model->where(['order_id'=>$order_id,'type'=>0])->delete();

            // 添加订单状态记录
            $this->order_model->log($order_id,$order['member_id'],12,1);            

            if($res && $res2 && $res3 && $res4 && $res5){
                 if(send_socket(json_decode($peisong_order['member_ids']),['type'=>2,'order_id'=>$order_id])){
                    $this->datas = ['code'=>200,'msg'=>'退款成功并提交订单'];
                 }                
                $result = $this->order_goods_model->where(['order_id'=>$order_id])->select();
                if($result){
                    foreach ($result as $key => $v) {
                        $this->mall_model->where(['goods_id'=>$v['goods_id']])->setInc('stock');
                    }
                }                   
                // 提交事务
                $this->order_model->commit(); 
               
            }else{
                // 回滚事务
                $this->order_model->rollback();
                $this->datas = ['code'=>500,'msg'=>'退款失败,请稍候再试!'];
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
                $this->datas = ['code'=>500,'msg'=>'退款失败,请稍候再试!'];
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
                $result = $this->order_goods_model->where(['order_id'=>$order_id])->select();
                if($result){
                    foreach ($result as $key => $v) {
                        $this->mall_model->where(['goods_id'=>$v['goods_id']])->setInc('stock');
                    }
                }
                $this->datas = ['code'=>200,'msg'=>'退款成功'];
            }else{
                // 回滚事务
                $this->order_model->rollback();
                $this->datas = ['code'=>500,'msg'=>'退款失败,请稍候再试!'];
            }
        }     
    }
    /**
     * @Author   康梓航
     * @Email    1275910740@qq.com
     * @DateTime 2018-12-04
     * @return   [type]            [description]
     * 订单直接购买接口
     */
    public function purchase(){

        $this->checkUser();//登录验证
        //接收订单ID
        $order_id = $this->request->param('order_id');
        if(empty($order_id)){
            $this->err(400,'缺少参数');
        }
        //查找订单是否存在
        $order = $this->order_model->where(['order_id'=>$order_id,'status'=>0])->find();
        if(!$order){
            $this->err(401,'该订单不存在');
        }


        //使用余额支付
        $is_yvue = (float)$this->request->param('is_yvue');//月抵消
        $is_weixin_paty = true;
        //使用了余额
        $yve_pirce = 0;
        if ($is_yvue == 1) {
            $balance = $this->user_model->where(['id'=>$this->user_id])->value('balance');
            if ($balance >= $order['need_pay']/100) {
                $is_weixin_paty = false;
                $yve_pirce = $order['need_pay']; //全部支付
              
                //减少用户的余额并产生消费记录
                $newblance = $balance - $yve_pirce/100;
                $data['balance'] = $newblance;
                $balance = $this->user_model->allowField(true)->save($data, ['id'=>$this->user_id]);
                if(!$balance){
                     $this->err(400,'余额更新失败');
                }

                $arr['uid'] = $this->user_id;
                $arr['type'] = 2;
                $arr['money'] = $yve_pirce/100;
                $arr['balance'] = $newblance;
                $arr['status'] = 1;
                $arr['create_time'] = time();
                $this->user_balance_log_model->allowField(true)->save($arr);
                $att['status'] = 1;
                $order = $this->order_model->allowField(true)->save($att, ['order_id'=>$order_id]);

            } else {
                $this->err(500, '抱歉,您余额不足,请充值!');
            }
        }        
       if($is_weixin_paty){
            if(empty(config('custom.CUSTOM_USERAPPID')) || empty(config('custom.CUSTOM_MCHID')) || empty(config('custom.CUSTOM_WXKEY')) || empty(config('custom.CUSTOM_USERAPPSECRET')) || empty(config('custom.CUSTOM_APICLIENTCERT')) || empty(config('custom.CUSTOM_APICLIENTKEY'))){
                $this->err(400,"抱歉,未配置微信支付,请联系管理员!");
            }

            define('WX_APPID', config('custom.CUSTOM_USERAPPID'));
            define('WX_MCHID', config('custom.CUSTOM_MCHID'));
            define('WX_KEY', config('custom.CUSTOM_WXKEY'));
            define('WX_APPSECRET', config('custom.CUSTOM_USERAPPSECRET'));
            define('WX_SSLCERT_PATH', config('custom.CUSTOM_APICLIENTCERT'));
            define('WX_SSLKEY_PATH', config('custom.CUSTOM_APICLIENTKEY'));
            define('WX_CURL_PROXY_HOST', '0.0.0.0');
            define('WX_CURL_PROXY_PORT', 0);
            define('WX_REPORT_LEVENL', 0);
            require_once ROOT_PATH . "/vendor/weixinpay/lib/WxPay.Api.php";
            require_once ROOT_PATH . "/vendor/weixinpay/example/WxPay.JsApiPay.php";
            $tools = new \JsApiPay();
            $input = new \WxPayUnifiedOrder();
            $input->SetBody("商品购买");
            $input->SetAttach($order_id);
            $input->SetOut_trade_no(WX_MCHID . rand(1000, 9999) . $order_id);
            $input->SetTotal_fee($order['need_pay']);
            $input->SetTime_start(date("YmdHis"));
            $input->SetTime_expire(date("YmdHis", time() + 600));
            $input->SetNotify_url("http://" . $_SERVER['HTTP_HOST'] . "/api/Payment/pay_mall");
            $input->SetTrade_type("JSAPI");
            $input->SetOpenid($this->openid);
            $order = \WxPayApi::unifiedOrder($input);
            $jsApiParameters = $tools->GetJsApiParameters($order);

            $this->datas= json_decode($jsApiParameters, true);
        }
    }
}  