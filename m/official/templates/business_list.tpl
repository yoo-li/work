<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
	<title>授权申请</title>
	<link rel="stylesheet" href="/public/css/mui.min.css">
	<link href="/public/css/public.css" rel="stylesheet" />
	<link href="/public/css/common.css" rel="stylesheet" />
	<link href="/public/css/iconfont.css" rel="stylesheet"/>
	<link href="/public/css/parsley.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="/public/css/mui.picker.min.css" />
	<link href="/public/css/mui.poppicker.css" rel="stylesheet" />
	<link href="/public/css/sweetalert.css" rel="stylesheet"/>

	<script src="/public/js/mui.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="/public/js/zepto.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="/public/js/utils.js" type="text/javascript" charset="utf-8"></script>

	<script src="/public/js/parsley.min.js"></script>
	<script src="/public/js/parsley.zh_cn.js"></script>

	<script type="text/javascript" src="/public/js/sweetalert.min.js"></script>
	<script src="/public/js/mui.picker.min.js"></script>
	<script src="/public/js/mui.poppicker.js"></script>
	<script type="text/javascript" charset="utf-8" src="/public/js/cordova.js"></script>
	<style>
		{literal}

		.img-responsive{ display:block; height:auto; width:100%; }

        .oa-contact-cell.mui-table .mui-table-cell {
            padding: 11px 0;
            vertical-align: middle;
        }

        .oa-contact-cell {
            position: relative;
            margin: -11px 0;
        }

        .oa-contact-avatar {
            width: 80px;
        }
        .oa-contact-content {
            width: 100%;
            padding-left: 15px !important;
        }
        .oa-contact-name {
            margin-right: 20px;
        }
        .oa-contact-name,.oa-contact-position {
            float: left;
        }
        .oa-contact-position {
            color:#FE912C;
            border:1px solid #FE912C;
            border-radius: 3px;
            font-size: 9px !important;
            line-height: 15px;
        }
        .mui-h4, h4 {
            font-size: 16px;
        }
        .text-ellipsis-1{
            overflow : hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            word-break: break-all;
        }
        .mui-icon-search:before {
            color: #1BC1F8;
        }
        .cell-active{
            background:#EFEFF4;
        }
		{/literal}
	</style>
    {include file='theme.tpl'}
</head>
<body>

<div class="mui-inner-wrap">
	<header class="mui-bar mui-bar-nav" style="padding: 0 !important;">
		<a class="mui-icon mui-icon-left-nav mui-pull-left mui-action-back"></a>
		<h1 class="mui-title">商家列表</h1>
        <!-- 搜索 -->
        <form action="business_list.php" style="padding-top:44px;">
            <div class="mui-table-view-cell" style="background-color:#EFEFF4;padding: 6px 15px 0px;">
                <div class="mui-input-row mui-search" >
                    <input id="keywords" name="keywords" type="search" class="mui-input-clear"  style="background-color:#FFF;margin-bottom: 10px;" placeholder="搜索商家">
                </div>
            </div>
        </form>
	</header>

	<div id="pullrefresh" class="mui-content mui-scroll-wrapper" style="padding-top: 97px;">
		<div class="mui-scroll">
			<!--商家列表-->
            <ul class="mui-table-view mui-table-view-striped mui-table-view-condensed">
                <li class="mui-table-view-cell">
                    <div class="mui-slider-cell">
                        <div class="oa-contact-cell mui-table">
                            <div class="oa-contact-avatar mui-table-cell">
                                <img class="img-responsive" src="/official/images/2.png" />
                            </div>
                            <div class="oa-contact-content mui-table-cell">
                                <div class="mui-clearfix">
                                    <h4 class="oa-contact-name">大众饭店1</h4>
                                    <span class="oa-contact-position mui-h6">&nbsp;餐饮&nbsp;</span>
                                </div>
                                <p class="oa-contact-email mui-h6 text-ellipsis-1">
                                    电话：0510-86833000江苏省无锡市滨湖区体育中心江苏省无锡市滨湖区体育中心
                                </p>
                                <p class="oa-contact-email mui-h6 text-ellipsis-1">
                                    地址：江苏省无锡市滨湖区体育中心江苏省无锡市滨湖区体育中心江苏省无锡市滨湖区体育中心
                                </p>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="mui-table-view-cell">
                    <div class="mui-slider-cell">
                        <div class="oa-contact-cell mui-table">
                            <div class="oa-contact-avatar mui-table-cell">
                                <img class="img-responsive" src="/official/images/2.png" />
                            </div>
                            <div class="oa-contact-content mui-table-cell">
                                <div class="mui-clearfix">
                                    <h4 class="oa-contact-name">大众饭店2</h4>
                                    <span class="oa-contact-position mui-h6">&nbsp;餐饮&nbsp;</span>
                                </div>
                                <p class="oa-contact-email mui-h6 text-ellipsis-1">
                                    电话：0510-86833000江苏省无锡市滨湖区体育中心江苏省无锡市滨湖区体育中心
                                </p>
                                <p class="oa-contact-email mui-h6 text-ellipsis-1">
                                    地址：江苏省无锡市滨湖区体育中心江苏省无锡市滨湖区体育中心江苏省无锡市滨湖区体育中心
                                </p>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="mui-table-view-cell">
                    <div class="mui-slider-cell">
                        <div class="oa-contact-cell mui-table">
                            <div class="oa-contact-avatar mui-table-cell">
                                <img class="img-responsive" src="/official/images/2.png" />
                            </div>
                            <div class="oa-contact-content mui-table-cell">
                                <div class="mui-clearfix">
                                    <h4 class="oa-contact-name">大众饭店3</h4>
                                    <span class="oa-contact-position mui-h6">&nbsp;餐饮&nbsp;</span>
                                </div>
                                <p class="oa-contact-email mui-h6 text-ellipsis-1">
                                    电话：0510-86833000江苏省无锡市滨湖区体育中心江苏省无锡市滨湖区体育中心
                                </p>
                                <p class="oa-contact-email mui-h6 text-ellipsis-1">
                                    地址：江苏省无锡市滨湖区体育中心江苏省无锡市滨湖区体育中心江苏省无锡市滨湖区体育中心
                                </p>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="mui-table-view-cell">
                    <div class="mui-slider-cell">
                        <div class="oa-contact-cell mui-table">
                            <div class="oa-contact-avatar mui-table-cell">
                                <img class="img-responsive" src="/official/images/2.png" />
                            </div>
                            <div class="oa-contact-content mui-table-cell">
                                <div class="mui-clearfix">
                                    <h4 class="oa-contact-name">大众饭店4</h4>
                                    <span class="oa-contact-position mui-h6">&nbsp;餐饮&nbsp;</span>
                                </div>
                                <p class="oa-contact-email mui-h6 text-ellipsis-1">
                                    电话：0510-86833000江苏省无锡市滨湖区体育中心江苏省无锡市滨湖区体育中心
                                </p>
                                <p class="oa-contact-email mui-h6 text-ellipsis-1">
                                    地址：江苏省无锡市滨湖区体育中心江苏省无锡市滨湖区体育中心江苏省无锡市滨湖区体育中心
                                </p>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="mui-table-view-cell">
                    <div class="mui-slider-cell">
                        <div class="oa-contact-cell mui-table">
                            <div class="oa-contact-avatar mui-table-cell">
                                <img class="img-responsive" src="/official/images/2.png" />
                            </div>
                            <div class="oa-contact-content mui-table-cell">
                                <div class="mui-clearfix">
                                    <h4 class="oa-contact-name">大众饭店5</h4>
                                    <span class="oa-contact-position mui-h6">&nbsp;餐饮&nbsp;</span>
                                </div>
                                <p class="oa-contact-email mui-h6 text-ellipsis-1">
                                    电话：0510-86833000江苏省无锡市滨湖区体育中心江苏省无锡市滨湖区体育中心
                                </p>
                                <p class="oa-contact-email mui-h6 text-ellipsis-1">
                                    地址：江苏省无锡市滨湖区体育中心江苏省无锡市滨湖区体育中心江苏省无锡市滨湖区体育中心
                                </p>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="mui-table-view-cell">
                    <div class="mui-slider-cell">
                        <div class="oa-contact-cell mui-table">
                            <div class="oa-contact-avatar mui-table-cell">
                                <img class="img-responsive" src="/official/images/2.png" />
                            </div>
                            <div class="oa-contact-content mui-table-cell">
                                <div class="mui-clearfix">
                                    <h4 class="oa-contact-name">大众饭店6</h4>
                                    <span class="oa-contact-position mui-h6">&nbsp;餐饮&nbsp;</span>
                                </div>
                                <p class="oa-contact-email mui-h6 text-ellipsis-1">
                                    电话：0510-86833000江苏省无锡市滨湖区体育中心江苏省无锡市滨湖区体育中心
                                </p>
                                <p class="oa-contact-email mui-h6 text-ellipsis-1">
                                    地址：江苏省无锡市滨湖区体育中心江苏省无锡市滨湖区体育中心江苏省无锡市滨湖区体育中心
                                </p>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="mui-table-view-cell">
                    <div class="mui-slider-cell">
                        <div class="oa-contact-cell mui-table">
                            <div class="oa-contact-avatar mui-table-cell">
                                <img class="img-responsive" src="/official/images/2.png" />
                            </div>
                            <div class="oa-contact-content mui-table-cell">
                                <div class="mui-clearfix">
                                    <h4 class="oa-contact-name">大众饭店7</h4>
                                    <span class="oa-contact-position mui-h6">&nbsp;餐饮&nbsp;</span>
                                </div>
                                <p class="oa-contact-email mui-h6 text-ellipsis-1">
                                    电话：0510-86833000江苏省无锡市滨湖区体育中心江苏省无锡市滨湖区体育中心
                                </p>
                                <p class="oa-contact-email mui-h6 text-ellipsis-1">
                                    地址：江苏省无锡市滨湖区体育中心江苏省无锡市滨湖区体育中心江苏省无锡市滨湖区体育中心
                                </p>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="mui-table-view-cell">
                <div class="mui-slider-cell">
                    <div class="oa-contact-cell mui-table">
                        <div class="oa-contact-avatar mui-table-cell">
                            <img class="img-responsive" src="/official/images/2.png" />
                        </div>
                        <div class="oa-contact-content mui-table-cell">
                            <div class="mui-clearfix">
                                <h4 class="oa-contact-name">大众饭店8</h4>
                                <span class="oa-contact-position mui-h6">&nbsp;餐饮&nbsp;</span>
                            </div>
                            <p class="oa-contact-email mui-h6 text-ellipsis-1">
                                电话：0510-86833000江苏省无锡市滨湖区体育中心江苏省无锡市滨湖区体育中心
                            </p>
                            <p class="oa-contact-email mui-h6 text-ellipsis-1">
                                地址：江苏省无锡市滨湖区体育中心江苏省无锡市滨湖区体育中心江苏省无锡市滨湖区体育中心
                            </p>
                        </div>
                    </div>
                </div>
            </li>
                <li class="mui-table-view-cell">
                    <div class="mui-slider-cell">
                        <div class="oa-contact-cell mui-table">
                            <div class="oa-contact-avatar mui-table-cell">
                                <img class="img-responsive" src="/official/images/2.png" />
                            </div>
                            <div class="oa-contact-content mui-table-cell">
                                <div class="mui-clearfix">
                                    <h4 class="oa-contact-name">大众饭店9</h4>
                                    <span class="oa-contact-position mui-h6">&nbsp;餐饮&nbsp;</span>
                                </div>
                                <p class="oa-contact-email mui-h6 text-ellipsis-1">
                                    电话：0510-86833000江苏省无锡市滨湖区体育中心江苏省无锡市滨湖区体育中心
                                </p>
                                <p class="oa-contact-email mui-h6 text-ellipsis-1">
                                    地址：江苏省无锡市滨湖区体育中心江苏省无锡市滨湖区体育中心江苏省无锡市滨湖区体育中心
                                </p>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
            {include file='copyright.tpl'}
            <br/>
            <br/>
		</div>
	</div>
    <button id="sure" href="treat.php" type="button" class="mui-btn mui-btn-block" style="position:absolute;bottom: 0;z-index: 99;margin-bottom: 0;padding: 7px 0;background-color:#F81B3F;color:#fff;font-size: 14px; ">确定</button>
</div>

<script type="text/javascript">
    {literal}
    mui.init({
        pullRefresh: {
//            container: '#pullrefresh', //待刷新区域标识，querySelector能定位的css选择器均可，比如：id、.class等
//            down: {
//                callback: pulldownRefresh
//            },
//            up: {
//                contentrefresh: "正在加载...", //可选，正在加载状态时，上拉加载控件上显示的标题内容
//                contentnomore: '没有更多数据了', //可选，请求完毕若没有更多数据时显示的提醒内容；
//                callback: add_more //必选，刷新函数，根据具体业务来编写，比如通过ajax从服务器获取新数据；
//            }
        },
    });
    mui.ready(function ()
    {
        mui('#pullrefresh').scroll({
                indicators:false //是否显示滚动条
        });
        mui('.mui-bar').on('tap', 'a', function (e)
        {
            mui.openWindow({
                url: this.getAttribute('href'),
                id: 'info'
            });
        });
        mui('.mui-table-view').on('tap', '.mui-table-view-cell', function (e)
        {
            var cells = document.querySelectorAll('.mui-table-view-cell');
            for(i=0;i<cells.length;i++){
                cells[i].classList.remove("cell-active");
            }
            this.classList.add('cell-active');
        });
        mui('.mui-inner-wrap').on('tap', '#sure', function (e)
        {
            var cells = document.querySelectorAll('.mui-table-view-cell');
            var business_name;
            var busineess_id;
            for(i=0;i<cells.length;i++){
                //第一种方法，用classList这个H5 API，有兼容性问题
                if(cells[i].classList.contains('cell-active')==true){
                    business_name=cells[i].getElementsByTagName("h4")[0].innerHTML;
                    busineess_id=1;
                }
            }
            mui.ajax('treat.php',{
                data:{
                    business_name:business_name,
                    busineess_id:busineess_id
                },
                dataType:'json',


                type:'post',
            
            });
            mui.openWindow({
                url: 'treat.php',
                id: 'info'
            });
            // var treat=plus.webview.getWebviewById("treat.html");
//            mui.openWindow({
//                url: "treat.php",
//            });
            // mui.fire(treat,'goTreat', {business_name: business_name,busineess_id: busineess_id});
        });
    });
    {/literal}
</script>
<script src="/public/js/baidu.js?_=20140821" type="text/javascript"></script>
</body>
</html>