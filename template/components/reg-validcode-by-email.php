<?php include '../gfw.php'; ?>
<label class="reg-form-item form-item">
    <span class="reg-form-item-label">验证码</span>
    <input type="text" class="form-item-input" name="emailValidcode" placeholder="请输入邮件验证码" />
    <span class="send-validcode email-validcode" data-url="{$lemon_uc.apis.emailCode}">发送验证码</span>
</label>
