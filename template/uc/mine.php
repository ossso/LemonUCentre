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
            <div class="mine-data">
                <div class="mine-data-item">
                    <h4 class="item-name">我的文章</h4>
                    <span class="item-value">{$user.Articles}</span>
                </div>
                <div class="mine-data-item">
                    <h4 class="item-name">收获点赞</h4>
                    <span class="item-value">{$user.LemonUC.LikeCount}</span>
                </div>
                <div class="mine-data-item">
                    <h4 class="item-name">总收藏数</h4>
                    <span class="item-value">{$user.LemonUC.CollectCount}</span>
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
</body>
</html>
