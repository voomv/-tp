<?php
namespace app\admin\validate;

use think\Validate;

class Config extends Validate
{
    protected $rule = [
        'k'                => 'require|unique:config',
        'v'                => 'require',
        'name'             => 'require',
    ];

    protected $message = [
        'k.require'                => '请输入变量名',
        'k.unique'                 => '变量名已存在',
        'v.require'                => '请输入变量值',
        'name'                     => '请输入变量说明',
    ];
}