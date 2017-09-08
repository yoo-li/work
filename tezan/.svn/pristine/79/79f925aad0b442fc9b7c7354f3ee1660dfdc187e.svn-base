function cadlinktarget_onchange(f2cadlinktarget)
{
    if (f2cadlinktarget == 0)
    {
        $.CurrentNavtab.find('#cid_productid').css("display","");
		$.CurrentNavtab.find('#cid_salesactivityid').css("display","none");
        $.CurrentNavtab.find('#cid_newsid').css("display","none");
		$.CurrentNavtab.find('#cid_otherlink').css("display","none");

		$.CurrentNavtab.find("#productid_name").removeAttr("novalidate");
		$.CurrentNavtab.find("#salesactivityid_id").val('');
		$.CurrentNavtab.find("#salesactivityid_name").val('');
		$.CurrentNavtab.find("#salesactivityid_name").attr("novalidate",true);
		$.CurrentNavtab.find("#newsid_id").val('');
		$.CurrentNavtab.find("#newsid_name").val('');
		$.CurrentNavtab.find("#newsid_name").attr("novalidate",true);

    }
    else if (f2cadlinktarget == 1)
    {
        $.CurrentNavtab.find('#cid_salesactivityid').css("display","");
  		$.CurrentNavtab.find('#cid_productid').css("display","none");
  		$.CurrentNavtab.find('#cid_newsid').css("display","none");
        $.CurrentNavtab.find('#cid_otherlink').css("display","none");

		$.CurrentNavtab.find("#salesactivityid_name").removeAttr("novalidate");
		$.CurrentNavtab.find("#productid_id").val('');
		$.CurrentNavtab.find("#sproductid_name").val('');
		$.CurrentNavtab.find("#productid_name").attr("novalidate",true);
		$.CurrentNavtab.find("#newsid_id").val('');
		$.CurrentNavtab.find("#newsid_name").val('');
		$.CurrentNavtab.find("#newsid_name").attr("novalidate",true);

    }
    else if (f2cadlinktarget == 2)
    {
        $.CurrentNavtab.find('#cid_newsid').css("display","");
		$.CurrentNavtab.find('#cid_salesactivityid').css("display","none");
		$.CurrentNavtab.find('#cid_productid').css("display","none");
        $.CurrentNavtab.find('#cid_otherlink').css("display","none");

		$.CurrentNavtab.find("#newsid_name").removeAttr("novalidate");
		$.CurrentNavtab.find("#productid_id").val('');
		$.CurrentNavtab.find("#sproductid_name").val('');
		$.CurrentNavtab.find("#productid_name").attr("novalidate",true);
		$.CurrentNavtab.find("#salesactivityid_id").val('');
		$.CurrentNavtab.find("#salesactivityid_name").val('');
		$.CurrentNavtab.find("#salesactivityid_name").attr("novalidate",true);
    }
    else
    {
        $.CurrentNavtab.find('#cid_newsid').css("display","none");
        $.CurrentNavtab.find('#cid_salesactivityid').css("display","none");
        $.CurrentNavtab.find('#cid_productid').css("display","none");
        $.CurrentNavtab.find('#cid_otherlink').css("display","");

        $.CurrentNavtab.find("#newsid_name").removeAttr("novalidate");
        $.CurrentNavtab.find("#productid_id").val('');
        $.CurrentNavtab.find("#sproductid_name").val('');
        $.CurrentNavtab.find("#productid_name").attr("novalidate",true);
        $.CurrentNavtab.find("#salesactivityid_id").val('');
        $.CurrentNavtab.find("#salesactivityid_name").val('');
        $.CurrentNavtab.find("#salesactivityid_name").attr("novalidate",true);
        $.CurrentNavtab.find("#newsid_id").val('');
        $.CurrentNavtab.find("#newsid_name").val('');
        $.CurrentNavtab.find("#newsid_name").attr("novalidate",true);
    }
}





$(function (){
    $.CurrentNavtab.find("input[name^='f2cadlinktarget']").on("ifChecked",function(){
		var f2cadlinktarget = $(this).val();
		cadlinktarget_onchange(f2cadlinktarget);
    });
	var f2cadlinktarget = $.CurrentNavtab.find('input[name=f2cadlinktarget]:checked').val();
    cadlinktarget_onchange(f2cadlinktarget);

});



function salesactivityid_callback(groupid,args)
{
	jQuery("#salesactivityid").val(args.id);
}
function newsid_callback(groupid,args)
{
	jQuery("#newsid").val(args.id);
}

function productid_callback(groupid,args)
{
	jQuery("#productid").val(args.id);
}
