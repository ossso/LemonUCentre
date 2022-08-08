window.addEventListener('load', function () {
var asyncLink = {};
var inps = document.querySelectorAll('.async-link-group input');
for (var i = 0; i < inps.length; i += 1) {
    var item = inps[i];
    asyncLink[item.name] = item.value;
}
/**
 * 兑换码管理
 * 依赖jQuery的ajax部分
 */
document.querySelector('#app').style.display = 'block';
new Vue({
    el: '#app',
    data: function() {
        return {
            filter: {
                status: '',
                type: '',
                code: '',
            },
            filterSelectVisible: '',
            statusList: [
                {
                    name: '全部',
                    value: '',
                },
                {
                    name: '未使用',
                    value: '0',
                },
                {
                    name: '已使用',
                    value: '1',
                },
            ],
            statusName: '全部',
            typeList: [
                {
                    name: '全部',
                    value: '',
                },
                {
                    name: '积分兑换码',
                    value: '0',
                },
                {
                    name: '会员兑换码',
                    value: '1',
                },
            ],
            typeName: '全部',
            createForm: {
                type: '0',
                value: null,
                num: 1,
            },
            createFormVisible: false,
            list: [],
            page: 1,
            size: 20,
            total: 0,
            pagination: null,
            checkboxList: [],
        };
    },
    computed: {
        theadHalfChecked: function () {
            return (this.checkboxList.length > 0 && this.checkboxList.length < this.list.length);
        },
        theadAllChecked: function () {
            return (this.checkboxList.length > 0  && this.checkboxList.length === this.list.length);
        },
    },
    mounted: function() {
        var vm = this;
        document.body.addEventListener('click', function() {
            vm.filterSelectVisible = '';
        });
        this.handlePagebar();
        this.loadList();
    },
    watch: {
        'filter.code': function() {
            this.loadList();
        },
        list: function() {
            if (this.list.length === 0 && this.total > this.size) {
                this.loadList(this.page);
            }
        },
    },
    methods: {
        /**
         * 加载列表
         * @param {Number} page 页码
         * @param {Function} cb 回调方法
         */
        loadList: function (page, cb) {
            var vm = this;
            if (!page) {
                page = 1;
            }
            NProgress.start();
            var data = {
                page: page,
                size: 20,
            };
            Object.keys(vm.filter).forEach(function (i) {
                data[i] = vm.filter[i];
            });
            $.ajax({
                type: 'post',
                url: asyncLink.list,
                data: data,
                dataType: 'json',
                success: function (res) {
                    if (res.code === 0) {
                        var list = res.data.list.slice();
                        vm.handleList(list);
                        vm.list = list;
                        vm.total = res.data.total;
                        vm.checkboxList = [];
                        vm.handlePagebar();
                    } else {
                        layer.msg(res.message);
                    }
                },
                error: function () {
                    layer.open({
                        content: '加载失败',
                    });
                },
                complete: function () {
                    NProgress.done();
                },
            });
        },
        /**
         * 处理列表需要被格式化处理的内容
         *
         * @param {Array} list 被处理的列表数组 
         */
        handleList: function (list) {
            list.forEach(function(item) {
                item.CreateDate = window.$$admin.dateFormat('yyyy/mm/dd hh:ii:ss', null, item.CreateTime);
                item.UseDate = window.$$admin.dateFormat('yyyy/mm/dd hh:ii:ss', null, item.UseTime);
                item.delete = false;
            });
        },
        /**
         * 处理分页
         */
        handlePagebar: function() {
            var pagination = $$admin.pagination(this.page, this.size, this.total);
            this.pagination = pagination;
        },
        /**
         * 过滤select选项显示
         * @param {String} type 显示类型
         */
        filterSelectToggle: function (type) {
            if (this.filterSelectVisible === type) {
                this.filterSelectVisible = '';
            } else {
                this.filterSelectVisible = type;
            }
        },
        /**
         * 过滤的select选择单项点击
         */
        filterSelectItem: function (item, type) {
            var vm = this;
            if (type === 'status') {
                vm.filter.status = item.value;
                vm.statusName = item.name;
            } else if (type === 'type') {
                vm.filter.type = item.value;
                vm.typeName = item.name;
            }
            vm.filterSelectVisible = '';
            this.loadList();
        },
        /**
         * 切换页码
         *
         * @param {Number|String} page 页码
         */
        togglePage(page) {
            if (page === '-1') {
                var page = this.page - 1;
                if (page < 1) {
                    this.page = 1;
                } else {
                    this.page = page;
                }
            } else if (page === '1') {
                var page = this.page + 1;
                if (page > Math.ceil(this.total / this.size)) {
                    this.page = Math.ceil(this.total / this.size);
                } else {
                    this.page = page;
                }
            }
            this.page = page;
            this.handlePagebar();
            this.loadList(this.page);
        },
        /**
         * 打开创建兑换码
         */
        createBtn: function() {
            this.createForm = {
                type: '0',
                value: null,
                num: 1,
            };
            this.createFormVisible = true;
        },
        /**
         * 创建兑换码 - 提交操作
         */
        createCode: function () {
            var vm = this;
            if (!vm.createForm.value) {
                layer.msg('请输入正确的数值');
                return this;
            }
            if ((vm.createForm.value + '') === '0') {
                layer.msg('数值不能为0');
                return this;
            }
            if (!vm.createForm.num) {
                layer.msg('请输入正确的创建数量');
                return this;
            }
            if ((vm.createForm.num + '') === '0') {
                layer.msg('创建数量不能为0');
                return this;
            }
            NProgress.start();
            var data = {};
            Object.keys(vm.createForm).forEach(function(i) {
                data[i] = vm.createForm[i];
            });
            $.ajax({
                type: 'post',
                url: asyncLink.create,
                data: data,
                dataType: 'json',
                success: function (res) {
                    if (res.code !== 0) {
                        layer.msg(res.message);
                    } else {
                        vm.createFormVisible = false;
                        vm.loadList();
                    }
                },
                error: function (e) {
                    layer.msg('创建失败，ErrorCode' + e.status);
                },
                complete: function () {
                    NProgress.done();
                },
            });
            return this;
        },
        /**
         * 更新状态
         * @param {Object} item 单行数据对象
         * @param {String} status 变更状态
         */
        updateCode: function (item, status, cb) {
            NProgress.start();
            $.ajax({
                type: 'post',
                url: asyncLink.status,
                data: {
                    ID: item.ID,
                    status: status,
                },
                dataType: 'json',
                success: function (res) {
                    if (res.code !== 0) {
                        layer.msg(res.message);
                    } else {
                        item.Status = parseInt(status, 10);
                    }
                },
                error: function (e) {
                    layer.msg('操作失败，ErrorCode' + e.status);
                },
                complete: function () {
                    NProgress.done();
                    if (typeof cb === 'function') {
                        cb();
                    }
                },
            });
        },
        /**
         * 删除Code
         * @param {Object} item 单行数据对象
         */
        deleteCode: function (item, cb) {
            var vm = this;
            NProgress.start();
            var deleteID = item.ID;
            $.ajax({
                type: 'post',
                url: asyncLink.delete,
                data: {
                    ID: item.ID,
                },
                dataType: 'json',
                success: function (res) {
                    if (res.code !== 0) {
                        layer.msg(res.message);
                    } else {
                        item.delete = true;
                        setTimeout(function () {
                            for (var i = 0; i < vm.list.length; i += 1) {
                                if (vm.list[i].ID === deleteID) {
                                    var list = vm.list.slice();
                                    list.splice(i, 1);
                                    vm.list = list;
                                    break;
                                }
                            }
                        }, 2000);
                    }
                },
                error: function (e) {
                    layer.msg('操作失败，ErrorCode' + e.status);
                },
                complete: function () {
                    NProgress.done();
                    if (typeof cb === 'function') {
                        cb();
                    }
                },
            });
        },
        /**
         * 全选
         */
        checkAll: function () {
            var list = [];
            if (!this.theadAllChecked) {
                this.list.forEach(function (i) {
                    list.push(i.ID);
                });
            }
            this.checkboxList = list;
        },
        /**
         * 反选
         */
        checkReverse: function () {
            var checkList = this.checkboxList.slice();
            var list = [];
            this.list.forEach(function (i) {
                if (checkList.indexOf(i.ID) === -1) {
                    list.push(i.ID);
                }
            });
            this.checkboxList = list;
        },
        /**
         * 单击单条数据
         */
        checkItem: function (item) {
            var index = this.checkboxList.indexOf(item.ID);
            if (index > -1) {
                this.checkboxList.splice(index, 1);
            } else {
                this.checkboxList.push(item.ID);
            }
        },
        /**
         * 复制单个Code
         * @param {String} code 兑换码
         */
        copyCode: function (code) {
            try {
                clipboard.writeText(code);
                layer.msg('复制成功');
            } catch (err) {
                layer.msg('复制失败');
            }
        },
        /**
         * 一键复制
         */
        copyCheckedCode: function () {
            var checkList = this.checkboxList;
            var list = [];
            this.list.forEach(function (i) {
                if (checkList.indexOf(i.ID) > -1) {
                    list.push(i.CodeString);
                }
            });
            try {
                clipboard.writeText(list.join("\r\n"));
                layer.msg('复制成功');
            } catch (err) {
                layer.msg('复制失败');
            }
        },
        /**
         * 批量禁用
         * 不想写批量了……用单条复用吧。。。
         */
        batchDisable: function () {
            var checkList = this.checkboxList;
            var list = [];
            this.list.forEach(function (i) {
                if (checkList.indexOf(i.ID) > -1) {
                    list.push(i);
                }
            });
            var vm = this;
            var update = function (key) {
                var item = list[key];
                vm.updateCode(item, '2', function() {
                    if (key + 1 < list.length) {
                        update(key + 1);
                    }
                });
            }
            if (list.length > 0) {
                update(0);
            }
        },
        /**
         * 批量启用
         */
        batchEnable: function () {
            var checkList = this.checkboxList;
            var list = [];
            this.list.forEach(function (i) {
                if (checkList.indexOf(i.ID) > -1) {
                    list.push(i);
                }
            });
            var vm = this;
            var update = function (key) {
                var item = list[key];
                vm.updateCode(item, '0', function() {
                    if (key + 1 < list.length) {
                        update(key + 1);
                    }
                });
            }
            if (list.length > 0) {
                update(0);
            }
        },
        /**
         * 批量删除
         */
        batchDelete: function () {
            var checkList = this.checkboxList;
            var list = [];
            this.list.forEach(function (i) {
                if (checkList.indexOf(i.ID) > -1) {
                    list.push(i);
                }
            });
            var vm = this;
            var deleteItem = function (key) {
                var item = list[key];
                vm.deleteCode(item, function() {
                    if (key + 1 < list.length) {
                        deleteItem(key + 1);
                    }
                });
            }
            if (list.length > 0) {
                deleteItem(0);
            }
        },
    },
});

});