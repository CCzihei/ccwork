<?php
namespace Common\Service;
use Think\Model;

class Log extends Model
{

	public function AddLog(){

		$model = D('Common/Log');
		if($model ->create()){
			$res=$model->add();
			if($res){
				return array('flag'=>true,'msg'=>'日志操作成功');
			}else{
				$msg=$model->getError();
				return array('flag'=>false,'msg'=>$msg);
			}
		}else{
			$msg=$model->getError();
			return array('flag'=>false,'msg'=>$msg);
		}
	}
}