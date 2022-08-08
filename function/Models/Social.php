<?php
/**
 * Lemon社交登录
 */

namespace LemonUCentre\Models;

use Base;


class Third extends Base
{
    public function __construct()
    {
        global $zbp;
        parent::__construct($zbp->table['LemonUCentreThird'], $zbp->datainfo['LemonUCentreThird'], __CLASS__);

        $this->CreateTime = time();
        $this->UpdateTime = time();
    }

    /**
     * @param $name
     * @return array|int|mixed|null|string
     */
    public function __set($name, $value)
    {
        switch($name) {
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
        global $zbp, $lemon_uc;
        switch($name) {
            case 'User':
                return $lemon_uc->GetUserByID($this->LUID);
            break;
            case 'TypeName': {
                switch ($this->Type) {
                    default:
                    case 0:
                        return 'QQ';
                    case 1:
                        return '微信';
                    case 2:
                        return '微博';
                }
            }
            break;
        }
        return parent::__get($name);
    }

    /**
     * 获取数据库内指定类型OpenID的数据
     * @param int $type 指定类型
     * @param string $openId
     * @return bool
     */
    public function LoadInfoByOpenID($type = 0, $openId)
    {
        $type = (int) $type;
        $s = $this->db->sql->Select($this->table, array('*'), array(
            array('=', 'td_Type', $type),
            array('=', 'td_OpenID', $openId),
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
