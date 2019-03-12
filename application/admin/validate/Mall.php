<?php
namespace app\admin\validate;

use think\Validate;

/**
 * 商品添加验证
 * Class Mall
 * @package app\admin\validate
 */
class Mall extends Validate
{
    protected $rule = [
        'name' => 'require',
        'price' => 'require',
        'warrantyone'   => 'require',
        'warrantytwo'   => 'require',
        'photo' =>	'require',
        'banner' =>	'require',
        'details' => 'require',
        'admit' => 'require',
        'stock' => 'require'
    ];

    protected $message = [
        'name.require' => '请输入商品名称',
        'price.require' => '请输入价格',
        'warrantyone.require'   => '请输入延保的价格',
        'warrantytwo.require'   => '请输入延保的价格',
        'photo.require'   => '请上传封面图',
        'banner.require'   => '请上传商品图',
		'details.require' => '请输入商品详情',
		'admit.require' => '请输入承诺',
		'stock.require' => '请输入库存'
    ];
}