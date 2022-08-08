<?php

namespace LemonUCentre\Controllers;

use LemonUCentre\Models\RedeemType;

/**
 * 后台数据控制器
 */
class AdminController extends BaseController
{

    /**
     * 确认是否登录
     */
    public function checkLogin()
    {
        global $zbp, $lemon_uc;
        if ($zbp->user->Level != 1) {
            $this->response['code'] = -9;
            $this->response['message'] = '权限不足';
            return false;
        }
        return true;
    }

    /**
     * 处理接口数据
     */
    public function watch()
    {
        switch ($this->type) {
            case 'getRouter':
                $this->getRouter();
            break;
            case 'getLoginSet':
                $this->getLoginSet();
            break;
            case 'getRedeemTypeItem':
                $this->getRedeemTypeItem();
            break;
            case 'getRedeemTypeList':
                $this->getRedeemTypeList();
            break;
            case 'getRedeemCodeList':
                $this->getRedeemCodeList();
            break;
            case 'saveRouter':
                $this->saveRouter();
            break;
            case 'saveLoginSet':
                $this->saveLoginSet();
            break;
            case 'saveRedeemTypeItem':
                $this->saveRedeemTypeItem();
            break;
            case 'createRedeemCode':
                $this->createRedeemCode();
            break;
            case 'reg-setting':
                $this->AdminSaveRegSetting();
            break;
            case 'sms-setting':
                $this->AdminSaveSMSSetting();
            break;
            case 'mail-setting':
                $this->AdminSaveEmailSetting();
            break;
            case 'invitation-code-create':
                $this->AdminCreateInvitationCode();
            break;
            case 'invitation-code-status':
                $this->AdminUpdateInvitationCodeStatus();
            break;
            case 'invitation-code-delete':
                $this->AdminDeleteInvitationCode();
            break;
            case 'points-setting':
                $this->AdminSavePointsSetting();
            break;
            case 'vip-setting':
                $this->AdminSaveVIPSetting();
            break;
            case 'redemption-code-list':
                $this->AdminGetRedemptionCodeList();
            break;
            case 'redemption-code-create':
                $this->AdminCreateRedemptionCode();
            break;
            case 'redemption-code-status':
                $this->AdminUpdateRedemptionCodeStatus();
            break;
            case 'redemption-code-delete':
                $this->AdminDeleteRedemptionCode();
            break;
            default:
                parent::watch();
        }

        return true;
    }

    /**
     * 获取路由配置内容
     */
    public function getLoginSet()
    {
        global $zbp;

        $params = array(
            'loginBySMSCode',
            'loginByEmailCode',
        );
        $result = array();
        foreach ($params as $v) {
            $result[$v] = $zbp->Config('LemonUCentre')->$v;
        }

        $this->response['code'] = 0;
        $this->response['result'] = $result;

        return true;
    }

    /**
     * 获取路由配置内容
     */
    public function getRouter()
    {
        global $zbp;

        $params = array(
            'routerType',
            'routeName',
            'routeSuffix',
        );
        $result = array();
        foreach ($params as $v) {
            $result[$v] = $zbp->Config('LemonUCentre')->$v;
        }

        $this->response['code'] = 0;
        $this->response['result'] = $result;

        return true;
    }

    /**
     * 获取兑换码类型
     */
    public function getRedeemTypeItem()
    {
        global $zbp, $lemon_uc;

        $id = \GetVars('id', 'POST');
        if ($id > 0) {
            $redeemType = $lemon_uc->getRedeemTypeByID($id);
            if ($id != $redeemType->ID) {
                $this->response['code'] = -1;
                $this->response['message'] = '兑换类型ID不正确';
                return false;
            }
        } else {
            $this->response['code'] = -1;
            $this->response['message'] = '请传入正确的ID';
            return false;
        }

        $this->response['code'] = 0;
        $this->response['result'] = $this->vo->To('RedeemType', $redeemType);

        return true;
    }

    /**
     * 获取兑换码列表
     */
    public function getRedeemTypeList()
    {
        global $zbp, $lemon_uc;

        // 页码
        $page = \GetVars('page', 'POST');
        $page = (int) $page > 0 ? (int) $page : 1;
        // 数量
        $size = \GetVars('size', 'POST');
        $size = (int) $size > 0 ? (int) $size : 10;

        $pagebar = new \Pagebar('', false);
        $pagebar->PageCount = $size;
        $pagebar->PageNow = $page;
        $pagebar->PageBarCount = $zbp->pagebarcount;

        $w = array();
        $order = array('rt_Order' => 'DESC', 'rt_ID' => 'DESC');
        $limit = array(($pagebar->PageNow - 1) * $pagebar->PageCount, $pagebar->PageCount);
        $option = array('pagebar' => $pagebar);

        $codeList = $lemon_uc->getRedeemTypeList(array('*'), $w, $order, $limit, $option);

        $list = array();
        foreach ($codeList as $item) {
            $list[] = $this->vo->To('RedeemType', $item);
        }

        $result = array(
            'page'      => $page,
            'size'      => $size,
            'total'     => $pagebar->Count,
            'list'      => $list,
        );

        $this->response['code'] = 0;
        $this->response['result'] = $result;
        $this->response['message'] = '请求成功';
    }

    /**
     * 获取兑换码列表
     */
    public function getRedeemCodeList()
    {
        global $zbp, $lemon_uc;

        // 页码
        $page = \GetVars('page', 'POST');
        $page = (int) $page > 0 ? (int) $page : 1;
        // 数量
        $size = \GetVars('size', 'POST');
        $size = (int) $size > 0 ? (int) $size : 10;
        // 过滤状态
        $status = \GetVars('status', 'POST');
        // 过滤类型
        $type = \GetVars('type', 'POST');
        // 搜索邀请码
        $code = \GetVars('code', 'POST');

        $pagebar = new \Pagebar('', false);
        $pagebar->PageCount = $size;
        $pagebar->PageNow = $page;
        $pagebar->PageBarCount = $zbp->pagebarcount;

        $w = array();
        if (isset($status) && strlen($status)) {
            $w[] = array('=', 'rc_Status', $status);
        }
        if (isset($type) && strlen($type)) {
            $w[] = array('=', 'rc_Type', $type);
        }
        if (isset($code) && strlen($code)) {
            $w[] = array('search', 'rc_Code', $code);
        }
        $order = array('rc_CreateTime' => 'DESC', 'rc_ID' => 'DESC');
        $limit = array(($pagebar->PageNow - 1) * $pagebar->PageCount, $pagebar->PageCount);
        $option = array('pagebar' => $pagebar);

        $codeList = $lemon_uc->getRedeemCodeList(array('*'), $w, $order, $limit, $option);

        $list = array();
        foreach ($codeList as $item) {
            $list[] = $this->vo->To('RedeemCode', $item, array(
                'use' => true,
                'type' => true,
                'more' => true,
            ));
        }

        $result = array(
            'page'      => $page,
            'size'      => $size,
            'total'     => $pagebar->Count,
            'list'      => $list,
        );

        $this->response['code'] = 0;
        $this->response['result'] = $result;
        $this->response['message'] = '请求成功';
    }

    /**
     * 保存登录内容
     */
    public function saveLoginSet()
    {
        global $zbp;

        $params = array(
            'loginBySMSCode',
            'loginByEmailCode',
        );
        foreach ($params as $v) {
            $zbp->Config('LemonUCentre')->$v = trim(\GetVars($v, 'POST'));
        }
        $zbp->SaveConfig('LemonUCentre');

        $this->response['code'] = 0;
        $this->response['message'] = '保存成功';

        return true;
    }

    /**
     * 保存路由配置内容
     */
    public function saveRouter()
    {
        global $zbp;

        $params = array(
            'routerType',
            'routeName',
            'routeSuffix',
        );
        foreach ($params as $v) {
            $zbp->Config('LemonUCentre')->$v = trim(\GetVars($v, 'POST'));
        }
        $zbp->SaveConfig('LemonUCentre');

        $this->response['code'] = 0;
        $this->response['message'] = '保存成功';

        return true;
    }

    /**
     * 获取兑换码类型
     */
    public function saveRedeemTypeItem()
    {
        global $zbp, $lemon_uc;

        $id = \GetVars('id', 'POST');
        if ($id > 0) {
            $redeemType = $lemon_uc->getRedeemTypeByID($id);
            if ($id != $redeemType->ID) {
                $this->response['code'] = -1;
                $this->response['message'] = '兑换类型ID不正确';
                return false;
            }
        } else {
            $redeemType = new RedeemType();
        }

        $params = array(
            'Name',
            'Code',
            'Symbol',
            'Order',
            'Remark',
        );
        if ($redeemType->Lock == '1') {
            $params = array(
                'Name',
                'Symbol',
                'Remark',
            );
        }

        foreach ($params as $k) {
            $redeemType->$k = trim(\GetVars($k, 'POST'));
        }
        $redeemType->Save();

        $this->response['code'] = 0;
        $this->response['message'] = '保存成功';

        return true;
    }

    /**
     * 保存注册设置内容
     */
    public function AdminSaveRegSetting()
    {
        global $zbp;
        $params = array(
            'regLevel',
            'regType',
            'regValidcode',
            'regSyncUsername',
            'regSendEmailLogin',
            'regInvitationCode',
            'regUserInvitationCode',
        );
        foreach ($params as $v) {
            $zbp->Config('LemonUCentre')->$v = trim(\GetVars($v, 'POST'));
        }
        $zbp->SaveConfig('LemonUCentre');

        $this->response['code'] = 0;
        $this->response['message'] = '保存成功';
    }

    /**
     * 保存短信设置内容
     */
    public function AdminSaveSMSSetting()
    {
        global $zbp;

        $type = \GetVars('mode', 'GET');

        switch ($type) {
            case 'system':
                $params = array(
                    'smsType',
                );
                foreach ($params as $v) {
                    $zbp->Config('LemonUCentre')->$v = trim(\GetVars($v, 'POST'));
                }
                $zbp->SaveConfig('LemonUCentre');
            break;
            case 'aliyun':
                $params = array(
                    'aliyunAccessKeyId',
                    'aliyunAccessKeySecret',
                    'aliyunSignName',
                    'aliyunTemplateCode',
                    'aliyunRequestType',
                );
                foreach ($params as $v) {
                    $zbp->Config('LemonUCentreLibsBySMS')->$v = trim(\GetVars($v, 'POST'));
                }
                $zbp->SaveConfig('LemonUCentreLibsBySMS');
            break;
            case 'qcloud':
                $params = array(
                    'qcloudSmsSdkAppid',
                    'qcloudSmsSdkAppkey',
                    'qcloudSign',
                    'qcloudTemplateID',
                );
                foreach ($params as $v) {
                    $zbp->Config('LemonUCentreLibsBySMS')->$v = trim(\GetVars($v, 'POST'));
                }
                $zbp->SaveConfig('LemonUCentreLibsBySMS');
            break;
            default:
        }

        $this->response['code'] = 0;
        $this->response['message'] = '保存成功';
    }

    /**
     * 保存邮件设置内容
     */
    public function AdminSaveEmailSetting()
    {
        global $zbp;

        $type = \GetVars('mode', 'GET');

        switch ($type) {
            case 'system':
                $params = array(
                    'emailType',
                );
                foreach ($params as $v) {
                    $zbp->Config('LemonUCentre')->$v = trim(\GetVars($v, 'POST'));
                }
                $zbp->SaveConfig('LemonUCentre');
            break;
            case 'smtp':
                $params = array(
                    'smtpServer',
                    'smtpPort',
                    'smtpUsername',
                    'smtpPassword',
                    'smtpUserEmail',
                    'smtpNickname',
                );
                foreach ($params as $v) {
                    $zbp->Config('LemonUCentreLibsByEmail')->$v = trim(\GetVars($v, 'POST'));
                }
                $zbp->SaveConfig('LemonUCentreLibsByEmail');
            break;
            case 'aliyun':
                $params = array(
                    'aliyunAccessKeyId',
                    'aliyunAccessKeySecret',
                    'aliyunFromEmail',
                    'aliyunFromEmailName',
                );
                foreach ($params as $v) {
                    $zbp->Config('LemonUCentreLibsByEmail')->$v = trim(\GetVars($v, 'POST'));
                }
                $zbp->SaveConfig('LemonUCentreLibsByEmail');
            break;
            default:
        }

        $this->response['code'] = 0;
        $this->response['message'] = '保存成功';
    }

    /**
     * 获取邀请码列表
     */
    public function AdminGetInvitationCodeList()
    {
        global $zbp, $lemon_uc;

        // 页码
        $page = \GetVars('page', 'POST');
        $page = (int) $page > 0 ? (int) $page : 1;
        // 数量
        $size = \GetVars('size', 'POST');
        $size = (int) $size > 0 ? (int) $size : 10;
        // 过滤状态
        $status = \GetVars('status', 'POST');
        // 过滤类型
        $type = \GetVars('type', 'POST');
        // 搜索邀请码
        $code = \GetVars('code', 'POST');

        $pagebar = new \Pagebar('', false);
        $pagebar->PageCount = $size;
        $pagebar->PageNow = $page;
        $pagebar->PageBarCount = $zbp->pagebarcount;

        $w = array();
        if (isset($status) && strlen($status)) {
            $w[] = array('=', 'ic_Status', $status);
        }
        if (isset($type) && strlen($type)) {
            $w[] = array('=', 'ic_Type', $type);
        }
        if (isset($code) && strlen($code)) {
            $w[] = array('search', 'ic_Code', $code);
        }
        $order = array('ic_CreateTime' => 'DESC', 'ic_ID' => 'DESC');
        $limit = array(($pagebar->PageNow - 1) * $pagebar->PageCount, $pagebar->PageCount);
        $option = array('pagebar' => $pagebar);

        $codeList = $lemon_uc->GetInvitationCodeList(array('*'), $w, $order, $limit, $option);

        $list = array();
        foreach ($codeList as $item) {
            $list[] = $this->vo->To('InviteCode', $item);
        }

        $result = array(
            'page'      => $page,
            'size'      => $size,
            'total'     => $pagebar->Count,
            'list'      => $list,
        );

        $this->response['code'] = 0;
        $this->response['data'] = $result;
        $this->response['message'] = '请求成功';
    }

    /**
     * 创建邀请码
     */
    public function AdminCreateInvitationCode()
    {
        global $zbp, $lemon_uc;

        // 创建数量
        $num = \GetVars('num', 'POST');
        $num = (int) $num > 0 ? (int) $num : 1;

        $i = 0;
        $list = array();
        while ($i < $num) {
            $code = $lemon_uc->GetUniqueInvitationCode(true);
            $list[] = $code;
            $i += 1;
        }

        $this->response['code'] = 0;
        $this->response['data'] = $list;
        $this->response['message'] = '请求成功';
    }

    /**
     * 变更状态
     */
    public function AdminUpdateInvitationCodeStatus()
    {
        global $zbp, $lemon_uc;

        $id = \GetVars('ID', 'POST');
        $status = \GetVars('status', 'POST');
        
        if ((isset($id) && strlen($id)) && (isset($status) && strlen($status))) {
            if ((int) $status > -1) {
                $code = $lemon_uc->GetLemonUCentreInvitationCodeByID($id);
                if ($code->ID > 0 && $code->ID == $id) {
                    $code->Status = $status;
                    $code->Save();
                    $this->response['code'] = 0;
                    $this->response['message'] = '操作成功';
                    return true;
                }
            }
        }

        $this->response['code'] = -1;
        $this->response['message'] = '操作失败';
    }

    /**
     * 删除Code
     */
    public function AdminDeleteInvitationCode()
    {
        global $zbp, $lemon_uc;

        $id = \GetVars('ID', 'POST');
        $status = \GetVars('status', 'POST');
        
        if (isset($id) && strlen($id)) {
            $code = $lemon_uc->GetLemonUCentreInvitationCodeByID($id);
            if ($code->ID > 0 && $code->ID == $id) {
                $code->Del();
            }
        }

        $this->response['code'] = 0;
        $this->response['message'] = '操作成功';
    }

    /**
     * 保存积分设定
     */
    public function AdminSavePointsSetting()
    {
        global $zbp;
        $params = array(
            'pointsName',
            'regDefaultPoints',
            'checkinMode',
            'checkinAddPoints',
            'checkinIncPoints',
            'checkinIncMaxDate',
        );
        foreach ($params as $v) {
            $zbp->Config('LemonUCentre')->$v = trim(\GetVars($v, 'POST'));
        }
        $zbp->SaveConfig('LemonUCentre');

        $this->response['code'] = 0;
        $this->response['message'] = '保存成功';
    }

    /**
     * 保存会员设定
     */
    public function AdminSaveVIPSetting()
    {
        global $zbp;
        $params = array(
            'VIPName',
            'enabledPoints2VIP',
            'points2VIP',
            'points2VIPDate',
        );
        foreach ($params as $v) {
            $zbp->Config('LemonUCentre')->$v = trim(\GetVars($v, 'POST'));
        }
        $zbp->SaveConfig('LemonUCentre');

        $this->response['code'] = 0;
        $this->response['message'] = '保存成功';
    }

    /**
     * 创建兑换码
     */
    public function createRedeemCode()
    {
        global $lemon_uc;

        // 创建类型
        $type = \GetVars('type', 'POST');
        $type = trim($type);
        $typeCode = \GetVars('typeCode', 'POST');
        $typeCode = trim($typeCode);
        if (empty($type) && empty($typeCode)) {
            $this->response['code'] = -1;
            $this->response['message'] = '类型不能为空';
            return false;
        } elseif (empty($type)) {
            $redeemType = new RedeemType();
            $redeemType->LoadInfoByCode($typeCode);
            $type = $redeemType->ID;
            if ($type == '0') {
                $this->response['code'] = -1;
                $this->response['message'] = '类型不能为空';
                return false;
            }
        }

        // 兑换值
        $value = \GetVars('value', 'POST');
        $value = trim($value);
        if (empty($value)) {
            $value = 1;
        }

        // 创建数量
        $num = \GetVars('num', 'POST');
        $num = (int) $num > 0 ? (int) $num : 1;

        $i = 0;
        $result = array();
        while ($i < $num) {
            $code = $lemon_uc->createRedeemCodeItem($type, $value);
            $result[] = $this->vo->To('RedeemCode', $code);
            $i += 1;
        }

        $this->response['code'] = 0;
        $this->response['result'] = $result;

        return true;
    }

    /**
     * 变更状态
     */
    public function AdminUpdateRedemptionCodeStatus()
    {
        global $zbp, $lemon_uc;

        $id = \GetVars('ID', 'POST');
        $status = \GetVars('status', 'POST');
        
        if ((isset($id) && strlen($id)) && (isset($status) && strlen($status))) {
            if ((int) $status > -1) {
                $code = $lemon_uc->GetLemonUCentreRedemptionCodeByID($id);
                if ($code->ID > 0 && $code->ID == $id) {
                    $code->Status = $status;
                    $code->Save();
                    $this->response['code'] = 0;
                    $this->response['message'] = '操作成功';
                    return true;
                }
            }
        }

        $this->response['code'] = -1;
        $this->response['message'] = '操作失败';
    }

    /**
     * 删除Code
     */
    public function AdminDeleteRedemptionCode()
    {
        global $zbp, $lemon_uc;

        $id = \GetVars('ID', 'POST');
        $status = \GetVars('status', 'POST');
        
        if (isset($id) && strlen($id)) {
            $code = $lemon_uc->GetLemonUCentreRedemptionCodeByID($id);
            if ($code->ID > 0 && $code->ID == $id) {
                $code->Del();
            }
        }

        $this->response['code'] = 0;
        $this->response['message'] = '操作成功';
    }
}
