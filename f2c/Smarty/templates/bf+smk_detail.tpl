<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>惠民商城 </title>
    <script src="public/js/mui.min.js"></script>
    <link href="public/css/mui.min.css" rel="stylesheet"/>
    <link href="public/css/common.css" rel="stylesheet"/>
    <link href="public/css/goods-detail.css" rel="stylesheet"/>
    <script src="public/js/zepto.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="public/js/lazyload.min.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" src="public/js/jweixin.js"></script>
    <script src="public/js/utils.js" type="text/javascript" charset="utf-8"></script>
    <script src="public/js/detail.js" type="text/javascript" charset="utf-8"></script>

    <style>
        {literal}
        .mui-pull-right a{
            margin: 0 0 10px 10px;
            padding: 2px 10px;
            display: inline-block;
            width: auto;
            font-size: .26rem;
            color: #878686;
            background-color: transparent;
            border: 1px solid #878686;"
        }
        .mui-pull-right .active{
            border-color: #e53348;
            background: url(images/checked.png) no-repeat bottom right;
        }
        .show-content{
            padding: 0 10px;
        }
        .show-content dd{
            margin: 0;
        }
        .show-content dd.name{
            margin-bottom: 10px;
            border-left: 4px solid #fe4205;
            padding-left: 5px;
        }
        .detail p{
            line-height: 20px;
            margin-bottom: 10px;
        }
        header.mui-bar-nav{
            background: #f9f9f9;
        }
        .mui-bar-nav.mui-bar .mui-icon.mui-icon-back{
            color: #000;
        }
        .tab.mui-segmented-control .mui-control-item{
            color: #000;
        }
        .tab.mui-segmented-control .mui-control-item.mui-active{
            background-color: #f9f9f9;
            color: #000;
        }
        .tab .mui-control-item.mui-active:after{
            background: #000;
        }
        .mui-bar .tab.mui-segmented-control{
            background-color: #f9f9f9;
        }
        .mui-bar{
            height: 40px;
        }
        .show-content{
            letter-spacing: 1px;
        }
        .t-right p{
            margin-bottom: 0;
            font-size: .28rem;
        }
        .goods-tips{
            padding: 10px 5px;
        }
        {/literal}
    </style>
</head>
<body>
<div class="container">
    <header class="mui-bar mui-bar-nav">
        <span class="mui-icon mui-icon-back mui-icon mui-action-back mui-icon-back mui-pull-left"></span>
        {*<span class="icon icon-more">&#xe74f;</span>*}
        <div class="tab mui-segmented-control">
            <a class="mui-control-item mui-active" href="#goods">商品</a>
            <a class="mui-control-item" href="#detail">详情</a>
            <a class="mui-control-item" href="#evaluate">评价</a>
        </div>
    </header>
    <!-- 底部按钮 -->
    <nav class="mui-bar mui-bar-tab bottom">
        <ul class="mui-table-view mui-grid-view mui-grid-9">
            <li class="mui-table-view-cell mui-media mui-col-xs-2">
                <a href="/webim.php" class="webim">
                    <span class="mui-icon icon" style="font-size: 20px;">&#xe70d;</span>
                    <div class="mui-media-body"  style="font-size: 9px;">客服</div>
                </a>
            </li>
            <li class="mui-table-view-cell mui-media mui-col-xs-2">
                {if $mycollections eq '0'}
                    <a id="collection" href="#">
                        <span class="mui-icon icon" style="font-size: 20px;">&#xe62b;</span>
                        <div class="mui-media-body"  style="font-size: 9px;">收藏</div>
                    </a>
                {else}
                    <a id="collection" href="#" class="red">
                        <span class="mui-icon icon" style="font-size: 20px;">&#xe614;</span>
                        <div class="mui-media-body" style="font-size: 9px;">已收藏</div>
                    </a>
                {/if}

            </li>
            <li class="mui-table-view-cell mui-media mui-col-xs-2">
                <a href="/shoppingcart.php" class="shoppingcart" id="gouwuche">
					<span class="mui-icon icon"  id="shoppingcart" style="font-size: 20px;"><span id="shoppingcart_badge" >
                        {if $share_info.shoppingcart neq '0' && $share_info.shoppingcart neq '' }<span class="mui-badge mui-badge-red" >{$share_info.shoppingcart}</span>{/if}&#xe64f;</span></span>
                    <div class="mui-media-body" style="font-size: 9px;">购物车</div>
                </a>
            </li>
            <li class="mui-table-view-cell mui-media mui-col-xs-3 add-cart">
                <a href="#" class="addshoppingcart">
                    加入购物车
                </a>
            </li>
            <li class="mui-table-view-cell mui-media mui-col-xs-3 pay">
                <a href="shoppingcart.php" class="shoppingcart">
                    立即购买
                </a>
            </li>
        </ul>
    </nav>
    <div class="mui-content mui-scroll-wrapper" id="pullrefresh">
        <div class="mui-scroll">
            <div class="mui-content-padded goods-content"  id="propertygroup">
                <!-- 商品 -->
                <div id="goods" class="mui-control-content mui-active">
                    <!-- 轮播 -->
                    <div class="mui-slider">
                        <div class="mui-slider-group">
                            <div class="mui-slider-item"><img  id="productlogo" src="{$productinfo.productlogo}"/></div>
                        </div>
                    </div>
                    <!-- 商品价格 -->
                    <input type="hidden" id="property_type_count" value="{$property_type_count}" />
                    <input type="hidden" id="from" value="{$from}" />
                    <input type="hidden" id="product_property_id" name="product_property_id" value="" />
                    <input type="hidden" id="pagenum" name="pagenum" value="{$pagenum}">
                    <input type="hidden" id="scrolltop" name="scrolltop" value="{$scrolltop}">
                    <input type="hidden" id="productid" name="productid" value="{$productid}">
                    <input type="hidden" name="total_price" id="total_price1" value="{$productinfo.shop_price}" />
                    <input type="hidden" name="shop_price" id="shop_price1" value="{$productinfo.shop_price}" />
                    <input type="hidden" name="inventory" id="inventory1" value="{$productinfo.inventory}" />
                    <input type="hidden" name="zhekou" id="zhekou" value="{$productinfo.zhekou}" />
                    <input type="hidden" name="salesactivityid" id="salesactivityid" value="{$productinfo.salesactivityid}" />
                    <input type="hidden" name="salesactivity_product_id" id="salesactivity_product_id" value="{$productinfo.salesactivity_product_id}" />
                    <input type="hidden" name="type" id="type" value="{$type}" />

                    <input type="hidden" id="jd" value="{$jd}" />


                    <div class="mui-row goods-title">
                        <div class="mui-col-xs-2"><span class="goods-tag">自营</span></div>

                        <h4 class="mui-col-xs-10">{$productinfo.productname}</h4>
                        <div class="clear"></div>
                        <div class="goods-price">
                            {if $productinfo.activityname neq '' &&  $productinfo.zhekoulabel neq '' && $productinfo.zhekou neq ''}
                                <span id="shop_price"  style="color: #f23030;">￥{$productinfo.promotional_price}</span>
                            {else}
                                <span id="shop_price"  style="color: #f23030;">￥{$productinfo.shop_price}</span>
                            {/if}

                            {if $productinfo.activityname neq '' &&  $productinfo.zhekoulabel neq '' && $productinfo.zhekou neq ''}
                                <!-- <s>￥<span id="old_shop_price"  style="color: #000;">{$productinfo.market_price}</span></s> -->
                                <s>￥{$productinfo.shop_price}</s>
                            {/if}

                            <!-- <input type="hidden" id="mycollection" value="{$mycollections}"> -->
                        </div>
                    </div>
                    <div class="h20"></div>
                    <!-- 优惠信息 -->
                    {if $productinfo.activityname neq '' &&  $productinfo.zhekoulabel neq '' && $productinfo.zhekou neq ''}
                        <div class="mui-row wrap">
                            <div class="t-left mui-pull-left" style="color: #8f8f94">优惠信息：</div>
                            <div class="t-right mui-pull-left">
                                <p><span > {$productinfo.activityname}【{$productinfo.zhekoulabel}】</span></p>
                            </div>
                        </div>
                        <div class="h20"></div>
                    {/if}
                    <!-- 供应商 -->
                    {if $productinfo.vendorname neq '' && $supplier_info.showvendor eq '1'}
                        <div class="mui-row wrap">
                            <div class="t-left mui-pull-left" style="color: #8f8f94">供应商：</div>
                            <div class="t-right mui-pull-left">
                                <p><span > {$productinfo.vendorname}</span></p>
                            </div>
                        </div>
                        <div class="h20"></div>
                    {/if}
                    <div class="mui-row wrap">
                        {if $activitynames neq '该商品没有参加其他活动'}
                        <div class="t-left mui-pull-left"  style="color: #8f8f94">此商品正在参与活动：</div>
                        <div id="add_salelist" class="mui-pull-right red"><span style="display: inline-block;">查看全部</span><span class="mui-icon mui-icon-arrowright" style="font-size: 14px;"></span></div>
                        <br>
                        <div class="mui-pull-left">
                                 <ul style="margin:0px;padding-left: 18px;font-size: 11px;text-decoration: underline;">
                                    <!--循环加载出li内的“href”和“打折活动名称”-zl-->
                                    {*<li>{$activitynames}</li>*}
                                     {if $activitynames neq '该商品没有参加其他活动'}
                                    {foreach name ="smk_detail" from = "$activitynames" item =activityname }
                                        <li class="salelist"><a href="{$sleslink}" style="color:#333">{$activityname} </a></li>
                                    {/foreach}
                                     {/if}
                                </ul>
                         </div>
                        {/if}
                    </div>
                    <div class="mui-row wrap">
                        <div class="t-left mui-pull-left"  style="color: #8f8f94">库存数量：</div>
                        <div class="t-right mui-pull-left">
                            {if $jd eq '1'}
                                <p style="color: #000;"><span id="inventory_label"> </span>{if $productinfo.inventory eq '0'}无货{else}有货{/if}</p>
                            {else}
                                <p style="color: #000;"><span id="inventory_label"> {$productinfo.inventory}</span>&nbsp;件</p>
                            {/if}

                        </div>
                    </div>
                    <div class="h20"></div>


                    <!-- <div class="mui-row wrap">
                        <div class="t-left mui-pull-left">邮费：</div>
                        <div class="t-right mui-pull-left">
                            <p style="color: #000;"><span id="postage_span"> ￥{$productinfo.postage}</span>元
                                {if $productinfo.includepost|@intval gt 0}
                                    <span ({$productinfo.includepost}件包邮)</span>
                                {/if}
                            </p>

                        </div>
                    </div>
                    <div class="h20"></div> -->
                    <!-- 商品信息 -->
                    <div class="mui-row wrap">
                        <div class="t-left mui-pull-left" style="color: #8f8f94">已选：</div>
                        <div class="t-right mui-pull-left">

                            {foreach name="propertygroup" item=property_info key=property_name from=$property_type}

                                <div class="mui-row">
                                    <span style="color: #000">{$property_name}</span>
                                    <div class="mui-pull-right tags clear">
                                        <input type="hidden" id="propertygroup_label_{$smarty.foreach.propertygroup.iteration}" value="{$property_name}" />
                                        {foreach name="property" item=property key=propertyid from=$property_info}

                                            <a  class=" propertygroup_{$smarty.foreach.propertygroup.iteration}" groupid="{$smarty.foreach.propertygroup.iteration}" propertyid="{$propertyid}" href="javascript:;"  >{$property}
                                                <div style="display:none">
                                                    <input class="propertygroup_input_{$smarty.foreach.propertygroup.iteration}" id="property_{$smarty.foreach.propertygroup.iteration}_{$propertyid}" type="radio" name="propertygroup_{$smarty.foreach.propertygroup.iteration}" propertyid="{$propertyid}" value="{$property}" />
                                                </div>
                                            </a>

                                        {/foreach}

                                    </div>
                                </div>
                            {/foreach}
                            <!-- 数量 -->
                            <div class="mui-row">
                                <span class="mui-pull-left" style="color: #000;">数量</span>
                                <div class="mui-pull-left">
                                    <div class="mui-numbox" data-numbox-step='1' data-numbox-min='1' data-numbox-max='999'>
                                        <button class="mui-btn mui-numbox-btn-minus" type="button">-</button>
                                        <input value="{$productinfo.postage}" id="postage" type="hidden"/>
                                        <input value="{$productinfo.includepost}" id="includepost" type="hidden"/>
                                        <input value="{$productinfo.mergepostage}" id="mergepostage" type="hidden"/>
                                        <input onkeyup="recalc();" readonly   id="qty_item" name="qty_item" class="mui-numbox-input" type="number" />
                                        <button class="mui-btn mui-numbox-btn-plus" type="button">+</button>
                                    </div>
                                </div>
                            </div>
                            <!-- 其他信息 -->

                        </div>
                    </div>
                    <!-- 售后信息 -->
                    <div class="goods-tips">
                        {if $productid eq '417982' || $productid eq '418562' || $productid eq '418551'}
                        <p class="clear">
                            <span style="width: 140px;float: left;"><span class="icon">&#xe660;</span>苏锡常包邮</span>
                            <span style="width: 140px;float: left;"><span class="icon">&#xe660;</span>7.1后陆续发货</span>
                        </p>
                        {elseif $productid eq '418486' || $productid eq '418558' || $productid eq '418564'}
                        <p class="clear">
                            <span style="width: 140px;float: left;"><span class="icon">&#xe660;</span>江浙沪包邮</span>
                            <span style="width: 140px;float: left;"><span class="icon">&#xe660;</span>7.1后陆续发货</span>
                        </p>
                        {elseif $productid eq '418546' || $productid eq '418560' || $productid eq '418569'}
                        <p class="clear">
                            <span style="width: 140px;float: left;"><span class="icon">&#xe660;</span>全国包邮</span>
                            <span style="width: 140px;float: left;"><span class="icon">&#xe660;</span>7.1后陆续发货</span>
                        </p>
                        {else}
                        <p class="clear">
                            <span style="width: 140px;float: left;"><span class="icon">&#xe660;</span>京东售后&发货</span>
                            <span style="width: 200px;float: left;"><span class="icon">&#xe660;</span>运费6元（满119元免运费）</span>
                        </p>
                        {/if}
                        <!-- <p class="clear">
                           <span style="width: 140px;float: left;"> <span class="icon">&#xe660;</span>满119包邮</span>
                            <span style="width: 140px;float: left;"><span class="icon">&#xe660;</span>极速到货</span>
                        </p> -->
                    </div>
                    <!--  <div class="h20"></div> -->
                    <div class="comment goods-comment">
                        <div class="comment-head clear">
               <span class="mui-pull-left"  style="font-size: .28rem !important;">评价内容</span>
        
                    <span id="more" class="mui-pull-right red"  style="font-size: .28rem !important;">查看全部<span class="mui-icon mui-icon-arrowright red"></span></span>
                        </div>
                        {if $appraises|@count eq 0}
                            <div class="comment">
                                <div class="comment-head clear" >
                                    <h5 style="text-align:center;color:#f23030" >目前没有评价。</h5>
                                </div>
                            </div>
                        {else}
                            {foreach name="appraises" item=appraises_info   from=$appraises}
                                <div class="comment" style="vertical-align: middle">
                                    <div class="comment-head clear" style="vertical-align: middle">
                                        <img style="margin-bottom:4px" class="mui-pull-left head-avator" src="{$appraises_info.headimgurl}" alt="">
                                        <span class="mui-pull-left" style="margin-left: 10px;line-height: .62rem">{$appraises_info.givenname}</span>
                                        <span class="mui-pull-right" style="line-height: .62rem">{$appraises_info.praise_info}</span>
                                    </div>
                                    <div class="comment-body">
                                        <!-- 评分，分级对应样式rate-1表示一颗星 -->
                                        <!--<div class="comment-rate rate-5"></div>-->
                                        <p>{$appraises_info.remark}</p>
                                        {if $appraises.hasimages gt 0}
                                            <div class="comment-img clear">
                                                {foreach name="appraise_images" item=appraise_image_info   from=$appraises.images}
                                                    <img src="images/goods7.jpg" alt="">
                                                {/foreach}
                                            </div>
                                        {/if}
                                        <p class="gray">{$appraises_info.published}</p>
                                    </div>
                                </div>
                            {/foreach}
                        {/if}
                    </div>
                    <div class="mui-row wrap">
                        <div class="h20"></div>
                        <div class="comment-head clear">
                            <span class="mui-pull-left">商品详情</span>
                        </div>
                        <div style="background: #FFFFFF; padding: 5px;margin:0px;margin-top: 5px;">
                            {$productinfo.description}
                        </div>
                    </div>
                </div>





                <!-- 详情 -->
                <div id="detail" class="mui-control-content">
                    <div class="mui-segmented-control">
                        <a class="mui-control-item mui-active" href="#item1">商品介绍</a>
                        <a class="mui-control-item" href="#item2">售后保障</a>
                    </div>
                    <div class="mui-content-padded">
                        <div id="item1" class="mui-control-content mui-active">
                            <div class="detail-content">
                                <div style="background: #FFFFFF; padding: 5px;margin:0px;margin-top: 5px;">
                                    {$productinfo.description}
                                </div>
                            </div>
                        </div>
                        <div id="item2" class="mui-control-content">
                            <div class="detail-content">
                                <!-- <h3 class="show-content" style="font-size: 18px">卖家承诺以下服务</h3> -->
                                <div class="show-content">
                                    <dl class="seven-days">
                                        <dd class="name">退换货规则</dd>
                                        <dd class="detail">
                                            <p>1.订单未支付前，可以随时取消该订单；</p>
                                            <p>2.订单支付成功后，若您想取消该订单，因为物流流转速度很快，请您提交退货退款申请后及时联系在线客服咨询此订单的配送情况，若订单尚未出库，会在3个工作日内为您办理退款，退款金额原路返回至您的账户。<span style="color: #f94302">若订单已经出库进入配送阶段，请您选择拒收此单，待订单退库成功后，3个工作日内为您办理退款，退款金额原路返回至您的账户。</span>若您不拒收此单，我们将拒绝您的退款申请；</p>
                                            <p>3.自客户收到商品之日起7日内可以退货，15日内可以换货</p>
                                            <p>4.您退货时应当将商品本身、配件及赠品（包括赠送的实物、积分、代金券、优惠券等形式）一并退回。若赠品不能一并退回，惠民商城有权要求您按照事先标明的赠品价格支付赠品价款。</p>
                                            <p>5.退货价款以您实际支出的价款为准。</p>
                                            <p>6.您退货时所产生的运费依法由您自行承担，另有约定的除外。</p>
                                            <p>7.该退换货规则根据实际运营情况酌情修改。</p>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <!-- <h3 class="show-content" style="font-size: 18px"><em>具体细则</em></h3> -->
                                        <dd class="name" >以下商品不支持无理由退货：</dd>
                                        <dd class="detail">
                                            <p>1.个人定制类；</p>
                                            <p>2.鲜活易腐类；</p>
                                            <p>3.在线下载类/拆封的音像制品/计算机软件等数字化商品；</p>
                                            <p>4.交付的报纸期刊类商品；</p>
                                            <p>5.根据商品性质不适宜退货，并经您在购买时确认的商品：</p>
                                            <p>a.拆封后易影响人身安全或者生命健康的商品，或者拆封后易导致商品品质发生改变的商品；</p>
                                            <p>b.一经激活或者试用后价值贬损较大的商品；</p>
                                            <p>c.销售时已明示的临近保质期的商品、有瑕疵的商品；</p>
                                            <p>d.其他根据商品性质不适宜退货，在商品页面标注“不支持无理由退货”并经您在购买时确认的商品；</p>
                                            <p>6.无法保证退回商品完好的商品（能够保持原有品质、功能，商品本身、配件、商标标识齐全的，视为商品完好）。</p>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dd class="name" >以下商品不支持退换货：</dd>
                                        <dd class="detail">
                                            <p>1.任何非惠民商城出售的商品；</p>
                                            <p>2.过保商品（超过三包保修期的商品）；</p>
                                            <p>3.未经授权的维修、误用、碰撞、疏忽、滥用、进液、事故、改动、不正确的安装所造成的商品质量问题，或撕毁、涂改标贴、机器序号、防伪标记；</p>
                                            <p>4.三包凭证信息与商品不符及被涂改的；</p>
                                            <p>5.其他依法不应办理退换货的。</p>
                                        </dd>
                                    </dl>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- 评价 -->
                <div id="evaluate" class="mui-control-content">
                    {if $appraises|@count eq 0}
                        <div class="comment">
                            <div class="comment-head clear">
                                <h5 style="text-align:center;color:#f23030" >目前没有评价。</h5>
                            </div>
                        </div>
                    {else}
                        {foreach name="appraises" item=appraises_info   from=$appraises}
                            <div class="comment">
                                <div class="comment-head clear">
                                    <img style="margin-bottom:4px" class="mui-pull-left head-avator" src="{$appraises_info.headimgurl}" alt="">
                                    <span class="mui-pull-left" style="margin-left: 10px;line-height: .62rem">{$appraises_info.givenname}</span>
                                    <span class="mui-pull-right" style="line-height: .62rem">{$appraises_info.praise_info}</span>
                                </div>
                                <div class="comment-body">
                                    <!-- 评分，分级对应样式rate-1表示一颗星 -->
                                    <!--<div class="comment-rate rate-5"></div>-->
                                    <p>{$appraises_info.remark}</p>
                                    {if $appraises.hasimages gt 0}
                                        <div class="comment-img clear">
                                            {foreach name="appraise_images" item=appraise_image_info   from=$appraises.images}
                                                <img src="images/goods7.jpg" alt="">
                                            {/foreach}
                                        </div>
                                    {/if}
                                    <p class="gray">{$appraises_info.published}</p>
                                </div>
                            </div>
                        {/foreach}
                    {/if}
                </div>
            </div>
            </span>
        </div>
    </div>
</body>
</html>
<script type="text/javascript" charset="utf-8">
    var propertys = {$propertys};
    {literal}
    //恢复a标签功能
    mui('body').on('tap','a',function(){
        window.top.location.href=this.href;
    });

    mui.init({
        pullRefresh: {
            container: '#pullrefresh'
        },
    });
    mui.ready(function() {
        if(Zepto('.salelist').length<4){
            Zepto('#add_salelist').hide();
        }else{
            Zepto('#add_salelist').show();
            salelists=Zepto('.salelist');
            for(var i=3;i<salelists.length;i++){
                salelist=salelists[i];
                Zepto(salelist).hide();
            }
        }
        mui('.mui-row').on('tap','#add_salelist',function(e){
            salelists=Zepto('.salelist');
            for(var i=3;i<salelists.length;i++){
                salelist=salelists[i];
                Zepto(salelist).toggle();
            }
        });
        mui('.salelist').on('tap', 'a', function (e){
            mui.openWindow({url: this.getAttribute('href'), id: 'info'});
        });

        mui('body').on('tap','.webim',function(){document.location.href=this.href;});
        mui('body').on('tap','#gouwuche',function(){document.location.href=this.href;});

        mui('#pullrefresh').scroll();
        $(".lazy").lazyload({
            failurelimit : 20
        });
        mui('.mui-bar').on('tap','a.addshoppingcart',function(e){
            addshoppingcart();
        });
        mui('.mui-bar').on('tap','a.shoppingcart',function(e){
            var shoppingcarturl = this.getAttribute('href');
            checkshoppingcart(shoppingcarturl);
        });
        mui('.mui-bar').on('tap', 'a.home', function (e){
            mui.openWindow({url: this.getAttribute('href'), id: 'info'});
        });

        mui('#propertygroup').on('tap','a.mycollection',function(e){
            var productid = Zepto('#productid').val();
            var status = Zepto('#mycollection').val();
            if (status == "0")
            {

                var postbody = 'record=' + productid + '&status=1';
                mui.ajax({
                    type: 'POST',
                    url: "mycollection_add.ajax.php",
                    data: postbody,
                    success: function(json) {
                        mui.toast("成功添加到收藏！");
                        Zepto('#mycollection').val("1");
                        Zepto("#mycollectionicon").addClass("icon-collection");
                        Zepto("#mycollectionicon").removeClass("icon-nocollection");
                        Zepto("#mycollectionicon").removeClass("mui-slow-twinkling");
                    }
                });
            }
            else
            {

                var postbody = 'record=' + productid + '&status=0';
                mui.ajax({
                    type: 'POST',
                    url: "mycollection_add.ajax.php",
                    data: postbody,
                    success: function(json) {
                        mui.toast("成功取消收藏！");
                        Zepto('#mycollection').val("0");
                        Zepto("#mycollectionicon").addClass("icon-nocollection");
                        Zepto("#mycollectionicon").addClass("mui-slow-twinkling");
                        Zepto("#mycollectionicon").removeClass("icon-collection");
                    }
                });

            }
        });
        mui('#detail_image').on('tap','h5',function(e){
            detail_image();
        });
        mui('#moreappraises').on('tap','h5',function(e){
            var from = Zepto('#from').val();
            var pagenum = Zepto('#pagenum').val();
            var scrolltop = Zepto('#scrolltop').val();
            var productid = Zepto('#productid').val();
            var url = 'detail_appraise.php?productid='+productid+'&scrolltop='+scrolltop+'&pagenum='+pagenum+'&from='+from;
            mui.openWindow({
                url: url,
                id: 'info'
            });
        });
        mui('#propertygroup').on('tap', 'a', function(e) {

            var groupid =  this.getAttribute('groupid');
            var propertyid =  this.getAttribute('propertyid');

            Zepto(".propertygroup_"+groupid).removeClass("active");
            Zepto(this).addClass("active");

            Zepto(".propertygroup_input_"+groupid).attr("checked",false);
            Zepto("#property_"+groupid+"_"+propertyid).attr("checked",true);
            Zepto("#type").val('');
            change_price();
        });
        mui('.mui-numbox').on('change', 'input', function() {
            recalc();
        });
        mui('.mui-table-view-cell').on('tap', 'button#numaddten', function() {
            var qty_item = Zepto('#qty_item').val();
            var new_qty_item = parseInt(qty_item,10) + 10;
            Zepto('#qty_item').val(new_qty_item);
            recalc();
        });

    });
    window.onload = function(){
        // mui('.mui-scroll-wrapper').scroll({
        //     scrollY: true, //是否竖向滚动
        //     scrollX: false, //是否横向滚动
        //     deceleration: 0.0005
        // });
        var $tags = $('.tags');
        mui('.tags').each(function(){
            var that = this;
            mui(that).on('tap', '.mui-btn-danger', function(){
                $(that).children('.mui-btn-danger').removeClass('mui-active');
                $(this).addClass('mui-active');
            })
        })
        mui('.tab.mui-segmented-control').on('tap', '.mui-control-item', function(){
            mui('.mui-scroll-wrapper').scroll().scrollTo(0,0,100);
        })
        mui('.comment-head').on('tap', '#more', function(){
            var commentTab = mui('.tab a.mui-control-item')[2];
            var commentContent = mui('#evaluate');
            $('.tab .mui-control-item').removeClass('mui-active');
            $('.goods-content').children('.mui-control-content').removeClass('mui-active');
            $(commentTab).addClass('mui-active');
            $(commentContent).addClass('mui-active');
            mui('.mui-scroll-wrapper').scroll().scrollTo(0,0,100);
        })
        mui('.comment-head').on('tap', '#goodsDetail', function(){
            var commentTab = mui('.tab a.mui-control-item')[1];
            var commentContent = mui('#detail');
            $('.tab .mui-control-item').removeClass('mui-active');
            $('.goods-content').children('.mui-control-content').removeClass('mui-active');
            $(commentTab).addClass('mui-active');
            $(commentContent).addClass('mui-active');
            mui('.mui-scroll-wrapper').scroll().scrollTo(0,0,100);
        })
        mui('nav').on('tap', '#collection', function(){
            $(this).toggleClass('red');
            var productid = Zepto('#productid').val();
            var status = Zepto('#mycollection').val();
            if($(this).hasClass('red')){
                var postbody = 'record=' + productid + '&status=1';
                mui.ajax({
                    type: 'POST',
                    url: "mycollection_add.ajax.php",
                    data: postbody,
                    success: function(json) {
                        $(this).find('.mui-icon').html('&#xe614;');
                        $(this).find('.mui-media-body').html('已收藏');
                    }
                });

            }else{
                var postbody = 'record=' + productid + '&status=0';
                mui.ajax({
                    type: 'POST',
                    url: "mycollection_add.ajax.php",
                    data: postbody,
                    success: function(json) {
                        $(this).find('.mui-icon').html('&#xe62b;');
                        $(this).find('.mui-media-body').html('收藏');
                    }
                });

            }
        })
    };
    function checkshoppingcart(shoppingcarturl)
    {
        var inventory = Zepto('#inventory1').val();
        var newinventory = parseInt(inventory,10);
        if ( newinventory <= 0)
        {
            mui.toast('您选择的商品已经卖完了！');
            return false;
        }
        if (Zepto('#type').val() == "")
        {
            var property_type_count = Zepto('#property_type_count').val();
            for(var i=1;i<=property_type_count;i++)
            {
                var radio = Zepto('input[name=propertygroup_'+i+'][checked=true]');
                if( radio.val() == undefined )
                {
                    mui.toast('请选择商品的'+Zepto('#propertygroup_label_'+i).val());
                    return false;
                }
            }
            mui.toast(' 您还需要选择的商品属性！');
            return false;
        }
        else
        {
            var qty_item = Zepto('#qty_item').val();
            var productid = Zepto('#productid').val();
            var product_property_id = Zepto('#product_property_id').val();

            var postbody = 'shoppingcart=1&record=' + productid + '&quantity=' + qty_item;
            if (product_property_id != "" && product_property_id != undefined)
            {
                postbody = 'type=detail&shoppingcart=1&record=' + productid + '&quantity=' + qty_item + '&propertyid=' + product_property_id;
            }
            var salesactivityid = Zepto('#salesactivityid').val();
            var salesactivity_product_id = Zepto('#salesactivity_product_id').val();
            if (salesactivityid != "" && salesactivity_product_id != "")
            {
                postbody += '&salesactivityid='+salesactivityid + '&salesactivitys_product_id='+salesactivity_product_id;
            }
            mui.ajax({
                type: 'POST',
                url: "shoppingcart_add.ajax.php",
                data: postbody,
                success: function(json) {
                    var jsondata = eval("("+json+")");
                    if (jsondata.code == 200) {
                        mui.openWindow({
                            url: shoppingcarturl,
                            id: 'info'
                        });
                    }
                    else
                    {
                        mui.toast(jsondata.msg);
                    }
                }
            });
        }
    }
    function addshoppingcart()
    {
        var inventory = Zepto('#inventory1').val();
        var newinventory = parseInt(inventory,10);
        if ( newinventory <= 0)
        {
            mui.toast('您选择的商品已经卖完了！');
            return false;
        }
        if (Zepto('#type').val() == "")
        {
            var property_type_count = Zepto('#property_type_count').val();
            for(var i=1;i<=property_type_count;i++)
            {
                var radio = Zepto('input[name=propertygroup_'+i+'][checked=true]');
                if( radio.val() == undefined )
                {
                    mui.toast('请选择商品的'+Zepto('#propertygroup_label_'+i).val());
                    return false;
                }
            }
            mui.toast(' 您还需要选择的商品属性！');
            return false;
        }
        else
        {
            var qty_item = Zepto('#qty_item').val();
            var productid = Zepto('#productid').val();
            var product_property_id = Zepto('#product_property_id').val();

            var postbody = 'record=' + productid + '&quantity=' + qty_item;

            if (product_property_id != "" && product_property_id != undefined)
            {
                postbody = 'type=detail&record=' + productid + '&quantity=' + qty_item + '&propertyid=' + product_property_id;
            }
            var salesactivityid = Zepto('#salesactivityid').val();
            var salesactivity_product_id = Zepto('#salesactivity_product_id').val();
            if (salesactivityid != "" && salesactivity_product_id != "")
            {
                postbody += '&salesactivityid='+salesactivityid + '&salesactivitys_product_id='+salesactivity_product_id;
            }

            mui.ajax({
                type: 'POST',
                url: "shoppingcart_add.ajax.php",
                data: postbody,
                success: function(json) {
                    var jsondata = eval("("+json+")");
                    if (jsondata.code == 200) {
                        mui.toast(jsondata.msg);
                        Zepto('#shoppingcart_badge').html('<span class="mui-badge mui-badge-red">'+jsondata.shoppingcart+'</span>&#xe64f;</span></span>');
                        //<span class="mui-badge mui-badge-red">{$share_info.shoppingcart}</span>{/if}&#xe64f;</span></span>
                    }
                    else
                    {
                        mui.toast(jsondata.msg);
                    }
                }
            });
        }
    }
    function recalc()
    {
        var qty_item = Zepto('#qty_item').val();
        var inventory = Zepto('#inventory1').val();
        var shop_price = Zepto('#shop_price1').val();
        var zhekou = Zepto('#zhekou').val();
        var includepost    = Zepto("#includepost").val();
        var postage        = Zepto("#postage").val();
        var mergepostage   = Zepto("#mergepostage").val();
        var new_qty_item = parseInt(qty_item,10);
        var newinventory = parseInt(inventory,10);
        var newshop_price = parseFloat(shop_price,10);
        var newzhekou = parseFloat(zhekou,10) * 0.1;

        if (newinventory > 0 || newinventory !== 0)
        {
            if (new_qty_item > newinventory )
            {
                new_qty_item = newinventory;
                Zepto('#qty_item').val(newinventory);
            }
            var total = new_qty_item * newshop_price;
            if (newzhekou > 0)
            {
                total = new_qty_item * newshop_price * newzhekou ;
            }

            if (parseFloat(postage, 10) > 0)
            {
                if (parseInt(mergepostage, 10) != 1)
                {
                    postage = parseFloat(postage, 10) * parseInt(new_qty_item, 10);
                }
                Zepto("#postage_span").html(parseFloat(postage, 10).toFixed(2));
                if (parseInt(includepost, 10) > 0 && parseInt(includepost, 10) <= parseInt(new_qty_item, 10))
                {
                    Zepto("#postage_panel").css('display', 'none;');
                }
                else
                {
                    Zepto("#postage_panel").css('display', 'block;');
                    total = parseFloat(total, 10) + parseFloat(postage, 10);
                }
            }
            Zepto("#totalprice").html(total.toFixed(2));
            Zepto("#total_price1").val(total);
            Zepto("#type").val('submit');
        }
        else
        {
            Zepto("#totalprice").html('0.00');
            Zepto("#type").val('');
        }
    }
    function product_recalc(shop_price,inventory) {
        var zhekou = Zepto('#zhekou').val();
        var newzhekou = parseFloat(zhekou,10) * 0.1;

        var newinventory = parseInt(inventory,10);
        var qty_item = Zepto('#qty_item').val();
        var new_qty_item = parseInt(qty_item,10);
        var price = parseFloat(shop_price,10);
        var includepost    = Zepto("#includepost").val();
        var postage        = Zepto("#postage").val();
        var mergepostage   = Zepto("#mergepostage").val();
        if (newinventory > 0 )
        {
            if (new_qty_item > newinventory )
            {
                new_qty_item = newinventory;
                Zepto('#qty_item').val(newinventory);
            }
            var total = new_qty_item * price;
            if (newzhekou > 0)
            {
                total = new_qty_item * price * newzhekou;
            }
            if (parseFloat(postage, 10) > 0)
            {
                if (parseInt(mergepostage, 10) != 1)
                {
                    postage = parseFloat(postage, 10) * parseInt(new_qty_item, 10);
                }
                Zepto("#postage_span").html(parseFloat(postage, 10).toFixed(2));
                if (parseInt(includepost, 10) > 0 && parseInt(includepost, 10) <= parseInt(new_qty_item, 10))
                {
                    Zepto("#postage_panel").css('display', 'none;');
                }
                else
                {
                    Zepto("#postage_panel").css('display', 'block;');
                    total = parseFloat(total, 10) + parseFloat(postage, 10);
                }
            }
            Zepto("#totalprice").html(total.toFixed(2));
            Zepto("#total_price1").val(total);
            Zepto("#type").val('submit');
        }
        else
        {
            Zepto("#totalprice").html('0.00');
            Zepto("#type").val('');
        }
    }

    function change_price()
    {
        var property_type_count = Zepto('#property_type_count').val();
        var propertygroup = [];
        for(var i=1;i<=property_type_count;i++)
        {
            var radio = Zepto('input[name=propertygroup_'+i+'][checked=true]');
            if (radio)
            {
                var propertyid = radio.attr("propertyid");
                if (propertyid)
                {
                    propertygroup.push(propertyid);
                }
            }
        }
        var propertygroupstr = propertygroup.sort().toString();
        Zepto.each(propertys, function(i, v) {
            var propertyids = v.propertyids;
            var propertyarray = propertyids.split(',');
            if (propertygroupstr == propertyarray.sort().toString())
            {
                var zhekou = Zepto('#zhekou').val();
                var newzhekou = parseFloat(zhekou,10) * 0.1;
                if (newzhekou > 0)
                {
                    Zepto("#old_shop_price").html(v.shop_price);
                    var promotional_price = v.shop_price * newzhekou;
                    Zepto("#shop_price").html(promotional_price.toFixed(2));
                    Zepto("#shop_price1").val(v.shop_price);
                }
                else
                {
                    Zepto("#shop_price").html(v.shop_price);
                    Zepto("#shop_price1").val(v.shop_price);
                }
                Zepto("#productlogo").attr("src",v.imgurl);
                Zepto("#product_property_id").val(v.propertytypeid);
                Zepto("#market_price").html(v.market_price);

                Zepto("#productlogo").html(v.imgurl);
                var jd = Zepto("#jd").val();
                if (jd == "1")
                {
                    if (v.inventory == '0')
                    {
                        Zepto("#inventory_label").html("无货");
                    }
                    else
                    {
                        Zepto("#inventory_label").html("有货");
                    }
                }
                else
                {
                    Zepto("#inventory_label").html(v.inventory);
                }

                Zepto("#inventory1").val(v.inventory);
                product_recalc(v.shop_price,v.inventory)
            }

        });
    }
    function detail_image()
    {
        var from = Zepto('#from').val();
        var pagenum = Zepto('#pagenum').val();
        var scrolltop = Zepto('#scrolltop').val();
        var productid = Zepto('#productid').val();
        var url = 'detail_image.php?productid='+productid+'&scrolltop='+scrolltop+'&pagenum='+pagenum+'&from='+from;
        mui.openWindow({
            url: url,
            id: 'info'
        });
    }
    !function(){function a(){document.documentElement.style.fontSize=document.documentElement.clientWidth/6.4+"px";if(document.documentElement.clientWidth>=640)document.documentElement.style.fontSize='100px';}var b=null;window.addEventListener("resize",function(){clearTimeout(b),b=setTimeout(a,300)},!1),a()}(window);
    {/literal}
</script>
{include file='weixin.tpl'}
