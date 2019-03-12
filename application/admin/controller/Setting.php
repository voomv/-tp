<?php

namespace app\admin\controller;

use app\common\model\Config as ConfigModel;
use app\common\controller\AdminBase;
use think\Db;

/**
 * 小程序配置
 * Class Setting
 * @package app\admin\controller
 */
class Setting extends AdminBase {

    protected $config_model;

    protected function _initialize() {
        parent::_initialize();
        $this->config_model = new ConfigModel();
    }

    /** 
     * @Author   admin
     * @Email    无
     * @DateTime 2018-11-22
     * 小程序配置
     */
    public function setting() {   
        if ($this->request->isPost()) {
            $config = $this->request->param("config/a");

            //验证数据值
            $validate_result = $this->validate($config, 'Setting');

            if ($validate_result !== true) {
                return $this->error($validate_result);
            }

            // 转化数据
            $data = [];
            foreach ($config as $k => $v) {
                $id = $this->config_model->where(['k'=>$k])->value("id");
                $data[] = ['id'=>$id,'v'=>$v];
            }

            if ($this->config_model->allowField(true)->saveAll($data)) {
                $this->setConfig();
                return $this->success('设置成功');
            } else {
                return $this->error('设置失败');
            }
        }else{
            //查询系统变量信息
            $where['k'] = ['in',"UserAppID,UserAppSecret,DistributionAppID,DistributionAppSecret,MchID,WxKey,ApiclientCert,ApiclientKey,SmsAppID,SmsAppKey,SmsTemplateId,SmsSign"];
            $config_list = $this->config_model->where($where)->select();
            if(!empty($config_list)){
                foreach($config_list as $k=>$v){
                    $v['desc'] = strtoupper($v['k']);
                    $config_list[$v['k']] = $v;
                }
            }

            return $this->fetch('setting', ['config_list' => $config_list]);
        }
    }
    
    /**
     * @Author   admin
     * @Email    无
     * @DateTime 2018-11-22
     * 生成配置文件
     */
    public function setConfig()
    {
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
                return json(['code'=>1,'msg'=>"生成配置文件成功!"]);
        } else {
                return json(['code'=>0,'msg'=>"生成配置文件失败!"]);
        }
    }
}