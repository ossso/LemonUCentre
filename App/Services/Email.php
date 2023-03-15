<?php

namespace LemonUCentre\Service;

use LemonUCentre\Method;
use LemonUCentre\Utils;

/**
 * 邮件组件
 */
include_once __DIR__ . '/aliyun.email.php';
include_once __DIR__ . '/smtp.php';

/**
 * 发送验证码邮件
 *
 * @param string $email 邮箱地址
 */
function send_email_code($email)
{
    global $zbp;

    // 检查60秒内是否有未验证的短信
    if (Method\Query60sVerifyCode(1, $email)) {
        return array(
            'code'      => '300000',
            'message'   => '请在1分钟后重新获取',
        );
    }

    $code = Method\GetVerifyCode(1, $email);

    $subject = '您在【' . $zbp->name . '】的验证码';
    $content = '<p>验证码: <span style="font-weight: bold; color: #ff6666;">' . $code . '</span>，15分钟内有效。</p>';

    $channel = $zbp->Config('LemonUCentre')->emailType;
    switch ($channel) {
        default:
        case 'smtp':
            return smtp_email_send($email, $subject, $content);
        case 'aliyun':
            return aliyun_email_send($email, $subject, $content);
        case 'custom':
            foreach ($GLOBALS['hooks']['Filter_Plugin_LemonUCentre_Send_Email'] as $fpname => &$fpsignal) {
                $fpname($email, $subject, $content, 'VerifyCode');
            }
        break;
    }

    return array(
        'code'      => '300010',
        'message'   => '发送邮件渠道异常',
    );
}

/**
 * 发送激活邮件
 *
 * @param string $email 邮箱地址
 * @param object $user 注册用户对象
 */
function send_email_active($email, $user)
{
    global $zbp, $lemon_uc;

    $timestamp = time();
    $user->LemonUser->Metas->VerifyEmail = $email;
    $user->LemonUser->Metas->VerifyEmailTime = $timestamp;
    $user->LemonUser->Save();

    $stringToSign = '';
    $stringToSign .= $email . "\n";
    $stringToSign .= $user->ID . "\n";
    $stringToSign .= $user->PostTime . "\n";
    $stringToSign .= $timestamp . "\n";
    $token = base64_encode(hash_hmac('sha1', $stringToSign, $user->Guid, true));
    $token = urlencode($token);
    if ($zbp->Config('LemonUCentre')->routerType == 'REWRITE' || $zbp->Config('LemonUCentre')->routerType == 'INDEX.PHP') {
        $routeName = $zbp->Config('LemonUCentre')->routeName;
        $routeName .= strlen($routeName) > 0 ? '/' : '';
        if ($zbp->Config('LemonUCentre')->routerType == 'INDEX.PHP') {
            $routeName = 'index.php/' . $routeName;
        }
        $suf = $zbp->Config('LemonUCentre')->routeSuffix;
        $suf = $suf ? $suf : '';
        $activeLink = $zbp->host . $routeName . 'email-active' . $suf . '?';
    } else {
        $activeLink = $zbp->host . 'zb_system/cmd.php?act=lemon-uc-page&type=email-active&';
    }
    $uid = $user->ID;
    $activeLink .= 'token=' . $token . '&uid=' . $uid . '&email=' . $email;

    $tplPath = $zbp->path . 'zb_users/plugin/LemonUCentre/check-email.tpl';
    if (file_exists($tplPath)) {
        $content = file_get_contents($tplPath);
        $content = preg_replace('/\{%name%\}/', $zbp->name, $content);
        $content = preg_replace('/\{%nickname%\}/', $user->StaticName, $content);
        $content = preg_replace('/\{%url%\}/', $activeLink, $content);
    } else {
        $content = '<a herf="' . $activeLink . '">' . $activeLink . '</a>';
    }

    $subject = '【' . $zbp->name . '】 注册邮箱激活';

    $channel = $zbp->Config('LemonUCentre')->emailType;
    switch ($channel) {
        default:
        case 'smtp':
            return smtp_email_send($email, $subject, $content);
        case 'aliyun':
            return aliyun_email_send($email, $subject, $content);
        case 'custom':
            foreach ($GLOBALS['hooks']['Filter_Plugin_LemonUCentre_Send_Email'] as $fpname => &$fpsignal) {
                $fpname($email, $subject, $content, 'ActiveLink');
            }
        break;
    }

    return array(
        'code'      => '300020',
        'message'   => '发送邮件渠道异常',
    );
}

/**
 * SMTP发送邮件
 *
 * @param string $email 接收邮件地址
 * @param string $subject 邮件主题
 * @param string $content 邮件内容
 */
function smtp_email_send($email, $subject, $content)
{
    global $zbp;
    $mailto = $email;
    $mailsubject = $subject;
    $mailbody = $content;

    $smtpserverport = $zbp->Config('LemonUCentreLibsByEmail')->smtpPort;
    $smtpserverport = $smtpserverport ? $smtpserverport : 25;
    $smtpserver     = $zbp->Config('LemonUCentreLibsByEmail')->smtpServer;
    if ($smtpserverport == 465) {
        if (substr($smtpserver, 0, 6) != 'ssl://') {
            $smtpserver = 'ssl://' . $smtpserver;
        }
    }
    $smtpuser       = $zbp->Config('LemonUCentreLibsByEmail')->smtpUsername;
    $smtppass       = $zbp->Config('LemonUCentreLibsByEmail')->smtpPassword;
    $smtpusermail   = $zbp->Config('LemonUCentreLibsByEmail')->smtpUserEmail;
    $sender         = $zbp->Config('LemonUCentreLibsByEmail')->smtpNickname;

    if (empty($smtpserver)) {
        return array(
            'code'      => '300100',
            'message'   => '服务器不能为空',
        );
    }
    if (empty($smtpuser)) {
        return array(
            'code'      => '300110',
            'message'   => '用户名不能为空',
        );
    }
    if (empty($smtppass)) {
        return array(
            'code'      => '300120',
            'message'   => '密码不能为空',
        );
    }
    if (empty($smtpusermail)) {
        return array(
            'code'      => '300130',
            'message'   => '发件人不能为空',
        );
    }
    if (empty($sender)) {
        $sender = $zbp->name;
    }

    $mailsubject    = '=?UTF-8?B?' . base64_encode($mailsubject) . '?=';
    $mailtype       = 'HTML';
    $smtpreplyto    = '';
    $cc             = '';
    $bcc            = '';
    $additional_headers = '';

    $smtp           = new SMTP($smtpserver, $smtpserverport, true, $smtpuser, $smtppass);
    $smtp->debug    = false;
    $status = $smtp->sendmail($mailto, $smtpusermail, $mailsubject, $mailbody, $mailtype, $cc, $bcc, $additional_headers, $sender, $smtpreplyto);

    if ($status) {
        return array(
            'code'      => '0',
            'message'   => '发送成功',
        );
    }
    return array(
        'code'      => '300140',
        'message'   => '发送失败',
    );
}

/**
 * 发送邮件
 * 阿里云API发送
 *
 * @param string $email 接收邮件地址
 * @param string $subject 邮件主题
 * @param string $content 邮件内容
 */
function aliyun_email_send($email, $subject, $content)
{
    global $zbp;

    $accessKeyId = $zbp->Config('LemonUCentreLibsByEmail')->aliyunAccessKeyId;
    $accessKeySecret = $zbp->Config('LemonUCentreLibsByEmail')->aliyunAccessKeySecret;
    $fromEmail = $zbp->Config('LemonUCentreLibsByEmail')->aliyunFromEmail;
    $fromEmailName = $zbp->Config('LemonUCentreLibsByEmail')->aliyunFromEmailName;

    if (empty($accessKeyId)) {
        return array(
            'code'      => '300200',
            'message'   => 'accessKeyId不能为空',
        );
    }
    if (empty($accessKeySecret)) {
        return array(
            'code'      => '300210',
            'message'   => 'accessKeySecret不能为空',
        );
    }
    if (empty($fromEmail)) {
        return array(
            'code'      => '300220',
            'message'   => '发信账号不能为空',
        );
    }
    if (empty($fromEmail)) {
        $fromEmailName = $zbp->name;
    }

    $aliyun = new AliyunEmail();
    $aliyun->init($accessKeyId, $accessKeySecret);
    $result = $aliyun->send($fromEmail, $fromEmailName, $email, $subject, $content);

    if ($result['code'] == 0) {
        return array(
            'code'      => '0',
            'message'   => '发送成功',
        );
    } else {
        return array(
            'code'      => '300230',
            'message'   => $result['message'],
            'data'      => $result,
        );
    }
}
