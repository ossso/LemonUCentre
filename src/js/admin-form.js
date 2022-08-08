!function () {
/**
 * Form组合监听
 */
var FormGroup, CL;
CL = FormGroup = function() {
    this.elems = {};
    this.data = {};
    this.status = {};
    var _this = this;

    /**
     * 监听交互事件
     */
    this.watch = function() {
        this.elems.formSwitchList = document.querySelectorAll('.form-item-by-switch');
        for (var i = 0; i < this.elems.formSwitchList.length; i += 1) {
            var item = this.elems.formSwitchList[i];
            this.switchWatch(item);
        }
        // 切换查看密码方式
        this.elems.viewPasswordList = document.querySelectorAll('.form-item-by-input-password');
        for (var i = 0; i < this.elems.viewPasswordList.length; i += 1) {
            var item = this.elems.viewPasswordList[i];
            this.viewPasswordWatch(item);
        }
        // 复制输入框
        this.elems.copyInputList = document.querySelectorAll('.form-item-by-input-copy');
        for (var i = 0; i < this.elems.copyInputList.length; i += 1) {
            var item = this.elems.copyInputList[i];
            this.copyInputWatch(item);
        }
        // form-block切换
        this.elems.formBlockList = document.querySelectorAll('.form-block');
        for (var i = 0; i < this.elems.formBlockList.length; i += 1) {
            var item = this.elems.formBlockList[i];
            this.formBlockWatch(item);
        }
    };
    this.watch();

    this.init = function() {
        this.elems.forms = document.querySelectorAll('.form-group form');
        for (var i = 0; i < this.elems.forms.length; i += 1) {
            var item = this.elems.forms[i];
            item.addEventListener('submit', function () {
                _this.submitForm(this);
            });
        }
    };
    this.init();
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
 * Switch切换事件
 *
 * @param {Element} ele 监听对象
 */
CL.fn.switchWatch = function (ele) {
    var switchElem = ele.querySelector('.form-switch');
    var switchInput = ele.querySelector('.form-switch-input');
    var switchValue = switchInput.value;
    if (switchValue === '1') {
        switchElem.classList.add('active');
    }
    switchElem.addEventListener('click', function () {
        if (switchElem.classList.contains('active')) {
            switchInput.value = '0';
            switchElem.classList.remove('active');
        } else {
            switchInput.value = '1';
            switchElem.classList.add('active');
        }
    });
    return this;
};

/**
 * 切换密码查看交互
 *
 * @param {Element} ele 监听对象
 */
CL.fn.viewPasswordWatch = function (ele) {
    var btn = ele.querySelector('.view-password');
    var pwdInput = ele.querySelector('input[type="password"]');
    var onIcon = btn.querySelector('.on-icon');
    var offIcon = btn.querySelector('.off-icon');
    btn.addEventListener('click', function () {
        if (btn.classList.contains('active')) {
            btn.classList.remove('active');
            onIcon.style.display = '';
            offIcon.style.display = 'none';
            pwdInput.type = 'password';
        } else {
            btn.classList.add('active');
            onIcon.style.display = 'none';
            offIcon.style.display = '';
            pwdInput.type = 'text';
        }
    });
    return this;
};

/**
 * 复制输入框监听
 *
 * @param {Element} ele 监听对象
 */
CL.fn.copyInputWatch = function (ele) {
    var _this = this;
    var inp = ele.querySelector('input');;
    inp.addEventListener('click', function () {
        try {
            clipboard.writeText(this.value);
            _this.msg('复制成功');
        } catch (err) {
            _this.msg('复制失败');
        }
    });
    return this;
};

/**
 * Form模块的切换状态
 *
 * @param {Element} ele 监听对象
 */
CL.fn.formBlockWatch = function (ele) {
    var head = ele.querySelector('.form-block-head');
    var content = ele.querySelector('.form-block-content');
    var childFormGroup = ele.querySelector('.form-group');
    head.addEventListener('click', function () {
        if (ele.classList.contains('active')) {
            content.style.height = '0px';
            ele.classList.remove('active');
        } else {
            content.style.height = childFormGroup.offsetHeight + 'px';
            ele.classList.add('active');
        }
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
    var rules = {
        'username': [
            {
                required: true,
                message: '请输入账号'
            },
            {
                noSpacek: true,
                message: '账号不能包含空格'
            },
            {
                min: 6,
                max: 20,
                message: '账号长度应为6至20位'
            },
        ],
        'email': [
            {
                required: true,
                message: '请输入邮箱'
            },
            {
                validator: this.checkEmail,
                message: '邮箱不符合规则'
            },
        ],
        'phone': [
            {
                required: true,
                message: '请输入手机号码'
            },
            {
                validator: this.checkPhone,
                message: '手机号码不符合规则'
            },
        ],
        'nickname': [
            {
                required: true,
                message: '请输入昵称'
            },
            {
                noSpacek: true,
                message: '昵称不能包含空格'
            },
            {
                min: 2,
                max: 20,
                message: '昵称最短2个字符'
            },
        ],
        'password': [
            {
                required: true,
                message: '请输入密码'
            },
            {
                min: 8,
                max: 30,
                message: '密码长度不能低于8位'
            },
        ],
        'emailValidcode': [
            {
                required: true,
                message: '请输入邮件验证码'
            },
        ],
        'phoneValidcode': [
            {
                required: true,
                message: '请输入短信验证码'
            },
        ],
        'validcode': [
            {
                required: true,
                message: '请输入图片验证码'
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
                    if (!this.validateItem(inpVal, rule)) {
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
 */
CL.fn.validateItem = function (val, rule) {
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
        return rule.validator(val, rule);
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
            data[inpName] = inpVal;
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
    NProgress.start();
    this.status.loading = true;
    this.loading(true);
    $.ajax({
        type: 'post',
        url: url,
        data: this.getFormData(formElem),
        dataType: 'json',
        success: function (res) {
            if (res.hasOwnProperty('code') && res.code.toString() === '0') {
                _this.msg('提交成功');
            } else {
                _this.msg(res.message || '插件接口异常');
            }
        },
        error: function (e, textStatus) {
            if (textStatus === 'timeout') {
                _this.msg('网络超时');
            } else if (textStatus === 'parsererror') {
                _this.msg('服务器返回内容不规范');
            } else {
                _this.msg('网络请求错误，Error Code:' + e.status);
            }
        },
        complete: function () {
            _this.status.loading = false;
            _this.loading(false);
            NProgress.done();
        },
    });
};

window.$$FormGroup = FormGroup;
}();
