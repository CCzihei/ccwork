<?php
namespace Home\Controller;
use Think\Controller;

class Comment extends Home
{
    private $comment = null;
    private $userinfo = null;
    public function _initialize(){
        $this->userinfo = session('home.userInfo');
        $this->comment = D('Comment','Service');
    }
    public function AddComment(){
        if(IS_POST){
            $content = I('post.content');
            if(empty($content)){
                $this->redirect('Index/Index');
            }
            $_POST['createtime'] = time();
            $_POST['uid'] = $this->userinfo['id'];
            $res = $this->comment->AddComment();
            if($res == true){
                $this->redirect('Index/Index');
            }else{
                $this->error($res);
            }
        }else{
            $this->error('操作错误');
        }
    }
}