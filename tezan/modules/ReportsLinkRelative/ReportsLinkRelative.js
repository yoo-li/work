

function on_reportslinkrelative_changedate()
{					
	var startdate = jQuery.trim(jQuery("#reportslinkrelative_published_startdate").val());
    var enddate = jQuery.trim(jQuery("#reportslinkrelative_published_enddate").val());

	var startdatearray = startdate.split("-");
	var enddatearray = enddate.split("-");

	var start = new Date(startdatearray[0],startdatearray[1],startdatearray[2]);

	var end = new Date(enddatearray[0],enddatearray[1],enddatearray[2]);

    var t2 = start.getTime();
	var t1 = end.getTime();

	var days =  parseInt((t1-t2)/(24*3600*1000));
	
	if (days > 0 && days <= 7)
	{ 
		  $('#reportslinkrelative_relative_unit').find('[value=天]').prop('disabled', false);
		  $('#reportslinkrelative_relative_unit').find('[value=周]').prop('disabled', true);
		  $('#reportslinkrelative_relative_unit').find('[value=月]').prop('disabled', true);
		  $('#reportslinkrelative_relative_unit').find('[value=季]').prop('disabled', true);
		  $('#reportslinkrelative_relative_unit').find('[value=年]').prop('disabled', true);
		  $("#reportslinkrelative_relative_unit").val('天');
		  $('#reportslinkrelative_relative_unit').selectpicker('refresh');
	}
	else if (days > 7 && days <= 31)
	{ 
	  $('#reportslinkrelative_relative_unit').find('[value=天]').prop('disabled', false);
	  $('#reportslinkrelative_relative_unit').find('[value=周]').prop('disabled', false);
	  $('#reportslinkrelative_relative_unit').find('[value=月]').prop('disabled', true);
	  $('#reportslinkrelative_relative_unit').find('[value=季]').prop('disabled', true);
	  $('#reportslinkrelative_relative_unit').find('[value=年]').prop('disabled', true);
	  $("#reportslinkrelative_relative_unit").val('天');
	  $('#reportslinkrelative_relative_unit').selectpicker('refresh');
	}
	else if (days > 31 && days <= 120)
	{ 
  	  $('#reportslinkrelative_relative_unit').find('[value=天]').prop('disabled', true);
  	  $('#reportslinkrelative_relative_unit').find('[value=周]').prop('disabled', false);
  	  $('#reportslinkrelative_relative_unit').find('[value=月]').prop('disabled', false);
  	  $('#reportslinkrelative_relative_unit').find('[value=季]').prop('disabled', true);
  	  $('#reportslinkrelative_relative_unit').find('[value=年]').prop('disabled', true);
  	  $("#reportslinkrelative_relative_unit").val('周');
  	  $('#reportslinkrelative_relative_unit').selectpicker('refresh');
	}
	else if (days > 120 && days <= 365)
	{ 
    	  $('#reportslinkrelative_relative_unit').find('[value=天]').prop('disabled', true);
    	  $('#reportslinkrelative_relative_unit').find('[value=周]').prop('disabled', true);
    	  $('#reportslinkrelative_relative_unit').find('[value=月]').prop('disabled', false);
    	  $('#reportslinkrelative_relative_unit').find('[value=季]').prop('disabled', false);
    	  $('#reportslinkrelative_relative_unit').find('[value=年]').prop('disabled', true);
    	  $("#reportslinkrelative_relative_unit").val('月');
    	  $('#reportslinkrelative_relative_unit').selectpicker('refresh');
	}
	else if ( days > 365)
	{ 
	  	  $('#reportslinkrelative_relative_unit').find('[value=天]').prop('disabled', true);
	  	  $('#reportslinkrelative_relative_unit').find('[value=周]').prop('disabled', true);
	  	  $('#reportslinkrelative_relative_unit').find('[value=月]').prop('disabled', true);
	  	  $('#reportslinkrelative_relative_unit').find('[value=季]').prop('disabled', true);
	  	  $('#reportslinkrelative_relative_unit').find('[value=年]').prop('disabled', false);
	  	  $("#reportslinkrelative_relative_unit").val('年');
	  	  $('#reportslinkrelative_relative_unit').selectpicker('refresh');
	}
	else
	{
	      jQuery('#reportslinkrelative_relative_unit').empty();	
	}
}

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



$(document).ready(function () { 
	setTimeout("ajax_report_click();",500); 
	$("#reportslinkrelative_published_startdate").on('afterchange.bjui.datepicker', function(e, data) { on_reportslinkrelative_changedate(); });
	$("#reportslinkrelative_published_enddate").on('afterchange.bjui.datepicker', function(e, data) { on_reportslinkrelative_changedate(); });
});



 