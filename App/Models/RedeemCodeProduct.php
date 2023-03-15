<?php
/**
 * 兑换码产品类型
 */

namespace LemonUCentre\Models;

use Base;

class RedeemCodeProduct extends Base
{
    public function __construct()
    {
        global $lemon_uc;

        parent::__construct($lemon_uc->table['LemonUCentreRedeemCodeProduct'], $lemon_uc->tableInfo['LemonUCentreRedeemCodeProduct'], __CLASS__);

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

        switch ($name) {
            case 'User':
                if ($this->UID > 0) {
                    $lemon_uc->getUserByID($this->UID);
                }
                return null;
            break;
            default:
        }

        return parent::__get($name);
    }

    /**
     * 保存
     *
     * @return bool
     */
    public function Save()
    {
        return parent::Save();
    }

}
