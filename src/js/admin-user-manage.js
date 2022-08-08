window.addEventListener('load', function () {

/**
 * 邀请码管理
 * 依赖jQuery的ajax部分
 */
document.querySelector('#app').style.display = 'block';
new Vue({
    el: '#app',
    data: function() {
        return {
            filter: {
                status: '',
                searchType: 'name',
                keyword: '',
            },
            filterSelectVisible: '',
            statusList: [
                {
                    name: '全部',
                    value: '',
                },
                {
                    name: '正常登录',
                    value: '0',
                },
                {
                    name: '禁止登录',
                    value: '1',
                },
            ],
            statusName: '全部',
            searchTypeList: [
                {
                    name: '用户账号',
                    value: 'name',
                },
                {
                    name: '用户昵称',
                    value: 'alias',
                },
                {
                    name: '手机号码',
                    value: 'phone',
                },
                {
                    name: '邮箱地址',
                    value: 'email',
                },
            ],
            searchTypeName: '用户账号',
            list: [],
            page: 1,
            size: 20,
            total: 0,
        };
    },
    computed: {
        theadHalfChecked: function () {
            return (this.checkboxList.length > 0 && this.checkboxList.length < this.list.length);
        },
        theadAllChecked: function () {
            return (this.checkboxList.length > 0 && this.checkboxList.length === this.list.length);
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
        loadList: function () {},
        /**
         * 处理分页
         */
        handlePagebar: function () {
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
                this.loadList();
            } else if (type === 'searchType') {
                vm.filter.searchType = item.value;
                vm.searchTypeName = item.name;
            }
            vm.filterSelectVisible = '';
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
    },
});

});
