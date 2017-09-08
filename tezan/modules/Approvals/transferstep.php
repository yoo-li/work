<?php

require_once('transferstep.func.php');


if (isset($_REQUEST['record']) && $_REQUEST['record'] != '' &&
    isset($_REQUEST['formodule']) && $_REQUEST['formodule'] != '')
{
    $formodule = $_REQUEST ['formodule'];
    $recordid = $_REQUEST ['record'];
    try
    {
		$tabid = getTabid($formodule); 
		 
		global $copyrights,$supplierid; 
		if(isset($_SESSION['supplierid']) && $_SESSION['supplierid'] !='')
		{ 
			$supplierid = $_SESSION['supplierid']; 
		}
	 
		if (isset($copyrights['customapproval']) && $copyrights['customapproval'] != "" &&
			isset($supplierid) && $supplierid != "")
		{
			$customapproval = $copyrights['customapproval'];
            $customapprovals = XN_Query::create("Content")->tag($customapproval)
                                        ->filter("type", "eic", $customapproval)
                                        ->filter("my.deleted", "=", "0")
                                        ->filter("my.supplierid", "=", $supplierid)
                                        ->filter("my.customapprovalflowtabid", "=", $tabid)
                                        ->filter("my.approvalflowsstatus", "=", '1')
                                        ->end(1)
                                        ->execute();

		    if (count($customapprovals) > 0)
			{
				$steps = gettransfersteps($recordid, $formodule,$customapproval); 
			}
			else
			{
				$steps = gettransfersteps($recordid, $formodule);
			}
		}
		else
		{
			$steps = gettransfersteps($recordid, $formodule);
		}
       
        //print_r($steps);
        echo '{statusCode:200,selectnode:"'.XN_Profile::$VIEWER.'",data:'.json_encode($steps).'}';

    }
    catch (XN_Exception $e)
    {
        echo '{"statusCode":300,"message":"' . $e->getMessage() . '"}';
        die();
    }
}



/*{statusCode:200,selectnode:"3",data:{
           id: "0",
           name: "F5",
           data: {
           	type:'F5'
           },
           children: [ {id: "1",
                name: "引擎1",
                data: {type:'server'}
               },{
               id: "2",
               name: "引擎2",
               data: {},
                children: [{
   		            id: "21",
   		            name: "应用21",
   		            data: {}
   		            }, {
   		        	 id: "22",
   		             name: "应用22",
   		             data: {type:'server'}
   		            }, {
   		        	id: "23",
   		            name: "应用23",
   		            data: {type:'server'}
   		            }, {
   		        	id: "24",
   		            name: "应用24",
   		            data: {type:'server'}
   		           }]
               }, 
           	 {
           	id: "3",
               name: "引擎3",
               data: {type:'server'}
               }, {
           	id: "5",
               name: "引擎4",
               data: {type:'server'}
              }]
       }
}*/

?>