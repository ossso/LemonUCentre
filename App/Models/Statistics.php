<?php
/**
 * 统计数据表
 */

namespace LemonUCentre\Models;

use Base;

class Statistics extends Base
{
    public function __construct()
    {
        global $zbp;
        parent::__construct($zbp->table['LemonUCentreStatistics'], $zbp->datainfo['LemonUCentreStatistics'], __CLASS__);
    }
}
