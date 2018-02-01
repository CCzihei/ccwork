<?php


/**
 * ��дUrl����
 * @param string        $url ·�ɵ�ַ
 * @param string|array  $vars ����
 * @param bool|string   $suffix ���ɵ�URL��׺
 * @param bool|string   $domain ����
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