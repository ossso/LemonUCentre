<?php include '../gfw.php'; ?>
<form action="{$formURL}" class="forgotten-form" onsubmit="return false;">
    <input type="hidden" data-url value="{$host}" />
    <label class="forgotten-form-item form-item">
        <span class="forgotten-form-item-label">账号</span>
        <input type="text" class="form-item-input" name="autoAccount" placeholder="邮箱地址/手机号码" />
    </label>
    <label class="forgotten-form-item form-item">
        <span class="forgotten-form-item-label">密码</span>
        <input type="password" class="form-item-input" name="password" placeholder="新设置密码" />
        <span class="view-password">
            <span class="on-icon ant ant-eye-close" title="查看密码"></span>
            <span class="off-icon ant ant-eye" title="隐藏密码" style="display: none;"></span>
        </span>
    </label>
    <label class="forgotten-form-item form-item">
        <span class="forgotten-form-item-label">验证码</span>
        <input type="text" class="form-item-input" name="autoValidcode" placeholder="请输入验证码" />
        <span class="send-validcode auto-validcode"
            data-phone-url="{$lemon_uc.apis.phoneCodeByReged}"
            data-email-url="{$lemon_uc.apis.emailCodeByReged}">获取验证码</span>
    </label>
    <div class="forgotten-form-btn">
        <button type="submit" class="submit-btn">提交</button>
    </div>
</form>
