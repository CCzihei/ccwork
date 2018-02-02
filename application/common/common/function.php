<?php

use think\captcha\Captcha;
use think\Config;
use think\Loader;

function page ($params)
{
	if(!is_array($params)){
		return false;
	}
	if(!isset($params['model'])){
		return false;
	}else{
		$model = $params['model'];
	}
	$step = isset($params['step'])?$params['step']:5;
	$where = isset($params['where'])?$params['where']:'';
	$count      = $model->where($where)->count();// 查询满足要求的总记录数
	$Page       = new \Think\Page($count,$step);// 实例化分页类 传入总记录数和每页显示的记录数
	$show       = $Page->show();// 分页显示输出
	$show = '<div id="page-php">'.substr($show, 5, -6).'</div>';
	return $show;
}


/* 获取当前url*/
function curPageURL ()
{
	$pageURL = 'http';

	if ($_SERVER["HTTPS"] == "on")
	{
		$pageURL .= "s";
	}
	$pageURL .= "://";

	if ($_SERVER["SERVER_PORT"] != "80")
	{
		$pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
	}
	else
	{
		$pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
	}
	return $pageURL;
}

function Upload ($pname)
{
	$upload = new \Think\Upload();// 实例化上传类
	$upload->maxSize   =     3145728 ;// 设置附件上传大小
	$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
	$upload->rootPath  =      './Uploads/'; // 设置附件上传根目录
	// 上传单个文件
	$info   =   $upload->uploadOne($_FILES[$pname]);
	if(!$info) {// 上传错误提示错误信息
		return array('flag'=>false,'content'=>$upload->getError());
	}else{// 上传成功 获取上传文件信息
		$res = $info['savepath'].$info['savename'];
		return array('flag'=>true,'content'=>$res);
	}
}

/**
 * 生成验证码
 */
function make_captcha($id = '')
{
	return captcha_src($id);
}

/**
 * 校验验证码
 */
function check_captcha($code, $id = '')
{
	$captcha = new Captcha();
	return $captcha->check($code, $id);
}

/**
 * 生成登录密码
 */
function make_password($password)
{
	$rd = '';
	// 密码字符集，可任意添加你需要的字符
	$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_ []{}<>~`+=,.;:/?|';
	for ( $i = 0; $i < 2; $i++ )
	{
		$rd .= $chars[ mt_rand(0, strlen($chars) - 1) ];
	}
	$password .= $rd;
	$password = md5($password) . '|' . $rd;
	return $password;
}

/**
 * 校验密码
 */
function check_password($check_password, $password)
{
	$password_array = explode('|', $password);
	$postfix = !empty($password_array[1]) ? $password_array[1] : '';
	$md5_password = $password_array[0];
	if (md5($check_password . $postfix) == $md5_password) {
		return true;
	}
	return false;
}

/**
 * 获取ip
 */
function getIp()
{
	$ip=false;
	if(!empty($_SERVER["HTTP_CLIENT_IP"])){
		$ip = $_SERVER["HTTP_CLIENT_IP"];
	}
	if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ips = explode (", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
		if ($ip) { array_unshift($ips, $ip); $ip = FALSE; }
		for ($i = 0; $i < count($ips); $i++) {
			if (!eregi ("^(10│172.16│192.168).", $ips[$i])) {
				$ip = $ips[$i];
				break;
			}
		}
	}
	return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
}

/**
 * 重写Url生成
 * @param string        $url 路由地址
 * @param string|array  $vars 变量
 * @param bool|string   $suffix 生成的URL后缀
 * @param bool|string   $domain 域名
 * @return string
 */
function url($url = '', $vars = '', $suffix = true, $domain = false)
{
	if (is_array($vars) && Config::get('url_common_param')) {
		foreach ($vars as &$var) {
			if (is_string($var) && $var != '') {
				$var = urlencode($var);
			}
		}
	}
	return \think\Url::build($url, $vars, $suffix, $domain);
}

/**
 * 实例化Service
 * @param string $name Service名称
 * @return object
 */
function service($name = '')
{
	return Loader::model($name, 'service');
}

/**
 * 实例化Logic
 * @param string $name Logic名称
 * @return object
 */
function logic($name = '')
{
	return Loader::model($name, 'logic');
}


