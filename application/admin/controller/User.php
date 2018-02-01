<?php
namespace Admin\Controller;

class User extends Admin {
    private $user = null;
    public function _initialize(){
        $this->user = D('User',"Service");
        $this->islogin();
    }
    public function index(){
        $p = I('get.p',1);
        $user= D('User','Service');
        $params['page'] = $p;
        $params['step'] = 10;
        $dataArr=$user->GetUserList($params);
        $page = $dataArr['page'];
        $data = $dataArr['data'];

        $this->assign('page',$page);// 赋值分页输出
    	$this->assign('title','用户管理');
        $this->assign('data',$data);
    	$this->display();
    }

    public function admin(){
        $p = I('get.p',1);
        $user= D('User','Service');
        $params['page'] = $p;
        $params['step'] = 10;
        $params['where'] = 'status > 1';
        $dataArr=$user->GetUserList($params);
        $page = $dataArr['page'];
        $data = $dataArr['data'];

        $this->assign('page',$page);// 赋值分页输出
        $this->assign('title','用户管理');
        $this->assign('data',$data);
        $this->display();
    }

    public function AddUser(){
        $this->assign('title','新增用户');
        if($_POST){
            $username = I('post.username');
            $email = I('post.email');
            $user=D("User","Service");
            $resUsername = $user->GetUserByUserName($username);
            if($resUsername){
                $popMSG['title'] = '错误';
                $popMSG['msg'] = '用户名已被使用';
                $this->assign('popMSG',$popMSG);
                $this->display();
                return ;
            }
            $res=$user->AddUser();
            if($res){
                $this->redirect('User/index');
            }else{
                $popMSG['title'] = '错误';
                $popMSG['msg'] = '新增用户出错';
                $this->assign('popMSG',$popMSG);
            }
        }
        $this->assign('department',$this->DEPARTMENTS);

        $this->display();
    }


    public function SetPass(){
        if($_POST){
            $mpass = I('post.mpass');
            $newpass = I('post.newpass');
            $renewpass = I('post.renewpass');
            if($newpass !== $renewpass){
                $this->error('密码不一致！');
            }
            $myinfo = session('admin.userInfo');

            $user=D("User","Service");
            $userinfo = $user->GetUserByUserName($myinfo['username']);
            if(md5($mpass) === $userinfo['password']){
                $params['password'] = md5($newpass);
                $params['username'] = $myinfo['username'];
                $user->EditUser($params);
                session('admin',null);
                $this->success('修改成功');
            }else{
                $this->error('原始密码不正确！');
            }
        }else{
            $userinfo = session('admin.userInfo');
            $this->assign('username',$userinfo['username']);
            $this->assign('title','修改密码');
            $this->display();
        }

    }

    public function EditUser(){
        if(IS_GET){
            $id = I('get.id');
            $user = D('User','Service');
            $params['id'] = $id;
            $params['field'] = 'id,username,sex,age,status,department';
            $data  = $user->GetFieldByid($params);
            $this->assign('data',$data);
            $this->assign('title','修改信息');
            $this->assign('department',$this->DEPARTMENTS);
            $this->display();
        }else{
            $this->error('操作错误！');
        }
    }

    public function DoEditUser(){
        if(IS_POST){
            $params['id'] = I('post.id');
            $params['username'] = I('post.username');
            $params['sex'] = I('post.sex');
            $params['age'] = I('post.age');
            $params['status'] = I('post.status');
            $params['department'] = I('post.department');
            $res  = $this->user->EditUser($params);
            if($res == true){
                $this->redirect('user/index');
            }else{
                $this->error("修改失败：$res");
            }
        }else{
            $this->error('操作错误！');
        }
    }
    public function ChangeStatus(){
        if(IS_GET){
            $status = I('get.status');
            if($status>1){
                $this->error('管理员不能添加黑名单');
            }elseif($status == 1){
                $params['status'] = 0;
            }
            elseif($status == 0){
                $params['status'] = 1;
            }
            $params['id'] = I('get.id');
            $res  = $this->user->EditUser($params);
            if($res == true){
                $this->redirect('user/index');
            }else{
                $this->error("修改失败：$res");
            }
        }else{
            $this->error('操作错误');
        }
    }
}