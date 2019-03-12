<?php
namespace app\admin\controller;

use app\common\controller\AdminBase;
use app\common\model\Mall as MallModel;
use app\common\model\MallSku as MallSkuModel;
use think\Db;

/**
 * 商品管理
 * Class Mall
 * @package app\admin\controller 
 */
class Mall extends AdminBase
{
	protected $mall_model;
    protected $mall_sku_model;
    protected function _initialize()
    {
        parent::_initialize();
        $this->mall_model = new MallModel();  //商品表
        $this->mall_sku_model = new MallSkuModel();  //商品规格表
    }

    /**
     * @Author   康梓航
     * @Email    1275910740@qq.com
     * @DateTime 2018-11-22
     * @return   [type][description]   
     * 商品列表
     */
    
   public function index($type_id = 0, $keyword = '', $page = 1)
    {
        $map   = [];
        $dll   = [];
        $field = 'goods_id,name,price,photo,is_online,is_home,sales,add_time,type_id,orderby,stock';

        if (!empty($keyword)) {
            $map['name'] = ['like', "%{$keyword}%"];
        }
        if (!empty($type_id)) {
            $dll['type_id'] = ['like', "%{$type_id}%"];
        }

        $mall  = $this->mall_model->field($field)->where($map)->where($dll)->order(['add_time' => 'DESC'])->paginate(15, false, ['page' => $page]);

        $page = $mall->render();

        return $this->fetch('index', ['mall' => $mall, 'type_id' => $type_id, 'keyword' => $keyword,'page'=>$page]);
    }
    /**
     * @Author   康梓航
     * @Email    1275910740@qq.com 
     * @DateTime 2018-11-22
     * 商品添加
     */
    public function add(){


       return  $this->fetch();
    }
    /**
     * @Author   康梓航
     * @Email    1275910740@qq.com
     * @DateTime 2018-11-22
     * @return   [type]            [description]
     * 添加商品数据
     */
    public function save(){


    	if ($this->request->isPost()){

            $data            = $this->request->param();
            $validate_result = $this->validate($data, 'Mall');
            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
                $data['add_time'] = time();
                $data['price'] = $data['price'] * 100;
                $data['warrantyone'] = $data['warrantyone'] * 100;
                $data['warrantytwo'] = $data['warrantytwo'] * 100;
                //处理多图
                $banner = $data['banner'];
                if(count($banner) > 5){
                     $this->error("banner 图不可大于5张",null,101);
                }
                $json_banner = json_encode($banner);
                $data['banner'] = $json_banner;
                //处理商品规格的数据 
                $sku = $this->request->param("sku/a");

                // $sku = $data['sku'];
                //判断多规格的参数是否为空
                $i=$num=0;$skus = [];
                foreach ($sku as $val){
                    $i++;
                        if(empty($val['name'])){
                            $this->error("第{$i}行属性中属性名称没有填写",null,101);
                        }

                        if(empty($val['news_money'])){
                                 $this->error("类型SKU的价格没有填写",null,101);
                        }
                        if(empty($val['price'])){
                            $this->error("第{$i}行属性中价格没有填写",null,101);
                        }
                      
                        $skus[] = [
                            'name' => $val['name'],
                            'news_money' => (float)$val['news_money'] * 100,
                            'price' => (float)$val['price'] * 100,
                            'add_time' => time(),
                        ];

                }    

                if ($this->mall_model->allowField(true)->save($data)) {
                    $id = $this->mall_model->goods_id;
                    if(!empty($skus)){
                        //添加商品规格
                        foreach ($skus as $key=>$val){
                            $skus[$key]['goods_id'] = $id;
                        }
                        $this->mall_sku_model->saveAll($skus);
                    }               
                        $this->success('保存成功','admin/mall/index');
                }else{
                        $this->error('保存失败');
                }                    


            }
        }

    }
    /**
     * @Author   康梓航
     * @Email    1275910740@qq.com
     * @DateTime 2018-11-22
     * @return   [type] [description]
     * 商品管理编辑页面
     */
    public function edit($id){

        $mall = $this->mall_model->find($id);

        $mall_sku = $this->mall_sku_model->where('goods_id',$id)->select();

        $this->assign('mall',$mall);
        $this->assign('skus',$mall_sku);

        return $this->fetch('edit', ['mall' => $mall]);

    }

    /**
     * @Author   康梓航
     * @Email    1275910740@qq.com
     * @DateTime 2018-11-22
     * @return   [type] [description]
     * 商品管理编辑页面数据保存
     */
    public function update($goods_id){

        if ($this->request->isPost()) {
            
            $data            = $this->request->param();
            $validate_result = $this->validate($data, 'Mall');
            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
                //图片处理
                $data['price'] = $data['price'] * 100;
                $data['warrantyone'] = $data['warrantyone'] * 100;
                $data['warrantytwo'] = $data['warrantytwo'] * 100;

                $banner = $data['banner'];
                if(count($banner) > 5){
                     $this->error("banner 图不可大于5张",null,101);
                }                
                $json_banner = json_encode($banner);
                $data['banner'] = $json_banner;
                    $sku = empty($data['sku']) ? [] : $data['sku'];

                    $oldsku = empty($data['oldsku']) ? [] : $data['oldsku'];
                    $oldskus = $this->mall_sku_model->where(['goods_id'=>$goods_id])->select();
                     $oldskuAll =  [];
                     $i=$num=0;$skus = [];
                     foreach ($oldskus as $val){
                         if(empty($oldsku[$val->sku_id])){
                             $oldskuAll[] = [
                                 'sku_id' => $val->sku_id,
                                 'goods_id' => $goods_id,
                                 'name' => $val->name,
                                 'news_money'=> $val->news_money,
                                 'price' => (int) $val->price * 100,
                             ];
                         }else{
                             $i++;
                             if(empty($oldsku[$val->sku_id]['name'])){
                                 $this->error("第{$i}行属性中属性名称没有填写",null,101);
                             }
                             if(empty($oldsku[$val->sku_id]['price'])){
                                 $this->error("第{$i}行属性中现价没有填写",null,101);
                             }


                             $oldskuAll[] = [
                                 'sku_id' => $val->sku_id,
                                 'name' => $oldsku[$val->sku_id]['name'],
                                 'price' => (float)$oldsku[$val->sku_id]['price'] * 100,
                                 'goods_id' => $goods_id,
                                 'news_money'=> $oldsku[$val->sku_id]['news_money']*100,
                             ];
                         }
                    }
                    foreach ($sku as $val){
                        $i++;
                            if(empty($val['name'])){
                                $this->error("第{$i}行属性中属性名称没有填写",null,101);
                            }

                            if(empty($val['news_money'])){
                                     $this->error("行属性中价格没有填写",null,101);
                            }
                            if(empty($val['price'])){
                                $this->error("第{$i}行属性中价格没有填写",null,101);
                            }
                            $skus[] = [
                                'name' => $val['name'],
                                'news_money' => (float)$val['news_money'] * 100,
                                'price' => (float)$val['price'] * 100,
                                'add_time' => time(),
                            ];
                    }                


            }

            if(!empty($skus)){
                //更新商品规格
                foreach ($skus as $key=>$val){
                    $skus[$key]['goods_id'] = $goods_id;
                }
                if(!empty($skus)){
                     $this->mall_sku_model->saveAll($skus);
                }
            }
            if(!empty($oldskuAll)){
                 $this->mall_sku_model->saveAll($oldskuAll);
            }
           
            //更新商品
            $this->mall_model->allowField(true)->save($data,['goods_id'=>$goods_id]);
           
            $this->success('操作成功',null,100);             
        }

    }

    /**
     * @Author   康梓航
     * @Email    1275910740@qq.com
     * @DateTime 2018-11-26
     * @return   [type]            [description]
     * 删除商品中的sku规格
     */
    public function skuDelete(){

        $sku_id = (int) $this->request->param('sku_id');
        if(empty($sku_id)){
            return 2;
        }
      
        if($this->mall_sku_model->where(['sku_id'=>$sku_id])->delete()){
            return 1;
        }else{
            return 2;
        }        

    }
    /**
     * @Author   康梓航
     * @Email    1275910740@qq.com
     * @DateTime 2018-11-26
     * @return   [type]            [description]
     * 删除商品信息
     */
     public function delete($id = 0, $ids = [])
    {
        $id = $ids ? $ids : $id;
        if ($id) {
            if ($this->mall_model->destroy($id)) {
                $this->success('删除成功');
            } else {
                $this->error('删除失败');
            }
        } else {
            $this->error('请选择需要删除的商品');
        }
    }
    /**
     * @Author   康梓航
     * @Email    1275910740@qq.com
     * @DateTime 2018-11-26
     * @param    array             $ids  [商品ID]
     * @param    string            $type [description]
     * @return   [type]                  [description]
     */
    public function toggle($ids = [], $type = '')
    {

        $data   = [];
        $status = $type == 'audit' ? 1 : 2;

        if (!empty($ids)) {
            foreach($ids as $v){
                $data[] = ['goods_id'=>$v,'is_online'=>$status];
            }
            if ($this->mall_model->saveAll($data)) {
                $this->success('操作成功');
            } else {
                $this->error('操作失败');
            }
        } else {
            $this->error('请选择需要操作的商品');
        }
    }

}