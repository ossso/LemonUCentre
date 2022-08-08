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
                <h2>我的{$lemon_uc.PointsName}</h2>
            </div>
            <div class="uc-points-page list-container">
                <div class="uc-points">
                    <div class="user-points-group" title="{$user.LemonUC.Points} {$lemon_uc.PointsName}">
                        <span>当前账户{$lemon_uc.PointsName}：</span>
                        <span class="points-value">{$user.LemonUC.Points}</span>
                    </div>
                </div>
                {if count($pointsRecordList) > 0}
                <h3>{$lemon_uc.PointsName}明细</h3>
                <table class="list">
                    <thead>
                        <tr>
                            <th>时间</th>
                            <th>操作</th>
                            <th>变动</th>
                            <th>余额</th>
                        </tr>
                    </thead>
                    <tbody>
                    {foreach $pointsRecordList as $item}
                        <tr class="list-item">
                            <td>{$item.Time('Y-m-d H:i:s')}</td>
                            <td>{$item.Note}</td>
                            <td>
                                <span class="type">{if $item.Type == 1}-{else}+{/if}</span>
                                <span class="value">{$item.Value}</span>
                            </td>
                            <td>{$item.Count}</td>
                        </tr>
                    {/foreach}
                    </tbody>
                </table>
                {/if}
                {template:uc/pagebar}
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
</body>
</html>
