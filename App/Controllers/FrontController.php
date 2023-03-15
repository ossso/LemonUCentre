<?php

namespace LemonUCentre\Controllers;

use LemonUCentre\Services\Sign;
use LemonUCentre\Services\CDKEY;

/**
 * 数据控制器
 */
class FrontController extends BaseController
{
    /**
     * 监听区分
     */
    public function watch()
    {
        switch ($this->type) {
            case 'login':
                $this->login();
            break;
            case 'sms-login':
                $this->loginByPhoneVerifyCode();
            break;
            case 'email-login':
                $this->loginByEmailVerifyCode();
            break;
            case 'reg':
                $this->register();
            break;
            case 'forgotten':
                $this->forgotten();
            break;
            case 'phone-code':
                $this->sendPhoneCode();
            break;
            case 'email-code':
                $this->sendEmailCode();
            break;
            case 'bind-login':
                $this->bindLogin();
            break;
            case 'bind-sms-login':
                $this->bindLoginByPhoneVerifyCode();
            break;
            case 'bind-email-login':
                $this->bindLoginByEmailVerifyCode();
            break;
            case 'bind-reg':
                $this->bindRegister();
            break;
            case 'checkin':
                $this->checkIn();
            break;
            case 'CDKEY':
                $this->CDKEY();
            break;
            case 'collect':
                $this->articleCollect();
            break;
            case 'like':
                $this->articleLike();
            break;
            case 'follow':
                $this->userFollow();
            break;
            case 'points2vip':
                $this->points2VIP();
            break;
            case 'upload-avatar':
                $this->uploadAvatar();
            break;
            case 'update-userinfo':
                $this->updateUserinfo();
            break;
            case 'update-password':
                $this->updatePassword();
            break;
            default:
                parent::watch();
        }

        return true;
    }

    /**
     * 登录接口
     */
    public function login() 
    {
        global $zbp;

        $username = \GetVars('username', 'POST');
        $username = trim($username);
        $username = \TransferHTML($username, '[nohtml]');
        $password = \GetVars('password', 'POST');
        $password = trim($password);
        $password = \TransferHTML($password, '[nohtml]');
        $remember = \GetVars('remember', 'POST');
        $remember = trim($remember);
        $remember = \TransferHTML($remember, '[nohtml]');

        $message = '';
        $status = Sign::in($username, $password, $remember == 1, $message);
        if ($status) {
            $this->response['code'] = 0;
            $this->response['message'] = '登录成功';
        } else {
            $this->response['code'] = -1;
            $this->response['message'] = $message;
        }

        return true;
    }

    /**
     * 短信验证登录接口
     */
    public function loginByPhoneVerifyCode()
    {
        global $zbp;

        $phone = \GetVars('phone', 'POST');
        $phone = trim($phone);
        $phone = \TransferHTML($phone, '[nohtml]');
        $code = \GetVars('phoneValidcode', 'POST');
        $code = trim($code);
        $code = \TransferHTML($code, '[nohtml]');

        $result = Event\AccountLoginByVerifyCode(1, $phone, $code);

        if ($result) {
            if ($result['code'] == '0') {
                $this->response['code'] = 0;
                $this->response['message'] = '登录成功';
            } else {
                $this->response['code'] = -1;
                $this->response['message'] = $result['message'];
            }
        }
        if ($zbp->option['ZC_DEBUG_MODE']) {
            $this->response['debug'] = $result;
        }
    }

    /**
     * 邮件验证登录接口
     */
    public function loginByEmailVerifyCode()
    {
        global $zbp;

        $email = \GetVars('email', 'POST');
        $email = trim($email);
        $email = \TransferHTML($email, '[nohtml]');
        $code = \GetVars('emailValidcode', 'POST');
        $code = trim($code);
        $code = \TransferHTML($code, '[nohtml]');

        $result = Event\AccountLoginByVerifyCode(2, $email, $code);

        if ($result) {
            if ($result['code'] == '0') {
                $this->response['code'] = 0;
                $this->response['message'] = '登录成功';
            } else {
                $this->response['code'] = -1;
                $this->response['message'] = $result['message'];
            }
        }
        if ($zbp->option['ZC_DEBUG_MODE']) {
            $this->response['debug'] = $result;
        }
    }

    /**
     * 注册接口
     */
    public function register()
    {
        global $zbp, $lemon_uc;

        $regType = $zbp->Config('LemonUCentre')->regType;
        if (empty($regType)) {
            $regType = '0';
        }

        if ($zbp->Config('LemonUCentre')->regSyncUsername == '1' && $regType != '0') {
            if ($regType == '1' || $regType == '2') {
                $username = \GetVars('email', 'POST');
            } else if ($regType == '3') {
                $username = \GetVars('phone', 'POST');
            }
        } else {
            $username = \GetVars('username', 'POST');
        }

        $username = trim($username);
        $username = \TransferHTML($username, '[nohtml]');
        $nickname = \GetVars('nickname', 'POST');
        $nickname = trim($nickname);
        $nickname = \TransferHTML($nickname, '[nohtml]');
        $password = \GetVars('password', 'POST');
        $password = trim($password);
        $password = \TransferHTML($password, '[nohtml]');
        $invitationCode = \GetVars('invitationCode', 'POST');
        $invitationCode = trim($invitationCode);
        $invitationCode = \TransferHTML($invitationCode, '[nohtml]');
        $email = \GetVars('email', 'POST');
        $email = trim($email);
        $email = \TransferHTML($email, '[nohtml]');
        $phone = \GetVars('phone', 'POST');
        $phone = trim($phone);
        $phone = \TransferHTML($phone, '[nohtml]');

        switch ($regType) {
            default:
            case '0':
                $result = Event\Register($username, $nickname, $password, $invitationCode);
            break;
            case '1':
                $result = Event\RegisterByEmailActive($email, $username, $password, $nickname, $invitationCode);
            break;
            case '2':
                $code = \GetVars('emailValidcode', 'POST');
                $code = trim($code);
                $code = \TransferHTML($code, '[nohtml]');
                $result = Event\RegisterByEmailCode($email, $code, $username, $password, $nickname, $invitationCode);
            break;
            case '3':
                $code = \GetVars('phoneValidcode', 'POST');
                $code = trim($code);
                $code = \TransferHTML($code, '[nohtml]');
                $result = Event\RegisterByPhoneCode($phone, $code, $username, $password, $nickname, $invitationCode);
            break;
        }

        if ($result['code'] == '0') {
            $this->response['code'] = 0;
            $this->response['message'] = '注册成功';
        } else {
            $this->response['code'] = -1;
            $this->response['message'] = $result['message'];
        }

        if ($zbp->option['ZC_DEBUG_MODE']) {
            $this->response['debug'] = $result;
        }
    }

    /**
     * 发送手机短信验证码
     */
    public function sendPhoneCode()
    {
        global $zbp;
        $phone = \GetVars('phone', 'POST');
        $phone = trim($phone);
        $phone = \TransferHTML($phone, '[nohtml]');

        if (!Method\CheckPhone($phone)) {
            $this->response['code'] = -1;
            $this->response['message'] = '手机号码不正确';
            return false;
        }

        unset($this->response['message']);
        $hasVerify = $this->HandleVerification('POST');
        if ($hasVerify) {
            return false;
        }

        $checkUser = $this->mode == 'reged';
        if ($checkUser) {
            $user = Method\GetUserByPhone($phone, $checkUser);
            if ($user->ID == 0) {
                $this->response['code'] = -1;
                $this->response['message'] = '手机号码未注册';
                return false;
            }
        }

        $result = Service\send_sms_code($phone);
        // 清理失效验证码
        Method\ClearVerifyCode();
        if ($result['code'] == '0') {
            $this->response['code'] = 0;
        } else {
            $this->response['code'] = -1;
        }
        $this->response['message'] = $result['message'];

        if ($zbp->option['ZC_DEBUG_MODE']) {
            $this->response['debug'] = $result;
        }
    }

    /**
     * 发送邮件验证码
     */
    public function sendEmailCode()
    {
        global $zbp, $lemon_uc;
        $email = \GetVars('email', 'POST');
        $email = trim($email);
        $email = \TransferHTML($email, '[nohtml]');

        if (!Method\CheckEmail($email)) {
            $this->response['code'] = -1;
            $this->response['message'] = '邮箱地址不正确';
            return false;
        }

        unset($this->response['message']);
        $hasVerify = $this->HandleVerification('POST');
        if ($hasVerify) {
            return false;
        }

        $checkUser = $this->mode == 'reged';
        if ($checkUser) {
            $user = Method\GetUserByEmail($email, $checkUser);
            if ($user->ID == 0) {
                $this->response['code'] = -1;
                $this->response['message'] = '邮箱地址未注册';
                return false;
            }
        }

        $result = Service\send_email_code($email);
        // 清理失效验证码
        Method\ClearVerifyCode();
        if ($result['code'] == '0') {
            $this->response['code'] = 0;
        } else {
            $this->response['code'] = -1;
        }
        $this->response['message'] = $result['message'];

        if ($zbp->option['ZC_DEBUG_MODE']) {
            $this->response['debug'] = $result;
        }
    }

    /**
     * 找回密码
     */
    public function forgotten() {
        global $zbp, $lemon_uc;
        $account = $_POST['autoAccount'];
        $account = trim($account);
        $account = \TransferHTML($account, '[nohtml]');
        $password = $_POST['password'];
        $password = trim($password);
        $password = \TransferHTML($password, '[nohtml]');
        $code = $_POST['autoValidcode'];
        $code = trim($code);
        $code = \TransferHTML($code, '[nohtml]');

        $result = Event\Forgotten($account, $code, $password);
        if ($result['code'] == '0') {
            $this->response['code'] = 0;
        } else {
            $this->response['code'] = -1;
        }
        $this->response['message'] = $result['message'];

        if ($zbp->option['ZC_DEBUG_MODE']) {
            $this->response['debug'] = $result;
        }
    }

    /**
     * 绑定登录
     */
    public function bindLogin()
    {
        global $zbp;

        $username = \GetVars('username', 'POST');
        $username = trim($username);
        $username = \TransferHTML($username, '[nohtml]');
        $password = \GetVars('password', 'POST');
        $password = trim($password);
        $password = \TransferHTML($password, '[nohtml]');

        $thirdType = \GetVars('LemonUCentreThirdType', 'SESSION');
        $openId = null;
        if ($thirdType == 0) {
            $openId = \GetVars('LemonUCentreQCOpenID', 'SESSION');
        }

        if (empty($openId)) {
            $this->response['code'] = -1;
            $this->response['message'] = '社交登录失效，请重新登录';
            return false;
        }

        $result = Event\AccountLogin($username, $password);
        if ($result) {
            if ($result['code'] == '0') {
                // 执行绑定
                $third = Method\CreateThirdBindByOpenID($thirdType, $openId);
                if ($third) {
                    $this->response['code'] = 0;
                    $this->response['message'] = '绑定成功';
                } else {
                    $this->response['code'] = -1;
                    $this->response['message'] = '绑定失败';
                }
            } else {
                $this->response['code'] = -1;
                $this->response['message'] = $result['message'];
            }
        }
        if ($zbp->option['ZC_DEBUG_MODE']) {
            $this->response['debug'] = $result;
        }
    }

    /**
     * 验证手机短信验证码登录
     */
    public function bindLoginByPhoneVerifyCode()
    {
        global $zbp;

        $phone = \GetVars('phone', 'POST');
        $phone = trim($phone);
        $phone = \TransferHTML($phone, '[nohtml]');
        $code = \GetVars('phoneValidcode', 'POST');
        $code = trim($code);
        $code = \TransferHTML($code, '[nohtml]');

        $thirdType = \GetVars('LemonUCentreThirdType', 'SESSION');
        $openId = null;
        if ($thirdType == 0) {
            $openId = \GetVars('LemonUCentreQCOpenID', 'SESSION');
        }

        if (empty($openId)) {
            $this->response['code'] = -1;
            $this->response['message'] = '社交登录失效，请重新登录';
            return false;
        }

        $result = Event\AccountLoginByVerifyCode(1, $phone, $code);

        if ($result) {
            if ($result['code'] == '0') {
                // 执行绑定
                $third = Method\CreateThirdBindByOpenID($thirdType, $openId);
                if ($third) {
                    $this->response['code'] = 0;
                    $this->response['message'] = '绑定成功';
                } else {
                    $this->response['code'] = -1;
                    $this->response['message'] = '绑定失败';
                }
            } else {
                $this->response['code'] = -1;
                $this->response['message'] = $result['message'];
            }
        }
        if ($zbp->option['ZC_DEBUG_MODE']) {
            $this->response['debug'] = $result;
        }
    }

    /**
     * 邮件验证登录接口
     */
    public function bindLoginByEmailVerifyCode()
    {
        global $zbp;

        $email = \GetVars('email', 'POST');
        $email = trim($email);
        $email = \TransferHTML($email, '[nohtml]');
        $code = \GetVars('emailValidcode', 'POST');
        $code = trim($code);
        $code = \TransferHTML($code, '[nohtml]');

        $thirdType = \GetVars('LemonUCentreThirdType', 'SESSION');
        $openId = null;
        if ($thirdType == 0) {
            $openId = \GetVars('LemonUCentreQCOpenID', 'SESSION');
        }

        if (empty($openId)) {
            $this->response['code'] = -1;
            $this->response['message'] = '社交登录失效，请重新登录';
            return false;
        }

        $result = Event\AccountLoginByVerifyCode(2, $email, $code);

        if ($result) {
            if ($result['code'] == '0') {
                // 执行绑定
                $third = Method\CreateThirdBindByOpenID($thirdType, $openId);
                if ($third) {
                    $this->response['code'] = 0;
                    $this->response['message'] = '绑定成功';
                } else {
                    $this->response['code'] = -1;
                    $this->response['message'] = '绑定失败';
                }
            } else {
                $this->response['code'] = -1;
                $this->response['message'] = $result['message'];
            }
        }
        if ($zbp->option['ZC_DEBUG_MODE']) {
            $this->response['debug'] = $result;
        }
    }


    /**
     * 注册接口
     */
    public function bindRegister()
    {
        global $zbp, $lemon_uc;

        $regType = $zbp->Config('LemonUCentre')->regType;
        if (empty($regType)) {
            $regType = '0';
        }

        if ($zbp->Config('LemonUCentre')->regSyncUsername == '1' && $regType != '0') {
            if ($regType == '1' || $regType == '2') {
                $username = \GetVars('email', 'POST');
            } else if ($regType == '3') {
                $username = \GetVars('phone', 'POST');
            }
        } else {
            $username = \GetVars('username', 'POST');
        }

        $username = trim($username);
        $username = \TransferHTML($username, '[nohtml]');
        $nickname = \GetVars('nickname', 'POST');
        $nickname = trim($nickname);
        $nickname = \TransferHTML($nickname, '[nohtml]');
        $password = \GetVars('password', 'POST');
        $password = trim($password);
        $password = \TransferHTML($password, '[nohtml]');
        $invitationCode = \GetVars('invitationCode', 'POST');
        $invitationCode = trim($invitationCode);
        $invitationCode = \TransferHTML($invitationCode, '[nohtml]');
        $email = \GetVars('email', 'POST');
        $email = trim($email);
        $email = \TransferHTML($email, '[nohtml]');
        $phone = \GetVars('phone', 'POST');
        $phone = trim($phone);
        $phone = \TransferHTML($phone, '[nohtml]');

        $thirdType = \GetVars('LemonUCentreThirdType', 'SESSION');
        $openId = null;
        if ($thirdType == 0) {
            $openId = \GetVars('LemonUCentreQCOpenID', 'SESSION');
        }

        if (empty($openId)) {
            $this->response['code'] = -1;
            $this->response['message'] = '社交登录失效，请重新登录';
            return false;
        }

        switch ($regType) {
            default:
            case '0':
                $result = Event\Register($username, $nickname, $password, $invitationCode);
            break;
            case '1':
                $result = Event\RegisterByEmailActive($email, $username, $password, $nickname, $invitationCode);
            break;
            case '2':
                $code = \GetVars('emailValidcode', 'POST');
                $code = trim($code);
                $code = \TransferHTML($code, '[nohtml]');
                $result = Event\RegisterByEmailCode($email, $code, $username, $password, $nickname, $invitationCode);
            break;
            case '3':
                $code = \GetVars('phoneValidcode', 'POST');
                $code = trim($code);
                $code = \TransferHTML($code, '[nohtml]');
                $result = Event\RegisterByPhoneCode($phone, $code, $username, $password, $nickname, $invitationCode);
            break;
        }

        if ($result['code'] == '0') {
            // 执行绑定
            $third = Method\CreateThirdBindByOpenID($thirdType, $openId);
            if ($third) {
                $this->response['code'] = 0;
                $this->response['message'] = '绑定成功';
            } else {
                $this->response['code'] = -1;
                $this->response['message'] = '绑定失败，账号已成功注册';
            }
        } else {
            $this->response['code'] = -1;
            $this->response['message'] = $result['message'];
        }

        if ($zbp->option['ZC_DEBUG_MODE']) {
            $this->response['debug'] = $result;
        }
    }

    /**
     * 用户签到
     */
    public function checkIn()
    {
        global $zbp, $lemon_uc;
        if ($zbp->user->ID == 0) {
            $this->response['code'] = -9;
            $this->response['message'] = '未登录或登录已超时';
            return false;
        }

        $result = Event\UserCheckIn();
        if ($result['code'] == '0') {
            $this->response['code'] = 0;
            $this->response['data'] = array(
                'count'         => $zbp->user->LemonUser->CheckInCount,
                'today'         => $zbp->user->LemonUser->CheckInPointsByToday,
                'tomorrow'      => $zbp->user->LemonUser->CheckInPointsByTomorrow,
                'pointsName'    => $lemon_uc->PointsName,
            );
        } else {
            $this->response['code'] = -1;
        }
        $this->response['message'] = $result['message'];

        if ($zbp->option['ZC_DEBUG_MODE']) {
            $this->response['debug'] = $result;
        }
    }

    /**
     * 兑换CDKEY
     */
    public function CDKEY() {

        $code = \GetVars('code', 'POST');
        $code = trim($code);
        $code = \TransferHTML($code, '[nohtml]');

        $message = '';
        $redeemCode = CDKEY::use($code, null, $message);
        if ($redeemCode) {
            $this->response['code'] = 0;
            $this->response['result'] = $this->vo->to('RedeemCode', $redeemCode, array(
                'type' => true,
            ));
        } else {
            $this->response['code'] = -1;
            $this->response['message'] = $message;
        }
        
        return true;
    }

    /**
     * 兑换会员
     */
    public function points2VIP()
    {
        global $zbp, $lemon_uc;
        if ($zbp->user->ID == 0) {
            $this->response['code'] = -9;
            $this->response['message'] = '未登录或登录已超时';
            return false;
        }

        $num = $_POST['num'];
        $num = trim($num);
        $num = \TransferHTML($num, '[nohtml]');

        $result = Event\Points2VIP($num);
        if ($result['code'] == '0') {
            $this->response['code'] = 0;
            $this->response['data'] = $result['data'];
        } else {
            $this->response['code'] = -1;
        }
        $this->response['message'] = $result['message'];

        if ($zbp->option['ZC_DEBUG_MODE']) {
            $this->response['debug'] = $result;
        }
    }

    /**
     * 收藏文章
     */
    public function articleCollect()
    {
        global $zbp, $lemon_uc;
        if ($zbp->user->ID == 0) {
            $this->response['code'] = -9;
            $this->response['message'] = '未登录或登录已超时';
            return false;
        }

        $logID = $_POST['articleID'];
        $logID = trim($logID);
        $logID = \TransferHTML($logID, '[nohtml]');
        $type = $_POST['type'];
        $type = trim($type);
        $type = \TransferHTML($type, '[nohtml]');

        if (empty($logID)) {
            $this->response['code'] = -1;
            $this->response['message'] = '文章ID不能为空';
            return false;
        }

        if (empty($type)) {
            $this->response['code'] = -1;
            $this->response['message'] = '操作类型不能为空';
            return false;
        }

        $result = Event\ArticleCollectByUser($logID, $type);
        if ($result['code'] == '0') {
            $this->response['code'] = 0;
        } else {
            $this->response['code'] = -1;
        }
        $this->response['message'] = $result['message'];

        if ($zbp->option['ZC_DEBUG_MODE']) {
            $this->response['debug'] = $result;
        }
    }

    /**
     * 点赞文章
     */
    public function articleLike()
    {
        global $zbp, $lemon_uc;
        if ($zbp->user->ID == 0) {
            $this->response['code'] = -9;
            $this->response['message'] = '未登录或登录已超时';
            return false;
        }

        $logID = $_POST['articleID'];
        $logID = trim($logID);
        $logID = \TransferHTML($logID, '[nohtml]');
        $type = $_POST['type'];
        $type = trim($type);
        $type = \TransferHTML($type, '[nohtml]');

        if (empty($logID)) {
            $this->response['code'] = -1;
            $this->response['message'] = '文章ID不能为空';
            return false;
        }

        if (empty($type)) {
            $this->response['code'] = -1;
            $this->response['message'] = '操作类型不能为空';
            return false;
        }

        $result = Event\ArticleLikeByUser($logID, $type);
        if ($result['code'] == '0') {
            $this->response['code'] = 0;
        } else {
            $this->response['code'] = -1;
        }
        $this->response['message'] = $result['message'];

        if ($zbp->option['ZC_DEBUG_MODE']) {
            $this->response['debug'] = $result;
        }
    }

    /**
     * 关注用户
     */
    public function userFollow()
    {
        global $zbp, $lemon_uc;
        if ($zbp->user->ID == 0) {
            $this->response['code'] = -9;
            $this->response['message'] = '未登录或登录已超时';
            return false;
        }

        $luid = $_POST['luid'];
        $luid = trim($luid);
        $luid = \TransferHTML($luid, '[nohtml]');
        $type = $_POST['type'];
        $type = trim($type);
        $type = \TransferHTML($type, '[nohtml]');

        if (empty($luid)) {
            $this->response['code'] = -1;
            $this->response['message'] = '用户ID不能为空';
            return false;
        }

        if (empty($type)) {
            $this->response['code'] = -1;
            $this->response['message'] = '操作类型不能为空';
            return false;
        }

        $result = Event\UserFollow($luid, $type);
        if ($result['code'] == '0') {
            $this->response['code'] = 0;
        } else {
            $this->response['code'] = -1;
        }
        $this->response['message'] = $result['message'];

        if ($zbp->option['ZC_DEBUG_MODE']) {
            $this->response['debug'] = $result;
        }
    }

    /**
     * 上传头像
     */
    public function uploadAvatar()
    {
        global $zbp, $lemon_uc;
        if ($zbp->user->ID == 0) {
            $this->response['code'] = -9;
            $this->response['message'] = '未登录或登录已超时';
            return false;
        }

        $upRet = Event\UploadPhoto();
        if ($upRet['code'] != '0') {
            $this->response['code'] = -1;
            $this->response['message'] = $upRet['message'];
            if ($zbp->option['ZC_DEBUG_MODE']) {
                $this->response['debug'] = $upRet;
            }
            return false;
        }

        foreach ($upRet['list'] as $up) {
            $url = $up['Url'];
            Method\SaveUserAvatarUrl($url);
        }

        $this->response['code'] = 0;
        $this->response['message'] = '设置头像成功';
        $this->response['result'] = $url;
    }

    /**
     * 设置用户信息
     */
    public function updateUserinfo()
    {
        global $zbp, $lemon_uc;
        if ($zbp->user->ID == 0) {
            $this->response['code'] = -9;
            $this->response['message'] = '未登录或登录已超时';
            return false;
        }

        $nickname = $_POST['nickname'];
        $nickname = trim($nickname);
        $nickname = \TransferHTML($nickname, '[nohtml]');
        $gender = $_POST['gender'];
        $gender = trim($gender);
        $gender = \TransferHTML($gender, '[nohtml]');
        $age = $_POST['age'];
        $age = trim($age);
        $age = \TransferHTML($age, '[nohtml]');

        $result = Event\UpdateUserinfo($nickname, $gender, $age);
        if ($result['code'] == '0') {
            $this->response['code'] = 0;
        } else {
            $this->response['code'] = -1;
        }
        $this->response['message'] = $result['message'];

        if ($zbp->option['ZC_DEBUG_MODE']) {
            $this->response['debug'] = $result;
        }
    }

    /**
     * 修改密码
     */
    public function updatePassword()
    {
        global $zbp, $lemon_uc;
        if ($zbp->user->ID == 0) {
            $this->response['code'] = -9;
            $this->response['message'] = '未登录或登录已超时';
            return false;
        }

        $oldPassword = $_POST['oldPassword'];
        $oldPassword = trim($oldPassword);
        $oldPassword = \TransferHTML($oldPassword, '[nohtml]');
        $password = $_POST['password'];
        $password = trim($password);
        $password = \TransferHTML($password, '[nohtml]');

        $result = Event\UpdatePassword($oldPassword, $password);
        if ($result['code'] == '0') {
            $this->response['code'] = 0;
        } else {
            $this->response['code'] = -1;
        }
        $this->response['message'] = $result['message'];

        if ($zbp->option['ZC_DEBUG_MODE']) {
            $this->response['debug'] = $result;
        }
    }

    /**
     * 处理接口需要验证的地方
     *
     * @return boolean 是否需要显示验证
     */
    public function handleVerification($method = 'POST')
    {
        global $zbp, $lemon_uc;
        $status = true;
        $imageCode = \GetVars('imageCode', $method);
        if (isset($imageCode)) {
            if ($zbp->CheckValidCode($imageCode, 'lemon-uc-event')) {
                return false;
            } else {
                $this->response['message'] = '验证码不正确';
            }
        }
        
        $this->response['code'] = 101010;
        // 图片验证码
        $this->response['data'] = array(
            'url'       => $lemon_uc->pages->imageVerification,
            'width'     => 320,
            'height'    => 180,
        );

        return $status;
    }
}
