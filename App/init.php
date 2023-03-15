<?php

namespace LemonUCentre;

use LemonUCentre\Services\UCenter;

/**
 * 初始化
 */
function init()
{
    global $zbp;

    $lemon_uc = new UCenter();
    $GLOBALS['lemon_uc'] = $lemon_uc;

    defineTable($lemon_uc->table, $lemon_uc->tableInfo);
    defineDatainfo($lemon_uc->datainfo);
    $lemon_uc->init();

    // $routeName = $zbp->Config('LemonUCentre')->routeName;
    // $routeName .= strlen($routeName) > 0 ? '/' : '';
    // if ($zbp->Config('LemonUCentre')->routerType == 'INDEX.PHP') {
    //     $routeName = 'index.php/' . $routeName;
    // }

    // $suffix = $zbp->Config('LemonUCentre')->routeSuffix;
    // $suffix = $suffix ? $suffix : '';

    // $pageList = array(
    //     'login'             => 'login',
    //     'smsLogin'          => 'sms-login',
    //     'emailLogin'        => 'email-login',
    //     'reg'               => 'reg',
    //     'forgotten'         => 'forgotten',
    //     'bindLogin'         => 'bind-login',
    //     'bindSmsLogin'      => 'bind-sms-login',
    //     'bindEmailLogin'    => 'bind-email-login',
    //     'bindReg'           => 'bind-reg',
    //     'mine'              => 'mine',
    //     'collect'           => 'collect',
    //     'comment'           => 'comment',
    //     'cdkey'             => 'cdkey',
    //     'points'            => 'points',
    //     'use-points'        => 'use-points',
    //     'userinfo'          => 'userinfo',
    //     'uploadAvatar'      => 'upload-avatar',
    //     'updateUserinfo'    => 'update-userinfo',
    //     'updatePassword'    => 'update-password',
    //     'imageVerification' => 'image-verification',
    // );
    // $pages = array(
    //     'active'    => array(),
    //     'rewrite'   => array(),
    // );
    // foreach ($pageList as $k => $v) {
    //     $pages['active'][$k] = $zbp->host . '?mode=' . $v;
    //     $pages['rewrite'][$k] = $zbp->host . $routeName . $v . $suffix;
    // }

    // $apiList = array(
    //     'login'             => 'login',
    //     'smsLogin'          => 'sms-login',
    //     'emailLogin'        => 'email-login',
    //     'reg'               => 'reg',
    //     'forgotten'         => 'forgotten',
    //     'emailCode'         => 'email-code',
    //     'emailCodeByReged'  => 'email-code&mode=reged',
    //     'phoneCode'         => 'phone-code',
    //     'phoneCodeByReged'  => 'phone-code&mode=reged',
    //     'bindLogin'         => 'bind-login',
    //     'bindSmsLogin'      => 'bind-sms-login',
    //     'bindEmailLogin'    => 'bind-email-login',
    //     'bindReg'           => 'bind-reg',
    //     'checkIn'           => 'check-in',
    //     'cdkey'             => 'cdkey',
    //     'collect'           => 'collect',
    //     'like'              => 'like',
    //     'follow'            => 'follow',
    //     'points2vip'        => 'points2vip',
    //     'uploadAvatar'      => 'upload-avatar',
    //     'updateUserinfo'    => 'update-userinfo',
    //     'updatePassword'    => 'update-password',
    // );
    // $apis = array();
    // foreach ($apiList as $k => $v) {
    //     $apis[$k] = $zbp->host . 'zb_system/cmd.php?act=lemon-uc-api&type=' . $v;
    // }

    // if ($zbp->Config('LemonUCentre')->routerType == 'REWRITE' || $zbp->Config('LemonUCentre')->routerType == 'INDEX.PHP') {
    //     $lemon_uc->pages = (object) $pages['rewrite'];
    // } else {
    //     $lemon_uc->pages = (object) $pages['active'];
    // }
    // $lemon_uc->apis = (object) $apis;
}

init();

/**
 * 定义插件
 */

/*
'**************************************************<
'类型:Filter
'名称:Filter_Plugin_LemonUCentre_VO_To_Begin
'参数:&$vo
'说明:类对象数据转输出对象数据
'调用:
'**************************************************>
 */
\DefinePluginFilter('Filter_Plugin_LemonUCentre_VO_To_Begin');

/*
'**************************************************<
'类型:Filter
'名称:Filter_Plugin_LemonUCentre_VO_To_End
'参数:&$vo
'说明:类对象数据转输出对象数据
'调用:
'**************************************************>
 */
\DefinePluginFilter('Filter_Plugin_LemonUCentre_VO_To_End');

/*
'**************************************************<
'类型:Filter
'名称:Filter_Plugin_LemonUCentre_Send_Email
'参数:$email, $subject, $content, $type
'说明:类对象数据转输出对象数据
'调用:
'**************************************************>
 */
\DefinePluginFilter('Filter_Plugin_LemonUCentre_Send_Email');

/*
'**************************************************<
'类型:Filter
'名称:Filter_Plugin_LemonUCentre_Send_SMSCode
'参数:$phone, $code
'说明:类对象数据转输出对象数据
'调用:
'**************************************************>
 */
\DefinePluginFilter('Filter_Plugin_LemonUCentre_Send_SMSCode');

/*
'**************************************************<
'类型:Filter
'名称:Filter_Plugin_LemonUCentre_CDKEY_Use
'参数:$redeemCode, $user, $message
'说明:类对象数据转输出对象数据
'调用:
'**************************************************>
 */
\DefinePluginFilter('Filter_Plugin_LemonUCentre_CDKEY_Use');
