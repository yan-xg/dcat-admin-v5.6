var util = require('../../utils/util.js');
var api = require('../../config/api.js');
const pay = require('../../services/pay.js');
const userInfo = wx.getStorageSync('userInfo');
const app = getApp()

Page({
    data: {
        isDisabled:false,
        checkedGoodsList: [],
        checkedAddress: {},
        goodsTotalPrice: 0.00, //商品总价
        freightPrice: 0.00, //快递费
        orderTotalPrice: 0.00, //订单总价
        actualPrice: 0.00, //实际需要支付的总价
        addressId: 0,
        goodsCount: 0,
        postscript: '',
        outStock: 0,
        payMethodItems: [
            {
                name: 'online',
                value: '在线支付',
                checked: 'true'
            },
        ],
        payMethod:1,
    },
    payChange(e){
        let val = e.detail.value;
        if(val == 'offline'){
            this.setData({
                payMethod:0
            })
        }
        else{
            this.setData({
                payMethod:1
            })
        }
    },
    toGoodsList: function (e) {
        wx.navigateTo({
            url: '/pages/ucenter/goods-list/index?id=0&addType='+this.data.addType+'&goodId='+this.data.goodId+'&amount='+this.data.amount,
        });
    },
    toSelectAddress: function () {
        wx.navigateTo({
            url: '/pages/ucenter/address/index?type=1',
        });
    },
    toAddAddress: function () {
        wx.navigateTo({
            url: '/pages/ucenter/address-add/index',
        })
    },
    bindinputMemo(event) {
        let postscript = event.detail.value;
        this.setData({
            postscript: postscript
        });
    },
    onLoad: function (options) {
        let addType = options.addtype;
        let orderFrom = options.orderFrom;
        let goodId = options.good_id;
        let amount = options.amount;
        if (addType != undefined) {
            this.setData({
                addType: addType
            })
        }
        if (orderFrom != undefined) {
            this.setData({
                orderFrom: orderFrom
            })
        }
        if (goodId != undefined) {
            this.setData({
                goodId: goodId
            })
        }
        if (amount != undefined) {
            this.setData({
                amount: amount
            })
        }
    },
    onUnload: function () {
        wx.removeStorageSync('addressId');
    },
    onShow: function () {
        // 页面显示
        // TODO结算时，显示默认地址，而不是从storage中获取的地址值
        try {
            var addressId = wx.getStorageSync('addressId');
            if (addressId == 0 || addressId == '') {
                addressId = 0;
            }
            this.setData({
                'addressId': addressId
            });
        } catch (e) {}
        this.getCheckoutInfo();
    },
    onPullDownRefresh: function () {
        wx.showNavigationBarLoading()
        try {
            var addressId = wx.getStorageSync('addressId');
            if (addressId == 0 || addressId == '') {
                addressId = 0;
            }
            this.setData({
                'addressId': addressId
            });
        } catch (e) {
            // Do something when catch error
        }
        this.getCheckoutInfo();
        wx.hideNavigationBarLoading() //完成停止加载
        wx.stopPullDownRefresh() //停止下拉刷新
    },
    getCheckoutInfo: function () {
        let that = this;
        let addressId = that.data.addressId;
        let goodId = that.data.goodId;
        let amount = that.data.amount;
        let orderFrom = that.data.orderFrom;
        let addType = that.data.addType;
        util.request(api.CartCheckout, {
            user_id:userInfo.uid,
            addressId: addressId,
            goodId:goodId,
            amount:amount,
            addType: addType,
            orderFrom: orderFrom,
            type: 0
        }).then(function (res) {
            if (res.code == 200) {
                let addressId = 0;
                if (res.data.checkedAddress != 0) {
                    addressId = res.data.checkedAddress.id;
                }
                that.setData({
                    checkedGoodsList: res.data.checkedGoodsList,
                    checkedAddress: res.data.checkedAddress,
                    actualPrice: res.data.actualPrice,
                    addressId: addressId,
                    freightPrice: res.data.freightPrice,
                    goodsTotalPrice: res.data.goodsTotalPrice,
                    orderTotalPrice: res.data.orderTotalPrice,
                    goodsCount: res.data.goodsCount,
                    outStock: res.data.outStock
                });
                let goods = res.data.checkedGoodsList;
                wx.setStorageSync('addressId', addressId);
                if (res.data.outStock == 1) {
                    util.showErrorToast('有部分商品缺货或已下架');
                    that.setData({
                        isDisabled: true
                    });
                } else if (res.data.numberChange == 1) {
                    util.showErrorToast('部分商品库存有变动');
                }
            }
        });
    },
    // TODO 有个bug，用户没选择地址，支付无法继续进行，在切换过token的情况下
    submitOrder: function (e) {
        if (this.data.addressId <= 0) {
            util.showErrorToast('请选择收货地址');
            return false;
        }
        console.log(this.data)
        return false;
        let addressId = this.data.addressId;
        let postscript = this.data.postscript; //备注
        let freightPrice = this.data.freightPrice;//快递费
        let actualPrice = this.data.actualPrice;//实际价格
        wx.showLoading({
            title: '',
            mask:true
        })
        util.request(api.OrderSubmit, {
            addressId: addressId,
            postscript: postscript,
            freightPrice: freightPrice,
            actualPrice: actualPrice,
            offlinePay: 0
        }, 'POST').then(res => {
            if (res.errno === 0) {
                wx.removeStorageSync('orderId');
                wx.setStorageSync('addressId', 0);
                const orderId = res.data.orderInfo.id;
                pay.payOrder(parseInt(orderId)).then(res => {
                    wx.redirectTo({
                        url: '/pages/payResult/payResult?status=1&orderId=' + orderId
                    });
                }).catch(res => {
                    wx.redirectTo({
                        url: '/pages/payResult/payResult?status=0&orderId=' + orderId
                    });
                });
            } else {
                util.showErrorToast(res.errmsg);
            }
            wx.hideLoading()
        });
    },
    offlineOrder: function (e) {
        if (this.data.addressId <= 0) {
            util.showErrorToast('请选择收货地址');
            return false;
        }
        let addressId = this.data.addressId;
        let postscript = this.data.postscript;
        let freightPrice = this.data.freightPrice;
        let actualPrice = this.data.actualPrice;
        util.request(api.OrderSubmit, {
            addressId: addressId,
            postscript: postscript,
            freightPrice: freightPrice,
            actualPrice: actualPrice,
            offlinePay: 1
        }, 'POST').then(res => {
            if (res.errno === 0) {
                wx.removeStorageSync('orderId');
                wx.setStorageSync('addressId', 0);
                wx.redirectTo({
                    url: '/pages/payOffline/index?status=1',
                })
            } else {
                util.showErrorToast(res.errmsg);
                wx.redirectTo({
                    url: '/pages/payOffline/index?status=0',
                })
            }
        });
    }
})