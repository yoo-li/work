function reporttypechange() {
	var reporttype = $.CurrentDialog.find('#reporttype option:selected').html()
	if(reporttype == '综合报表'){
		$.CurrentDialog.find('#modulestabid_group').css('display','none');
		$.CurrentDialog.find('#complex_group').css('display','block');
		$.CurrentDialog.find('#modulestabid').attr('novalidate',true);
		$.CurrentDialog.find('#complex').removeAttr('novalidate');
	}else{
		$.CurrentDialog.find('#modulestabid_group').css('display','block');
		$.CurrentDialog.find('#complex_group').css('display','none');
		$.CurrentDialog.find('#complex').attr('novalidate',true);
		$.CurrentDialog.find('#modulestabid').removeAttr('novalidate');
	}
}


function addreportfilter() {
	if ($.CurrentNavtab.find('#reportfilterfields').val() == "" || $.CurrentNavtab.find('#reportfilterfields').val() == null || $.CurrentNavtab.find('#reportfiltertype').val() == ""){
		$(this).alertmsg("warn", "必须先选择查询字段和查询类型!", {autoClose: true, alertTimeout: 2000});
		return;
	}
	var querycount = parseInt($.CurrentNavtab.find('#reportfiltercount').val(),10);
	var fields = "";
	$.CurrentNavtab.find('#reportfilterfields option:selected').each(function(){
		if(fields != ""){
			fields += ",";
		}
		fields += $(this).html();
	});
	var html = '<tr>' +
			   '<td><label class="control-label x100" style="font-weight: normal;">筛选字段:</label></td>' +
			   '<td style="width: 33%;">'+fields+
			   '<input type="hidden" id="reportfilterfield_'+querycount+'" name="reportfilterfield_'+querycount+'" value="'+$.CurrentNavtab.find('#reportfilterfields').val()+'">' +
			   '</td>' +
			   '<td><label class="control-label x100" style="font-weight: normal;">显示模型:</label></td>' +
			   '<td style="width: 33%;">'+$.CurrentNavtab.find('#reportfiltertype option:selected').html()+
			   '<input type="hidden" id="reportfiltertype_'+querycount+'" name="reportfiltertype_'+querycount+'" value="'+$.CurrentNavtab.find('#reportfiltertype').val()+'">' +
			   '</td>' +
			   '<td><label class="control-label x100" style="font-weight: normal;">&nbsp;</label></td>' +
			   '<td style="width: 33%;" align="right"><button class="btn btn-red" data-icon="times" onclick="removereportquery(this);" type="button">删除</button></td>' +
			   '</tr>';
	$.CurrentNavtab.find('#reportfiltercount').val(querycount+1);
	$.CurrentNavtab.find("#report_filter_table").append(html).initui();
	$.CurrentNavtab.find('#reportfilterfields').selectpicker('val',"");
	$.CurrentNavtab.find('#reportfilterfields').selectpicker('render');
	$.CurrentNavtab.find('#reportfiltertype').selectpicker('val',"");
	$.CurrentNavtab.find('#reportfiltertype').selectpicker('render');
}

function addreportquery() {
	if ($.CurrentNavtab.find('#reportqueryfields').val() == "" || $.CurrentNavtab.find('#reportqueryfields').val() == null || $.CurrentNavtab.find('#reportquerylogic').val() == "" || $.CurrentNavtab.find('#reportqueryvalue').val() == ""){
		$(this).alertmsg("warn", "必须先选择过滤字段和过滤逻辑,填写过滤值!", {autoClose: true, alertTimeout: 2000});
		return;
	}

	var querycount = parseInt($.CurrentNavtab.find('#reportquerycount').val(),10);
	var html = '<tr>' +
			   '<td><label class="control-label x100" style="font-weight: normal;">过滤字段:</label></td>' +
			   '<td style="width: 35%;">'+$.CurrentNavtab.find('#reportqueryfields option:selected').html()+
			   '<input type="hidden" id="reportqueryfield_'+querycount+'" name="reportqueryfield_'+querycount+'" value="'+$.CurrentNavtab.find('#reportqueryfields').val()+'">' +
			   '</td>' +
			   '<td><label class="control-label x100" style="font-weight: normal;">过滤逻辑:</label></td>' +
			   '<td style="width: 36.5%;">'+$.CurrentNavtab.find('#reportquerylogic option:selected').html()+
			   '<input type="hidden" id="reportquerylogic_'+querycount+'" name="reportquerylogic_'+querycount+'" value="'+$.CurrentNavtab.find('#reportquerylogic').val()+'">' +
			   '</td>' +
			   '<td><label class="control-label x100" style="font-weight: normal;">过滤值:</label></td>' +
			   '<td style="width: 33%;">' + $.CurrentNavtab.find('#reportqueryvalue').val() +
			   '<input type="hidden" id="reportqueryvalue_'+querycount+'" name="reportqueryvalue_'+querycount+'" value="'+$.CurrentNavtab.find('#reportqueryvalue').val()+'">' +
			   '</td>' +
			   '<td align="right"><button class="btn btn-red" data-icon="times" onclick="removereportquery(this);" type="button">删除</button></td>' +
			   '</tr>';
	$.CurrentNavtab.find('#reportquerycount').val(querycount+1);
	$.CurrentNavtab.find("#report_query_table").append(html).initui();
	$.CurrentNavtab.find('#reportqueryfields').selectpicker('val',"");
	$.CurrentNavtab.find('#reportqueryfields').selectpicker('render');
	$.CurrentNavtab.find('#reportquerylogic').selectpicker('val',"");
	$.CurrentNavtab.find('#reportquerylogic').selectpicker('render');
	$.CurrentNavtab.find('#reportqueryvalue').val("");
}

function removereportquery(obj){
	$(obj).parent().parent().remove();
}

function reporttypeonchange() {
	var reporttype = $.CurrentNavtab.find('#reporttype option:selected').html();
	if (reporttype == "综合报表"){
		$.CurrentNavtab.find('#reportfilters_panel').css('display','none');
		$.CurrentNavtab.find('#reportquerys_panel').css('display','none');
		$.CurrentNavtab.find('#reportaxis_panel').css('display','none');
		$.CurrentNavtab.find('#modulestab_label').css('display','none');
		$.CurrentNavtab.find('#modulestabid_div').css('display','none');
		$.CurrentNavtab.find('#complex_label').css('display','block');
		$.CurrentNavtab.find('#complex_div').css('display','block');
		$.CurrentNavtab.find('#modulestabid').attr('novalidate',true);
		$.CurrentNavtab.find('#x_axis').attr('novalidate',true);
		$.CurrentNavtab.find('#y_axis').attr('novalidate',true);
		$.CurrentNavtab.find('#complex').removeAttr('novalidate');
	}else
	{
		$.CurrentNavtab.find('#reportfilters_panel').css('display','block');
		$.CurrentNavtab.find('#reportquerys_panel').css('display','block');
		$.CurrentNavtab.find('#reportaxis_panel').css('display','block');
		$.CurrentNavtab.find('#modulestab_label').css('display','block');
		$.CurrentNavtab.find('#modulestabid_div').css('display','block');
		$.CurrentNavtab.find('#complex_label').css('display','none');
		$.CurrentNavtab.find('#complex_div').css('display','none');
		$.CurrentNavtab.find('#modulestabid').removeAttr('novalidate');
		$.CurrentNavtab.find('#x_axis').removeAttr('novalidate');
		$.CurrentNavtab.find('#y_axis').removeAttr('novalidate');
		$.CurrentNavtab.find('#complex').attr('novalidate',true);

		var html = "";
		if (reporttype == "TopN报表")
		{
			html = '<tr>' +
				   '<td><label class="control-label x100" style="font-weight: normal;" for="x_axis">Ｘ轴字段:</label></td>' +
				   '<td style="width: 29%;">' +
				   '<select id="x_axis" name="x_axis" data-toggle="selectpicker" data-width="200px" class="required" data-rule="required;">' +
				   '<option value="" selected>==选择字段==</option>' + Xaxisfields +
				   '</select>' +
				   '</td>' +
				   '<td><label class="control-label x100" style="font-weight: normal;" for="y_axis">Ｙ轴字段:</label></td>' +
				   '<td style="width: 29%;">' +
				   '<select id="y_axis" name="y_axis" data-toggle="selectpicker" data-width="200px" class="required" data-rule="required;">' +
				   '<option value="" selected>==选择字段==</option>' + Yaxisfields +
				   '</select>' +
				   '</td>' +
				   '<td><label class="control-label x100" style="font-weight: normal;" for="z_axis">&nbsp;</label></td>' +
				   '<td style="width: 34%;">&nbsp;</td>' +
				   '</tr>';
		}
		else if (reporttype == "同比报表" || reporttype == "环比报表")
		{
			html = '<tr>' +
				   '<td><label class="control-label x100" style="font-weight: normal;" for="y_axis">Ｙ轴字段:</label></td>' +
				   '<td style="width: 29%;">' +
				   '<select id="y_axis" name="y_axis" data-toggle="selectpicker" data-width="200px" class="required" data-rule="required;">' +
				   '<option value="" selected>==选择字段==</option>' + Yaxisfields +
				   '</select>' +
				   '</td>' +
				   '<td><label class="control-label x100" style="font-weight: normal;" for="z_axis">&nbsp;</label></td>' +
				   '<td style="width: 34%;">&nbsp;</td>' +
				   '<td><label class="control-label x100" style="font-weight: normal;" for="z_axis">&nbsp;</label></td>' +
				   '<td style="width: 34%;">&nbsp;</td>' +
				   '</tr>';
		}
		else if ($.CurrentNavtab.find('#reporttype').val() != "")
		{
			html = '<tr>' +
				   '<td><label class="control-label x100" style="font-weight: normal;" for="x_axis">Ｘ轴字段:</label></td>' +
				   '<td style="width: 33%;">' +
				   '<select id="x_axis" name="x_axis" data-toggle="selectpicker" data-width="200px" class="required" data-rule="required;">' +
				   '<option value="" selected>==选择字段==</option>' + Xaxisfields +
				   '</select>' +
				   '</td>' +
				   '<td><label class="control-label x100" style="font-weight: normal;" for="y_axis">Ｙ轴字段:</label></td>' +
				   '<td style="width: 33%;">' +
				   '<select id="y_axis" name="y_axis" data-toggle="selectpicker" data-width="200px" class="required" data-rule="required;">' +
				   '<option value="" selected>==选择字段==</option>' + Yaxisfields +
				   '</select>' +
				   '</td>' +
				   '<td><label class="control-label x100" style="font-weight: normal;" for="z_axis">Ｚ轴字段:</label></td>' +
				   '<td style="width: 33%;">' +
				   '<select id="z_axis" name="z_axis" data-toggle="selectpicker" onchange="z_axisonchange();" data-width="200px">' +
				   '<option value="" selected>==选择字段==</option>' + Zaxisfields +
				   '</select>' +
				   '</td>' +
				   '</tr>';
		}
		$.CurrentNavtab.find("#report_x_y_x_table").html(html).initui();
	}
}

function z_axisonchange() {
	if ($.CurrentNavtab.find('#x_axis').val() == "" || $.CurrentNavtab.find('#y_axis').val() == ""){
		$(this).alertmsg("warn", "必须先选择Ｘ轴和Ｙ轴后才能选择Ｚ轴!", {autoClose: true, alertTimeout: 2000});
		$.CurrentNavtab.find('#z_axis').selectpicker('val',"");
		$.CurrentNavtab.find('#z_axis').selectpicker('render');
		return;
	}
}


function reportscategorysinfo(id,categorys,sequence) {
	var html ='' +
			  '<form id="ReportManagerCategorysForm" method="post" action="/index.php" data-toggle="validate" data-validator-option="{focusCleanup:true,timely:false}" data-alertmsg="false">' +
			  '<input type="hidden" id="module" name="module" value="Supplier_ReportSettings">' +
			  '<input type="hidden" id="action" name="action" value="ManagerCategorys">' +
			  '<input type="hidden" id="type" name="type" value="save">' +
			  '<input type="hidden" id="record" name="record" value="'+id+'">' +
			  '<div class="bjui-pageHeader">' +
			  '<button type="button" class="btn-default" data-icon="edit" onclick="addreportscategorys();">新建</button>&nbsp;' +
			  '<button type="submit" class="btn-default" data-icon="save">保存</button>&nbsp;' + ((id != '') ?
			  '<button type="button" class="btn-red" data-icon="trash-o" onclick="delreportscategorys(\''+id+'\');">删除</button>' : '') +
			  '</div>' +
			  '<div class="bjui-pageContent tableContent" style="top: 28px;">' +
			  '<div class="bjui-pageContent" style="overflow: hidden;">' +
			  '<div class="form-group">' +
			  '<label class="control-label x120" for="categorys">分类名称：</label>' +
			  '<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;">' +
			  '<input id="categorys" class="required form-control" type="text" style="padding-right: 15px; width: 200px;" value="'+categorys+'" name="categorys" tabindex="1" size="20" maxlength="40" data-rule="required;">' +
			  '</span>' +
			  '</div>' +
			  '<div class="form-group">' +
			  '<label class="control-label x120" for="sequence">分类排序：</label>' +
			  '<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;">' +
			  '<input id="sequence" class="required form-control" type="text" style="padding-right: 15px; width: 200px;" value="'+sequence+'" name="sequence" tabindex="1" size="20" maxlength="40" data-rule="required;digits;">' +
			  '</span>' +
			  '</div>' +
			  '</div>' +
			  '</div>' +
			  '</form>';
	$.CurrentNavtab.find("#refresh_reportscategorysinfo_entries").html(html).initui();
}

function addreportscategorys() {
	reportscategorysinfo('','','100');
}

function delreportscategorys(id) {
	var ajaxurl = "index.php?module=Supplier_ReportSettings&action=ManagerCategorys&type=movesub&record=" + id;
	$(this).dialog({id: "ManagerCategorysDialog",height:"320", url: ajaxurl, title: "删除分类", mask: true, resizable: false, maxable: false});
}

function supplier_reportsettings_doauthorize_callback(group,args){
	var ids  = [];
	$.CurrentNavtab.find('input[type="checkbox"][name="ids"]:checked').each(function(){
		ids.push($(this).val())
	});
	var url = "index.php?module=Supplier_ReportSettings&action=ReportUser";
	$(this).ajaxUrl({url:url, callback:Supplier_reportsettings_doauthorize_return, type:"POST", data:{pid:args.id,record:ids.join(',')}, loadingmask:true})
}

function Supplier_reportsettings_doauthorize_return(json){
	var json = json.toObj();
	if (json.statusCode == 200){
		$.CurrentNavtab.find("#pagerForm").bjuiajax('ajaxDone', json).navtab('refresh');
	}else{
		$.CurrentNavtab.find("#pagerForm").bjuiajax('ajaxDone', json)
	}
}