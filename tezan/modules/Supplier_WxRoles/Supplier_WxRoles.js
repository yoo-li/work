function wxid_callback(groupid,args)
{
			jQuery("#wxid").val(args.id); 	
}

function wxroletype_onchange() 
{
	    var wxtype = $('input[name=wxroletype]:checked').val();
		if (wxtype && wxtype != "")
		{
			if (wxtype == "1")
			{
				$.CurrentNavtab.find('#cid_replytitle').css("display","none");
				$.CurrentNavtab.find('#cid_image').css("display","none");
				$.CurrentNavtab.find('#replytitle').removeClass("required");
				$.CurrentNavtab.find('#salesEditViewForm').validator("setField", "replytitle", "");
				
				$.CurrentNavtab.find('#image_plupload_div').find('.form-control').removeClass("required");
				$.CurrentNavtab.find('#salesEditViewForm').validator("setField", "image_plupload_required", "");
			}
			else
			{
				$.CurrentNavtab.find('#cid_replytitle').css("display","");
				$.CurrentNavtab.find('#cid_image').css("display","");
				$.CurrentNavtab.find('#replytitle').addClass("required");
				$.CurrentNavtab.find('#salesEditViewForm').validator("setField", "replytitle", "required;");
				
				$.CurrentNavtab.find('#image_plupload_div').find('.form-control').addClass("required");
				$.CurrentNavtab.find('#salesEditViewForm').validator("setField", "image_plupload_required", "required;");
			} 
		} 
}
$(function () {
	$.CurrentNavtab.find('.wxroletype').on('ifChanged',function(e){
		wxroletype_onchange();
    });  
	
	setTimeout("wxroletype_onchange();",100); 
})
 