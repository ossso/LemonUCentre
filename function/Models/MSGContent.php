<?php
/**
 * Lemon 站内信内容
 */

namespace LemonUCentre\Models;

use Base;


class MSGContent extends Base
{
    public function __construct()
    {
        global $zbp;
        parent::__construct($zbp->table['LemonUCentreMSGContent'], $zbp->datainfo['LemonUCentreMSGContent'], __CLASS__);

        $this->CreateTime = time();
    }
}
