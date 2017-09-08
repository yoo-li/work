function wxid_callback(groupid,args)
{
			jQuery("#wxid").val(args.id); 	
}



 
	if (typeof(jQuery('#wxroletype_1').val()) != 'undefined')
	{
	    var wxroletype = $('input[id="wxroletype_1"]:checked').val();
		jQuery("[name=wxroletype]").attr("onchange","wxroletype_onchange();");
		jQuery("#wxroletype_1").change(wxroletype_onchange); 
		jQuery("#wxroletype_2").change(wxroletype_onchange);
		wxroletype_onchange();
	}
	
 


function wxroletype_onchange() 
{
		var wxroletype = $('input[name=wxroletype]:checked').val();
		if (wxroletype == "1")
		{
			jQuery('#cid_replytitle').css("display","none");
			jQuery('#cid_image').css("display","none"); 
		}
		else
		{
			jQuery('#cid_replytitle').css("display","");
			jQuery('#cid_image').css("display",""); 
		}
	 	

	 	
}