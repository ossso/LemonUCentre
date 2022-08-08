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
                <h2>评论列表</h2>
            </div>
            <div class="uc-comment-list list-container">
                {if count($comments) > 0}
                <div class="list">
                    {foreach $comments as $comment}
                    <a class="list-item" href="{$comment.Post.Url}#cmt={$comment.ID}" target="_blank">
                        <p class="article-info">
                            <span>在《</span>
                            <span class="article-title">{$comment.Post.Title}</span>
                            <span>》中评论</span>
                        </p>
                        <p class="comment-content">“{$comment.Content}”</p>
                        <span class="post-date">发表于{$comment.Time('Y/m/d H:i')}</span>
                    </a>
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
