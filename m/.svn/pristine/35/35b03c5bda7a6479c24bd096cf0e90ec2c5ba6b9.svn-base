<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>采购收货</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <!--标准mui.css-->
    <link rel="stylesheet" href="/public/css/mui.min.css">
    <link href="/public/css/public.css" rel="stylesheet"/>
    <link href="/public/css/iconfont.css" rel="stylesheet"/>
    <!--App自定义的css-->
    <link rel="stylesheet" type="text/css" href="/public/css/tezan.css"/>
    <style>
        {literal}
        p {
            text-indent: 22px;
            padding: 5px 8px;
        }

        html,
        body,
        .mui-content {
            background-color: #fff;
        }

        h4 {
            margin-left: 5px;
        }

        .mui-plus header.mui-bar {
            display: none;
        }

        .mui-plus .mui-bar-nav ~ .mui-content {
            padding: 0;
        }

        {/literal}
    </style>
</head>

<body>
<header class="mui-bar mui-bar-nav" id="header">
    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
    <h1 class="mui-title">{$ma_saleorders_no}</h1>
    <input type="hidden" readonly="readonly" value="{$record}" id="record" class="form-control middle-width">
    <input type="hidden" readonly="readonly" value="{$totalnum}" id="totalnum" class="form-control middle-width">
    <input type="hidden" readonly="readonly" value="{$profileid}" id="profileid" class="form-control middle-width">
    <input style="font-size: 15px;" type="text" readonly="readonly" id="show"
           value="总数量:{$totalnum}/0">
</header>
<div id="div_main" style="background-color: #fff ">
    <div id="div_html">
    </div>
    <div>
        </br></br></br>
        <button type="button" class="mui-btn" id="div_main_close" style="width: 80px;margin-left: 80px">关闭</button>
        <button type="button" class="mui-btn" id="div_main_ok" style="width: 80px;margin-left: 20px">保存</button>
    </div>
    </br></br></br></br></br></br></br></br>
</div>
<div id="pullrefresh" class="mui-content mui-scroll-wrapper" style="padding-top: 120px;">
    <div class="mui-collapse-content">
        <form class="mui-input-group">
            <button type="button" class="mui-btn" id="find" style="float: left;">手动添加批号</button>
            <div id="div_find">
            </div>
            {foreach name=blocks key=header item=data from=$incheckstorage}
                <div class="mui-collapse-content products" style="margin: 3px 3px;">
                    <div class="mui-input-row">
                        <label style="font-size: 15px;"></label>
                    </div>
                    <div class="mui-input-row">
                        <label style="font-size: 15px;">产品名称：</label>
                        <input style="font-size: 15px;" type="text" readonly="readonly" id="productname_{$header}"
                               value="{$data.productname}">
                    </div>
                    <div class="mui-input-row">
                        <label style="font-size: 15px;">产品编码：</label>
                        <input style="font-size: 15px;" type="text" readonly="readonly" id="barcode_{$header}" value="{$data.barcode}">
                    </div>
                    <div class="mui-input-row">
                        <label style="font-size: 15px;">产品条码：</label>
                        <input style="font-size: 15px;" type="text" readonly="readonly" id="itemcode_{$header}" value="{$data.itemcode}">
                    </div>
                    <div class="mui-input-row">
                        <label style="font-size: 15px;">规格：</label>
                        <input style="font-size: 15px;" type="text" readonly="readonly" id="guige_{$header}" value="{$data.guige}">
                    </div>
                    <div class="mui-input-row">
                        <label style="font-size: 15px;">单位：</label>
                        <input style="font-size: 15px;" type="text" readonly="readonly" id="unit_{$header}" value="{$data.unit}">
                    </div>
                    <div class="mui-input-row">
                        <label style="font-size: 15px;">注册证号：</label>
                        <input style="font-size: 15px;" type="text" readonly="readonly" id="registercode_{$header}"
                               value="{$data.registercode}">
                    </div>
                    <div class="mui-input-row">
                        <label style="font-size: 15px;">生产企业：</label>
                        <input style="font-size: 15px;" type="text" readonly="readonly" id="factorys_name_{$header}"
                               value="{$data.factorys_name}">
                    </div>
                    <div class="mui-input-row" style="height: auto;">
                        <label style="font-size: 15px;">仓库位置：</label>
                        <span style="float: left;">
                        {$data.warehouseinfo}
                            </span>
                    </div>
                    <div class="mui-input-row">
                        <label style="font-size: 15px;">待收数量：</label>
                        <input style="font-size: 15px;" type="text" readonly="readonly" id="number_{$data.itemcode}" value="{$data.number}">
                        <input style="font-size: 15px;" type="hidden" readonly="readonly" id="number_{$data.barcode}"
                               value="{$data.number}">
                    </div>
                    <div id="div_{$data.itemcode}"></div>
                    <div id="div_{$data.barcode}"></div>
                </div>
            {/foreach}
        </form>
        {include file='copyright.tpl'}
        </br></br></br></br></br></br></br></br>
    </div>
</div>
<script src="/public/js/mui.min.js"></script>
<script src="/public/js/rule.js"></script>
<script type="text/javascript" charset="utf-8" src="/public/js/cordova.js"></script>
<script type="text/javascript" charset="utf-8">
    var js_arr ={$js_arr};
    {literal}
    var mybarcodes = [];
    var idarr = new Dictionary();//保存码和控件id
    var numarr = new Dictionary();//保存控件id和数量
    var bararr = new Dictionary();//保存码和数量
    var myarr = new Dictionary();//保存控件id和码
    var productdatearr = new Dictionary();//保存码和生产日期
    var sterilizecodearr = new Dictionary();//保存码和灭菌批号
    var sterilizevalidatearr = new Dictionary();//保存码和灭菌有效期
    var num = 0;
    var thisresult = "";
    var addnum = 0;//手动添加的
    var addnumarr = new Dictionary();//add保存控件id和数量
    var addbararr = new Dictionary();//add保存码和数量
    var addmyarr = new Dictionary();//add保存控件id和码
    var totalnum = document.getElementById("totalnum").value;//订单出库总数
    var barnum = 0;//已扫描数量
    var addout = 0;//自动添加是否超出待收数量;
    mui.init({
        gestureConfig: {
            longtap: true
        },
        swipeBack: false //启用右滑关闭功能
    });
    //处理点击事件，需要打开原生浏览器
    mui.ready(function () {
        mui('body').on('tap', 'a', function (e) {
            var href = this.getAttribute('href');
            if (href) {
                if (window.plus) {
                    plus.runtime.openURL(href);
                } else {
                    location.href = href;
                }
            }
        });


        mui('body').on('tap', 'button#find', function (e) {
            var finddiv = document.getElementById("div_find");
            if (finddiv) {
                finddiv.innerHTML = '<div class="mui-input-row" style="height: 60px">' +
                        '<label style="font-size: 15px;">产品编码:</label>' +
                        '<input id="barcode" onchange="getdata(this);" type="text">' +
                        '</div>' +
                        '<div class="mui-input-row" style="height: 60px">' +
                        '<label style="font-size: 15px;">产品条码:</label>' +
                        '<input id="itemcode"  onchange="getdata(this);" type="text">' +
                        '<input type="hidden" readonly="readonly"  id="suppliername" class="form-control middle-width">' +
                        '<input type="hidden" readonly="readonly"  id="factorys_name" class="form-control middle-width">' +
                        '</div>' +
                        '<div class="mui-input-row" style="height: auto;">' +
                        '<label style="font-size: 15px;">仓库位置：</label>' +
                        '<input style="float: left;" id="warehouseinfo" readonly="readonly">' +
                        '</div>' +
                        '<div class="mui-input-row">' +
                        '<label style="font-size: 15px;">待收数量：</label>' +
                        '<input style="font-size: 15px;" type="text" readonly="readonly" id="number" >' +
                        '</div>' +
                        '<div id="div_add">' +
                        '</div>' +
                        '<div class="mui-collapse-content" style="height: 60px">' +
                        '<button type="button" class="mui-btn" id="addbatch_no">新增批号</button>' +
                        '<button type="button" class="mui-btn" id="submitbatch_no" style="margin-left:40px">提交</button>' +
                        '</div>';
            }
        });

        mui('body').on('tap', 'button#addbatch_no', function (e) {
            var suppliername = document.getElementById("suppliername").value;
            var factorys_name = document.getElementById("factorys_name").value;
            var factorys = getfactorys(factorys_name);
            if (suppliername === 'YLT') {
                if (factorys != "") {
                    var itemcodes = document.getElementById("barcode").value;
                } else {
                    var itemcodes = document.getElementById("itemcode").value;
                }
            } else {
                var itemcodes = document.getElementById("itemcode").value;
            }
            addnum += 1;
            var adddiv = document.getElementById("div_add");
            if (adddiv) {
                adddiv.innerHTML +=
                        '<div class="mui-input-row" style="height: 60px">' +
                        '<label style="font-size: 15px;">批号:</label>' +
                        '<input id="add_batch_no_' + itemcodes + '_' + addnum + '"  onchange="savebatch(this);"/>' +
                        '</div>' +
                        '<div class="mui-input-row">' +
                        '<label style="font-size: 15px;">产品数量：</label>' +
                        '<div class="mui-numbox" data-numbox-min="0" data-numbox-max="9999999999" style="width:170px">' +
                        '<button class="mui-btn mui-btn-numbox-minus" type="button">-</button>' +
                        '<input id="add_productnum_' + itemcodes + '_' + addnum + '" class="mui-input-numbox" type="number" onchange="savenum(this);"/>' +
                        '<button class="mui-btn mui-btn-numbox-plus" type="button">+</button>' +
                        '</div>' +
                        '</div>';
                for (var i = 1; i < addnum; i++) {
                    if (document.getElementById('add_productnum_' + itemcodes + '_' + i)) {
                        document.getElementById('add_batch_no_' + itemcodes + '_' + i).value = addmyarr.get("add_batch_no_" + itemcodes + "_" + i);
                        document.getElementById('add_productnum_' + itemcodes + '_' + i).value = addnumarr.get("add_productnum_" + itemcodes + "_" + i);
                    }
                }
            }
        });

        mui('body').on('tap', 'button#submitbatch_no', function (e) {
            var factorys_name = document.getElementById("factorys_name").value;
            var factorys = getfactorys(factorys_name);
            var suppliername = document.getElementById("suppliername").value;
            if (suppliername === 'YLT') {
                if (factorys != "") {
                    var itemcodes = document.getElementById("barcode").value;
                } else {
                    var itemcodes = document.getElementById("itemcode").value;
                }
            } else {
                var itemcodes = document.getElementById("itemcode").value;
            }
            for (var i = 1; i <= addnum; i++) {
                if (document.getElementById('add_batch_no_' + itemcodes + '_' + i)) {
                    if (factorys != "") {
                        addbararr.put(factorys + itemcodes + document.getElementById('add_batch_no_' + itemcodes + '_' + i).value, addnumarr.get("add_productnum_" + itemcodes + "_" + i));
                        addJsonResult(factorys + itemcodes + addmyarr.get("add_batch_no_" + itemcodes + "_" + i));
                    } else {
                        addbararr.put(document.getElementById('add_batch_no_' + itemcodes + '_' + i).value, addnumarr.get("add_productnum_" + itemcodes + "_" + i));
                        addJsonResult(addmyarr.get("add_batch_no_" + itemcodes + "_" + i));
                    }
                }

            }
            if (addout != 1) {
                var hA = document.getElementById("div_main");
                hA.style.display = 'block';
                document.getElementById("header").style.display = 'none';
                var test = document.getElementById("div_" + itemcodes).parentNode.cloneNode(true);
                document.getElementById("div_html").innerHTML = '';
                document.getElementById("div_html").appendChild(test);
                mui('#div_main').off("change", "input");
                mui('#div_main').on('change', "input", function () {
                    newchanges(this);
                });
            }
        });

        mui('body').on('tap', 'button#div_main_close', function (e) {
            var totle = 0;
            mui('form .products input[type="number"] ').each(function () {
                var self = this;
                totle += parseInt(self.value);
            });
            document.getElementById('show').value = '总数量:' + totalnum + '/' + totle;
            barnum = totle;
            showdialog();
        });
        mui('body').on('tap', 'button#div_main_ok', function (e) {
            var totle = 0;
            mui('#div_html input[type="number"]').each(function () {
                var self = this;
                mui('form input#' + self.id).each(function () {
                    this.value = self.value;
                    mui.trigger(this, "change");
                    bararr.put(myarr.get(self.id), self.value);
                });
                mui('#div_add input[type="number"] ').each(function () {
                    this.value = 1;
                    addnumarr.put(this.id, this.value);
                });
            });
            mui('#div_html input[type="text"]').each(function () {
                var self = this;
                mui('form input#' + self.id).each(function () {
                    this.value = self.value;
                });
            });
            mui('form .products input[type="number"] ').each(function () {
                var self = this;
                totle += parseInt(self.value);
            });
            //保存数据
            savedata(thisresult, "0");
            document.getElementById('show').value = '总数量:' + totalnum + '/' + totle;
            barnum = totle;
            showdialog();
        });

        mui('.mui-scroll-wrapper').scroll({
            deceleration: 0.0005 //flick 减速系数，系数越大，滚动速度越慢，滚动距离越小，默认值0.0006
        });
        dialog();
    });
    function JsonResult(result) {
        showdialog();
        thisresult = result;
        var itemcodes = getitemcode(result);
        var batchcodes = getbatchcode(result);
//        if (result.substring(0, 3) === 'YLT') {
//            var itemcodes = result.substring(3, 19);//条码
//            var batchcodes = result.substring(29);//批号
//        } else if (result.substring(0, 3) === 'ATH') {
//            var itemcodes = result.substring(3, 16);
//            var batchcodes = result.substring(26);
//        } else if (result.substring(0, 3) === 'BCL') {
//            var itemcodes = result.substring(3, 19);
//            var batchcodes = result.substring(37);
//        } else {
//            var itemcodes = result.substring(3, 15);
//            var batchcodes = result.substring(26);
//        }
        if (checks(mybarcodes, result)) {
            if (contains(mybarcodes, result)) {
                mui('form input#' + idarr.get(result)).each(function () {
                    this.value = parseInt(numarr.get(idarr.get(result))) + 1;
                    numarr.put(idarr.get(result), this.value);
                });
            }
            else {
                //动态添加元素
                var testdiv = document.getElementById("div_" + itemcodes);
                if (testdiv) {
                    mybarcodes.push(result);
                    idarr.put(result, "productnum_" + itemcodes + "_" + num);
                    numarr.put(idarr.get(result), "1");
                    testdiv.innerHTML += '<div class="mui-input-row" style="height: 60px">' +
                            '<label style="font-size: 15px;">批号:</label>' +
                            '<textarea id="batch_no_' + itemcodes + '_' + num + '" rows="2" readonly="">' + batchcodes + '</textarea>' +
                            '</div>' +
                            '<div class="mui-input-row" style="height: 60px">' +
                            '<label style="font-size: 15px;">生产日期:</label>' +
                            '<input id="productdate_' + itemcodes + '_' + num + '" type="text" />' +
                            '</div>' +
                            '</div>' +
                            '<div class="mui-input-row" style="height: 60px">' +
                            '<label style="font-size: 15px;">灭菌批号:</label>' +
                            '<input id="sterilizecode_' + itemcodes + '_' + num + '" type="text" />' +
                            '</div>' +
                            '</div>' +
                            '<div class="mui-input-row" style="height: 60px">' +
                            '<label style="font-size: 15px;">灭菌有效期:</label>' +
                            '<input id="sterilizevalidate_' + itemcodes + '_' + num + '" type="text"/>' +
                            '</div>' +
                            '<div class="mui-input-row">' +
                            '<label style="font-size: 15px;">产品数量：</label>' +
                            '<div class="mui-numbox" data-numbox-min="0" data-numbox-max="9999999999" style="width:170px">' +
                            '<button class="mui-btn mui-btn-numbox-minus" type="button">-</button>' +
                            '<input id="productnum_' + itemcodes + '_' + num + '" class="mui-input-numbox" type="number"/>' +//  onchange="changes(this);"
                            '<button class="mui-btn mui-btn-numbox-plus" type="button">+</button>' +
                            '</div>' +
                            '</div>';
                    for (var i = 0; i <= num; i++) {
                        if (document.getElementById('productnum_' + itemcodes + '_' + i)) {
                            document.getElementById('productnum_' + itemcodes + '_' + i).value = numarr.get("productnum_" + itemcodes + "_" + i);
                            if (typeof(productdatearr.get(myarr.get("productnum_" + itemcodes + "_" + i))) != "undefined") {
                                document.getElementById('productdate_' + itemcodes + '_' + i).value = productdatearr.get(myarr.get("productnum_" + itemcodes + "_" + i)).replace(/-/g, "");
                            } else {
                                var temp_productdate = getproductdate("productdate", itemcodes, batchcodes);
                                document.getElementById('productdate_' + itemcodes + '_' + i).value = temp_productdate.replace(/-/g, "");
                                productdatearr.put(result, temp_productdate);
                            }
                            if (typeof(sterilizecodearr.get(myarr.get("productnum_" + itemcodes + "_" + i))) != "undefined") {
                                document.getElementById('sterilizecode_' + itemcodes + '_' + i).value = sterilizecodearr.get(myarr.get("productnum_" + itemcodes + "_" + i));
                            } else {
                                var temp_sterilizecode = getproductdate("sterilizecode", itemcodes, batchcodes);
                                document.getElementById('sterilizecode_' + itemcodes + '_' + i).value = getproductdate("sterilizecode", itemcodes, batchcodes);
                                sterilizecodearr.put(result, temp_sterilizecode);
                            }
                            if (typeof(sterilizevalidatearr.get(myarr.get("productnum_" + itemcodes + "_" + i))) != "undefined") {
                                document.getElementById('sterilizevalidate_' + itemcodes + '_' + i).value = sterilizevalidatearr.get(myarr.get("productnum_" + itemcodes + "_" + i)).replace(/-/g, "");
                            } else {
                                var temp_sterilizevalidate = getproductdate("sterilizevalidate", itemcodes, batchcodes);
                                document.getElementById('sterilizevalidate_' + itemcodes + '_' + i).value = temp_sterilizevalidate.replace(/-/g, "");
                                sterilizevalidatearr.put(result, temp_sterilizevalidate);
                            }
                        }
                    }
                    mui('.products').on('change', "input", function () {
                        changes(this);
                    });
                    myarr.put("productnum_" + itemcodes + "_" + num, result);
                    num += 1;
                } else {
                    alert("找不到编码为" + itemcodes + "批号为" + batchcodes + "的未收货产品");
                    return;
                }
            }
            savedata(thisresult, 1);
            bararr.put(result, document.getElementById(idarr.get(result)).value);
            barnum += 1;
            document.getElementById('show').value = '总数量:' + totalnum + '/' + barnum;
            var hA = document.getElementById("div_main");
            hA.style.display = 'block';
            document.getElementById("header").style.display = 'none';
            var test = document.getElementById("div_" + itemcodes).parentNode.cloneNode(true);
            document.getElementById("div_html").innerHTML = '';
            document.getElementById("div_html").appendChild(test);
            mui('#div_main').off("change", "input");
            mui('#div_main').on('change', "input", function () {
                newchanges(this);
            });
        }
        else {
            alert(itemcodes + "超过待收数量");
        }
    }
    function addJsonResult(result) {
        thisresult = result;
        var itemcodes = getitemcode(result);
        var batchcodes = getbatchcode(result);
//        if (result.substring(0, 3) === 'YLT') {
//            var itemcodes = result.substring(3, 19);//条码
//            var batchcodes = result.substring(29);//批号
//        } else if (result.substring(0, 3) === 'ATH') {
//            var itemcodes = result.substring(3, 16);
//            var batchcodes = result.substring(26);
//        } else {
//            var itemcodes = result.substring(3, 15);
//            var batchcodes = result.substring(26);//批号
//        }
        if (addchecks(mybarcodes, result)) {
            addout = 0;
            if (contains(mybarcodes, result)) {
                mui('form input#' + idarr.get(result)).each(function () {
                    if (typeof(numarr.get(idarr.get(result))) != 'underfind') {
                        var num = parseInt(numarr.get(idarr.get(result))) + parseInt(addbararr.get(result));
                        numarr.put(idarr.get(result), num);
                        this.value = num;
                    } else {
                        numarr.put(idarr.get(result), addbararr.get(result));
                        this.value = addbararr.get(result);
                    }
                });
            }
            else {
                //动态添加元素
                var testdiv = document.getElementById("div_" + itemcodes);
                if (testdiv) {
                    mybarcodes.push(result);
                    idarr.put(result, "productnum_" + itemcodes + "_" + num);
                    numarr.put(idarr.get(result), addbararr.get(result));
                    testdiv.innerHTML += '<div class="mui-input-row" style="height: 60px">' +
                            '<label style="font-size: 15px;">批号:</label>' +
                            '<textarea id="batch_no_' + itemcodes + '_' + num + '" rows="2" readonly="">' + batchcodes + '</textarea>' +
                            '</div>' +
                            '<div class="mui-input-row" style="height: 60px">' +
                            '<label style="font-size: 15px;">生产日期:</label>' +
                            '<input id="productdate_' + itemcodes + '_' + num + '" type="text" />' +
                            '</div>' +
                            '</div>' +
                            '<div class="mui-input-row" style="height: 60px">' +
                            '<label style="font-size: 15px;">灭菌批号:</label>' +
                            '<input id="sterilizecode_' + itemcodes + '_' + num + '" type="text" />' +
                            '</div>' +
                            '</div>' +
                            '<div class="mui-input-row" style="height: 60px">' +
                            '<label style="font-size: 15px;">灭菌有效期:</label>' +
                            '<input id="sterilizevalidate_' + itemcodes + '_' + num + '" type="text"/>' +
                            '</div>' +
                            '<div class="mui-input-row">' +
                            '<label style="font-size: 15px;">产品数量：</label>' +
                            '<div class="mui-numbox" data-numbox-min="0" data-numbox-max="9999999999" style="width:170px">' +
                            '<button class="mui-btn mui-btn-numbox-minus" type="button">-</button>' +
                            '<input id="productnum_' + itemcodes + '_' + num + '" class="mui-input-numbox" type="number"/>' +//  onchange="changes(this);"
                            '<button class="mui-btn mui-btn-numbox-plus" type="button">+</button>' +
                            '</div>' +
                            '</div>';
                    for (var i = 0; i <= num; i++) {
                        if (document.getElementById('productnum_' + itemcodes + '_' + i)) {
                            document.getElementById('productnum_' + itemcodes + '_' + i).value = numarr.get("productnum_" + itemcodes + "_" + i);
                            if (typeof(productdatearr.get(myarr.get("productnum_" + itemcodes + "_" + i))) != "undefined") {
                                document.getElementById('productdate_' + itemcodes + '_' + i).value = productdatearr.get(myarr.get("productnum_" + itemcodes + "_" + i)).replace(/-/g, "");
                            } else {
                                var temp_productdate = getproductdate("productdate", itemcodes, batchcodes);
                                document.getElementById('productdate_' + itemcodes + '_' + i).value = temp_productdate.replace(/-/g, "");
                                productdatearr.put(result, temp_productdate);
                            }
                            if (typeof(sterilizecodearr.get(myarr.get("productnum_" + itemcodes + "_" + i))) != "undefined") {
                                document.getElementById('sterilizecode_' + itemcodes + '_' + i).value = sterilizecodearr.get(myarr.get("productnum_" + itemcodes + "_" + i));
                            } else {
                                var temp_sterilizecode = getproductdate("sterilizecode", itemcodes, batchcodes);
                                document.getElementById('sterilizecode_' + itemcodes + '_' + i).value = getproductdate("sterilizecode", itemcodes, batchcodes);
                                sterilizecodearr.put(result, temp_sterilizecode);
                            }
                            if (typeof(sterilizevalidatearr.get(myarr.get("productnum_" + itemcodes + "_" + i))) != "undefined") {
                                document.getElementById('sterilizevalidate_' + itemcodes + '_' + i).value = sterilizevalidatearr.get(myarr.get("productnum_" + itemcodes + "_" + i)).replace(/-/g, "");
                            } else {
                                var temp_sterilizevalidate = getproductdate("sterilizevalidate", itemcodes, batchcodes);
                                document.getElementById('sterilizevalidate_' + itemcodes + '_' + i).value = temp_sterilizevalidate.replace(/-/g, "");
                                sterilizevalidatearr.put(result, temp_sterilizevalidate);
                            }
                        }
                    }
                    mui('.products').on('change', "input", function () {
                        changes(this);
                    });
                    myarr.put("productnum_" + itemcodes + "_" + num, result);
                    num += 1;
                } else {
                    alert("找不到编码为" + itemcodes + "批号为" + batchcodes + "的未收货产品");
                    return;
                }
            }
            savedata(thisresult, addbararr.get(result));
            bararr.put(result, document.getElementById(idarr.get(result)).value);
            barnum = parseInt(barnum) + parseInt(addbararr.get(result));
            document.getElementById('show').value = '总数量:' + totalnum + '/' + barnum;

        } else {
            addout = 1;
            alert(itemcodes + "超过待收数量");
        }
    }

    function contains(arr, obj) {
        var i = arr.length;
        while (i--) {
            if (arr[i] === obj) {
                return true;
            }
        }
        return false;
    }

    //产品待收数量与扫入数量检验
    function checks(arr, obj1) {
        var i = arr.length;
        var codes = getitemcode(obj1);
        var xg = document.getElementById('number_' + codes);
        if (i > 0) {
            if (xg) {
                var num = parseInt(xg.value);
            } else {
                return false;
            }
            var addnum = 0;
            for (var j = 0; j < i; j++) {
                var temp = arr[j].indexOf(codes);
                if (temp >= 0) {
                    if (document.getElementById(idarr.get(arr[j]))) {
                        addnum = addnum + parseInt(document.getElementById(idarr.get(arr[j])).value);
                    }
                }
            }
            if (num > addnum) {
                return true;
            }
            return false;
        } else {
            if (xg) {
                var num = parseInt(xg.value);
                if (num > 0) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

    //产品待收数量与扫入数量检验
    function addchecks(arr, obj1) {
        var i = arr.length;
        var codes = getitemcode(obj1);
        var num = parseInt(document.getElementById('number_' + codes).value);
        if (i > 0) {
            var addnum = 0;
            for (var j = 0; j < i; j++) {
                var temp = arr[j].indexOf(codes);
                if (temp >= 0) {
                    if (document.getElementById(idarr.get(arr[j]))) {
                        addnum = addnum + parseInt(document.getElementById(idarr.get(arr[j])).value);
                    }
                }
            }
            addnum += parseInt(addbararr.get(obj1));
            if (num >= addnum) {
                return true;
            }
            return false;
        } else {
            if (num >= parseInt(addbararr.get(obj1))) {
                return true;
            } else {
                return false;
            }
        }
    }

    function Dictionary() {
        this.data = [];
        this.put = function (key, value) {
            this.data[key] = value;
        };
        this.get = function (key) {
            return this.data[key];
        };
        this.remove = function (key) {
            this.data[key] = null;
        };
        this.isEmpty = function () {
            return this.data.length == 0;
        };
        this.size = function () {
            return this.data.length;
        };
    }

    //产品数量框输入检测
    function changes(obj) {
        if (obj.id.indexOf('productnum') == 0) {
            if (checkRate(obj.id)) {
                var strid = obj.id.substring(10, obj.id.length);
                var barcodesid = "batch_no" + strid;
                var strs = [];
                strs = strid.split("_");
                if (checksonchange(strs[1], document.getElementById(barcodesid).value, parseInt(obj.value))) {
                    var beforenum = numarr.get(obj.id);
                    bararr.put(myarr.get(obj.id), obj.value);
                    numarr.put(obj.id, obj.value);
                    barnum = barnum + parseInt(obj.value) - beforenum;
                    document.getElementById('show').value = '总数量:' + totalnum + '/' + barnum;
                }
                else {
                    mui('form input#' + obj.id).each(function () {
                        this.value = numarr.get(obj.id);
                        alert("超过待收数量");
                    });
                }
            }
        }
    }

    //新产品数量框输入检测
    function newchanges(obj) {
        if (obj.id.indexOf('productnum') == 0) {
            if (checkRate(obj.id)) {
                var strid = obj.id.substring(10, obj.id.length);
                var barcodesid = "batch_no" + strid;
                var strs = strid.split("_");
                if (!checksonchange(strs[1], document.getElementById(barcodesid).value, parseInt(obj.value))) {
                    obj.value = numarr.get(obj.id);
                    alert("超过待收数量");
                } else {
                    var beforenum = numarr.get(obj.id);
                    savedata(myarr.get(obj.id), parseInt(obj.value) - parseInt(beforenum));
                    mui('#div_html input[type="number"]').each(function () {
                        var self = this;
                        mui('form input#' + self.id).each(function () {
                            this.value = self.value;
                            bararr.put(myarr.get(self.id), self.value);
                            numarr.put(self.id, self.value);
                        });
                        mui('#div_add input[type="number"] ').each(function () {
                            this.value = self.value;
                            addnumarr.put(this.id, this.value);
                        });
                    });
                    barnum = parseInt(barnum) + parseInt(obj.value) - parseInt(beforenum);
                    document.getElementById('show').value = '总数量:' + totalnum + '/' + barnum;
                }
            }
        } else if (obj.id.indexOf('productdate') == 0) {
            var strid = obj.id.substring(11, obj.id.length);
            var ma = "productnum" + strid;
            var mydate = obj.value;
            var myproductdate = mydate.substring(0, 4) + "-" + mydate.substring(4, 6) + "-" + mydate.substring(6, 8);
            productdatearr.put(myarr.get(ma), myproductdate);
        } else if (obj.id.indexOf('sterilizecode') == 0) {
            var strid = obj.id.substring(13, obj.id.length);
            var ma = "productnum" + strid;
            sterilizecodearr.put(myarr.get(ma), obj.value);
        } else if (obj.id.indexOf('sterilizevalidate') == 0) {
            var strid = obj.id.substring(17, obj.id.length);
            var ma = "productnum" + strid;
            var mydate = obj.value;
            var myproductdate = mydate.substring(0, 4) + "-" + mydate.substring(4, 6) + "-" + mydate.substring(6, 8);
            sterilizevalidatearr.put(myarr.get(ma), myproductdate);
        }
    }

    function getdata(obj) {
        for (var i = 0; i < js_arr.length; i++) {
            if ((js_arr[i].itemcode == obj.value) || js_arr[i].barcode == obj.value) {
                document.getElementById("barcode").value = js_arr[i].barcode;
                document.getElementById("itemcode").value = js_arr[i].itemcode;
                document.getElementById("warehouseinfo").value = js_arr[i].warehouseinfo;
                document.getElementById("number").value = js_arr[i].number;
                document.getElementById("factorys_name").value = js_arr[i].factorys_name;
                if (js_arr[i].suppliername == '医流通') {
                    document.getElementById("suppliername").value = 'YLT';
                } else {
                    document.getElementById("suppliername").value = 'DS';
                }

            }
        }
    }

    function savebatch(obj) {
        if (document.getElementById(obj.id)) {
            if (obj.value.length < 12) {
                alert("输入的批号长度错误");
            } else {
                addmyarr.put(obj.id, obj.value);
            }
        }
    }

    function savenum(obj) {
        if (document.getElementById(obj.id)) {
            addnumarr.put(obj.id, obj.value);
        }
    }

    //产品待收数量与输入数量检验
    function checksonchange(obj1, obj2, obj3) {
        var i = mybarcodes.length;
        var num = parseInt(document.getElementById('number_' + obj1).value);
        var addnum = 0;
        var beforenum = 0;
        for (var j = 0; j < i; j++) {
            var temp1 = mybarcodes[j].indexOf(obj1);
            var temp2 = mybarcodes[j].indexOf(obj2);
            if (temp1 >= 0) {
                addnum = addnum + parseInt(bararr.get(mybarcodes[j]));
            }
            if (temp2 >= 0) {
                if (document.getElementById(idarr.get(mybarcodes[j]))) {
                    beforenum = parseInt(bararr.get(mybarcodes[j]));
                }
            }
        }
        if (num >= (addnum + obj3 - beforenum)) {
            return true;
        }
        return false;
    }

    //检测是否为纯数字
    function checkRate(obj1) {
        var re = /^[1-9]+[0-9]*]*$/;
        var nubmer = document.getElementById(obj1).value;
        if (!re.test(nubmer)) {
            alert("请输入大于1的数字");
            document.getElementById(obj1).value = numarr.get(obj1);
            return false;
        } else {
            return true;
        }
    }
    function dialog() {
        var hA = document.getElementById("div_main");
        hA.style.width = window.screen.availWidth - 20; //得到宽度
        var s_height = document.body.scrollHeight;
        if (s_height < window.screen.availHeight) {
            s_height = window.screen.availHeight;
        }
        hA.style.height = s_height + "px"//设置高度
        hA.style.zIndex = 1000;
        hA.style.position = 'relative';
        hA.style.display = 'none'//block
        document.getElementById("header").style.display = 'block';
    }
    ;
    ;
    function showdialog() {
        var hA = document.getElementById("div_main");
        document.getElementById("div_html").innerHTML = '';
        hA.style.display = 'none';
        document.getElementById("header").style.display = 'block';
    }
    function savedata(str1, str2) {
        var key = "";
        var productdate = "";
        var sterilizecode = "";
        var sterilizevalidate = "";
        var record = document.getElementById("record").value;
        var profileid = document.getElementById("profileid").value;
        var postarr = {};
        if (str1.indexOf('YLT') == 0) {
            key = str1.substring(29, str1.length);
        } else if (str1.indexOf('ATH') == 0) {
            key = str1.substring(26, str1.length);
        } else if (str1.indexOf('BCL') == 0) {
            key = str1.substring(37, str1.length);
        } else if (str1.indexOf('RTK') == 0) {
            key = str1.substring(35, str1.length);
        } else {
            key = str1.substring(26, str1.length);
        }
        if (typeof(productdatearr.get(str1)) != "undefined") {
            productdate = productdatearr.get(str1);
        }
        if (typeof(sterilizecodearr.get(str1)) != "undefined") {
            sterilizecode = sterilizecodearr.get(str1);
        }
        if (typeof(sterilizevalidatearr.get(str1)) != "undefined") {
            sterilizevalidate = sterilizevalidatearr.get(str1);
        }
        postarr[key] = {
            "barcode": str1,
            "number": str2,
            "productdate": productdate,
            "sterilizecode": sterilizecode,
            "sterilizevalidate": sterilizevalidate
        };
        var fields = JSON.stringify(postarr);
        mui.ajax({
            type: 'POST',
            traditional: true,
            dataType: "json",
            url: "save_incheckstorage.php",
            data: {"mybarcodes": fields, "record": record, "profileid": profileid},
            success: function (data) {
//                alert(data);
            }
        });
    }


    function getproductdate(obj1, obj2, obj3) {
        for (var i = 0; i < js_arr.length; i++) {
            if ((js_arr[i].itemcode ==obj2) || js_arr[i].barcode == obj2) {
                var item = js_arr[i].batch_info;
                for (var key in item) {
                    if (item[key].products_batch_no == obj3) {
                        if (obj1 == "productdate") {
                            return item[key].productdate;
                        } else if (obj1 == "sterilizecode") {
                            return item[key].sterilizecode;
                        } else if (obj1 == "sterilizevalidate") {
                            return item[key].sterilizevalidate;
                        }
                    }
                }
            }
        }
        return "";
    }







    {/literal}
</script>
</body>

</html>