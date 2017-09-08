function logisticpackage_print(record)
{
	if (selectprinter != "")
	{
		var urlstring = 'module=Mall_LogisticPackages&action=LogisticPackagePrint&record='+record;
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
		$(this).alertmsg("error",'无法获得面单打印机配置！');
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

function suppliers_callback(groupid,args)
{
	jQuery("#suppliers").val(args.id); 		
}