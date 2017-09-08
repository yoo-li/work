<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <title>委托调拨出库</title>
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
<header class="mui-bar mui-bar-nav">
    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
    <h1 class="mui-title">{$ma_saleorders_no}</h1>
    <input type="hidden" readonly="readonly"  value="{$record}" id="record" class="form-control middle-width">
    <input type="hidden" readonly="readonly"  value="{$totalnum}" id="totalnum" class="form-control middle-width">
    <input type="hidden" readonly="readonly"  value="{$profileid}" id="profileid" class="form-control middle-width">
    <input type="hidden" readonly="readonly"  value="{$supplierid}" id="supplierid" class="form-control middle-width">
</header>
<div id="div_main" style="background-color: #fff ">
    <div id="div_html">
    </div>
    <div>
        <button type="button" class="mui-btn" id="div_main_close">关闭</button>
        <button type="button" class="mui-btn" id="div_main_ok">确定</button>
    </div>
</div>
<div id="pullrefresh" class="mui-content mui-scroll-wrapper" style="padding-top: 50px;">
    <div class="mui-collapse-content">
        <form class="mui-input-group">
            <button type="button" class="mui-btn" id="finishsann">完成扫码</button>
            <button type="button" class="mui-btn" id="recheck">提交复核</button>
            <button type="button" class="mui-btn" id="find" style="float: right;">手动添加批号</button>
            <input style="font-size: 15px;" type="text" readonly="readonly" id="show"
                   value="总数量:{$totalnum}/0">
	    <div id="div_find">
            </div>
            {foreach name=blocks key=header item=data from=$inventoryauthoout}
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
                        <label style="font-size: 15px;">待发数量：</label>
                        <input style="font-size: 15px;" type="text" readonly="readonly" id="number_{$data.itemcode}" value="{$data.number}">
                        <input style="font-size: 15px;" type="hidden" readonly="readonly" id="number_{$data.barcode}" value="{$data.number}">
                    </div>
                    <div id="div_{$data.itemcode}"></div>
                    <div id="div_{$data.barcode}"></div>
                </div>
            {/foreach}

        </form>
        {include file='copyright.tpl'}
        </br></br></br></br></br></br></br></br></br>
    </div>
</div>
<script src="/public/js/mui.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/public/js/cordova.js"></script>
<script type="text/javascript" charset="utf-8">
    {literal}
    var mybarcodes = [];
    var idarr = new Dictionary();//保存码和控件id
    var numarr = new Dictionary();//保存控件id和数量
    var bararr = new Dictionary();//保存码和数量
    var myarr = new Dictionary();//保存控件id和码
    var num = 0;
    var addnum = 0;//手动添加的
    var addnumarr = new Dictionary();//add保存控件id和数量
    var addbararr = new Dictionary();//add保存码和数量
    var addmyarr = new Dictionary();//add保存控件id和码
    var totalnum = document.getElementById("totalnum").value;//订单出库总数
    var barnum = 0;//已扫描数量
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
//    mui('body').on('tap', '#starsann', function (e) {
//        Cordova.exec(null, null, "PhoneGapPlugin", "PluginFunction", [{"type": "qrcodescann"}]);
//    });
    mui('body').on('tap', 'button#finishsann', function (e) {
        var record=document.getElementById("record").value;
        var profileid=document.getElementById("profileid").value;
        var myarr = [];
        for(var i=0;i<mybarcodes.length;i++){
//            alert(mybarcodes[i]+"======"+bararr.get(mybarcodes[i]));
            var myjson={};
            myjson.barcode=mybarcodes[i];
            myjson.number=bararr.get(mybarcodes[i]);
            myarr.push(myjson);
        }
        var fields = JSON.stringify(myarr);
        mui.ajax({
            type: 'POST',
            traditional :true,
            dataType:"json",
            url: "save_inventoryauthoout.php",
            data: {"mybarcodes":fields,"record":record,"profileid":profileid},
            success: function (data)
            {
                if(data=="200"){
                    alert("保存成功");
                    document.getElementById("finishsann").style.color="red";
                }
            }
        });

    });
    mui('body').on('tap', 'button#recheck', function (e) {
        var record=document.getElementById("record").value;
        var profileid=document.getElementById("profileid").value;
        var supplierid=document.getElementById("supplierid").value;
        mui.ajax({
            type: 'POST',
            traditional :true,
            dataType:"json",
            url: "recheckbyauthoout.php",
            data: {"record":record,"profileid":profileid,"supplierid":supplierid},
            success: function (data)
            {
                if(data=="200"){
                    alert("提交复核成功");
                    document.getElementById("recheck").style.color="red";
                    document.getElementById("recheck").attr("disabled","true");
                }
            }
        });
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
                    '<input type="hidden" readonly="readonly"  id="suppliername" class="form-control middle-width">'+
                    '</div>' +
                    '<div class="mui-input-row" style="height: auto;">' +
                    '<label style="font-size: 15px;">仓库位置：</label>' +
                    '<input style="float: left;" id="warehouseinfo" readonly="readonly">' +
                    '</div>' +
                    '<div class="mui-input-row">' +
                    '<label style="font-size: 15px;">待发数量：</label>' +
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
        if(suppliername==='YLT'){
            var itemcodes = document.getElementById("barcode").value;
        }else{
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
            var suppliername = document.getElementById("suppliername").value;
            if (suppliername === 'YLT') {
                var itemcodes = document.getElementById("barcode").value;
            }
            else {
                var itemcodes = document.getElementById("itemcode").value;
            }
            for (var i = 1; i <= addnum; i++) {
                if (suppliername === 'YLT') {
                    if (document.getElementById('add_batch_no_' + itemcodes + '_' + i)) {
                        if(itemcodes.length==16){
                            addbararr.put("YLT" + itemcodes + document.getElementById('add_batch_no_' + itemcodes + '_' + i).value, addnumarr.get("add_productnum_" + itemcodes + "_" + i));
                            addJsonResult("YLT" + itemcodes + addmyarr.get("add_batch_no_" + itemcodes + "_" + i));
                        }else if(itemcodes.length==13){
                            addbararr.put("ATH" + itemcodes + document.getElementById('add_batch_no_' + itemcodes + '_' + i).value, addnumarr.get("add_productnum_" + itemcodes + "_" + i));
                            addJsonResult("ATH" + itemcodes + addmyarr.get("add_batch_no_" + itemcodes + "_" + i));
                        }

                    }
                }
            }else{
                if(document.getElementById('add_batch_no_' + itemcodes + '_' + i)) {
                    addbararr.put(itemcodes + document.getElementById('add_batch_no_' + itemcodes + '_' + i).value, addnumarr.get("add_productnum_" + itemcodes + "_" + i));
                        addJsonResult(itemcodes + addmyarr.get("add_batch_no_" + itemcodes + "_" + i));
                }
            }

            };
            var hA = document.getElementById("div_main");
            hA.style.display = 'block';
            var test = document.getElementById("div_" + itemcodes).parentNode.cloneNode(true);
            document.getElementById("div_html").innerHTML = '';
            document.getElementById("div_html").appendChild(test);
            mui('#div_main').off("change", "input");
            mui('#div_main').on('change', "input", function () {
                newchanges(this);
            });
        });

        mui('body').on('tap', 'button#div_main_close', function (e) {
            var totle = 0;
            mui('form .products input[type="number"] ').each(function () {
                var self = this;
                totle += parseInt(self.value);
            });
            document.getElementById('show').value = '总数量:' + totalnum + '/' + totle;
            barnum=totle;
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
                    this.value = self.value;
                    addnumarr.put(this.id, this.value);
                });
            });
            mui('form .products input[type="number"] ').each(function () {
                var self = this;
                totle += parseInt(self.value);
            });

            document.getElementById('show').value = '总数量:' + totalnum + '/' + totle;
            barnum=totle;
            showdialog();
        });

        mui('.mui-scroll-wrapper').scroll({

            deceleration: 0.0005 //flick 减速系数，系数越大，滚动速度越慢，滚动距离越小，默认值0.0006
        });
        dialog();
    })
    function JsonResult(Str) {
        showdialog();
        var result = Str;
        if (result.substring(0, 3) === 'YLT') {
            var itemcodes = result.substring(3, 19);//条码
            var batchcodes = result.substring(29);//批号
        } else if (result.substring(0, 3) === 'ATH') {
            var itemcodes = result.substring(3, 16);
            var batchcodes = result.substring(26);
        } else {
            var itemcodes = result.substring(3, 15);
            var batchcodes = result.substring(26);
        }
        if (checks(mybarcodes, result)) {

            if (contains(mybarcodes, result)) {
                mui('form input#' + idarr.get(result)).each(function () {
                    this.value = parseInt(numarr.get(idarr.get(result))) + 1;
                    numarr.put(idarr.get(result), this.value);
                });
            }
            else {
                mybarcodes.push(result);
                idarr.put(result, "productnum_" + itemcodes + "_" + num);
                numarr.put(idarr.get(result), "1");
                //动态添加元素
                var testdiv = document.getElementById("div_" + itemcodes);
                if (testdiv) {
                    testdiv.innerHTML += '<div class="mui-input-row" style="height: 60px">' +
                            '<label style="font-size: 15px;">批号:</label>' +
                            '<textarea id="batch_no_' + itemcodes + '_' + num + '" rows="2" readonly="">' + batchcodes + '</textarea>' +
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
                        }
                    }
                    mui('.products').on('change', "input", function () {
                        changes(this);
                    });
                    myarr.put("productnum_" + itemcodes + "_" + num, result);
                    num += 1;
                }
            }
            bararr.put(result, document.getElementById(idarr.get(result)).value);
            barnum += 1;
            document.getElementById('show').value = '总数量:' + totalnum + '/' + barnum;
            var hA = document.getElementById("div_main");
            hA.style.display = 'block';
            var test = document.getElementById("div_" + itemcodes).parentNode.cloneNode(true);
            document.getElementById("div_html").innerHTML = '';
            document.getElementById("div_html").appendChild(test);
            mui('#div_main').off("change", "input");
            mui('#div_main').on('change', "input", function () {
                newchanges(this);
            });
        }
        else {
            alert("超过待发数量");
        }
    }
    function addJsonResult(Str) {
        var result = Str;
        if (result.substring(0, 3) === 'YLT') {
            var itemcodes = result.substring(3, 19);//条码
            var batchcodes = result.substring(29);//批号
        } else if (result.substring(0, 3) === 'ATH') {
            var itemcodes = result.substring(3, 16);
            var batchcodes = result.substring(26);
        } else {
            var itemcodes = result.substring(3, 15);
            var batchcodes = result.substring(26);//批号
        }
        if (checks(mybarcodes, result)) {
            if (contains(mybarcodes, result)) {
                mui('form input#' + idarr.get(result)).each(function () {
                    this.value = addbararr.get(result);
                    numarr.put(idarr.get(result), addbararr.get(result));
                });
            }
            else {
                mybarcodes.push(result);
                idarr.put(result, "productnum_" + itemcodes + "_" + num);
                numarr.put(idarr.get(result), addbararr.get(result));
                //动态添加元素
                var testdiv = document.getElementById("div_" + itemcodes);
                if (testdiv) {
                    testdiv.innerHTML += '<div class="mui-input-row" style="height: 60px">' +
                            '<label style="font-size: 15px;">批号:</label>' +
                            '<textarea id="batch_no_' + itemcodes + '_' + num + '" rows="2" readonly="">' + batchcodes + '</textarea>' +
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
                        }
                    }
                    mui('.products').on('change', "input", function () {
                        changes(this);
                    });
                    myarr.put("productnum_" + itemcodes + "_" + num, result);
                    num += 1;
                }
            }
            bararr.put(result, document.getElementById(idarr.get(result)).value);
            barnum = parseInt(barnum) + parseInt(addbararr.get(result));
            document.getElementById('show').value = '总数量:' + totalnum + '/' + barnum;

        } else {
            alert("超过待发数量");
        }
    }

    //检测该批号是否已经扫过
    function contains(arr, obj) {
        var i = arr.length;
        while (i--) {
            if (arr[i] === obj) {
                return true;
            }
        }
        return false;
    }

    //产品待发数量与扫入数量检验
    function checks(arr, obj1) {
        var i = arr.length;
        if (i > 0) {
            if (obj1.substring(0, 3) === 'YLT') {
                var codes = obj1.substring(3, 19);//条码
            } else if (obj1.substring(0, 3) === 'ATH') {
                var codes = obj1.substring(3, 16);
            } else {
                var codes = obj1.substring(3, 15);
            }
            var num = parseInt(document.getElementById('number_'+ codes).value);
            var addnum = 0;
                for(var j=0;j<i;j++){
                var temp=arr[j].indexOf(codes);
                if (temp>=0) {
                    if(document.getElementById(idarr.get(arr[j]))){
                        addnum=addnum+parseInt(document.getElementById(idarr.get(arr[j])).value);
                    }
                }
            }

            if(num>addnum){
                return true;
            }
            return false;
        }else{
            return true;
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
                    alert("超过待发数量");
                });
            }
        }
    }

    //新产品数量框输入检测
    function newchanges(obj) {
        if (checkRate(obj.id)) {
            var strid = obj.id.substring(10, obj.id.length);
            var barcodesid = "batch_no" + strid;
            var strs = strid.split("_");
            if (!checksonchange(strs[1], document.getElementById(barcodesid).value, parseInt(obj.value))) {
                obj.value = numarr.get(obj.id);
                alert("超过待发数量");
            }
        }
    }

    function getdata(obj) {
        var record = document.getElementById("record").value;
        mui.ajax({
            type: 'POST',
            traditional: true,
            dataType: "json",
            url: "find.php",
            data: {"record": record, "barcode": obj.value,"mode":"inventoryauthoout"},
            success: function (data) {
                document.getElementById("barcode").value = data.barcode;
                document.getElementById("itemcode").value = data.itemcode;
                document.getElementById("warehouseinfo").value = data.warehouseinfo;
                document.getElementById("number").value = data.number;
                document.getElementById("suppliername").value = data.suppliername;

            }
        });
    }

    function savebatch(obj) {
        if (document.getElementById(obj.id)) {
            addmyarr.put(obj.id, obj.value);
        }
    }

    function savenum(obj) {
        if (document.getElementById(obj.id)) {
            addnumarr.put(obj.id, obj.value);
        }
    }

    //产品待发数量与输入数量检验
    function checksonchange(obj1,obj2,obj3) {
            var i = mybarcodes.length;
            var num = parseInt(document.getElementById('number_'+ obj1).value);
            var addnum = 0;
            var beforenum=0;
            for(var j=0;j<i;j++){
                    var temp1=mybarcodes[j].indexOf(obj1);
                    var temp2=mybarcodes[j].indexOf(obj2);
                    if(temp1>=0){
                        addnum=addnum+parseInt(bararr.get(mybarcodes[j]));
                    }
                    if (temp2>=0) {
                        if(document.getElementById(idarr.get(mybarcodes[j]))){
                            beforenum=parseInt(bararr.get(mybarcodes[j]));
                        }
                    }
            }
            if(num>=(addnum+obj3-beforenum)){
                return true;
            }
            return false;
    }

    //检测是否为纯数字
    function checkRate(obj1)
    {
        var re = /^[1-9]+[0-9]*]*$/;
        var nubmer = document.getElementById(obj1).value;
        if (!re.test(nubmer))
        {
            alert("请输入大于1的数字");
            document.getElementById(obj1).value = numarr.get(obj1);
            return false;
        }else{
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
    };;
    function showdialog() {
        var hA = document.getElementById("div_main");
        document.getElementById("div_html").innerHTML = '';
        hA.style.display = 'none';
    }












    {/literal}
</script>
</body>

</html>