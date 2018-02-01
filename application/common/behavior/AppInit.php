<?php

namespace app\common\behavior;

use think\Config;

class AppInit
{
    public function run(&$param)
    {
        // վ���ʼ��
        $this->initialization();
        // ��������
        $this->config();
        // ϵͳ����
//        $this->setting();
    }


    private  function initialization ()
    {
        // ���峣��
        define('NOW_TIME', $_SERVER['REQUEST_TIME']);
        define('NOW_DATE', date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']));
        define('TABLE_PREFIX', Config::get('database.prefix'));

        // Ŀ¼
        define('RESOURCE_PATH', ROOT_PATH . 'static' . DIRECTORY_SEPARATOR);
        define('UPLOAD_PATH', ROOT_PATH . 'uploads' . DIRECTORY_SEPARATOR);
        // ��ԴURL����
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
                '��Ϣ����ѧԺ',
                '��Դ����ѧԺ',
                '��ѧ�봫ýѧԺ',
                '��������繤��ѧԺ',
                '��ѧ�����ѧԺ',
                '����ϵ',
                '����ϵ',
                '����ѧԺ',
                '���������ѧԺ',
                '������ѧѧԺ',
                '�����ѧԺ'
            ],
        ]);
    }
}