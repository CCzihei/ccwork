<?php
namespace Home\Controller;
use Think\Controller;

class Favorite extends Home
{
    private $favorite = null;
    private $userinfo = null;
    public function _initialize(){
        $this->userinfo = session('home.userInfo');
        $this->favorite = D('Favorite','Service');
    }
   public function ajaxChangeFavorite(){
       $status = I('get.status');
       $moodID = I('get.moodID');
       if($status == 1){
           $_POST['moodID'] = $moodID;
           $_POST['createtime'] = time();
           $_POST['display'] = 1;
           $_POST['uid'] = $this->userinfo['id'];
           $res = $this->favorite->AddFavorite();
           if($res == true){
               $this->ajaxReturn(1);
           }else{
               $this->ajaxReturn(0);
           }
       }else{
            $params['display'] = 0;
            $res = $this->favorite->where(' uid = '.$this->userinfo['id'].' moodID = '.$moodID)->save($params);
           if($res){
               $this->ajaxReturn(1);
           }else{
               $this->ajaxReturn(0);
           }
       }
   }

    public function DeleteFavorite(){
        if(IS_GET){
            $id = I('get.id');
            $params['display'] = 0;
            $res = $this->favorite->where('id = '.$id)->save($params);
            if(!$res){
                $this->error('操作错误');
            }else{
                $this->success('已取消赞');
            }
        }else{
            $this->error('操作错误');
        }
    }
}