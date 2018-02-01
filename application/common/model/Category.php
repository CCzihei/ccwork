<?php
namespace app\common\model;

class Category extends Base
{

    protected $_validate = array(
        // array('uid','require','用户id不能为空',0),
        array('pid','require','请填写父级id',0),
        array('name','require','分类名不能为空',0),
        array('path','require','路径不能为空',0),
    );

    protected $_auto = array (
//        array('display',1),
//        array('path','getPath',3,'callback'), // 对name字段在新增和编辑的时候回调getName方法
    );
}