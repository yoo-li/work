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

		.mui-input-row label{
			line-height:21px;
			height:21px;
		}

		.menuicon{ font-size:1.2em; color:#fe4401; padding-right:10px; }

		.menuitem a{ font-size:1.1em; }

		#save_button{
			font-size:20px;
			color:#cc3300;
			padding-left:5px;
		}

		.mui-bar-tab .mui-tab-item .mui-icon{
			width:auto;
		}

		.mui-bar-tab .mui-tab-item, .mui-bar-tab .mui-tab-item.mui-active{
			color:#cc3300;
		}

		.mui-input-row label{
			text-align:right;
			width:30%;
		}

		.mui-input-row label ~ input, .mui-input-row label ~ select, .mui-input-row label ~ textarea{
			float:right;
			width:70%;
		}

		.mui-input-row label{
			line-height:21px;
			padding:10px 10px;
		}

		.mui-input-clear{
			font-size:12px;
		}

		input.parsley-success,
		select.parsley-success,
		textarea.parsley-success{
			color:#468847;
			background-color:#DFF0D8;
			border:1px solid #D6E9C6;
		}

		input.parsley-error,
		select.parsley-error,
		textarea.parsley-error{
			color:#B94A48;
			background-color:#F2DEDE;
			border:1px solid #EED3D7;
		}

		.parsley-errors-list{
			margin:2px 0 3px;
			padding:0;
			list-style-type:none;
			font-size:0.9em;
			line-height:0.9em;
			opacity:0;
			transition:all .3s ease-in;
			-o-transition:all .3s ease-in;
			-moz-transition:all .3s ease-in;
			-webkit-transition:all .3s ease-in;
		}

		.parsley-errors-list.filled{
			opacity:1;
		}

		.mui-table-view input[type='radio']{
			line-height:21px;
			width:20px;
			margin-top:10px;
			height:30px;
			float:left;
			border:0;
			outline:0 !important;
			background-color:transparent;
			-webkit-appearance:none;
		}

		.mui-input-row label.radio{
			line-height:21px;
			width:30px;
			height:40px;
			float:left;
			text-align:left;
			padding:10px 3px;
		}

		.mui-table-view input[type='radio']{
		}

		.mui-table-view input[type='radio']:before{
			content:'\e411';
		}

		.mui-table-view input[type='radio']:checked:before{
			content:'\e441';
		}

		.mui-table-view input[type='radio']:checked:before{
			color:#007aff;
		}

		.mui-table-view input[type='radio']:before{
			font-family:Muiicons;
			font-size:20px;
			font-weight:normal;
			line-height:1;
			text-decoration:none;
			color:#aaa;
			border-radius:0;
			background:none;
			-webkit-font-smoothing:antialiased;
		}



		.mui-bar .tit-sortbar{
			left: 0;
			right: 0;
			margin-top: 45px;
		}
		.mui-bar .mui-segmented-control {
			top: 0px;
		}
		.mui-segmented-control.mui-segmented-control-inverted .mui-control-item {
			color: #333;
		}

		.tishi { color: #fe4401; width: 100%; text-align: center; padding-top: 10px; }
		.tishi .mui-icon { font-size: 4.4em; }
		.msgbody { width: 100%; font-size: 1.4em; line-height: 25px; color: #333; text-align: center; padding-top: 10px; }
		.msgbody a { font-size: 1.0em; }
		select{
			color:black;
			width:100%;
			padding:0;
			margin:0;
			font-size:12px;
		}
		.add_btn,.removes{
			display:inline-block;
			color:white;
			line-height:20px;
			width:20px;
			height:20px;
			background: #820e01;
			border-radius: 50%;
			text-align: center;
		}

		{/literal}
	</style>
    {include file='theme.tpl'}
</head>
<body>

<div class="mui-inner-wrap">
	<header class="mui-bar mui-bar-nav" style="padding-right: 15px;">
        {*<a href="/official/supplier.php?supplierid={$supplier_info.supplierid}" class="mui-icon mui-icon-back mui-pull-left"></a>*}
		<a id="returnback" class="mui-icon mui-icon-left-nav mui-pull-left"></a>
		<h1 class="mui-title">授权申请</h1>
		<div class="mui-title mui-content tit-sortbar" id="sortbar">
			<div id="segmentedControl" class="mui-segmented-control mui-segmented-control-inverted mui-segmented-control-negative">
				<a class="mui-control-item iconfont icon-daishenpi button-color mui-active" href="authorizationapply.php">&nbsp;我要申请</a>
				<a class="mui-control-item iconfont icon-shenpijilu button-color" href="authorizationapplyrecord.php">&nbsp;申请记录</a>
				<a class="mui-control-item iconfont icon-shenpijilu button-color" href="authorizationapplyrecord_ready.php">&nbsp;授权审批</a>
			</div>
		</div>
	</header>
	<div id="pullrefresh" class="mui-content mui-scroll-wrapper" style="padding-top: 85px;">
		<div class="mui-scroll">
			<form class="mui-input-group" name="frm" id="frm" method="post" action="authorizationapply.php"  parsley-validate>
				<input type="hidden" name="template_values" id="template_values" value="{$simulatedData}">
				<div class="mui-card" style="margin: 3px 3px;">
					<ul class="mui-table-view" style="padding-top: 5px;padding-bottom: 5px;">
						<input  name="type" value="submit" type="hidden">
						<div class="mui-input-row" style="margin-top:3px;">
							<label style="height:45px;">授权标题:</label>
							<input required="required" name="authorizationtitle"
								   value="" type="text" style="font-size: 12px;"
								   class="mui-input-clear required"  placeholder="标题">
						</div>
						<div class="mui-input-row" style="margin-top:3px;">
							<label style="height:65px;">授权内容描述:</label>
							<textarea name="authorizationdescription" required="required" parsley-minlength="10" class="mui-input-clear required" placeholder="授权内容描述"   rows="2" ></textarea>
						</div>
						<div class="mui-input-row" style="margin-top:3px;">
							<label style="height:45px;">授权人:</label>
							<input id="authorizedperson" name="authorizedperson" value="" type="hidden">
							<input required="required" name="authorizedperson_name" id="authorizedperson_name"
								   value="" type="text" style="font-size: 12px;"
								   class="mui-input-clear required"  placeholder="授权人">
						</div>
						<div class="mui-input-row" style="margin-top:3px;">
							<label style="height:45px;">决定人:</label>
							<input id="decider" name="decider" value="" type="hidden">
							<input required="required" name="decider_name" id="decider_name"
								   value="" type="text" style="font-size: 12px;"
								   class="mui-input-clear required"  placeholder="决定人">
						</div>
						<div class="mui-input-row" style="margin-top:3px;">
							<label style="height:45px;">关注人:</label>
							<input id="opinion" name="opinion" value="" type="hidden">
							<input required="required" name="opinion_name" id="opinion_name"
								   value="" type="text" style="font-size: 12px;"
								   class="mui-input-clear required"  placeholder="关注人">
						</div>
						<div class="mui-input-row" style="margin-top:3px;">
							<label style="height:45px;">授权用途:</label>
							<span><input  type="radio" value="0" id="radio-1"
										  name="authorizedtype" >
												                   <label class="radio" for="radio-1">购物</label></span>
							<span><input  type="radio" value="1" id="radio-2"
										  name="authorizedtype" checked>
												                   <label class="radio" for="radio-2">宴请</label></span>
						</div>
						<div class="mui-input-row" style="margin-top:3px;">
							<label style="height:45px;">起始日期:</label>
							<input id="startdate" name="startdate" value="" required="required"
								   data-options='{ldelim}"type":"date","beginYear":2017,"endYear":2027,"value":""{rdelim}'
								   readonly  type="text" class="mui-input-clear required"
								   maxlength="20" placeholder="请输入起始日期">

						</div>
						<div class="mui-input-row" style="margin-top:3px;">
							<label style="height:45px;">结束日期:</label>
							<input id="enddate" name="enddate" value="" required="required"
								   data-options='{ldelim}"type":"date","beginYear":2017,"endYear":2027,"value":""{rdelim}'
								   readonly  type="text" class="mui-input-clear required"
								   maxlength="20" placeholder="请输入结束日期">

						</div>
						<div class="mui-input-row" style="margin-top:3px;">
							<label style="height:45px;">授权模板:</label>
							<input id="templateid" name="templateid" value="" type="hidden">
							<input id="template_name" name="template_name" value=""
								   readonly  type="text" class="mui-input-clear "
								   maxlength="50" placeholder="授权模板">
						</div>

					</ul>
				</div>
				<div class="mui-card" style="margin: 3px 3px;">
					<a href="javascript:void(0);" class="adds mui-icon mui-icon-plus add_weidu mui-pull-right" style="margin-right:10px;"></a>
					<h5 class="mui-content-padded" style="margin-bottom:0px;">授权模板详情
					</h5>
					<ul id="template_div" class="mui-table-view" style="min-height:5px;padding-left: 5px;padding-right: 5px;">
						<li class="mui-table-view-cell fubusi-title" style="background-color: #efeff4;">
						<div class="mui-media-body  mui-pull-left"><span style="width:120px;text-align:left;display:inline-block;">维度类别</span></div>';
						<div class="mui-media-body  mui-pull-left"><span style="padding-left:5px;">比较符</span></div>
						<div class="mui-media-body mui-pull-right" style="text-align:right;">详情</div>
					</ul>
				</div>

				<div class="mui-card mui-btn-my" style=" margin: 3px 3px;background:{$theme_info.buttoncolor};">
					<div class="mui-content-padded" style="margin:0px;margin-top: 5px;">
						<h5 class="show-content" style="padding: 10px;"><span class="mui-icon iconfont icon-save"></span> 提交给授权人</h5>
					</div>
				</div>
			</form>
            {include file='copyright.tpl'}
		</div>
	</div>

</div>

<script type="text/javascript">
    var users = {$users};
    var officialauthorizedimensions = {$officialauthorizedimensions};
    var authorizedimensions = {$authorizedimensions};
    {literal}
    var simulatedData = [];
    mui.init({
        pullRefresh: {
            container: '#pullrefresh' //待刷新区域标识，querySelector能定位的css选择器均可，比如：id、.class等
        },
    });
    mui.ready(function ()
    {
        document.getElementById('returnback').addEventListener('tap', function() {
            Cordova.exec(null, null, "PhoneGapPlugin", "PluginFunction", [{"type":"historyback"}]);
        });
        //返回按钮
        mui('#pullrefresh').scroll();
        mui('.mui-bar').on('tap', 'a', function (e)
        {
            mui.openWindow({
                url: this.getAttribute('href'),
                id: 'info'
            });
        });
        mui('.mui-content').on('tap', 'h5.show-content', function (e)
        {
            var validate = Zepto( '#frm' ).parsley( 'validate' );
            if (validate)
            {
                swal({
                    title: "提示",
                    text: "您确定提交申请吗？",
                    type: "warning",
                    showCancelButton: true,
                    closeOnConfirm: true,
                    confirmButtonText: "确定提交",
                    confirmButtonColor: "#ec6c62"
                }, function ()
                {
                    var simulatedData={};
                    $(".weidu").each(function(i){
                        var weidu_kind=$(this).find('select.weidu_kind').val();

                        var oper=$(this).parent().find(".compare>select").val();
                        if(oper===undefined || oper==''){
                            oper=$(this).parent().find(".compare").text();
                        }
                        var weidu_zhi=$(this).parent().find("input[type='number']").val();
                        if(weidu_zhi===undefined || weidu_zhi=='' ||weidu_zhi==null){
                            var weiduzhi=$(this).parent().find("div.weiduzhi").text();
                            var hide_weiduzhi=$(this).parent().find("div.weiduzhi>span.quoto").attr("hide_text");
                            if(hide_weiduzhi==null)weidu_zhi=weiduzhi;
                            else weidu_zhi=weiduzhi+''+hide_weiduzhi;

                            if(weiduzhi===undefined || weiduzhi=='' || weiduzhi==null){
                                var weiduzhi=$(this).parent().find("div.weiduzhi2").text();
                                var hide_weiduzhi=$(this).parent().find("div.weiduzhi2>span.quoto").attr("hide_text");
                                var weidu_zhi=weiduzhi+''+hide_weiduzhi;
                            }
                            weidu_zhi=weidu_zhi.replace(/\.\.\.\.\.\./,'');
                        }

                        var dataElement={};
                        dataElement['weidu_kind']=weidu_kind;
                        dataElement['oper']=oper;
                        dataElement['weidu_zhi']=weidu_zhi;
                        simulatedData[i]=dataElement;
                    })

                    var simulatedDatastr=JSON.stringify(simulatedData);
                    $("#template_values").val(simulatedDatastr);
                    document.frm.submit();
                });
            }
        });
        //起始时间、结束时间选择框
        var pickers = {};
        mui('.mui-table-view').on('tap', 'input#startdate', function (e) {
            var optionsJson = this.getAttribute('data-options') || '{}';
            var options = JSON.parse(optionsJson);
            var id = this.getAttribute('id');
            pickers[id] = pickers[id] || new mui.DtPicker(options);
            pickers[id].show(function (rs) {
                Zepto("#startdate").val(rs.text);
                Zepto('#startdate').parsley('validate');
            });
        });
        mui('.mui-table-view').on('tap', 'input#enddate', function (e) {
            var optionsJson = this.getAttribute('data-options') || '{}';
            var options = JSON.parse(optionsJson);
            var id = this.getAttribute('id');
            pickers[id] = pickers[id] || new mui.DtPicker(options);
            pickers[id].show(function (rs) {
                Zepto("#enddate").val(rs.text);
                Zepto('#enddate').parsley('validate');
            });
        });
        //点击选择系统已创建的模版
        var authorizeeventPicker = new mui.PopPicker();
        authorizeeventPicker.setData(authorizedimensions);
        var ischecked = new Array();
        var ischecked2 = new Array();
        Array.prototype.contains = function ( needle ){
            for (i in this) {
                if (this[i] == needle) return true;
            }
            return false;
        };

        //点击模版下拉选择框种选择某一项时，回调函数中加载模版详情
        mui('.mui-table-view').on('tap', 'input#template_name', function (e) {
            authorizeeventPicker.show(function(items) {
                var selectauthorizeevent =  items[0].value;
                $("#templateid").val(selectauthorizeevent);
                $("#template_name").val(items[0].text);
                var btn = document.getElementById("templateid");
                mui.ajax('authorization_ajax.php',{
                    data:{
                        selectauthorizeevent:selectauthorizeevent,
                    },
                    type:'get',//HTTP请求类型
                    success:function(data){
                        eval("var json="+data);
                        simulatedData=json;

                        var html = '<h5>';
                        html += '<li class="mui-table-view-cell fubusi-title" style="background-color: #efeff4;">';
                        html += '	<div class="mui-media-body  mui-pull-left"><span style="width:120px;text-align:left;display:inline-block;">维度类别</span></div>';
                        html += '	<div class="mui-media-body  mui-pull-left"><span style="padding-left:5px;">比较符</span></div>';
                        html += '	<div class="mui-media-body mui-pull-right" style="width:30px;text-align:right;">操作</div>';
                        html += '	<div class="mui-media-body mui-pull-right" style="text-align:right;">维度值</div>';
                        html += '</li>';
                        html += '</h5>';
                        $("#template_div").html(html);
                        Zepto.each(simulatedData, function(k, detail_info) {
                            var detail_html = '<li class="mui-table-view-cell weidu_list">';
                            detail_html += '<div class="mui-media-body  mui-pull-left"><span style="display:inline-block;white-space:nowrap;width:120px;text-align:left;overflow: hidden;">'+detail_info.dimensiontypename+'</span></div>';
                            detail_html += '<div class="mui-media-body  mui-pull-left"><span style="padding-left:5px;">'+detail_info.comparisonoperator+'</span></div>';
                            detail_html += '<div class="mui-media-body mui-pull-right" style="width:30px;text-align:right;"><span class="removes">-</span></div>';
                            if(detail_info.dimensiontypename == '消费商户类别'){
                                detail_html += '<div class="mui-media-body mui-pull-right" ' +
                                    'style="text-align:right;"><span class="price1">'+detail_info
                                        .dimensionvalue[1]+'</span></div>';
                                for(var a=0;a<detail_info.dimensionvalue.length;a++){
                                    ischecked.push(detail_info.dimensionvalue[a]);
                                }
                            }else if(detail_info.dimensiontypename == '消费品类'){
                                detail_html += '<div class="mui-media-body mui-pull-right" style="text-align:right;"><span class="price2">'+detail_info.dimensionvalue[1]+'</span></div>';
                                for(var b=0;b<detail_info.dimensionvalue.length;b++){
                                    ischecked2.push(detail_info.dimensionvalue[b]);
                                }
                            } else{
                                detail_html += '<div class="mui-media-body mui-pull-right" style="text-align:right;"><input type="number" class="price" value="'+detail_info.dimensionvalue+'" style="width:60px;height:20px;font-size:12px;text-align:right;padding:10px 5px;"></div>';
                            }
                            detail_html += '</li>';
                            $("#template_div").append(detail_html);
                        });
                    }
                });
            });
        });
        //点击＋号新增一行模版设置
        $(document).on('tap','.add_weidu',addinner);
        function addinner(){
            var html = '<li class="mui-table-view-cell weidu_list"><div class="mui-media-body  mui-pull-left weidu" style="width:120px"><select class="weidu_kind"><option value="消费商户类别">消费商户类别</option><option value="消费品类">消费品类</option><option value="人均">人均</option><option value="单价" >单价</option><option value="单次额度">单次额度</option><option value="累计额度">累计额度</option><option value="单次额度">授权次数</option></select></div><div class="mui-media-body  mui-pull-left"><span style="padding-left:5px;" class="compare">包含</span></div><div class="mui-media-body mui-pull-right operation"><span class="removes">-</span></div><div class="mui-media-body mui-pull-right weiduzhi" style="text-align:left;margin-right:5px">点击选择</div></li>';
            $('#template_div').append(html);
        }
        $(document).on('tap','.price1',function(){
            var self = $(this);
            var html = '<div style="max-height:200px;overflow-x:hidden;overflow-y:scroll;border:1px solid  #c8c7cc;padding-bottom:5px;">';
            // Zepto.each(users, function(key, user_info) {
            if(ischecked.contains('茶厂')){
                html += '<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;" >茶厂</label><input name="opinion_checkbox" label="1" value="茶厂" type="checkbox" style="margin-top: 2px;top:0px;" checked></div>'
            } else{
                html += '<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;" >茶厂</label><input name="opinion_checkbox" label="1" value="茶厂" type="checkbox" style="margin-top: 2px;top:0px;" ></div>'
            };
            if(ischecked.contains('超市')){
                html += '<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;">超市</label><input name="opinion_checkbox" label="1" value="超市" type="checkbox" style="margin-top: 2px;top:0px;" checked></div>'
            } else{
                html += '<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;">超市</label><input name="opinion_checkbox" label="1" value="超市" type="checkbox" style="margin-top: 2px;top:0px;"></div>'
            };
            if(ischecked.contains('会所')){
                html += '<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;">会所</label><input name="opinion_checkbox" label="1" value="会所" type="checkbox" style="margin-top: 2px;top:0px;" checked></div>'
            } else{
                html += '<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;">会所</label><input name="opinion_checkbox" label="1" value="会所" type="checkbox" style="margin-top: 2px;top:0px;"></div>'
            };
            if(ischecked.contains('咖啡茶座')){
                html += '<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;">咖啡茶座</label><input name="opinion_checkbox" label="1" value="咖啡茶座" type="checkbox" style="margin-top: 2px;top:0px;" checked></div>'
            } else{
                html += '<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;">咖啡茶座</label><input name="opinion_checkbox" label="1" value="咖啡茶座" type="checkbox" style="margin-top: 2px;top:0px;"></div>'
            };
            if(ischecked.contains('酒楼')){
                html += '<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;">酒楼</label><input name="opinion_checkbox" label="1" value="酒楼" type="checkbox" style="margin-top: 2px;top:0px;" checked></div>'
            } else{
                html += '<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;">酒楼</label><input name="opinion_checkbox" label="1" value="酒楼" type="checkbox" style="margin-top: 2px;top:0px;"></div>'
            };
            if(ischecked.contains('餐饮公司')){
                html += '<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;">餐饮公司</label><input name="opinion_checkbox" label="1" value="餐饮公司" type="checkbox" style="margin-top: 2px;top:0px;" checked></div>'
            } else{
                html += '<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;">餐饮公司</label><input name="opinion_checkbox" label="1" value="餐饮公司" type="checkbox" style="margin-top: 2px;top:0px;"></div>'
            };
            if(ischecked.contains('外卖')){
                html += '<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;">外卖</label><input name="opinion_checkbox" label="1" value="外卖" type="checkbox" style="margin-top: 2px;top:0px;" checked></div>'
            } else{
                html += '<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;">外卖</label><input name="opinion_checkbox" label="1" value="外卖" type="checkbox" style="margin-top: 2px;top:0px;"></div>'
            };
            if(ischecked.contains('办公用品')){
                html += '<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;">办公用品</label><input name="opinion_checkbox" label="1" value="办公用品" type="checkbox" style="margin-top: 2px;top:0px;" checked></div>'
            } else{
                html += '<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;">办公用品</label><input name="opinion_checkbox" label="1" value="办公用品" type="checkbox" style="margin-top: 2px;top:0px;"></div>'
            }

            html += "</div>";
            swal({
                title: "添加维度值",
                text: html,
                html:true,
                type: "",
                showCancelButton: true,
                closeOnConfirm: true,
                confirmButtonText: "确定",
                confirmButtonColor: "#ec6c62"
            }, function ()
            {
                var profileids = [];
                var profilenames = [];
                ischecked.splice(0,ischecked.length);
                Zepto.each(Zepto('input[name=opinion_checkbox]'), function(k,obj) {
                    if ($(obj).prop("checked")){
                        profileids.push($(obj).val());
                        profilenames.push($(obj).attr('label'));
                        ischecked.push($(obj).val());
                    }

                });
                if(profileids.length>0){
                    self.text(profileids.join(' '));
                }
            });
            // $(this).text('已选择')

        });
        $(document).on('tap','.price2',function(e){
            e.stopPropagation();
            e.preventDefault();
            var self = $(this);
            var html = '<div style="max-height:200px;overflow-x:hidden;overflow-y:scroll;border:1px solid  #c8c7cc;padding-bottom:5px;">';
            // Zepto.each(users, function(key, user_info) {
            if(ischecked2.contains('餐饮')){
                html += '<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;" >餐饮</label><input name="opinion_checkbox" label="1" value="餐饮" type="checkbox" style="margin-top: 2px;top:0px;" checked></div>'
            } else{
                html += '<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;" >餐饮</label><input name="opinion_checkbox" label="1" value="餐饮" type="checkbox" style="margin-top: 2px;top:0px;" ></div>'
            };
            if(ischecked2.contains('茶')){
                html += '<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;">茶</label><input name="opinion_checkbox" label="1" value="茶" type="checkbox" style="margin-top: 2px;top:0px;" checked></div>'
            } else{
                html += '<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;">茶</label><input name="opinion_checkbox" label="1" value="茶" type="checkbox" style="margin-top: 2px;top:0px;"></div>'
            };
            if(ischecked2.contains('酒')){
                html += '<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;">酒</label><input name="opinion_checkbox" label="1" value="酒" type="checkbox" style="margin-top: 2px;top:0px;" checked></div>'
            } else{
                html += '<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;">酒</label><input name="opinion_checkbox" label="1" value="酒" type="checkbox" style="margin-top: 2px;top:0px;"></div>'
            };
            if(ischecked2.contains('办公用品')){
                html += '<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;">办公用品</label><input name="opinion_checkbox" label="1" value="办公用品" type="checkbox" style="margin-top: 2px;top:0px;" checked></div>'
            } else{
                html += '<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;">办公用品</label><input name="opinion_checkbox" label="1" value="办公用品" type="checkbox" style="margin-top: 2px;top:0px;"></div>'
            };
            if(ischecked2.contains('外卖')){
                html += '<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;">外卖</label><input name="opinion_checkbox" label="1" value="外卖" type="checkbox" style="margin-top: 2px;top:0px;" checked></div>'
            } else{
                html += '<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;">外卖</label><input name="opinion_checkbox" label="1" value="外卖" type="checkbox" style="margin-top: 2px;top:0px;"></div>'
            };

            html += "</div>";
            swal({
                title: "添加维度值",
                text: html,
                html:true,
                type: "",
                showCancelButton: true,
                closeOnConfirm: true,
                confirmButtonText: "确定",
                confirmButtonColor: "#ec6c62"
            }, function ()
            {
                var profileids = [];
                var profilenames = [];
                ischecked2.splice(0,ischecked2.length);
                Zepto.each(Zepto('input[name=opinion_checkbox]'), function(k,obj) {
                    if ($(obj).prop("checked")){
                        profileids.push($(obj).val());
                        profilenames.push($(obj).attr('label'));
                        ischecked2.push($(obj).val());
                    }

                });
                if(profileids.length>0){
                    self.text('点击查看')
                }
            });

        });
        //纬度第一列选择纬度
        $(document).on('click','.weidu_kind',function(){
            if($(this).val()=='消费商户类别'){
                $(this).parent().next().replaceWith('<div class="mui-media-body  mui-pull-left compare"><span style="padding-left:5px;">包含</span></div>');
                $(this).parent().next().next().next().replaceWith('<div class="mui-media-body mui-pull-right weiduzhi" style="text-align:left;margin-right:5px">点击选择</div>');
            } else if($(this).val()=='消费品类'){
                $(this).parent().next().replaceWith('<div class="mui-media-body  mui-pull-left compare"><span style="padding-left:5px;">包含</span></div>');
                $(this).parent().next().next().next().replaceWith('<div class="mui-media-body mui-pull-right weiduzhi2" style="text-align:left;margin-right:5px">点击选择</div>');
            } else{
                $(this).parent().next().replaceWith('<div class="mui-media-body  mui-pull-left compare"><select name="" id="" style="padding-left:8px"><option value="=">=</option><option value=">">></option><option value=">=">>=</option><option value="<"><</option><option value="<="><=</option></select></div>');
                $(this).parent().next().next().next().replaceWith('<div class="mui-media-body mui-pull-right" style="text-align:left;margin-right:5px"><input type="number" style="width:60px;height:20px;font-size:12px;text-align:right;padding:10px 5px;"></div>');
            }
        });
        $(document).on('click','.weiduzhi',function(){
        //mui('.mui-table-view').on('tap', '.weiduzhi', function (){
            var self = $(this);
            var html = '<div style="max-height:200px;overflow-x:hidden;overflow-y:scroll;border:1px solid  #c8c7cc;padding-bottom:5px;">';
            // Zepto.each(users, function(key, user_info) {
            if(ischecked.contains('茶厂')){
                html += '<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;" >茶厂</label><input name="opinion_checkbox" label="1" value="茶厂" type="checkbox" style="margin-top: 2px;top:0px;" checked></div>'
            } else{
                html += '<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;" >茶厂</label><input name="opinion_checkbox" label="1" value="茶厂" type="checkbox" style="margin-top: 2px;top:0px;" ></div>'
            };
            if(ischecked.contains('超市')){
                html += '<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;">超市</label><input name="opinion_checkbox" label="1" value="超市" type="checkbox" style="margin-top: 2px;top:0px;" checked></div>'
            } else{
                html += '<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;">超市</label><input name="opinion_checkbox" label="1" value="超市" type="checkbox" style="margin-top: 2px;top:0px;"></div>'
            };
            if(ischecked.contains('会所')){
                html += '<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;">会所</label><input name="opinion_checkbox" label="1" value="会所" type="checkbox" style="margin-top: 2px;top:0px;" checked></div>'
            } else{
                html += '<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;">会所</label><input name="opinion_checkbox" label="1" value="会所" type="checkbox" style="margin-top: 2px;top:0px;"></div>'
            };
            if(ischecked.contains('咖啡茶座')){
                html += '<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;">咖啡茶座</label><input name="opinion_checkbox" label="1" value="咖啡茶座" type="checkbox" style="margin-top: 2px;top:0px;" checked></div>'
            } else{
                html += '<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;">咖啡茶座</label><input name="opinion_checkbox" label="1" value="咖啡茶座" type="checkbox" style="margin-top: 2px;top:0px;"></div>'
            };
            if(ischecked.contains('酒楼')){
                html += '<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;">酒楼</label><input name="opinion_checkbox" label="1" value="酒楼" type="checkbox" style="margin-top: 2px;top:0px;" checked></div>'
            } else{
                html += '<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;">酒楼</label><input name="opinion_checkbox" label="1" value="酒楼" type="checkbox" style="margin-top: 2px;top:0px;"></div>'
            };
            if(ischecked.contains('餐饮公司')){
                html += '<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;">餐饮公司</label><input name="opinion_checkbox" label="1" value="餐饮公司" type="checkbox" style="margin-top: 2px;top:0px;" checked></div>'
            } else{
                html += '<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;">餐饮公司</label><input name="opinion_checkbox" label="1" value="餐饮公司" type="checkbox" style="margin-top: 2px;top:0px;"></div>'
            };
            if(ischecked.contains('外卖')){
                html += '<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;">外卖</label><input name="opinion_checkbox" label="1" value="外卖" type="checkbox" style="margin-top: 2px;top:0px;" checked></div>'
            } else{
                html += '<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;">外卖</label><input name="opinion_checkbox" label="1" value="外卖" type="checkbox" style="margin-top: 2px;top:0px;"></div>'
            };
            if(ischecked.contains('办公用品')){
                html += '<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;">办公用品</label><input name="opinion_checkbox" label="1" value="办公用品" type="checkbox" style="margin-top: 2px;top:0px;" checked></div>'
            } else{
                html += '<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;">办公用品</label><input name="opinion_checkbox" label="1" value="办公用品" type="checkbox" style="margin-top: 2px;top:0px;"></div>'
            }

            html += "</div>";
            swal({
                title: "添加维度值",
                text: html,
                html:true,
                type: "",
                showCancelButton: true,
                closeOnConfirm: true,
                confirmButtonText: "确定",
                confirmButtonColor: "#ec6c62"
            }, function ()
            {
                var profileids = [];
                var profilenames = [];
                ischecked.splice(0,ischecked.length);
                Zepto.each(Zepto('input[name=opinion_checkbox]'), function(k,obj) {
                    if ($(obj).prop("checked")){
                        profileids.push($(obj).val());
                        profilenames.push($(obj).attr('label'));
                        ischecked.push($(obj).val());
                    }

                });
                if(profileids.length>0){
                    var selected_consume_supplier_types=ischecked.join(' ');
                    var self_text=selected_consume_supplier_types;
                    if(selected_consume_supplier_types.length>5){
                        var show_consume_supplier_types=selected_consume_supplier_types.substr(0,5);
                        var hide_consume_supplier_types=selected_consume_supplier_types.substr(5);
                        self_text=show_consume_supplier_types+'<span class="quoto" hide_text="'+hide_consume_supplier_types+'">......</span>';
                    }
                    self.html(self_text);
                }
            });
        });
        $(document).on('click','.quoto',function(){
        //mui('.mui-table-view').on('tap', '.quoto', function (e) {
            var self = $(this);
            var self_text=self.parent().text();
            self_text=self_text.substr(0,self_text.length-6);
            var hide_text=self.attr('hide_text');
            var show_text=self_text+''+hide_text
            self.parent().text(show_text);
            event.preventDefault();
            event.stopPropagation()
        })
        $(document).on('click','.weiduzhi2',function(){
        //mui('.mui-table-view').on('tap', '.weiduzhi2', function (e) {
            var self = $(this);
            var html = '<div style="max-height:200px;overflow-x:hidden;overflow-y:scroll;border:1px solid  #c8c7cc;padding-bottom:5px;">';
            // Zepto.each(users, function(key, user_info) {
            if(ischecked2.contains('餐饮')){
                html += '<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;" >餐饮</label><input name="opinion_checkbox" label="1" value="餐饮" type="checkbox" style="margin-top: 2px;top:0px;" checked></div>'
            } else{
                html += '<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;" >餐饮</label><input name="opinion_checkbox" label="1" value="餐饮" type="checkbox" style="margin-top: 2px;top:0px;" ></div>'
            };
            if(ischecked2.contains('茶')){
                html += '<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;">茶</label><input name="opinion_checkbox" label="1" value="茶" type="checkbox" style="margin-top: 2px;top:0px;" checked></div>'
            } else{
                html += '<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;">茶</label><input name="opinion_checkbox" label="1" value="茶" type="checkbox" style="margin-top: 2px;top:0px;"></div>'
            };
            if(ischecked2.contains('酒')){
                html += '<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;">酒</label><input name="opinion_checkbox" label="1" value="酒" type="checkbox" style="margin-top: 2px;top:0px;" checked></div>'
            } else{
                html += '<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;">酒</label><input name="opinion_checkbox" label="1" value="酒" type="checkbox" style="margin-top: 2px;top:0px;"></div>'
            };
            if(ischecked2.contains('办公用品')){
                html += '<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;">办公用品</label><input name="opinion_checkbox" label="1" value="办公用品" type="checkbox" style="margin-top: 2px;top:0px;" checked></div>'
            } else{
                html += '<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;">办公用品</label><input name="opinion_checkbox" label="1" value="办公用品" type="checkbox" style="margin-top: 2px;top:0px;"></div>'
            };
            if(ischecked2.contains('外卖')){
                html += '<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;">外卖</label><input name="opinion_checkbox" label="1" value="外卖" type="checkbox" style="margin-top: 2px;top:0px;" checked></div>'
            } else{
                html += '<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;">外卖</label><input name="opinion_checkbox" label="1" value="外卖" type="checkbox" style="margin-top: 2px;top:0px;"></div>'
            };
            html += "</div>";
            swal({
                title: "添加维度值",
                text: html,
                html:true,
                type: "",
                showCancelButton: true,
                closeOnConfirm: true,
                confirmButtonText: "确定",
                confirmButtonColor: "#ec6c62"
            }, function ()
            {
                var profileids = [];
                var profilenames = [];
                ischecked2.splice(0,ischecked2.length);
                Zepto.each(Zepto('input[name=opinion_checkbox]'), function(k,obj) {
                    if ($(obj).prop("checked")){
                        profileids.push($(obj).val());
                        profilenames.push($(obj).attr('label'));
                        ischecked2.push($(obj).val())
                    }
                });
                if(profileids.length>0){
                    var selected_consume_supplier_types=ischecked2.join(' ');
                    var self_text=selected_consume_supplier_types;
                    if(selected_consume_supplier_types.length>5){
                        var show_consume_supplier_types=selected_consume_supplier_types.substr(0,5);
                        var hide_consume_supplier_types=selected_consume_supplier_types.substr(5);
                        self_text=show_consume_supplier_types+'<span class="quoto" hide_text="'+hide_consume_supplier_types+'">......</span>';
                    }
                    self.html(self_text);
                }
            });
        });
        //删除一行
        $(document).on('tap','.removes',function(){
            var someElement = $(this).parent().prev().prev().children();
            var val = someElement.val();
            // removeByValue(realdata, val);
            if(someElement.value == '消费商户类别' || someElement.text() == '消费商户类别'){
                ischecked.splice(0,ischecked.length);
            }

            else if(someElement.value == '消费品类' || someElement.text() == '消费品类'){
                ischecked2.splice(0,ischecked2.length);
            }
            $(this).parents('.weidu_list').remove();
        });





        mui('.mui-table-view').on('tap', 'input#authorizedperson_name', function (e) {
            var html = '<div style="max-height:200px;overflow-x:hidden;overflow-y:scroll;border:1px solid  #c8c7cc;padding-bottom:5px;">';
            Zepto.each(users, function(key, user_info) {
                html += '<div class="mui-input-row mui-radio mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;">'+user_info.account+'</label><input name="authorizedperson_checkbox" label="'+user_info.account+'" value="'+user_info.profileid+'" type="radio" style="margin-top: 2px;top:0px;"></div>';
            });
            html += "</div>";
            swal({
                title: "选择授权人",
                text: html,
                html:true,
                type: "",
                showCancelButton: true,
                closeOnConfirm: true,
                confirmButtonText: "确定",
                confirmButtonColor: "#ec6c62"
            }, function ()
            {
                var profileid = "";
                var profilename = "";
                Zepto.each(Zepto('input[name=authorizedperson_checkbox]'), function(k,obj) {
                    if ($(obj).prop("checked")){
                        profileid = $(obj).val();
                        profilename = $(obj).attr('label');
                    }

                });
                $("#authorizedperson").val(profileid);
                $("#authorizedperson_name").val(profilename);
            });

        });
        mui('.mui-table-view').on('tap', 'input#decider_name', function (e) {
            var html = '<div style="max-height:200px;overflow-x:hidden;overflow-y:scroll;border:1px solid  #c8c7cc;padding-bottom:5px;">';
            Zepto.each(users, function(key, user_info) {
                html += '<div class="mui-input-row mui-radio mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;">'+user_info.account+'</label><input name="decider_checkbox" label="'+user_info.account+'" value="'+user_info.profileid+'" type="radio" style="margin-top: 2px;top:0px;"></div>';
            });
            html += "</div>";
            swal({
                title: "选择决定人",
                text: html,
                html:true,
                type: "",
                showCancelButton: true,
                closeOnConfirm: true,
                confirmButtonText: "确定",
                confirmButtonColor: "#ec6c62"
            }, function ()
            {
                var profileid = "";
                var profilename = "";
                Zepto.each(Zepto('input[name=decider_checkbox]'), function(k,obj) {
                    if ($(obj).prop("checked")){
                        profileid = $(obj).val();
                        profilename = $(obj).attr('label');
                    }

                });
                $("#decider").val(profileid);
                $("#decider_name").val(profilename);
            });

        });
        mui('.mui-table-view').on('tap', 'input#opinion_name', function (e) {
            var html = '<div style="max-height:200px;overflow-x:hidden;overflow-y:scroll;border:1px solid  #c8c7cc;padding-bottom:5px;">';
            Zepto.each(users, function(key, user_info) {
                html += '<div class="mui-input-row mui-checkbox mui-left"><label style="line-height: 29px;height: 29px;text-align:left;width:60%;padding:3px;">'+user_info.account+'</label><input name="opinion_checkbox" label="'+user_info.account+'" value="'+user_info.profileid+'" type="checkbox" style="margin-top: 2px;top:0px;"></div>';
            });
            html += "</div>";
            swal({
                title: "选择关注人",
                text: html,
                html:true,
                type: "",
                showCancelButton: true,
                closeOnConfirm: true,
                confirmButtonText: "确定",
                confirmButtonColor: "#ec6c62"
            }, function ()
            {
                var profileids = [];
                var profilenames = [];
                Zepto.each(Zepto('input[name=opinion_checkbox]'), function(k,obj) {
                    if ($(obj).prop("checked")){
                        profileids.push($(obj).val());
                        profilenames.push($(obj).attr('label'));
                    }

                });
                $("#opinion").val(profileids.join(','));
                $("#opinion_name").val(profilenames.join(','));
            });

        });

    });

    {/literal}
</script>
<script src="/public/js/baidu.js?_=20140821" type="text/javascript"></script>
</body>
</html>