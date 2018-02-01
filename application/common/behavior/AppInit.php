<?php

namespace app\common\behavior;

use think\Config;

class AppInit
{
    public function run(&$param)
    {
        // 站点初始化
        $this->initialization();
        // 补充配置
        $this->config();
        // 系统配置
//        $this->setting();
    }


    private  function initialization ()
    {
        // 定义常量
        define('NOW_TIME', $_SERVER['REQUEST_TIME']);
        define('NOW_DATE', date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']));
        define('TABLE_PREFIX', Config::get('database.prefix'));

        // 目录
        define('RESOURCE_PATH', ROOT_PATH . 'static' . DIRECTORY_SEPARATOR);
        define('UPLOAD_PATH', ROOT_PATH . 'uploads' . DIRECTORY_SEPARATOR);
        // 资源URL配置
        define('PUBLIC_URL', '/public/static/');
        define('ADMIN_URL', '/public/static/Admin');
        define('HOME_URL', '/public/static/Home');
        define('CHAT_URL', '/public/static/Chat');
        define('IMAGE_URL', PUBLIC_URL . 'images/');
        define('CSS_URL', PUBLIC_URL . 'css/');
        define('JS_URL', PUBLIC_URL . 'js/');
        define('UPLOAD_URL', 'http://' . config('image_domain') . '/');
    }

    private function config ()
    {
        Config::set([
            'department_list' => [
                '信息工程学院',
                '资源工程学院',
                '文学与传媒学院',
                '物理与机电工程学院',
                '化学与材料学院',
                '艺术系',
                '体育系',
                '奇迈学院',
                '经济与管理学院',
                '教育科学学院',
                '外国语学院'
            ],
        ]);
    }
}