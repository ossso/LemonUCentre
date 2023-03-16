<?php
/**
 * 奖励规则
 * 控制积分、兑换码等功能相互兑换与获取
 */

namespace LemonUCentre\Models;

use Base;
use LemonUCentre\Constants\Common as COMMON;
use LemonUCentre\Constants\AwardRule as AWARD_RUlE;

class AwardRule extends Base
{
    public function __construct()
    {
        global $zbp;
        parent::__construct($zbp->table['LemonUCentreAwardRule'], $zbp->datainfo['LemonUCentreAwardRule'], __CLASS__);

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
            case 'CateName':
            case 'TypeName':
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
            case 'CateName': 
                return AWARD_RUlE\CATE_NAME[$this->Cate];
            case 'TypeName': 
                $typeName = AWARD_RUlE\TYPE_NAME[$this->Cate];
                if (empty($typeName)) {
                    return '自定义';
                }
                return $typeName;
        }
        return parent::__get($name);
    }
}
