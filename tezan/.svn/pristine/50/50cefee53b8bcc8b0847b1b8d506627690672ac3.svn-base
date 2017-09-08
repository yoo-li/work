<?php


require_once('Smarty_setup.php');
require_once('include/utils/utils.php');

global  $currentModule;

 

if (isset($_REQUEST['profile_name']) && $_REQUEST['profile_name'] != "")
{
	try {
		$profile_name = $_REQUEST['profile_name'];
		$description = $_REQUEST['description'];

		$profileListResult = XN_Query::create('Content')
				->tag('Profiles')
				->filter('type','eic','Profiles')
				->filter('my.profilename','=',$profilename)
				->filter('my.deleted ','=','0')
				->execute();

        if(count($profileListResult) > 0)
        {
				echo '{"statusCode":"300","message":"'.$mod_strings['LBL_PROFILENAME_EXIST'].'"}';
                die;
        }
		echo '{"statusCode":200,"message":"'.$profile_name.'创建成功，但处理时间较长，请5分钟后查看创建详细权限！","tabid":"'.$currentModule.'","closeCurrent":true}';
		fast_finish_request();
		initprofilebyname($profile_name,$description);
						
		
	} catch ( XN_Exception $e ) 
	{
		 echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
	}			
	die();
}

function initprofilebyname($profile_name,$description)
{
	
	try
	{
	    

		$Administrator = XN_Content::create('profiles','',false);
		$Administrator->my->profilename  = $profile_name;
		$Administrator->my->description   = $description;
		$Administrator->my->globalactionpermission1  = 0;
		$Administrator->my->globalactionpermission2   = 0;
		$Administrator->my->allowdeleted = 1;
		$Administrator->my->deleted = 0; 
		$Administrator->save('profiles'); 

		$profileid = $Administrator->id;
	

		$tabs = XN_Query::create ( 'Content' )->tag('tabs')
						->filter ( 'type', 'eic', 'tabs' )
						->filter (XN_Filter::any(XN_Filter( 'my.isentitytype', '=', '1'),XN_Filter( 'my.isentitytype', '=', '2')))
						->order('my.tabsequence',XN_Order::DESC)
						->begin(0)->end(-1)					
						->execute ();

		foreach ($tabs as $tab_info)
		{
			$tabid = $tab_info->my->tabid;
			$module = $tab_info->my->tabname;
			init_profile($tabid,$module,$profileid);	
		}
		
	} catch ( XN_Exception $e ) {}
}

function init_profile($tabid,$module,$profileid)
{

       $objs = array();
	   $profile2tabs = XN_Query::create ( 'Content' )->tag('profile2tabs')
						->filter ( 'type', 'eic', 'profile2tabs' )
					    ->filter ( 'my.tabid', '=', $tabid )
					    ->filter ( 'my.profileid', '=', $profileid)
						->begin(0)->end(-1)	
						->execute ();
	   if (count($profile2tabs)  == 0)
	   {
		   $objs[] = XN_Content::create ( 'profile2tabs', '', false )
						->my->add ( 'tabid', $tabid )
						->my->add ( 'profileid', $profileid )
						->my->add ( 'permissions', '0' );
	   }
	   $profile2standardpermissions = XN_Query::create ( 'Content' )->tag('profile2standardpermissions')
						->filter ( 'type', 'eic', 'profile2standardpermissions' )
						->filter ( 'my.tabid', '=', $tabid )
					    ->filter ( 'my.profileid', '=', $profileid)
						->begin(0)->end(-1)	
						->execute ();
	   if (count($profile2standardpermissions)  == 0)
	   {
		   $permissions =  array ( 'EditView' => 0,  'Delete' => 0, 'Index' => 0,);
		   foreach ( $permissions as   $actionname => $permissions ){
					$objs[] = XN_Content::create ( 'profile2standardpermissions', '', false )
					->my->add ( 'tabid', $tabid )
					->my->add ( 'profileid', $profileid )
					->my->add ( 'actionname', $actionname )					
					->my->add ( 'permissions', $permissions );
			}	
	   }
		
		$fields = XN_Query::create ( 'Content' )->tag('fields')
					->filter ( 'type', 'eic', 'fields' )
					->filter ( 'my.tabid', '=',$tabid )
					->begin(0)->end(-1)	
					->execute ();
		 $fielddata = array();
		 foreach ($fields as $field_info)
		 {							
			$g_field_id = $field_info->my->fieldid;
			$fielddata[$g_field_id] = $field_info->my->fieldname;				 
		 }	

		if (isset($fielddata) && is_array($fielddata))
		{
			$profile2fields = XN_Query::create ( 'Content' )->tag('profile2fields')
							->filter ( 'type', 'eic', 'profile2fields' )
							->filter ( 'my.tabid', '=',$tabid )
							->filter ( 'my.profileid', '=', $profileid)
							->begin(0)->end(-1)	
							->execute ();
			$profile_2_fields = array();
			$profile_2_fieldids = array();
			foreach($profile2fields as $profile2field_info)
			{
				$profile_2_fields[] = $profile2field_info->my->fieldname;
				$profile_2_fieldids[] = $profile2field_info->my->fieldid;
			}
			

			if (count(array_intersect(array_values($fielddata),$profile_2_fields)) != count($fielddata) || count(array_intersect(array_keys($fielddata),$profile_2_fieldids)) != count($fielddata) || count($profile2fields) == 0)
			{

				XN_Content::delete($profile2fields,'profile2fields');

				foreach ($fielddata as $field_id => $field_v)
				{
					$objs[] = XN_Content::create ( 'profile2fields', '', false )
								->my->add ( 'tabid', $tabid )
								->my->add ( 'profileid', $profileid )
								->my->add ( 'fieldid', $field_id )
								->my->add ( 'fieldname', $field_v )
								->my->add ( 'visible', '0' )
								->my->add ( 'readonly', '1' );

				}
			}
		}


		$datafile = $_SERVER['DOCUMENT_ROOT'].'/modules/'.$module.'/config.inc.php';
		if (@file_exists($datafile))
		{
			   require($datafile);
			   if(isset($actionmapping) && count($actionmapping) > 0)
			   {	
				   $profile2utilitys = XN_Query::create ( 'Content' )->tag('profile2utilitys')
						->filter ( 'type', 'eic', 'profile2utilitys' )
						->filter ( 'my.tabid', '=',$tabid )
					    ->filter ( 'my.profileid', '=', $profileid)
						->execute ();
				    $profile_2_utilitys = array();
					foreach($profile2utilitys as $profile2utility_info)
					{
						$profile_2_utilitys[] = $profile2utility_info->my->activity;
					}
					$action_2_utilitys = array();
					foreach ($actionmapping as $actionmapping_info)
					{
						$action_2_utilitys[] = $actionmapping_info['actionname'];
					}
					if (count(array_intersect($action_2_utilitys,$profile_2_utilitys)) != count($action_2_utilitys))
				    {
						XN_Content::delete($profile2utilitys,'profile2utilitys');
						foreach ($actionmapping as $actionmapping_info)
						{
							$activity = $actionmapping_info['actionname'];
							$securitycheck = $actionmapping_info['securitycheck'];
							$type = $actionmapping_info['type'];
							if (($type == 'ajax' || $type == 'button' || $type == 'listview') && $securitycheck == '0')
							{
								$objs[] = XN_Content::create('profile2utilitys','',false)
									->my->add('tabid',$tabid)
									->my->add('profileid', $profileid )
									->my->add('permission','0')
									->my->add('activity',$activity) ;
							}
						}
				   }
			   }
		}
		XN_Content::batchsave($objs,"profile2tabs,profile2standardpermissions,profile2fields,profile2utilitys");		

}


$smarty = new vtigerCRM_Smarty;

			
$msg =  '<div class="form-group" style="margin: 20px 0 20px; ">
	            <label class="control-label x85">'.getTranslatedString('LBL_NEW_PROFILE_NAME').'：</label>
	            <input type="text" class="required" data-rule="required" name="profile_name"  value="" placeholder="新权限名称" style="width:230px" maxlength="20">
	        </div>
	        <div class="form-group" style="margin: 20px 0 20px; ">
	            <label class="control-label x85">'.getTranslatedString('LBL_DESCRIPTION').'：</label>
	            <textarea type="text" class="required" data-rule="required;" name="description"  value="" placeholder="权限描述" style="width:230px"></textarea>
	        </div>';		
			


$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);
$smarty->assign("MSG", $msg);
$smarty->assign("SUBMODULE", "Profiles");
$smarty->assign("OKBUTTON", "保存");
$smarty->assign("SUBACTION", "CreateProfile");

$smarty->display("MessageBox.tpl");
