(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define([], factory);
    } else if (typeof module === 'object' && module.exports) {
        module.exports = factory();
    } else {
        root.lmucInsert = factory();
    }
}(this, function () {
/**
 * Insert插入脚本
 */

var LemonUCentreInsert, CL;
CL = LemonUCentreInsert = function () {
    this.data = {};
    this.elem = {};

    this.watchLike()
        .watchCollect()
        .watchFollow();
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
 * 获取Element节点
 *
 * @param {String} selector 节点
 * @param {Element} parentNode 查询的父节点
 */
CL.fn.getElem = function (selector, parentNode) {
    var dom = parentNode || document;
    if (!dom) {
        throw Error('请传入查询的Element对象或在浏览器环境下运行');
    }
    return dom.querySelector(selector);
};

/**
 * 获取Element节点
 *
 * @param {String} selector 节点
 * @param {Element} parentNode 查询的父节点
 */
CL.fn.getElemList = function (selector, parentNode) {
    var dom = parentNode || document;
    if (!dom) {
        throw Error('请传入查询的Element对象或在浏览器环境下运行');
    }
    return dom.querySelectorAll(selector);
};

/**
 * 监听点赞
 */
CL.fn.watchLike = function () {
    this.elem.likeBtns = this.getElemList('[data-lmuc="article-like"]');
    if (this.elem.likeBtns.length === 0) return this;
    var _this = this;
    for (var i = 0; i < this.elem.likeBtns.length; i += 1) {
        var item = this.elem.likeBtns[i];
        item.addEventListener('click', function () {
            _this.likeSubmit(this);
        }, false);
    }
    return this;
};

/**
 * 点赞提交
 */
CL.fn.likeSubmit = function (likeBtn) {
    var _this = this;
    var postId = likeBtn.getAttribute('data-postid');
    var status = likeBtn.getAttribute('data-status');
    status = parseInt(status, 10);
    var url = window.bloghost + 'zb_system/cmd.php?act=lemon-uc-api&type=like';
    var toStatus = status === 1 ? 0 : 1;
    var iconElem = this.getElem('.icon.ant', likeBtn);
    var valueElem = this.getElem('.value', likeBtn);
    this.sendRequest({
        type: 'post',
        url: url,
        data: {
            articleID: postId,
            type: toStatus === 1 ? 'add' : 'remove',
        },
        success: function () {
            if (window.$$likeEvent) {
                window.$$likeEvent.call(likeBtn, 'success', toStatus);
            }
        },
        error: function () {
            _this.msg('点赞失败');
            iconElem.setAttribute('data-status', status);
            if (iconElem) {
                if (status === 1) {
                    iconElem.classList.remove('ant-like');
                    iconElem.classList.add('ant-like-fill');
                } else {
                    iconElem.classList.remove('ant-like-fill');
                    iconElem.classList.add('ant-like');
                }
                if (valueElem) {
                    var value = valueElem.innerHTML;
                    value = value.trim();
                    value = parseInt(value, 10);
                    valueElem.innerHTML = value + (toStatus === 1 ? -1 : 1);
                }
            } else if (window.$$likeEvent) {
                window.$$likeEvent.call(likeBtn, 'fail', toStatus);
            }
        },
    });
    likeBtn.setAttribute('data-status', toStatus);
    if (iconElem) {
        if (toStatus === 1) {
            iconElem.classList.remove('ant-like');
            iconElem.classList.add('ant-like-fill');
        } else {
            iconElem.classList.remove('ant-like-fill');
            iconElem.classList.add('ant-like');
        }
        if (valueElem) {
            var value = valueElem.innerHTML;
            value = value.trim();
            value = parseInt(value, 10);
            valueElem.innerHTML = value + (toStatus === 1 ? 1 : -1);
        }
    } else if (window.$$likeEvent) {
        window.$$likeEvent.call(likeBtn, 'preview', toStatus);
    }
    return this;
};

/**
 * 监听收藏
 */
CL.fn.watchCollect = function () {
    this.elem.collectBtns = this.getElemList('[data-lmuc="article-collect"]');
    if (this.elem.collectBtns.length === 0) return this;
    var _this = this;
    for (var i = 0; i < this.elem.collectBtns.length; i += 1) {
        var item = this.elem.collectBtns[i];
        item.addEventListener('click', function () {
            _this.submitCollect(this);
        }, false);
    }
    return this;
};

/**
 * 收藏提交
 */
CL.fn.submitCollect = function (collectBtn) {
    var _this = this;
    var postId = collectBtn.getAttribute('data-postid');
    var status = collectBtn.getAttribute('data-status');
    status = parseInt(status, 10);
    var url = window.bloghost + 'zb_system/cmd.php?act=lemon-uc-api&type=collect';
    var toStatus = status === 1 ? 0 : 1;
    var iconElem = this.getElem('.icon.ant', collectBtn);
    var valueElem = this.getElem('.value', collectBtn);
    this.sendRequest({
        type: 'post',
        url: url,
        data: {
            articleID: postId,
            type: toStatus === 1 ? 'add' : 'remove',
        },
        success: function () {
            if (window.$$collectEvent) {
                window.$$collectEvent.call(collectBtn, 'success', toStatus);
            }
        },
        error: function () {
            _this.msg('收藏失败');
            collectBtn.setAttribute('data-status', status);
            if (iconElem) {
                if (status === 1) {
                    iconElem.classList.remove('ant-star');
                    iconElem.classList.add('ant-star-fill');
                } else {
                    iconElem.classList.remove('ant-star-fill');
                    iconElem.classList.add('ant-star');
                }
                if (valueElem) {
                    var value = valueElem.innerHTML;
                    value = value.trim();
                    value = parseInt(value, 10);
                    valueElem.innerHTML = value + (toStatus === 1 ? -1 : 1);
                }
            } else if (window.$$collectEvent) {
                window.$$collectEvent.call(collectBtn, 'fail', toStatus);
            }
        },
    });
    collectBtn.setAttribute('data-status', toStatus);
    if (iconElem) {
        if (toStatus === 1) {
            iconElem.classList.remove('ant-star');
            iconElem.classList.add('ant-star-fill');
        } else {
            iconElem.classList.remove('ant-star-fill');
            iconElem.classList.add('ant-star');
        }
        if (valueElem) {
            var value = valueElem.innerHTML;
            value = value.trim();
            value = parseInt(value, 10);
            valueElem.innerHTML = value + (toStatus === 1 ? 1 : -1);
        }
    } else if (window.$$collectEvent) {
        window.$$collectEvent.call(collectBtn, 'preview', toStatus);
    }
    return this;
};

/**
 * 监听关注
 */
CL.fn.watchFollow = function () {
    this.elem.followBtns = this.getElemList('[data-lmuc="follow-user"]');
    if (!this.elem.followBtns) return this;
    var _this = this;
    for (var i = 0; i < this.elem.followBtns.length; i += 1) {
        var item = this.elem.followBtns[i];
        item.addEventListener('click', function () {
            _this.submitFollow(this);
        }, false);
    }
    return this;
};

/**
 * 提交关注
 */
CL.fn.submitFollow = function (followBtn) {
    var _this = this;
    var luid = followBtn.getAttribute('data-luid');
    var status = followBtn.getAttribute('data-status');
    status = parseInt(status, 10);
    var url = window.bloghost + 'zb_system/cmd.php?act=lemon-uc-api&type=follow';
    var toStatus = status === 1 ? 0 : 1;
    var iconElem = this.getElem('.icon.ant', followBtn);
    var nameElem = this.getElem('.name', followBtn);
    this.sendRequest({
        type: 'post',
        url: url,
        data: {
            luid: luid,
            type: toStatus === 1 ? 'add' : 'remove',
        },
        success: function () {
            if (window.$$followEvent) {
                window.$$followEvent.call(followBtn, 'success', toStatus);
            }
        },
        error: function () {
            _this.msg('关注失败');
            followBtn.setAttribute('data-status', status);
            if (iconElem) {
                if (status === 1) {
                    iconElem.classList.remove('ant-check');
                    iconElem.classList.add('ant-plus');
                } else {
                    iconElem.classList.remove('ant-plus');
                    iconElem.classList.add('ant-check');
                }
                if (nameElem) {
                    var val = nameElem.innerHTML;
                    val = val.trim();
                    var tpl = toStatus === 1 ? '关注' : '已关注';
                    nameElem.innerHTML = val.replace(/(已关注|关注)/, tpl);
                }
            } else if (window.$$followEvent) {
                window.$$followEvent.call(followBtn, 'fail', toStatus);
            }
        },
    });
    followBtn.setAttribute('data-status', toStatus);
    if (iconElem) {
        if (toStatus === 1) {
            iconElem.classList.remove('ant-plus');
            iconElem.classList.add('ant-check');
        } else {
            iconElem.classList.remove('ant-check');
            iconElem.classList.add('ant-plus');
        }
        if (nameElem) {
            var val = nameElem.innerHTML;
            val = val.trim();
            var tpl = toStatus === 1 ? '已关注' : '关注';
            nameElem.innerHTML = val.replace(/(已关注|关注)/, tpl);
        }
    } else if (window.$$followEvent) {
        window.$$followEvent.call(followBtn, 'preview', toStatus);
    }
    return this;
};

/**
 * 发送请求
 */
CL.fn.sendRequest = function (options) {
    var _this = this;
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
        },
    });
    return this;
};

return new LemonUCentreInsert();
}));
