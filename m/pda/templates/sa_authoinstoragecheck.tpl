<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>委托调拨验收</title>
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
<div id="div_main" style="background-color: #fff ">
    <div id="div_html">
    </div>
    <div>
        <button type="button" class="mui-btn" id="div_main_close">关闭</button>
        <button type="button" class="mui-btn" id="div_main_ok">确定</button>
    </div>
</div>
<header class="mui-bar mui-bar-nav">
    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
    <h1 class="mui-title">{$ma_saleorders_no}</h1>
    <input type="hidden" readonly="readonly"  value="{$record}" id="record" class="form-control middle-width">
    <input type="hidden" readonly="readonly"  value="{$takepartin}" id="takepartin" class="form-control middle-width">
    <input type="hidden" readonly="readonly"  value="{$totalnum}" id="totalnum" class="form-control middle-width">
    <input type="hidden" readonly="readonly"  value="{$profileid}" id="profileid" class="form-control middle-width">
</header>
<div id="pullrefresh" class="mui-content mui-scroll-wrapper" style="padding-top: 50px;">
    <div class="mui-collapse-content">
        <form class="mui-input-group">
            <button type="button" class="mui-btn" id="finishsann">完成扫码</button>
            <button type="button" class="mui-btn" id="find" style="float: right;">手动添加批号</button>
            <input style="font-size: 15px;" type="text" readonly="readonly" id="show"
                   value="总数量:{$totalnum}/0">
 	    <div id="div_find">
            </div>
            {foreach name=blocks key=header item=data from=$instoragecheck}
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
                        <input style="font-size: 15px;" type="text" readonly="readonly" id="number_{$header}" value="{$data.number}">
                    </div>
                    {foreach  key=key item=info from=$data.batch_info}
                    <div class="mui-input-row" style="height: 60px">
                        <label style="font-size: 15px;">批号：</label>
                        {if $data.suppliername eq '医流通'}
                            <textarea id="batch_no_{$data.barcode}_{$info.products_batch_no}" rows="2" readonly="">{$info.products_batch_no}</textarea>
                        {else}
                            <textarea id="batch_no_{$data.itemcode}_{$info.products_batch_no}" rows="2" readonly="">{$info.products_batch_no}</textarea>
                        {/if}
                    </div>
                    <div class="mui-input-row">
                        <label style="font-size: 15px;">产品数量：</label>
                        <div class="mui-numbox" data-numbox-min='0' data-numbox-max='9999999999' style="width:170px">
                            <button class="mui-btn mui-btn-numbox-minus" type="button">-</button>
                            {if $data.suppliername eq '医流通'}
                                <input id="productnum_{$data.barcode}_{$info.products_batch_no}" class="mui-input-numbox" type="number" value="{$info.instoragenumber}"  onchange="changes(this);"/>
                            {else}
                                <input id="productnum_{$data.itemcode}_{$info.products_batch_no}" class="mui-input-numbox" type="number" value="{$info.instoragenumber}"  onchange="changes(this);"/>
                            {/if}
                            <button class="mui-btn mui-btn-numbox-plus" type="button">+</button>
                        </div>
                    </div>
                        {if $data.suppliername eq '医流通'}
                            <input id="hidden_productnum_{$data.barcode}_{$info.products_batch_no}" class="mui-input-numbox" type="hidden" value="{$info.instoragenumber}"/>
                        {else}
                            <input id="hidden_productnum_{$data.itemcode}_{$info.products_batch_no}" class="mui-input-numbox" type="hidden" value="{$info.instoragenumber}"/>
                        {/if}
                        {/foreach}
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
    var bararr = new Dictionary();//保存码和数量
    var totalnum = document.getElementById("totalnum").value;//订单出库总数
    var barnum = 0;//已扫描数量
    var addnum = 0;//手动添加的
    var addnumarr = new Dictionary();//add保存控件id和数量
    var addbararr = new Dictionary();//add保存码和数量
    var addmyarr = new Dictionary();//add保存控件id和码
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
    mui('body').on('tap', 'button#finishsann', function (e) {
        var record=document.getElementById("record").value;
        var takepartin=document.getElementById("takepartin").value;
        var profileid=document.getElementById("profileid").value;
        var myarr = [];
        for(var i=0;i<mybarcodes.length;i++){
            var myjson={};
            var temp=mybarcodes[i];
            if(temp.substring(0,3)==='YLT'){
                var itemcodes=temp.substring(3,19);//条码
                var batchcodes=temp.substring(29);//批号
                }else if (temp.substring(0, 3) === 'ATH') {
                    var itemcodes = temp.substring(3, 16);
                    var batchcodes = temp.substring(26);
            }else{
                var itemcodes=temp.substring(3,15);//条码
                var batchcodes=temp.substring(26);//批号
            }
            myjson.barcode=temp;
            var btnnum=parseInt(bararr.get("_"+itemcodes+"_"+batchcodes));
            if(btnnum<=0){
                btnnum=0;
            }
            
            myjson.number=parseInt(document.getElementById("hidden_productnum_"+itemcodes+"_"+batchcodes).value)-parseInt(btnnum);
            myjson.refusenumber=parseInt(btnnum);
            myarr.push(myjson);
        }
        var fields = JSON.stringify(myarr);
        mui.ajax({
            type: 'POST',
            traditional :true,
            dataType:"json",
            url: "save_authoinstoragecheck.php",
            data: {"mybarcodes":fields,"record":record,"takepartin":takepartin,"profileid":profileid},
            success: function (data)
            {
                if(data=="200"){
                    alert("保存成功");
                    document.getElementById("finishsann").style.color="red";
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
        if(suppliername==='YLT'){
            var itemcodes = document.getElementById("barcode").value;
        }else{
            var itemcodes = document.getElementById("itemcode").value;
        }
        for (var i = 1; i <= addnum; i++) {
            if(suppliername==='YLT'){
                if(document.getElementById('add_batch_no_' + itemcodes + '_' + i)) {
                        if(itemcodes.length==16) {
                        var batchcodes = addmyarr.get("add_batch_no_" + itemcodes + "_" + i).substring(10);
                    addbararr.put("YLT" + itemcodes + document.getElementById('add_batch_no_' + itemcodes + '_' + i).value, addnumarr.get("add_productnum_" + itemcodes + "_" + i));
                        addJsonResult("YLT" + itemcodes + addmyarr.get("add_batch_no_" + itemcodes + "_" + i));
                        }else if(itemcodes.length==13) {
                            var batchcodes = addmyarr.get("add_batch_no_" + itemcodes + "_" + i).substring(10);
                            addbararr.put("ATH" + itemcodes + document.getElementById('add_batch_no_' + itemcodes + '_' + i).value, addnumarr.get("add_productnum_" + itemcodes + "_" + i));
                            addJsonResult("ATH" + itemcodes + addmyarr.get("add_batch_no_" + itemcodes + "_" + i));
                        }
                }
            }else{
                if(document.getElementById('add_batch_no_' + itemcodes + '_' + i)) {
                        var batchcodes = addmyarr.get("add_batch_no_" + itemcodes + "_" + i).substring(10);
                    addbararr.put(itemcodes + document.getElementById('add_batch_no_' + itemcodes + '_' + i).value, addnumarr.get("add_productnum_" + itemcodes + "_" + i));
                        addJsonResult(itemcodes + addmyarr.get("add_batch_no_" + itemcodes + "_" + i));
                }
            }

            }
            var hA = document.getElementById("div_main");
            hA.style.display = 'block';
            var test = document.getElementById("hidden_productnum_" + itemcodes + "_" + batchcodes).parentNode.cloneNode(true);
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
            totle=parseInt(totalnum)-parseInt(totle);
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
                    bararr.put(self.id.substring(10), self.value);
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
            totle = parseInt(totalnum) - parseInt(totle);
            document.getElementById('show').value = '总数量:' + totalnum + '/' + totle;
            barnum=totle;
            showdialog();
        });
        mui('.mui-scroll-wrapper').scroll({

            deceleration: 0.0005 //flick 减速系数，系数越大，滚动速度越慢，滚动距离越小，默认值0.0006
        });
        dialog();
    });
    function JsonResult(Str) {
        showdialog();
        var result = Str;
        if (result.substring(0, 3) === 'YLT') {
            var itemcodes = result.substring(3, 19);//条码
            var batchcodes = result.substring(29);//批号
        }else if (result.substring(0, 3) === 'ATH') {
            var itemcodes = result.substring(3, 16);
            var batchcodes = result.substring(26);
        } else {
            var itemcodes = result.substring(3, 15);
            var batchcodes = result.substring(26);
        }
        if (document.getElementById("batch_no_" + itemcodes + "_" + batchcodes)) {
            if (!contains(mybarcodes, result)) {
                mybarcodes.push(result);
            }
            barnum += 1;
            if (parseInt(document.getElementById("productnum_" + itemcodes + "_" + batchcodes).value) > 1) {
                document.getElementById("productnum_" + itemcodes + "_" + batchcodes).value = Math.abs(parseInt(document.getElementById("productnum_" + itemcodes + "_" + batchcodes).value) - 1);
                bararr.put("_" + itemcodes + "_" + batchcodes, document.getElementById("productnum_" + itemcodes + "_" + batchcodes).value);
                var test = document.getElementById("batch_no_" + itemcodes + "_" + batchcodes).parentNode.parentNode.cloneNode(true);
                var hA = document.getElementById("div_main");
                hA.style.display = 'block';
                document.getElementById("div_html").innerHTML = '';
                document.getElementById("div_html").appendChild(test);
                mui('#div_main').off("change", "input");
                mui('#div_main').on('change', "input", function () {
                    newchanges(this);
                });
            } else {
                document.getElementById("batch_no_" + itemcodes + "_" + batchcodes).parentNode.remove();
                document.getElementById("productnum_" + itemcodes + "_" + batchcodes).parentNode.parentNode.remove();
                bararr.put("_" + itemcodes + "_" + batchcodes, "0");
            }
            document.getElementById('show').value = '总数量:' + totalnum + '/' + barnum;
        }
    }

    function addJsonResult(Str) {
        var result = Str;
        if (result.substring(0, 3) === 'YLT') {
            var itemcodes = result.substring(3, 19);//条码
            var batchcodes = result.substring(29);//批号
        }else if (result.substring(0, 3) === 'ATH') {
            var itemcodes = result.substring(3, 16);
            var batchcodes = result.substring(26);
        } else {
            var itemcodes = result.substring(3, 15);
            var batchcodes = result.substring(26);
        }
        if (document.getElementById("batch_no_" + itemcodes + "_" + batchcodes)) {

            if (!contains(mybarcodes, result)) {
                mybarcodes.push(result);
            }
            barnum = parseInt(barnum) + parseInt(addbararr.get(result));
            if (parseInt(document.getElementById("productnum_" + itemcodes + "_" + batchcodes).value) > addbararr.get(result)) {
                document.getElementById("productnum_" + itemcodes + "_" + batchcodes).value = Math.abs(parseInt(document.getElementById("productnum_" + itemcodes + "_" + batchcodes).value) - addbararr.get(result));
                bararr.put("_" + itemcodes + "_" + batchcodes, document.getElementById("productnum_" + itemcodes + "_" + batchcodes).value);
            } else {
                document.getElementById("batch_no_" + itemcodes + "_" + batchcodes).parentNode.remove();
                document.getElementById("productnum_" + itemcodes + "_" + batchcodes).parentNode.parentNode.remove();
                bararr.put("_" + itemcodes + "_" + batchcodes, "0");
            }
            document.getElementById('show').value = '总数量:' + totalnum + '/' + barnum;
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

    function changes(obj){
        var strid=obj.id.substring(10,obj.id.length);
        var barcodesid="batch_no"+strid;
        if(typeof(bararr.get(strid))=="undefined"){
            bararr.put(strid,document.getElementById("hidden_productnum"+strid).value);
        }
        if(checkRate(obj.id)){
            var beforenum=parseInt(bararr.get(strid));
            barnum=barnum-parseInt(obj.value)+beforenum;
            document.getElementById('show').value='总数量:'+totalnum+'/'+barnum;
            bararr.put(strid,obj.value);
        }
    }

    //新产品数量框输入检测
    function newchanges(obj) {
        var strid = obj.id.substring(10, obj.id.length);
        var barcodesid = "batch_no" + strid;
        if (typeof(bararr.get(strid)) == "undefined") {
            bararr.put(strid, document.getElementById("hidden_productnum" + strid).value);
        }
        if (checkRate(obj.id)) {
            var beforenum = parseInt(bararr.get(strid));
            barnum = barnum - parseInt(obj.value) + beforenum;
            bararr.put(strid, obj.value);
        }
    }
    //检测是否为纯数字
    function checkRate(obj1) {
        var re = /^[1-9]+[0-9]*]*$/;
        var nubmer = document.getElementById(obj1).value;
        var strid = obj1.substring(10, obj1.length);
        if (!re.test(nubmer)) {
            alert("请输入大于1的数字");
            document.getElementById(obj1).value = bararr.get(strid);
            return false;
        } else {
            return true;
        }
    }

    function getdata(obj) {
        var record = document.getElementById("record").value;
        mui.ajax({
            type: 'POST',
            traditional: true,
            dataType: "json",
            url: "find.php",
            data: {"record": record, "barcode": obj.value,"mode":"authoinstoragecheck"},
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