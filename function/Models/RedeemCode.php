<?php

namespace LemonUCentre\Models;

use Base;

/**
 * Lemon 兑换码
 */
class RedeemCode extends Base
{
    public function __construct()
    {
        global $lemon_uc;

        parent::__construct($lemon_uc->table['RedeemCode'], $lemon_uc->tableInfo['RedeemCode'], __CLASS__);

        $this->CreateTime = time();
    }

    /**
     * @param $name
     * @return array|int|mixed|null|string
     */
    public function __set($name, $value)
    {
        switch ($name) {
            case 'Use':
            case 'Type':
            case 'CodeValue':
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
            case 'Use':
                if ($this->UseID > 0) {
                    return $lemon_uc->getUserByID($this->UseID);
                }
                return null;
            break;
            case 'Type':
                return $lemon_uc->getRedeemTypeByID($this->TypeID);;
            break;
            case 'CodeValue':
                $codeValue = substr($this->Code, 0, 4);
                $codeValue .= '-' . substr($this->Code, 4, 4);
                $codeValue .= '-' . substr($this->Code, 8, 4);
                $codeValue .= '-' . substr($this->Code, 12, 4);
                return $codeValue;
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
            array('=', 'rc_Code', $code),
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
     * 生成兑换码
     * @return string 兑换码
     */
    public function getCode()
    {
        $host = \GetVars('HTTP_HOST', 'SERVER');
        $code = md5(hash_hmac('sha256', uniqid() . mt_rand() . time(), $host));
        $code = substr($code, 8, 16);
        $code = strtoupper($code);
        return $code;
    }
}
