<?php
/**
 * 配置表
 */

namespace LemonUCentre\Models;

use Base;

class Config extends Base
{
    public function __construct()
    {
        global $zbp;
        parent::__construct($zbp->table['LemonUCentreConfig'], $zbp->datainfo['LemonUCentreConfig'], __CLASS__);
    }
}
