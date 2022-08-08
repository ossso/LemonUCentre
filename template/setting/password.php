<?php include '../gfw.php'; ?>
<!DOCTYPE html>
<html>
<head>
{template:common/head}
</head>
<body class="iframe-body">
<div class="set-form-group">
    <form action="{$formURL}" onsubmit="return false;">
        <label class="form-item">
            <span class="form-item-name">旧密码</span>
            <div class="form-item-value">
                <input type="password" class="form-item-input" name="oldPassword" />
                <span class="view-password">
                    <span class="on-icon ant ant-eye-close" title="查看密码"></span>
                    <span class="off-icon ant ant-eye" title="隐藏密码" style="display: none;"></span>
                </span>
            </div>
        </label>
        <label class="form-item">
            <span class="form-item-name">新密码</span>
            <div class="form-item-value">
                <input type="password" class="form-item-input" name="password" />
                <span class="view-password">
                    <span class="on-icon ant ant-eye-close" title="查看密码"></span>
                    <span class="off-icon ant ant-eye" title="隐藏密码" style="display: none;"></span>
                </span>
            </div>
        </label>
        <button class="submit-btn" type="submit">提交</button>
    </form>
</div>
{template:common/script}
<script>
!function () {
    var lmFront = new $$LemonUCentreFront();
    lmFront.init({
        form: '.set-form-group form',
        success: function(formElem) {
            this.msg('修改成功');
            var a = function() {
                var parent = window.parent;
                if (parent && parent.layer) {
                    var index = parent.layer.getFrameIndex(window.name);
                    parent.layer.close(index);
                } else {
                    window.location.href = '{$lemon_uc.pages.userinfo}';
                }
            };
            setTimeout(a.call(this), 2000);
        },
    });
}();
</script>
</body>
</html>
