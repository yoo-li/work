{if $HASAPPROVALS eq 'true' && $APPROVALID neq ''}
<link type="text/css" href="/Public/Jit/css/base.css" rel="stylesheet" />
<link type="text/css" href="/Public/Jit/css/Spacetree.css" rel="stylesheet" />
<!--[if IE]><script language="javascript" type="text/javascript" src="/Public/Jit/Extras/excanvas.js"></script><![endif]--> 
<script language="javascript" type="text/javascript" src="/Public/Jit/js/jit-yc.js"></script> 
<script language="javascript" type="text/javascript" src="/Public/Jit/js/jit-init.js"></script>


<div class="panel panel-default" style="margin:2px;">
	 <div class="panel-heading"><h3 class="panel-title">{'LBL_APPROVALSTRANSFERSTEP'|@getTranslatedString}<a style="float:right;cursor:pointer;text-decoration: none;font-size:17px;"  data-toggle="collapse" data-target="#approvalstransferstep_form_div"><i class="fa btn-default fa-caret-square-o-up"></i><i class="fa btn-default fa-caret-square-o-down"></i></a> </h3></div>
	 <div style="padding:0;" class="panel-body bjui-doc">
		<div id="approvalstransferstep_form_div" class="collapse in">  
			   <div id="jit" style="height:1px;min-height:1px;"> 
			   		<div id="center-container">
			   	    	<div id="infovis"></div>    
			   		</div>  
			       <div id="log"></div>
			   </div> 
		</div>
	 </div>
</div>


<script language="JavaScript">
 
$(document).ready(function()
{ldelim} 
    $.ajax({ldelim}
        url: 'index.php',
        type: 'post',
        data: 'module=Approvals&action=transferstep&record={$APPROVALID}&formodule={$MODULE}', 
        success: function(json)
		{ldelim}
			var jsondata = eval("("+json+")"); 
		     if (jsondata.statusCode == 200)
			{ldelim}
			 	$("#jit").css("height","120px");
				$("#jit").css("min-height","120px");
				jit_init(jsondata.data,jsondata.selectnode);
			{rdelim}
        {rdelim}
    {rdelim}); 
{rdelim}); 
</script>
{/if}

