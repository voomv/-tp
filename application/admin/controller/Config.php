<?php

namespace app\admin\controller;

use app\common\model\Config as ConfigModel;
use app\common\controller\AdminBase;
use think\Db;

/**
 * 自定义系统变量
 * *
 */
class Config extends AdminBase {

    protected $config_model;

    protected function _initialize() {
        parent::_initialize();
        $this->config_model = new ConfigModel();
    }

    /** 
     * 系统变量列表
     */
    public function index($keyword = '',$page = 1) {
        //判断搜索值
        $map = [];
        if($keyword){
            $map['name|k|v'] = ['LIKE',"%$keyword%"]; 
        }
        
        //查询系统变量信息
        $config_list = $this->config_model->where($map)->paginate(15, false, ['page' => $page]);
        if(!empty($config_list)){
            foreach($config_list as $k=>$v){
                $config_list[$k]['desc'] = strtoupper($v['k']);
            }
        }

        return $this->fetch('index', ['config_list' => $config_list,'keyword' => $keyword]);
    }

    /**
     * 添加系统自定义变量
     */
    public function add() {
        return $this->fetch();
    }

    /**
     * 执行添加系统自定义变量 
     */
    public function save($k) {

        if ($this->request->isPost()) {
            $data = $this->request->post();

            //验证数据值
            $validate_result = $this->validate($data, 'Config');

            if ($validate_result !== true) {
                return $this->error($validate_result);
            }

            //执行插入
            if ($this->config_model->allowField(true)->save($data)) {
                return $this->success('添加成功', 'index');
            } else {
                return $this->error('添加失败');
            }
        }
    }

    /**
     * 修改系统自定义变量
     */
    public function edit($id) {

        $id = intval($id);

        $config = $this->config_model->find($id);

        if (!$config) {
            return $this->error('非法操作');
        }

        return $this->fetch('edit', ['config' => $config]);
    }

    /**
     * 执行修改系统自定义变量
     */
    public function update($id) {
        $id = intval($id);

        $config = $this->config_model->find($id);

        if (!$config) {
            return $this->error('非法操作');
        }
        
        $data = $this->request->post();
        //验证数据值
        $validate_result = $this->validate($data, 'Config');
        
        if($validate_result !== true){
            return $this->error($validate_result);
        }
        
        if($this->config_model->allowField(true)->save($data,$id) !== false){
            return $this->success('修改成功', 'index');
        }else{
            return $this->error('修改失败');
        }
        
    }
    
    /**
     * 删除系统自定义变量
     */
    public function delete($id){
        $id = intval($id);
        
        $config = $this->config_model->find($id);
        
        if(!$config){
            return $this->error('非法操作');
        }

        //执行删除
        if($this->config_model->destroy($id) !== false){
            return $this->success('删除成功');
        }else{
            return $this->error('删除失败');
        }
    }
    
    /**
    * [setConfig 生成自定义变量配置文件]
    */
    public function setConfig()
    {
       if(request()->isAjax()){
            $data = $this->config_model->select();

            $str = "<?php\n\r";
            $str .= "/*\n\r";
            $str .= "* Author: [ Copy Lian ]\n\r";
            $str .= "* Date: [ ".date("Y.m.d")." ]\n\r";
            $str .= "* Description [ 自定义变量 ]\n\r";
            $str .= "*/\n\r\n\r";
            $str .= "return array(\n\r";
            //写入数据
            if(!empty($data)){
                 foreach ($data as $key => $value) {
                    $str .= "\t\t" . "'CUSTOM_".strtoupper($value['k'])."' => '" . $value['v'] . "',\n\r";
                }
            }

            $str .= ");\n\r?>";
            if( ! is_dir(APP_PATH . 'extra')){
                mkdir(APP_PATH . 'extra',0777);
            }
            $ok = file_put_contents(APP_PATH . 'extra/custom.php', $str);
            if($ok){
                    return json(array('msg'=>'生成配置文件成功!','code'=>1,'url'=>url('admin/config/index')));
            } else {
                    return json(array('msg'=>'生成配置文件失败!','code'=>0));
            }
        }

    }
}