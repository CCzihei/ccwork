<?php
namespace Home\Controller;
use Think\Controller;

class Mood extends Home
{

    private $mood=null;

    public function _initialize(){
        $this->mood = D('Mood','Service');
    }
    public function AddMood(){
        if(IS_POST){
            $_POST['uid'] = $_SESSION['home']['userInfo']['id'];
            $_POST['createtime'] = time();
            $_POST['display'] = 1;
            $this->mood->AddMood();
            $this->redirect('Index/index');
        }else{
            $this->error('操作错误！');
        }

    }
    public function DeleteMood(){
        if(IS_GET){
            dump($_GET);
            $id = I('get.id');
            $res = $this->mood->DeleteMoodById($id);
            $model = M();
            if($res == true){
                $model->table('favorite')->where('moodID = '.$id)->delete();
                $model->table('comment')->where('moodID = '.$id)->delete();
                $model->table('collect')->where('moodID = '.$id)->delete();
                $this->redirect('Home/Center/Index/active/mymood');
            }else{
                $this->error($res);
            }
            exit;
        }else{
            $this->error('操作错误！');
        }
    }
}