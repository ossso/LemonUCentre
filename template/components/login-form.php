<?php include '../gfw.php'; ?>
<form action="{$formURL}" class="login-form" onsubmit="return false;">
    <input type="hidden" data-url value="{$lemon_uc.pages.mine}" />
    <label class="login-form-item form-item">
        <span class="login-form-item-label">账号</span>
        <input type="text" class="form-item-input" name="username" placeholder="用户名/邮箱/手机号码" />
    </label>
    <label class="login-form-item form-item">
        <span class="login-form-item-label">密码</span>
        <input type="password" class="form-item-input" name="password" placeholder="登录密码" />
    </label>
    {if $isRemember}
    <div class="login-remember">
        <span class="remember-box">
            <span class="check-box">
                <span class="icon ant ant-check"></span>
            </span>
            <span class="value">记住登录</span>
        </span>
    </div>
    {/if}
    <div class="login-form-btn">
        <button type="submit" class="submit-btn">登录</button>
    </div>
</form>
