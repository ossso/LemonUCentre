<?php
/**
 * Lemon 验证码发送记录
 */

namespace LemonUCentre\Models;

use Base;


class Captcha extends Base
{
    public function __construct()
    {
        global $zbp;
        parent::__construct($zbp->table['LemonUCentreCaptcha'], $zbp->datainfo['LemonUCentreCaptcha'], __CLASS__);

        $this->CreateTime = time();
    }

    /**
     * @param $name
     * @return array|int|mixed|null|string
     */
    public function __set($name, $value)
    {
        switch ($name) {
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
        global $lemon_uc;
        switch ($name) {
            case 'User':
                return $lemon_uc->GetUserByID($this->UID);
            case 'TypeName': {
                switch ($this->Type) {
                    case 1:
                        return 'Email';
                    default:
                    case 0:
                        return '手机号码';
                }
            }
            break;
        }
        return parent::__get($name);
    }

}
