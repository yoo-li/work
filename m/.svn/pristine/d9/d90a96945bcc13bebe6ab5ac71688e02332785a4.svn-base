//获取产品编码或条码
function getitemcode(obj) {
    var itemcodes = "";
    if (obj.substring(0, 3) === 'WZD') {
        var strs = obj.split("_");
        itemcodes = strs[1];//条码
    } else if (obj.substring(0, 3) === 'YLT') {//威曼.威高
        itemcodes = obj.substring(3, 19);
    } else if (obj.substring(0, 3) === 'ATH') {//中安泰华。华科润
        itemcodes = obj.substring(3, 16);
    } else if (obj.substring(0, 3) === 'BCL') {//春丽
        itemcodes = obj.substring(6, 19);
    } else if (obj.substring(0, 3) === 'RTK') {//贝尔泰克
        itemcodes = obj.substring(6, 23);
    } else {//常州鼎健
        itemcodes = obj.substring(3, 15);
    }
    return itemcodes;
}

//获取批号
function getbatchcode(obj) {
    var batchcodes = "";
    if (obj.substring(0, 3) === 'WZD') {
        var strs = obj.split("_");
        batchcodes = strs[2];
    } else if (obj.substring(0, 3) === 'YLT') {//威曼.威高
        batchcodes = obj.substring(29);
    } else if (obj.substring(0, 3) === 'ATH') {//中安泰华。华科润
        batchcodes = obj.substring(26);
    } else if (obj.substring(0, 3) === 'BCL') {//春丽
        batchcodes = obj.substring(37);
    } else if (obj.substring(0, 3) === 'RTK') {//贝尔泰克
        batchcodes = obj.substring(35);
    } else {//常州鼎健
        batchcodes = obj.substring(26);
    }
    return batchcodes;
}


//获取手动输入批号
function getbatchcodes(obj1, obj2) {
    var batchcodes = "";
    if (obj1.indexOf('YLT') != -1) {//威曼.威高
        batchcodes = obj2.substring(10);
    } else if (obj1.indexOf('ATH') != -1) {//中安泰华。华科润
        batchcodes = obj2.substring(10);
    } else if (obj1.indexOf('BCL') != -1) {//春丽
        batchcodes = obj2.substring(18);
    } else if (obj1.indexOf('RTK') != -1) {//贝尔泰克
        batchcodes = obj2.substring(12);
    } else {//常州鼎健
        batchcodes = obj2.substring(26);
    }
    return batchcodes;
}

//生产厂家
function getfactorys(obj) {
    var factorys_name = '';
    if (obj.indexOf('威曼') != -1 || obj.indexOf('威高') != -1) {
        factorys_name = 'YLT';
    } else if (obj.indexOf('中安泰华') != -1 || obj.indexOf('华科润') != -1) {
        factorys_name = 'ATH';
    } else if (obj.indexOf('春立') != -1) {
        factorys_name = 'BCL010';
    } else if (obj.indexOf('贝尔泰克') != -1) {
        factorys_name = 'RTK00';
    } else {//常州鼎健
        factorys_name = '';
    }
    return factorys_name;
}

//创建弹框内容(json数组，编码，批号,保存数据数组，生产日期效期，灭菌批号效期，灭菌有效期)采购收货
function creatdialog(obj1, obj2, obj3,obj4,productdatearr,sterilizecodearr,sterilizevalidatearr) {
    var msg = '';
    var warehouseinfo = '';
    for (var i = 0; i < obj1.length; i++) {
        if ((obj1[i].itemcode == obj2) || obj1[i].barcode == obj2) {
            if( obj1[i].warehouseinfo==null || obj1[i].warehouseinfo==""){
                warehouseinfo="未设置";
            }else{
                warehouseinfo=obj1[i].warehouseinfo;
            }
            msg = '<div class="mui-input-row">' +
                '<label style="font-size: 15px;">产品名称：</label>' +
                '<input style="font-size: 15px;" type="text" readonly="readonly" value="' + obj1[i].productname + '">' +
                '</div>' +
                '<div class="mui-input-row">' +
                '<label style="font-size: 15px;">产品编码：</label>' +
                ' <input style="font-size: 15px;" type="text" readonly="readonly" value="' + obj1[i].barcode + '">' +
                '</div>' +
                '<div class="mui-input-row">' +
                '<label style="font-size: 15px;">产品条码：</label>' +
                '<input style="font-size: 15px;" type="text" readonly="readonly" value="' + obj1[i].itemcode + '">' +
                '</div>' +
                '<div class="mui-input-row">' +
                '<label style="font-size: 15px;">规格：</label>' +
                '<input style="font-size: 15px;" type="text" readonly="readonly" value="' + obj1[i].guige + '">' +
                '</div>' +
                '<div class="mui-input-row">' +
                '<label style="font-size: 15px;">单位：</label>' +
                '<input style="font-size: 15px;" type="text" readonly="readonly" value="' + obj1[i].unit + '">' +
                '</div>' +
                '<div class="mui-input-row">' +
                '<label style="font-size: 15px;">注册证号：</label>' +
                '<input style="font-size: 15px;" type="text" readonly="readonly" value="' + obj1[i].registercode + '">' +
                '</div>' +
                '<div class="mui-input-row">' +
                '<label style="font-size: 15px;">生产企业：</label>' +
                '<input style="font-size: 15px;" type="text" readonly="readonly" value="' + obj1[i].factorys_name + '">' +
                '</div>' +
                '<div class="mui-input-row" style="height: auto;">' +
                '<label style="font-size: 15px;">仓库位置：</label>' +
                '<span style="float: left;">' +warehouseinfo +
                '</span>' +
                '</div>' +
                '<div class="mui-input-row">' +
                '<label style="font-size: 15px;">待收数量：</label>' +
                '<input style="font-size: 15px;" type="text" readonly="readonly" value="' + obj1[i].number + '">' +
                '<input style="font-size: 15px;" type="hidden" readonly="readonly" value="' + obj1[i].number + '">' +
                '</div>';
            var item = obj1[i].batch_info;
            for(var key in obj4){
                var sterilizevalidate="";
                var sterilizecode="";
                var productdate="";
                if(obj4[key]['itemcodes']==obj2){
                    var num=obj4[key]['number'];
                    var batch=obj4[key].batchcodes;
                    for (var key1 in item) {
                        if(item[key1].products_batch_no == obj4[key]['batchcodes']){
                             sterilizevalidate=item[key1]['sterilizevalidate'];
                             sterilizecode=item[key1]['sterilizecode'];
                             productdate=item[key1]['productdate'];
                        }
                    }
                    var result=obj4[key]['sanncodes'];
                    if (typeof(productdatearr.get(result)) != "undefined") {
                        productdate = productdatearr.get(result);
                    }
                    if (typeof(sterilizecodearr.get(result)) != "undefined") {
                        sterilizecode = sterilizecodearr.get(result);
                    }
                    if (typeof(sterilizevalidatearr.get(result)) != "undefined") {
                        sterilizevalidate = sterilizevalidatearr.get(result);
                    }

                    msg += '<div class="mui-input-row" style="height: 60px">' +
                        '<label style="font-size: 15px;">批号:</label>' +
                        '<textarea id="batch_no_' + obj2 + '_' + batch + '" rows="2" readonly="">' + batch + '</textarea>' +
                        '</div>' +
                        '<div class="mui-input-row" style="height: 60px">' +
                        '<label style="font-size: 15px;">生产日期:</label>' +
                        '<input id="productdate_' + obj2 + '_' + batch + '" type="text" value="' + productdate + '"/>' +
                        '</div>' +
                        '</div>' +
                        '<div class="mui-input-row" style="height: 60px">' +
                        '<label style="font-size: 15px;">灭菌批号:</label>' +
                        '<input id="sterilizecode_' + obj2 + '_' + batch + '" type="text" value="' + sterilizecode + '"/>' +
                        '</div>' +
                        '</div>' +
                        '<div class="mui-input-row" style="height: 60px">' +
                        '<label style="font-size: 15px;">灭菌有效期:</label>' +
                        '<input id="sterilizevalidate_' + obj2 + '_' + batch + '" type="text" value="' + sterilizevalidate + '"/>' +
                        '</div>' +
                        '<div class="mui-input-row">' +
                        '<label style="font-size: 15px;">产品数量：</label>' +
                        '<div class="mui-numbox" data-numbox-min="0" data-numbox-max="9999999999" style="width:170px">' +
                        '<button class="mui-btn mui-btn-numbox-minus" type="button">-</button>'+
                        '<input id="productnum_' + obj2 + '_' + batch + '" class="mui-input-numbox" type="number"  value="'+num+'"/>'+
                        '<button class="mui-btn mui-btn-numbox-plus" type="button">+</button>' +
                        '</div>' +
                        '</div>'+
                        '<input id="hidden_' + obj2 + '_' + batch  + '" class="mui-input-numbox" type="hidden" value="'+result+'"/>';
                }
            }
        }
    }
return msg;
}


//创建弹框内容(json数组，编码，批号,保存数据数组)销售出库
function creatdialog1(obj1, obj2, obj3,obj4) {
    var msg = '';
    var warehouseinfo = '';
    for (var i = 0; i < obj1.length; i++) {
        if ((obj1[i].itemcode == obj2) || obj1[i].barcode == obj2) {
            if( obj1[i].warehouseinfo==null || obj1[i].warehouseinfo==""){
                warehouseinfo="未设置";
            }else{
                warehouseinfo=obj1[i].warehouseinfo;
            }
            msg = '<div class="mui-input-row">' +
                '<label style="font-size: 15px;">产品名称：</label>' +
                '<input style="font-size: 15px;" type="text" readonly="readonly" value="' + obj1[i].productname + '">' +
                '</div>' +
                '<div class="mui-input-row">' +
                '<label style="font-size: 15px;">产品编码：</label>' +
                ' <input style="font-size: 15px;" type="text" readonly="readonly" value="' + obj1[i].barcode + '">' +
                '</div>' +
                '<div class="mui-input-row">' +
                '<label style="font-size: 15px;">产品条码：</label>' +
                '<input style="font-size: 15px;" type="text" readonly="readonly" value="' + obj1[i].itemcode + '">' +
                '</div>' +
                '<div class="mui-input-row">' +
                '<label style="font-size: 15px;">规格：</label>' +
                '<input style="font-size: 15px;" type="text" readonly="readonly" value="' + obj1[i].guige + '">' +
                '</div>' +
                '<div class="mui-input-row">' +
                '<label style="font-size: 15px;">单位：</label>' +
                '<input style="font-size: 15px;" type="text" readonly="readonly" value="' + obj1[i].unit + '">' +
                '</div>' +
                '<div class="mui-input-row">' +
                '<label style="font-size: 15px;">注册证号：</label>' +
                '<input style="font-size: 15px;" type="text" readonly="readonly" value="' + obj1[i].registercode + '">' +
                '</div>' +
                '<div class="mui-input-row">' +
                '<label style="font-size: 15px;">生产企业：</label>' +
                '<input style="font-size: 15px;" type="text" readonly="readonly" value="' + obj1[i].factorys_name + '">' +
                '</div>' +
                '<div class="mui-input-row" style="height: auto;">' +
                '<label style="font-size: 15px;">仓库位置：</label>' +
                '<span style="float: left;">' +warehouseinfo +
                '</span>' +
                '</div>' +
                '<div class="mui-input-row">' +
                '<label style="font-size: 15px;">待收数量：</label>' +
                '<input style="font-size: 15px;" type="text" readonly="readonly" value="' + obj1[i].number + '">' +
                '<input style="font-size: 15px;" type="hidden" readonly="readonly" value="' + obj1[i].number + '">' +
                '</div>';
            for(var key in obj4){
                if(obj4[key]['itemcodes']==obj2){
                    var num=obj4[key]['number'];
                    var batch=obj4[key].batchcodes;
                    msg += '<div class="mui-input-row" style="height: 60px">' +
                        '<label style="font-size: 15px;">批号:</label>' +
                        '<textarea id="batch_no_' + obj2 + '_' + batch + '" rows="2" readonly="">' + batch + '</textarea>' +
                        '</div>' +
                        '<div class="mui-input-row">' +
                        '<label style="font-size: 15px;">产品数量：</label>' +
                        '<div class="mui-numbox" data-numbox-min="0" data-numbox-max="9999999999" style="width:170px">' +
                        '<button class="mui-btn mui-btn-numbox-minus" type="button">-</button>'+
                        '<input id="productnum_' + obj2 + '_' + batch + '" class="mui-input-numbox" type="number"  value="'+num+'"/>'+
                        '<button class="mui-btn mui-btn-numbox-plus" type="button">+</button>' +
                        '</div>' +
                        '</div>'+
                        '<input id="hidden_' + obj2 + '_' + batch  + '" class="mui-input-numbox" type="hidden" value="'+obj4[key].sanncodes+'"/>';
                }
            }
        }
    }
    return msg;
}


//创建弹框内容(json数组，编码，批号,保存数据数组)采购验收
function creatdialog2(obj1, obj2, obj3,obj4) {
    var msg = '';
    var warehouseinfo = '';
    for (var i = 0; i < obj1.length; i++) {
        if ((obj1[i].itemcode == obj2) || obj1[i].barcode == obj2) {
            if( obj1[i].warehouseinfo==null || obj1[i].warehouseinfo==""){
                warehouseinfo="未设置";
            }else{
                warehouseinfo=obj1[i].warehouseinfo;
            }
            var itemcode=obj1[i].itemcode;
            var barcode=obj1[i].barcode;
            msg = '<div class="mui-input-row">' +
                '<label style="font-size: 15px;">产品名称：</label>' +
                '<input style="font-size: 15px;" type="text" readonly="readonly" value="' + obj1[i].productname + '">' +
                '</div>' +
                '<div class="mui-input-row">' +
                '<label style="font-size: 15px;">产品编码：</label>' +
                ' <input style="font-size: 15px;" type="text" readonly="readonly" value="' + obj1[i].barcode + '">' +
                '</div>' +
                '<div class="mui-input-row">' +
                '<label style="font-size: 15px;">产品条码：</label>' +
                '<input style="font-size: 15px;" type="text" readonly="readonly" value="' + obj1[i].itemcode + '">' +
                '</div>' +
                '<div class="mui-input-row">' +
                '<label style="font-size: 15px;">规格：</label>' +
                '<input style="font-size: 15px;" type="text" readonly="readonly" value="' + obj1[i].guige + '">' +
                '</div>' +
                '<div class="mui-input-row">' +
                '<label style="font-size: 15px;">单位：</label>' +
                '<input style="font-size: 15px;" type="text" readonly="readonly" value="' + obj1[i].unit + '">' +
                '</div>' +
                '<div class="mui-input-row">' +
                '<label style="font-size: 15px;">注册证号：</label>' +
                '<input style="font-size: 15px;" type="text" readonly="readonly" value="' + obj1[i].registercode + '">' +
                '</div>' +
                '<div class="mui-input-row">' +
                '<label style="font-size: 15px;">生产企业：</label>' +
                '<input style="font-size: 15px;" type="text" readonly="readonly" value="' + obj1[i].factorys_name + '">' +
                '</div>' +
                '<div class="mui-input-row" style="height: auto;">' +
                '<label style="font-size: 15px;">仓库位置：</label>' +
                '<span style="float: left;">' +warehouseinfo +
                '</span>' +
                '</div>' +
                '<div class="mui-input-row">' +
                '<label style="font-size: 15px;">待收数量：</label>' +
                '<input style="font-size: 15px;" type="text" readonly="readonly" value="' + obj1[i].number + '">' +
                '<input style="font-size: 15px;" type="hidden" readonly="readonly" value="' + obj1[i].number + '">' +
                '</div>';
           var batchinfo=obj1[i].batch_info;
            for(var key in batchinfo){
                var num=0;
                var hidnum=0;
                var sanncodes=0;
                var products_batch_no=batchinfo[key].products_batch_no;
                for(var item in obj4){
                    if(obj4[item]['itemcodes']==itemcode && obj4[item]['batchcodes']==products_batch_no ){
                        num=obj4[item]['number'];
                        sanncodes=obj4[item]['sanncodes'];
                    }
                }
               if(obj3=='1'){
                   var ing_instoragenumber=parseInt(batchinfo[key].ing_instoragenumber,10);
                   if( batchinfo[key].add_checknumber==null || batchinfo[key].add_checknumber==""){
                       var  add_checknumber=0;
                   }else{
                       var  add_checknumber=parseInt(batchinfo[key].add_checknumber,10);
                   }
                   num=ing_instoragenumber-add_checknumber-parseInt(num,10);
                   hidnum=ing_instoragenumber-add_checknumber;
                   if(ing_instoragenumber-add_checknumber!=0){
                        msg+=' <div class="mui-input-row" style="height: 60px">'+
                            '<label style="font-size: 15px;">批号：</label>';
                       if(obj1[i].suppliername=='医流通'){
                           if(obj1[i].factorys_name.indexOf('常州鼎健医疗器械有限公司')!=-1){
                               msg+= '<textarea id="batch_no_'+itemcode+'_'+products_batch_no+'" rows="2" readonly="">'+products_batch_no+'</textarea>'+
                                   '</div>'+
                                    '<div class="mui-input-row" style="height: 60px">'+
                                   '<label style="font-size: 15px;">生产日期：</label>'+
                                   '<input id="productdate_'+itemcode+'_'+products_batch_no+'" value="'+batchinfo[key].productdate+'" type="text" readonly=""/>'+
                                       '</div>'+
                                   '<div class="mui-input-row" style="height: 60px">'+
                                   '<label style="font-size: 15px;">灭菌批号：</label>'+
                                   '<input id="sterilizecode_'+itemcode+'_'+products_batch_no+'" value="'+batchinfo[key].sterilizecode+'" type="text" readonly=""/>'+
                                   '</div>'+
                                   '<div class="mui-input-row" style="height: 60px">'+
                                   '<label style="font-size: 15px;">灭菌有效期：</label>'+
                                   '<input id="sterilizevalidate_'+itemcode+'_'+products_batch_no+'" value="'+batchinfo[key].sterilizevalidate+'" type="text" readonly=""/>'+
                                   '</div>'+
                                   '<div class="mui-input-row" style="height: 60px">' +
                                   '<label style="font-size: 15px;">批号:</label>' +
                                   '<textarea id="batch_no_' + itemcode + '_' + products_batch_no + '" rows="2" readonly="">' + products_batch_no + '</textarea>' +
                                   '</div>' +
                                   '<div class="mui-input-row">' +
                                   '<label style="font-size: 15px;">产品数量：</label>' +
                                   '<div class="mui-numbox" data-numbox-min="0" data-numbox-max="9999999999" style="width:170px">' +
                                   '<button class="mui-btn mui-btn-numbox-minus" type="button">-</button>'+
                                   '<input id="productnum_' + itemcode + '_' + products_batch_no + '" class="mui-input-numbox" type="number"  value="'+num+'"/>'+
                                   '<button class="mui-btn mui-btn-numbox-plus" type="button">+</button>' +
                                   '</div>' +
                                   '</div>'+
                                   '<input id="hidden_productnum_' + itemcode + '_' + products_batch_no  + '" class="mui-input-numbox" type="hidden" value="'+hidnum+'"/>'+
                                    '<input id="hidden_' + itemcode + '_' + products_batch_no  + '" class="mui-input-numbox" type="hidden" value="'+sanncodes+'"/>';

                           }else{
                               msg+= '<textarea id="batch_no_'+barcode+'_'+products_batch_no+'" rows="2" readonly="">'+products_batch_no+'</textarea>'+
                                   '</div>'+
                                   '<div class="mui-input-row" style="height: 60px">'+
                                   '<label style="font-size: 15px;">生产日期：</label>'+
                                   '<input id="productdate_'+barcode+'_'+products_batch_no+'" value="'+batchinfo[key].productdate+'" type="text" readonly=""/>'+
                                   '</div>'+
                                   '<div class="mui-input-row" style="height: 60px">'+
                                   '<label style="font-size: 15px;">灭菌批号：</label>'+
                                   '<input id="sterilizecode_'+barcode+'_'+products_batch_no+'" value="'+batchinfo[key].sterilizecode+'" type="text" readonly=""/>'+
                                   '</div>'+
                                   '<div class="mui-input-row" style="height: 60px">'+
                                   '<label style="font-size: 15px;">灭菌有效期：</label>'+
                                   '<input id="sterilizevalidate_'+barcode+'_'+products_batch_no+'" value="'+batchinfo[key].sterilizevalidate+'" type="text" readonly=""/>'+
                                   '</div>'+
                                   '<div class="mui-input-row" style="height: 60px">' +
                                   '<label style="font-size: 15px;">批号:</label>' +
                                   '<textarea id="batch_no_' + barcode + '_' + products_batch_no + '" rows="2" readonly="">' + products_batch_no + '</textarea>' +
                                   '</div>' +
                                   '<div class="mui-input-row">' +
                                   '<label style="font-size: 15px;">产品数量：</label>' +
                                   '<div class="mui-numbox" data-numbox-min="0" data-numbox-max="9999999999" style="width:170px">' +
                                   '<button class="mui-btn mui-btn-numbox-minus" type="button">-</button>'+
                                   '<input id="productnum_' + barcode + '_' + products_batch_no + '" class="mui-input-numbox" type="number"  value="'+num+'"/>'+
                                   '<button class="mui-btn mui-btn-numbox-plus" type="button">+</button>' +
                                   '</div>' +
                                   '</div>'+
                                   '<input id="hidden_productnum_' + barcode + '_' + products_batch_no  + '" class="mui-input-numbox" type="hidden" value="'+hidnum+'"/>'+
                                   '<input id="hidden_' + itemcode + '_' + products_batch_no  + '" class="mui-input-numbox" type="hidden" value="'+sanncodes+'"/>';
                           }
                       }else{
                           msg+= '<textarea id="batch_no_'+itemcode+'_'+products_batch_no+'" rows="2" readonly="">'+products_batch_no+'</textarea>'+
                               '</div>'+
                               '<div class="mui-input-row" style="height: 60px">'+
                               '<label style="font-size: 15px;">生产日期：</label>'+
                               '<input id="productdate_'+itemcode+'_'+products_batch_no+'" value="'+batchinfo[key].productdate+'" type="text" readonly=""/>'+
                               '</div>'+
                               '<div class="mui-input-row" style="height: 60px">'+
                               '<label style="font-size: 15px;">灭菌批号：</label>'+
                               '<input id="sterilizecode_'+itemcode+'_'+products_batch_no+'" value="'+batchinfo[key].sterilizecode+'" type="text" readonly=""/>'+
                               '</div>'+
                               '<div class="mui-input-row" style="height: 60px">'+
                               '<label style="font-size: 15px;">灭菌有效期：</label>'+
                               '<input id="sterilizevalidate_'+itemcode+'_'+products_batch_no+'" value="'+batchinfo[key].sterilizevalidate+'" type="text" readonly=""/>'+
                               '</div>'+
                               '<div class="mui-input-row" style="height: 60px">' +
                               '<label style="font-size: 15px;">批号:</label>' +
                               '<textarea id="batch_no_' + itemcode + '_' + products_batch_no + '" rows="2" readonly="">' + products_batch_no + '</textarea>' +
                               '</div>' +
                               '<div class="mui-input-row">' +
                               '<label style="font-size: 15px;">产品数量：</label>' +
                               '<div class="mui-numbox" data-numbox-min="0" data-numbox-max="9999999999" style="width:170px">' +
                               '<button class="mui-btn mui-btn-numbox-minus" type="button">-</button>'+
                               '<input id="productnum_' + itemcode + '_' + products_batch_no + '" class="mui-input-numbox" type="number"  value="'+num+'"/>'+
                               '<button class="mui-btn mui-btn-numbox-plus" type="button">+</button>' +
                               '</div>' +
                               '</div>'+
                               '<input id="hidden_productnum_' + itemcode + '_' + products_batch_no  + '" class="mui-input-numbox" type="hidden" value="'+hidnum+'"/>'+
                               '<input id="hidden_' + itemcode + '_' + products_batch_no  + '" class="mui-input-numbox" type="hidden" value="'+sanncodes+'"/>';
                       }
                   }
               }else{
                   var instoragenumber=parseInt(batchinfo[key].instoragenumber,10);
                   if( batchinfo[key].checknumber==null || batchinfo[key].checknumber==""){
                       var  checknumber=0;
                   }else{
                       var  checknumber=parseInt(batchinfo[key].checknumber,10);
                   }
                   num=instoragenumber-checknumber-parseInt(num,10);
                   if(instoragenumber-checknumber!=0){
                       msg+=' <div class="mui-input-row" style="height: 60px">'+
                           '<label style="font-size: 15px;">批号：</label>';
                       if(obj1[i].suppliername=='医流通'){
                           if(obj1[i].factorys_name.indexOf('常州鼎健医疗器械有限公司')!=-1){
                               msg+= '<textarea id="batch_no_'+itemcode+'_'+products_batch_no+'" rows="2" readonly="">'+products_batch_no+'</textarea>'+
                                   '</div>'+
                                   '<div class="mui-input-row" style="height: 60px">'+
                                   '<label style="font-size: 15px;">生产日期：</label>'+
                                   '<input id="productdate_'+itemcode+'_'+products_batch_no+'" value="'+batchinfo[key].productdate+'" type="text" readonly=""/>'+
                                   '</div>'+
                                   '<div class="mui-input-row" style="height: 60px">'+
                                   '<label style="font-size: 15px;">灭菌批号：</label>'+
                                   '<input id="sterilizecode_'+itemcode+'_'+products_batch_no+'" value="'+batchinfo[key].sterilizecode+'" type="text" readonly=""/>'+
                                   '</div>'+
                                   '<div class="mui-input-row" style="height: 60px">'+
                                   '<label style="font-size: 15px;">灭菌有效期：</label>'+
                                   '<input id="sterilizevalidate_'+itemcode+'_'+products_batch_no+'" value="'+batchinfo[key].sterilizevalidate+'" type="text" readonly=""/>'+
                                   '</div>'+
                                   '<div class="mui-input-row" style="height: 60px">' +
                                   '<label style="font-size: 15px;">批号:</label>' +
                                   '<textarea id="batch_no_' + itemcode + '_' + products_batch_no + '" rows="2" readonly="">' + products_batch_no + '</textarea>' +
                                   '</div>' +
                                   '<div class="mui-input-row">' +
                                   '<label style="font-size: 15px;">产品数量：</label>' +
                                   '<div class="mui-numbox" data-numbox-min="0" data-numbox-max="9999999999" style="width:170px">' +
                                   '<button class="mui-btn mui-btn-numbox-minus" type="button">-</button>'+
                                   '<input id="productnum_' + itemcode + '_' + products_batch_no + '" class="mui-input-numbox" type="number"  value="'+num+'"/>'+
                                   '<button class="mui-btn mui-btn-numbox-plus" type="button">+</button>' +
                                   '</div>' +
                                   '</div>'+
                                   '<input id="hidden_productnum_' + itemcode + '_' + products_batch_no  + '" class="mui-input-numbox" type="hidden" value="'+hidnum+'"/>'+
                                   '<input id="hidden_' + itemcode + '_' + products_batch_no  + '" class="mui-input-numbox" type="hidden" value="'+sanncodes+'"/>';
                           }else{
                               msg+= '<textarea id="batch_no_'+barcode+'_'+products_batch_no+'" rows="2" readonly="">'+products_batch_no+'</textarea>'+
                                   '</div>'+
                                   '<div class="mui-input-row" style="height: 60px">'+
                                   '<label style="font-size: 15px;">生产日期：</label>'+
                                   '<input id="productdate_'+barcode+'_'+products_batch_no+'" value="'+batchinfo[key].productdate+'" type="text" readonly=""/>'+
                                   '</div>'+
                                   '<div class="mui-input-row" style="height: 60px">'+
                                   '<label style="font-size: 15px;">灭菌批号：</label>'+
                                   '<input id="sterilizecode_'+barcode+'_'+products_batch_no+'" value="'+batchinfo[key].sterilizecode+'" type="text" readonly=""/>'+
                                   '</div>'+
                                   '<div class="mui-input-row" style="height: 60px">'+
                                   '<label style="font-size: 15px;">灭菌有效期：</label>'+
                                   '<input id="sterilizevalidate_'+barcode+'_'+products_batch_no+'" value="'+batchinfo[key].sterilizevalidate+'" type="text" readonly=""/>'+
                                   '</div>'+
                                   '<div class="mui-input-row" style="height: 60px">' +
                                   '<label style="font-size: 15px;">批号:</label>' +
                                   '<textarea id="batch_no_' + barcode + '_' + products_batch_no + '" rows="2" readonly="">' + products_batch_no + '</textarea>' +
                                   '</div>' +
                                   '<div class="mui-input-row">' +
                                   '<label style="font-size: 15px;">产品数量：</label>' +
                                   '<div class="mui-numbox" data-numbox-min="0" data-numbox-max="9999999999" style="width:170px">' +
                                   '<button class="mui-btn mui-btn-numbox-minus" type="button">-</button>'+
                                   '<input id="productnum_' + barcode + '_' + products_batch_no + '" class="mui-input-numbox" type="number"  value="'+num+'"/>'+
                                   '<button class="mui-btn mui-btn-numbox-plus" type="button">+</button>' +
                                   '</div>' +
                                   '</div>'+
                                   '<input id="hidden_productnum_' + barcode + '_' + products_batch_no  + '" class="mui-input-numbox" type="hidden" value="'+hidnum+'"/>'+
                                   '<input id="hidden_' + itemcode + '_' + products_batch_no  + '" class="mui-input-numbox" type="hidden" value="'+sanncodes+'"/>';
                           }
                       }else{
                           msg+= '<textarea id="batch_no_'+itemcode+'_'+products_batch_no+'" rows="2" readonly="">'+products_batch_no+'</textarea>'+
                               '</div>'+
                               '<div class="mui-input-row" style="height: 60px">'+
                               '<label style="font-size: 15px;">生产日期：</label>'+
                               '<input id="productdate_'+itemcode+'_'+products_batch_no+'" value="'+batchinfo[key].productdate+'" type="text" readonly=""/>'+
                               '</div>'+
                               '<div class="mui-input-row" style="height: 60px">'+
                               '<label style="font-size: 15px;">灭菌批号：</label>'+
                               '<input id="sterilizecode_'+itemcode+'_'+products_batch_no+'" value="'+batchinfo[key].sterilizecode+'" type="text" readonly=""/>'+
                               '</div>'+
                               '<div class="mui-input-row" style="height: 60px">'+
                               '<label style="font-size: 15px;">灭菌有效期：</label>'+
                               '<input id="sterilizevalidate_'+itemcode+'_'+products_batch_no+'" value="'+batchinfo[key].sterilizevalidate+'" type="text" readonly=""/>'+
                               '</div>'+
                               '<div class="mui-input-row" style="height: 60px">' +
                               '<label style="font-size: 15px;">批号:</label>' +
                               '<textarea id="batch_no_' + itemcode + '_' + products_batch_no + '" rows="2" readonly="">' + products_batch_no + '</textarea>' +
                               '</div>' +
                               '<div class="mui-input-row">' +
                               '<label style="font-size: 15px;">产品数量：</label>' +
                               '<div class="mui-numbox" data-numbox-min="0" data-numbox-max="9999999999" style="width:170px">' +
                               '<button class="mui-btn mui-btn-numbox-minus" type="button">-</button>'+
                               '<input id="productnum_' + itemcode + '_' + products_batch_no + '" class="mui-input-numbox" type="number"  value="'+num+'"/>'+
                               '<button class="mui-btn mui-btn-numbox-plus" type="button">+</button>' +
                               '</div>' +
                               '</div>'+
                               '<input id="hidden_productnum_' + itemcode + '_' + products_batch_no  + '" class="mui-input-numbox" type="hidden" value="'+hidnum+'"/>'+
                               '<input id="hidden_' + itemcode + '_' + products_batch_no  + '" class="mui-input-numbox" type="hidden" value="'+sanncodes+'"/>';
                       }
                   }
               }
            }
        }
    }
    return msg;
}