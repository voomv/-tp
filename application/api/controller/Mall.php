<?php
namespace app\api\controller;

use app\common\model\User as UserModel;
use app\common\model\Mall as MallModel;
use app\common\model\MallSku as MallSkuModel;
use app\common\model\Coupon as CouponModel;
use app\common\model\Order as OrderModel;
use app\common\model\UserCoupon as UserCouponModel;
use app\common\model\OrderGoods as OrderGoodsModel;
use app\common\model\Address as AddressModel;
use app\common\model\UserBalanceLog as UserBalanceLogModel;
use app\common\controller\ApiBase;
use think\Cache;
use think\Config;
use think\Db;

/**
 * 商品控制器
 * Class Login
 * @package app\api\controller
 */
class Mall extends ApiBase
{
		protected $checkUserLogin = true;
		protected $user_model;
		protected $mall_sku_model;
		protected $mall_model;
		protected $coupon_model;
		protected $order_model;
		protected $user_coupon_model;
		protected $order_goods_model;
		protected $address_model;
		protected $user_balance_log_model;
		protected function _initialize()
		{
				parent::_initialize();
				
				$this->user_model = new UserModel();  //用户表
				$this->mall_model = new MallModel();  //商品表
				$this->mall_sku_model = new MallSkuModel();  //商品规格表
				$this->coupon_model = new CouponModel();  //优惠卷表
				$this->order_model = new OrderModel();//订单表
				$this->user_coupon_model = new UserCouponModel();//用户优惠卷表
				$this->order_goods_model = new OrderGoodsModel(); // 订单商品表
				$this->address_model = new AddressModel(); // 用户地址表
				$this->user_balance_log_model = new UserBalanceLogModel();//用户余额记录表
		}
		/**
		 * @Author   康梓航
		 * @Email    1275910740@qq.com
		 * @DateTime 2018-11-26
		 * @return   [type]            [description] 
		 * 商品列表
		 */
		public function lists($page = 1 ,$cid = 1){

			$map = [];

			if(!empty($cid)){
					$map['type_id'] = ['like',"%{$cid}%"];

			}
			$mall = $this->mall_model->where($map)->where('stock','>',0)->where(['is_online'=>1])->order('orderby desc')->field('photo,goods_id,name,add_time')->paginate(15, false, ['page' => $page]);

			if($mall){
				foreach($mall as $v){
					$v['add_time'] = date('Y-m-d H:i:s',$v['add_time']);
				}

				$this->datas = ['list'=>$mall,'msg'=>"查询成功!"];    		

			}else{

				 $this->err(400,"抱歉！数据为空");
			}	
		}
		/**
		 * @Author   康梓航
		 * @Email    1275910740@qq.com
		 * @DateTime 2018-11-26
		 * 商品详情页
		 */
		public function detail(){

			$id  = $this->request->param('id');

			if(empty($id)){

				$this->err(400,"缺少参数");
			}

			//查找该商品的sku
			//
			$sku = $this->mall_sku_model->where('goods_id',$id)->select();

			foreach($sku as $v){
				$v['news_money'] = $v['news_money']/100;
				$v['price'] = $v['price']/100;
			}

			$mall = $this->mall_model->find($id);


			$price = $mall->price /100;
			$mall->price = $price;

			$warrantyone = $mall->warrantyone /100;
			$mall->warrantyone = $warrantyone;

			$warrantytwo = $mall->warrantytwo /100;
			$mall->warrantytwo = $warrantytwo;

			$banner = $mall->banner;
			$json_banner = json_decode($banner,true);
			$mall->banner = $json_banner;

			$admit = $mall->admit;
			$trim = trim($admit,'，');
			$arr_admit = explode('，',$trim);
			$mall->admit = $arr_admit;

			if(!empty($mall)){
				$this->datas = ['list'=>$mall,'sku'=>$sku,'msg'=>"查询成功!"]; 
			}else{
				$this->err(400,"查询失败");
			}

		}
		/**
		 * @Author   康梓航
		 * @Email    1275910740@qq.com
		 * @DateTime 2018-11-26
		 * @return   [type]            [description] 
		 * 优惠卷列表信息
		 */
		public function coupon($page = 1){
				
			$coupon = $this->coupon_model->order('orderby desc')->where('end_data','>',time())->where('num','>',0)->where('is_online',1)->paginate(15, false, ['page' => $page]);

			//判断该用户那些优惠卷有领取

			 if($coupon){
				//转化时间格式
				foreach($coupon as $k=>$v){
					if($this->user_coupon_model->where(['member_id'=>$this->user_id,'coupon_id'=>$v['id']])->find()){
						$coupon[$k]['is_lg'] = 1;
		            }else{
		            	$coupon[$k]['is_lg'] = 0;
		            }
					//转化时间格式
					$v['bg_data'] = date('Y-m-d H:i:s',$v['bg_data']);
					$v['end_data'] = date('Y-m-d H:i:s',$v['end_data']);
					$v['add_time'] = date('Y-m-d H:i:s',$v['add_time']);
					$v['price'] = $v['price']/100;
					$v['man_price'] = $v['man_price']/100;

				}

				$this->datas = ['list'=>$coupon,'msg'=>"查询成功!"]; 

			 }else{
				$this->err(400,"查询失败");
			}
		}

		/**
		 * @Author   康梓航
		 * @Email    1275910740@qq.com
		 * @DateTime 2018-11-27
		 * @return   [type]            [description]
		 * 领取优惠卷表
		 */
		public function receive(){

				$coupon_id = $this->request->param('coupon_id');

				if(empty($coupon_id)){
						 $this->err(400,"缺少参数");
				}
				//查看优惠价是否存在并验证是否上架
				$coupon_info = $this->coupon_model->where(['id'=>$coupon_id])->find();

				if(empty($coupon_info) || $coupon_info['is_online'] == 1 || $coupon['end_data']>time()){

						if($coupon_info['num'] == 0){
								$this->err(401,'优惠券已领取完');
						}
						$user =  $this->user_coupon_model->where(['member_id'=>$this->user_id,'coupon_id'=>$coupon_id])->find();
						if(!empty($user)){
								$this->err(402,'您已经领取');
						}
				//生成卡号
				$number  =  $this->user_id . $order_id_main = date('YmdHis') . rand(10000000,99999999);
						//此优惠卷可以领取 
						$result = $this->user_coupon_model->save([
							'member_id'=>$this->user_id,
							'coupon_id'=>$coupon_id,
							'is_use'=>0,
							'coupon_num' => $number,
							'bg_data'=>$coupon_info['bg_data'],
							'end_data'=>$coupon_info['end_data'],
							'price'=>$coupon_info['price'],
							'man_price'=>$coupon_info['man_price'],
							'title'=>$coupon_info['title'],
							'add_time'=>time(),
						 ]);
						if($result){
								$this->datas = ['code'=>200,'msg'=>"领取成功!"]; 
								//增加优惠卷的已领次数
								$this->coupon_model->where(['id'=>$coupon_id])->setInc('receive_num');
								$this->coupon_model->where(['id'=>$coupon_id])->setDec('num');
						}else{
								$this->err(404,"领取失败");
						}
				}else{
						$this->err(405,"优惠卷已过期！");
				}
		}
		/**
		 * @Author   康梓航
		 * @Email    1275910740@qq.com
		 * @DateTime 2018-11-27 
		 * @return   [type]            [description]
		 * 我的优惠卷
		 */
		public function myCoupon($status = 1){

			//1 为用户待使用  2为已使用  3已过期
			$map = [];

			if($status == 1){

				$map['is_use']  = 0;
        		$map['bg_data'] = ['elt',time()];
        		$map['end_data'] = ['egt',time()];				
			}
			if($status == 2){

				$map['is_use']  = 1;
			}
			if($status == ''){
				$map['end_data'] = ['elt',time()];
			}
				$where['member_id'] = $this->user_id;

				$list = $this->user_coupon_model->where($map)->where($where)->order('end_data desc')->select();
				$data = [];
				foreach($list as $k=>$v){
					$data[$k]['id'] = $v['user_coupon_id'];
					$data[$k]['coupon_id'] = $v['coupon_id'];
					$data[$k]['bg_data'] = date('Y-m-d H:i:s',$v['bg_data']);
					$data[$k]['end_data'] = date('Y-m-d H:i:s',$v['end_data']);
					$data[$k]['price'] = $v['price']/100;
					$data[$k]['title'] = $v['title'];
					$data[$k]['add_time'] = date('Y-m-d H:i:s',$v['add_time']);
					$data[$k]['man_price'] = $v['man_price']/100;
					$data[$k]['coupon_num'] = $v['coupon_num'];
				}

				$this->datas['list'] = $data;
		}    

		/**
		 * @Author   康梓航
		 * @Email    1275910740@qq.com
		 * @DateTime 2018-11-26
		 * @return   [type]       [description]
		 * 订单数据产生
		 */
		public function order (){
				//接收数据
			 	$menu_object = json_decode(htmlspecialchars_decode($this->request->param('menu')));
				if(empty($menu_object)){
					$this->err(400,"缺少参数");
				}
				//接收收货地址ID
				$address_id = $this->request->param('address_id');

				$goumai = 0;

				//获取用户所在的地址
				$address =  $this->address_model->where(['address_id'=>$address_id])->find();

				if(empty($address)){
					$this->err(400,"缺少收货地址");
				}				
				$menus = [];
				foreach ($menu_object as $key=>$val) {
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

				//判断是否可以使用优惠卷
				
				$user_coupon_id= (int)$this->request->param('coupon_id');
				if (!empty($user_coupon_id)) {
					//判断该用户下是否有该优惠卷
					if (!$coupon = $this->user_coupon_model->where(['user_coupon_id'=>$user_coupon_id])->find()) {
						$this->err(400, '优惠券未领取');
					}
					//判断该优惠卷是否存在
					if(!$Coupon_info = $this->coupon_model->where(['id'=>$coupon->coupon_id])->find()){
						$this->err(400, '优惠券不存在');
					}
					//判断该优惠卷是否过期
					$date = time();

					if ($coupon->bg_data > $date || $coupon->end_data < $date) {
						$this->err(400, '优惠券不可用2');
					}
					 //判断该优惠卷是否下架
					if ($Coupon_info->is_online != 1) {
						$this->err(400, '优惠券不可用1');
					}
					//判断该优惠卷金额是否达到标准
					if ($Coupon_info->man_price > $price || $price - $Coupon_info->price <= 0) {
						$this->err(400, '优惠券金额不够');
					}
					//优惠卷价格
					$coupon_money = 0;
					//计算使用了优惠卷的金额
					$coupon_money = $coupon_money+$Coupon_info->price;
					$sum_price = $price - $Coupon_info->price;
					//修改用户使用完优惠卷之后的数量
					$this->user_coupon_model->save(['is_use' => 1,'user_time' => time()], ['user_coupon_id' => $user_coupon_id]);
				}

				//使用余额支付
			 		$is_yvue = (float)$this->request->param('is_yvue');//月抵消
			        $is_weixin_paty = true;
			        //使用了余额
			        $yve_pirce = 0;
			        if ($is_yvue == 1) {
			        	$balance = $this->user_model->where(['id'=>$this->user_id])->value('balance');
			            if ($balance >= $sum_price/100) {
			                $is_weixin_paty = false;
			                $yve_pirce = $sum_price; //全部支付
			              
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
			              	
			            } else {
			                $this->err(500, '抱歉,您余额不足,请充值!');
			            }
			        }
			        $weixin_money = $sum_price - $yve_pirce;

				$order_data = $this->order_model->save([
								'member_id' => $this->user_id,          //用户ID
								'total_money' => $price,                //总金额
								'need_pay' => $sum_price,               //实际支付的金额
								'pay_money' => $weixin_money,              //在线支付的金额
								'pay_coupon' => empty($Coupon_info->price)?0:$Coupon_info->price,    //优惠卷支付金额
								'coupon_id' => empty($Coupon_info->id)?0:$Coupon_info->id,        //优惠卷的ID
								'pay_yue' => $yve_pirce,                //余额支付
								'mobile' => $address->mobile,           //收货人手机
								'name' => $address->name,               //收货人姓名
								'address' => $address->address,  //收货人地址
								'province' => $address->province, //省市区
								'lat' => $address->lat,                 //收货人精度
								'lng' => $address->lng,                 //收货人维度
								'info' => '备注',                        //订单备注
								'status' => $is_weixin_paty ? 0 : 1,
								'last_time' => $this->request->time() + 1800, //订单过期时间  30分钟有效期；
								'add_time' => time(),
				]);
				//获取订单号
				$order_id =  $this->order_model->order_id;
				//生成订单中的商品数据 
				$malls = [];
				foreach ($menus as $val) {
						if ($val['is_online'] == 1) {
								$malls[] = [
										'order_id' => $order_id,
										'member_id' => $this->user_id,
										'photo' => $val['photo'],
										'goods_name' => $val['name'],
										'price' => empty($val['num']) ? 0 : $val['num'] * $val['price'],
										'num' => empty($val['num']) ? 0 : $val['num'],
										'goods_id' => $val['goods_id'],
										'sku_id' => $val['sku_id'],
								];
						}
				}

				$this->order_goods_model->saveAll($malls);

				if(!$is_weixin_paty){
 						$result = $this->order_goods_model->where(['order_id'=>$order_id])->select();
                        if($result){
                        	foreach ($result as $key => $v) {
                        		$this->mall_model->where(['goods_id'=>$v['goods_id']])->setDec('stock');
                        		$this->mall_model->where(['goods_id'=>$v['goods_id']])->setInc('sales');
                        	}
                        }					
				}

				if($is_weixin_paty){
 					// 判断是否配置支付
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
			        $input->SetTotal_fee($sum_price);
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