<?php
/**
 * 积分记录
 * 单个用户的积分记录
 */

namespace LemonUCentre\Models;

use Base;

class PointRecord extends Base
{
    public function __construct()
    {
        global $zbp;
        parent::__construct($zbp->table['LemonUCentrePointRecord'], $zbp->datainfo['LemonUCentrePointRecord'], __CLASS__);

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
            case 'Cate':
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
            case 'User':
                return $lemon_uc->GetUserByID($this->UID);
            break;
            case 'Cate': {
                return $lemon_uc->GetPointCateByID($this->CateID);
            }
            break;
        }
        return parent::__get($name);
    }
}
