function categorys_callback(groupid,args)
{
	jQuery("#categorys").val(args.id);
    jQuery.post("index.php?module=Mall_Products&action=ParameterConfig&categorys="+args.id,'',function(data){
        jQuery("#parameterconfig_form_div").html(data);
    })
}

function developer_callback(groupid,args)
{
	jQuery("#developer").val(args.id);
}

function imagemaker_callback(groupid,args)
{
    jQuery("#imagemaker").val(args.id);
}

function brand_callback(groupid,args)
{
    jQuery("#brand").val(args.id);
}
function suppliers_callback(groupid,args)
{
	jQuery("#suppliers").val(args.id);
	jQuery("input[type='radio'][name='product_type'][value='"+args.product_type+"']").attr("checked",true);
}

function ExpiredProducts(){
	var productname = $('#productname').val();
	$(this).alertmsg.confirm("确定将：<br>&nbsp;&nbsp;&nbsp;&nbsp;"+productname+"<br>做废处理？", {
		okCall: function(){
			var postBody = "module=Mall_Products&action=Save&savetype=expired&record="+$('#record').val()
			jQuery.post("index.php", postBody,
				function (data, textStatus)
				{
					data = eval('('+data+')');
					if(data.statusCode == 300){
						$(this).alertmsg("error",data.message);
					}else{
						navTab.reloadFlag(data.navTabId);
						navTab.closeCurrentTab(data.navTabId);
					}
				}
			);	
		}
	});
}


function applyModifyCategorys(obj){
	jQuery.pdialog.open("index.php?module=Mall_Products&action=ModifyCategorys&ids="+obj.ids,"ModifyCategorys","修改分类",{width:280,height:100,mask:true});
		// var postBody = 'module=Products&action=ModifyCategorys&opr=rejectcheck&ids='+ids;
		// 	jQuery.post("index.php", postBody,
		// 		function (data, textStatus)
		// 		{
		// 			if(data != ""){
		// 				$(this).alertmsg("error",data);
		// 			}else{
		// 						jQuery.pdialog.open("index.php?module=Products&action=ModifyCategorys&ids="+ids,"ModifyCategorys","修改分类",{width:280,height:100,mask:true});

		// 			}
			// });
}

function confirm_select_mall_products(obj){
    var ids="";
    var names="";
    var shop_price="";
    $(obj).parent().parent().parent().next().find("tbody>tr>td>div>input[name='ids']:checked").each(function(){
        ids+=$(this).val()+";";
             names+=$(this).parent().parent().parent().find("td.productname>div>a").text()+";";
        shop_price+=$(this).parent().parent().parent().find("td.shop_price>div>span").text()+";";
    })
    ids=ids.substr(0,ids.length-1);
    names=names.substr(0,names.length-1);
    shop_price=shop_price.substr(0,shop_price.length-1);
    $.bringBack({"id":ids,"Name":names,"Shop_Price":shop_price});
}
function closeCurrentDialogandFlushList(){
    jQuery.pdialog.closeCurrent();
    navTab.reload("index.php?module=Mall_Products&action=ListView",{title:"商品",fresh:false,mask:true, data:{} },"Products");
}
