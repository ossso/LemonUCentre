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
                <h2>文章收藏列表</h2>
            </div>
            <div class="uc-article-list list-container">
                {if count($collects) > 0}
                <div class="list">
                    {foreach $collects as $collect}
                    <div class="list-item">
                        <div class="article-info">
                            <a href="{$collect.Post.Category.Url}" class="article-cate">{$collect.Post.Category.Name}</a>
                            <span class="split-dot">·</span>
                            <a href="{$collect.Post.Author.Url}" class="article-author">{$collect.Post.Author.LemonUC.Nickname}</a>
                            <span class="split-dot">·</span>
                            <span class="article-post-date">{$collect.Post.Time('Y/m/d H:i')}</span>
                        </div>
                        <div class="article-title">
                            <a href="{$collect.Post.Url}" target="_blank">{$collect.Post.Title}</a>
                        </div>
                        <div class="article-data">
                            <span class="data-item article-view-item" title="有{$collect.Post.ViewNums}次阅读">
                                <span class="icon ant ant-eye"></span>
                                <span class="value">{$collect.Post.ViewNums}</span>
                            </span>
                            <span class="split-dot">·</span>
                            <span class="data-item article-cmt-item" title="有{$collect.Post.CommNums}条评论">
                                <span class="icon ant ant-comment"></span>
                                <span class="value">{$collect.Post.CommNums}</span>
                            </span>
                            <span class="split-dot">·</span>
                            <span class="data-item article-like-item" title="有{$collect.Post.LikeCount}人点赞">
                                <span class="icon ant ant-like"></span>
                                <span class="value">{$collect.Post.LikeCount}</span>
                            </span>
                        </div>
                    </div>
                    {/foreach}
                </div>
                {template:uc/pagebar}
                {/if}
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
