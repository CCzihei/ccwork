<?php
namespace app\Common\Service;

class User
{

	public function AddUser(){
		$model = D('User');
		$_POST['password'] = md5(I('post.password'));
		try {
			if($model->create()){
				$res = $model->add();
				return $res;
//				return true;
			}else{
				return $model->getError();
			}
		} catch (Exception $e) {
			return $model->getError();
		}
	}
	public function DeleteUserById($id){
		$model = M('User');
		try {
			$res = $model->where("id = $id")->delete();
			if($res){
				return true;
			}else{
				return $model->getError();
			}
		} catch (Exception $e) {
			return $model->getError();
		}
	}
	public function EditUser($params){
		if(!is_array($params)){
			$params = array();
		}
		$model = D('User');
		try {
			$username = isset($params['username'])?$params['username']:'';
			$id = isset($params['id'])?$params['id']:'';
			if(!empty($id)){
				$res = $model->where(" id = $id ")->save($params);
			}else{
				$res = $model->where(" username = '$username' ")->save($params);
			}

			if($res){
				return true;
			}else{
				return false;
			}
		} catch (Exception $e) {
			return $model->getError();
		}
	}
	public function GetUserByUserName($username){
		if(!isset($username)){
			$username='';
		}
		$model = M('user');
		$data= $model->where("username = '{$username}'")->find();
		return $data;
	}

	public function GetUserList($params){
		if(!is_array($params)){
			$params = array();
		}
		$page = isset($params['page'])? $params['page']:1;
		$step = isset( $params['step'])? $params['step']:5;
		$where = isset ($params['where']) ? $params['where'] : '';
		$model = M('user');
		$data = $model->where($where)->page($page.','.$step)->select();
		$count      = $model->where($where)->count();// 查询满足要求的总记录数
		$Page       = new \Think\Page($count,$step);// 实例化分页类 传入总记录数和每页显示的记录数
		$show       = $Page->show();// 分页显示输出
		$show = '<div id="page-php">'.substr($show, 5, -6).'</div>';

		$resArr['data']=$data;
		$resArr['page']=$show;
		return $resArr;
	}

	public function GetFieldByid($params){
		if(!is_array($params)){
			$params = array();
		}
		$field = isset($params['field'])? $params['field']:'id';
		$id = isset( $params['id'])? $params['id']:'';
		$model = M('user');
		$res=$model->field($field)->find($id);
		return $res;
	}
}