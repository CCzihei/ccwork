<?php

namespace app\common\controller;
use think\Controller;
use think\Db;

class Admin extends Controller
{

	public $admin_info = null;
	public $sysinfo = null;

	public function _initialize ()
	{
		$this->admin_info = $this->checkLogin();
		$this->assign('sysinfo', $this->getSysInfo());
	}

    /**
	 * 判断是否登录
     */
	public function checkLogin ()
	{
		$admin = session('admin.admin_info');
		if(empty($admin)){
			$this->redirect(url('admin/login/login'));
		}
		return $admin;
	}
	/**
	 * 404
	 */
   	public function _empty ()
	{
		$this->error('404');
   	}

	/**
	 *
	 */
	private function getSysInfo()
	{
		if (!empty($this->sysinfo)) {
			return $this->sysinfo;
		}
		$condition = [
			'name' => ['in', ['logo', 'name']]
		];
		$sysinfo = Db::name('sysinfo')->where($condition)->column('value', 'name');
		$this->sysinfo = $sysinfo;
		return $sysinfo;
	}

	/**
	 * 保持管理员信息
	 */
	protected function setAdmin($admin)
	{
		$admin_info['id'] = $admin['admin_id'];
		$admin_info['name'] = $admin['name'];
		$admin_info['ip'] = getIp();
		$admin_info['date'] = NOW_DATE;
		$this->admin_info = $admin_info;

		session('admin.admin_info', $admin_info);
	}

	/**
	 * 获取菜单列表
	 */
	private function fetchMenuList()
	{
		$menu = [
			'user' => [
				'child' => [
					'user_list' => [ 'route' => '',
					]
				]
			],
		];
	}
}