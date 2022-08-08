!function () {
var Avatar, CL;
CL = Avatar = function () {
    this.data = {};
    this.elem = {};
    this.status = {};

    this.init = function (options) {
        var _this = this;

        this.elem.main = document.querySelector(options.main);
        this.elem.avatarPreview = document.querySelectorAll(options.avatarPreview);
        this.cropper = new Cropper(this.elem.main, {
            aspectRatio: 1 / 1,
            preview: this.elem.avatarPreview,
            minCropBoxWidth: 100,
            minCropBoxHeight: 100,
            viewMode: 1,
            dragMode: 'move',
        });

        this.elem.selectImage = document.querySelector(options.selectImage);
        if (this.elem.selectImage) {
            this.selectImageWatch();
        }

        this.elem.uploadForm = document.querySelector(options.uploadForm);
        if (this.elem.uploadForm) {
            this.elem.uploadForm.addEventListener('submit', function () {
                _this.uploadAvatar(this);
            });
        }
    };
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
 * 选择图片
 */
CL.fn.selectImageWatch = function () {
    var _this = this;
    this.data.URL = window.URL || window.webkitURL;
    if (this.data.URL) {
        this.elem.selectImage.addEventListener('change', function () {
            var files = this.files;
            if (files && files.length) {
                var file = files[0];
                if (/^image\/\w+$/.test(file.type)) {
                    _this.data.blobURL = _this.data.URL.createObjectURL(file);
                    _this.cropper.replace(_this.data.blobURL);
                    _this.elem.selectImage.value = '';
                } else {
                    layer.msg('请选择一张图片');
                }
            }
        });
    }
    return this;
};

/**
 * 上传头像
 */
CL.fn.uploadAvatar = function (formElem) {
    if (this.status.uploadAvatar) {
        return this;
    }
    var _this = this;
    this.status.uploadAvatar = true;
    this.loading(true);
    this.cropper.getCroppedCanvas({
        width: 256,
        height: 256,
    }).toBlob(function (blob) {
        var formData = new FormData();
        formData.append('file', blob, 'avatar.png');
        $.ajax({
            url: formElem.getAttribute('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(res) {
                if (res.code === 0) {
                    _this.msg('上传成功');
                    if (window.parent) {
                        var list = window.parent.document.querySelectorAll('[data-key="avatar"]');
                        for (var i = 0; i < list.length; i += 1) {
                            var item = list[i];
                            item.setAttribute('src', res.result);
                        }
                    }
                    setTimeout(function () {
                        _this.close();
                    }, 2000);
                } else {
                    _this.status.uploadAvatar = false;
                    _this.msg(res.message);
                }
            },
            error: function () {
                _this.status.uploadAvatar = false;
                _this.msg('上传失败');
            },
            complete: function() {
                _this.loading(false);
            },
        });
    });
    return this;
};

/**
 * 关闭
 */
CL.fn.close = function () {
    var parent = window.parent;
    if (parent && parent.layer) {
        var index = parent.layer.getFrameIndex(window.name);
        parent.layer.close(index);
        return this;
    }
    this.msg('关闭失败');
    return this;
};

window.$$AvatarUpload = Avatar;
}();