<?php
namespace app\admin\controller;

use app\common\controller\AdminBase;
use think\Cache;
use think\Db;

/**
 * 系统配置
 * Class System
 * @package app\admin\controller
 */
class System extends AdminBase
{
    public function _initialize()
    {
        parent::_initialize();
    }

    /**
     * 站点配置
     */
    public function siteConfig()
    {
        $site_config = Db::name('system')->field('value')->where('name', 'site_config')->find();
        $site_config = unserialize($site_config['value']);

        return $this->fetch('site_config', ['site_config' => $site_config]);
    }

    /**
     * 更新配置
     */
    public function updateSiteConfig()
    {
        if ($this->request->isPost()) {
            $site_config                = $this->request->post('site_config/a');
            // $site_config['site_tongji'] = htmlspecialchars_decode($site_config['site_tongji']);
            $data['value']              = serialize($site_config);
            if (Db::name('system')->where('name', 'site_config')->update($data) !== false) {
                $this->success('提交成功');
            } else {
                $this->error('提交失败');
            }
        }
    }

    /**
     * 清除缓存
     */
    public function clear()
    {
        if (delete_dir_file(CACHE_PATH) || delete_dir_file(TEMP_PATH)) {
            $this->success('清除缓存成功');
        } else {
            $this->error('清除缓存失败');
        }
    }

     /**
      * @Author   admin
      * @Email    无
      * @DateTime 2018-11-28
      * 公司信息配置
      */
    public function companyConfig()
    {
        $company_config = Db::name('system')->field('value')->where('name', 'company_config')->find();
        $company_config = unserialize($company_config['value']);

        return $this->fetch('company_config', ['company_config' => $company_config]);
    }

    /**
     * @Author   admin
     * @Email    无
     * @DateTime 2018-11-28
     * 更新公司信息配置
     */
    public function updatecompanyConfig()
    {
        if ($this->request->isPost()) {
            $company_config                = $this->request->post('company_config/a');
            if(empty($company_config['name'])){
                $this->error('请填写公司名称');
            }
            if(empty($company_config['logo'])){
                $this->error('请上传公司LOGO');
            }
            if(empty($company_config['tel'])){
                $this->error('请填写电话');
            }
            if(empty($company_config['weixin'])){
                $this->error('请填写微信号');
            }
            if(empty($company_config['address'])){
                $this->error('请填写公司地址');
            }
            if(empty($company_config['content'])){
                $this->error('请填写公司介绍');
            }
            if(empty($company_config['slogan'])){
                $this->error('请填写首页标语');
            }            
            $data['value']              = serialize($company_config);
            if (Db::name('system')->where('name', 'company_config')->update($data) !== false) {
                $this->success('提交成功');
            } else {
                $this->error('提交失败');
            }
        }
    }
}