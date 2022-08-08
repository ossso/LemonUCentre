<?php include '../gfw.php'; ?>
<!DOCTYPE html>
<html>
<head>
{template:common/head}
</head>
<body class="login-body">
    <div class="login-main">
        <h2 class="title">{$title}</h2>
        {$isRemember=false}
        {template:components/login-form}
        <div class="login-options">
            {if $zbp.Config('LemonUCentre').loginBySMSCode == '1'}
            <a href="{$lemon_uc.pages.bindSmsLogin}" class="option-item reg-item">短信验证码登录</a>
            {/if}
            {if $zbp.Config('LemonUCentre').loginByEmailCode == '1'}
            <a href="{$lemon_uc.pages.bindEmailLogin}" class="option-item reg-item">邮件验证码登录</a>
            {/if}
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
            success: function(formElem) {
                this.msg('绑定成功');
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
