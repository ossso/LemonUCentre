<?php
/**
 * Lemon积分记录
 */

namespace LemonUCentre\Models;

use Base;


class PointCate extends Base
{
    public function __construct()
    {
        global $zbp;
        parent::__construct($zbp->table['LemonUCentrePointCate'], $zbp->datainfo['LemonUCentrePointCate'], __CLASS__);

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
                if ($this->status === 1) {
                    return '启用';
                }
                return '停用';
            break;
        }
        return parent::__get($name);
    }
}
