<?php include '../gfw.php'; ?>
<form action="{$formURL}" class="reg-form" onsubmit="return false;">
    <input type="hidden" data-url value="{$host}" />
    <label class="reg-form-item form-item">
        <span class="reg-form-item-label">手机</span>
        <input type="text" class="form-item-input" name="phone" placeholder="请输入手机号码" />
    </label>
    {template:components/reg-validcode-by-phone}
    {if $zbp.Config('LemonUCentre').regSyncUsername != '1'}
    <label class="reg-form-item form-item">
        <span class="reg-form-item-label">账号</span>
        <input type="text" class="form-item-input" name="username" placeholder="请输入注册用户名" />
    </label>
    {/if}
    <label class="reg-form-item form-item">
        <span class="reg-form-item-label">昵称</span>
        <input type="text" class="form-item-input" name="nickname" placeholder="请输入您的昵称" />
    </label>
    <label class="reg-form-item form-item">
        <span class="reg-form-item-label">密码</span>
        <input type="password" class="form-item-input" name="password" placeholder="请设定登录密码" />
        <span class="view-password">
            <span class="on-icon ant ant-eye-close" title="查看密码"></span>
            <span class="off-icon ant ant-eye" title="隐藏密码" style="display: none;"></span>
        </span>
    </label>
    {template:components/reg-invitation-code}
    {template:components/reg-validcode-by-img}
    <div class="reg-form-btn">
        <button type="submit" class="submit-btn">注册</button>
    </div>
</form>
