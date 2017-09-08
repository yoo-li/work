$(function () {
	$.CurrentNavtab.find('.authenticationtype').on('ifChanged',function(e){
		var authenticationtype = $('input[name=authenticationtype]:checked').val();
		if (authenticationtype && authenticationtype != "")
		{
			if (authenticationtype == "2")
			{
				$.CurrentNavtab.find('#cid_shopname').css("display","none");
				$.CurrentNavtab.find('#shopname').removeClass("required");
				$.CurrentNavtab.find('#salesEditViewForm').validator("setField", "shopname", "");
			}
			else
			{
				$.CurrentNavtab.find('#cid_shopname').css("display","");
				$.CurrentNavtab.find('#shopname').addClass("required");
				$.CurrentNavtab.find('#salesEditViewForm').validator("setField", "shopname", "required;");
			} 
		} 
    }); 
	
	var authenticationtype = $('input[name=authenticationtype]:checked').val();
	if (authenticationtype && authenticationtype != "")
	{
		if (authenticationtype == "2")
		{
			$.CurrentNavtab.find('#cid_shopname').css("display","none");
			$.CurrentNavtab.find('#shopname').removeClass("required");
			$.CurrentNavtab.find('#salesEditViewForm').validator("setField", "shopname", "");
		}
		else
		{
			$.CurrentNavtab.find('#cid_shopname').css("display","");
			$.CurrentNavtab.find('#shopname').addClass("required");
			$.CurrentNavtab.find('#salesEditViewForm').validator("setField", "shopname", "required;");
		}  
	}  
})