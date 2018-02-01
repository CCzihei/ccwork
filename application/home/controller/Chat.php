<?php
namespace Home\Controller;
use app\common\Controller\Home;
use Think\Controller;

class Chat extends Home
{
   public function  index(){
       $this->islogin();
       $fid = I('get.fid');
       $user = D('User','Service');
       $params = array('id'=>$fid,'field'=>'id,username');
       $res = $user->GetFieldByid($params);
       $this->assign('friend',$res);
       $link = D('Link','Service');
       $links = $link->ShowLink();
       $this->assign('links',$links);
       $this->display();
   }
}