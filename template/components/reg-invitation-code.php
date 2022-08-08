<?php include '../gfw.php'; ?>
{if $zbp.Config('LemonUCentre').regInvitationCode == '1'}
    <label class="reg-form-item form-item">
        <span class="reg-form-item-label">邀请码</span>
        <input type="text" class="form-item-input" name="invitationCode" placeholder="请输入邀请码" />
    </label>
{/if}
