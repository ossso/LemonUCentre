<?php

namespace LemonUCentre\Services;

use LemonUCentre\Models\LoginRecord;
use LemonUCentre\Utils\Validate;

class Sign
{
    /**
     * 登录方法
     * @param string $account 账号
     * @param string $password 密码
     * @param boolean $remember 记住登录
     * @param string $message 返回消息
     * @return $zbp.user;
     */
    public function in($account, $password, $remember, &$message = '')
    {
        global $zbp;

        $account = trim($account);
        $password = trim($password);

        $accountType = Account::getType($account);
        if ($accountType == 0) {
            $message = '账号信息不正确';
            return false;
        }

        $user = Account::loadUser($account);

        if ($user->ID == 0) {
            $message = '用户错误或密码错误';
            return false;
        }

        // 调用系统登录方法
        $_POST = array();
        $_POST['username'] = $user->Name;
        $_POST['password'] = $password;
        if ($remember) {
            $_POST['savedate'] = 7;
        }
        $status = \VerifyLogin(false);

        if ($status) {
            $savedate = $remember ? (7 * 24 * 60 * 60) : 0;
            self::record($zbp->user, 0, $savedate);
            $message = '登录成功';
            return true;
        }
        
        $message = '用户错误或密码错误';
        return false;
    }

    /**
     * 添加登录记录
     * @param object $user ZBP用户
     * @param number $type 登录类型
     * @param number $cookieTime cookie时长
     */
    public function record($user = null, $type = 0, $cookieTime = 0)
    {
        global $zbp, $lemon_uc;
    
        if (empty($user)) {
            $user = $zbp->user;
        }
        
        $IPAddress = \GetGuestIP();
        $isIPv4 = Validate::checkIPv4($IPAddress);

        $w = array();
        $w[] = array('=', 'lr_UID', $user->LemonUser->ID);
        $order = array('lr_CreateTime' => 'DESC');
        $loginCount = 0;
        $beforeRecord = $lemon_uc->getLoginRecordList(array('*'), $w, $order, array(1));
        if (count($beforeRecord) > 0) {
            $loginCount = $beforeRecord[0]->Count;
            $loginCount = (int) $loginCount > -1 ? (int) $loginCount : 0;
        }

        $record = new LoginRecord();
        $record->Type = $type;
        $record->UID = $user->LemonUser->ID;
        if ($isIPv4) {
            $record->IPv4 = $IPAddress;
        } else {
            $record->IPv6 = $IPAddress;
        }
        $record->Token = $user->LemonUser->getToken();
        $record->Count = $loginCount + 1;
        $record->Save();

        // 保存登录Token
        $user->LemonUser->Token = $record->Token;
        $user->LemonUser->Save();

        // 添加token到cookie
        $secure = HTTP_SCHEME == 'https://';
        setcookie('lemon-uc-token', $record->Token, $cookieTime, $zbp->cookiespath, '', $secure, true);
    }
}