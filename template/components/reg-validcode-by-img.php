<?php include '../gfw.php'; ?>
{if $zbp.Config('LemonUCentre').regValidcode == '1'}
    <label class="reg-form-item form-item">
        <span class="reg-form-item-label">验证码</span>
        <input type="text" class="form-item-input" name="validcode" placeholder="请输入图片验证码" />
        <span class="img-validcode" data-src="{$zbp.validcodeurl}?id=lemon-uc-reg" title="点击切换验证码">
            <img src="{$zbp.validcodeurl}?id=lemon-uc-reg&t={time()}" />
        </span>
    </label>
{/if}