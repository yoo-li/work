<?php



/*
$oaflows = XN_Query::create ( 'Content' )->tag('domains')
					->filter ( 'type', 'eic', 'domains')
					->filter ( 'my.deleted', '=', '0') 
					->end(-1)
					->execute (); 

XN_Content::delete($oaflows,"domains");	
*/


$applications = XN_Query::create('Application')->begin(0)->end(-1)->execute();

foreach($applications as $app)
{
	$domains = XN_Query::create ( 'MainContent' )->tag('domains')
			->filter ( 'type', 'eic', 'domains' )
			->filter (  'my.domain', '=', $app->name )
			->execute ();
	if (count($domains) == 0)
	{   
	 	 $newcontent = XN_Content::create('domains','',false); 
		 $newcontent->my->deleted = 0;  
		 $newcontent->my->domain = $app->name;  
		 $newcontent->my->domaindescription = $app->description;
	 	 $province = "";
		 $city = "";  
		 $newcontent->my->province = $province;  
		 $newcontent->my->city = $city;
		 $newcontent->my->agentname = '王真明'; 
		 $newcontent->my->startdate = '2014-01-01'; 
		 $newcontent->my->enddate = '2015-12-31'; 
		 $newcontent->my->trialtime = $app->trialtime;  
		 $newcontent->my->status = 'Active';    
		 $newcontent->save('domains');
	 }
}


global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
global $currentModule;
include ('modules/'.$currentModule.'/ListView.php');
?>
