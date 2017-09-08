<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>采购验收</title>
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
        </br></br></br>
        <button type="button" class="mui-btn" id="div_main_close" style="width: 80px;margin-left: 80px">关闭</button>
        <button type="button" class="mui-btn" id="div_main_ok" style="width: 80px;margin-left: 20px">保存</button>
    </div>
    </br></br></br></br></br></br></br></br>
</div>
<header class="mui-bar mui-bar-nav" id="header">
    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
    <h1 class="mui-title">{$ma_saleorders_no}</h1>
    <input type="hidden" readonly="readonly" value="{$ma_checkordersid}" id="ma_checkordersid" class="form-control middle-width">
    <input type="hidden" readonly="readonly" value="{$record}" id="record" class="form-control middle-width">
    <input type="hidden" readonly="readonly" value="{$takepartin}" id="takepartin" class="form-control middle-width">
    <input type="hidden" readonly="readonly" value="{$totalnum}" id="totalnum" class="form-control middle-width">
    <input type="hidden" readonly="readonly" value="{$profileid}" id="profileid" class="form-control middle-width">
    <input style="font-size: 15px;" type="text" readonly="readonly" id="show"
           value="总数量:{$totalnum}/0">
</header>
<div id="pullrefresh" class="mui-content mui-scroll-wrapper" style="padding-top: 120px;">
    <div class="mui-collapse-content">
        <form class="mui-input-group">
            <button type="button" class="mui-btn" id="finishsann">完成扫码</button>
            <button type="button" class="mui-btn" id="find" style="float: right;">手动添加批号</button>
            <div id="div_find">
            </div>
            {foreach name=blocks key=header item=data from=$instoragecheck}
                <div class="mui-collapse-content products" style="margin: 3px 3px;">
                    <div class="mui-input-row" style="font-size: 15px; height: 10px">
                        <label style="font-size: 15px;"></label>
                    </div>
                    <input style="font-size: 15px; width: 100px" type="text" readonly="readonly"
                           value="{$data.barcode}">
                    <input style="font-size: 15px; width: 180px" type="text" readonly="readonly"
                           value="{$data.productname}">
                    <input style="font-size: 15px; width: 50px" type="text" readonly="readonly" id="number_{$data.itemcode}"
                           value="{$data.number}">
                    <input style="font-size: 15px; width: 1px" type="hidden" readonly="readonly" id="number_{$data.barcode}"
                           value="{$data.number}">
                </div>
            {/foreach}
        </form>
        {include file='copyright.tpl'}
        </br></br></br></br></br></br></br></br></br>
    </div>
</div>
<script src="/public/js/mui.min.js"></script>
<script src="/public/js/rule.js"></script>
<script type="text/javascript" charset="utf-8" src="/public/js/cordova.js"></script>
<script type="text/javascript" charset="utf-8">
    var js_arr ={$js_arr};
    {literal}
    var thisresult = "";
    var bararr = new Dictionary();//保存码和数量
    var sanncode_json = {};
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
        mui('.products').on('change', "input", function () {
            changes(this);
        });
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
            var takepartin = document.getElementById("takepartin").value;
            var ma_checkordersid = document.getElementById("ma_checkordersid").value;
            mui.ajax({
                type: 'POST',
                traditional: true,
                dataType: "json",
                url: "finishsanncode.php",
                data: {"record": ma_checkordersid, "takepartin": takepartin, "mode": "instoragecheck"},
                success: function (data) {
                    if (data == "200") {
                        alert("保存成功");
                        document.getElementById("finishsann").style.color = "red";
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
            var suppliername = document.getElementById("suppliername").value;
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
        });
        mui('body').on('tap', 'button#div_main_close', function (e) {
            showdialog();
        });
        mui('body').on('tap', 'button#div_main_ok', function (e) {
            //保存数据
            savedata(thisresult, "0");
            showdialog();
        });
        mui('.mui-scroll-wrapper').scroll({
            deceleration: 0.0005 //flick 减速系数，系数越大，滚动速度越慢，滚动距离越小，默认值0.0006
        });
        dialog();
//        JsonResult("010694950157155513150508211409277040");
    });
    function JsonResult(result) {
        showdialog();
        thisresult = result;
        var itemcodes = getitemcode(result);
        var batchcodes = getbatchcode(result);
        var takepartin = document.getElementById("takepartin").value;
        if (document.getElementById("number_" + itemcodes)) {
            if (sanncode_json[result] != undefined) {
                var onum = sanncode_json[result]["number"];
                sanncode_json[result]["number"] = parseInt(onum, 10) + parseInt(1, 10);
            } else {
                sanncode_json[result] = {
                    "sanncodes": result,
                    "itemcodes": itemcodes,
                    "batchcodes": batchcodes,
                    "number": "1",
                };
            }
            var mytestdiv = creatdialog2(js_arr, itemcodes, takepartin, sanncode_json);
            var hA = document.getElementById("div_main");
            hA.style.display = 'block';
            document.getElementById("header").style.display = 'none';
            document.getElementById("div_html").innerHTML = '';
            document.getElementById("div_html").innerHTML = mytestdiv;
            mui('#div_main').on('change', "input", function () {
                newchanges(this);
            });
            if (parseInt(document.getElementById("productnum_" + itemcodes + "_" + batchcodes).value,10) >= 0) {
                barnum += 1;
                savedata(thisresult, 1);
            } else if (parseInt(document.getElementById("productnum_" + itemcodes + "_" + batchcodes).value,10) < 0) {
                document.getElementById("productnum_" + itemcodes + "_" + batchcodes).value = 0;
                sanncode_json[result]["number"]=parseInt(sanncode_json[result]["number"],10)-parseInt(1,10);
                alert(itemcodes + "产品的" + batchcodes + "批号已验收完!");
            }
            document.getElementById('show').value = '总数量:' + totalnum + '/' + barnum;
        }else {
            alert("找不到编码为" + itemcodes + "批号为" + batchcodes + "的未验收产品");
        }
    }

    function addJsonResult(result) {
        thisresult = result;
        var itemcodes = getitemcode(result);
        var batchcodes = getbatchcode(result);
        var thisnum = parseInt(addbararr.get(result), 10);
        var takepartin = document.getElementById("takepartin").value;
        if (document.getElementById("number_" + itemcodes)) {
            if (sanncode_json[result] != undefined) {
                var onum = sanncode_json[result]["number"];
                sanncode_json[result]["number"] = parseInt(onum, 10) + parseInt(thisnum, 10);
            } else {
                sanncode_json[result] = {
                    "sanncodes": result,
                    "itemcodes": itemcodes,
                    "batchcodes": batchcodes,
                    "number": thisnum,
                };
            }
            var mytestdiv = creatdialog2(js_arr, itemcodes, takepartin, sanncode_json);
            var hA = document.getElementById("div_main");
            hA.style.display = 'block';
            document.getElementById("header").style.display = 'none';
            document.getElementById("div_html").innerHTML = '';
            document.getElementById("div_html").innerHTML = mytestdiv;
            mui('#div_main').on('change', "input", function () {
                newchanges(this);
            });
            if (parseInt(document.getElementById("productnum_" + itemcodes + "_" + batchcodes).value,10) >= 0) {
                barnum += thisnum;
                savedata(thisresult, thisnum);
            } else if (parseInt(document.getElementById("productnum_" + itemcodes + "_" + batchcodes).value,10) < 0) {
                document.getElementById("productnum_" + itemcodes + "_" + batchcodes).value = 0;
                sanncode_json[result]["number"]=parseInt(sanncode_json[result]["number"],10)-parseInt(thisnum,10);
                alert(itemcodes + "产品的" + batchcodes + "批号已验收完!");
            }
            document.getElementById('show').value = '总数量:' + totalnum + '/' + barnum;
        }else {
            alert("找不到编码为" + itemcodes + "批号为" + batchcodes + "的未验收产品");
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


    //新产品数量框输入检测
    function newchanges(obj) {
        var newid = "hidden_" + obj.id;
        var maxnum = document.getElementById(newid).value;
        var strid = obj.id.substring(10, obj.id.length);
        var hiddenid="hidden"+ strid;
        var hidden=document.getElementById(hiddenid).value;
        var sannnumber=sanncode_json[hidden].number;
        if (checkRate(obj.id,sannnumber)) {
            var number=parseInt(maxnum,10)-parseInt(sannnumber,10);//数字框中数量
            if (parseInt(obj.value,10) > parseInt(number,10)) {
                mui('#div_html input#' + obj.id).each(function () {
                    this.value = number;
                    alert("超过待收数量");
                });
            }else{
                var strid = obj.id.substring(10, obj.id.length);
                var changenum=parseInt(number,10)-parseInt(obj.value,10);
                savedata("WZD" + strid, changenum);
                barnum=parseInt(barnum,10)+parseInt(changenum,10);
                document.getElementById('show').value = '总数量:' + totalnum + '/' + barnum;
            }
        }
    }

    //检测是否为纯数字
    function checkRate(obj1,obj2) {
        var re = /^[0-9]+[0-9]*]*$/;
        var nubmer = document.getElementById(obj1).value;
        if (!re.test(nubmer)) {
            alert("请输入大于0的数字");
            document.getElementById(obj1).value = obj2;
            return false;
        } else {
            return true;
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
        var record = document.getElementById("record").value;
        var takepartin = document.getElementById("takepartin").value;
        var profileid = document.getElementById("profileid").value;
        var ma_checkordersid = document.getElementById("ma_checkordersid").value;
        var postarr = {};
        var itemcodes = getitemcode(str1);
        var batchcodes = getbatchcode(str1);
        var tempnumber = parseInt(document.getElementById("hidden_productnum_" + itemcodes + "_" + batchcodes).value,10) - parseInt(str2,10);
        postarr[batchcodes] = {
            "barcode": str1,
            "number": str2,
            "refusenumber": tempnumber
        };
        var fields = JSON.stringify(postarr);
        mui.ajax({
            type: 'POST',
            traditional: true,
            dataType: "json",
            url: "save_instoragecheck.php",
            data: {
                "mybarcodes": fields,
                "record": record,
                "takepartin": takepartin,
                "profileid": profileid,
                "ma_checkordersid": ma_checkordersid
            },
            success: function (data) {
                if (data == "200") {
//                        document.getElementById("div_main_ok").style.color = "red";
                }
            }
        });
    }
    {/literal}
</script>
</body>

</html>