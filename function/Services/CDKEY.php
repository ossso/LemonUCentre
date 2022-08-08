<?php

namespace LemonUCentre\Services;

use LemonUCentre\Models\RedeemCode;

class CDKEY
{

    /**
     * 是否启用
     * @var boolean
     */
    public $enable = true;

    /**
     * 构造函数
     */
    public function __construct()
    {
        global $zbp;
        if ($zbp->Config('LemonUCentre')->RedeemCodeMode == 'off') {
            $this->enable = false;
        }
    }

    /**
     * 验证Code
     *
     * @param string $code 兑换码
     * @param string $message 通知消息
     */
    public function use($code, $user = null, &$message = '')
    {
        global $zbp, $lemon_uc;

        if (empty($user)) {
            $user = $zbp->user;
        }

        $code = str_replace('-', '', $code);
        $code = strtoupper($code);
        if (strlen($code) != 16) {
            $message = '兑换码不合法';
            return false;
        }

        $redeemCode = $lemon_uc->getRedeemCodeByCode($code);

        if ($redeemCode->ID == 0) {
            $message = '兑换码不正确';
            return false;
        }
        if ($redeemCode->Status == 1) {
            $message = '兑换码已使用';
            return false;
        }
        if ($redeemCode->Status == 2) {
            $message = '兑换码已禁用';
            return false;
        }

        $useStatus = false;
        switch ($redeemCode->Type->Code) {
            case 'LemonUCentre2VIP':
                $useStatus = self::exchangeVIP($redeemCode, $user, $message);
                break;
            case 'LemonUCentre2Point':
                $useStatus = self::exchangePoint($redeemCode, $user, $message);
                break;
            default:
                foreach ($GLOBALS['hooks']['Filter_Plugin_LemonUCentre_CDKEY_Use'] as $fpname => &$fpsignal) {
                    $useStatus = $fpname($redeemCode, $user, $message);
                    if ($useStatus) {
                        break;
                    }
                    if ($fpsignal == PLUGIN_EXITSIGNAL_RETURN) {
                        $fpsignal = PLUGIN_EXITSIGNAL_NONE;
                        return false;
                    }
                }
                break;
        }
        if (!$useStatus) {
            $message = '无法使用此兑换码';
            return false;
        }
        $redeemCode->Status = 1;
        $redeemCode->UseTime = time();
        $redeemCode->UseID = $user->LemonUser->ID;
        $redeemCode->Save();
        
        $message = '兑换成功';

        return $redeemCode;
    }

    public function exchangeVIP()
    {}

    public function exchangePoint()
    {}
}
