<?php
/**
 * Lemon 邀请码
 */

namespace LemonUCentre\Models;

use Base;


class InviteCode extends Base
{
    public function __construct()
    {
        global $zbp;
        parent::__construct($zbp->table['LemonUCentreInviteCode'], $zbp->datainfo['LemonUCentreInviteCode'], __CLASS__);

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
        switch ($name) {
            case 'User': 
                return $lemon_uc->GetUserByID($this->UID);
            break;
        }
        return parent::__get($name);
    }

    /**
     * 获取数据库内指定Code的数据
     * @param string $code 指定Code
     * @return bool
     */
    public function LoadInfoByCode($code)
    {
        $s = $this->db->sql->Select($this->table, array('*'), array(
            array('=', 'Code', $code),
        ), null, null, null);
        $array = $this->db->Query($s);
        if (count($array) > 0) {
            $this->LoadInfoByAssoc($array[0]);
            return true;
        } else {
            return false;
        }
    }
}
