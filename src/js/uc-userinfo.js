!function () {
var UCUserInfo, CL;

CL = UCUserInfo = function () {
    this.data = {};
    this.elem = {};

    var _this = this;
    var cmdList = document.querySelectorAll('.uc-setting [data-command]');
    for (var i = 0; i < cmdList.length; i += 1) {
        var item = cmdList[i];
        item.addEventListener('click', function () {
            var cmd = this.getAttribute('data-command');
            _this.command(cmd);
        });
    }
};

CL.fn = CL.prototype;

CL.fn.command = function (command) {
    switch (command) {
        case 'upload-avatar':
            this.uploadAvatar();
        break;
        case 'update-userinfo':
            this.updateUserinfo();
        break;
        case 'update-password':
            this.updatePassword();
        break;
        default:
    }
    return this;
};

/**
 * 上传头像
 */
CL.fn.uploadAvatar = function () {
    this.data.uploadAvatarIndex = layer.open({
        type: 2,
        title: '上传头像',
        content: window.iframeUrls['upload-avatar'],
        area: ['650px', '450px'],
    });
    return this;
};

/**
 * 设置用户信息
 */
CL.fn.updateUserinfo = function () {
    this.data.updateUserinfoIndex = layer.open({
        type: 2,
        title: '设置用户信息',
        content: window.iframeUrls['update-userinfo'],
        area: ['450px', '360px'],
    });
    return this;
};

/**
 * 设置用户信息
 */
CL.fn.updatePassword = function () {
    this.data.updatePasswordIndex = layer.open({
        type: 2,
        title: '修改密码',
        content: window.iframeUrls['update-password'],
        area: ['450px', '300px'],
    });
    return this;
};

new UCUserInfo();
}();
