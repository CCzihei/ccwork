<?php
namespace Admin\Controller;

class Comment extends Admin
{

    private $comment = null;
    public function _initialize ()
    {
        $this->comment= D('Comment','Service');
        $this->islogin();
    }
    public function index ()
    {
        $p = I('get.p',1);

        $params['page'] = $p;
        $params['step'] = 10;
//        $params['where'] = 'status = 1';
        $dataArr=$this->comment->GetCommentList($params);
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

    public function ShowComment ()
    {
        $p = I('get.p',1);
        $moodid = I('get.moodID');
        $params['page'] = $p;
        $params['step'] = 10;
        $params['where'] = 'moodID = '.$moodid;
        $dataArr=$this->comment->GetCommentList($params);
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
        $this->assign('title','评论管理');
        $this->assign('data',$data);
        $this->display();
    }

    public function DeleteComment ()
    {
        if(IS_GET){
            dump($_GET);
            $id = I('get.id');
            $res = $this->comment->DeleteCommentById($id);
            if($res == true){
                $this->redirect('Comment/index');
            }else{
                $this->error("删除失败：".$res);
            }
            exit;
        }else{
            $this->error('操作错误！');
        }
    }
}