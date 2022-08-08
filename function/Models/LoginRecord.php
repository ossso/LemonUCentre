<?php

namespace LemonUCentre\Models;

use Base;

/**
 * Lemon登录记录
 */
class LoginRecord extends Base
{
    public function __construct()
    {
        global $lemon_uc;

        parent::__construct($lemon_uc->table['LoginRecord'], $lemon_uc->tableInfo['LoginRecord'], __CLASS__);

        $this->CreateTime = time();
    }

    /**
     * @param $name
     * @return array|int|mixed|null|string
     */
    public function __set($name, $value)
    {
        switch($name) {
            case 'User':
            case 'TypeName':
                return;
            break;
            default:
                parent::__set($name, $value);
            break;
        }
    }

    /**
     * @param $name
     * @return array|int|mixed|null|string
     */
    public function __get($name)
    {
        global $zbp, $lemon_uc;

        switch($name) {
            /**
             * Lemon用户
             */
            case 'User':
                return $lemon_uc->getUserByID($this->LUID);
            /**
             * 登录类型
             */
            case 'TypeName': 
                {
                    switch ($this->Type) {
                        case 0:
                            return '账号密码';
                        case 10:
                            return '短信验证码';
                        case 11:
                            return '邮件验证码';
                        case 1000:
                            return 'QQ';
                        case 1001:
                            return '微信';
                        case 1002:
                            return '微博';
                        default:
                        case 999999:
                            return '其它';
                    }
                }
                break;
            default:
        }
        return parent::__get($name);
    }
}
