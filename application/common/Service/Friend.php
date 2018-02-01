<?php
namespace Common\Service;
use Think\Model;

class Friend extends Model
{

    public function AddFriend(){
        $model = D('Friend');
        try {
            if($model->create()){
                $res = $model->add();
                if($res){
                    return  array('flag'=>true,'content'=>$res);
                }else{
                    return  array('flag'=>false,'content'=>$res);
                }
            }else{
                return  array('flag'=>false,'content'=>$model->getError());
            }
        } catch (Exception $e) {
            return  array('flag'=>false,'content'=>$model->getError());
        }
    }

    public function DeleteFriendById($id){
        $model = M('Friend');
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

    public function GetFriendList($params){
        if(!is_array($params)){
            $params = array();
        }
        $page = isset($params['page'])? $params['page']:1;
        $step = isset( $params['step'])? $params['step']:5;
        $where = isset ($params['where']) ? $params['where'] : '';
        $order = isset ($params['order']) ? $params['order'] : '';
        $model = M('Friend');
        $data = $model->where($where)->page($page.','.$step)->order($order)->select();
        $count      = $model->where($where)->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,$step);// 实例化分页类 传入总记录数和每页显示的记录数
        $show       = $Page->show();// 分页显示输出
        $show = '<div id="page-php">'.substr($show, 5, -6).'</div>';

        $resArr['data']=$data;
        $resArr['page']=$show;
        return $resArr;
    }

    public function EditFriend($params){
        if(!is_array($params)){
            $params = array();
        }
        $uid = isset($params['uid'])?$params['uid']:'';
        $model = D('Friend');
        try {
            $res = $model->where("uid = '{$uid}'")->save($params);
            if($res){
                return true;
            }else{
                return false;
            }
        } catch (Exception $e) {
            $model->getError();
        }
    }
    public function EditFriendByid($params){
        if(!is_array($params)){
            $params = array();
        }
        $id = isset($params['id'])?$params['id']:'';
        $model = D('Friend');
        try {
            $res = $model->where("id = '{$id}'")->save($params);
            if($res){
                return true;
            }else{
                return false;
            }
        } catch (Exception $e) {
            $model->getError();
        }
    }

    public function GetFriendListdByUId($uid){
        $model = M('Friend');
        try {
            $res = $model->where("uid = $uid and status = 2  and fid<>$uid")->select();
            if($res){
                return array('flag'=>true,'content'=>$res);
            }else{
                return array('flag'=>false,'content'=>$model->getError());
            }
        } catch (Exception $e) {
            return array('flag'=>false,'content'=>$model->getError());
        }
    }
    public function GetFriendListdByFId($fid){
        $model = M('Friend');
        try {
            $res = $model->where("fid = $fid and status = 1")->select();
            if($res){
                return array('flag'=>true,'content'=>$res);
            }else{
                return array('flag'=>false,'content'=>$model->getError());
            }
        } catch (Exception $e) {
            return array('flag'=>false,'content'=>$model->getError());
        }
    }
}