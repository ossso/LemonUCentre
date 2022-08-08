<?php
/**
 * Lemon点赞记录
 */

namespace LemonUCentre\Models;

use Base;


class Like extends Base
{
    public function __construct()
    {
        global $zbp;
        parent::__construct($zbp->table['LemonUCentreLike'], $zbp->datainfo['LemonUCentreLike'], __CLASS__);

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
            case 'Article':
            case 'Post':
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
            case 'LemonUser':
                return $lemon_uc->GetUserByID($this->LUID);
            break;
            case 'Article':
                return $lemon_uc->GetArticleByID($this->ArtID);
            break;
            case 'Post':
                return $zbp->GetPostByID($this->LogID);
            break;
        }
        return parent::__get($name);
    }

    /**
     * 获取数据库内指定LogID的数据
     * @param int $id 指定LogID
     * @param int $luid LUID
     * @return bool
     */
    public function LoadInfoByLogID($id, $luid)
    {
        $id = (int) $id;
        $s = $this->db->sql->Select($this->table, array('*'), array(
            array('=', 'lk_LUID', $luid),
            array('=', 'lk_LogID', $id),
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
     * 获取数据库内指定ArtID的数据
     * @param int $id 指定ArtID
     * @param int $luid LUID
     * @return bool
     */
    public function LoadInfoByArtID($id, $luid)
    {
        $id = (int) $id;
        $s = $this->db->sql->Select($this->table, array('*'), array(
            array('=', 'lk_LUID', $luid),
            array('=', 'lk_ArtID', $id),
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
