<?php
/**
 * 社交登录绑定关系
 */

namespace LemonUCentre\Models;

use Base;


class Social extends Base
{
    public function __construct()
    {
        global $zbp;
        parent::__construct($zbp->table['LemonUCentreSocial'], $zbp->datainfo['LemonUCentreSocial'], __CLASS__);

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
            case 'PlatformName':
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
            case 'PlatformName': {
                switch ($this->Platform) {
                    default:
                    case 0:
                        return 'QQ';
                    case 1:
                        return '微信';
                    case 2:
                        return '微博';
                    case 3:
                        return 'Google';
                    case 4:
                        return 'Github';
                    case 5:
                        return 'Facebook';
                    case 6:
                        return 'Twiiter';
                }
            }
            break;
        }
        return parent::__get($name);
    }

    /**
     * 获取数据库内指定类型OpenID的数据
     * @param string $openId
     * @param int $type 指定类型
     * @return bool
     */
    public function LoadInfoByOpenID($openId, $platform = 0)
    {
        $type = (int) $type;
        $s = $this->db->sql->Select($this->table, array('*'), array(
            array('=', 'OpenID', $openId),
            array('=', 'Platform', $platform),
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
