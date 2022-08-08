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
            <span class="form-item-name">昵称</span>
            <div class="form-item-value">
                <input type="text" class="form-item-input" name="nickname" value="{$user.LemonUC.Nickname}">
            </div>
        </label>
        <label class="form-item">
            <span class="form-item-name">性别</span>
            <div class="form-item-value">
                <select class="form-item-select" name="gender">
                    <option value="0">保密</option>
                    <option value="1">男</option>
                    <option value="2">女</option>
                </select>
                <script>
                !function () {
                    var select = document.querySelector('select[name="gender"]');
                    select.value = '{$user.LemonUC.Gender}';
                }();
                </script>
            </div>
        </label>
        <label class="form-item">
            <span class="form-item-name">年龄</span>
            <div class="form-item-value">
                <input type="number" class="form-item-input" name="age" value="{$user.LemonUC.Age}">
            </div>
        </label>
        <button class="submit-btn" type="submit">保存</button>
    </form>
</div>
{template:common/script}
<script>
!function () {
    var lmFront = new $$LemonUCentreFront();
    lmFront.init({
        form: '.set-form-group form',
        success: function(formElem) {
            this.msg('设置成功');
            var a = function() {
                var parent = window.parent;
                if (parent) {
                    window.parent.location.href = '{$lemon_uc.pages.userinfo}';
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
