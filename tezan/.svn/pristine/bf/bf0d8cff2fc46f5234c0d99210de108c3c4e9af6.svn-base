{if $MODE neq "ajax"}
<div id="dialog_div" >
{/if}


<script language="JavaScript" type="text/javascript" src="modules/{$MODULE}/{$MODULE}.js"></script>

{literal}
<style>
.image_button{background:url(/Public/css/zTreeStyle/img/zTree_diy.png);display:inline-block;width:16px;height:16px;}
.image_button_edit_disabled{background-position:16px 32px;}
.image_button_edit{background-position:16px 0;}
.image_button_delete_disabled{background-position:32px 32px;}
.image_button_delete{background-position:32px 0px;}
.listview a {
    color: #3C6196;;
    text-decoration: none;
}
.listview a:hover {
    color: #F7A02C;
    text-decoration: none;
}
#screenview font
{
  font-size:16px;
}

#dbgrid td
{
  font-size:18px;
  color: #000;
}
#dbgrid th
{
  font-size:18px;
}

#dbgrid{color:#484848;margin-top:3px;word-break: break-all;word-wrap:break-word;font-size:13px;border-spacing: 1px;}
#dbgrid td{padding:3px;}
.dbgrid_header{color:white;background-color:#4A4840;height:30px;}
.lvt {
	background-color:#c4cfd8;
	border:0px solid #cce; 
}
</style>
{/literal}
<div id="demo" style="overflow:hidden; width:100%; height:200px;">
<div id="demo1">
	<div>
		<table id="dbgrid" class="lvt" width="100%" cellspacing="1" cellpadding="3" border="0" >
			<tr class="dbgrid_header">			
				{foreach name="listviewforeach" item=header key=key from=$LISTHEADER}	
					<th align="center" width="{$header.width}%" >{$header.label}</th>
				{/foreach}
			</tr>
			<tbody>
			{foreach name="listviewentity" item=entity key=entity_id from=$LISTENTITY}
				<tr bgcolor={cycle values="#FFFFFF,#EEEEEE"} style="color:{$entity.color}" >				
				{foreach item=data key=key from=$entity} 
					{foreach name="listviewforeach" item=header key=headkey from=$LISTHEADER}					 			
						{if $smarty.foreach.listviewforeach.iteration eq $key+1 && $key != "color" }				
							<td align="{$header.align}" class="listview" >{$data}</td>
						{/if}
					{/foreach}
				{/foreach}	        
				</tr>		
			{/foreach}
				
			</tbody>
		</table>	
	</div>
</div>
<div id="demo2"></div> 
</div>
{literal}
<script language="javascript">
var interval_id = window.setInterval("", 9999); 
for (var i = 1; i < interval_id; i++)
{
        window.clearInterval(i);
}
var height = jQuery(window).height();
height = jQuery(".dialogContent").height();
var speed=60
function Marquee()
{
	if (typeof $("#demo2") != "undefined" && typeof $("#demo") != "undefined")
	{
		if ($("#demo2").offset() != null && $("#demo").offset() != null)
		{
			var dif =  $("#demo2").offset().top - $("#demo").offset().top ;
			if(dif <=0 )
			{
				var offset = $("#demo").scrollTop() -  $("#demo1").offset().height;
				$("#demo").scrollTop(offset);
				$("#scrolltop").val(offset);
			}
			else
			{
				var offset = $("#demo").scrollTop()+2;
				$("#demo").scrollTop(offset);
			}
		}
	}
}
{/literal}

if ({$NOOFROWS} * 50 > height)
{ldelim}
	$("#demo2").html($("#demo1").html());
	var MyMar=setInterval(Marquee,speed)
	demo.onmouseover=function() {ldelim}clearInterval(MyMar){rdelim}
	demo.onmouseout=function() {ldelim}MyMar=setInterval(Marquee,speed){rdelim}
{rdelim}



function refreshvehicleactivityinfo()
{ldelim}
	if (jQuery("#dialog_div").html() != null)
	{ldelim}
		jQuery("[id=progressBar]").addClass("hidden");
		var postBody = "index.php?module={$MODULE}&action={$ACTION}&mode=ajax";		
		jQuery("#dialog_div").loadUrl(postBody);
		jQuery("[id=progressBar]").removeClass("hidden");
	{rdelim}
{rdelim}

setTimeout('refreshvehicleactivityinfo();',180000);



function marquee_dialog_onsize()
{ldelim}
	if (jQuery("#dialog_div").html() != null)
	{ldelim}
		var height = jQuery(".dialogContent").height();	
		$("#demo").css("height",height-57);
		setTimeout('marquee_dialog_onsize();',1000);	
	{rdelim}
{rdelim}

setTimeout('marquee_dialog_onsize();',500);


</script> 

<div class="formBar" style="height:60px;" >
	<ul style="float:left;width:100%;">	
	{$BARINFO}
	</ul>
</div>



{if $MODE neq "ajax"}
</div>
{/if}