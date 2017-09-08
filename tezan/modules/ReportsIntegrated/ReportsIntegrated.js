

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
    $('a[for="reportsintegrated_published_period"]').each(function () {
        $(this).click(reportsintegrated_published_period_onclick);
    }); 
});






$("#reportsintegrated_published_startdate").on("afterchange.bjui.datepicker", function (e, data) {
    $("#reportsintegrated_published_thistype").val("custom");
    $('a[for="reportsintegrated_published_period"]').toggleClass("over", false);
});
$("#reportsintegrated_published_enddate").on("afterchange.bjui.datepicker", function (e, data) {
    $("#reportsintegrated_published_thistype").val("custom");
    $('a[for="reportsintegrated_published_period"]').toggleClass("over", false);
});
function reportsintegrated_published_period_onclick() {
    $('a[for="reportsintegrated_published_period"]').toggleClass("over", false);
    $(this).addClass("over");
    var dt = new Date();
    if ($(this).attr("id") == "reportsintegrated_published_all") {
        var start = "";
        var end = "";
        $("#reportsintegrated_published_thistype").val("all");
    } else if ($(this).attr("id") == "reportsintegrated_published_thisyear") {
        var start = dt.getFullYear() + "-01-01";
        var end = dt.getFullYear() + "-12-31";
        $("#reportsintegrated_published_thistype").val("thisyear");
    }
    else if ($(this).attr("id") == "reportsintegrated_published_thisquater") {
        var nowMonth = dt.getMonth() + 1;
        if (nowMonth <= 3) {
            var start = dt.getFullYear() + "-01-01";
            var end = dt.getFullYear() + "-03-31";
        }
        else if (3 < nowMonth && nowMonth < 7) {
            var start = dt.getFullYear() + "-04-01";
            var end = dt.getFullYear() + "-06-30";
        }
        else if (6 < nowMonth && nowMonth < 10) {
            var start = dt.getFullYear() + "-07-01";
            var end = dt.getFullYear() + "-09-30";
        }
        else {
            var start = dt.getFullYear() + "-10-01";
            var end = dt.getFullYear() + "-12-31";
        }
        $("#reportsintegrated_published_thistype").val("thisquater");
    }
    else if ($(this).attr("id") == "reportsintegrated_published_recently") {
        var nowMonth = dt.getMonth() + 1;
        if (nowMonth < 10) {
            nowMonth = "0" + nowMonth;
        }
        var nowDay = dt.getDate();
        if (nowDay < 10) {
            nowDay = "0" + nowDay;
        } 
		 
        var end = dt.getFullYear() + "-" + nowMonth + "-"  + nowDay;  
		
		dt.setMonth(dt.getMonth()-1);
        var lastMonth = dt.getMonth() + 1;
        if (lastMonth < 10) {
            lastMonth = "0" + lastMonth;
        } 
        var start = dt.getFullYear() + "-" + lastMonth + "-"  + nowDay;  
        $("#reportsintegrated_published_thistype").val("recently");
    }
    else {
        var nowMonth = dt.getMonth() + 1;
        if (nowMonth < 10) {
            nowMonth = "0" + nowMonth;
        }
        var nowDay = dt.getDate();
        if (nowDay < 10) {
            nowDay = "0" + nowDay;
        }
        var start = dt.getFullYear() + "-" + nowMonth + "-01";
        var end = dt.getFullYear() + "-" + nowMonth + "-" + nowDay;
        $("#reportsintegrated_published_thistype").val("thismonth");
    }
    $("#reportsintegrated_published_startdate").val(start);
    $("#reportsintegrated_published_enddate").val(end);
}