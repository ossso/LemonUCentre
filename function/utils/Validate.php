<?php

namespace LemonUCentre\Utils;

class Validate
{

    /**
     * 确认是否为邮箱
     *
     * @param string $email 邮箱地址
     *
     * @return boolean
     */
    public function checkEmail($email = '')
    {
        if (strripos($email, '@') > 0) {
            $pattern = "/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/";
            $matches = array();
            preg_match($pattern, $email, $matches);
            return count($matches) > 0 && $matches[0] == $email;
        }
        return false;
    }

    /**
     * 确认是否为手机号码
     *
     * @param string $phone 手机号码
     *
     * @return boolean
     */
    public function checkPhone($phone = '')
    {
        if (strlen($phone) == 11 && $phone * 1 == $phone) {
            $pattern = "/^1\d{10}$/";
            $matches = array();
            preg_match($pattern, $phone, $matches);
            return count($matches) > 0 && $matches[0] == $phone;
        }
        return false;
    }

    /**
     * 确认是否为IPv4
     *
     * @param string $ipv4 IP地址
     *
     * @return boolean
     */
    public function checkIPv4($ipv4 = '')
    {
        if (strripos($ipv4, '.') > 0) {
            $pattern = "/(?=(\b|\D))(((\d{1,2})|(1\d{1,2})|(2[0-4]\d)|(25[0-5]))\.){3}((\d{1,2})|(1\d{1,2})|(2[0-4]\d)|(25[0-5]))(?=(\b|\D))/";
            $matches = array();
            preg_match($pattern, $ipv4, $matches);
            return count($matches) > 0 && $matches[0] == $ipv4;
        }
        return false;
    }

}
