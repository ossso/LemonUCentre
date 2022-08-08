<?php

namespace LemonUCentre\Services;

use Member;

/**
 * 账号管理
 */
class Account
{
    /**
     * 获取账号类型
     */
    static public function getType($account)
    {
        $account = trim($account);
        if (empty($account)) {
            return 0;
        }

        if (strlen($account) == 11 && $account * 1 == $account) {
            $pattern = "/^1\d{10}$/";
            preg_match($pattern, $account, $matches);
            if ($matches[0] == $account) {
                return 1;
            }
        } elseif (strpos($account, '@') > 0) {
            $pattern = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/";
            preg_match($pattern, $account, $matches);
            if ($matches[0] == $account) {
                return 2;
            }
        }

        return 3;
    }

    /**
     * 载入用户
     * 只返回，不接入系统
     * @param string $account 用户名
     * @return $user;
     */
    static public function loadUser($account)
    {
        $accountType = self::getType($account);

        $user = new Member();
        switch ($accountType) {
            case 1:
                $user = self::loadUserByPhone($account);
            break;
            case 2:
                $user = self::loadUserByEmail($account);
            break;
            case 3:
                $user = self::loadUserByName($account);
            break;
            default:
        }

        return $user;
    }

    /**
     * 根据手机号获取用户
     * @param string $phone 手机号码
     * @param boolean $isCheck 手机号码是否验证
     * @return $user;
     */
    static public function loadUserByPhone($phone, $isCheck = false)
    {
        global $lemon_uc;

        $w = array();
        $w[] = array('=', 'u_Phone', $phone);
        if ($isCheck) {
            $w[] = array('>', 'u_Phoned', 0);
        }
        $result = $lemon_uc->getUserList(array('*'), $w);
        if (count($result) > 0) {
            return $result[0]->User;
        }

        return new Member();
    }

    /**
     * 根据邮箱地址获取用户
     * @param string $email 邮箱地址
     * @param boolean $isCheck 邮箱地址是否验证
     * @return $user;
     */
    static public function loadUserByEmail($email, $isCheck = false)
    {
        global $lemon_uc;

        $w = array();
        $w[] = array('=', 'u_Email', $email);
        if ($isCheck) {
            $w[] = array('>', 'u_Emailed', 0);
        }
        $result = $lemon_uc->getUserList(array('*'), $w);
        if (count($result) > 0) {
            return $result[0]->User;
        }

        return new Member();
    }

    /**
     * 根据用户名获取用户
     * @param string $name 用户名
     * @return $user;
     */
    static public function loadUserByName($name)
    {
        global $zbp;

        $w = array();
        $w[] = array('=', 'mem_Name', $name);
        $w[] = array('=', 'mem_Status', 0);
        $result = $zbp->GetMemberList(array('*'), $w);
        if (count($result) > 0) {
            return $result[0];
        }

        return new Member();
    }
}
