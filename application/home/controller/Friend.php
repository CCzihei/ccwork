<?php
namespace Home\Controller;
use Think\Controller;

class Friend extends Home
{
    private $friend = null;
    private $userinfo = null;
    public function _initialize(){
        $this->friend = D('Friend','Service');
        $this->userinfo = session('home.userInfo');
    }

    public function ajaxAddFriend(){
        $userinfo = session('home.userInfo');
        if($_GET){
            $fid = I('get.fid');
        }elseif($_POST){
            $fid = I('post.fid');
        }
        if(empty($fid)) $this->ajaxReturn(0);
        if($fid==$userinfo['id'] ) $this->ajaxReturn(3);
        $friend= D('Friend','Service');
        $check = $friend->where('uid='.$userinfo['id'].' and fid='.$fid)->find();
        if($check){
            $this->ajaxReturn(2);
        }
        $_POST['uid'] = $userinfo['id'];
        $_POST['fid'] = $fid;
        $_POST['createtime'] = time();
        $_POST['status'] = 1; //1 为申请中
        $friend= D('Friend','Service');
        $res = $friend->AddFriend();
        if(!$res['flag']){
            $this->ajaxReturn($res['content']);
        }
        $this->ajaxReturn(1);
    }

    public  function GetFriendList(){
        $userinfo = session('home.userInfo');
        $friend= D('Friend','Service');
        $res = $friend->GetFriendListdByUId($userinfo['id']);
    }


    public  function ajaxGetFriendList(){
        $userlist = json_decode($_GET['userlist'],true);
        $userinfo = session('home.userInfo');
        $friend= D('Friend','Service');
        $res = $friend->GetFriendListdByUId($userinfo['id']);
        if(!$res['flag']){
            $this->ajaxReturn(0);
        }
        $user = D('User','Service');
        foreach($res['content'] as $k=>$v ){
            if(in_array($v['fid'],$userlist)){
                $params['field'] = 'id,username';
                $params['id'] = $v['fid'];
                $r = $user->GetFieldByid($params);
                if($r){
                    $friendlist[] = $r;
                }
            }
        }
        $friendlist = json_encode($friendlist);
        $this->ajaxReturn($friendlist);
    }

    public function AddFriend(){
        if(IS_GET){
            $id = I('get.id');
            $fid = I('get.fid');
            $pramas['id'] = $id;
            $pramas['status'] = 2;
            $pramas['createtime'] = time();
            $res = $this->friend->EditFriendById($pramas);
            if($res == true){
                $userinfo = session('home.userInfo');
                $prama['uid'] = $userinfo['id'];
                $prama['fid'] = $fid;
                $prama['status'] = 2;
                $result = $this->friend->add($prama);
                if(!$result){
                    $this->error('操作失败');
                }else{
                    $this->redirect('Center/Index',array('active'=>'addfriend'));
                }

            }else{
                $this->error('操作错误！');
            }
        }else{
            $this->error('操作错误！');
        }
    }

    public function ajaxDeleteFriend(){
        if(IS_GET){
            $fid = I('get.fid');
            $uid = $this->userinfo['id'];
            $pramas['status'] = 0;
            $res1 = $this->friend->where("uid = $uid and fid = $fid")->delete();
            $res2 = $this->friend->where("uid = $fid and fid = $uid")->delete();
            if($res1 != 0 && $res2 != 0){
                $this->ajaxReturn(1);
            }else{

                $this->ajaxReturn(0);
            }
        }else{
            $this->ajaxReturn(0);
        }
    }

    public function DeleteFriend(){
        if(IS_GET){
            $fid = I('get.fid');
            $uid = $this->userinfo['id'];
            $pramas['status'] = 0;
            $res1 = $this->friend->where("uid = $uid and fid = $fid")->delete();
            $res2 = $this->friend->where("uid = $fid and fid = $uid")->delete();
            if($res1 != 0 && $res2 != 0){
                $this->redirect('Center/Index',array('active'=>'friendlist'));
            }else{
                $this->error('操作失败！');
            }
        }else{
            $this->error('操作错误！');
        }
    }

    public function RefuseFriend(){
        if(IS_GET){
            $id = I('get.id');
            $res = $this->friend->DeleteFriendById($id);
            if($res == true){
                $this->redirect('Center/Index',array('active'=>'addfriend'));
            }else{
                $this->error('操作错误！');
            }
        }else{
            $this->error('操作错误！');
        }
    }
}