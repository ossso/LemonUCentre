!function () {
/**
 * LemonUCentre 前台脚本
 */
var LemonUCentreFront, CL;
CL = LemonUCentreFront = function() {
    this.elems = {};
    this.data = {};
    this.status = {};
    var _this = this;

    this.init = function(options) {
        if (!options) {
            options = {};
        }
        this.elems.form = document.querySelector(options.form);
        if (this.elems.form) {
            this.elems.form.addEventListener('submit', function () {
                _this.submitForm(this);
            });
            // 切换查看密码方式
            this.elems.viewPasswordList = this.elems.form.querySelectorAll('.view-password');
            for (var i = 0, n = this.elems.viewPasswordList.length; i < n; i += 1) {
                var item = this.elems.viewPasswordList[i];
                this.viewPasswordToggle(item);
            }
            // 图片验证码切换
            this.elems.imgValidcodeBoxList = this.elems.form.querySelectorAll('.img-validcode');
            for (var i = 0, n = this.elems.imgValidcodeBoxList.length; i < n; i += 1) {
                var item = this.elems.imgValidcodeBoxList[i];
                item.addEventListener('click', function () {
                    _this.imgValidcodeToggle(this);
                });
            }
            // 邮件验证码相关监听
            this.elems.emailValidcodeBtn = this.elems.form.querySelector('.send-validcode.email-validcode');
            if (this.elems.emailValidcodeBtn) {
                this.watchEmailInput();
                this.elems.emailValidcodeBtn.addEventListener('click', function () {
                    _this.emailValidcodeSendVerify();
                });
            }
            // 短信验证码相关监听
            this.elems.phoneValidcodeBtn = this.elems.form.querySelector('.send-validcode.phone-validcode');
            if (this.elems.phoneValidcodeBtn) {
                this.watchPhoneInput();
                this.elems.phoneValidcodeBtn.addEventListener('click', function () {
                    _this.phoneValidcodeSendVerify();
                });
            }
            // 自动验证码相关监听
            this.elems.autoValidcodeBtn = this.elems.form.querySelector('.send-validcode.auto-validcode');
            if (this.elems.autoValidcodeBtn) {
                this.watchAutoAccountInput();
                this.elems.autoValidcodeBtn.addEventListener('click', function () {
                    _this.autoValidcodeSendVerify();
                });
            }
            // 记住登录
            this.elems.remember = this.elems.form.querySelector('.remember-box');
            if (this.elems.remember) {
                this.elems.remember.addEventListener('click', function () {
                    if (_this.elems.remember.classList.contains('active')) {
                        _this.elems.remember.classList.remove('active');
                        _this.data.remember = false;
                    } else {
                        _this.elems.remember.classList.add('active');
                        _this.data.remember = true;
                    }
                });
            }
        }
        if (options.success) {
            this.data.success = options.success;
        }
        // 用户签到
        this.elems.checkin = document.body.querySelector('.user-check-in-btn');
        if (this.elems.checkin) {
            this.elems.checkin.addEventListener('click', function () {
                _this.submitCheckIn();
            });
        }
        // 抓取来源页
        this.data.returnUrl = '';
        if (window.location.search && window.location.search.length > 0) {
            var query = window.location.search.substring(1);
            var queryList = query.split('&');
            for (var i = 0, n = queryList.length; i < n; i += 1) {
                if (queryList[i].indexOf('returnUrl=') === 0) {
                    var returnUrl = queryList[i].split('=');
                    returnUrl = returnUrl.length > 1 ? returnUrl[1] : '';
                    this.data.returnUrl = decodeURIComponent(returnUrl);
                    break;
                }
            }
        }
        return this;
    };

    this.copyTextWatch();
};

CL.fn = CL.prototype;

/**
 * 通知消息
 */
CL.fn.msg = function (cont) {
    try {
        layer.msg(cont);
    } catch (err) {
        alert(cont);
    }
    return this;
};

/**
 * 通知消息2
 */
CL.fn.modal = function (cont) {
    try {
        layer.open({
            title: '提示',
            content: cont,
        });
    } catch (err) {
        alert(cont);
    }
    return this;
};

/**
 * 统一Loading
 */
CL.fn.loading = function (status) {
    if (status) {
        this.data.loading = layer.load(2);
    } else if (this.data.loading) {
        layer.close(this.data.loading);
    } else {
        layer.closeAll('loading');
    }
    return this;
};

/**
 * 父级选择器 - 仅限className
 */
CL.fn.parents = function (className, elem) {
    if (elem.parentNode.classList.contains(className)) {
        return elem.parentNode;
    } else if (elem.parentNode.tagName === 'BODY') {
        return document.body;
    }
    return this.parents(className, elem.parentNode);
};

/**
 * 发送请求
 */
CL.fn.sendRequest = function (options) {
    var _this = this;
    this.loading(true);
    NProgress.start();
    $.ajax({
        type: options.type || 'get',
        url: options.url,
        data: options.data || '',
        dataType: 'json',
        success: function (res) {
            if (res.hasOwnProperty('code') && res.code.toString() === '0') {
                if (typeof options.success === 'function') {
                    options.success(res);
                }
            } else if (res.code === 101010) {
                var layerIndex = _this.renderIframe(res.data);
                if (res.message) {
                    setTimeout(function () {
                        layer.msg(res.message);
                    }, 100);
                }
                window.__iframeWatch = function (val) {
                    if (options.type === 'post' && options.data) {
                        options.data.imageCode = val;
                    } else if (options.type === 'get') {
                        if (options.url.include('imageCode')) {
                            options.url = options.url.replace(/(imageCode=)[a-zA-Z0-9]*/, '$1' + val);
                        } else {
                            if (options.url.include('?')) {
                                options.url += '&';
                            } else {
                                options.url += '?';
                            }
                            options.url += 'imageCode=' + val;
                        }
                    }
                    layer.close(layerIndex);
                    _this.sendRequest(options);
                };
            } else {
                if (typeof options.error === 'function') {
                    options.error(res);
                } else {
                    _this.msg(res.message || '插件接口异常');
                }
            }
        },
        error: function (e, textStatus) {
            if (typeof options.error === 'function') {
                options.error(e, textStatus);
            } else if (textStatus === 'timeout') {
                _this.msg('网络超时');
            } else if (textStatus === 'parsererror') {
                _this.msg('服务器返回内容不规范');
            } else {
                _this.msg('网络请求错误，Error Code:' + e.status);
            }
        },
        complete: function () {
            if (typeof options.complete === 'function') {
                options.complete();
            }
            _this.loading(false);
            NProgress.done();
        },
    });
    return this;
};

/**
 * 验证是否为邮箱
 * @param {String} val 
 */
CL.fn.checkEmail = function (val) {
    return /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(val);
};

/**
 * 验证是否为手机号码
 * @param {String} val 
 */
CL.fn.checkPhone = function (val) {
    return /^1\d{10}$/.test(val);
};

/**
 * 创建规则
 */
CL.fn.createRules = function () {
    var _this = this;
    var rules = {
        username: [
            {
                required: true,
                message: '请输入账号',
            },
            {
                noSpacek: true,
                message: '账号不能包含空格',
            },
        ],
        email: [
            {
                required: true,
                message: '请输入邮箱',
            },
            {
                validator: this.checkEmail,
                message: '邮箱不符合规则',
            },
        ],
        phone: [
            {
                required: true,
                message: '请输入手机号码',
            },
            {
                validator: this.checkPhone,
                message: '手机号码不符合规则',
            },
        ],
        autoAccount: [
            {
                required: true,
                message: '请输入账号',
            },
            {
                validator: function(val) {
                    return (_this.checkEmail(val) || _this.checkPhone(val));
                },
                message: '请输入邮箱地址或手机号码',
            },
        ],
        nickname: [
            {
                required: true,
                message: '请输入昵称',
            },
            {
                noSpacek: true,
                message: '昵称不能包含空格',
            },
            {
                min: 2,
                max: 20,
                message: '昵称最短2个字符',
            },
        ],
        password: [
            {
                required: true,
                message: '请输入密码',
            },
            {
                min: 8,
                max: 30,
                message: '密码长度不能低于8位',
            },
        ],
        oldPassword: [
            {
                required: true,
                message: '请输入原密码',
            },
            {
                min: 8,
                max: 30,
                message: '原密码长度不能低于8位',
            },
        ],
        password2: [
            {
                required: true,
                message: '请输入确认密码',
            },
            {
                validator: function (val, rule, formElem) {
                    var pwdInp = formElem.querySelector('[name="password"]');
                    if (pwdInp) {
                        var pwd = pwdInp.value;
                        return pwd === val;
                    }
                    return false;
                },
                message: '密码与确认密码不一致',
            },
        ],
        emailValidcode: [
            {
                required: true,
                message: '请输入邮件验证码',
            },
        ],
        phoneValidcode: [
            {
                required: true,
                message: '请输入短信验证码',
            },
        ],
        validcode: [
            {
                required: true,
                message: '请输入图片验证码',
            }, 
        ],
        invitationCode: [
            {
                required: true,
                message: '请输入邀请码',
            }, 
        ],
        autoValidcode: [
            {
                required: true,
                message: '请输入验证码',
            }, 
        ],
    };

    return rules;
};

/**
 * 验证表单
 * @param {Element} formElem Form对象
 *
 * @return Boolean
 */
CL.fn.validateForm = function (formElem) {
    var rules = this.createRules();

    var names = formElem.querySelectorAll('[name]');
    if (names.length) {
        for (var i = 0, n = names.length; i < n; i += 1) {
            var item = names[i];
            var inpName = item.name;
            var inpVal = item.value || '';
            inpVal = inpVal.trim();
            var inpRules = rules[inpName];
            if (inpRules) {
                for (var k = 0, l = inpRules.length; k < l; k += 1) {
                    var rule = inpRules[k];
                    if (!this.validateItem(inpVal, rule, formElem)) {
                        this.msg(rule.message);
                        return false;
                    }
                }
            }
        }
    }

    return true;
};

/**
 * 验证单项
 * @param {String} val 验证值
 * @param {Object} rule 验证规则
 * @param {Element} formElem form的Element对象
 */
CL.fn.validateItem = function (val, rule, formElem) {
    if (rule.required && val.length === 0) {
        return false;
    }
    if (rule.noSpacek && /\s/.test(val)) {
        return false;
    }
    if (rule.hasOwnProperty('min') && val.length < rule.min) {
        return false;
    }
    if (rule.hasOwnProperty('max') && val.length > rule.max) {
        return false;
    }
    if (rule.hasOwnProperty('validator') && typeof rule.validator === 'function') {
        return rule.validator(val, rule, formElem);
    }
    return true;
};

/**
 * 获取表单内容
 * @param {Element}} formElem 提交表单form对象
 */
CL.fn.getFormData = function (formElem) {
    var data = {};
    var names = formElem.querySelectorAll('[name]');
    if (names.length) {
        for (var i = 0, n = names.length; i < n; i += 1) {
            var item = names[i];
            var inpName = item.name;
            var inpVal = item.value || '';
            inpVal = inpVal.trim();
            var isPwd = inpName.match(/password/i);
            if (isPwd && isPwd.length > 0) {
                data[inpName] = md5(inpVal);
            } else {
                data[inpName] = inpVal;
            }
        }
    }
    return data;
};

/**
 * 提交表单
 * @param {Element} formElem 提交表单form对象
 */
CL.fn.submitForm = function (formElem) {
    if (this.status.loading) {
        return false;
    }
    if (!formElem) {
        return false;
    }
    if (!this.validateForm(formElem)) {
        return false;
    }
    var url = formElem.getAttribute('action');
    if (!url) {
        this.msg('表单异常，未找到提交地址');
        return false;
    }
    var _this = this;
    var data = this.getFormData(formElem);
    if (this.data.remember) {
        data.remember = this.data.remember ? 1 : '';
    }
    this.sendRequest({
        type: 'post',
        url: url,
        data: data,
        success: function (res) {
            if (typeof _this.data.success === 'function') {
                _this.data.success.call(_this, formElem, data, res);
            } else {
                _this.msg('提交成功');
            }
        },
    });
    return this;
};

/**
 * 切换图片验证码
 */
CL.fn.imgValidcodeToggle = function (box) {
    var img = document.createElement('img');
    img.src = box.dataset['src'] + '&t=' + Date.now();
    box.innerHTML = '';
    box.appendChild(img);
    var parentItem = this.parents('form-item', box);
    var imgValidcodeInput = parentItem.querySelector('.form-item-input');
    imgValidcodeInput.value = '';
    return this;
};

/**
 * 查看密码的切换
 */
CL.fn.viewPasswordToggle = function (elem) {
    var viewPasswordOn = elem.querySelector('.on-icon');
    var viewPasswordOff = elem.querySelector('.off-icon');
    var parentItem = this.parents('form-item', elem);
    var viewPasswordInput = parentItem.querySelector('[type="password"]');
    if (!viewPasswordInput) return this;
    elem.addEventListener('click', function () {
        if (elem.classList.contains('active')) {
            elem.classList.remove('active');
            viewPasswordOn.style.display = '';
            viewPasswordOff.style.display = 'none';
            viewPasswordInput.type = 'password';
        } else {
            elem.classList.add('active');
            viewPasswordOn.style.display = 'none';
            viewPasswordOff.style.display = '';
            viewPasswordInput.type = 'text';
        }
    });
    return this;
};

/**
 * 监听邮箱地址输入响应邮件验证码发送按钮
 */
CL.fn.watchEmailInput = function () {
    var _this = this;
    this.elems.emailInput = this.elems.form.querySelector('[name="email"]');
    var emailInput = this.elems.emailInput;
    var verify = function () {
        if (_this.status.emailValidcodeSend) {
            return false;
        }
        var that = this;
        setTimeout(() => {
            var val = that.value || '';
            val = val.trim();
            if (_this.checkEmail(val)) {
                _this.status.checkEmail = true;
                _this.elems.emailValidcodeBtn.classList.add('active');
            } else {
                _this.status.checkEmail = false;
                _this.elems.emailValidcodeBtn.classList.remove('active');
            }
        }, 10);
    }
    emailInput.addEventListener('keyup', function () {
        verify.call(this);
    });
    emailInput.addEventListener('blur', function () {
        verify.call(this);
    });
    return this;
};

/**
 * 监听手机号码输入响应短信验证码发送按钮
 */
CL.fn.watchPhoneInput = function () {
    var _this = this;
    this.elems.phoneInput = this.elems.form.querySelector('[name="phone"]');
    var phoneInput = this.elems.phoneInput;
    var verify = function () {
        if (_this.status.phoneValidcodeSend) {
            return false;
        }
        var that = this;
        setTimeout(() => {
            var val = that.value || '';
            val = val.trim();
            if (_this.checkPhone(val)) {
                _this.status.checkPhone = true;
                _this.elems.phoneValidcodeBtn.classList.add('active');
            } else {
                _this.status.checkPhone = false;
                _this.elems.phoneValidcodeBtn.classList.remove('active');
            }
        }, 10);
    }
    phoneInput.addEventListener('keyup', function () {
        verify.call(this);
    });
    phoneInput.addEventListener('blur', function () {
        verify.call(this);
    });
    return this;
};

/**
 * 监听输入的账号信息响应验证码发送按钮
 */
CL.fn.watchAutoAccountInput = function () {
    var _this = this;
    this.elems.autoAccountInput = this.elems.form.querySelector('[name="autoAccount"]');
    var autoAccountInput = this.elems.autoAccountInput;
    var verify = function () {
        if (_this.status.sendValidcode) {
            return false;
        }
        var that = this;
        setTimeout(() => {
            var val = that.value || '';
            val = val.trim();
            if (_this.checkEmail(val) || _this.checkPhone(val)) {
                _this.status.checkAutoAccount = true;
                _this.elems.autoValidcodeBtn.classList.add('active');
            } else {
                _this.status.checkAutoAccount = false;
                _this.elems.autoValidcodeBtn.classList.remove('active');
            }
        }, 10);
    }
    autoAccountInput.addEventListener('keyup', function () {
        verify.call(this);
    });
    autoAccountInput.addEventListener('blur', function () {
        verify.call(this);
    });
    return this;
};

/**
 * 刷新按钮状态
 *
 * @param {Element} btn 按钮对象
 * @param {Number} time 剩余时间
 */
CL.fn.refreshBtnStatus = function(btn, time) {
    if (!time) {
        btn.classList.remove('wait');
        btn.classList.add('active');
        btn.innerHTML = '发送验证码';
        this.status.sendValidcode = false;
        return this;
    }
    this.status.sendValidcode = true;
    btn.classList.remove('active');
    btn.classList.add('wait');
    btn.innerHTML = '重新发送(' + time + 's)';
    var _this = this;
    setTimeout(function() {
        _this.refreshBtnStatus(btn, time - 1);
    }, 1000);
    return this;
};

/**
 * 发送短信验证
 */
CL.fn.phoneValidcodeSendVerify = function() {
    if (this.status.sendValidcode) return this;
    var btn = this.elems.phoneValidcodeBtn;
    if (!btn.classList.contains('active')) {
        return this;
    }
    var url = btn.dataset['url'];
    this.sendValidcode(url, {
        phone: this.elems.phoneInput.value.trim(),
    }, btn);
    return this;
};

/**
 * 邮件发送验证
 */
CL.fn.emailValidcodeSendVerify = function() {
    if (this.status.sendValidcode) return this;
    var btn = this.elems.emailValidcodeBtn;
    if (!btn.classList.contains('active')) {
        return this;
    }
    var url = btn.dataset['url'];
    this.sendValidcode(url, {
        email: this.elems.emailInput.value.trim(),
    }, btn);
    return this;
};

/**
 * 自动账号验证码发送验证
 */
CL.fn.autoValidcodeSendVerify = function() {
    if (this.status.sendValidcode) return this;
    var btn = this.elems.autoValidcodeBtn;
    if (!btn.classList.contains('active')) {
        return this;
    }
    var account = this.elems.autoAccountInput.value.trim();
    var accountType = this.checkPhone(account) ? 'phone' : 'email';
    var url = btn.dataset[accountType + 'Url'];
    var data = {};
    data[accountType] = account;
    this.sendValidcode(url, data, btn);
    return this;
};

/**
 * 发送验证码
 * @param {String} url 请求地址
 * @param {Object|String} data 请求参数
 * @param {Element} btn 发送按钮
 */
CL.fn.sendValidcode = function (url, data, btn) {
    if (this.status.sendValidcode) {
        return false;
    }
    var _this = this;
    this.status.sendValidcode = true;
    this.sendRequest({
        type: 'post',
        url: url,
        data: data,
        success: function() {
            _this.msg('发送成功');
            _this.refreshBtnStatus(btn, 60);
        },
        complete: function () {
            _this.status.sendValidcode = false;
        },
    });
    return this;
};

/**
 * 用户签到
 */
CL.fn.submitCheckIn = function() {
    if (this.status.submitCheckIn) {
        return this;
    }
    var _this = this;
    this.status.submitCheckIn = true;
    this.sendRequest({
        type: 'get',
        url: this.elems.checkin.dataset['url'],
        success: function (res) {
            _this.msg('签到成功');
            if (res.data) {
                var text = '今天已完成签到，明天签到可获得 ';
                text += res.data.tomorrow;
                text += ' ';
                text += res.data.pointsName;
                _this.elems.checkin.innerHTML = '已签到' + res.data.count + '天';
                _this.elems.checkin.parentNode.querySelector('p').innerHTML = text;
            }
            _this.elems.checkin.classList.remove('active');
            var pointsValueElem = document.body.querySelector('.user-points .points-value');
            if (pointsValueElem) {
                var oldValue = pointsValueElem.innerHTML;
                oldValue = oldValue.trim();
                oldValue = parseFloat(oldValue, 10);
                var newValue = parseFloat(res.data.today, 10);
                pointsValueElem.innerHTML = oldValue + newValue;
            }
        },
        complete: function () {
            _this.status.submitCheckIn = false;
        },
    });
    return this;
};

/**
 * 监听复制
 */
CL.fn.copyTextWatch = function () {
    var _this = this;
    var list = document.querySelectorAll('[data-copy]');
    for (var i = 0, n = list.length; i < n; i += 1) {
        var item = list[i];
        item.addEventListener('click', function () {
            var text = this.getAttribute('data-copy');
            try {
                var dt = new clipboard.DT();
                dt.setData('text/plain', text);
                clipboard.write(dt);
                _this.msg('复制成功');
            } catch (err) {
                _this.msg('复制失败');
            }
        });
    }
    return this;
};

/**
 * 渲染iframe - 基于layer
 */
CL.fn.renderIframe = function (data) {
    var area = [];
    area.push(data.width + 'px');
    area.push(data.height + 'px');
    var index = layer.open({
        type: 2,
        title: false,
        content: data.url,
        area: area,
    });
    return index;
};

window.$$LemonUCentreFront = LemonUCentreFront;
}();
