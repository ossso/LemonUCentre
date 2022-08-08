<?php
/**
 * Lemon积分记录
 */

namespace LemonUCentre\Models;

use Base;


class PointsRecord extends Base
{
    public function __construct()
    {
        global $zbp;
        parent::__construct($zbp->table['LemonUCentrePointsRecord'], $zbp->datainfo['LemonUCentrePointsRecord'], __CLASS__);

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
                if ($this->Type == 1) {
                    return '支出';
                }
                return '收入';
            }
            break;
        }
        return parent::__get($name);
    }
    
    /**
     * @param string $s
     *
     * @return bool|string
     */
    public function Time($s = 'Y-m-d H:i:s')
    {
        return date($s, (int) $this->CreateTime);
    }
}
