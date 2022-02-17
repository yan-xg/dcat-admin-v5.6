var util = require('../../../utils/util.js');
var api = require('../../../config/api.js');
const userInfo = wx.getStorageSync('userInfo');
const app = getApp()

Page({
    data: {
        goodsList: [],
    },
    onLoad: function(options) {
        if(options.addType == 1 && options.goodId == undefined){
            wx.showToast({
                image: '/images/icon/icon_error.png',
                title: '信息获取错误',
            });
            return false;
        }
        this.getGoodsList(options.id, options.addType, options.goodId, options.amount);
    },
    getGoodsList: function(orderId=0, addType, goodId, amount) {
        let that = this;
        util.request(api.OrderGoods, {
            orderId: orderId,
            user_id:userInfo.uid,
            addType:addType,
            goodId:goodId,
            amount,amount
        }).then(function(res) {
            if (res.code == 200) {
                that.setData({
                    goodsList: res.data.GoodsList
                });
            }
        });
    }
})