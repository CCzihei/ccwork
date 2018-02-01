<?php
namespace app\admin\Controller;

use app\common\controller\Admin;
use think\Db;

class Index extends Admin {

    public function index() {
        $sysinfo = array(
            'os' => $_SERVER["SERVER_SOFTWARE"], //获取服务器标识的字串
            'version' => PHP_VERSION, //获取PHP服务器版本
            'time' => date("Y-m-d H:i:s", time()), //获取服务器时间
            'pc' => $_SERVER['SERVER_NAME'], //当前主机名
            'osname' => php_uname(), //获取系统类型及版本号
            'language' => $_SERVER['HTTP_ACCEPT_LANGUAGE'], //获取服务器语言
            'port' => $_SERVER['SERVER_PORT'], //获取服务器Web端口
            'max_upload' => ini_get("file_uploads") ? ini_get("upload_max_filesize") : "Disabled", //最大上传
            'max_ex_time' => ini_get("max_execution_time")."秒", //脚本最大执行时间
            'mysql_version' => '',
            'mysql_size' => '',
        );

        $this->assign('admin_info',$this->admin_info);
        $this->assign('sysinfo',$sysinfo);
    	$this->assign('title','后台主入口');
    	return $this->fetch();
    }


}