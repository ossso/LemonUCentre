<?php

namespace LemonUCentre;

function defineTable(&$table = [], &$tableInfo = [])
{
    /**
     * 数据库信息列表
     */
    $tables = array(
        /**
         * 用户拓展表
         */
        'User' => array(
            'name'          => '%pre%lemon_uc_user',
            'info'          => array(
                'ID'            => array('u_ID', 'integer', '', 0),
                'UID'           => array('u_UID', 'integer', '', 0),
                'VIPType'       => array('u_VIPType', 'integer', 'tinyint', 0), // VIP身份
                'VIPTime'       => array('u_VIPTime', 'integer', 'bigint', 0), // VIP有效期
                'Points'        => array('u_Points', 'integer', '', 0), // 积分
                'AvatarUrl'     => array('u_AvatarUrl', 'string', 255, ''), // 头像
                'Gender'        => array('u_Gender', 'integer', 'tinyint', 0), // 性别 0未知 | 1男 | 2女
                'Age'           => array('u_Age', 'integer', 'tinyint', 0), // 年龄
                'Phone'         => array('u_Phone', 'string', 20, ''), // 手机号码
                'Phoned'        => array('u_Phoned', 'integer', '', 0), // 手机号码是否认证 时间戳
                'Email'         => array('u_Email', 'string', 255, ''), // 邮箱地址
                'Emailed'       => array('u_Emailed', 'integer', '', 0), // 邮箱地址是否认证 时间戳
                'Code'          => array('u_Code', 'string', 10, ''), // 用户邀请码Code
                'Token'         => array('u_Token', 'string', 255, ''), // 最后登录Token
                'CollectNums'   => array('u_CollectNums', 'integer', '', 0), // 被收藏总数
                'LikeNums'      => array('u_LikeNums', 'integer', '', 0), // 收获点赞总数
                'FansNums'      => array('u_FansNums', 'integer', '', 0), // 粉丝总数
                'UpdateTime'    => array('u_UpdateTime', 'integer', 'bigint', 0), // 最后活跃时间
                'Meta'          => array('u_Meta', 'string', '', ''),
            ),
        ),
        /**
         * 文章拓展表
         */
        'Article' => array(
            'name'          => '%pre%lemon_uc_article',
            'info'          => array(
                'ID'            => array('a_ID', 'integer', '', 0),
                'LogID'         => array('a_LogID', 'integer', '', 0),
                'Status'        => array('a_Status', 'integer', 'tinyint', 0),
                'CollectNums'   => array('a_CollectNums', 'integer', '', 0), // 收藏总数
                'LikeNums'      => array('a_LikeNums', 'integer', '', 0), // 点赞总数
                'Meta'          => array('a_Meta', 'string', '', ''),
            ),
        ),
        /**
         * 签到表
         */
        'CheckIn' => array(
            'name'          => '%pre%lemon_uc_checkin',
            'info'          => array(
                'ID'            => array('ck_ID', 'integer', '', 0),
                'LUID'          => array('ck_LUID', 'integer', '', 0),
                'Count'         => array('ck_Count', 'integer', '', 0), // 签到天数
                'CheckTime'     => array('ck_CheckTime', 'integer', 'bigint', 0), // 签到时间
                'Meta'          => array('ck_Meta', 'string', '', ''),
            ),
        ),
        /**
         * 签到记录表
         */
        'CheckInRecord' => array(
            'name'          => '%pre%lemon_uc_checkin_record',
            'info'          => array(
                'ID'            => array('ckr_ID', 'integer', '', 0),
                'CKID'          => array('ckr_CKID', 'integer', '', 0),
                'LUID'          => array('ckr_LUID', 'integer', '', 0),
                'CreateTime'    => array('ckr_CreateTime', 'integer', 'bigint', 0),
                'Meta'          => array('ckr_Meta', 'string', '', ''),
            ),
        ),
        /**
         * 社交账号绑定
         */
        'Social' => array(
            'name'          => '%pre%lemon_uc_social',
            'info'          => array(
                'ID'            => array('sc_ID', 'integer', '', 0),
                'LUID'          => array('sc_LUID', 'integer', '', 0), // LemonUser ID
                'Type'          => array('sc_Type', 'integer', '', 0), // 0:QQ | 1:WeChat | 2:Weibo
                'OpenID'        => array('sc_OpenID', 'string', 255, ''),
                'UnionID'       => array('sc_UnionID', 'string', 255, ''),
                'Token'         => array('sc_Token', 'string', 255, ''), 
                'Nickname'      => array('sc_Nickname', 'string', 30, ''), // 昵称
                'Avatar'        => array('sc_Avatar', 'string', 255, ''), // 头像地址
                'CreateTime'    => array('sc_CreateTime', 'integer', 'bigint', 0),
                'UpdateTime'    => array('sc_UpdateTime', 'integer', 'bigint', 0),
                'Meta'          => array('sc_Meta', 'string', '', ''),
            ),
        ),
        /**
         * 验证码发送记录
         */
        'CaptchaRecord' => array(
            'name'          => '%pre%lemon_uc_captcha_record',
            'info'          => array(
                'ID'            => array('cr_ID', 'integer', '', 0),
                'Type'          => array('cr_Type', 'integer', '', 0), // 0手机号码 | 1邮箱地址
                'Status'        => array('cr_Status', 'integer', 'tinyint', 0), // 是否验证
                'Account'       => array('cr_Account', 'string', 255, ''), // 相关账号
                'Code'          => array('cr_Code', 'string', 20, ''), // 验证码
                'CreateTime'    => array('cr_CreateTime', 'integer', 'bigint', 0), // 创建时间
                'PassTime'      => array('cr_PassTime', 'integer', 'bigint', 0), // 验证时间
                'Meta'          => array('cr_Meta', 'string', '', ''),
            ),
        ),
        /**
         * 邀请码
         */
        'InviteCode' => array(
            'name'          => '%pre%lemon_uc_invite_code',
            'info'          => array(
                'ID'            => array('ic_ID', 'integer', '', 0),
                'LUID'          => array('ic_LUID', 'integer', '', 0), // LemonUser ID
                'Code'          => array('ic_Code', 'string', 20, ''), // 邀请码
                'Type'          => array('ic_Type', 'integer', '', 0), // 0 一次性邀请码 || 1 用户邀请码
                'Status'        => array('ic_Status', 'integer', 'tinyint', 0),
                'CreateTime'    => array('ic_CreateTime', 'integer', 'bigint', 0), // 创建时间
                'UseTime'       => array('ic_UseTime', 'integer', 'bigint', 0), // 使用时间
                'Meta'          => array('ic_Meta', 'string', '', ''),
            ),
        ),
        /**
         * 兑换码类型
         */
        'RedeemType' => array(
            'name'          => '%pre%lemon_uc_redeem_type',
            'info'          => array(
                'ID'            => array('rt_ID', 'integer', '', 0),
                'Lock'          => array('rt_Lock', 'integer', 'tinyint', 0), // 是否锁定Code不允许编辑
                'Name'          => array('rt_Name', 'string', 40, ''), // 类型名称
                'Code'          => array('rt_Code', 'string', 100, ''), // 类型识别码
                'Symbol'        => array('rt_Symbol', 'string', 100, ''), // 兑换值计量单位
                'Order'         => array('rt_Order', 'integer', '', 0), // 类型排序数值
                'Remark'        => array('rt_Remark', 'string', 255, ''), // 类型备注
                'Meta'          => array('rc_Meta', 'string', '', ''),
            ),
        ),
        /**
         * 兑换码
         */
        'RedeemCode' => array(
            'name'          => '%pre%lemon_uc_redeem_code',
            'info'          => array(
                'ID'            => array('rc_ID', 'integer', '', 0),
                'Status'        => array('rc_Status', 'integer', 'tinyint', 0), // 状态
                'TypeID'        => array('rc_TypeID', 'integer', '', 0), // 关联类型ID
                'LUID'          => array('rc_LUID', 'integer', '', 0), // 创建用户
                'UseID'         => array('rc_UseID', 'integer', '', 0), // 使用用户
                'Value'         => array('rc_Value', 'integer', '', 0), // 兑换值
                'Code'          => array('rc_Code', 'string', 255, ''), // 兑换码
                'CreateTime'    => array('rc_CreateTime', 'integer', 'bigint', 0), // 创建时间
                'UseTime'       => array('rc_UseTime', 'integer', 'bigint', 0), // 使用时间
                'Meta'          => array('rc_Meta', 'string', '', ''),
            ),
        ),
        /**
         * 统计表
         */
        'Statistics'    => array(
            'name'          => '%pre%lemon_uc_statistics',
            'info'          => array(
                'ID'            => array('st_ID', 'integer', '', 0),
                'DateKey'       => array('st_DateKey', 'integer', '', 0),
                'RegCount'      => array('st_RegCount', 'integer', '', 0),
                'LoginCount'    => array('st_LoginCount', 'integer', '', 0),
                'VIPCount'      => array('st_VIPCount', 'integer', '', 0),
                'VIPLoginCount' => array('st_VIPLoginCount', 'integer', '', 0),
                'CollectCount'  => array('st_CollectCount', 'integer', '', 0),
                'LikeCount'     => array('st_LikeCount', 'integer', '', 0),
                'Meta'          => array('st_Meta', 'string', '', ''),
            ),
        ),
        /**
         * 登录记录
         */
        'LoginRecord' => array(
            'name'          => '%pre%lemon_uc_login_record',
            'info'          => array(
                'ID'            => array('lr_ID', 'integer', '', 0),
                'LUID'          => array('lr_LUID', 'integer', '', 0), // LemonUser ID
                'Type'          => array('lr_Type', 'integer', '', 0), // 登录方式 0:账号密码 | 1000:QQ | 1001:WeChat | 1002:Weibo
                'IPv4'          => array('lr_IPv4', 'string', 50, ''), // IPv4
                'IPv6'          => array('lr_IPv6', 'string', 50, ''), // IPv6
                'City'          => array('lr_City', 'string', 255, ''), // 城市
                'Province'      => array('lr_Province', 'string', 255, ''), // 省份
                'Country'       => array('lr_Country', 'string', 255, ''), // 国家
                'Token'         => array('lr_Token', 'string', 255, ''), // token
                'Count'         => array('lr_Count', 'integer', '', 0), // 登录次数
                'CreateTime'    => array('lr_CreateTime', 'integer', 'bigint', 0), // 创建时间
                'Meta'          => array('lr_Meta', 'string', '', ''),
            ),
        ),
        /**
         * 积分记录表
         */
        'PointRecord' => array(
            'name'          => '%pre%lemon_uc_point_record',
            'info'          => array(
                'ID'            => array('pr_ID', 'integer', '', 0),
                'LUID'          => array('pr_LUID', 'integer', '', 0),
                'Type'          => array('pr_Type', 'integer', 'tinyint', 0), // 类型 0 获得 1 消耗
                'Value'         => array('pr_Value', 'integer', '', 0), // 操作积分
                'Count'         => array('pr_Count', 'integer', '', 0), // 操作后总分
                'Note'          => array('pr_Note', 'string', 255, ''), // 操作备注
                'CreateTime'    => array('pr_CreateTime', 'integer', 'bigint', 0), // 操作时间
                'Meta'          => array('pr_Meta', 'string', '', ''),
            ),
        ),
        /**
         * 会员记录表
         */
        'VIPRecord' => array(
            'name'          => '%pre%lemon_uc_vip_record',
            'info'          => array(
                'ID'            => array('vr_ID', 'integer', '', 0),
                'LUID'          => array('vr_LUID', 'integer', '', 0),
                'Value'         => array('vr_Value', 'integer', '', 0), // 操作时长 - 天数
                'EndTime'       => array('vr_EndTime', 'integer', 'bigint', 0), // 操作后到期时间
                'Note'          => array('vr_Note', 'string', 255, ''), // 操作备注
                'Channel'       => array('vr_Channel', 'integer', '', 0), // 渠道 0:系统赠予 1:兑换码 2:积分
                'CreateTime'    => array('vr_CreateTime', 'integer', 'bigint', 0), // 操作时间
                'Meta'          => array('vr_Meta', 'string', '', ''),
            ),
        ),
        /**
         * 收藏表
         */
        'Collect' => array(
            'name'          => '%pre%lemon_uc_collect',
            'info'          => array(
                'ID'            => array('cc_ID', 'integer', '', 0),
                'LUID'          => array('cc_LUID', 'integer', '', 0),
                'LogID'         => array('cc_LogID', 'integer', '', 0), // 文章ID
                'ArtID'         => array('cc_ArtID', 'integer', '', 0), // 文章拓展ID
                'CreateTime'    => array('cc_CreateTime', 'integer', 'bigint', 0), // 收藏时间
                'Meta'          => array('cc_Meta', 'string', '', ''),
            ),
        ),
        /**
         * 点赞表
         */
        'Like' => array(
            'name'          => '%pre%lemon_uc_like',
            'info'          => array(
                'ID'            => array('lk_ID', 'integer', '', 0),
                'LUID'          => array('lk_LUID', 'integer', '', 0),
                'LogID'         => array('lk_LogID', 'integer', '', 0), // 文章ID
                'ArtID'         => array('lk_ArtID', 'integer', '', 0), // 文章拓展ID
                'CreateTime'    => array('lk_CreateTime', 'integer', 'bigint', 0), // 点赞时间
                'Meta'          => array('lk_Meta', 'string', '', ''),
            ),
        ),
        /**
         * 关注表
         */
        'Follow' => array(
            'name'          => '%pre%lemon_uc_follow',
            'info'          => array(
                'ID'            => array('fl_ID', 'integer', '', 0),
                'LUID'          => array('fl_LUID', 'integer', '', 0),
                'FUID'          => array('fl_FUID', 'integer', '', 0), // 关注用户ID 
                'Mutual'        => array('fl_Mutual', 'integer', 'tinyint', 0), // 是否相互关注
                'CreateTime'    => array('fl_CreateTime', 'integer', 'bigint', 0), // 关注时间
                'Meta'          => array('fl_Meta', 'string', '', ''),
            ),
        ),
        /**
         * 消息列表
         */
        'MSGList' => array(
            'name'          => '%pre%lemon_uc_msgs',
            'info'          => array(
                'ID'            => array('ml_ID', 'integer', '', 0),
                'Status'        => array('ml_Status', 'integer', 'tinyint', 0),
                'FromLUID'      => array('ml_FromLUID', 'integer', '', 0),
                'ToLUID'        => array('ml_ToLUID', 'integer', '', 0),
                'ContID'        => array('ml_ContID', 'integer', '', 0),
                'DeleteFlag'    => array('ml_DeleteFlag', 'integer', '', 0),
                'CreateTime'    => array('ml_CreateTime', 'integer', 'bigint', 0),
                'Meta'          => array('ml_Meta', 'string', '', ''),
            ),
        ),
        /**
         * 消息内容列表
         */
        'MSGContent' => array(
            'name'          => '%pre%lemon_uc_msg_content',
            'info'          => array(
                'ID'            => array('mc_ID', 'integer', '', 0),
                'Title'         => array('mc_Title', 'string', 255, ''),
                'Content'       => array('mc_Content', 'string', '', ''),
                'Meta'          => array('mc_Meta', 'string', '', ''),
            ),
        ),
    );

    foreach ($tables as $k => $v) {
        $table[$k] = $v['name'];
        $tableInfo[$k] = $v['info'];
    }

    return $tables;
}

/**
 * 检查是否有创建数据库
 */
function createTable() {
    global $zbp;

    $tables = defineTable();

    foreach ($tables as $k => $v) {
        if (!$zbp->db->ExistTable($v['name'])) {
            $s = $zbp->db->sql->CreateTable($v['name'], $v['info']);
            $s = str_replace('=utf8', '=utf8mb4 COLLATE=utf8mb4_unicode_ci', $s);
            $zbp->db->QueryMulit($s);
        }
    }
}
