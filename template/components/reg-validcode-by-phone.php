<?php include '../gfw.php'; ?>
<label class="reg-form-item form-item">
    <span class="reg-form-item-label">验证码</span>
    <input type="text" class="form-item-input" name="phoneValidcode" placeholder="请输入短信验证码" />
    <span class="send-validcode phone-validcode" data-url="{$lemon_uc.apis.phoneCode}">发送验证码</span>
</label>
