<?php
namespace app\common\model;

use think\db\Query;

/**
 * Class Base
 * @package app\common\model
 * @method static Query field($field, $except = false, $tableName = '', $prefix = '', $alias = '') 指定查询字段
 * @method static Query with($with) 关联预载入
 * @method static Query lock($lock = false) 指定查询lock
 */
class Base extends \think\Model
{
    protected $autoWriteTimestamp = true;
    // 创建时间字段
    protected $createTime = 'createtime';
    // 更新时间字段
//    protected $updateTime = 'gmt_modified';
    // 字段类型或者格式转换
    protected $type = [
        'createtime' => 'datetime',
//        'gmt_modified' => 'datetime',
    ];
}