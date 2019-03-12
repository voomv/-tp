<?php
namespace app\index\controller;

use app\common\controller\HomeBase;
use think\Db;
use think\Session;

class Index extends HomeBase
{   
    protected $user_info = [];

    protected function _initialize()
    {
        parent::_initialize();
    }

    public function index()
    {
        return "1";
    }
}
