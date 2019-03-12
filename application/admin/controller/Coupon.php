<?php
namespace app\admin\controller;

use app\common\controller\AdminBase;
use app\common\model\Mall as MallModel;
use app\common\model\MallSku as MallSkuModel;
use app\common\model\Coupon as CouponModel;
use think\Db;

/**
 * 优惠券管理
 * Class Coupon
 * @package app\admin\controller 
 */
class Coupon extends AdminBase
{
	protected $mall_model;
    protected $mall_sku_model;
    protected $coupon_model;
    protected function _initialize()
    {
        parent::_initialize();
        $this->mall_model = new MallModel();  //商品表
        $this->mall_sku_model = new MallSkuModel();  //商品规格表
        $this->coupon_model = new CouponModel();  //商品规格表
    }

    /**
     * @Author   康梓航
     * @Email    1275910740@qq.com
     * @DateTime 2018-11-22
     * @return   [type][description]   
     * 商品列表
     */
    
    public function index($keyword = '', $page = 1)
    {
        $map   = [];
        $field = 'id,title,price,man_price,bg_data,end_data,is_online,num,receive_num,add_time';
        if (!empty($keyword)) {
            $map['title'] = ['like', "%{$keyword}%"];
        }

        $coupon  = $this->coupon_model->field($field)->where($map)->order(['add_time' => 'DESC'])->paginate(15, false, ['page' => $page]);

        $page = $coupon->render();

        return $this->fetch('index',['coupon'=>$coupon,'page'=>$page]);
    }
    /**
     * @Author   康梓航
     * @Email    1275910740@qq.com
     * @DateTime 2018-11-22
     * @return   [type][description]   
     * 添加优惠券页面
     */
    public function add(){

        return $this->fetch();

    }
    
    /**
     * @Author   康梓航
     * @Email    1275910740@qq.com
     * @DateTime 2018-11-22
     * @return   [type][description]   
     * 数据添加
     */
    public function save(){

        if ($this->request->isPost()) {
            $data             = $this->request->param();
            $data['add_time'] = time();
            $data['bg_data'] = strtotime($data['bg_data']);
            $data['end_data'] = strtotime($data['end_data']);
            $data['price'] = $data['price']*100;
            $data['man_price'] = $data['man_price']*100;
            if ($this->coupon_model->allowField(true)->save($data)) {
                $this->success('保存成功');
            } else {
                $this->error('保存失败');
            }
        }
    }
    /**
     * @Author   康梓航
     * @Email    1275910740@qq.com
     * @DateTime 2018-11-22
     * @return   [type][description]   
     * 数据更新展示
     */
    public function edit($id){
       
        $coupon = $this->coupon_model->find($id);
        $this->assign('coupon',$coupon);

        return $this->fetch();
    }
    /**
     * @Author   康梓航
     * @Email    1275910740@qq.com
     * @DateTime 2018-11-22
     * @return   [type][description]   
     * 优惠券数据更新
     */
    public function update($id){

        if ($this->request->isPost()) {
            $data            = $this->request->param();
            $data['add_time'] = time();
            $data['bg_data'] = strtotime($data['bg_data']);
            $data['end_data'] = strtotime($data['end_data']);
            $data['price'] = $data['price']*100;
            $data['man_price'] = $data['man_price']*100;
            if ($this->coupon_model->allowField(true)->save($data, $id) !== false) {
                $this->success('更新成功');
            } else {
                $this->error('更新失败');
            }
        }

    }
    /**
     * @Author   康梓航
     * @Email    1275910740@qq.com
     * @DateTime 2018-11-22
     * @return   [type][description]   
     * 优惠券删除数据
     */
    public function delete($id = 0, $ids = [])
    {
        $id = $ids ? $ids : $id;
        if ($id) {
            if ($this->coupon_model->destroy($id)) {
                $this->success('删除成功');
            } else {
                $this->error('删除失败');
            }
        } else {
            $this->error('请选择需要删除的优惠券');
        }
    }
    /**
     * @Author   康梓航
     * @Email    1275910740@qq.com
     * @DateTime 2018-11-22
     * @return   [type][description]   
     * 状态切换
     */
    public function toggle($ids = [], $type = '')
    {
        $data   = [];
        $status = $type == 'audit' ? 1 : 2;

        if (!empty($ids)) {
            foreach ($ids as $value) {
                $data[] = ['id' => $value, 'is_online' => $status];
            }
            if ($this->coupon_model->saveAll($data)) {
                $this->success('操作成功');
            } else {
                $this->error('操作失败');
            }
        } else {
            $this->error('请选择需要操作的优惠券');
        }
    }

}