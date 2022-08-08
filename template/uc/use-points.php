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
                <h2>使用{$lemon_uc.PointsName}</h2>
            </div>
            <div class="uc-use-points">
                <p class="points-content">您可以使用{$lemon_uc.PointsName}兑换以下服务</p>
                <div class="use-points-product">
                    {if $zbp.Config('LemonUCentre').enabledPoints2VIP}
                    <div class="product-item">
                        <div class="vip-card">
                            <span class="vip-name">{$lemon_uc.VIPName}</span>
                            <span class="vip-date">
                                <span class="vip-date-value">{$zbp.Config('LemonUCentre').points2VIPDate}</span>
                                <span class="vip-date-symbol">天</span>
                            </span>
                            <span class="vip-price">
                                <span class="vip-price-name">价值</span>
                                <span class="vip-price-value">{$zbp.Config('LemonUCentre').points2VIP}</span>
                                <span class="vip-price-symbol">{$lemon_uc.PointsName}</span>
                            </span>
                            {template:icon/crown-icon}
                        </div>
                        <form class="product-ex"
                            action="{$lemon_uc.apis.points2vip}"
                            data-points="{$zbp.Config('LemonUCentre').points2VIP}"
                            onsubmit="return false;">
                            <div class="product-ex-name">兑换</div>
                            <div class="product-ex-value">
                                <input type="text"
                                    class="product-ex-input"
                                    pattern="[0-9]*"
                                    value="1" />
                            </div>
                            <div class="product-ex-symbol">份</div>
                            <button class="product-buy">立刻兑换</button>
                        </form>
                    </div>
                    {/if}
                </div>
            </div>
        </div>
    </div>
    {template:common/footer}
    {template:common/script}
    <script>
    !function() {
        var lmFront = new $$LemonUCentreFront();
        lmFront.init();
        var formSubmit = function(formElem) {
            var inp = formElem.querySelector('.product-ex-input');
            var val = inp.value || '';
            val = val.trim() + '';
            if (/[^0-9]/.test(val)) {
                lmFront.msg('请输入正确的兑换数量');
                return false;
            }
            var pointsValueElem = document.body.querySelector('.user-points .points-value');
            if (pointsValueElem) {
                var oldValue = pointsValueElem.innerHTML;
                oldValue = oldValue.trim();
                oldValue = parseFloat(oldValue, 10);
                var points = formElem.dataset['points'];
                points = parseFloat(points, 10);
                var countPoints = points * val;
                if (countPoints > oldValue) {
                    lmFront.msg('您的余额不足，无法兑换' + val + '份');
                    return false;
                }
            }
            lmFront.sendRequest({
                url: formElem.getAttribute('action'),
                type: 'post',
                data: {
                    num: val,
                },
                success: function(res) {
                    lmFront.msg('兑换成功');
                    if (pointsValueElem) {
                        var newValue = parseFloat(res.data.points, 10);
                        pointsValueElem.innerHTML = oldValue + newValue;
                    }
                },
            });
        };
        document.body.querySelector('.product-ex').addEventListener('submit', function() {
            formSubmit(this);
        });
    }();
    </script>
</body>
</html>
