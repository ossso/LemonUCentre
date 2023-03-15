<?php

namespace LemonUCentre\Social;

use LemonUCentre\Method;

/**
 * 第三方社交登录
 */
include_once __DIR__ . '/qq.connect.php';

class Social
{
    /**
     * 登录类型
     * @var string
     */
    public $type = null;

    /**
     * 构造函数
     */
    public function __construct()
    {}

    /**
     * 触发登录
     */
    public function active($type)
    {
        global $zbp;
        $this->type = $type;
        if ($this->type == 'qq') {
            $this->qqLogin();
        }
    }

    /**
     * QQ登录
     */
    public function qqLogin()
    {
        global $zbp;
        if ($zbp->Config('LemonUCentreSocial')->qq_switch != '1') {
            \Redirect($zbp->host);
        }
        $appid = $zbp->Config('LemonUCentreSocial')->qq_appid;
        $appkey = $zbp->Config('LemonUCentreSocial')->qq_appkey;
        $qc = new QQConnect();
        $qc->init($appid, $appkey);
        $res = $qc->getCodeUrl();

        if (!session_id()) {
            session_start();
        }
        $_SESSION['LemonUCentreState'] = $res['state'];

        \Redirect($res['url']);
    }

    /**
     * QQ登录回调
     */
    public function qqCallback()
    {
        global $zbp;
        if ($zbp->Config('LemonUCentreSocial')->qq_switch != '1') {
            \Redirect($zbp->host);
        }
        if (!session_id()) {
            session_start();
        }

        $state2 = \GetVars('LemonUCentreState', 'SESSION');

        $appid = $zbp->Config('LemonUCentreSocial')->qq_appid;
        $appkey = $zbp->Config('LemonUCentreSocial')->qq_appkey;
        $qc = new QQConnect();
        $qc->init($appid, $appkey, null, $state2);

        $state = \GetVars('state', 'GET');
        $state = trim($state);
        $state = \TransferHTML($state, '[nohtml]');
        $code = \GetVars('code', 'GET');
        $code = trim($code);
        $code = \TransferHTML($code, '[nohtml]');

        if ($state != $state2) {
            echo 'Hello World!';
            die();
        }

        $accessToken = $zbp->Config('LemonUCentreSocial')->qq_accessToken;
        $accessTokenTime = $zbp->Config('LemonUCentreSocial')->qq_accessTokenTime;
        if (empty($accessTokenTime) || time() - $accessTokenTime > 3600) {
            $ret = null;
            $accessToken = $qqconn->getAccessToken($state, $code, $ret);
            if (empty($accessToken)) {
                if ($zbp->option['ZC_DEBUG_MODE']) {
                    var_dump($ret);
                } else {
                    echo '未能正常获取AccessToken';
                }
                die();
            }
            $zbp->Config('LemonUCentreSocial')->qq_accessToken = $accessToken;
            $zbp->Config('LemonUCentreSocial')->qq_accessTokenTime = time();
            $zbp->SaveConfig('LemonUCentreSocial');
        } else {
            $qqconn->accessToken = $accessToken;
        }

        $ret = null;
        $openId = $qqconn->getOpenID($ret);
        if (empty($openId)) {
            if ($zbp->option['ZC_DEBUG_MODE']) {
                var_dump($ret);
            } else {
                echo '未能正常获取OPENID';
            }
            die();
        }
        // 查询openid是否绑定
        $third = Method\QueryThirdBindByOpenID(0, $openId);
        // 如果有third对象，执行登录
        if (isset($third)) {
            $user = $third->User->User;
            if ($user->ID > 0 && $user->Status == 0) {
                $zbp->user = $user;
                \SetLoginCookie($user, 0);
                \Redirect($lemon_uc->pages->mine);
            } else {
                echo '绑定的用户无权登录';
                die();
            }
        } else
        // 处理未绑定
        {
            // 判断是否登录
            if ($zbp->user->ID > 0) {
                Method\CreateThirdBindByOpenID(0, $openId);
                // 绑定成功，转到用户设置
                \Redirect($lemon_uc->pages->setting);
            } else {
                $_SESSION['LemonUCentreSocialType'] = 0;
                $_SESSION['LemonUCentreQQOpenID'] = $openId;
                \Redirect($lemon_uc->pages->thirdBind);
            }
        }
    }
}
