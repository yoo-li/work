{*<script src="/Public/js/jquery-1.11.3.min.js"></script>*}
<div class="bjui-pageHeader">
    <form action="index.php?module=Mall_Finance&action=Finance_getexcel " method="post">
        请输入查询时间(查询时间不能跨月) :
    <span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;">
        <input type="text" name = "starttime" id="finance_startdate" value="" readonly="" data-toggle="datepicker" size="11" class="form-control n-valid" ;" style="padding-right: 15px; width: 110px;">
        <a class="bjui-lookup" href="javascript:;" id = "aa" ; data-toggle="datepickerbtn" style="height: 22.6667px; line-height: 22.6667px; ; ">
            <i class="fa fa-calendar"></i>
        </a>
    </span>

    <span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;">
        <input type="text" name = "endtime" id="finance_enddate" value="" readonly="" data-toggle="datepicker"  data-date-end-date="0d" size="11" class="form-control n-valid" style="padding-right: 15px; width: 110px;">
        <a class="bjui-lookup" href="javascript:;" data-toggle="datepickerbtn"  data-date-end-date="0d" style="height: 22.6667px; line-height: 22.6667px;">
            <i class="fa fa-calendar"></i>
        </a>
    </span>
        <b>请选择日期</b>
    </form>
</div>
<div class="bjui-pageContent">


    <form action="index.php?module=Mall_Finance&action=Finance_getexcel " method="post">
        <div style="padding: 2px 0px;">
        {*请输入表名：<input name="" value=""></input> *}
        <span style="display:inline-block;width:150px;">01.收款表明细表</span>
        {*请输入查询时间 :  <input type="text" name = "starttime" value=""> - <input type="text" name="endtime">*}
        <input class="btn btn-default" data-icon="file-excel-o" type="submit" name="" value="导出EXCEL" onclick=" return btn1( )">   </input>&nbsp;&nbsp;
        <a href="index.php?module=Mall_Finance&action=Finance_getexcel" target="_blank" class="btn btn-default" onclick=" return btn2(this)" >打印</a><br>
        <input type="hidden" name="starttime" class="start1"  value=""   >  </input>
        <input type="hidden" name="endtime" class="end1" value="" >  </input>
        </div>
    </form>
    <form action="index.php?module=Mall_Finance&action=Getmoney_getexcel " method="post">
        <div style="padding: 2px 0px;">
            {*请输入表名：<input name="" value=""> </input>*}
            <span style="display:inline-block;width:150px;">02.收款表合计表</span>
            {*请输入查询时间 :  <input type="text" name = "starttime" value=""> - <input type="text" name="endtime">*}
            <input class="btn btn-default" data-icon="file-excel-o" type="submit" name="" value="导出EXCEL" onclick="return btn1( )">   </input>&nbsp;&nbsp;
            <a href="index.php?module=Mall_Finance&action=Getmoney_getexcel" target="_blank" class="btn btn-default" onclick=" return btn2(this)">打印</a><br>
            <input type="hidden" name="starttime" value="" class="start1" >  </input>
            <input type="hidden" name="endtime" value="" class="end1">  </input>
        </div>
    </form>

    <form action="index.php?module=Mall_Finance&action=Npdetail_getexcel " onclick="btn1( )" method="post">
        <div style="padding: 2px 0px;">
            {*请输入表名：<input name="" value=""> </input>*}
            <span style="display:inline-block;width:150px;">03.已付款未发货明细表</span>
            {*请输入查询时间 :  <input type="text" name = "starttime" value=""> - <input type="text" name="endtime">*}
            <input class="btn btn-default" data-icon="file-excel-o" type="submit" name="" value="导出EXCEL" onclick="return btn1()">   </input>&nbsp;&nbsp;
            <a href="index.php?module=Mall_Finance&action=Npdetail_getexcel" target="_blank"  class="btn btn-default" onclick=" return btn2(this)">打印</a><br>
            <input type="hidden" name="starttime" value="" class="start1" >  </input>
            <input type="hidden" name="endtime" value="" class="end1">  </input>
        </div>
    </form>
    <form action="index.php?module=Mall_Finance&action=Np_getexcel " method="post">
        <div style="padding: 2px 0px;">
        {*请输入表名：<input name="" value=""> </input>*}
        <span style="display:inline-block;width:150px;">04.已付款未发货合计表</span>
        {*请输入查询时间 :  <input type="text" name = "starttime" value=""> - <input type="text" name="endtime">*}
        <input class="btn btn-default" data-icon="file-excel-o" type="submit" name="" value="导出EXCEL" onclick="return btn1( )">   </input>&nbsp;&nbsp;
        <a  href="index.php?module=Mall_Finance&action=Np_getexcel" target="_blank"  class="btn btn-default" onclick=" return btn2(this)">打印</a><br>
        <input type="hidden" name="starttime" class="start1" value="" id="start1" >  </input>
        <input type="hidden" name="endtime" value=""  class="end1" id="end1">  </input>
        </div>
    </form>
    <form action="index.php?module=Mall_Finance&action=Post_unreceipt " method="post">
        <div style="padding: 2px 0px;">
            {*请输入表名：<input name="" value=""> </input>*}
            <span style="display:inline-block;width:150px;">05.已发货未收货明细表</span>
            {*请输入查询时间 :  <input type="text" name = "starttime" value=""> - <input type="text" name="endtime">*}
            <input class="btn btn-default" data-icon="file-excel-o" type="submit" name="" value="导出EXCEL" onclick="return  btn1( )">   </input>&nbsp;&nbsp;
            <a  href="index.php?module=Mall_Finance&action=Post_unreceipt" target="_blank" class="btn btn-default" onclick=" return btn2(this )">打印</a><br>
            <input type="hidden" name="starttime" value="" class="start1" >  </input>
            <input type="hidden" name="endtime" value="" class="end1">  </input>
        </div>
    </form>
    <!--已发货未收货合计表-->
    <form action="index.php?module=Mall_Finance&action=Post_unreceipt_total" method="post">
        <div style="padding: 2px 0px;">
            {*请输入表名：<input name="" value=""> </input>*}
            <span style="display:inline-block;width:150px;">06.已发货未收货合计表
            </span>
            {*请输入查询时间 :  <input type="text" name = "starttime" value=""> - <input type="text" name="endtime">*}
            <input class="btn btn-default" data-icon="file-excel-o" type="submit" name="" value="导出EXCEL" onclick="return  btn1( )">   </input>&nbsp;&nbsp;
            <a h href="index.php?module=Mall_Finance&action=Post_unreceipt_total" target="_blank" class="btn btn-default" onclick=" return btn2(this)">打印</a><br>
            <input type="hidden" name="starttime" value="" class="start1" >  </input>
            <input type="hidden" name="endtime" value="" class="end1">  </input>
        </div>
    </form>

    <form action="index.php?module=Mall_Finance&action=Reimburses_list_excel " method="post">
        <div style="padding: 2px 0px;">
            {*请输入表名：<input name="" value=""> </input>*}
            <span style="display:inline-block;width:150px;">07.已退货未退款明细表</span>
            {*请输入查询时间 :  <input type="text" name = "starttime" value=""> - <input type="text" name="endtime">*}
            <input class="btn btn-default" data-icon="file-excel-o" type="submit" name="" value="导出EXCEL" onclick="return  btn1( )">   </input>&nbsp;&nbsp;
            <a  href="index.php?module=Mall_Finance&action=Reimburses_list_excel" target="_blank" class="btn btn-default" onclick=" return btn2(this)">打印</a><br>
            <input type="hidden" name="starttime" value="" class="start1" >  </input>
            <input type="hidden" name="endtime" value="" class="end1">  </input>
        </div>
    </form>

    <form action="index.php?module=Mall_Finance&action=Reimburses_excel " method="post">
        <div style="padding: 2px 0px;">
            {*请输入表名：<input name="" value=""> </input>*}
            <span style="display:inline-block;width:150px;">08.已退货未退款合计表</span>
            {*请输入查询时间 :  <input type="text" name = "starttime" value=""> - <input type="text" name="endtime">*}
            <input class="btn btn-default" data-icon="file-excel-o" type="submit" name="" value="导出EXCEL" onclick="return  btn1( )">   </input>&nbsp;&nbsp;
            <a  href="index.php?module=Mall_Finance&action=Reimburses_excel" target="_blank" class="btn btn-default" onclick=" return btn2(this)">打印</a><br>
            <input type="hidden" name="starttime" value="" class="start1" >  </input>
            <input type="hidden" name="endtime" value="" class="end1">  </input>
        </div>
    </form>
    <form action="index.php?module=Mall_Finance&action=Refund_getexcel " method="post">
        <div style="padding: 2px 0px;">
            {*请输入表名：<input name="" value=""> </input>*}
            <span style="display:inline-block;width:150px;">09.已退款明细表</span>
            {*请输入查询时间 :  <input type="text" name = "starttime" value=""> - <input type="text" name="endtime">*}
            <input class="btn btn-default" data-icon="file-excel-o" type="submit" name="" value="导出EXCEL" onclick="return btn1( )">   </input>&nbsp;&nbsp;
            <a  href="index.php?module=Mall_Finance&action=Refund_getexcel" target="_blank" class="btn btn-default" onclick=" return btn2(this)">打印</a><br>
            <input type="hidden" name="starttime" class="start1" value="" id="start1" >  </input>
            <input type="hidden" name="endtime"  class="end1"  value="" id="end1">  </input>
        </div>
    </form>
    <form action="index.php?module=Mall_Finance&action=Reimburses_excel_data " method="post">
        <div style="padding: 2px 0px;">
            {*请输入表名：<input name="" value=""> </input>*}
            <span style="display:inline-block;width:150px;">10.已退款合计表</span>
            {*请输入查询时间 :  <input type="text" name = "starttime" value=""> - <input type="text" name="endtime">*}
            <input class="btn btn-default" data-icon="file-excel-o" type="submit" name="" value="导出EXCEL" onclick="return  btn1( )">   </input>&nbsp;&nbsp;
            <a  href="index.php?module=Mall_Finance&action=Reimburses_excel_data" target="_blank" class="btn btn-default" onclick=" return btn2(this)">打印</a><br>
            <input type="hidden" name="starttime" value="" class="start1" >  </input>
            <input type="hidden" name="endtime" value="" class="end1">  </input>
        </div>
    </form>
    <form action="index.php?module=Mall_Finance&action=Spdetail_getexcel " method="post">
        <div style="padding: 2px 0px;">
            {*请输入表名：<input name="" value=""> </input>*}
            <span style="display:inline-block;width:150px;">11.供应商结算明细表</span>
            {*请输入查询时间 :  <input type="text" name = "starttime" value=""> - <input type="text" name="endtime">*}
            <input class="btn btn-default" data-icon="file-excel-o" type="submit" name="" value="导出EXCEL" onclick="return  btn1( )">   </input>&nbsp;&nbsp;
            <a  href="index.php?module=Mall_Finance&action=Spdetail_getexcel" target="_blank" class="btn btn-default" onclick=" return btn2(this )">打印</a><br>
            <input type="hidden" name="starttime" value="" class="start1" >  </input>
            <input type="hidden" name="endtime" value="" class="end1">  </input>
        </div>
    </form>
    <form action="index.php?module=Mall_Finance&action=Supplier_data_excel " method="post">
        <div style="padding: 2px 0px;">
            {*请输入表名：<input name="" value=""> </input>*}
            <span style="display:inline-block;width:150px;">12.供应商结算合计表</span>
            {*请输入查询时间 :  <input type="text" name = "starttime" value=""> - <input type="text" name="endtime">*}
            <input class="btn btn-default" data-icon="file-excel-o" type="submit" name="" value="导出EXCEL" onclick="return  btn1( )">   </input>&nbsp;&nbsp;
            <a  href="index.php?module=Mall_Finance&action=Supplier_data_excel" target="_blank" class="btn btn-default" onclick=" return btn2(this )">打印</a><br>
            <input type="hidden" name="starttime" value="" class="start1" >  </input>
            <input type="hidden" name="endtime" value="" class="end1">  </input>
        </div>
    </form>
    <form action="index.php?module=Mall_Finance&action=sck_total_excel " method="post">
        <div style="padding: 2px 0px;">
            <span style="display:inline-block;width:150px;">13.商城卡结算合计表</span>
            <input class="btn btn-default" data-icon="file-excel-o" type="submit" name="" value="导出EXCEL" onclick="return  btn1( )">   </input>&nbsp;&nbsp;
            <a  href="index.php?module=Mall_Finance&action=sck_total_excel" target="_blank" class="btn btn-default" onclick=" return btn2(this )">打印</a><br>
            <input type="hidden" name="starttime" value="" class="start1" >  </input>
            <input type="hidden" name="endtime" value="" class="end1">  </input>
        </div>
    </form>
    <form action="index.php?module=Mall_Finance&action=Otdetail_getexcel" method="post">
        <div style="padding: 2px 0px;">
            <span style="display:inline-block;width:150px;">14.其他供应商财务明细表</span>
            <input class="btn btn-default" data-icon="file-excel-o" type="submit" name="" value="导出EXCEL" onclick="return  btn1( )">   </input>&nbsp;&nbsp;
            <a  href="index.php?module=Mall_Finance&action=Otdetail_getexcel" target="_blank" class="btn btn-default" onclick=" return btn2(this )">打印</a><br>
            <input type="hidden" name="starttime" value="" class="start1" >  </input>
            <input type="hidden" name="endtime" value="" class="end1">  </input>
        </div>
    </form>
    <form action="index.php?module=Mall_Finance&action=Otcount_getexcel " method="post">
        <div style="padding: 2px 0px;">
            <span style="display:inline-block;width:150px;">15.其他供应商财务合计表</span>
            <input class="btn btn-default" data-icon="file-excel-o" type="submit" name="" value="导出EXCEL" onclick="return  btn1( )">   </input>&nbsp;&nbsp;
            <a  href="index.php?module=Mall_Finance&action=Otcount_getexcel" target="_blank" class="btn btn-default" onclick=" return btn2(this )">打印</a><br>
            <input type="hidden" name="starttime" value="" class="start1" >  </input>
            <input type="hidden" name="endtime" value="" class="end1">  </input>
        </div>
    </form>
    <form action="index.php?module=Mall_Finance&action=april_special " method="post">
        <div style="padding: 2px 0px;">
            <span style="display:inline-block;width:150px;">16.供应商结算明细表(四月份)</span>
            <input class="btn btn-default" data-icon="file-excel-o" type="submit" name="" value="导出EXCEL" onclick="return  btn1( )">   </input>&nbsp;&nbsp;
            <a  href="index.php?module=Mall_Finance&action=april_special" target="_blank" class="btn btn-default" onclick=" return btn2(this )">打印</a><br>
            <input type="hidden" name="starttime" value="" class="start1" >  </input>
            <input type="hidden" name="endtime" value="" class="end1">  </input>
        </div>
    </form>
    {*<form action="index.php?module=Mall_Finance&action=Sptotal_getexcel " method="post">*}

    {*<c>供应商结算合计</c>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;*}
    {*请输入查询时间 :  <input type="text" name = "starttime" value=""> - <input type="text" name="endtime">*}
    {*<input type="submit" name="" value="导出" onclick="btn1( )">   </input><br>*}
    {*<input type="hidden" name="starttime" value="" id="start1" >  </input>*}
    {*<input type="hidden" name="endtime" value="" id="end1">  </input>*}
    {*</form>*}


</div>

<script>
    {literal}

    function btn1(){
//        alert(111111);
        var start= jQuery("input[name= starttime]").val();
        var end =jQuery("input[name= endtime]").val();
        console.log(start);
        console.log(end);
        jQuery(".start1").val(start) ;
        jQuery(".end1").val(end) ;
        if(start == ''|| end == ''){
            alert('请选择日期');
            return false;
        }
    }
    function btn2(btn){
        var start= jQuery("input[name= starttime]").val();
        var end =jQuery("input[name= endtime]").val();
        //alert(start);
        //alert(end);
        var href=jQuery(btn).attr('href');
        //alert(href);
        jQuery(btn).attr("href",href+"&starttime="+start+"&endtime="+end+"&preview="+'1');
        var href=jQuery(btn).attr('href');
        //alert(href);
    }
    {/literal}
</script>
<script>
    {literal}
    $(document).ready(function(){
        jQuery('#finance_startdate').on('afterchange.bjui.datepicker', function(e, data) {
            var pattern = 'yyyy-MM-dd';
            var start  = data.value;
            var endmin=new Date(start.getTime());
            var endmax=new Date(start.getTime());
            endmax.setMonth(start.getMonth() + 1);
            endmax.setDate(start.getDate() - start.getDate());
            jQuery('#finance_enddate').val(endmax.formatDate(pattern));
        });
        jQuery('#finance_enddate').on('afterchange.bjui.datepicker', function(e, data) {
            var pattern = 'yyyy-MM-dd';
            var end  = data.value;
            var startmax=new Date(end.getTime());
            var startmin=new Date(end.getTime());
            startmin.setDate(1);
            jQuery('#finance_enddate').val(startmin.formatDate(pattern));
        });
    })



    //$('#finance_enddate').datepicker({pattern:'dd/MM/yyyy', minDate:'2017-6-01'});

    {/literal}
</script>