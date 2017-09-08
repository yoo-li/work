function supplier_authorizemanage_doauthorize_callback(group,args){
	var ids  = [];
	$.CurrentNavtab.find('input[type="checkbox"][name="ids"]:checked').each(function(){
		ids.push($(this).val())
	});
	var url = "index.php?module=Supplier_AuthorizeManage&action=Save";
	$(this).ajaxUrl({url:url, callback:supplier_authorizemanage_doauthorize_return, type:"POST", data:{pid:args.id,pname:args.name,ids:ids.join(',')}, loadingmask:true})
}

function supplier_authorizemanage_doauthorize_return(json){
	var json = json.toObj();
	if (json.statusCode == 200){
		$.CurrentNavtab.find("#pagerForm").bjuiajax('ajaxDone', json).navtab('refresh');
	}else{
		$.CurrentNavtab.find("#pagerForm").bjuiajax('ajaxDone', json)
	}
}