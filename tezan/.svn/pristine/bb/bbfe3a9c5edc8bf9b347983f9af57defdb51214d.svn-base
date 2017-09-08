<?php 

require_once('modules/Public/config.func.php');

function initprofilebyname($name)
{
    try
    {

        $profiles = XN_Query::create ( 'Content' )->tag('profiles')
            ->filter ( 'type', 'eic', 'profiles' )
            ->filter ( 'my.profilename', '=', $name )
            ->filter ( 'my.deleted', '=', '0' )
            ->begin(0)->end(1)
            ->execute ();
        if (count($profiles) == 0)
        {

            $Administrator = XN_Content::create('profiles','',false);
            $Administrator->my->profilename  = $name;
            $Administrator->my->description   = $name;
            $Administrator->my->globalactionpermission1  = 0;
            $Administrator->my->globalactionpermission2   = 0;
            $Administrator->my->allowdeleted = 1;
            $Administrator->my->deleted = 0;
            $Administrator->save('profiles');
            $profilesid = $Administrator->id;
        }
        else
        {
            $Administrator = $profiles[0];
            $profilesid = $Administrator->id;
        }
        return $profilesid;
    } catch ( XN_Exception $e ) {
        return null;
    }
}

