function authorizedimensionid_callback(groupid,args)
{
	jQuery("#authorizedimensionid").val(args.id);   
	var record = $.CurrentNavtab.find("#record").val(); 
    $.post("index.php?module=Mall_OfficialAuthorizeEvents&action=WriteAuthorizeDimensions&record="+record+"&authorizedimensionid="+args.id,"",function(data){
        
		var postBody = "index.php?module=Mall_OfficialAuthorizeEvents&action=AuthorizeEventsDimensions&record="+record+"&mode=ajax&readonly=false"+params;
		$("#authorizeeventsdimensions_form_div").loadUrl(postBody);   
        
    });
}