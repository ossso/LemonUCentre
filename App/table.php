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
                'ID'            => array('ID', 'integer', '', 0),
                'MemberID'      => array('MemberID', 'integer', '', 0, '用户ID'),
                'AvatarUrl'     => array('AvatarUrl', 'string', 256, '', '头像'),
                'Gender'        => array('Gender', 'integer', 'tinyint', 0, '性别 0未知 | 1男 | 2女'),
                'Age'           => array('Age', 'integer', 'tinyint', 0, '年龄'),
                'Phone'         => array('Phone', 'string', 20, '', '手机号码'),
                'Phoned'        => array('Phoned', 'integer', '', 0, '手机号码是否认证 时间戳'),
                'Email'         => array('Email', 'string', 256, '', '邮箱地址'),
                'Emailed'       => array('Emailed', 'integer', '', 0, '邮箱地址是否认证 时间戳'),
                'Code'          => array('Code', 'string', 10, '', '用户邀请码Code'),
                'Token'         => array('Token', 'string', 64, '', '最后登录Token'),
                'CollectNums'   => array('CollectNums', 'integer', '', 0, '被收藏总数'),
                'LikeNums'      => array('LikeNums', 'integer', '', 0, '被点赞总数'),
                'FansNums'      => array('FansNums', 'integer', '', 0, '粉丝总数'),
                'UpdateTime'    => array('UpdateTime', 'integer', 'bigint', 0, '最后活跃时间'),
                'City'          => array('City', 'string', 128, '', '城市'),
                'Province'      => array('Province', 'string', 128, '', '省份'),
                'Country'       => array('Country', 'string', 128, '', '国家'),
                'Meta'          => array('Meta', 'string', '', ''),
            ),
        ),
        /**
         * 关注记录表
         */
        'Follow' => array(
            'name'          => '%pre%lemon_uc_follow',
            'info'          => array(
                'ID'            => array('ID', 'integer', '', 0),
                'UID'           => array('UID', 'integer', '', 0, 'Lemon用户ID'),
                'FollowID'      => array('FollowID', 'integer', '', 0, '被关注Lemon用户ID'), 
                'CreateTime'    => array('CreateTime', 'integer', 'bigint', 0, '关注时间'),
                'Meta'          => array('Meta', 'string', '', ''),
            ),
        ),
        /**
         * 验证码
         */
        'Captcha' => array(
            'name'          => '%pre%lemon_uc_captcha',
            'info'          => array(
                'ID'            => array('ID', 'integer', '', 0),
                'UID'           => array('UID', 'integer', '', 0, '触发人Lemon用户ID'),
                'Type'          => array('Type', 'integer', 'tinyint', 0, '0手机号码 | 1邮箱地址'),
                'Status'        => array('Status', 'integer', 'tinyint', 0, '是否验证: 0 | 1'),
                'Code'          => array('Code', 'string', 32, '', '验证码'),
                'CreateTime'    => array('CreateTime', 'integer', 'bigint', 0, '创建时间'),
                'PassTime'      => array('PassTime', 'integer', 'bigint', 0, '验证时间'),
                'Meta'          => array('Meta', 'string', '', ''),
            ),
        ),
        /**
         * 登录记录日志
         */
        'SignIn' => array(
            'name'          => '%pre%lemon_uc_sign_in',
            'info'          => array(
                'ID'            => array('ID', 'integer', '', 0),
                'UID'           => array('UID', 'integer', '', 0, 'Lemon用户ID'),
                'Type'          => array('Type', 'integer', '', 0, '登录方式 0:账号密码 | 1000:QQ | 1001:WeChat | 1002:Weibo'),
                'IP'            => array('IP', 'string', 50, '', 'IP地址'),
                'Token'         => array('Token', 'string', 64, '', '本次登录的token'),
                'CreateTime'    => array('CreateTime', 'integer', 'bigint', 0, '创建时间'),
                'Meta'          => array('Meta', 'string', '', ''),
            ),
        ),
        /**
         * 签到表
         */
        'CheckIn' => array(
            'name'          => '%pre%lemon_uc_checkin',
            'info'          => array(
                'ID'            => array('ID', 'integer', '', 0),
                'UID'           => array('UID', 'integer', '', 0, 'Lemon用户ID'),
                'Count'         => array('Count', 'integer', '', 0, '签到天数'),
                'LastTime'      => array('LastTime', 'integer', 'bigint', 0, '最后签到时间'),
                'Meta'          => array('Meta', 'string', '', ''),
            ),
        ),
        /**
         * 签到日志表
         */
        'CheckInLogs' => array(
            'name'          => '%pre%lemon_uc_checkin_logs',
            'info'          => array(
                'ID'            => array('ID', 'integer', '', 0),
                'CheckInID'     => array('CheckInID', 'integer', '', 0, 'CheckIn表ID'),
                'UID'           => array('UID', 'integer', '', 0, 'Lemon用户ID'),
                'CreateTime'    => array('CreateTime', 'integer', 'bigint', 0, '签到时间'),
                'Meta'          => array('Meta', 'string', '', ''),
            ),
        ),
        /**
         * 社交账号绑定
         */
        'Social' => array(
            'name'          => '%pre%lemon_uc_social',
            'info'          => array(
                'ID'            => array('ID', 'integer', '', 0),
                'UID'           => array('UID', 'integer', '', 0, 'Lemon用户ID'),
                'Platform'      => array('Platform', 'integer', '', 0, '0:QQ | 1:WeChat | 2:Weibo'),
                'OpenID'        => array('OpenID', 'string', 256, '', '平台OPENID'),
                'UnionID'       => array('UnionID', 'string', 256, '', '平台UNIONID'),
                'Token'         => array('Token', 'string', 256, '', '通常是AccessToken'), 
                'Nickname'      => array('Nickname', 'string', 128, '', '昵称'),
                'Avatar'        => array('Avatar', 'string', 256, '', '头像地址'),
                'CreateTime'    => array('CreateTime', 'integer', 'bigint', 0, '创建时间'),
                'UpdateTime'    => array('UpdateTime', 'integer', 'bigint', 0, '更新时间'),
                'Meta'          => array('Meta', 'string', '', ''),
            ),
        ),
        /**
         * 邀请码
         */
        'InviteCode' => array(
            'name'          => '%pre%lemon_uc_invite_code',
            'info'          => array(
                'ID'            => array('ID', 'integer', '', 0),
                'UID'           => array('UID', 'integer', '', 0, 'Lemon用户ID'),
                'Code'          => array('Code', 'string', 20, '', '邀请码内容'),
                'Type'          => array('Type', 'integer', '', 0, '0:一次性邀请码、1:用户生成邀请码'),
                'Status'        => array('Status', 'integer', 'tinyint', 0, '邀请码状态'),
                'CreateTime'    => array('CreateTime', 'integer', 'bigint', 0, '创建时间'),
                'UseTime'       => array('UseTime', 'integer', 'bigint', 0, '使用时间'),
                'Meta'          => array('Meta', 'string', '', ''),
            ),
        ),
        /**
         * 兑换码产品
         */
        'RedeemCodeProduct' => array(
            'name'          => '%pre%lemon_uc_redeem_code_product',
            'info'          => array(
                'ID'            => array('ID', 'integer', '', 0),
                'Status'        => array('Status', 'integer', 'tinyint', 0, '状态'),
                'Name'          => array('Name', 'string', 50, '', '类型名称'),
                'Symbol'        => array('Symbol', 'string', 100, '', '兑换值计量单位'),
                'Content'       => array('Content', 'string', '', '', '类型说明'),
                'Meta'          => array('Meta', 'string', '', ''),
            ),
        ),
        /**
         * 兑换码
         */
        'RedeemCode' => array(
            'name'          => '%pre%lemon_uc_redeem_code',
            'info'          => array(
                'ID'            => array('ID', 'integer', '', 0),
                'Status'        => array('Status', 'integer', 'tinyint', 0, '状态'),
                'ProductID'     => array('ProductID', 'integer', '', 0, '类型ID'),
                'UID'           => array('UID', 'integer', '', 0, '创建的Lemon用户'),
                'UseUID'        => array('UseUID', 'integer', '', 0, '使用的Lemon用户'),
                'Value'         => array('Value', 'integer', '', 0, '兑换值'),
                'Code'          => array('Code', 'string', 256, '', '兑换码'),
                'CreateTime'    => array('CreateTime', 'integer', 'bigint', 0, '创建时间'),
                'UseTime'       => array('UseTime', 'integer', 'bigint', 0, '使用时间'),
                'Meta'          => array('Meta', 'string', '', ''),
            ),
        ),
        /**
         * 积分分类表
         */
        'PointCate' => array(
            'name'          => '%pre%lemon_uc_point_cate',
            'info'          => array(
                'ID'            => array('ID', 'integer', '', 0),
                'Status'        => array('Status', 'integer', 'tinyint', 0, '状态：0停用 1启用'),
                'Name'          => array('Name', 'string', 50, '', '积分名称'),
                'Level'         => array('Level', 'integer', '', 0, '积分级别'),
                'Icon'          => array('Icon', 'string', 256, '', '积分Icon图标'),
                'Logo'          => array('Logo', 'string', 256, '', '积分Logo图标'),
                'CreateTime'    => array('CreateTime', 'integer', 'bigint', 0, '操作时间'),
                'Content'       => array('Content', 'string', '', '', '积分说明'),
                'Meta'          => array('Meta', 'string', '', ''),
            ),
        ),
        /**
         * 积分记录表
         */
        'PointRecord' => array(
            'name'          => '%pre%lemon_uc_point_record',
            'info'          => array(
                'ID'            => array('ID', 'integer', '', 0),
                'UID'           => array('UID', 'integer', '', 0, 'Lemon用户ID'),
                'CateID'        => array('CateID', 'integer', '', 0, '积分类型'),
                'Value'         => array('Value', 'integer', '', 0, '积分总值'),
                'CreateTime'    => array('CreateTime', 'integer', 'bigint', 0, '操作时间'),
                'Remark'        => array('Remark', 'string', '', '', '备注'),
                'Meta'          => array('Meta', 'string', '', ''),
            ),
        ),
        /**
         * 积分日志表
         */
        'PointLogs' => array(
            'name'          => '%pre%lemon_uc_point_logs',
            'info'          => array(
                'ID'            => array('ID', 'integer', '', 0),
                'UID'           => array('UID', 'integer', '', 0, 'Lemon用户ID'),
                'Type'          => array('Type', 'integer', 'tinyint', 0, '类型：0获得 1消耗'),
                'CateID'        => array('CateID', 'integer', '', 0, '积分分类ID'),
                'Value'         => array('Value', 'integer', '', 0, '操作积分'),
                'Count'         => array('Count', 'integer', '', 0, '操作后总分'),
                'CreateTime'    => array('CreateTime', 'integer', 'bigint', 0, '操作时间'),
                'Remark'        => array('Remark', 'string', '', '', '操作备注'),
                'Meta'          => array('Meta', 'string', '', ''),
            ),
        ),
        /**
         * 会员类型表
         */
        'VIPCate' => array(
            'name'          => '%pre%lemon_uc_vip_cate',
            'info'          => array(
                'ID'            => array('ID', 'integer', '', 0),
                'Status'        => array('Status', 'integer', 'tinyint', 0, '状态：0停用 1启用'),
                'Name'          => array('Name', 'integer', '', 0, '会员类型名称'),
                'Level'         => array('Level', 'integer', '', 0, '会员类型所属等级'),
                'Icon'          => array('Icon', 'string', 256, '', '会员Icon图标'),
                'Logo'          => array('Logo', 'string', 256, '', '会员Logo图标'),
                'CreateTime'    => array('CreateTime', 'integer', 'bigint', 0, '操作时间'),
                'Content'       => array('Content', 'string', '', '', '会员类型说明'),
                'Meta'          => array('Meta', 'string', '', ''),
            ),
        ),
        /**
         * 奖励规则
         * 控制兑换码兑换内容
         * 控制积分兑换内容
         * 控制签到兑换内容
         */
        'AwardRule' => array(
            'name'          => '%pre%lemon_uc_award_rule',
            'info'          => array(
                'ID'            => array('ID', 'integer', '', 0),
                'Name'          => array('Name', 'string', 50, '', '规则名称'),
                'Status'        => array('Status', 'integer', 'tinyint', 0, '状态：0停用 1启用'),
                'Cate'          => array('Cate', 'integer', '', 0, '适用分类 0:签到 | 1:注册 | 2:兑换码 | 3:积分'),
                'Type'          => array('Type', 'integer', '', 0, '奖励类型 0:积分 | 1:会员 | 2:兑换码 | 3:邀请码 | 4:文章阅读权限 | 1000+自定义内容'),
                'Relation'      => array('Relation', 'integer', '', 0, '奖励类型关联值，涉及积分类型、会员类型、兑换码类型等'),
                'Value'         => array('Value', 'integer', '', 0, '奖励值，需要参考插件WiKi'),
                'Remark'        => array('Remark', 'string', 256, '', '备注'),
                'CreateTime'    => array('CreateTime', 'integer', 'bigint', 0, '创建时间'),
                'UpdateTime'    => array('UpdateTime', 'integer', 'bigint', 0, '操作时间'),
                'Meta'          => array('Meta', 'string', '', ''),
            ),
        ),
        /**
         * 奖励日志表
         */
        'AwardLogs' => array(
            'name'          => '%pre%lemon_uc_award_logs',
            'info'          => array(
                'ID'            => array('ID', 'integer', '', 0),
                'UID'           => array('UID', 'integer', '', 0, 'Lemon用户ID'),
                'RuleID'        => array('RuleID', 'integer', '', 0, '执行的规则ID'),
                'Status'        => array('Status', 'integer', 'tinyint', 0, '执行状态：0未执行 | 1执行成功 | 2执行失败'),
                'CreateTime'    => array('CreateTime', 'integer', 'bigint', 0, '创建时间'),
                'UpdateTime'    => array('UpdateTime', 'integer', 'bigint', 0, '操作时间'),
                'Remark'        => array('Remark', 'string', '', '', '操作备注'),
                'Meta'          => array('Meta', 'string', '', ''),
            ),
        ),
        /**
         * 文章拓展表
         */
        'Article' => array(
            'name'          => '%pre%lemon_uc_article',
            'info'          => array(
                'ID'            => array('ID', 'integer', '', 0),
                'LogID'         => array('LogID', 'integer', '', 0, '文章ID'),
                'Status'        => array('Status', 'integer', 'tinyint', 0, '状态'),
                'CollectNums'   => array('CollectNums', 'integer', '', 0, '收藏总数'),
                'LikeNums'      => array('LikeNums', 'integer', '', 0, '点赞总数'),
                'Meta'          => array('Meta', 'string', '', ''),
            ),
        ),
        /**
         * 收藏记录表
         */
        'Collect' => array(
            'name'          => '%pre%lemon_uc_collect',
            'info'          => array(
                'ID'            => array('ID', 'integer', '', 0),
                'UID'           => array('UID', 'integer', '', 0, '收藏人Lemon用户ID'),
                'LogID'         => array('LogID', 'integer', '', 0, '文章ID'),
                'ArtID'         => array('ArtID', 'integer', '', 0, '文章拓展ID'),
                'CreateTime'    => array('CreateTime', 'integer', 'bigint', 0, '收藏时间'),
                'Meta'          => array('Meta', 'string', '', ''),
            ),
        ),
        /**
         * 点赞记录表
         */
        'Like' => array(
            'name'          => '%pre%lemon_uc_like',
            'info'          => array(
                'ID'            => array('ID', 'integer', '', 0),
                'UID'           => array('UID', 'integer', '', 0, 'Lemon用户ID'),
                'LogID'         => array('LogID', 'integer', '', 0, '文章ID'),
                'ArtID'         => array('ArtID', 'integer', '', 0, '文章拓展ID'),
                'CreateTime'    => array('CreateTime', 'integer', 'bigint', 0, '点赞时间'),
                'Meta'          => array('Meta', 'string', '', ''),
            ),
        ),
        /**
         * 消息列表
         */
        'MSGList' => array(
            'name'          => '%pre%lemon_uc_msg_list',
            'info'          => array(
                'ID'            => array('ID', 'integer', '', 0),
                'Status'        => array('Status', 'integer', 'tinyint', 0, '消息状态'),
                'FromUID'       => array('FromUID', 'integer', '', 0, '发送消息的Lemon用户ID'),
                'ToUID'         => array('ToUID', 'integer', '', 0, '接收消息的Lemon用户ID'),
                'ContID'        => array('ContID', 'integer', '', 0, '消息内容ID'),
                'DeleteFlag'    => array('DeleteFlag', 'integer', 'tinyint', 0, '删除标记'),
                'CreateTime'    => array('CreateTime', 'integer', 'bigint', 0, '创建时间'),
                'Meta'          => array('Meta', 'string', '', ''),
            ),
        ),
        /**
         * 消息内容列表
         */
        'MSGContent' => array(
            'name'          => '%pre%lemon_uc_msg_content',
            'info'          => array(
                'ID'            => array('ID', 'integer', '', 0),
                'Title'         => array('Title', 'string', 256, '', '消息标题'),
                'Content'       => array('Content', 'string', '', '', '消息内容'),
                'Meta'          => array('Meta', 'string', '', ''),
            ),
        ),
        /**
         * 统计表
         */
        'Statistics'    => array(
            'name'          => '%pre%lemon_uc_statistics',
            'info'          => array(
                'ID'            => array('ID', 'integer', '', 0),
                'Date'          => array('Date', 'integer', 'bigint', 0, '记录日期开始时间戳'),
                'RegCount'      => array('RegCount', 'integer', '', 0, '注册数'),
                'LoginCount'    => array('LoginCount', 'integer', '', 0, '登录数'),
                'VIPCount'      => array('VIPCount', 'integer', '', 0, 'VIP总数'),
                'VIPLoginCount' => array('VIPLoginCount', 'integer', '', 0, 'VIP登录总数'),
                'CollectCount'  => array('CollectCount', 'integer', '', 0, '收藏总数'),
                'LikeCount'     => array('LikeCount', 'integer', '', 0, '点赞总数'),
                'Meta'          => array('Meta', 'string', '', ''),
            ),
        ),
        /**
         * 插件功能配置
         */
        'Config'    => array(
            'name'          => '%pre%lemon_uc_config',
            'info'          => array(
                'ID'            => array('ID', 'integer', '', 0),
                'Type'          => array('Type', 'string', 50, ''),
                'Content'       => array('Content', 'string', '', ''),
            ),
        ),
    );

    foreach ($tables as $k => $v) {
        $table['LemonUCentre' . $k] = $v['name'];
        $tableInfo['LemonUCentre' . $k] = $v['info'];
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
            $zbp->db->QueryMulit($s);
        }
    }
}
