<?php
/**
 * 站内信列表
 */

namespace LemonUCentre\Models;

use Base;
use LemonUCentre\Constants\Msg as MSG;

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
            default:
        }
        parent::__set($name, $value);
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
            case 'ToUser':
                return $lemon_uc->GetUserByID($this->ToUID);
            case 'Content':
                return $lemon_uc->GetMSGContentByID($this->ContID);
            case 'StatusName':
                return MSG\READ_STATUS[$this->Status];
        }
        return parent::__get($name);
    }
}
