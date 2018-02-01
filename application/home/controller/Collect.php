<?php
namespace Home\Controller;
use Think\Controller;

class Collect extends Home
{
    private $collect = null;
    private $userinfo = null;
    public function _initialize(){
        $this->userinfo = session('home.userInfo');
        $this->collect = D('Collect','Service');
    }
   public function ajaxChangeCollect(){
       $status = I('get.status');
       $moodID = I('get.moodID');
       if($status == 1){
           $_POST['moodID'] = $moodID;
           $_POST['createtime'] = time();
           $_POST['display'] = 1;
           $_POST['uid'] = $this->userinfo['id'];
           $res = $this->collect->AddCollect();
           if($res == true){
               $this->ajaxReturn(1);
           }else{
               $this->ajaxReturn(0);
           }
       }else{
            $params['display'] = 0;
            $res = $this->collect->where('moodID = '.$moodID)->save($params);
           if($res){
               $this->ajaxReturn(1);
           }else{
               $this->ajaxReturn(0);
           }
       }
   }
}