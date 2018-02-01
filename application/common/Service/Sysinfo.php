<?php
namespace Common\Service;
use Think\Model;

class Sysinfo extends Model
{
    public function AddSysinfo(){
        $model = D('Sysinfo');
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

    public function EditSysinfo(){
        $model = D('Sysinfo');
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

    public function DeleteSysinfoById($id){
        $model = M('Sysinfo');
        $res = $model->delete($id);
        if($res){
            return true;
        }
        return false;
    }

    public function GetSysinfoList($params){
        if(!is_array($params)){
            $params = array();
        }
        $page = isset($params['page'])? $params['page']:1;
        $step = isset( $params['step'])? $params['step']:5;
        $where = isset ($params['where']) ? $params['where'] : '';
        $model = M('Sysinfo');
        $data = $model->where($where)->page($page.','.$step)->select();
        $params['where'] = $where;
        $params['step'] = $step;
        $params['model'] = $model;
        $show = page($params);
        $resArr['data']=$data;
        $resArr['page']=$show;
        return $resArr;
    }


    public function GetSysinfoById($id){
        $id = isset($id)?$id : null;
        $model = M('Sysinfo');
        $data = $model->find($id);
        return $data;
    }
}