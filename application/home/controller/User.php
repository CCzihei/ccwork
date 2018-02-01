<?php
namespace app\Home\Controller;
use app\common\Controller\Home;
use Think\Controller;

class User extends Home
{
	public function Login(){
		if(request()->isPost()){
			$name = input('post.username','');
			$password = input('post.password','');
			$identity = input('post.identity','');
			if($name!=''&& $password!=''){
				$info=service('user')->GetUserByUserName($name);
				$password=md5($password);
				if($password==$info['password']){
					if($identity != $info['identity']){
						$this->error('身份有误！');
					}else{
						$info['identity'] = $info['identity'] == 1 ? '学生' : '老师';
					}
					if($info['status']==0){
						$this->error('您已被限制登录！');
					}
					unset($info['password']);
					$user_info['id'] = $info['id'];
					session('home.userInfo',$info);
					$this->assign('title','主页');
					$this->redirect('/Home/Index');exit;
				}else{
					$this->error('密码不正确！');
				}
			}else{
				$this->error('用户名或密码不正确！');
			}
 		}
		$this->assign('title','欢迎登陆平台');
		return $this->fetch();
	}

	public function Register(){
		$this->assign('department',$this->DEPARTMENTS);
		$this->assign("title","注册");
		$this->fetch();
	}
	public function loginout(){
		session('home.userInfo',null);
		if(empty($_SESSION['home']['userInfo'])){
			$this->success('退出成功！',U("User/login"));
		}
	}
	public function Edit(){
		if(IS_POST){
			$this->user;
			$username = I('post.username');
			if(empty($username)){
				$userinfo = session('home.userInfo');
				$params['username'] = $userinfo['username'];
			}else{
				$params['username'] = $username;
			}
			if(!empty(I('post.sex'))){
				$params['sex'] = I('post.sex');
			}
			if(!empty(I('post.age'))){
				$params['age'] = I('post.age');
			}
			if(!empty(I('post.department'))){
				$params['department'] = I('post.department');
			}
			if(!empty(I('post.password'))){
				$oldpassword = I('post.oldpassword');
				$username = $this->userinfo['username'];
				$userinfo = $this->user->GetUserByUserName($username);
				if($userinfo['password'] != md5($oldpassword)){
					$this->error('原始密码不正确');
				}
				$repassword = I('post.repassword');

				$password = I('post.password');
				if($repassword != $password){
					$this->error('请确认密码');
				}
				$params['password'] = md5($password);
			}
			$params['id'] = $this->userinfo['id'];
			$res = $this->user->EditUser($params);
			if($res === true){
				$this->success('修改成功',U('Center/Index'));
			}elseif($res == false){
				$this->error('修改失败',U('Center/Index'));
			}else{
				$this->error($res);
			}
		}
	}

	public function DoRegister(){
		if($_POST){
			$username = I('post.username');
			$user= D('User','Service');
			$resUsername = $user->GetUserByUserName($username);
			if($resUsername){
				$this->redirect('register',array('msgTitle'=>'错误','msgContext'=> '用户名已被使用'));
				return ;
			}
			$res=$user->AddUser();
			if($res){
				$friend = D('Friend','Service');
				$_POST['uid'] = $res;
				$_POST['fid'] = $res;
				$_POST['status'] = 2;
				$_POST['createtime'] = time();
				$friend->AddFriend();
				$this->redirect('login');
			}else{
				$this->redirect('register',array('msgTitle'=>'错误','msgContext'=> '注册出错'));
			}
		}
	}


	public function ajaxGetUserList(){
		$userlist = json_decode($_GET['userlist']);
		foreach($userlist as $k => $v){
			$params = array('field'=>'id,username','id'=>$v);
			$user= D('User','Service');
			$res[] = $user->GetFieldByid($params);
		}
		$res = json_encode($res);
		$this->ajaxReturn($res);
	}
	public function ajaxGetUser(){
		$id = json_decode($_GET['id']);
		$params = array('field'=>'id,username','id'=>$id);
		$user= D('User','Service');
		$res = $user->GetFieldByid($params);
		if(!$res){
			$this->ajaxReturn(0);
		}
		$res = json_encode($res);
		$this->ajaxReturn($res);
	}

	public function EditIcon(){
		if(IS_POST){
			if($_FILES['icon']['name']){
				$res = Upload('icon');
			}
			if($res['flag']!=true){
				$this->error('上传失败:'.$res['content']);
			}
			$params['id'] = $this->userinfo['id'];
			$params['icon'] = $res['content'];

			$r = $this->user->EditUser($params);
			if($r!=true){
				$this->error('操作错误');
			}else{
				$id = $this->userinfo['id'];
				$params['id'] = $id;
				$params['field'] = 'id,username,icon,sex,age,status';
				$res = $this->user->GetFieldByid($params);
				session('home.userInfo',$res);
				$this->redirect('Center/Index',array('active'=>'icon'));
			}
		}else{
			$this->error('操作错误');
		}
	}
}