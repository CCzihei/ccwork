<?php


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