<?php
/**
 * Lemon 验证码发送记录
 */

namespace LemonUCentre\Models;

use Base;


class VerifyCode extends Base
{
    public function __construct()
    {
        global $zbp;
        parent::__construct($zbp->table['LemonUCentreVerifyCode'], $zbp->datainfo['LemonUCentreVerifyCode'], __CLASS__);

        $this->CreateTime = time();
    }

    /**
     * @param $name
     * @return array|int|mixed|null|string
     */
    public function __set($name, $value)
    {
        switch ($name) {
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
        switch ($name) {
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
