<?php

require_once('include/utils/UserInfoUtil.php');
require_once('include/utils/CommonUtils.php');


$idlist = $_REQUEST['ids'];
$module = $_REQUEST['module'];

//split the string and store in an array
$storearray = explode(",",trim($idlist,','));
array_filter($storearray);
global $global_user_privileges;
$is_admin = $global_user_privileges["is_admin"];
try {
    $loadcontents = XN_Content::loadMany($storearray,strtolower($module));
    foreach($loadcontents as $loadcontent_info)
    {
        $status = strtolower($module)."status";
       
        $approvalstatus  = $loadcontent_info->my->approvalstatus;
        $modulestatus = $loadcontent_info->my->$status;

        if ($modulestatus == 'Archive')
        {
            $errormsg .= getTranslatedFormatString('LBL_MODULESTATUSERRORMSG',$module,array($loadcontent_info->id,getTranslatedString($modulestatus,$module))).'<br/>';
        }
        else if ($modulestatus == 'Submited') {
            $errormsg .= getTranslatedFormatString('LBL_MODULESTATUSERRORMSG',$module,array($loadcontent_info->id,getTranslatedString($modulestatus,$module))).'<br/>';
        }
        else if ($modulestatus == 'Release') {
            $errormsg .= getTranslatedFormatString('LBL_MODULESTATUSERRORMSG',$module,array($loadcontent_info->id,getTranslatedString($modulestatus,$module))).'<br/>';
        }
        else if ($modulestatus == 'Terminate') {
            $errormsg .= getTranslatedFormatString('LBL_MODULESTATUSERRORMSG',$module,array($loadcontent_info->id,getTranslatedString($modulestatus,$module))).'<br/>';
        }
        else if ($loadcontent_info->author != XN_Profile::$VIEWER)
        {
            $errormsg .= getTranslatedFormatString('LBL_DELETEDAUTHORERRORMSG',$module,array($loadcontent_info->id)).'<br/>';
        }
        else if ($approvalstatus == 1 || $approvalstatus == 2 || $approvalstatus == 4)
        {
            $errormsg .= getTranslatedFormatString('LBL_APPROVALSTATUSERRORMSG',$module,array($loadcontent_info->id)).'<br/>';
        }
        else if($is_admin == true || $loadcontent_info->author == XN_Profile::$VIEWER)
        {

        }

    }
}
catch(XN_Exception $e)
{
    echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
    die();
}

try {
    $loadcontents = XN_Content::loadMany($storearray,strtolower($module));
    foreach($loadcontents as $loadcontent_info)
    {
        $status = strtolower($module)."status";
        $approvalstatus  = $loadcontent_info->my->approvalstatus;
        $modulestatus = $loadcontent_info->my->$status;
        if ($modulestatus == 'Archive')
        {
            $errormsg .= getTranslatedFormatString('LBL_MODULESTATUSERRORMSG','',array($loadcontent_info->id,getTranslatedString($modulestatus,$module))).'<br>';
        }
        else if ($loadcontent_info->contributorName != XN_Profile::$VIEWER)
        {
            $errormsg .= getTranslatedFormatString('LBL_DELETEDAUTHORERRORMSG','',array($loadcontent_info->id)).'<br>';
        }
        else if ($approvalstatus == 1 || $approvalstatus == 2  || $approvalstatus == 4)
        {
            $errormsg .= getTranslatedFormatString('LBL_APPROVALSTATUSERRORMSG','',array($loadcontent_info->id)).'<br>';
        }
        else if($is_admin == true || $loadcontent_info->author == XN_Profile::$VIEWER)
        {

        }
        else
        {
            
			global $global_session; 
			$tabdata  = $global_session['tabdata']; 
            $applicationname=$tabdata['applicationname'];
            $tab_info_array=$tabdata['tab_info_array'];
            $approvaltabs=$tabdata['approvaltabs'];
            $optionalapprovals=$tabdata['optionalapprovals'];
            $detailapprovals=$tabdata['detailapprovals'];
            $all_tabs_array=$tabdata['all_tabs_array'];
            $all_entity_tabs_array=$tabdata['all_entity_tabs_array'];
            $all_tablabels_array=$tabdata['all_tablabels_array'];
            $tab_label_array=$tabdata['tab_label_array'];
            $tab_quickcreate_array=$tabdata['tab_quickcreate_array'];
            $tab_seq_array=$tabdata['tab_seq_array'];
            $tab_ownedby_array=$tabdata['tab_ownedby_array'];
            $defaultOrgSharingPermission=$tabdata['defaultOrgSharingPermission'];
             
            $tabid = getTabid($module);

            $approvalrecords = approvalpermission($module);
            if (isset($defaultOrgSharingPermission))
            {
                $permission = $defaultOrgSharingPermission[$tabid];
                switch ($permission)
                {

                    case 2:
                        break;
                    case 3:
                    case 0:
                    case 1:
                    default:
                        $errormsg .= getTranslatedFormatString('LBL_PRIVATEORGSHARINGPERMISSIONERRORMSG','',array($loadcontent_info->id)).'<br>';
                        break;
                }
            }
            else
            {
                $errormsg = getTranslatedFormatString('LBL_ORGSHARINGPERMISSIONERRORMSG');
                break;
            }
        }

    }
}
catch(XN_Exception $e)
{
    $errormsg = 'Error:'.$e->getMessage();
}
if ($errormsg == "")
{
    foreach($storearray as $id)
    {
        if(isPermitted($module,'Delete',$id) == 'yes')
        {
            $focus = CRMEntity::getInstance($module);
            DeleteEntity($module,$module,$focus,$id,'');
        }
    }
    echo '{"statusCode":"200","message":"删除成功","tabid":"'.$module.'","callbackType":null,"forward":null}';
}
else
{
    echo '{"statusCode":"300","message":"'.$errormsg.'"}';
}
?>