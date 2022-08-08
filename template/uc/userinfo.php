<?php include '../gfw.php'; ?>
<!DOCTYPE html>
<html>
<head>
{template:common/head}
</head>
<body class="uc-body">
    {template:uc/header}
    <div class="uc-container">
        {template:uc/side}
        <div class="uc-main">
            <div class="uc-main-head">
                <h2>{$title}</h2>
            </div>
            <div class="uc-setting">
                <div class="uc-setting-form">
                    <div class="user-avatar-group">
                        <img class="avatar" data-key="avatar" src="{$user.LemonUC.Avatar}" alt="{$user.LemonUC.Nickname}" />
                        <span class="update-btn" data-command="upload-avatar">更换头像</span>
                    </div>
                    <div class="form-item">
                        <span class="form-item-name">
                            <span>昵称</span>
                        </span>
                        <div class="form-item-value">
                            <span class="form-item-info nickname-info">{$user.LemonUC.Nickname}</span>
                            <span class="edit-btn" data-command="update-userinfo">修改</span>
                        </div>
                    </div>
                    <div class="form-item">
                        <span class="form-item-name">
                            <span>性别</span>
                        </span>
                        <div class="form-item-value">
                            <span class="form-item-info">{$user.LemonUC.GenderName}</span>
                            <span class="edit-btn" data-command="update-userinfo">修改</span>
                        </div>
                    </div>
                    <div class="form-item">
                        <span class="form-item-name">
                            <span>年龄</span>
                        </span>
                        <div class="form-item-value">
                            {if $user.LemonUC.Age > 0}
                            <span class="form-item-info">{$user.LemonUC.Age}</span>
                            {else}
                            <span class="form-item-info null-info">未填写</span>
                            {/if}
                            <span class="edit-btn" data-command="update-userinfo">修改</span>
                        </div>
                    </div>
                    <div class="form-item">
                        <span class="form-item-name">
                            <span>手机</span>
                        </span>
                        <div class="form-item-value">
                            {if $user.LemonUC.MobileCheck}
                            <span class="form-item-info">{$user.LemonUC.Mobile}</span>
                            <span class="edit-btn" data-command="bind-mobile">更换</span>
                            {else}
                            <span class="form-item-info null-info">未绑定</span>
                            <span class="edit-btn visible" data-command="bind-mobile">绑定</span>
                            {/if}
                        </div>
                    </div>
                    <div class="form-item">
                        <span class="form-item-name">
                            <span>邮箱</span>
                        </span>
                        <div class="form-item-value">
                            {if $user.LemonUC.EmailCheck}
                            <span class="form-item-info">{$user.LemonUC.Email}</span>
                            <span class="edit-btn" data-command="bind-email">更换</span>
                            {elseif $user.LemonUC.Email}
                            <span class="form-item-info null-info">(未验证)&nbsp;</span>
                            <span class="form-item-info">{$user.LemonUC.Email}</span>
                            <span class="edit-btn visible" data-command="verify-email">验证</span>
                            {else}
                            <span class="form-item-info null-info">未绑定</span>
                            <span class="edit-btn visible" data-command="bind-email">绑定</span>
                            {/if}
                        </div>
                    </div>
                    {if $zbp.Config('LemonUCentre').regUserInvitationCode}
                    <div class="form-item">
                        <span class="form-item-name">
                            <span>邀请码</span>
                        </span>
                        <div class="form-item-value">
                            <span class="form-item-info"
                                data-copy="{$user.LemonUC.InvitationCode}"
                                title="点击复制邀请码">
                                {$user.LemonUC.InvitationCode}
                            </span>
                        </div>
                    </div>
                    {/if}
                    <div class="form-item">
                        <span class="form-item-name">
                            <span>密码</span>
                        </span>
                        <div class="form-item-value">
                            <span class="edit-btn visible" data-command="update-password">更改</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {template:common/footer}
    {template:common/script}
    <script>
    !function() {
        var lmFront = new $$LemonUCentreFront();
        lmFront.init();
    }();
    </script>
    <script>
    !function () {
        window.iframeUrls = {
            'upload-avatar': '{$lemon_uc.pages.uploadAvatar}',
            'update-userinfo': '{$lemon_uc.pages.updateUserinfo}',
            'update-password': '{$lemon_uc.pages.updatePassword}',
        };
    }();
    </script>
    <script src="{$lemon_uc.jspath}uc-userinfo.js"></script>
</body>
</html>
