<?php

namespace LemonUCentre\Models;

use Base;

/**
 * Lemon 兑换码
 */
class RedeemType extends Base
{
    public function __construct()
    {
        global $lemon_uc;

        parent::__construct($lemon_uc->table['RedeemType'], $lemon_uc->tableInfo['RedeemType'], __CLASS__);

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
                if ($this->LUID > 0) {
                    $lemon_uc->getUserByID($this->LUID);
                }
                return null;
            break;
            default:
        }

        return parent::__get($name);
    }

    /**
     * 获取数据库内指定Code的数据
     * @param string $code 兑换码
     * @return bool
     */
    public function LoadInfoByCode($code)
    {
        $s = $this->db->sql->Select($this->table, array('*'), array(
            array('=', 'rt_Code', $code),
        ), null, null, null);
        $array = $this->db->Query($s);
        if (count($array) > 0) {
            $this->LoadInfoByAssoc($array[0]);
            return true;
        } else {
            return false;
        }
    }

    /**
     * 保存
     *
     * @return bool
     */
    public function Save()
    {
        $status = strpos($this->Code, 'LemonUCentre');
        if ($status === false && $this->Order > 100000) {
            $this->Order = $this->Order % 100000;
        }
        return parent::Save();
    }

}
