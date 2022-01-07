var util = require('../../utils/util.js');
var api = require('../../config/api.js');

Page({
    data: {
        navList: [],
        categoryList: [],
        currentCategory: {},
        goodsCount: 0,
        nowIndex: 0,
        nowId: 0,
        list: [],
        currentPage: 1,//当前页
        maxPage:0,//最大页
        allCount: 0,//商品总量
        size: 8,//每页数量
        hasInfo: 0,
        showNoMore: 0,
        loading:0,
        index_banner_img:0,
    },
    onLoad: function(options) {
    },
    onPullDownRefresh: function() {
        wx.showNavigationBarLoading()
        this.getCatalog();
        wx.hideNavigationBarLoading() //完成停止加载
        wx.stopPullDownRefresh() //停止下拉刷新
    },
    getCatalog: function() {
        //CatalogList
        let that = this;
        util.request(api.CategoryList).then(function(res) {
            that.setData({
                navList: res.data.categoryList,
            });
        });
        util.request(api.GoodsCount).then(function(res) {
            that.setData({
                goodsCount: res.data.goodsCount
            });
        });
    },
    
    getCurrentList: function(id) {
        let that = this;
        util.request(api.GetCurrentList, {
            size: that.data.size,
            page: that.data.currentPage,
            category_id: id
        }, 'POST').then(function(res) {
            if (res.code == 200) {
                let count = res.data.total;
                that.setData({
                    allCount: count,
                    currentPage: res.data.current_page,
                    maxPage:res.data.last_page,
                    list: that.data.list.concat(res.data.data),
                    showNoMore: 1,
                    loading: 0,
                });
                if (count == 0) {
                    that.setData({
                        hasInfo: 0,
                        showNoMore: 0
                    });
                }
            }
        });
    },
    onShow: function() {
        let id = this.data.nowId;
        let nowId = wx.getStorageSync('categoryId');
        if(id == 0 && nowId === 0){
            return false
        }
        else if (nowId == 0 && nowId === '') {
            this.setData({
                list: [],
                currentPage: 1,
                allCount: 0,
                size: 8,
                loading: 1
            })
            this.getCurrentList(0);
            this.setData({
                nowId: 0,
                currentCategory: {}
            })
            wx.setStorageSync('categoryId', 0)
        } else if(id != nowId) {
            this.setData({
                list: [],
                currentPage: 1,
                allCount: 0,
                size: 8,
                loading: 1
            })
            this.getCurrentList(nowId);
            this.setData({
                nowId: nowId
            })
            wx.setStorageSync('categoryId', nowId)
        }
        
        this.getCatalog();
    },
    switchCate: function(e) {
        let id = e.currentTarget.dataset.id;
        let nowId = this.data.nowId;
        if (id == nowId) {
            return false;
        } else {
            this.setData({
                list: [],
                currentPage: 1,
                allCount: 0,
                size: 8,
                loading: 1
            })
            if (id == 0) {
                this.getCurrentList(0);
                this.setData({
                    currentCategory: {}
                })
            } else {
                wx.setStorageSync('categoryId', id)
                this.getCurrentList(id);
            }
            wx.setStorageSync('categoryId', id)
            this.setData({
                nowId: id
            })
        }
    },
    onBottom: function() {
        let that = this;
        console.log(that.data.allCount);
        console.log(that.data.size);
        console.log(that.data.currentPage);
        if (that.data.maxPage <= that.data.currentPage) {
            that.setData({
                showNoMore: 0
            });
            return false;
        }
        that.setData({
            currentPage: that.data.currentPage + 1
        });
        let nowId = that.data.nowId;
        if (nowId == 0 || nowId == undefined) {
            that.getCurrentList(0);
        } else {
            that.getCurrentList(nowId);
        }
    }
})