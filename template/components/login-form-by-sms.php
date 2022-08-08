<?php include '../gfw.php'; ?>
<form action="{$formURL}" class="login-form" onsubmit="return false;">
    <input type="hidden" data-url value="{$lemon_uc.pages.mine}" />
    <label class="login-form-item form-item">
        <span class="login-form-item-label">手机号</span>
        <input type="text" class="form-item-input" name="phone" placeholder="手机号码" />
    </label>
    <label class="login-form-item form-item">
        <span class="login-form-item-label">验证码</span>
        <input type="text" class="form-item-input" name="phoneValidcode" placeholder="短信验证码" />
        <span class="send-validcode phone-validcode" data-url="{$lemon_uc.apis.phoneCodeByReged}">发送验证码</span>
    </label>
    <div class="login-form-btn">
        <button type="submit" class="submit-btn">登录</button>
    </div>
</form>
