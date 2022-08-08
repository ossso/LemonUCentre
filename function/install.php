<?php
/**
 * 安装插件时执行方法
 */

namespace LemonUCentre;

use LemonUCentre\Models\User;
use LemonUCentre\Models\RedeemType;

/**
 * 激活相关插件
 */
function activeRelatedPlugin()
{
    global $zbp;
    $relationPlugin = array(
        array('LemonTemplate', '模板插件 - Lemon系列'),
    );
    $plugins = $zbp->option['ZC_USING_PLUGIN_LIST'];
    foreach ($relationPlugin as $item) {
        $name = $item[0];
        if (!\HasNameInString($plugins, $name)) {
            $app = $zbp->LoadApp('plugin', $name);
            if ($app->id == $name) {
                \EnablePlugin($name);
            } else {
                $zbp->SetHint('bad', '请安装并启用插件“' . $item[1] . '” - ID:' . $item[0]);
            }
        }
    }
}

/**
 * 默认配置
 */
function defaultConfig()
{
    global $zbp;
    if ($zbp->Config('LemonUCentre')->HasKey('version')) {
        $zbp->DelConfig('LemonUCentre');
        $zbp->DelConfig('LemonUCentreLibsBySMS');
        $zbp->DelConfig('LemonUCentreLibsByEmail');
    }
    $zbp->Config('LemonUCentre')->version = '1.0';
    $zbp->Config('LemonUCentre')->template = array(
        array('LemonUCentre', 'LemonUCentre', 'plugin', 'template'),
        array('LemonUCentreAdmin', 'LemonUCentre', 'plugin', 'template_admin'),
    );
    $zbp->Config('LemonUCentre')->routerType = 'ACTIVE';
    $zbp->Config('LemonUCentre')->routeName = 'LemonUCentre';
    $zbp->Config('LemonUCentre')->regType = '0';

    $zbp->Config('LemonUCentre')->nicknameBlackList = '管理员|admin|站长';
    $zbp->SaveConfig('LemonUCentre');
}

/**
 * 创建默认数据
 */
function createDefaultData()
{
    /**
     * 创建兑换码兑换类型
     */
    $redeemTypeList = array(
        array(
            'Name'      => '兑换积分',
            'Code'      => 'LemonUCentre2Points',
            'Symbol'    => '积分',
            'Remark'    => '可直接兑换LemonUCentre的积分',
            'Lock'      => '1',
            'Order'     => '101000',
        ),
        array(
            'Name'      => '兑换会员',
            'Code'      => 'LemonUCentre2VIP',
            'Symbol'    => '天',
            'Remark'    => '可直接兑换LemonUCentre的会员',
            'Lock'      => '1',
            'Order'     => '100999',
        ),
    );
    foreach ($redeemTypeList as $item) {
        $type = new RedeemType();
        $type->LoadInfoByCode($item['Code']);
        if ($type->ID == 0) {
            foreach ($item as $key => $val) {
                $type->$key = $val;
            }
            $type->Save();
        }
    }
}
