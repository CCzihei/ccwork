<?php

namespace app\common\model;

class Log extends Base
{

	protected$_validate = array(
		// array('uid','require','用户id不能为空',0),
		array('error','require','请填写错误日志',0),
		array('class','require','类名不能为空',0),
		array('function','require','方法名不能为空',0),
		
		// array('phone','/^1([358]\d|47|70|77)\d{8}$/','手机号格式不正确',0,'regex',3),
	);

	protected $_auto = array (
		// array('status','1'), // 新增的时候把status字段设置为1
		// array('password','md5',3,'function') , // 对password字段在新增和编辑的时候使md5函数处理
		// array('name','getName',3,'callback'), // 对name字段在新增和编辑的时候回调getName方法
		array('create_time','time',1,'function'), // 对create_time字段在更新的时候写入当前时间戳
		array('uid','getUserId',1,'callback'),
	);

	protected function getUserId(){
		$info=session('home.userinfo');
		return $info['id'];
	}
}