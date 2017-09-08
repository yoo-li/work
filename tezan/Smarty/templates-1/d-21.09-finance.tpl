<link href="/Public/BJUI/themes/css/bootstrap.css" rel="stylesheet">
<!-- core - css -->
<link href="/Public/BJUI/themes/css/style.css" rel="stylesheet">
<link href="/Public/BJUI/themes/blue/core.css" id="bjui-link-theme" rel="stylesheet">
<link href="/Public/BJUI/themes/css/FA/css/font-awesome.min.css" rel="stylesheet">
<link href="/Public/BJUI/plugins/niceValidator/jquery.validator.css" rel="stylesheet">
<link href="/Public/BJUI/plugins/bootstrapSelect/bootstrap-select.css" rel="stylesheet">
<link href="/Public/BJUI/plugins/colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet">
<link href="/Public/css/global.css" rel="stylesheet" type="text/css" media="all" >
<link href="/Public/css/icon.css" rel="stylesheet" type="text/css" media="all" >
<link href="/Public/css/lightbox.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="/Public/css/tip-yellow.css" type="text/css" />
<script src="/Public/js/jquery-1.11.3.min.js"></script>
<script src="/Public/js/lightbox.min.js" type="text/javascript"></script>
<script src="/Public/js/plupload.full.min.js" type=text/javascript></script>
<script src="/Public/js/plupload.zh_CN.js" type=text/javascript></script>
<script src="/Public/js/plupload.js" type=text/javascript></script>
<script type="text/javascript" src="/Public/js/jquery.poshytip.js"></script>
<script src="/Public/js/jquery-1.11.3.min.js"></script>
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
        {*请输入表名：<input name="" value=""></input> *}
        <c>财务报表</c>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        {*请输入查询时间 :  <input type="text" name = "starttime" value=""> - <input type="text" name="endtime">*}
        <input type="submit" name="" value="导出" onclick=" return btn1( )">   </input><br>
        <input type="hidden" name="starttime" value="" id="start1" >  </input>
        <input type="hidden" name="endtime" value="" id="end1">  </input>
    </form>
    <form action="index.php?module=Mall_Finance&action=Refund_getexcel " method="post">
        {*请输入表名：<input name="" value=""> </input>*}
        <c>已退款明细表</c>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        {*请输入查询时间 :  <input type="text" name = "starttime" value=""> - <input type="text" name="endtime">*}
        <input type="submit" name="" value="导出" onclick="return btn1( )">   </input><br>
        <input type="hidden" name="starttime" value="" id="start1" >  </input>
        <input type="hidden" name="endtime" value="" id="end1">  </input>

    </form>
    <form action="index.php?module=Mall_Finance&action=Np_getexcel " method="post">
        {*请输入表名：<input name="" value=""> </input>*}
        <c>已付款未发货 合计</c>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        {*请输入查询时间 :  <input type="text" name = "starttime" value=""> - <input type="text" name="endtime">*}
        <input type="submit" name="" value="导出" onclick="return btn1( )">   </input><br>
        <input type="hidden" name="starttime" value="" id="start1" >  </input>
        <input type="hidden" name="endtime" value="" id="end1">  </input>
    </form>
    <form action="index.php?module=Mall_Finance&action=Getmoney_getexcel " method="post">
        {*请输入表名：<input name="" value=""> </input>*}
        <c>收款表合计表</c>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        {*请输入查询时间 :  <input type="text" name = "starttime" value=""> - <input type="text" name="endtime">*}
        <input type="submit" name="" value="导出" onclick="return btn1( )">   </input><br>
        <input type="hidden" name="starttime" value="" id="start1" >  </input>
        <input type="hidden" name="endtime" value="" id="end1">  </input>
    </form>
    <form action="index.php?module=Mall_Finance&action=Npdetail_getexcel " onclick="btn1( )" method="post">
        {*请输入表名：<input name="" value=""> </input>*}
        <c>已付款未发货明细表</c>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        {*请输入查询时间 :  <input type="text" name = "starttime" value=""> - <input type="text" name="endtime">*}
        <input type="submit" name="" value="导出" onclick="return btn1()">   </input><br>
        <input type="hidden" name="starttime" value="" id="start1" >  </input>
        <input type="hidden" name="endtime" value="" id="end1">  </input>
    </form>
    <form action="index.php?module=Mall_Finance&action=Spdetail_getexcel " method="post">
        {*请输入表名：<input name="" value=""> </input>*}
        <c>供应商结算明细</c>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        {*请输入查询时间 :  <input type="text" name = "starttime" value=""> - <input type="text" name="endtime">*}
        <input type="submit" name="" value="导出" onclick="return  btn1( )">   </input><br>
        <input type="hidden" name="starttime" value="" id="start1" >  </input>
        <input type="hidden" name="endtime" value="" id="end1">  </input>
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

        var start=$("input[name= starttime]").val();
        var end =$("input[name= endtime]").val();
        $("#start1").val(start) ;
        $("#end1").val(end) ;
        if(start == ''|| end == ''){
            alert('请选择日期');
            return false;
        }


    }

    {/literal}
</script>