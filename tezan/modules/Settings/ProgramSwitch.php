<?php
require_once('include/utils/CommonUtils.php');

require ($_SERVER['DOCUMENT_ROOT'].'/admin/config.program.php'); 




if(isset($_REQUEST['mode']) && $_REQUEST['mode'] == 'ajax' &&
   isset($_REQUEST['name']) && $_REQUEST['name'] != '' &&
   isset($_REQUEST['enable']) && $_REQUEST['enable'] != '')
{
	$results = XN_Query::create ( 'Content' )->tag ( 'programs' )
				->filter ( 'type', 'eic', 'programs' ) 
				->filter ( 'my.name', '=', $_REQUEST['name'] ) 
				->execute ();
	if (count($results) > 0)
	{
		 $program_info = $results[0];
		 $program_info->my->status = $_REQUEST['enable'];
		 $program_info->save("programs");	 
	}
	else
	{		
		$newcontent = XN_Content::create('programs','',false);					  
		$newcontent->my->name  = $_REQUEST['name'];
		$newcontent->my->status  = $_REQUEST['enable'];
		$newcontent->save("programs");	
	}
	$key = $_REQUEST['name'];
	$tabids = $programs[$key]['tabid'];
	$parenttabs = $programs[$key]['parenttab'];
	$enable = $_REQUEST['enable'];

	if (count($parenttabs) > 0)
	{
		$parenttabs = XN_Query::create ( 'Content' )->tag ( 'parenttabs' )
				->filter ( 'type', 'eic', 'parenttabs' )
				->filter ( 'my.parenttabname', 'in', $parenttabs )
				->filter ( 'my.presence', '!=', $enable)
				->execute ();
		if (count($parenttabs) >0)
		{
			foreach($parenttabs as $parenttab_info)
			{
				$parenttab_info->my->presence = $enable;
				$parenttab_info->save('parenttabs');
			}
			
		}
	}
	if (count($tabids) > 0)
	{
		$tabs = XN_Query::create ( 'Content' )->tag ( 'tabs' )
				->filter ( 'type', 'eic', 'tabs' )
				->filter ( 'my.tabid', 'in', $tabids )
				->filter ( 'my.presence', '!=', $enable)
				->end(-1)
				->execute ();
		if (count($tabs) >0)
		{
			foreach($tabs as $tab_info)
			{
				$tab_info->my->presence = $enable;
				$tab_info->save('tabs');
			}			
		}
	}
	XN_MemCache::delete("session_".XN_Application::$CURRENT_URL);
}

$results = XN_Query::create ( 'Content' )->tag ( 'programs' )
				->filter ( 'type', 'eic', 'programs' ) 
				->filter ( 'my.status', '=', '0' ) 
				->execute ();
if (count($results) >0)
{
	foreach($results as $program_info)
	{
		$key = $program_info->my->name;
		if (isset($programs[$key]) && $programs[$key] != "")
		{
			$programs[$key]["status"] = "0";
		} 
	}
}	


if(!isset($_REQUEST['mode']) || $_REQUEST['mode'] != 'ajax')
{
	echo '
	<style>
	.bjui-doc .page-header { border-bottom-color: #ccc;  margin-top: 0; }
	.bjui-doc blockquote.point {
	  border-left-color: #ff6600;
	}
	.bjui-doc blockquote {
	  border-bottom: 1px solid #eee;
	  border-radius: 5px;
	  border-right: 1px solid #eee;
	  border-top: 1px solid #eee;
	  padding: 5px 15px;
	}
	.bjui-doc blockquote span {width:300px;text-align:right;valign:middle;display:inline-block;padding-right:5px;}
	.bjui-doc blockquote i {}
 
	</style>
	<script type="text/javascript">
	function programswitch(name, enable_disable) 
	{   
			var postBody = "index.php?module=Settings&action=ProgramSwitch&name=" + encodeURIComponent(name) + "&enable=" + enable_disable + "&mode=ajax" ;
			 $(this).bjuiajax("doLoad", {url:postBody, target:"#programswitch",loadingmask:true});
			//jQuery("#programswitch").loadUrl(postBody);
	}
	</script>
		<div class="bjui-pageContent">
	    <div class="bjui-doc">
	        <h4 class="page-header">请选择系统功能</h4>
			<blockquote class="point" id="programswitch">';
}

$html = "";
foreach($programs as $key => $program_info)
{
	if ($program_info["status"] == "0")
	{
		$html .= "<p><span>".$program_info["label"]."：</span><a href='javascript:void(0);' onclick=\"programswitch('".$key."', '1');\"><i class='fa fa-toggle-on'></i></a></p>";
	}
	else
	{
		$html .= "<p><span>".$program_info["label"]."：</span><a href='javascript:void(0);' onclick=\"programswitch('".$key."', '0');\"><i class='fa fa-toggle-off'></i></a></p>";
	}
}

echo $html;

 /* 
echo '<script type="text/javascript">
function programswitch(name, enable_disable) {  
		var postBody = "index.php?module=Settings&action=ProgramSwitch&name=" + encodeURIComponent(name) + "&enable=" + enable_disable + "&mode=ajax" ;
		jQuery("#programswitch").loadUrl(postBody);}
</script>
<div>
<table border=0 cellspacing=0 cellpadding=0 width=99% align=center >
     <tr>      
	<td class="showPanelBg" valign="top" align="center" width=100%>
	<table cellspacing="0" cellpadding="0" width="98%" border="0">
	<tr>
		<td align="left">
			    <div align=center>						
					<style> 
					<!--						
						.tabcontainer
						{
							border:1px solid #bcb7a0;
						}
					--> 
					</style>					
					<br>	
					<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tabcontainer">					
					<tr>
					<td>		
						<table border=0 cellspacing=5 cellpadding=5 width=750 style="border-spacing: 10px 10px;">'
							.$html.'
						</table>
					</td>
					</tr>
					</table>
	</div>
	</td></tr></table>
     </td>     
   </tr>
</table>
</div>';*/
 
 

if(!isset($_REQUEST['mode']) || $_REQUEST['mode'] != 'ajax')
{
	echo '</blockquote>
    </div>
</div>
<div class="bjui-pageFooter">
    <ul>
        <li><button type="button" class="btn-close" data-icon="close">关闭</button></li>
    </ul>
</div>';
}

?>