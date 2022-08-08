<?php include 'gfw.php'; ?>
<!DOCTYPE html>
<html>
<head>
{template:common/head}
<link rel="stylesheet" href="{$lemon_uc.static}icon/sns-icon.css" />
</head>
<body class="login-body">
    <div class="login-main">
        <h2 class="title">{$title}</h2>
        {$isRemember=true}
        {template:components/login-form}
        {if $zbp.Config('LemonUCentre').loginBySMSCode == '1' && $zbp.Config('LemonUCentre').loginByEmailCode == '1'}
        <div class="login-options">
            <a href="{$lemon_uc.pages.smsLogin}" class="option-item reg-item">短信验证码登录</a>
            <a href="{$lemon_uc.pages.emailLogin}" class="option-item reg-item">邮件验证码登录</a>
        </div>
        <div class="login-options">
            <a href="{$lemon_uc.pages.forgotten}" class="option-item forgotten-item" target="_blank">忘记密码</a>
            <a href="{$lemon_uc.pages.reg}" class="option-item reg-item" target="_blank">注册账号</a>
        </div>
        {else}
        <div class="login-options">
            {if $zbp.Config('LemonUCentre').loginBySMSCode == '1'}
            <a href="{$lemon_uc.pages.smsLogin}" class="option-item reg-item">短信验证码登录</a>
            {/if}
            {if $zbp.Config('LemonUCentre').loginByEmailCode == '1'}
            <a href="{$lemon_uc.pages.emailLogin}" class="option-item reg-item">邮件验证码登录</a>
            {/if}
            <a href="{$lemon_uc.pages.forgotten}" class="option-item forgotten-item">忘记密码</a>
            <a href="{$lemon_uc.pages.reg}" class="option-item reg-item" target="_blank">注册账号</a>
        </div>
        {/if}
        <div class="third-group">
            <span class="third-item third-qq" title="QQ登录">
                <span class="si si-qq"></span>
            </span>
            <span class="third-item third-wechat" title="微信登录">
                <span class="si si-wechat"></span>
            </span>
            <span class="third-item third-weibo" title="微博登录">
                <span class="si si-weibo"></span>
            </span>
        </div>
    </div>
    {template:common/footer}
    {template:common/script}
    <script>
    !function() {
        var lmFront = new $$LemonUCentreFront();
        lmFront.init({
            form: '.login-main form',
            success: function(formElem) {
                this.msg('登录成功');
                var a = function() {
                    var ucenter = '';
                    if (this.data.returnUrl.length > 0) {
                        window.location.href = this.data.returnUrl;
                    } else if (ucenter.length > 0) {
                        window.location.href = ucenter;
                    } else {
                        window.location.href = formElem.querySelector('input[data-url]').value;
                    }
                };
                setTimeout(a.call(this), 2000);
            },
        });
    }();
    </script>
</body>
</html>
