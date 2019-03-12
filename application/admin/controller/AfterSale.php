<?php
namespace app\admin\controller;

use app\common\model\AfterSale as AfterSaleModel;
use app\common\controller\AdminBase;

/**
 * 上门售后管理
 * Class AfterSale
 * @package app\admin\controller
 */
class AfterSale extends AdminBase
{
    protected $after_sale_model;
    protected function _initialize()
    {
        parent::_initialize();
        $this->after_sale_model = new AfterSaleModel(); // 上门售后表
    }

    /**
     * @Author   admin
     * @Email    无
     * @DateTime 2018-11-30
     * 售后列表
     */
    public function index($keyword = '', $page = 1)
    {
        $map   = [];

        if (!empty($keyword)) {
            $map['name|tel|address'] = ['like', "%{$keyword}%"];
        }

        $list  = $this->after_sale_model
                                ->where($map)
                                ->order(['create_time' => 'DESC'])
                                ->paginate(15, false, ['page' => $page]);

        return $this->fetch('index', ['list' => $list, 'keyword' => $keyword]);
    }

    /**
     * @Author   admin
     * @Email    无
     * @DateTime 2018-11-30
     * 删除售后
     */
    public function delete($id = 0, $ids = [])
    {
        $id = $ids ? $ids : $id;
        if ($id) {
            if ($this->after_sale_model->destroy($id)) {
                $this->success('删除成功');
            } else {
                $this->error('删除失败');
            }
        } else {
            $this->error('请选择需要删除的售后');
        }
    }
}