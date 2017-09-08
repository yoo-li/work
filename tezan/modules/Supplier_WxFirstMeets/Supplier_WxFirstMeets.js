function wxid_callback(groupid,args)
{
			jQuery("#wxid").val(args.id); 	
}

$(document).ready(function(){	
	
	if (typeof(jQuery('#wxchanneltype_1').val()) != 'undefined')
	{
		jQuery("[name=wxchanneltype]").attr("onchange","changewxchanneltype();");
	}
   
    changewxchanneltype();
	
});

function changewxchanneltype() 
{
    var wxchanneltype = $('input[name="wxchanneltype"]:checked').val();
 
    if (wxchanneltype == "1")
    {
		//jQuery("[id=wxexpiredays]").attr("disabled",false); 
		jQuery("#wxexpiredays").attr("onchange","");
	}  	
	else
	{
		//jQuery("[id=wxexpiredays]").attr("disabled",true); 
		jQuery("#wxexpiredays").attr("onchange","this.selectedIndex=0;");
		jQuery("#wxexpiredays").val("0");
		
	}
}

