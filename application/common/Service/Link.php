<?php
namespace Common\Service;
use Think\Model;

class Link extends Model
{
    public function AddLink(){
        $model = D('Link');
        try {
            if($model->create()){
                $model->add();
                return array('flag'=>true,'msg'=>'添加成功');
            }else{
                return array('flag'=>false,'msg'=> $model->getError());
            }
        } catch (Exception $e) {
            return array('flag'=>false,'msg'=> $model->getError());
        }

    }

    public function EditLink(){
        $model = D('Link');
        $id = isset($_POST['id'])?$_POST['id']:'';
        try {
            if($model->create()){
                $model->where('id = '.$id)->save();
                return true;
            }else{
                return $model->getError();
            }
        } catch (Exception $e) {
            $model->getError();
        }
        return false;
    }

    public function DeleteLinkById($id){
        $model = M('Link');
        $res = $model->delete($id);
        if($res){
            return true;
        }
        return false;
    }

    public function GetLinkList($params){
        if(!is_array($params)){
            $params = array();
        }
        $page = isset($params['page'])? $params['page']:1;
        $step = isset( $params['step'])? $params['step']:5;
        $where = isset ($params['where']) ? $params['where'] : '';
        $model = M('Link');
        $data = $model->where($where)->page($page.','.$step)->select();
        $params['where'] = $where;
        $params['step'] = $step;
        $params['model'] = $model;
        $show = page($params);
        $resArr['data']=$data;
        $resArr['page']=$show;
        return $resArr;
    }


    public function GetLinkById($id){
        $id = isset($id)?$id : null;
        $model = M('Link');
        $data = $model->find($id);
        return $data;
    }

    public function ShowLink(){
        $model = M('Link');
        $data = $model->where("display = 1")->select();
        return $data;
    }
}