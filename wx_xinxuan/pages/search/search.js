var util = require('../../utils/util.js');
var api = require('../../config/api.js');

var app = getApp()
Page({
    data: {
        keywrod: '',
        searchStatus: false,
        goodsList: [],
        helpKeyword: [],
        historyKeyword: [],
        categoryFilter: false,
        currentSortType: 'default',
        filterCategory: [],
        defaultKeyword: {},
        hotKeyword: [],
        currentSortOrder: 'desc',
        salesSortOrder:'desc',
        categoryId: 0,
    },
    //事件处理函数
    closeSearch: function () {
        wx.navigateBack()
    },
    clearKeyword: function () {
        this.setData({
            keyword: '',
            searchStatus: false
        });
    },
    onLoad: function () {
        // 点击搜索展示默认，搜索历史，热门搜索
        // this.getSearchKeyword();
    },
    getSearchKeyword() {
        let that = this;
        util.request(api.SearchIndex).then(function (res) {
            console.log(res)
            if (res.code == 200) {
                that.setData({
                    // historyKeyword: res.data.historyKeywordList,
                    defaultKeyword: res.data.keyword,
                    // hotKeyword: res.data.hotKeywordList
                });
            }
        });
    },

    // 文本框搜索
    inputChange: function (e) {
        this.setData({
            keyword: e.detail.value,
            searchStatus: false
        });
        this.getHelpKeyword();
    },
    getHelpKeyword: function () {
        let that = this;
        util.request(api.SearchHelper, { keyword: that.data.keyword }, 'POST').then(function (res) {
            if (res.code == 200) {
                that.setData({
                    helpKeyword: res.data
                });
            }
        });
    },
    inputFocus: function () {
        this.setData({
            searchStatus: false,
            goodsList: []
        });
        if (this.data.keyword) {
            this.getHelpKeyword();
        }
    },

    //清除历史记录
    // clearHistory: function () {
    //     this.setData({
    //         historyKeyword: []
    //     })

    //     util.request(api.SearchClearHistory, {}, 'POST')
    //         .then(function (res) {
    //         });
    // },

    getGoodsList: function () {
        let that = this;
        // console.log(that.data);
        util.request(api.GoodsList, { keyword: that.data.keyword, sort: that.data.currentSortType, order: that.data.currentSortOrder, sales: that.data.salesSortOrder},'POST').then(function (res) {
            if (res.code == 200) {
                that.setData({
                    searchStatus: true,
                    // categoryFilter: false,
                    goodsList: res.data,
                    // filterCategory: res.data.filterCategory,
                    // page: res.data.currentPage,
                    //   size: res.data.numsPerPage
                });
            }else{
                //重新获取关键词
                that.getSearchKeyword();
            }
        });
    },
    onKeywordTap: function (event) {
        this.getSearchResult(event.target.dataset.keyword);
    },
    getSearchResult(keyword) {
        this.setData({
            keyword: keyword,
            page: 1,
            categoryId: 0,
            goodsList: []
        });

        this.getGoodsList();
    },
    openSortFilter: function (event) {
        let currentId = event.currentTarget.id;
        switch (currentId) {
            case 'salesSort':
                let _SortOrder = 'asc';
                if (this.data.salesSortOrder == 'asc') {
                    _SortOrder = 'desc';
                }
                this.setData({
                    'currentSortType': 'goods_stock',
                    'currentSortOrder': 'asc',
                    'salesSortOrder': _SortOrder
                });
                this.getGoodsList();
                break;
            case 'priceSort':
                let tmpSortOrder = 'asc';
                if (this.data.currentSortOrder == 'asc') {
                    tmpSortOrder = 'desc';
                }
                this.setData({
                    'currentSortType': 'goods_price',
                    'currentSortOrder': tmpSortOrder,
                    'salesSortOrder': 'asc'
                });
                this.getGoodsList();
                break;
            default:
                //综合排序
                this.setData({
                    'currentSortType': 'default',
                    'currentSortOrder': 'desc',
                    'salesSortOrder': 'desc'
                });
                this.getGoodsList();
        }
    },
    onKeywordConfirm(event) {
        this.getSearchResult(event.detail.value);
    }
})