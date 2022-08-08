<?php include '../gfw.php'; ?>
<div class="ucenter-header">
    <div class="header-container">
        <h1 class="logo-name">
            <a href="{$host}">{$name}</a>
        </h1>
        <div class="header-content">
            <a href="{$host}zb_system/cmd.php?act=admin"
                class="dashboard-mode icon-mode"
                title="网站后台">
                <span class="ant ant-dashboard"></span>
            </a>
            <a href="#" class="bell-mode icon-mode">
                <span class="ant ant-bell"></span>
                <span class="bell-tips"></span>
            </a>
            <div class="header-userinfo-group">
                <a href="{$lemon_uc.pages.mine}" class="user-avatar">
                    <img data-key="avatar" src="{$user.Avatar}" alt="{$user.StaticName}" />
                </a>
                <div class="userinfo-drawer">
                    <a href="{$lemon_uc.pages.mine}" class="drawer-item nickname-item">
                        <span class="nickname">{$user.StaticName}</span>
                        {if $user.LemonUC.VIP}
                        {template:icon/vip-icon}
                        {/if}
                    </a>
                    <a href="{BuildSafeCmdURL('act=logout')}" class="drawer-item logout-item">退出登录</a>
                </div>
            </div>
        </div>
    </div>
</div>
