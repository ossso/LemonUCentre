<?php include '../gfw.php'; ?>
<div class="uc-side">
    <div class="uc-userinfo-group">
        <div class="bg-block"></div>
        <div class="user-avatar" title="{$user.StaticName}">
            <img data-key="avatar" src="{$user.Avatar}" alt="{$user.StaticName}" />
        </div>
        {if $user.LemonUC.VIP}
        {template:icon/vip-icon}
        {/if}
        <div class="user-nickname" title="{$user.StaticName}">{$user.StaticName}</div>
        <div class="user-points">
            <div class="points-group" title="{$user.LemonUC.Points} {$lemon_uc.PointsName}">
                {template:icon/points-icon}
                <span class="points-value">{$user.LemonUC.Points}</span>
            </div>
        </div>
    </div>
    {if $zbp.Config('LemonUCentre').checkinMode != 'off' && $zbp.Config('LemonUCentre').checkinMode != ''}
    <div class="user-check-in">
        {if $user.LemonUC.CheckInToday}
        <p>今天已完成签到，明天签到可获得 {$user.LemonUC.CheckInPointsByTomorrow} {$lemon_uc.PointsName}</p>
        <button class="check-in">已签到{$user.LemonUC.CheckInCount}天</button>
        {else}
        <p>今天还没有签到，马上签到可获得 {$user.LemonUC.CheckInPointsByToday} {$lemon_uc.PointsName}</p>
        <button class="check-in active user-check-in-btn" data-url="{$lemon_uc.apis.checkin}">马上签到</button>
        {/if}
    </div>
    {/if}
    <ul class="side-menu">
        {foreach $sides as $item}
        {php}
            $activeClassName = '';
            $nowType = 'lemon-uc-' . $item['type'];
            if ($nowType == $type) {
                $activeClassName = 'active';
            }
        {/php}
        <li class="{$activeClassName}">
            <a href="{$item['url']}" class="side-menu-item" title="{$item['name']}">
                <span class="menu-item-icon">
                    <span class="{$item['icon']}"></span>
                </span>
                <span class="menu-item-name">{$item['name']}</span>
                <span class="menu-item-arrow">
                    <span class="ant ant-right"></span>
                </span>
            </a>
        </li>
        {/foreach}
    </ul>
</div>
