function myinvoiceprint(record)
{
	if (selectprinter != "" && selectprinter != undefined)
	{
		var urlstring = 'module=Mall_Orders&action=MyInvoicePrint&record='+record;
		jQuery.post("index.php", urlstring,
			function (printer_data, textStatus)
			{
				if (printer_data != "")
				{
					//alert(printer_data);
					print_direct(printer_data,selectprinter);
				}
				
			});  
	}
	else
	{
		$(this).alertmsg("error","无法获得面单打印机配置!"); 
	} 
}

function print_direct(print_text, printer_name)
{
	try{   
		var printer = require("printer");
		printer.printDirect({data: new Buffer(print_text), 
			printer:printer_name, 
			type: "RAW", 
			success:function(){
				console.log("printed ok");
			}, 
			error:function(err){
				console.log("printed error code 1");
				console.log(err);
			}
		});
	}   
	catch(e){   
		console.log("printed error code 0");
	    console.log(e);
	}  
} 


function changearea(value,type,select) {
	var urlstring = 'parent='+type+'&value='+value;
	jQuery.post("geturbanareas.php", urlstring,
	function (data, textStatus)
	{
		result = eval('(' + data + ')');
		switch(type) {
			case 'country':
				$("#province").html("<option value='--None--'>-- 无 --</option>");
				$("#city").html("<option value='--None--'>-- 无 --</option>");
				$("#district").html("<option value='--None--'>-- 无 --</option>");
				for(var i=1;i<=result.options.length;i++) {
					if (result.options[i-1] == select){
						jQuery("#province").append(new Option(result.options[i-1],result.options[i-1]));
						jQuery("#province").val(result.options[i-1]);
					}else if(result.options[i-1] == result.selected){
						jQuery("#province").append(new Option(result.options[i-1],result.options[i-1]));
						jQuery("#province").val(result.options[i-1]);
					}else
						jQuery("#province").append(new Option(result.options[i-1],result.options[i-1]));
				}
				if (typeof(jQuery('#zipcode')) != 'undefined') jQuery('#zipcode').val(result.zipcode);
				changearea(result.selected,'province');
				break;
			case 'province':
				$("#city").html("<option value='--None--'>-- 无 --</option>");
				$("#district").html("<option value='--None--'>-- 无 --</option>");
				for(var i=1;i<=result.options.length;i++) {
					if (result.options[i-1] == select){
						jQuery("#city").append(new Option(result.options[i-1],result.options[i-1]));
						jQuery("#city").val(result.options[i-1]);
					}else if(result.options[i-1] == result.selected){
						jQuery("#city").append(new Option(result.options[i-1],result.options[i-1]));
						jQuery("#city").val(result.options[i-1]);
					}else
						jQuery("#city").append(new Option(result.options[i-1],result.options[i-1]));										
				}
				if (typeof(jQuery('#zipcode')) != 'undefined') jQuery('#zipcode').val(result.zipcode);
				changearea(result.selected,'city');
				break;
			case 'city':
				$("#district").html("<option value='--None--'>-- 无 --</option>");
				for(var i=1;i<=result.options.length;i++) {
					if (result.options[i-1] == select){
						jQuery("#district").append(new Option(result.options[i-1],result.options[i-1]));
						jQuery("#district").val(result.options[i-1]);
					}else if(result.options[i-1] == result.selected){
						jQuery("#district").append(new Option(result.options[i-1],result.options[i-1]));
						jQuery("#district").val(result.options[i-1]);
					}else
						jQuery("#district").append(new Option(result.options[i-1],result.options[i-1]));
				}
				if (typeof(jQuery('#zipcode')) != 'undefined') jQuery('#zipcode').val(result.zipcode);
				changearea(result.selected,'district');
				break;
			case 'district':
				if (typeof(jQuery('#zipcode')) != 'undefined') jQuery('#zipcode').val(result.zipcode);
				break;
		}
	});	
}


function ordersproducts_callback(grid,args){
	var id = grid.substring(8,grid.length);
	jQuery("#price"+id).val(args.shop_price);
	var postBody = 'module=Mall_Inventorys&action=InventorysAjax&file=getinventory&pid='+args.id;
	jQuery.post("index.php", postBody,
		function (data, textStatus)
		{
			alert(data);
			//jQuery("#inventory"+id).val(data);
			//jQuery("#inventory_label"+id).html(data);
		});	
}

function delivery_callback(grid,args){
	jQuery("#delivery").val(args.id);
}

function SheetExportExcel(obj){
	var URL = "index.php?module=Mall_Orders&action=SheetExportExcel&ids="+encodeURIComponent(obj.ids);
	setTimeout('downExcel("'+URL+'");',1500);
	$(this).alertmsg("warn",'正在处理数据，导出后点击“确定”关闭窗口');
}
function specialSheetExportExcel(obj){
    var URL = "index.php?module=Mall_Orders&action=specialSheetExportExcel&ids="+encodeURIComponent(obj.ids);
    setTimeout('downExcel("'+URL+'");',1500);
    $(this).alertmsg("warn",'正在处理数据，导出后点击“确定”关闭窗口');
}
function downExcel(url){
	location.href = url;
}

function CompulsionOrders(){
	$(this).alertmsg.confirm("确定要强制退货处理吗？强退后无法撤消！", {
		okCall: function(){
			var postBody = "module=Mall_Orders&action=compulsion&orderid="+$('#record').val()
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
