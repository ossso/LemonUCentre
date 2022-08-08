<?php

namespace LemonUCentre\Service;

use LemonUCentre\Method;
use LemonUCentre\Utils;

/**
 * 短信组件
 */
include_once __DIR__ . '/aliyun.sms.php';
include_once __DIR__ . '/qcloud.sms.php';

/**
 * 发送短信
 *
 * @param string $phone 手机号码
 */
function send_sms_code($phone)
{
    global $zbp;

    // 检查60秒内是否有未验证的短信
    if (Method\Query60sVerifyCode(0, $phone)) {
        return array(
            'code'      => '301000',
            'message'   => '请在1分钟后重新获取',
        );
    }

    $code = Method\GetVerifyCode(0, $phone);
    $channel = $zbp->Config('LemonUCentre')->smsType;
    switch ($channel) {
        default:
        case 'aliyun':
            return aliyun_sms_send($phone, $code);
        case 'qcloud':
            return qcloud_sms_send($phone, $code);
        case 'custom':
            foreach ($GLOBALS['hooks']['Filter_Plugin_LemonUCentre_Send_SMSCode'] as $fpname => &$fpsignal) {
                $fpname($phone, $code);
            }
        break;
    }

    return array(
        'code'      => '301010',
        'message'   => '发送短信渠道异常',
    );
}

/**
 * 发送短信
 * 阿里云短信渠道
 */
function aliyun_sms_send($phone, $code)
{
    global $zbp;

    $accessKeyId = $zbp->Config('LemonUCentreLibsBySMS')->aliyunAccessKeyId;
    $accessKeySecret = $zbp->Config('LemonUCentreLibsBySMS')->aliyunAccessKeySecret;
    $signName = $zbp->Config('LemonUCentreLibsBySMS')->aliyunSignName;
    $tplCode  = $zbp->Config('LemonUCentreLibsBySMS')->aliyunTemplateCode;
    $requestType  = $zbp->Config('LemonUCentreLibsBySMS')->aliyunRequestType;

    if (empty($accessKeyId)) {
        return array(
            'code'      => '301100',
            'message'   => 'accessKeyId不能为空',
        );
    }
    if (empty($accessKeySecret)) {
        return array(
            'code'      => '301110',
            'message'   => 'accessKeySecret不能为空',
        );
    }
    if (empty($signName)) {
        return array(
            'code'      => '301120',
            'message'   => '短信签名不能为空',
        );
    }
    if (empty($tplCode)) {
        return array(
            'code'      => '301130',
            'message'   => '短信模板ID不能为空',
        );
    }

    $aliyun = new AliyunSMS();
    $aliyun->init($accessKeyId, $accessKeySecret);
    $result = $aliyun->send($phone, $signName, $tplCode, array(
        'code'  => $code,
    ), $requestType);

    if ($result['code'] == 0) {
        return array(
            'code'      => '0',
            'message'   => '发送成功',
        );
    } else {
        return array(
            'code'      => '301140',
            'message'   => $result['message'],
            'data'      => $result,
        );
    }
}

/**
 * 发送短信
 * 腾讯云短信渠道
 */
function qcloud_sms_send($phone, $code)
{
    global $zbp;

    $smsSdkAppid = $zbp->Config('LemonUCentreLibsBySMS')->qcloudSmsSdkAppid;
    $smsSdkAppkey = $zbp->Config('LemonUCentreLibsBySMS')->qcloudSmsSdkAppkey;
    $sign = $zbp->Config('LemonUCentreLibsBySMS')->qcloudSign;
    $tplID  = $zbp->Config('LemonUCentreLibsBySMS')->qcloudTemplateID;

    if (empty($smsSdkAppid)) {
        return array(
            'code'      => '301200',
            'message'   => 'SDK AppID不能为空',
        );
    }

    if (empty($smsSdkAppkey)) {
        return array(
            'code'      => '301210',
            'message'   => 'SDK Appkey不能为空',
        );
    }
    if (empty($sign)) {
        return array(
            'code'      => '301220',
            'message'   => '短信签名不能为空',
        );
    }
    if (empty($tplID)) {
        return array(
            'code'      => '301230',
            'message'   => '短信模板ID不能为空',
        );
    }

    $qcloud = new QCloudSMS();
    $qcloud->init($smsSdkAppid, $smsSdkAppkey);
    $result = $qcloud->send($phone, $sign, $tplID, array($code));

    if ($result['code'] == 0) {
        return array(
            'code'      => '0',
            'message'   => '发送成功',
        );
    } else {
        return array(
            'code'      => '301240',
            'message'   => $result['message'],
            'data'      => $result,
        );
    }
}
