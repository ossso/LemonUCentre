<?php include '../gfw.php'; ?>
<!DOCTYPE html>
<html>
<head>
{template:common/head}
</head>
<body class="uc-body">
    {template:uc/header}
    <div class="uc-container">
        {template:uc/side}
        <div class="uc-main">
            <div class="uc-main-head">
                <h2>兑换码 - CDKEY</h2>
            </div>
            <div class="uc-cdkey-group">
                <p>欢迎使用兑换码功能，您可以兑换{$lemon_uc.PointsName}、{$lemon_uc.VIPName}</p>
                <form class="cdkey-form-group" action="{$lemon_uc.apis.cdkey}" onsubmit="return false;">
                    <label class="cdkey-form-item">
                        <div class="cdkey-form-item-name">
                            <span>CDKEY</span>
                        </div>
                        <div class="cdkey-form-item-value">
                            <input type="text" class="cdkey-form-item-input" name="cdkey" placeholder="请输入16位兑换码密钥" />
                        </div>
                    </label>
                    <div class="cdkey-btn">
                        <button class="submit-btn" type="submit">兑换</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {template:common/footer}
    {template:common/script}
    <script>
    !function() {
        var lmFront = new $$LemonUCentreFront();
        lmFront.init({
            form: '.cdkey-form-group',
            success: function(formElem, formData, res) {
                layer.open({
                    title: '兑换成功',
                    content: '您已成功兑换' + res.data.value + res.data.symbol + res.data.name,
                    end: function() {
                        if ((res.data.type + '') === '1') {
                            window.location.href = window.location.href;
                        }
                    },
                });
                // 兑换积分的动态变更
                if ((res.data.type + '') === '0') {
                    var pointsValueElem = document.body.querySelector('.user-points .points-value');
                    if (pointsValueElem) {
                        var oldValue = pointsValueElem.innerHTML;
                        oldValue = oldValue.trim();
                        oldValue = parseFloat(oldValue, 10);
                        var newValue = parseFloat(res.data.value, 10);
                        pointsValueElem.innerHTML = oldValue + newValue;
                    }
                }
                document.body.querySelector('.cdkey-form-group [name="cdkey"]').value = '';
            },
        });
    }();
    </script>
</body>
</html>
