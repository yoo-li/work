<?php


global  $supplierid,$supplierusertype;
include ('config.inc.php');

if(isset($_SESSION['supplierid']) && $_SESSION['supplierid'] !='')
{
    $supplierid = $_SESSION['supplierid'];
    $supplierusertype = $_SESSION['supplierusertype'];
}
else
{
	if ($copyrights['program'] == 'ma')
	{
        $staffs = XN_Query::create("Content")
            ->tag("ma_staffs")
            ->filter("type", "eic", "ma_staffs")
            ->filter("my.profileid", "=", XN_Profile::$VIEWER)
            ->filter("my.deleted", "=", "0")
            ->end(1)
            ->execute();
        if (count($staffs))
        {
            $staff_info = $staffs[0];
            $supplierusertype = $staff_info->my->ma_registertype;
            $supplierid = $staff_info->my->supplierid;
	        $_SESSION['supplierid'] = $supplierid;
	        $_SESSION['supplierusertype'] = $supplierusertype;
        }
	    else
	    {
	        $supplierid = '0';
	        $supplierusertype = '';
	    }
	}
	else if ($copyrights['program'] == 'tezan')
	{
	    $supplier_users = XN_Query::create ( 'Content' ) ->tag('supplier_users')
	        ->filter ( 'type', 'eic', 'supplier_users')
	        ->filter ( 'my.deleted', '=', '0' )
	        ->filter ( 'my.profileid', '=' ,XN_Profile::$VIEWER)
	        ->execute();
	    if (count($supplier_users) > 0)
	    {
	        $supplier_users_info = $supplier_users[0];
	        $supplierid = $supplier_users_info->my->supplierid;
	        $supplierusertype = $supplier_users_info->my->supplierusertype;

	        $_SESSION['supplierid'] = $supplierid;
	        $_SESSION['supplierusertype'] = $supplierusertype;
	    }
	    else
	    {
	        $supplierid = '0';
	        $supplierusertype = '';
	    }
	} 
}

