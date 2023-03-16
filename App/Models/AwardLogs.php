<?php
/**
 * 奖励规则日志
 * 需要处理失败后的重发
 */

namespace LemonUCentre\Models;

use Base;
use LemonUCentre\Constants\Common as COMMON;

class AwardLogs extends Base
{
    public function __construct()
    {
        global $zbp;
        parent::__construct($zbp->table['LemonUCentreAwardLogs'], $zbp->datainfo['LemonUCentreAwardLogs'], __CLASS__);

        $this->CreateTime = time();
    }

    /**
     * @param $name
     * @return array|int|mixed|null|string
     */
    public function __set($name, $value)
    {
        switch($name) {
            case 'StatusName':
            case 'AwardRule':
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
        switch($name) {
            case 'StatusName':
                return COMMON\STATUS[$this->Status];
            // TODO 需要处理奖励规则获取
            case 'AwardRule':
                // return COMMON\STATUS[$this->Status];
        }
        return parent::__get($name);
    }
}
