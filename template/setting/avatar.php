<?php include '../gfw.php'; ?>
<!DOCTYPE html>
<html>
<head>
{template:common/head}
<link rel="stylesheet" href="{$lemon_uc.static}libs/cropper/cropper.min.css" />
</head>
<body class="iframe-body">
<div class="avatar-update-group">
    <div class="avatar-editor">
        <img src="{$user.LemonUC.Avatar}" />
    </div>
    <div class="avatar-options">
        <label class="select-photo-btn">
            <input type="file" style="display:none" id="select-image" name="file" accept="image/png,image/jpg,image/jpeg,image/gif">
            <span class="ant ant-image"></span>
            <span>选择图片</span>
        </label>
        <div class="tips">
            <p>1、推荐尺寸256px*256px；</p>
            <p>2、图片大小不能超过1M；</p>
            <p>3、透明底图片自动转白底；</p>
        </div>
        <h3>头像预览</h3>
        <div class="avatar-preview">
            <div class="avatar-preview-item preview-big"></div>
            <div class="avatar-preview-item preview-normal"></div>
        </div>
        <form id="upload-form" action="{$formURL}" onsubmit="return false;">
            <button class="save-btn" type="submit">保存头像</button>
        </form>
    </div>
</div>
{template:common/script}
<script src="{$lemon_uc.static}libs/cropper/cropper.min.js"></script>
<script src="{$lemon_uc.jspath}avatar.js"></script>
<script>
!function () {
var avatarUpload = new window.$$AvatarUpload();
avatarUpload.init({
    main: '.avatar-update-group .avatar-editor img',
    avatarPreview: '.avatar-update-group .avatar-preview-item',
    selectImage: '#select-image',
    uploadForm: '#upload-form',
});
}();
</script>
</body>
</html>
