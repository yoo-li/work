
 

function getPostParams(){
	var paramstr = "";
	$.CurrentNavtab.find("#pagerForm").find("input").each(function(e,obj){
		if(paramstr == ""){
			paramstr = $(obj).attr("name") + "=" + $(obj).val();
		}else{
			paramstr += "&"+$(obj).attr("name") + "=" + $(obj).val();
		}
	});
	$.CurrentNavtab.find("#pagerForm").find("select").each(function(e,obj){
		if(paramstr == ""){
			paramstr = $(obj).attr("name") + "=" + $(obj).val();
		}else{
			paramstr += "&"+$(obj).attr("name") + "=" + $(obj).val();
		}
	});
	return paramstr;
}
function ajax_report_click(){
	if($.CurrentNavtab.find("#refresh_report_entries")){
		var paramstr = getPostParams();
		var postBody = "index.php?mode=ajax&"+paramstr;
		$.CurrentNavtab.find("#refresh_report_entries").ajaxUrl({url:postBody, loadingmask:true})
	}
}

function reportssamerelative_relative_type_onchange(obj) 
{
	var relative_type = jQuery.trim(jQuery("#reportssamerelative_relative_type").val());  
	switch(relative_type)
	{
		case "0"://本年与去年
	      	  $('#reportssamerelative_relative_unit').find('[value=天]').prop('disabled', true);
	      	  $('#reportssamerelative_relative_unit').find('[value=周]').prop('disabled', true);
	      	  $('#reportssamerelative_relative_unit').find('[value=月]').prop('disabled', false);
	      	  $('#reportssamerelative_relative_unit').find('[value=季]').prop('disabled', false); 
	      	  $("#reportssamerelative_relative_unit").val('月');
	      	  $('#reportssamerelative_relative_unit').selectpicker('refresh'); 
		break;
	    case "1"://本季与上季
	    	  $('#reportssamerelative_relative_unit').find('[value=天]').prop('disabled', true);
	    	  $('#reportssamerelative_relative_unit').find('[value=周]').prop('disabled', false);
	    	  $('#reportssamerelative_relative_unit').find('[value=月]').prop('disabled', false);
	    	  $('#reportssamerelative_relative_unit').find('[value=季]').prop('disabled', true); 
	    	  $("#reportssamerelative_relative_unit").val('月');
	    	  $('#reportssamerelative_relative_unit').selectpicker('refresh');  
		break;
		case "2"://本月与上月
	      	  $('#reportssamerelative_relative_unit').find('[value=天]').prop('disabled', false);
	      	  $('#reportssamerelative_relative_unit').find('[value=周]').prop('disabled', false);
	      	  $('#reportssamerelative_relative_unit').find('[value=月]').prop('disabled', true);
	      	  $('#reportssamerelative_relative_unit').find('[value=季]').prop('disabled', true); 
	      	  $("#reportssamerelative_relative_unit").val('天');
	      	  $('#reportssamerelative_relative_unit').selectpicker('refresh');  
		break;
		case "3"://本周与上周
        	  $('#reportssamerelative_relative_unit').find('[value=天]').prop('disabled', false);
        	  $('#reportssamerelative_relative_unit').find('[value=周]').prop('disabled', true);
        	  $('#reportssamerelative_relative_unit').find('[value=月]').prop('disabled', true);
        	  $('#reportssamerelative_relative_unit').find('[value=季]').prop('disabled', true); 
        	  $("#reportssamerelative_relative_unit").val('天');
        	  $('#reportssamerelative_relative_unit').selectpicker('refresh');  
		break;
	}							
}

$(document).ready(function () { 
	setTimeout("ajax_report_click();",500);  
	$("#reportssamerelative_relative_type").on('change', function(e, data) { reportssamerelative_relative_type_onchange(); });
	
});



 