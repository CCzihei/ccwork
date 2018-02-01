<?php
namespace Admin\Controller;

class Mood extends Admin {

    private $mood = null;
//    private $userinfo = null;
    public function _initialize(){
        $this->mood= D('Mood','Service');
        $this->islogin();
    }
    public function index(){
        $p = I('get.p',1);

        $params['page'] = $p;
        $params['step'] = 10;
//        $params['where'] = 'status = 1';
        $dataArr=$this->mood->GetMoodList($params);
        $page = $dataArr['page'];
        $data = $dataArr['data'];
        $user = D('User','Service');
        foreach($data as $k=>$v ){
            $param['id'] = $v['uid'];
            $param['field'] = 'username';
            $username = $user->GetFieldByid($param);
            $data[$k]['username'] = $username['username'];
        }
        $this->assign('page',$page);// 赋值分页输出
    	$this->assign('title','动态管理');
        $this->assign('data',$data);
    	$this->display();
    }

    public function AddMood(){
        $this->assign('title','新增用户');

        $this->display();
    }
    public function DeleteMood(){
        if(IS_GET){
            $id = I('get.id');
            $res = $this->mood->DeleteMoodById($id);
            if($res == true){
                $model = M();
                $model->table('favorite')->where('moodID = '.$id)->delete();
                $model->table('comment')->where('moodID = '.$id)->delete();
                $model->table('collect')->where('moodID = '.$id)->delete();
                $this->redirect('Mood/index');
            }else{
                $this->error("删除失败：".$res);
            }
            exit;
        }else{
            $this->error('操作错误！');
        }
    }

    public function ShowMood(){

        if(IS_GET){
            $id = I('get.moodid');
            $params['id'] = $id;
            $params['field'] = '*';
            $data = $this->mood->GetFieldByid($params);
            $user = D('User','Service');

            $param['id'] = $data['uid'];
            $param['field'] = 'username';
            $username = $user->GetFieldByid($param);
            $data['username'] = $username['username'];
            $this->assign('data',$data);
            $this->assign('title','动态评论');
            $this->display();

        }else{
            $this->error('操作错误');
        }
    }
}