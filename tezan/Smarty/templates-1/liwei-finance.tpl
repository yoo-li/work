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
        <span style="display:inline-block;width:150px;">收款表明细表</span>
        {*请输入查询时间 :  <input type="text" name = "starttime" value=""> - <input type="text" name="endtime">*}
        <input class="btn btn-default" data-icon="file-excel-o" type="submit" name="" value="导出EXCEL" onclick=" return btn1( )">   </input><br>
        <input type="hidden" name="starttime" class="start1"  value=""   >  </input>
        <input type="hidden" name="endtime" class="end1" value="" >  </input>
        </div>
    </form>
    <form action="index.php?module=Mall_Finance&action=Refund_getexcel " method="post">
        <div style="padding: 2px 0px;">
        {*请输入表名：<input name="" value=""> </input>*}
        <span style="display:inline-block;width:150px;">已退款明细表</span>
        {*请输入查询时间 :  <input type="text" name = "starttime" value=""> - <input type="text" name="endtime">*}
        <input class="btn btn-default" data-icon="file-excel-o" type="submit" name="" value="导出EXCEL" onclick="return btn1( )">   </input><br>
        <input type="hidden" name="starttime" class="start1" value="" id="start1" >  </input>
        <input type="hidden" name="endtime"  class="end1"  value="" id="end1">  </input>
        </div>
    </form>
    <form action="index.php?module=Mall_Finance&action=Np_getexcel " method="post">
        <div style="padding: 2px 0px;">
        {*请输入表名：<input name="" value=""> </input>*}
        <span style="display:inline-block;width:150px;">已付款未发货合计表</span>
        {*请输入查询时间 :  <input type="text" name = "starttime" value=""> - <input type="text" name="endtime">*}
        <input class="btn btn-default" data-icon="file-excel-o" type="submit" name="" value="导出EXCEL" onclick="return btn1( )">   </input><br>
        <input type="hidden" name="starttime" class="start1" value="" id="start1" >  </input>
        <input type="hidden" name="endtime" value=""  class="end1" id="end1">  </input>
        </div>
    </form>
    <form action="index.php?module=Mall_Finance&action=Getmoney_getexcel " method="post">
        <div style="padding: 2px 0px;">
        {*请输入表名：<input name="" value=""> </input>*}
        <span style="display:inline-block;width:150px;">收款表合计表</span>
        {*请输入查询时间 :  <input type="text" name = "starttime" value=""> - <input type="text" name="endtime">*}
        <input class="btn btn-default" data-icon="file-excel-o" type="submit" name="" value="导出EXCEL" onclick="return btn1( )">   </input><br>
        <input type="hidden" name="starttime" value="" class="start1" >  </input>
        <input type="hidden" name="endtime" value="" class="end1">  </input>
        </div>
    </form>
    <form action="index.php?module=Mall_Finance&action=Npdetail_getexcel " onclick="btn1( )" method="post">
        <div style="padding: 2px 0px;">
        {*请输入表名：<input name="" value=""> </input>*}
        <span style="display:inline-block;width:150px;">已付款未发货明细表</span>
        {*请输入查询时间 :  <input type="text" name = "starttime" value=""> - <input type="text" name="endtime">*}
        <input class="btn btn-default" data-icon="file-excel-o" type="submit" name="" value="导出EXCEL" onclick="return btn1()">   </input><br>
        <input type="hidden" name="starttime" value="" class="start1" >  </input>
        <input type="hidden" name="endtime" value="" class="end1">  </input>
        </div>
    </form>
    <form action="index.php?module=Mall_Finance&action=Spdetail_getexcel " method="post">
        <div style="padding: 2px 0px;">
        {*请输入表名：<input name="" value=""> </input>*}
        <span style="display:inline-block;width:150px;">供应商结算明细表</span>
        {*请输入查询时间 :  <input type="text" name = "starttime" value=""> - <input type="text" name="endtime">*}
        <input class="btn btn-default" data-icon="file-excel-o" type="submit" name="" value="导出EXCEL" onclick="return  btn1( )">   </input><br>
        <input type="hidden" name="starttime" value="" class="start1" >  </input>
        <input type="hidden" name="endtime" value="" class="end1">  </input>
        </div>
    </form>
    <form action="index.php?module=Mall_Finance&action=Reimburses_excel_data" method="post">
        <div style="padding: 2px 0px;">
            {*请输入表名：<input name="" value=""> </input>*}
            <span style="display:inline-block;width:150px;">已退款合计表
            </span>
            {*请输入查询时间 :  <input type="text" name = "starttime" value=""> - <input type="text" name="endtime">*}
            <input class="btn btn-default" data-icon="file-excel-o" type="submit" name="" value="导出EXCEL" onclick="return  btn1( )">   </input><br>
            <input type="hidden" name="starttime" value="" class="start1" >  </input>
            <input type="hidden" name="endtime" value="" class="end1">  </input>
        </div>
    </form>
    <form action="index.php?module=Mall_Finance&action=Unreceipt_excel" method="post">
        <div style="padding: 2px 0px;">
            {*请输入表名：<input name="" value=""> </input>*}
            <span style="display:inline-block;width:150px;">已发货未收货
            </span>
            {*请输入查询时间 :  <input type="text" name = "starttime" value=""> - <input type="text" name="endtime">*}
            <input class="btn btn-default" data-icon="file-excel-o" type="submit" name="" value="导出EXCEL" onclick="return  btn1( )">   </input><br>
            <input type="hidden" name="starttime" value="" class="start1" >  </input>
            <input type="hidden" name="endtime" value="" class="end1">  </input>
        </div>
    </form>
    <form action="index.php?module=Mall_Finance&action=Post_unreceipt" method="post">
        <div style="padding: 2px 0px;">
            {*请输入表名：<input name="" value=""> </input>*}
            <span style="display:inline-block;width:150px;">已发货未收货明细
            </span>
            {*请输入查询时间 :  <input type="text" name = "starttime" value=""> - <input type="text" name="endtime">*}
            <input class="btn btn-default" data-icon="file-excel-o" type="submit" name="" value="导出EXCEL" onclick="return  btn1( )">   </input><br>
            <input type="hidden" name="starttime" value="" class="start1" >  </input>
            <input type="hidden" name="endtime" value="" class="end1">  </input>
        </div>
    </form>
    <form action="index.php?module=Mall_Finance&action=Post_unreceipt_total" method="post">
        <div style="padding: 2px 0px;">
            {*请输入表名：<input name="" value=""> </input>*}
            <span style="display:inline-block;width:150px;">已发货未收货合计表
            </span>
            {*请输入查询时间 :  <input type="text" name = "starttime" value=""> - <input type="text" name="endtime">*}
            <input class="btn btn-default" data-icon="file-excel-o" type="submit" name="" value="导出EXCEL" onclick="return  btn1( )">   </input><br>
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
    {/literal}
</script>