<?php
/**
 * Lemon会员记录
 */

namespace LemonUCentre\Models;

use Base;


class VIPRecord extends Base
{
    public function __construct()
    {
        global $zbp;
        parent::__construct($zbp->table['LemonUCentreVIPRecord'], $zbp->datainfo['LemonUCentreVIPRecord'], __CLASS__);

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
            case 'ChannelName':
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
                return $lemon_uc->GetUserByID($this->LUID);
            break;
            case 'ChannelName': {
                switch ($this->Channel) {
                    default:
                    case 0:
                        return '系统赠予';
                    case 1:
                        return '兑换码';
                    case 2:
                        return $lemon_uc->PointsName;
                }
            }
            break;
        }
        return parent::__get($name);
    }
}
