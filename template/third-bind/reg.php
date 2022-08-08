<?php include '../gfw.php'; ?>
<!DOCTYPE html>
<html>
<head>
{template:common/head}
</head>
<body class="reg-body">
    <div class="reg-main">
        <h2 class="title">{$title}</h2>
        {$regType=$zbp.Config('LemonUCentre').regType}
        {if $regType == '0'}
        {template:components/reg-form-by-quick}
        {elseif $regType == '1'}
        {template:components/reg-form-by-email-1}
        {elseif $regType == '2'}
        {template:components/reg-form-by-email-2}
        {elseif $regType == '3'}
        {template:components/reg-form-by-phone}
        {/if}
        <div class="reg-options">
            <a href="{$lemon_uc.pages.bindLogin}" class="option-item login-item">用户登录</a>
        </div>
    </div>
    {template:common/footer}
    {template:common/script}
    <script>
    !function() {
        var lmFront = new $$LemonUCentreFront();
        lmFront.init({
            form: '.reg-main form',
            success: function(formElem) {
                this.msg('注册成功');
                var a = function() {
                    var ucenter = '';
                    if (ucenter.length > 0) {
                        window.location.href = ucenter;
                    } else if (this.data.returnUrl.length > 0) {
                        window.location.href = this.data.returnUrl;
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
