<?php
/**
 * Lemon 站内信列表
 */

namespace LemonUCentre\Models;

use Base;


class MSGList extends Base
{
    public function __construct()
    {
        global $zbp;
        parent::__construct($zbp->table['LemonUCentreMSGList'], $zbp->datainfo['LemonUCentreMSGList'], __CLASS__);

        $this->CreateTime = time();
    }

    /**
     * @param $name
     * @return array|int|mixed|null|string
     */
    public function __set($name, $value)
    {
        switch($name) {
            case 'FromUser':
            case 'ToUser':
            case 'Content':
            case 'StatusName':
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
            case 'FromUser':
                return $lemon_uc->GetUserByID($this->FromUID);
            break;
            case 'ToUser':
                return $lemon_uc->GetUserByID($this->ToUID);
            break;
            case 'Content':
                return $lemon_uc->GetMSGContentByID($this->ContID);
            break;
            case 'StatusName':
                if ($this->Status == 1) {
                    return '已读';
                }
                return '未读';
            break;
        }
        return parent::__get($name);
    }
}
