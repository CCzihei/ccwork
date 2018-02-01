<?php
namespace Common\Service;
use Think\Model;

class Comment extends Model
{

    public function AddComment(){
        $model = D('Comment');
        $_POST['password'] = md5(I('post.password'));
        try {
            if($model->create()){
                $model->add();
                return true;
            }else{
                return $model->getError();
            }
        } catch (Exception $e) {
             return  $model->getError();
        }
    }
    public function DeleteCommentById($id){
        $model = M('Comment');
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
    public function EditComment($params){
        if(!is_array($params)){
            $params = array();
        }
        $model = D('Comment');
        try {

        } catch (Exception $e) {
            $model->getError();
        }
    }
    public function GetCommentList($params){
        if(!is_array($params)){
            $params = array();
        }
        $page = isset($params['page'])? $params['page']:1;
        $step = isset( $params['step'])? $params['step']:5;
        $where = isset ($params['where']) ? $params['where'] : '';
        $order = isset ($params['order']) ? $params['order'] : '';
        $model = M('Comment');
        $data = $model->where($where)->page($page.','.$step)->order($order)->select();
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
        $model = M('Comment');
        $res=$model->field($field)->find($id);
        return $res;
    }
}