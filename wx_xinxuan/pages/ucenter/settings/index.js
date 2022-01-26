var util = require('../../../utils/util.js');
var api = require('../../../config/api.js');
var app = getApp();
Page({
    data: {
        name: '',
        mobile: '',
        status: 0,
    },
    mobilechange(e) {
        let mobile = e.detail.value;
        this.setData({
            mobile: mobile,
            status: 0
        });
        if (util.testMobile(mobile)) {
            this.setData({
                mobile: mobile,
                status: 1
            });
        }
    },
    bindinputName(event) {
        let name = event.detail.value;
        let mobile = this.data.mobile;
        this.setData({
            name: name,
        });
        if (util.testMobile(mobile)) {
            this.setData({
                status: 1
            });
        }
    },
    getSettingsDetail() {
        let that = this;
        let uid = wx.getStorageSync('uid');
        util.request(api.userDetail,{uid: uid}, 'POST').then(function(res) {
            if (res.code == 200) {
                that.setData({
                    name: res.data.real_name,
                    mobile: res.data.ipone,
                });
                if (res.data.real_name == '' || res.data.ipone == ''){
                    util.showErrorToast('请填写姓名和手机');
                }
            }
        });
    },
    onLoad: function(options) {
        this.getSettingsDetail();
    },
    saveInfo() {
        let name = this.data.name;
        let mobile = this.data.mobile;
        let status = this.data.status;
        let uid = wx.getStorageSync('uid');
        if (name == '') {
            util.showErrorToast('请输入姓名');
            return false;
        }
        if (mobile == '') {
            util.showErrorToast('请输入手机号码');
            return false;
        }
        let that = this;
        util.request(api.userSetting, {
            name: name,
            mobile: mobile,
            uid:uid
        }, 'POST').then(function(res) {
            if (res.code == 200) {
                util.showErrorToast('保存成功');
                wx.navigateBack()
            }
        });
    },
})