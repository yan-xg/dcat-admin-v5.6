// const ApiRootUrl = 'https://xz.xingzan66.com/api/';
const ApiRootUrl = 'http://dcat-admin-v56.cc/api/';

module.exports = {
    // 首页
    IndexUrl: ApiRootUrl + 'index', //首页数据接口

    // 分类
    CategoryList: ApiRootUrl + 'category/list', //分类目录全部分类数据接口
    GetCurrentList: ApiRootUrl + 'category/currentlist',//对应分类下商品

    // 商品
    GoodsCount: ApiRootUrl + 'goods/count', //统计商品总数
    GoodsList: ApiRootUrl + 'goods/searchlist', //商品搜索列表
    GoodsDetail: ApiRootUrl + 'goods/detail', //获得商品的详情
    // GoodsShare: ApiRootUrl + 'goods/goodsShare', //分享商品
    // SaveUserId: ApiRootUrl + 'goods/saveUserId',

    // 搜索
    SearchHelper: ApiRootUrl + 'search/helper', //搜索帮助
    // SearchIndex: ApiRootUrl + 'search/index', //搜索页面默认数据
    // SearchClearHistory: ApiRootUrl + 'search/clearHistory', //历史记录

    // 登录
    AuthLoginByWeixin: ApiRootUrl + 'auth/loginByWeixin', //微信登录

    // 我的
    // OrderCountInfo: ApiRootUrl + 'order/orderCount', // 我的页面获取订单数状态
    userSetting: ApiRootUrl + 'settings/userSetting',
    userDetail: ApiRootUrl + 'settings/userDetail',

    // 收货地址
    GetAddresses: ApiRootUrl + 'address/getAddresses',//获取收货地址列表
    SaveAddress: ApiRootUrl + 'address/saveAddress', //保存收货地址
    RegionList: ApiRootUrl + 'region/list', //获取区域列表
    AddressDetail: ApiRootUrl + 'address/addressDetail', //收货地址详情
    DeleteAddress: ApiRootUrl + 'address/deleteAddress', //删除收获地址
    

    /*
    // 购物车
    CartAdd: ApiRootUrl + 'cart/add', // 添加商品到购物车
    CartList: ApiRootUrl + 'cart/index', //获取购物车的数据
    CartUpdate: ApiRootUrl + 'cart/update', // 更新购物车的商品
    CartDelete: ApiRootUrl + 'cart/delete', // 删除购物车的商品
    CartChecked: ApiRootUrl + 'cart/checked', // 选择或取消选择商品
    CartGoodsCount: ApiRootUrl + 'cart/goodsCount', // 获取购物车商品件数
    CartCheckout: ApiRootUrl + 'cart/checkout', // 下单前信息确认

    
    PayPrepayId: ApiRootUrl + 'pay/preWeixinPay', //获取微信统一下单prepay_id
    OrderSubmit: ApiRootUrl + 'order/submit', // 提交订单
    OrderList: ApiRootUrl + 'order/list', //订单列表
    OrderDetail: ApiRootUrl + 'order/detail', //订单详情
    OrderDelete: ApiRootUrl + 'order/delete', //订单删除
    OrderCancel: ApiRootUrl + 'order/cancel', //取消订单
    OrderConfirm: ApiRootUrl + 'order/confirm', //物流详情
    OrderCount: ApiRootUrl + 'order/count', // 获取订单数
    
    OrderExpressInfo: ApiRootUrl + 'order/express', //物流信息
    OrderGoods: ApiRootUrl + 'order/orderGoods', // 获取checkout页面的商品列表
    
    // 足迹
    FootprintList: ApiRootUrl + 'footprint/list', //足迹列表
    FootprintDelete: ApiRootUrl + 'footprint/delete', //删除足迹

    GetBase64: ApiRootUrl + 'qrcode/getBase64', //获取商品详情二维码
    */

};
