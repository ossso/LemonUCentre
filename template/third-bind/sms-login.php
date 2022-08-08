<?php include '../gfw.php'; ?>
<!DOCTYPE html>
<html>
<head>
{template:common/head}
<link rel="stylesheet" href="{$lemon_uc.static}icon/sns-icon.css" />
</head>
<body class="login-body">
    <div class="login-main">
        <h2 class="title">{$title}</h2>
        {template:components/login-form-by-sms}
        <div class="login-options">
            {if $zbp.Config('LemonUCentre').loginByEmailCode == '1'}
            <a href="{$lemon_uc.pages.bindEmailLogin}" class="option-item login-item">邮件验证码登录</a>
            {/if}
            <a href="{$lemon_uc.pages.bindLogin}" class="option-item username-item">普通登录</a>
            <a href="{$lemon_uc.pages.bindReg}" class="option-item reg-item">注册账号</a>
        </div>
    </div>
    {template:common/footer}
    {template:common/script}
    <script>
    !function() {
        var lmFront = new $$LemonUCentreFront();
        lmFront.init({
            form: '.login-main form',
        });
    }();
    </script>
</body>
</html>
