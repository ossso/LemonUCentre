<?php

namespace LemonUCentre\Models;

use Base; // ZBlogPHP Base

/**
 * LemonUCentre用户类
 * 拓展关联 ->LemonUser
 */
class User extends Base
{
    public function __construct()
    {
        global $lemon_uc;

        parent::__construct($lemon_uc->table['LemonUCentreUser'], $lemon_uc->tableInfo['LemonUCentreUser'], __CLASS__);

        $this->UpdateTime = time();
    }

    /**
     * @param $name
     * @return array|int|mixed|null|string
     */
    public function __set($name, $value)
    {
        switch($name) {
            case 'Avatar':
            case 'Member':
            case 'Username':
            case 'Nickname':
            case 'GenderLabel':
            case 'VIP':
            case 'InviteCode':
            case 'CheckIn':
            case 'CheckInToday':
            case 'CheckInCount':
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
            case 'Member':
                return $zbp->GetMemberByID($this->UID);
            case 'Username':
                return $this->Member->Name;
            case 'Nickname':
                return $this->Member->StaticName;
            case 'Avatar':
                if (!empty($this->AvatarUrl)) {
                    return $this->AvatarUrl;
                }
                return $this->Member->Avatar;
            case 'GenderLabel':
                if ($this->Gender == 1) {
                    return '男';
                } else
                if ($this->Gender == 2) {
                    return '女';
                }
                return '未知';
            // TODO 处理VIP查询
            case 'VIP':
                return '';
            case 'InviteCode':
                if (empty($this->Code) && $this->ID > 0) {
                    $code = $lemon_uc->getUniqueInviteCode(false);
                    $this->Code = $code;
                    $this->SystemSave();
                }
                return $this->Code;
            /**
             * 签到对象
             */
            case 'CheckIn':
                $checkin = new CheckIn();
                $checkin->LoadInfoByUID($UID);
                if ($checkin->UID == 0) {
                    $checkin->UID = $UID;
                    $checkin->Save();
                }
                return $checkin;
            /**
             * 昨日签到状态
             */
            case 'CheckInYesterday':
                return $lemon_uc->checkInYesterday($this);
            /**
             * 今日签到状态
             */
            case 'CheckInToday':
                return $lemon_uc->checkInToday($this);
            /**
             * 签到数量
             */
            case 'CheckInCount':
                return $lemon_uc->checkInCount($this);
            /**
             * 获取今天的签到积分
             */
            case 'CheckInPointsByToday':
                return Method\ComputedPointsByCheckIn($this->User);
            /**
             * 获取明天的签到积分
             */
            case 'CheckInPointsByTomorrow':
                return Method\ComputedPointsByCheckIn($this->User, true);
        }
        return parent::__get($name);
    }

    /**
     * 获取用户每次登录的唯一Token
     */
    public function getToken()
    {
        $key = uniqid() . mt_rand() . time();
        $token = md5(hash_hmac('sha256', $this->ID . $key, $this->User->Guid));
        return $token;
    }

    /**
     * 获取数据库内指定UID的数据
     * @param int $id 指定UID
     * @return bool
     */
    public function LoadInfoByUID($id)
    {
        $id = (int) $id;
        $s = $this->db->sql->Select($this->table, array('*'), array(
            array('=', 'u_UID', $id),
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
     * 保存用户数据.
     *
     * @return bool
     */
    public function Save()
    {
        $this->UpdateTime = time();
        return parent::Save();
    }

    /**
     * 保存用户数据.
     *
     * @return bool
     */
    public function SystemSave()
    {
        return parent::Save();
    }
}
