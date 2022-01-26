const util = require('../../utils/util.js');
const api = require('../../config/api.js');
const user = require('../../services/user.js');
//获取应用实例
const app = getApp()

Page({
    data: {

    },
    onLoad: function (options) {

    },
    onShow: function () {
        let userInfo = wx.getStorageSync('userInfo');
        if (userInfo != '') {
            wx.navigateBack();
        };
    },
    // getUserInfo: function (e) {
    //     app.globalData.userInfo = e.detail.userInfo
    //     user.loginByWeixin().then(res => {
    //         app.globalData.userInfo = res.data.userInfo;
    //         app.globalData.token = res.data.token;
    //         let is_new = res.data.is_new;//服务器返回的数据；
    //         if (is_new == 0) {
    //             util.showErrorToast('您已经是老用户啦！');
    //             wx.navigateBack();
    //         }
    //         else if (is_new == 1) {
    //             wx.navigateBack();
    //         }

    //     }).catch((err) => { });
    // },

    getUserProfile: function (e) {
        // wx.navigateTo({
        //     url: '/pages/app-auth/index',
        // });
        let that = this;
        let code = '';
        wx.login({
            success: (res) => {
                code = res.code;
            },
        });
        // 获取用户信息
        wx.getUserProfile({
            lang: 'zh_CN',
            desc: '用户登录',
            success: (res) => {
                let loginParams = {
                    code: code,
                    encryptedData: res.encryptedData,
                    iv: res.iv,
                    rawData: res.rawData,
                    signature: res.signature
                };
                that.postLogin(loginParams);
            },
            // 失败回调
            fail: () => {
                // 弹出错误
                wx.showToast({
                    title: '已拒绝小程序获取信息',
                    icon: 'none',
                    duration: 2000//持续的时间
                  })
            }
        });
    },
    postLogin(info) {
        util.request(api.AuthLoginByWeixin, {
            info: info
        }, 'POST').then(function (res) {
            if (res.code == 200) {
                wx.setStorageSync('userInfo', res.data);
                wx.setStorageSync('token', res.data.token);
                wx.setStorageSync('uid', res.data.uid);
                app.globalData.userInfo = res.data;
                app.globalData.token = res.data.token;
                app.globalData.uid = res.data.uid;
                wx.navigateBack();
            }
        });
    },
    goBack: function () {
        wx.navigateBack();
    }
})