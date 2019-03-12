<?php
namespace app\admin\controller;

use app\common\model\Comment as CommentModel;
use app\common\model\Mall as MallModel;
use app\common\model\User as UserModel;
use app\common\controller\AdminBase;
use think\Db;

/**
 * 评论管理
 * Class Commen
 * @package app\admin\controller
 */
class Comment extends AdminBase
{
    protected $comment_model;
    protected $mall_model;
    protected $user_model;

    protected function _initialize()
    {
        parent::_initialize();
        $this->comment_model = new CommentModel();//评论表
        $this->mall_model = new MallModel();//商品表
        $this->user_model = new UserModel();//用户信息表
    }

    /**
     * @Author   admin
     * @Email    无
     * @DateTime 2018-11-30
     * 商品评论列表
     */
    public function index($keyword = '', $page = 1)
    {       
        $map   = [];
        if (!empty($keyword)) {
            $map['c.content|u.username|m.name'] = ['like', "%{$keyword}%"];
        }

        $comment_list  = $this->comment_model
                                ->alias('c')
                                ->where($map)
                                ->join('dp_user u','c.uid = u.id','LEFT')
                                ->join('dp_mall m','c.mid = m.goods_id','LEFT')
                                ->field('c.*,u.username,m.name')
                                ->order(['c.add_time' => 'DESC'])
                                ->paginate(15, false, ['page' => $page]);

        return $this->fetch('index', ['comment_list' => $comment_list, 'keyword' => $keyword]);
    }

    /**
     * @Author   admin
     * @Email    无
     * @DateTime 2018-11-30
     * 评论删除
     */
    public function delete($id = 0, $ids = [])
    {
        $id = $ids ? $ids : $id;
        if ($id) {
            if ($this->comment_model->destroy($id)) {
                $this->success('删除成功');
            } else {
                $this->error('删除失败');
            }
        } else {
            $this->error('请选择需要删除的评论');
        }
    }
}