<?php


require_once('include/utils/UserInfoUtil.php');
require_once('VTEntityData.php');

class CRMEntity
{
    var $ownedby;
    public $tag = '';
    public $hasapprovals;
    public $approvalstatus;
    public $readOnly;
    public $approvalid;
    public $detailapproval;
    public $headerdetails;
    public $details;

    static function getInstance($module)
    {
        if (!class_exists($module))
        {
            checkFileAccess("modules/$module/$module.php");
            require_once("modules/$module/$module.php"); 
        }

        $focus = new $module();
        return $focus;
    }
	 
    function saveentity($module/*, $fileid = ''*/)
    {
//        global $current_user;  //$adb added by raju for mass mailing

//        $insertion_mode = $this->mode;

        $this->insertIntoEntityTable($this->table_name, $module);
        //Calling the Module specific save code
        $this->save_module($module);

        $assigntype = $_REQUEST['assigntype'];

        if ($module != "Calendar" && $module != "Accounts" && $module != "Contacts")
        {
            $this->whomToSendMail($module, $this->mode, $assigntype);
        }


        // vtlib customization: Hook provide to enable generic module relation.

        // Ticket 6386 fix
        global $singlepane_view;

        if ($_REQUEST['return_action'] == 'CallRelatedList' ||
            (isset($singlepane_view) && $singlepane_view == true &&
                $_REQUEST['return_action'] == 'DetailView' &&
                !empty($_REQUEST['return_module']))
        )
        {
            $for_module = $_REQUEST['return_module'];
            $for_crmid = $_REQUEST['return_id'];

            $on_focus = CRMEntity::getInstance($for_module);
            // Do conditional check && call only for Custom Module at present
            // TOOD: $on_focus->IsCustomModule is not required if save_related_module function
            // is used for core modules as well.
            if ($on_focus->IsCustomModule && method_exists($on_focus, 'save_related_module'))
            {
                $with_module = $module;
                $with_crmid = $this->id;
                $on_focus->save_related_module(
                    $for_module, $for_crmid, $with_module, $with_crmid);
            }
        }
        // END
    }


    function mime_type($filename)
    {

        $mime_types = array(

            'txt'  => 'text/plain',
            'htm'  => 'text/html',
            'html' => 'text/html',
            'php'  => 'text/html',
            'css'  => 'text/css',
            'js'   => 'application/javascript',
            'json' => 'application/json',
            'xml'  => 'application/xml',
            'swf'  => 'application/x-shockwave-flash',
            'flv'  => 'video/x-flv',

            // images
            'png'  => 'image/png',
            'jpe'  => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg'  => 'image/jpeg',
            'gif'  => 'image/gif',
            'bmp'  => 'image/bmp',
            'ico'  => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif'  => 'image/tiff',
            'svg'  => 'image/svg+xml',
            'svgz' => 'image/svg+xml',

            // archives
            'zip'  => 'application/zip',
            'rar'  => 'application/x-rar-compressed',
            'exe'  => 'application/x-msdownload',
            'msi'  => 'application/x-msdownload',
            'cab'  => 'application/vnd.ms-cab-compressed',

            // audio/video
            'mp3'  => 'audio/mpeg',
            'qt'   => 'video/quicktime',
            'mov'  => 'video/quicktime',

            // adobe
            'pdf'  => 'application/pdf',
            'psd'  => 'image/vnd.adobe.photoshop',
            'ai'   => 'application/postscript',
            'eps'  => 'application/postscript',
            'ps'   => 'application/postscript',

            // ms office
            'doc'  => 'application/msword',
            'rtf'  => 'application/rtf',
            'xls'  => 'application/vnd.ms-excel',
            'ppt'  => 'application/vnd.ms-powerpoint',

            // open office
            'odt'  => 'application/vnd.oasis.opendocument.text',
            'ods'  => 'application/vnd.oasis.opendocument.spreadsheet',
        );
        $pos=strrpos($filename,".");
        $ext=strtolower(substr($filename,$pos));
        if (array_key_exists($ext, $mime_types))
        {
            return $mime_types[$ext];
        }
        elseif (function_exists('finfo_open'))
        {
            $finfo = finfo_open(FILEINFO_MIME);
            $mimetype = finfo_file($finfo, $filename);
            finfo_close($finfo);
            return $mimetype;
        }
        else
        {
            return 'application/octet-stream';
        }
    }

    function ImageResize($srcFile, $toW, $toH, $toFile = "")
    {

        $cfg_photo_type['gif'] = FALSE;
        $cfg_photo_type['jpeg'] = FALSE;
        $cfg_photo_type['png'] = FALSE;
        $cfg_photo_type['wbmp'] = FALSE;

        if (function_exists("imagecreatefromgif") && function_exists("imagegif"))
        {
            $cfg_photo_type["gif"] = TRUE;

        }
        if (function_exists("imagecreatefromjpeg") && function_exists("imagejpeg"))
        {
            $cfg_photo_type["jpeg"] = TRUE;
        }
        if (function_exists("imagecreatefrompng") && function_exists("imagepng"))
        {
            $cfg_photo_type["png"] = TRUE;

        }
        if (function_exists("imagecreatefromwbmp") && function_exists("imagewbmp"))
        {
            $cfg_photo_type["wbmp"] = TRUE;

        }
        if ($toFile == '') $toFile = $srcFile;
        $info = '';
        $srcInfo = GetImageSize($srcFile, $info);
        switch ($srcInfo[2])
        {
            case 1:
                if (!$cfg_photo_type['gif']) return FALSE;
                $im = imagecreatefromgif($srcFile);
                break;
            case 2:
                if (!$cfg_photo_type['jpeg']) return FALSE;
                $im = imagecreatefromjpeg($srcFile);
                break;
            case 3:
                if (!$cfg_photo_type['png']) return FALSE;
                $im = imagecreatefrompng($srcFile);
                break;
            case 6:
                if (!$cfg_photo_type['bmp']) return FALSE;
                $im = imagecreatefromwbmp($srcFile);
                break;
        }
        $srcW = ImageSX($im);
        $srcH = ImageSY($im);

        //if($srcW<=$toW && $srcH<=$toH ) return TRUE;

        $toWH = $toW / $toH;
        $srcWH = $srcW / $srcH;

        $ftoH = $toH;
        $ftoW = $toW;
        if ($toWH <= $srcWH)
        {
            $src_Y = 0;
            $src_X = ($srcW - $srcH * $toWH) / 2;
            $srcW = $srcH * $toWH;
        }
        else
        {
            $src_X = 0;
            $src_Y = ($srcH - $srcW / $toWH) / 2;
            $srcH = $srcW / $toWH;
        }

        /*if($toWH<=$srcWH)
        {
            $ftoW=$toW;
            $ftoH=$ftoW*($srcH/$srcW);
        }
        else
        {
            $ftoH=$toH;
            $ftoW=$ftoH*($srcW/$srcH);
        }*/

        if ($srcW > $toW || $srcH > $toH)
        {
            if (function_exists("imagecreateTRUEcolor"))
            {
                @$ni = imagecreateTRUEcolor($ftoW, $ftoH);
                if ($ni)
                {
                    //imagecopyresampled($ni,$im,0,0,0,0,$ftoW,$ftoH,$srcW,$srcH);
                    imagecopyresampled($ni, $im, 0, 0, $src_X, $src_Y, $ftoW, $ftoH, $srcW, $srcH);
                }
                else
                {
                    $ni = imagecreate($ftoW, $ftoH);
                    //imagecopyresized($ni,$im,0,0,0,0,$ftoW,$ftoH,$srcW,$srcH);
                    imagecopyresized($ni, $im, 0, 0, $src_X, $src_Y, $ftoW, $ftoH, $srcW, $srcH);
                }
            }
            else
            {
                $ni = imagecreate($ftoW, $ftoH);
                //imagecopyresized($ni,$im,0,0,0,0,$ftoW,$ftoH,$srcW,$srcH);
                imagecopyresized($ni, $im, 0, 0, $src_X, $src_Y, $ftoW, $ftoH, $srcW, $srcH);
            }

            switch ($srcInfo[2])
            {
                case 1:
                    imagegif($ni, $toFile);
                    break;
                case 2:
                    imagejpeg($ni, $toFile, 80);
                    break;
                case 3:
                    imagepng($ni, $toFile);
                    break;
                case 6:
                    imagebmp($ni, $toFile);
                    break;
                default:
                    return FALSE;
            }
            imagedestroy($ni);
        }
        else
        {
            if ($srcW < $toW)
            {
                $toW = $srcW;
                $ftoW = $srcW;
            }
            if ($srcH < $toH)
            {
                $toH = $srcH;
                $ftoH = $srcH;
            }
            if (function_exists("imagecreateTRUEcolor"))
            {
                @$ni = imagecreateTRUEcolor($ftoW, $ftoH);
                if ($ni)
                {
                    //imagecopyresampled($ni,$im,0,0,0,0,$ftoW,$ftoH,$srcW,$srcH);
                    imagecopyresampled($ni, $im, 0, 0, $src_X, $src_Y, $ftoW, $ftoH, $srcW, $srcH);
                }
                else
                {
                    $ni = imagecreate($ftoW, $ftoH);
                    //imagecopyresized($ni,$im,0,0,0,0,$ftoW,$ftoH,$srcW,$srcH);
                    imagecopyresized($ni, $im, 0, 0, $src_X, $src_Y, $ftoW, $ftoH, $srcW, $srcH);
                }
            }
            else
            {
                $ni = imagecreate($ftoW, $ftoH);
                //imagecopyresized($ni,$im,0,0,0,0,$ftoW,$ftoH,$srcW,$srcH);
                imagecopyresized($ni, $im, 0, 0, $src_X, $src_Y, $ftoW, $ftoH, $srcW, $srcH);
            }

            switch ($srcInfo[2])
            {
                case 1:
                    imagegif($ni, $toFile);
                    break;
                case 2:
                    imagejpeg($ni, $toFile, 75);
                    break;
                case 3:
                    imagepng($ni, $toFile);
                    break;
                case 6:
                    imagebmp($ni, $toFile);
                    break;
                default:
                    return FALSE;
            }
            imagedestroy($ni);
        }
        imagedestroy($im);
        return TRUE;
    }


    /**
     *      This function is used to upload the attachment in the server and save that attachment information in db.
     * @param int $id - entity id to which the file to be uploaded
     * @param string $module - the current module name
     * @param array $file_details - array which contains the file information(name, type, size, tmp_name and error)
     *      return void
     */
    function uploadAndSaveFile($id, $module, $file_details,$category)
    {


        global $upload_badext;
        $filetmp_name = $file_details['tmp_name'];
        $hashval = md5_file($filetmp_name);
        $query = XN_Query::create("Content_Count")
            ->tag("attachments")
            ->filter("type", "eic", "attachments")
            ->filter("my.hashval", "=", $hashval)
            ->end(1)
            ->rollup();
        $query->execute();
        $count = $query->getTotalCount();
        if ($count > 0)
        {
            $attach_query = XN_Query::create("Content")
                ->tag("attachments")
                ->filter("type", "eic", "attachments")
                ->filter("my.hashval", "=", $hashval)
                ->end(1)
                ->order('published', XN_Order::ASC)
                ->execute();
            $attach_info = $attach_query[0];
            $mime_type = $attach_info->my->type;
            $filesize = $attach_info->my->filesize;
            $savefile = $attach_info->my->savefile;
            $upload_file_path = $attach_info->my->path;
            $filename = $attach_info->my->name;
            if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $upload_file_path . $savefile))
            {
                if (!is_dir($_SERVER['DOCUMENT_ROOT'] . $upload_file_path))
                {
                    @mkdir($_SERVER['DOCUMENT_ROOT'] . $upload_file_path, 0777, true);
                }
                $upload_status = move_uploaded_file($filetmp_name, $_SERVER['DOCUMENT_ROOT'] . $upload_file_path . $savefile);
            }
            return array(true, $attach_info->id, $upload_file_path, $savefile, $mime_type);

        }
        else
        {
            if (isset($file_details['original_name']) && $file_details['original_name'] != null)
            {
                $file_name = $file_details['original_name'];
            }
            else
            {
                $file_name = $file_details['name'];
            }
            $binFile = sanitizeUploadFileName($file_name, $upload_badext);
            $filename = ltrim(basename(" " . $binFile)); //allowed filename like UTF-8 characters
            $filetype = $file_details['type'];
            $filesize = $file_details['size'];
            $filetmp_name = $file_details['tmp_name'];

            $upload_file_path = "/" . decideFilePath();
            $guid = date("YmdHis") . floor(microtime() * 1000);
            $pos=strrpos($filename,".");
            $savefile = $guid . substr($filename,$pos);
            $upload_status = move_uploaded_file($filetmp_name, $_SERVER['DOCUMENT_ROOT'] . $upload_file_path . $savefile);


            $srcFile = $_SERVER['DOCUMENT_ROOT'] . $upload_file_path . $savefile;
            if (in_array($module, array("FoodProduct", "ProductTry")))
            {
                $this->ImageResize($srcFile, 640, 640);
            }
            $mime_type = $this->mime_type(strtolower($srcFile));
        }

        $Attachments = XN_Content::create('attachments', '', false);
        $Attachments->my->name=$filename;
        $Attachments->my->module=$module;
        $Attachments->my->record =$id;
        $Attachments->my->filesize =$filesize;
        $Attachments->my->type =$mime_type;
        $Attachments->my->path =$upload_file_path;
        $Attachments->my->savefile= $savefile;
        $Attachments->my->sequence ='0';
        $Attachments->my->hashval =$hashval;
        $Attachments->my->deleted ='0';
        if(isset($category) &&$category!="" ){
            $Attachments->my->category=$category;
        }
        $Attachments->save('Attachments');

        return array(true, $Attachments->id, $upload_file_path, $savefile, $mime_type);
    }


    /** Function to insert values in the specifed table for the specified module
     * @param $table_name -- table name:: Type varchar
     * @param $module -- module:: Type varchar
     */
    function insertIntoEntityTable($table_name, $module)
    {
        global $current_user, $app_strings;
        $insertion_mode = $this->mode;
        $statusFieldname = $this->table_name . 'status';

        $tabid = getTabid($module);
        if ($insertion_mode == 'edit')
        {
            $Fieldsquery = XN_Query::create('Content')->tag('Fields')
                ->filter('type', 'eic', 'fields')
                ->filter('my.tabid', '=', $tabid)
                ->filter('my.presence', 'in', array('0', '2', '3'))
                ->filter('my.displaytype', 'in', array('1', '2', '3'));
        }
        else
        {
            $Fieldsquery = XN_Query::create('Content')->tag('Fields')
                ->filter('type', 'eic', 'fields')
                ->filter('my.tabid', '=', $tabid)
                ->filter('my.presence', 'in', array('0', '2', '3'))
                ->filter('my.displaytype', 'in', array('1', '2', '3', '4', '5'));
        }
        $Fieldsquery->end(-1);
        $result = $Fieldsquery->execute();
        $keyvalus = array();

        foreach ($result as $info)
        {
            $fieldname = $info->my->fieldname;
            //$columname = $info->my->columnname;
            $uitype = $info->my->uitype;
            $displaytype = $info->my->displaytype;
            $generatedtype = $info->my->generatedtype;
            $typeofdata = $info->my->typeofdata;
            $typeofdata_array = explode("~", $typeofdata);
            $datatype = $typeofdata_array[0];

            if ($uitype == 4 && $insertion_mode != 'edit')
            {

                $this->column_fields[$fieldname] = $this->setModuleSeqNumber("increment", $module);
                $fldvalue = $this->column_fields[$fieldname];
            }
            if (isset($this->column_fields[$fieldname]))
            {
                if ($uitype == 56)
                {
                    if ($this->column_fields[$fieldname] == 'on' || $this->column_fields[$fieldname] == 1)
                    {
                        $fldvalue = '1';
                    }
                    else
                    {
                        $fldvalue = '0';
                    }

                }
                elseif ($uitype == 15 || $uitype == 16)
                {
                    $fldvalue = $this->column_fields[$fieldname];
                    /*
				  if($this->column_fields[$fieldname] == $app_strings['LBL_NOT_ACCESSIBLE'])
				  {

					$query = XN_Query::create ( 'Content' ) ->tag($this->table_name)
						->filter ( 'type', 'eic', $this->table_name)
						->filter ( 'my.'.$this->tab_name_index[$this->table_name], '=', $this->id)
						->execute();
					foreach($query as $info){
						$pick_val = $info->my->$fieldname;
					}
				  	$fldvalue = $pick_val;
				  }
				  else
				  {
					  $fldvalue = $this->column_fields[$fieldname];
				   }*/
                }
                elseif ($uitype == 33)
                {
                    if (is_array($this->column_fields[$fieldname]))
                    {
                        $field_list = implode(' |##| ', $this->column_fields[$fieldname]);
                    }
                    else
                    {
                        $field_list = $this->column_fields[$fieldname];
                    }
                    $fldvalue = $field_list;
                }
                elseif ($uitype == 5 || $uitype == 6 || $uitype == 23)
                {
                    //Added to avoid function call getDBInsertDateValue in ajax save
                    if (isset($current_user->date_format))
                    {
                        $fldvalue = getValidDBInsertDateValue($this->column_fields[$fieldname]);
                    }
                    else
                    {
                        $fldvalue = $this->column_fields[$fieldname];
                    }
                }
                elseif ($uitype == 7)
                {
                    //strip out the spaces and commas in numbers if given ie., in amounts there may be ,
                    $fldvalue = str_replace(",", "", $this->column_fields[$fieldname]);//trim($this->column_fields[$fieldname],",");

                }
                elseif ($uitype == 26)
                {
                    if (empty($this->column_fields[$fieldname]))
                    {
                        $fldvalue = 1; //the documents will stored in default folder
                    }
                    else
                    {
                        $fldvalue = $this->column_fields[$fieldname];
                    }
                }
                elseif ($uitype == 28)
                {
                    if ($this->column_fields[$fieldname] != null)  
                    {
                        $fldvalue = $this->column_fields[$fieldname];
                    }
                }
                elseif ($uitype == 8)
                {
                    $this->column_fields[$fieldname] = rtrim($this->column_fields[$fieldname], ',');
                    $ids = explode(',', $this->column_fields[$fieldname]);
                    $json = new Zend_Json();
                    $fldvalue = $json->encode($ids);
                }
                elseif ($uitype == 12)
                {
                    $query = XN_Query::create('Content')->tag('Users')
                        ->filter('type', 'eic', 'users')
                        ->filter('my.profileid', '=', $current_user->id)
                        ->execute();
                    if (count($query) > 0)
                        $fldvalue = $query[0]->my->email1;
                }
                elseif ($uitype == 71 && $generatedtype == 2)
                { // Convert currency to base currency value before saving for custom fields of type currency
                    $currency_id = $current_user->currency_id;
                    $curSymCrate = getCurrencySymbolandCRate($currency_id);
                    $fldvalue = convertToDollar($this->column_fields[$fieldname], $curSymCrate['rate']);
                }
                else if ($fieldname == 'personman' && is_array($this->column_fields[$fieldname]))
                {
                    if (count($this->column_fields[$fieldname]) == 0)
                    {
                        $fldvalue = XN_Profile::$VIEWER;
                    }
                    else if ($this->column_fields[$fieldname] == array(""))
                    {
                        $fldvalue = XN_Profile::$VIEWER;
                    }
                    else
                    {
                        $fldvalue = $this->column_fields[$fieldname];
                    }
                }
                else if ($fieldname == 'personman' && $this->column_fields[$fieldname] == '')
                {
                    $fldvalue = XN_Profile::$VIEWER;
                }
                else
                {
                    $fldvalue = $this->column_fields[$fieldname];
                }
                if ($uitype != 33 && $uitype != 8)
                    $fldvalue = from_html($fldvalue);
            }
            else if ($fieldname == 'personman')
            {
                $fldvalue = XN_Profile::$VIEWER;
            }
            else
            {
                $fldvalue = '';
            }

            if ($fldvalue == '')
            {
                $fldvalue = $this->get_column_value($fieldname, $fldvalue, $fieldname, $uitype, $datatype);
            }

            if ($insertion_mode == 'edit')
            {
                if ($uitype != 4)
                {
                    if ($displaytype == 2 && ($fldvalue != '' || (array_key_exists($fieldname,$this->column_fields) && isset($_REQUEST[$fieldname]))))
                    {
                        $keyvalus[$fieldname] = $fldvalue;
                    }
                    else if ($displaytype != 2)
                    {
                        $keyvalus[$fieldname] = $fldvalue;
                    }
                }
            }
            else
            {
                $keyvalus[$fieldname] = $fldvalue;
            }


        }
		
		global $global_session; 
		$tabdata  = $global_session['tabdata']; 
        $optionalapprovals = $tabdata['optionalapprovals'];
      
        if (in_array($tabid, array_keys($optionalapprovals)))
        {
            $keyvalus['optionalapproval'] = $this->column_fields['optionalapproval'];
        }


        $tag = '';
        if (isset($this->tag) && $this->tag != '')
        {
            $tag = ',' . $this->tag;
        }

        $datatype = $this->datatype;

        if ($insertion_mode == 'edit')
        {
            if (count($keyvalus) > 0)
            {
                try
                {

                    if (isset($datatype) && $datatype != '')
                    {
                        $SaveContent = XN_Content::load($this->id, $this->table_name, $datatype);
                    }
                    else
                    {
                        $SaveContent = XN_Content::load($this->id, $this->table_name);
                    }


                    foreach ($keyvalus as $columnname => $fieldname)
                    {
                        $SaveContent->my->$columnname = $fieldname;
                    }
                    $SaveContent->my->deleted = 0;
                    $SaveContent->my->createnew = 0;
                    if (isset($this->column_fields['title']) && $this->column_fields['title'] != "")
                    {
                        $SaveContent->title = $this->column_fields['title'];
                    }
                    $SaveContent->save($this->table_name . ',fulltext,report' . $tag);
                }
                catch (XN_Exception $e)
                {
                }
            }
        }
        else
        {
            if (isset($datatype) && $datatype != '')
            {
                $SaveContent = XN_Content::load($this->id, $this->table_name, $datatype);
            }
            else
            {
                $SaveContent = XN_Content::load($this->id, $this->table_name);
            }

            foreach ($keyvalus as $columnname => $fieldname)
            {
                $SaveContent->my->$columnname = $fieldname;
            }
            $SaveContent->my->deleted = 0;
            $SaveContent->my->createnew = 0;
            if (isset($this->column_fields['title']) && $this->column_fields['title'] != "")
            {
                $SaveContent->title = $this->column_fields['title'];
            }


            $SaveContent->save($this->table_name . ',fulltext,report' . $tag);
        }
    }

    function whomToSendMail($module, $insertion_mode, $assigntype)
    {
        if ($insertion_mode != "edit")
        {
            if ($assigntype == 'U')
            {
                sendNotificationToOwner($module, $this);
            }
            elseif ($assigntype == 'T')
            {
                $groupid = $_REQUEST['assigned_group_id'];
                sendNotificationToGroups($groupid, $this->id, $module);
            }
        }
    }


// Code included by Jaguar - Ends

    /** Function to retrive the information of the given recordid ,module
     * @param $record -- Id:: Type Integer
     * @param $module -- module:: Type varchar
     * This function retrives the information from the database and sets the value in the class columnfields array
     */
    function retrieve_entity_info($record, $module, $datatype = 0)
    {
        global $app_strings;
        $tabid = getTabid($module);
        $approvaltabs = array();
		global $global_session; 
		$tabdata  = $global_session['tabdata']; 
        $approvaltabs = $tabdata['approvaltabs'];
       
        if (isset($this->datatype) && $this->datatype != '')
        {
            $datatype = $this->datatype;
        }

        $this->hasapprovals = 'false';
        if (in_array($tabid, $approvaltabs))
        {
            $this->hasapprovals = 'true';
        }
		else
		{
			global $copyrights,$supplierid;
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
					$this->hasapprovals = 'true';
				}
			}
		}

        if (isset($record) && $record != '')
        {
            $this->id = $record;
            $this->mode = 'edit';
            try
            {

                if ($module == "Users")
                {
                    if (is_numeric($record))
                    {
                        $retrieveresult = XN_Content::load($record, $module, $datatype);
                    }
                    else
                    {
                        $users = XN_Query::create('Content')->tag('Users')
                            ->filter('type', 'eic', 'users')
                            ->filter('my.profileid', '=', $record)
                            ->execute();
                        if (count($users) > 0)
                        {
                            $retrieveresult = $users[0];
                        }
                        else
                        {
                            throw new XN_Exception('Users ID(' . $record . ') error!');
                        }
                    }
                }
                else
                {
                    if (is_numeric($record))
                    {
                        $retrieveresult = XN_Content::load($record, $module, $datatype);
                    }
                    else
                    {
                        throw new XN_Exception('XN_Content ID(' . $record . ') error!');
                    }
                }
            }
            catch (XN_Exception $e)
            {
                die("<br><br><center>" . $app_strings['LBL_RECORD_DELETE'] . "</center>");
            }
        }
        else
        {
            if (isset($datatype) && $datatype != '')
            {
                $retrieveresult = XN_Content::create(strtolower($this->table_name), '', false, $datatype)->my->add('createnew', '1')->save($this->table_name);
            }
            else
            {
                $retrieveresult = XN_Content::create(strtolower($this->table_name), '', false)->my->add('createnew', '1')->save($this->table_name);
            }
            $record = $retrieveresult->id;
            $this->id = $record;
            $_REQUEST['record'] = $record;
            $this->mode = '';

        }
        // Lookup in cache for information
        $cachedModuleFields = VTCacheUtils::lookupFieldInfo_Module($module);

        if ($cachedModuleFields === false)
        {
            // Let us pick up all the fields first so that we can cache information
            $query = XN_Query::create('Content')->tag('Fields')
                ->filter('type', 'eic', 'fields')
                ->filter('my.tabid', '=', $tabid)
                ->end(-1)
                ->execute();
            foreach ($query as $info)
            {
                VTCacheUtils::updateFieldInfo(
                    $tabid, $info->my->fieldname, $info->my->fieldid, $info->my->fieldlabel, $info->my->uitype, $info->my->typeofdata, $info->my->presence
                );
            }
            // Get only active field information
            $cachedModuleFields = VTCacheUtils::lookupFieldInfo_Module($module);
        }

        if ($cachedModuleFields)
        {
            foreach ($cachedModuleFields as $fieldname => $fieldinfo)
            {
                $fieldname = $fieldinfo['fieldname'];
                if (isset($retrieveresult))
                {
                    $fld_value = $retrieveresult->my->$fieldname;
                }
                else
                {
                    $fld_value = "";
                }
                $this->column_fields[$fieldname] = $fld_value;
            }
        }
        $this->readOnly = 'false';
		$this->approvalstatus = $retrieveresult->my->approvalstatus;
		$this->column_fields['approvalstatus'] = $this->approvalstatus;
		$this->column_fields['submitapprovaldatetime'] = $retrieveresult->my->submitapprovaldatetime;
		$this->column_fields['submitapprovalreplydatetime'] = $retrieveresult->my->submitapprovalreplydatetime;
        if ($this->approvalstatus == '1' || $this->approvalstatus == '2' || $_REQUEST['readonly'] == 'true')
        {
            $this->readOnly = 'true';
        }
        $this->column_fields["record_id"] = $record;
        $this->column_fields["record_module"] = $module;
        $this->column_fields["author"] = $retrieveresult->contributorName;
        $this->column_fields["published"] = date("Y-m-d", strtotime($retrieveresult->createdDate));
        $this->column_fields["updated"] = date("Y-m-d", strtotime($retrieveresult->updatedDate));
        $this->column_fields["deleted"] = $retrieveresult->my->deleted;
        if ($this->column_fields["deleted"] == '1')
        {
            $this->readOnly = 'true';
        }

        $status = strtolower($module) . 'status';
        if (in_array($this->column_fields[$status], array('Submited', 'Release', 'Terminate', 'Agree', 'Archive', 'Unapproved', "Approvaling")))
        {
            $this->readOnly = 'true';
        }


        $this->detailapproval = '0';

        if ($this->approvalstatus == '1')
        {

            $approvals = XN_Query::create('Content')
                ->tag('approvals')
                ->filter('type', 'eic', 'approvals')
                ->filter('my.tabid', '=', $tabid)
                ->filter('my.record', '=', $record)
                ->filter('my.userid', '=', XN_Profile::$VIEWER)
                ->filter('my.finished', '=', 'false')
                ->execute();
            if (count($approvals) > 0)
            {
                $approval_info = $approvals[0];
                $this->approvalid = $approval_info->id;
                $detailapprovals = array();
				global $global_session; 
				$tabdata  = $global_session['tabdata']; 
                $detailapprovals = $tabdata['detailapprovals'];
               

                if (in_array($tabid, $detailapprovals))
                {
                    try
                    {
                        $this->detailapproval = '1';
                        $fields = array();
                        $fieldsfile = "modules/$module/config.field.php";
                        if (@file_exists($fieldsfile))
                        {
                            require_once($fieldsfile);
	                        $this->headerdetails = array();
	                        foreach ($fields as $fieldname => $fieldname_info)
	                        {
	                            if (!$fieldname_info['approval']) continue;
	                            $this->headerdetails[] = array(
	                                'align'  => $fieldname_info['align'],
	                                'width=' => $fieldname_info['width'],
	                                'label'  => $fieldname_info['label']);
	                        }
	                        $approvals = XN_Query::create('Content')->tag(strtolower($module) . '_details')
	                            ->filter('type', 'eic', strtolower($module) . '_details')
	                            ->filter('my.record', '=', $record)
	                            ->filter('my.deleted', '=', '0')
	                            ->order("published", XN_Order::DESC)
	                            ->execute();
	                        $this->details = array();
	                        foreach ($approvals as $approval_info)
	                        {

	                            foreach ($fields as $fieldname => $fieldname_info)
	                            {
	                                if (!$fieldname_info['approval']) continue;

	                                switch ($fieldname)
	                                {
	                                    case "published":
	                                        $this->details[$approval_info->id]['published'] = date("Y-m-d", strtotime($approval_info->createdDate));
	                                        break;
	                                    case "number": 
	                                        $this->details[$approval_info->id][$fieldname] = formatnumber($approval_info->my->$fieldname) . "(元)";
	                                        break;
	                                    default:
	                                        $this->details[$approval_info->id][$fieldname] = $approval_info->my->$fieldname;
	                                        break;
	                                }
	                            }
	                        }
                        }
                     
                    }
                    catch (XN_Exception $e)
                    {
                    }
                }
            }
            else
            {
                $this->approvalid = "";
            }
        }


    }

    /** Function to saves the values in all the tables mentioned in the class variable $tab_name for the specified module
     * @param $module -- module:: Type varchar
     */
    function save($module_name, $fileid = '')
    {
        //Event triggering code
        /*require_once("include/events/include.inc");
		global $adb;
		$em = new VTEventsManager($adb);

		// Initialize Event trigger cache
		$em->initTriggerCache(); */

        $entityData = VTEntityData::fromCRMEntity($this);
        //$em->triggerEvent("vtiger.entity.beforesave.modifiable", $entityData);
        //$em->triggerEvent("vtiger.entity.beforesave", $entityData);
        //$em->triggerEvent("vtiger.entity.beforesave.final", $entityData);
        //Event triggering code ends

        //GS Save entity being called with the modulename as parameter
        $this->saveentity($module_name, $fileid);

        //Event triggering code
        //$em->triggerEvent("vtiger.entity.aftersave", $entityData);
        //Event triggering code ends
    }

    /** This function should be overridden in each module.  It marks an item as deleted.
     * If it is not overridden, then marking this type of item is not allowed
     * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc..
     * All Rights Reserved..
     * Contributor(s): ______________________________________..
     */
    function mark_deleted($module, $id)
    {
        global $current_user;

        $focus = CRMEntity::getInstance($module); 
		
		$datatype = $this->datatype; 

        setObjectValuesFromRequest($focus, $id);  
        $entityData = VTEntityData::fromCRMEntity($focus);   

        if (isset($datatype) && $datatype != '')
        {
            $SaveContent = XN_Content::load($id, $module, $datatype);
        }
        else
        {
            $SaveContent = XN_Content::load($id, $module);
        } 

        $SaveContent->my->deleted = 1;
        $SaveContent->my->modifiedby = $current_user->id;
        $SaveContent->my->modifiedtimeby = date("Y-m-d H:i:s");
        $SaveContent->save($this->table_name);
    }

    /**
     * Function to get the column value of a field when the field value is empty ''
     * @param $columnname -- Column name for the field
     * @param $fldvalue -- Input value for the field taken from the User
     * @param $fieldname -- Name of the Field
     * @param $uitype -- UI type of the field
     * @return Column value of the field.
     */
    function get_column_value($columnname, $fldvalue, $fieldname, $uitype, $datatype = '')
    {

        // Added for the fields of uitype '57' which has datatype mismatch in crmentity table and particular entity table
        if ($uitype == 57 && $fldvalue == '')
        {
            return 0;
        }
        if (is_uitype($uitype, "_date_") && $fldvalue == '')
        {
            return null;
        }
        if ($datatype == 'I' || $datatype == 'N' || $datatype == 'NN')
        {
            //return 0;
            return '';
        }
        return $fldvalue;
    }


    /** Function to delete an entity with given Id */
    function trash($module, $id)
    {
        global $current_user;
        $this->mark_deleted($module, $id);
    }


    /**
     * Function to initialize the sortby fields array
     */
    function initSortByField($module)
    {
//        global $adb;
//        $exclude_uitypes = Array();

        $tabid = getTabId($module);

        $fieldsquery = XN_Query::create('Content')->tag('Fields')
            ->filter('type', 'eic', 'fields')
            ->filter('my.presence', 'in', array('0', '2'));

        $fieldsquery->filter('my.tabid', '=', $tabid);

        $fieldsquery->end(-1);
        $fields = $fieldsquery->execute();

        foreach ($fields as $fields_info)
        {
            $columnname = $fields_info->my->columnname;
            if (in_array($columnname, $this->sortby_fields)) continue;
            else $this->sortby_fields[] = $columnname;
        }
    }

    /* Function to set the Sequence string and sequence number starting value */
    function setModuleSeqNumber($mode, $module, $req_str = ''/*, $req_no = ''*/)
    {
        if ($mode == "configure" && $req_str != '')
        {
            $check = XN_Query::create('Content')->tag('modentity_nums')
                ->filter('type', 'eic', 'modentity_nums')
                ->filter('my.semodule', '=', $module)
                ->execute();
            if (count($check) == 0)
            {
                XN_Content::create('modentity_nums', '', false)
                    ->my->add('semodule', $module)
                    ->my->add('prefix', $req_str)
                    ->my->add('start_id', '1')
                    ->my->add('cur_id', '1')
                    ->my->add('active', 1)
                    ->my->add('date', date("ymd"))
                    ->save('modentity_nums');
                return true;
            }
            else
            {
                $modentity_nums = $check[0];
                $modentity_nums->my->prefix = $req_str;
                $modentity_nums->save('modentity_nums');
                return true;
            }
        }
        else if ($mode == "increment")
        {

            try
            {
                $prev_inv_no = XN_ModentityNum::get($module);
                return $prev_inv_no;
            }
            catch (XN_Exception $e)
            {
                return 'EP' . date("ymd") . '001';
            }
            /*
			$query = XN_Query::create ( 'Content' ) ->tag('modentity_nums')
				->filter ( 'type', 'eic', 'modentity_nums' )
				->filter ( 'my.semodule', '=', $module )
				->filter ( 'my.active', '=', 1 )
				->execute();
			if(count($query)>0)
			{
				$modentity_nums = $query[0];
				$prefix = $modentity_nums->my->prefix;
				$curid = $modentity_nums->my->cur_id;
				$date_prefix = date("ymd");
				if ($date_prefix != $modentity_num->my->date)
				{
					$modentity_num->my->date = $date_prefix;
					$cur_id = 1;
				}
				if ($curid < 1000)
				{
					$formatcurid = sprintf("%03d", $curid);
				}
				else
				{
					$formatcurid = $curid;
				}
				$prev_inv_no=$prefix.$date_prefix.$formatcurid;
				$modentity_nums->my->cur_id = $curid+1;
				$modentity_nums->save('modentity_nums');
				return $prev_inv_no;
			}
			return 'EP1';*/
        }
    }
    // END

    /* Function to get the next module sequence number for a given module */
    function getModuleSeqInfo($module)
    {
        $query = XN_Query::create('Content')->tag('modentity_nums')
            ->filter('type', 'eic', 'modentity_nums')
            ->filter('my.active', '=', '1')
            ->filter('my.semodule', '=', $module)
            ->execute();
        foreach ($query as $info)
        {
            $prefix = $info->my->prefix;
            $curid = $info->my->cur_id;
        }
        return array($prefix, $curid);
    }

    /* Function to check if the mod number already exits */
    function checkModuleSeqNumber($table, $column, $no)
    {
        $query = XN_Query::create('Content')->tag($table)
            ->filter('type', 'eic', $table)
            ->filter('my.' . $column, '=', $no)
            ->execute();

        if (count($query) > 0)
            return true;
        else
            return false;
    }

    function getmoduleFields($module)
    {
        global $moduleFields;

        if (isset($moduleFields)) return $moduleFields;

        $tabid = getTabid($module);

        $fields = XN_Query::create('Content')->tag('Fields')
            ->filter('type', 'eic', 'fields')
            ->filter('my.tabid', '=', $tabid)
            ->filter('my.presence', 'in', array('0', '2'))
            ->filter('my.fieldname', 'in', $this->popup_fields)
            ->order('my.sequence', XN_Order::ASC_NUMBER)
            ->end(-1)
            ->execute();

        $moduleFields = array();

        foreach ($fields as $field_info)
        {
            $fieldlabel = $field_info->my->fieldlabel;
            /*$columnname = $field_info->my->columnname;*/
            $field_name = $field_info->my->fieldname;
            $fieldid = $field_info->my->fieldid;
            $uitype = $field_info->my->uitype;
            $width = $field_info->my->width;
            $align = $field_info->my->align;
            $relation=$field_info->my->relation;
            $moduleFields[$field_name] = array('fieldid' => $fieldid, 'fieldname' => $field_name, 'columnname' => $field_name, 'uitype' => $uitype, 'fieldlabel' => $fieldlabel, 'width' => $width, 'align' => $align,'relation'=>$relation);
        }
        return $moduleFields;
    }

    function getPopSearchFields($module)
    {
        global $popSearchFields;

        if (isset($popSearchFields)) return $popSearchFields;

        $tabid = getTabid($module);

        $fields = XN_Query::create('Content')->tag('Fields')
            ->filter('type', 'eic', 'fields')
            ->filter('my.tabid', '=', $tabid)
            ->filter('my.presence', 'in', array('0', '2'))
            ->filter('my.fieldname', 'in', $this->filter_fields)
            ->order('my.sequence', XN_Order::ASC_NUMBER)
            ->end(-1)
            ->execute();

        $popSearchFields = array();

        foreach ($fields as $field_info)
        {
            $fieldlabel = $field_info->my->fieldlabel;
            $field_name = $field_info->my->fieldname;
            $fieldid = $field_info->my->fieldid;
            $uitype = $field_info->my->uitype;
            $width = $field_info->my->width;
            $align = $field_info->my->align;
            $popSearchFields[$field_name] = array('fieldid' => $fieldid, 'fieldname' => $field_name, 'columnname' => $field_name, 'uitype' => $uitype, 'fieldlabel' => $fieldlabel, 'width' => $width, 'align' => $align);
        }
        return $popSearchFields;
    }

    function update($module, $data)
    {
        if (isset($data) && is_array($data))
        {
            foreach ($data as $key => $column_field)
            {
                $this->column_fields[$key] = $column_field;
            }
        }
        $this->save($module);
    }
}
