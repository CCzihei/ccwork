<?php
namespace app\common\controller;
use think\Controller;

class Home extends Controller
{
	public  $uerinfo = null;

	private function __initialize()
	{
		$this->getUserInfo();
		$this->islogin();
	}
	public function islogin(){
		$userinfo = session('home.userInfo');
		if(empty($userinfo)){
			$this->redirect("User/Login");
		}
	}

	public function getUserInfo ()
	{
		$userinfo = session('home.userInfo');
		$this->uerinfo = null;
		if (isset($userinfo['id'])) {
			$this->user_info = Db::name('user')->field('')->find($userinfo['id']);
		} else {
			$this->user_info = null;
		}

	}

	public function  _empty(){
		$this->error('404');
	}
}