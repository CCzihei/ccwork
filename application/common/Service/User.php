<?php
namespace app\common\service;

use app\common\model\User as UserModel;
class User
{

//	public function AddUser(){
//		$model = D('User');
//		$_POST['password'] = md5(I('post.password'));
//		try {
//			if($model->create()){
//				$res = $model->add();
//				return $res;
////				return true;
//			}else{
//				return $model->getError();
//			}
//		} catch (Exception $e) {
//			return $model->getError();
//		}
//	}
//	public function DeleteUserById($id){
//		$model = M('User');
//		try {
//			$res = $model->where("id = $id")->delete();
//			if($res){
//				return true;
//			}else{
//				return $model->getError();
//			}
//		} catch (Exception $e) {
//			return $model->getError();
//		}
//	}
//	public function EditUser($params){
//		if(!is_array($params)){
//			$params = array();
//		}
//		$model = D('User');
//		try {
//			$username = isset($params['username'])?$params['username']:'';
//			$id = isset($params['id'])?$params['id']:'';
//			if(!empty($id)){
//				$res = $model->where(" id = $id ")->save($params);
//			}else{
//				$res = $model->where(" username = '$username' ")->save($params);
//			}
//
//			if($res){
//				return true;
//			}else{
//				return false;
//			}
//		} catch (Exception $e) {
//			return $model->getError();
//		}
//	}
// 以上全部移到logic
	public function getUserByName($name){
		$model = new UserModel();
		$data = $model->where('name', $name)->find();
		return $data;
	}

	/**
	 * 获取用户列表
	 */
	public function getUserList($params, $field = '*'){
		if (empty($params) || !is_array($params)) {
			return [];
		}
		$page = !empty($params['page']) ? $params['page'] : 1;
		$limit = !empty($params['limit']) ? $params['limit'] : 20;
		$where = !empty($params['where']) ? $params['where'] : [];
		$model = new UserModel();
		if (!empty($params['where'])) {
			$model->where($where);
		}
		$user_list = $model->page($page)->limit($limit)->field($field)->select();

		return $user_list;
	}

	public function getFieldByid($params){
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