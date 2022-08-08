<?php include 'gfw.php'; ?>
<!DOCTYPE html>
<html>
<head>
{template:common/head}
</head>
<body class="email-active">
    {if $active}
    <div class="email-success">
        <h3>激活成功！</h3>
        <p>{$userNickname}，您的邮箱<span class="email-value">{$userEmail}</span>已激活成功！</p>
        <a href="{$host}" class="to-home">前往网站首页 <span class="ant ant-right"></span></a>
    </div>
    {else}
    <div class="email-fail">
        <h3>链接已失效</h3>
        <p>该激活链接已失效或已成功激活邮箱</p>
        <a href="{$host}" class="to-home">前往网站首页 <span class="ant ant-right"></span></a>
    </div>
    {/if}
</body>
</html>
