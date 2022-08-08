<?php include '../gfw.php'; ?>
<form action="{$formURL}" class="login-form" onsubmit="return false;">
    <input type="hidden" data-url value="{$lemon_uc.pages.mine}" />
    <label class="login-form-item form-item">
        <span class="login-form-item-label">邮<span style="display: inline-block;width: 1em;height: 1;"></span>箱</span>
        <input type="text" class="form-item-input" name="email" placeholder="邮箱地址" />
    </label>
    <label class="login-form-item form-item">
        <span class="login-form-item-label">验证码</span>
        <input type="text" class="form-item-input" name="emailValidcode" placeholder="邮件验证码" />
        <span class="send-validcode email-validcode" data-url="{$lemon_uc.apis.emailCodeByReged}">发送验证码</span>
    </label>
    <div class="login-form-btn">
        <button type="submit" class="submit-btn">登录</button>
    </div>
</form>
