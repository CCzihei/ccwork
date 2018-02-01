<?php
namespace app\common\model;

class Article extends Base
{

    protected$_validate = array(
        // array('uid','require','用户id不能为空',0),
        array('uid','require','请填写用户id',0),
        array('title','require','标题不能为空',0),
        array('content','require','内容不能为空',0),
        array('categoryid','require','分类id不能为空',0),
    );

    protected $_auto = array (
//        array('uid','getId',3,'callback'),
//        array('path','getPath',3,'callback'), // 对name字段在新增和编辑的时候回调getName方法
    );
//    public function getId(){
//        rreturn $_SESSION['home']['userInfo']['id'];
//    }
}