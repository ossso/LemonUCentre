<?php
/**
 * LemonUCentre
 * Lemon系列插件：用户中心
 */

include_once __DIR__ . '/App/index.php';
include_once __DIR__ . '/Function/index.php';

/**
 * 注册插件
 */
RegisterPlugin('LemonUCentre', 'ActivePlugin_LemonUCentre');

/**
 * 激活插件工具
 */
function ActivePlugin_LemonUCentre()
{
    global $zbp, $actions;
    $actions['lemon-uc-admin-api'] = '1';
    $actions['lemon-uc-api'] = '6';
    $actions['lemon-uc-page'] = '6';
	Add_Filter_Plugin('Filter_Plugin_Admin_TopMenu', 'LemonUCentre_Plugin_Admin_TopMenu');
    Add_Filter_Plugin('Filter_Plugin_Cmd_Begin', 'LemonUCentre_Plugin_Cmd_Begin');
	// Add_Filter_Plugin('Filter_Plugin_Misc_Begin', 'LemonUCentre_Plugin_Misc_Begin');
    // Add_Filter_Plugin('Filter_Plugin_ViewIndex_Begin', 'LemonUCentre_Plugin_ViewIndex_Begin');
    // Add_Filter_Plugin('Filter_Plugin_ViewAuto_Begin', 'LemonUCentre_Plugin_ViewAuto_Begin');
    Add_Filter_Plugin('Filter_Plugin_Member_Get', 'LemonUCentre_Plugin_Member_Get');
    // Add_Filter_Plugin('Filter_Plugin_Member_Avatar', 'LemonUCentre_Plugin_Member_Avatar');
    // Add_Filter_Plugin('Filter_Plugin_Post_Get', 'LemonUCentre_Plugin_Post_Get');
    // Add_Filter_Plugin('Filter_Plugin_ViewPost_Template', 'LemonUCentre_Plugin_ViewPost_Template');
}

/**
 * 安装插件执行内容
 */
function InstallPlugin_LemonUCentre()
{
    global $zbp;
    // 创建数据库
    LemonUCentre\createTable();
    // 创建默认数据
    LemonUCentre\createDefaultData();
    // 设定默认配置
    if (!$zbp->Config('LemonUCentre')->HasKey('version')) {
        LemonUCentre\defaultConfig();
    }
    // 激活关联插件
    LemonUCentre\activeRelatedPlugin();
    // 挂载其它的插件接口
    LemonUCentre\mount_plugin();
    // 创建模块
    // LemonUCentre\Method\create_module();
}

/**
 * 卸载插件执行内容
 */
function UninstallPlugin_LemonUCentre()
{
    LemonUCentre\unmount_plugin();
    // 删除模块
    // LemonUCentre\Method\delete_module();
}

/**
 * 后台顶部添加菜单入口
 */
function LemonUCentre_Plugin_Admin_TopMenu(&$menu)
{
    global $zbp;
    $menu[] = MakeTopMenu('root', '用户中心配置', $zbp->host . 'main.php', '', '');
}

/**
 * CMD_BEGIN 挂入访问监听
 */
function LemonUCentre_Plugin_Cmd_Begin()
{
    global $zbp, $lemon_uc;

    $zbp->template->SetTags('lemon_uc', $lemon_uc);

    $action = GetVars('act', 'GET');
    if ($action == 'lemon-uc-api') {
        // $type = GetVars('type', 'GET');
    } elseif ($action == 'lemon-uc-admin-api') {
        $admin = new LemonUCentre\Controllers\AdminController();
        $admin->init();
    } elseif ($action == 'lemon-uc-page') {
        // LemonUCentre\Method\CheckUserVIPDate();
        // $type = GetVars('type', 'GET');
        // $view = new LemonUCentre\View();
        // $view->init($type);
    }
}

/**
 * misc相关内容
 */
function LemonUCentre_Plugin_Misc_Begin() {
    LemonUCentre\Method\create_module();
}

/**
 * ViewIndex 对前台挂入变量
 */
function LemonUCentre_Plugin_ViewIndex_Begin()
{
    global $zbp, $lemon_uc;
    // LemonUCentre\Method\CheckUserVIPDate();
    $zbp->template->SetTags('lemon_uc', $lemon_uc);
}

/**
 * ViewAuto 处理路由
 */
function LemonUCentre_Plugin_ViewAuto_Begin($url)
{
    global $zbp;
    $status = LemonUCentre\view_auto($url);
    if ($status) {
        $GLOBALS['hooks']['Filter_Plugin_ViewAuto_Begin']['LemonUCentre_Plugin_ViewAuto_Begin'] = 'return';
    }
}

/**
 * 监听Member中的GET方法
 */
function LemonUCentre_Plugin_Member_Get($mem, $name)
{
    global $zbp, $lemon_uc;

    $ret = null;

    switch ($name) {
        case 'LemonUser':
            $lemonUser = $lemon_uc->GetUserByUID($mem->ID);
            if ($lemonUser->ID == 0 && $mem->ID > 0) {
                $lemonUser->UID = $mem->ID;
                $lemonUser->Save();
            }
            $ret = $lemonUser;
        break;
        default:
    }

    if (isset($ret)) {
        $GLOBALS['hooks']['Filter_Plugin_Member_Get']['LemonUCentre_Plugin_Member_Get'] = 'return';
    }
    return $ret;
}

/**
 * 输出头像
 */
function LemonUCentre_Plugin_Member_Avatar($mem)
{
    global $zbp, $lemon_uc;
    $lemonUser = $lemon_uc->GetUserByUID($mem->ID);
    if ($lemonUser->ID == 0 && $mem->ID > 0) {
        $lemonUser->UID = $mem->ID;
        $lemonUser->Save();
    }
    if (!empty($lemonUser->AvatarUrl)) {
        $GLOBALS['hooks']['Filter_Plugin_Member_Avatar']['LemonUCentre_Plugin_Member_Avatar'] = 'return';
        return $mem->LemonUC->AvatarUrl;
    }
}

/**
 * 监听Post中的GET方法
 */
function LemonUCentre_Plugin_Post_Get($post, $name)
{
    global $zbp, $lemon_uc, $hooks;
    $ret = null;
    switch ($name) {
        case 'LemonArticle':
            $lemonArticle = $lemon_uc->GetArticleByLogID($post->ID);
            if ($lemonArticle->ID == 0) {
                $lemonArticle->LogID = $post->ID;
                $lemonArticle->Save();
            }
            $ret = $lemonArticle;
        break;
        case 'CollectCount':
            $lemonArticle = $lemon_uc->GetArticleByLogID($post->ID);
            if ($lemonArticle->ID == 0) {
                $lemonArticle->LogID = $post->ID;
                $lemonArticle->Save();
            }
            $ret = $lemonArticle->CollectCount;
        break;
        case 'LikeCount':
            $lemonArticle = $lemon_uc->GetArticleByLogID($post->ID);
            if ($lemonArticle->ID == 0) {
                $lemonArticle->LogID = $post->ID;
                $lemonArticle->Save();
            }
            $ret = $lemonArticle->LikeCount;
        break;
        default:
    }
    if (isset($ret)) {
        $GLOBALS['hooks']['Filter_Plugin_Post_Get']['LemonUCentre_Plugin_Post_Get'] = 'return';
    }
    return $ret;
}

/**
 * 在文章页挂载内容
 */
function LemonUCentre_Plugin_ViewPost_Template()
{
    global $zbp;
    LemonUCentre\front_insert();

    $article = $zbp->template->templateTags['article'];
    LemonUCentre\article_insert($article);
}
