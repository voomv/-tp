<?php
namespace app\common\model;

use think\Model;

class Config extends Model{
    
    
    /**
     * 反转义HTML实体标签
     * @param $value
     * @return string
     */
    protected function setContentAttr($value)
    {
        return htmlspecialchars_decode($value);
    }
}
?>