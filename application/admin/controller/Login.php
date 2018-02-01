<?php
namespace app\admin\controller;
use app\common\Controller\Admin;
use think\Db;

class Login extends Admin
{
	public function _initialize ()
	{
		$admin = session('admin.admin_info');
		if (!empty($admin)) {
			$this->redirect(url('admin/index/index'));
		}
	}

	/**
	 * 登录
	 */
	public function login()
	{
		$this->assign('check_code', !empty(input('get.check_code') ? input('get.check_code') : 0));
		$this->assign('title', '后台登录');
		return $this->fetch();
	}

	/**
	 * 执行登录
	 */
	public function doLogin()
	{
		if (request()->isPost()) {
			$username = input('post.username');
			$password = input('post.password');
			$check_code = input('post.check_code');

			if (!empty($check_code)) {
				$code = input('post.code');
				if(!check_captcha($code, 'admin_login')){
					$this->result(null, 0, '验证码不正确');
				}
			}

			$admin = Db::name('admin')->where("name", $username)->find();
			if (empty($admin)) {
				$this->result(null, 0, '账号不存在！');
			}

			if(check_password($password, $admin['password'])){
				$this->setAdmin($admin);
				$this->result(null, 1);
				return $this->redirect(url('admin/index/index'));
			}else{
				$this->result(null, 1, '账号不存在或密码不正确!');
			}
		}
	}

	public function loginOut()
	{
		session('admin_info',null);
		$this->success('退出成功');

	}
	/**
	 * 验证码
	 * @return [source]
	 */
	public function code()
	{

	}

	//检查验证码
	public function checkCode()
	{
		$code = I('get.code');
		$Verify = new Verify();
		if(!$Verify->check($code)){
			$this->ajaxReturn(0);
		}else{
			$this->ajaxReturn(1);
		}
	}
}