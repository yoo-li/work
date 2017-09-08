<?php


try {
	 $modentity_tabs = array();
	 $modentity_nums = XN_Query::create ( 'Content' )->tag('modentity_nums')
			->filter ( 'type', 'eic', 'modentity_nums' )
			->end(-1) 
			->execute (); 
	 foreach($modentity_nums as $modentity_num_info)
	 {
		 $tabid = $modentity_num_info->my->tabid;
		 $modentity_tabs[] = $tabid;
	 }
	 
	 
  	  $fields = XN_Query::create ( 'Content' )
  			->filter ( 'type', 'eic', 'fields' )
  			->filter ('my.uitype','=','4')
  			->end(-1)
  			->tag('fields')
  			->execute ();   

  	  foreach($fields as $field_info)
  	  {
  		 $fieldname = $field_info->my->fieldname;
  		 $tabid = $field_info->my->tabid;
		 $module = getModule($tabid);
  		 if (!in_array($tabid,$modentity_tabs))
		 {
		     $datafile = $_SERVER['DOCUMENT_ROOT'].'/modules/'.$module.'/config.data.php';
		     if (@file_exists($datafile))
		     {
		         require($datafile); 
		         if (is_array($config_modentity_nums)) 
				 {
		             $newcontent = XN_Content::create('modentity_nums','',false);
		             foreach ($modentity_num_info as $k => $v){
		                 $newcontent->my->$k = $v;
		             }
		             $newcontent->my->tabid = $tabid;
		             $newcontent->my->semodule = $module;
		             $newcontent->my->date  = date("ymd");
		             $newcontent->save('modentity_nums');
				 } 
		    }
		}
  	 }
}
catch ( XN_Exception $e )
{
    echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
}

echo '{"statusCode":200,"message":"模块编号刷新成功","tabid":"Settings"}';
die(); 

?>