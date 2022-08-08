<?php
/**
 * Lemon 关注用户
 */

namespace LemonUCentre\Models;

use Base;


class Follow extends Base
{
    public function __construct()
    {
        global $zbp;
        parent::__construct($zbp->table['LemonUCentreFollow'], $zbp->datainfo['LemonUCentreFollow'], __CLASS__);

        $this->CreateTime = time();
    }

    /**
     * @param $name
     * @return array|int|mixed|null|string
     */
    public function __set($name, $value) {
        switch($name) {
            case 'User':
            case 'FollowUser':
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
    public function __get($name) {
        global $zbp, $lemon_uc;
        switch($name) {
            case 'User':
                return $lemon_uc->GetUserByID($this->LUID);
            break;
            case 'FollowUser':
                return $lemon_uc->GetUserByID($this->FUID);
            break;
        }
        return parent::__get($name);
    }

    /**
     * @param int $luid LUID
     * @param int $fuid FUID
     * @return bool
     */
    public function LoadInfoByUID($luid, $fuid) {
        $luid = (int) $luid;
        $fuid = (int) $fuid;
        $s = $this->db->sql->Select($this->table, array('*'), array(
            array('=', 'lf_LUID', $luid),
            array('=', 'lf_FUID', $fuid),
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
