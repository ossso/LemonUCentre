<?php
/**
 * 用户签到日志
 */

namespace LemonUCentre\Models;

use Base;


class CheckInLogs extends Base
{
    public function __construct()
    {
        global $zbp;
        parent::__construct($zbp->table['LemonUCentreCheckInLogs'], $zbp->datainfo['LemonUCentreCheckInLogs'], __CLASS__);
    }

    /**
     * @param $name
     * @return array|int|mixed|null|string
     */
    public function __set($name, $value)
    {
        switch($name) {
            case 'User':
                return;
            break;
            default:
                parent::__set($name, $value);
            break;
        }
    }

    /**
     * @param $name
     * 
     * @return array|int|mixed|null|string
     */
    public function __get($name)
    {
        global $zbp, $lemon_uc;
        switch($name) {
            case 'User':
                return $lemon_uc->GetUserByID($this->UID);
            break;
        }
        return parent::__get($name);
    }
    
    /**
     * @param string $s
     *
     * @return bool|string
     */
    public function Date($s = 'Y-m-d H:i:s')
    {
        return date($s, (int) $this->CreateTime);
    }
}
