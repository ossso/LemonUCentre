<?php
/**
 * QQ互联回调页面
 */

require '../../../../zb_system/function/c_system_base.php';

$zbp->Load();

if (!$zbp->CheckPlugin('LemonUCentre')) {
    $zbp->ShowError(48);
    die();
}

LemonUCentre_QQConnectCallback();
