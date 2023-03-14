<?php
/**
 * Lemon会员记录
 */

namespace LemonUCentre\Models;

use Base;


class VIPCate extends Base
{
    public function __construct()
    {
        global $zbp;
        parent::__construct($zbp->table['LemonUCentreVIPCate'], $zbp->datainfo['LemonUCentreVIPCate'], __CLASS__);

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
        }
        return parent::__get($name);
    }
}
