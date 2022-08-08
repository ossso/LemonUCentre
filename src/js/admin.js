!function() {
/**
 * 后台其它相关监听
 */
var Admin, CL;
CL = Admin = function () {
    this.elems = {};
    this.data = {};
    this.status = {};

    this.init = function() {
        this.elems.headerUserinfo = document.querySelector('.layout-header-userinfo');
        if (this.elems.headerUserinfo) {
            this.headerUserinfoDrawerWatch();
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
 * 顶部用户下拉菜单监听
 */
CL.fn.headerUserinfoDrawerWatch = function() {
    var _this = this;
    var userDrawer = this.elems.headerUserinfo.querySelector('.userinfo-drawer');
    var visibleDrawer = function() {
        userDrawer.classList.add('active');
        setTimeout(function() {
            if (_this.status.headerUserinfoDrawer) {
                userDrawer.classList.add('show');
            }
        }, 10);
    };
    var hideDrawer = function() {
        userDrawer.classList.remove('show');
        setTimeout(function() {
            if (!_this.status.headerUserinfoDrawer) {
                userDrawer.classList.remove('active');
            }
        }, 210);
    };
    this.elems.headerUserinfo.addEventListener('mouseenter', function() {
        _this.status.headerUserinfoDrawer = true;
        visibleDrawer();
    });
    this.elems.headerUserinfo.addEventListener('mouseleave', function () {
        _this.status.headerUserinfoDrawer = false;
        hideDrawer();
    });
    return this;
};

/**
 * 时间格式化工具
 *
 * @param {String} tpl 模板
 * @param {String|Object} date 日期字符串或日期对象
 * @param {Number} timestamp 时间戳
 */
CL.fn.dateFormat = function (tpl, date, timestamp) {
    // 设置默认模板
    tpl = tpl || 'yyyy/mm/dd';
    // 时间初始化
    var d = new Date();
    if (timestamp) {
        d.setTime(timestamp * 1000);
    } else if (typeof date === 'string') {
        (function () {
            var dateString = date.replace(/\-/g, '/')
                .replace(/\./g, '/')
                .replace(/T/g, ' ')
                .replace(/(日|秒)/g, '')
                .replace(/(时|分)/g, ':')
                .replace(/(年|月)/g, '/');
            d = new Date(dateString);
            var time = d.getTime();
            if (isNaN(time)) {
                throw Error('date 不是合法的时间字符串');
            }
        })();
    } else if (date.constructor.name !== 'Date') {
        throw Error('请传入正确的Date对象');
    }
    // 组装日期字符串对象
    var o = {};
    o.yyyy = d.getFullYear();
    o.yy = (o.yyyy + '').substring(2);
    o.m = d.getMonth() + 1;
    o.mm = o.m < 10 ? ('0' + o.m) : o.m;
    o.d = d.getDate();
    o.dd = o.d < 10 ? ('0' + o.d) : o.d;
    if (tpl.indexOf('h') > -1) {
        o.h = d.getHours();
        o.hh = o.h < 10 ? ('0' + o.h) : o.h;
        o.i = d.getMinutes();
        o.ii = o.i < 10 ? ('0' + o.i) : o.i;
        o.s = d.getSeconds();
        o.ss = o.s < 10 ? ('0' + o.s) : o.s;
    }

    return tpl.replace(/(yyyy|yy|mm|m|dd|d|hh|h|ii|i|ss|s)/ig, key => o[key.toLowerCase()]);
};

/**
 * 分页器
 *
 * @param {Number} page 页码
 * @param {Number} size 分页数量
 * @param {Number} total 总数
 * @param {Number} barCount 页码条数
 */
CL.fn.pagination = function (page, size, total, barCount) {
    var pagination = {
        page: page || 1,
        size: size || 10,
        total: total || 0,
        barCount: barCount || 5,
    };
    pagination.allPage = Math.ceil(pagination.total / pagination.size);
    var middleKey = Math.ceil(pagination.barCount / 2);
    var pagebar = [];
    // fisrt
    pagebar.push({
        name: 1,
        value: 1,
        type: 'page',
    });
    var start = 1;
    // 如果当前页大于key start为当前页减去key
    if (pagination.page > middleKey) {
        start = pagination.page - middleKey;
    }
    // 如果总页数减去start小于中间的页码bar数量 start变更为总数减去页码bar数量
    if (pagination.allPage > pagination.barCount && (pagination.allPage - start) < pagination.barCount) {
        start = pagination.allPage - pagination.barCount;
    }
    // 结束点为start+页码bar数量
    var end = start + pagination.barCount;
    if (end > pagination.allPage) {
        end = pagination.allPage;
    }
    // 如果start大于1，处理向前批量翻页
    if (start > 1) {
        var val = end - pagination.barCount;
        pagebar.push({
            name: '...',
            value: val < 1 ? 1 : val,
            type: 'before',
        });
    }
    // 开始循环，注入页码
    var i = start;
    while (i < end) {
        if (i === pagination.allPage - 1) {
            break;
        }
        pagebar.push({
            name: i + 1,
            value: i + 1,
        });
        i += 1;
    }
    // 如果start+页码bar数量小于总页数 挂入向后批量翻页
    if (start + pagination.barCount < pagination.allPage) {
        var val = pagination.page + pagination.barCount;
        pagebar.push({
            name: '...',
            value: val >= pagination.allPage ? pagination.allPage : val,
            type: 'after',
        });
    }
    // last
    if (pagination.allPage > 2) {
        pagebar.push({
            name: pagination.allPage,
            value: pagination.allPage,
            type: 'page',
        });
    }
    pagination.pagebar = pagebar;
    return pagination;
};

window.$$admin = new Admin();
}();
