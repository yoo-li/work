<?php


if (isset($_REQUEST['reportid']) && $_REQUEST['reportid'] != '')
{
    $reportid = $_REQUEST['reportid'];
}
else
{
    die();
}

 
$loadcontent = XN_Content::load($reportid,"ma_reportsettings");
$complex = $loadcontent->my->complex; 

global  $currentModule;
$configfile = $_SERVER['DOCUMENT_ROOT']."/modules/".$currentModule."/".$complex.".php";
if (@file_exists($configfile)) 
{
	global  $currentModule; 
	require_once('modules/'.$currentModule.'/'.$complex.'.php');
} 
else
{
	$display = '<center>没有找到'.$configfile.'的文件！</center>';  
	 echo '<style>
	 #warp
	 {
				  position: absolute;
				  width:700px;
				  height:200px;
				  left:50%;
				  top:40%;
				  margin-left:-350px;
				  margin-top:-100px;
	 }
						</style>
							<div id="warp">	
								<div class="panel panel-default" style="margin:2px;">
								    <div class="panel-heading"><h3 class="panel-title">提示信息</h3></div>
								    <div style="padding:10px;" class="panel-body bjui-doc">
										<div  class="collapse in"> 
											<div style="line-height:30px;">'.$display.'</div> 
										</div>
								    </div>
								</div>  
							</div>';
	die();
}
 
 
 