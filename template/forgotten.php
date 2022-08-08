<?php include 'gfw.php'; ?>
<!DOCTYPE html>
<html>
<head>
{template:common/head}
</head>
<body class="forgotten-body">
    <div class="forgotten-main">
        <h2 class="title">忘记密码</h2>
        {template:components/forgotten-form}
        <div class="forgotten-options">
            <a href="{$lemon_uc.pages.login}" class="option-item login-item">用户登录</a>
            <a href="{$lemon_uc.pages.reg}" class="option-item reg-item" target="_blank">注册账号</a>
        </div>
    </div>
    {template:common/footer}
    {template:common/script}
    <script>
    !function() {
        var lmFront = new $$LemonUCentreFront();
        lmFront.init({
            form: '.forgotten-main form',
            success: function(formElem) {
                this.msg('找回成功');
                var a = function() {
                    var loginUrl = '{$lemon_uc.pages.login}';
                    if (loginUrl.length > 0) {
                        window.location.href = loginUrl;
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
