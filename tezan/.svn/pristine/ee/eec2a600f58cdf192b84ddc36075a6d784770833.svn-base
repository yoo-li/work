<?php

	/**
	 * Class DataSearch
	 * 查询类型说明
	 * multi_input : 多字段联合查询类型
	 * calendar : 日期查询类型
	 * multitree : 多选树类型(系统部门)
	 * radiotree : 单选树类型(系统部门)
	 * vague_input : 单字段模糊查询类型
	 * search_input : 单字段全匹配查询类型
	 * select : 下拉选择查询类型
	 * text : 文本选项,需在模块中设置显示文本 $special_search_fields
	 */

    class DataSearch
    {
        public  $basSearchFilter;
        public  $advanceSearchFilter;
        public  $addonSearchFilter;
        public  $searchField;
        public  $searchid;
        public  $basicSearchUrl     = array ();
        public  $calendarField      = array ();
        private $queryGenerator;
        private $module;
        private $tabid;
        private $focus;
        private $specialSearchField = array ();
        private $hideSearchField    = array ();
        private $basicSearchColumn  = array ();
        public $searchfields = array ();

        public function DataSearch($module, $queryGenerator, $focus = null, $hideSearchField = array ())
        {
            $this->focus          = $focus;
            $this->module         = $module;
            $this->queryGenerator = $queryGenerator;
            if (isset($focus))
            {
                $this->specialSearchField = $focus->special_search_fields;
            }
            $this->hideSearchField = $hideSearchField;
            $this->tabid           = getTabid($this->module);
            $contents              = XN_Query::create('Content')->tag('searchcolumn')
                ->filter('type', 'eic', 'searchcolumn')
                ->filter('my.tabid', '=', $this->tabid)
                ->order('my.sequence', XN_Order::ASC_NUMBER)
                ->execute();
            foreach ($contents as $content)
            {
                $this->basicSearchColumn[$content->my->fieldname] = $content;
                if ($content->my->type == "multi_input")
                {
                    $this->searchfields[] = array ("multi_input", $content->my->fieldname, $content->my->columnname);
                }
                elseif ($content->my->type == "calendar")
                {
                    $this->searchfields[] = array ("calendar", $content->my->fieldname);
                }
                elseif ($content->my->type == "multitree")
                {
                    $this->searchfields[] = array ("multitree", $content->my->fieldname);
                }
                elseif ($content->my->type == "radiotree")
                {
                    $this->searchfields[] = array ("radiotree", $content->my->fieldname);
                }
				elseif ($content->my->type == "vague_input"){
					$this->searchfields[] = array ("vague_input", $content->my->fieldname);
				}
                else
                {
                    $this->searchfields[] = $content->my->fieldname;
                }
            }
        }

        public function getBasicSearchPanel()
        {
            $module       = $this->queryGenerator->getModule();
            $meta         = $this->queryGenerator->getMeta($module);
            $moduleFields = $meta->getModuleFields();

            return $this->searchPanelHtml($this->basicSearchColumn, $module, $moduleFields, $this->hideSearchField);
        }

        public function setQuery(&$query,&$statistics="")
        {
            foreach ($this->searchfields as $searchfield)
            {
                if (is_array($searchfield))
                {
                    if ($searchfield[0] == "multi_input")
                    {
                        $input = $_REQUEST['multi_'.$searchfield[2]];
                        if (isset($input) && $input != "")
                        {
                            if (strripos($input, ",") >= 0)
                            {
                                $fields    = $searchfield[1];
                                $fieldlist = explode(",", $fields);
                                $fieldlist = array_unique($fieldlist);
                                $subquery  = array ();
                                foreach ($fieldlist as $field)
                                {
                                    if ($field == "title")
                                    {
                                        $subquery[] = XN_Filter('title', 'like', $input);
                                    }
                                    else
                                    {
                                        $subquery[] = XN_Filter("my.".$field, 'like', $input);
                                    }
                                }
                                if (count($subquery) > 0)
                                {
                                    $query->filter(XN_Filter::any($subquery));
									if ($statistics)
									{
										$statistics->filter(XN_Filter::any($subquery));
									}
                                }
                            }
                            else
                            {
                                if ($searchfield[1] == "profileid")
                                {
                                    $search = '/^1\d{8}$/';
                                    if (preg_match($search, $input))
                                    {
                                        $profile = XN_Query::create('Profile')->tag("profile")
                                            ->filter('type', '=', 'wxuser')
                                            ->filter('mobile', '=', $input)
                                            ->begin(0)->end(100)
                                            ->execute();
                                        $pids    = array ();
                                        foreach ($profile as $pinfo)
                                        {
                                            $pids[] = $pinfo->screenName;
                                        }
                                        if (count($pids) > 0)
                                        {
                                            $query->filter('my.profileid', 'in', $pids);
											if ($statistics)
											{
												$statistics->filter('my.profileid', 'in', $pids);
											}
                                        }
                                    }
                                    else
                                    {
                                        $profile = XN_Query::create('Profile')->tag("profile")
                                            ->filter('type', '=', 'wxuser')
                                            ->filter('givenname', 'like', $input)
                                            ->begin(0)->end(100)
                                            ->execute();
                                        $pids    = array ();
                                        foreach ($profile as $pinfo)
                                        {
                                            $pids[] = $pinfo->screenName;
                                        }
                                        if (count($pids) > 0)
                                        {
                                            $query->filter('my.profileid', 'in', $pids);
											if ($statistics)
											{
												$statistics->filter('my.profileid', 'in', $pids);
											}
                                        }
                                    }
                                }
                            }
                        }
                    }
                    elseif ($searchfield[0] == "calendar")
                    {
                        $queryfield = 'my.'.$searchfield[1];
                        $startdate  = '';
                        $enddate    = '';
                        if ($searchfield[1] == "published")
                        {
                            $queryfield = 'published';
                            if (isset($_REQUEST['published_startdate']) && $_REQUEST['published_startdate'] != '')
                            {
                                $startdate = date('Y-m-d H:i:s', strtotime($_REQUEST['published_startdate'].' 00:00:00'));
                            }
                            if (isset($_REQUEST['published_enddate']) && $_REQUEST['published_enddate'] != '')
                            {
                                $enddate = date('Y-m-d H:i:s', strtotime($_REQUEST['published_enddate'].' 23:59:59'));
                            }
							$thistypekey = strtolower($this->module).'published_thistype';
							
                            if ($startdate == '' && $enddate == '' && !isset($_REQUEST[$thistypekey]))
                            {  
                                switch ($this->focus->default_published_section)
                                {
                                    case 'day':
                                        $time = strtotime("today");
		                                $startdate = date("Y-m-d", $time).' 00:00:00';
		                                $enddate   = date("Y-m-d").' 23:59:59';
                                        break;
                                    case 'year':
                                        $time = strtotime('-1 year', strtotime("today"));
		                                $startdate = date("Y-m-d", $time).' 00:00:00';
		                                $enddate   = date("Y-m-d").' 23:59:59';
                                        break;
                                    default:
										if ($_SESSION['PUBLISHED_THISTYPE'] == "all")
										{
											$startdate = "";
											$enddate = ""; 
										}
										else if (!isset($_REQUEST[$thistypekey]) &&  !isset($_REQUEST['published_startdate']) && !isset($_REQUEST['published_enddate']) &&
											isset($_SESSION['PUBLISHED_STARTDATE']) && $_SESSION['PUBLISHED_STARTDATE'] != '' && 
											isset($_SESSION['PUBLISHED_ENDDATE']) && $_SESSION['PUBLISHED_ENDDATE'] != '')
										{
											$startdate = $_SESSION['PUBLISHED_STARTDATE'];
											$enddate = $_SESSION['PUBLISHED_ENDDATE']; 
										}
										else
										{
											$time =  strtotime("today");
											$newmonth = date('m', $time);
											if ($newmonth<=3)
											{
												$startdate = date("Y", $time) . "-01-01 00:00:00";
												$enddate = date("Y", $time) . "-03-31  23:59:59";
											}
											else if(3<$newmonth && $newmonth<7)
											{
												$startdate = date("Y", $time) . "-04-01 00:00:00";
												$enddate = date("Y", $time) . "-06-30  23:59:59";
											}
											else if(6<$newmonth && $newmonth<10)
											{
												$startdate = date("Y", $time) . "-07-01 00:00:00";
												$enddate = date("Y", $time) . "-09-30  23:59:59";
											}
											else
											{
												$startdate = date("Y", $time) . "-10-01 00:00:00";
												$enddate = date("Y", $time) . "-12-31  23:59:59";
											}
										}
                                        break;
                                }  
                            }  
							if ($_REQUEST[$thistypekey] == "all")
							{
								$_SESSION['PUBLISHED_THISTYPE']= "all";
								$_SESSION['PUBLISHED_STARTDATE'] = "";
								$_SESSION['PUBLISHED_ENDDATE'] = "";
							}
							else if (isset($_REQUEST[$thistypekey]) && 
								isset($_REQUEST['published_enddate']) &&
								isset($_REQUEST['published_startdate']))
							{
								$_SESSION['PUBLISHED_THISTYPE']= $_REQUEST[$thistypekey];
								$_SESSION['PUBLISHED_STARTDATE'] = $_REQUEST['published_startdate']. " 00:00:00";
								$_SESSION['PUBLISHED_ENDDATE'] = $_REQUEST['published_enddate']. " 23:59:59";
							}
							
							 
                        }
                        else
                        {
                            if (isset($_REQUEST[$searchfield[1].'_startdate']) && $_REQUEST[$searchfield[1].'_startdate'] != '')
                            {
                                $startdate = date('Y-m-d H:i:s', strtotime($_REQUEST[$searchfield[1].'_startdate'].' 00:00:00'));
                            }
                            if (isset($_REQUEST[$searchfield[1].'_enddate']) && $_REQUEST[$searchfield[1].'_enddate'] != '')
                            {
                                $enddate = date('Y-m-d H:i:s', strtotime($_REQUEST[$searchfield[1].'_enddate'].' 23:59:59'));
                            }
                        }
                        if ($startdate != '' && $enddate != "")
                        {
                             $query->filter($queryfield, '>=', $startdate);
							 $query->filter($queryfield, '<=', $enddate);
							 if ($statistics)
							 {
								$statistics->filter($queryfield, '>=', $startdate);
								$statistics->filter($queryfield, '<=', $enddate);
							 }
                        } 
						
                    }
                    elseif ($searchfield[0] == "multitree")
                    {
                        if (isset($_REQUEST[$searchfield[1]."_id"]) && $_REQUEST[$searchfield[1]."_id"] != '')
                        {
                            $values     = $_REQUEST[$searchfield[1]."_id"];
                            $valueslist = explode(";", $values);
                            $valueslist = array_unique($valueslist);
                            $query->filter('my.'.$searchfield[1], 'in', $valueslist);
							if ($statistics)
							{
								$statistics->filter('my.'.$searchfield[1], 'in', $valueslist); 
							}
                        }
                    }
                    elseif ($searchfield[0] == "radiotree")
                    {
                        if (isset($_REQUEST[$searchfield[1]."_id"]) && $_REQUEST[$searchfield[1]."_id"] != '')
                        {
                            $query->filter('my.'.$searchfield[1], '=', $_REQUEST[$searchfield[1]."_id"]);
							if ($statistics)
							{
								$statistics->filter('my.'.$searchfield[1], '=', $_REQUEST[$searchfield[1]."_id"]);
							}
                        }
                    }
					elseif ($searchfield[0] == "vague_input"){
						if (isset($_REQUEST[$searchfield[1]]) && $_REQUEST[$searchfield[1]] != '')
						{
							$query->filter('my.'.$searchfield[1], 'like', $_REQUEST[$searchfield[1]]);
							if ($statistics)
							{
								$statistics->filter('my.'.$searchfield[1], 'like', $_REQUEST[$searchfield[1]]);
							}
						}
						elseif (isset($_REQUEST['search_'.$searchfield[1]]) && $_REQUEST['search_'.$searchfield[1]] != '')
						{
							$query->filter('my.'.$searchfield[1], 'like', $_REQUEST['search_'.$searchfield[1]]);
							if ($statistics)
							{
								$statistics->filter('my.'.$searchfield[1], 'like', $_REQUEST['search_'.$searchfield[1]]);
							}
						}
					}
                }
                else
                {
					if (isset($_REQUEST['profileid']) && $_REQUEST['profileid'] != '' && $searchfield == "profileid")
					{
					    $input=$_REQUEST['profileid'];
					    if($input != ""){
					        $pattern ='/^(1(([35][0-9])|(47)|[8][0126789]))\d{8}$/';
					        if(preg_match($pattern,$input))
					        {
					            $profile = XN_Query::create ( 'Profile' ) ->tag("profile")
					                ->filter('type','=','wxuser')
					                ->filter('mobile','=',$input)
					                ->begin(0)->end(100)
					                ->execute();
					            $pids = array();
					            foreach($profile as $pinfo){
					                $pids[] = $pinfo->screenName;
					            }
					            if(count($pids)>0){
					                $query->filter('my.profileid','in',$pids);
									if ($statistics)
									{
						                $statistics->filter('my.profileid','in',$pids);
									}
					            }
					        }
					        else
					        {
					            $profile = XN_Query::create ( 'Profile' ) ->tag("profile")
					                ->filter('type','=','wxuser')
					                ->filter('givenname','like',$input)
					                ->begin(0)->end(100)
					                ->execute();
					            $pids = array();
					            foreach($profile as $pinfo){
					                $pids[] = $pinfo->screenName;
					            }
					            if(count($pids)>0)
					            {
					                $query->filter('my.profileid','in',$pids);
									if ($statistics)
									{
						                $statistics->filter('my.profileid','in',$pids);
									}
					            }
					        }
					    }
					}
                    elseif (isset($_REQUEST[$searchfield]) && $_REQUEST[$searchfield] != '')
                    {
                        $query->filter('my.'.$searchfield, '=', $_REQUEST[$searchfield]);
						if ($statistics)
						{
							$statistics->filter('my.'.$searchfield, '=', $_REQUEST[$searchfield]);
						}
                    }
                    elseif (isset($_REQUEST['search_'.$searchfield]) && $_REQUEST['search_'.$searchfield] != '')
                    {
                        $query->filter('my.'.$searchfield, '=', $_REQUEST['search_'.$searchfield]);
						if ($statistics)
						{
							$statistics->filter('my.'.$searchfield, '=', $_REQUEST['search_'.$searchfield]);
						}
                    }
                }
            }
            if (isset($_REQUEST["explode"]) && $_REQUEST["explode"] != "")
            {
                $explode = explode(',', $_REQUEST["explode"]);
                $explode = array_unique($explode);
                $query->filter('id', 'in', $explode);
				if ($statistics)
				{
					$statistics->filter('id', 'in', $explode);
				}
            }
        }

        public function getCalendarHtml($fieldname){
			$mod       = $this->queryGenerator->getModule();
			$startdate = "";
			$enddate   = "";
			$thistype  = "";
			if ($_SESSION['PUBLISHED_THISTYPE'] == "all")
			{
				$startdate = "";
				$enddate = ""; 
				$thistype = "all";
			}
			else
			{
				if (isset($_REQUEST[$fieldname.'_startdate']) && isset($_REQUEST[$fieldname.'_enddate']))
				{
					$startdate = $_REQUEST[$fieldname.'_startdate'];
					$enddate   = $_REQUEST[$fieldname.'_enddate'];
				}
				if (isset($_REQUEST[$mod.$fieldname.'_thistype']))
				{
					$thistype = $_REQUEST[$mod.$fieldname.'_thistype'];
				}
			}  
			$searchpaneHtml = '<a href="javascript:;" id="'.$mod.$fieldname.'_all" for="'.$mod.$fieldname.'_period" '.($thistype == "all" ? 'class="over"' : '').' title="全部">全部</a>
					<a href="javascript:;" id="'.$mod.$fieldname.'_thisyear" for="'.$mod.$fieldname.'_period" '.($thistype == "thisyear" ? 'class="over"' : '').' title="本年">本年</a>
					<a href="javascript:;" id="'.$mod.$fieldname.'_thisquater" for="'.$mod.$fieldname.'_period" '.($thistype == "thisquater" ? 'class="over"' : '').' title="本季">本季</a>
					<a href="javascript:;" id="'.$mod.$fieldname.'_thismonth" for="'.$mod.$fieldname.'_period" '.($thistype == "thismonth" ? 'class="over"' : '').' title="本月">本月</a>
					<a href="javascript:;" id="'.$mod.$fieldname.'_recently" for="'.$mod.$fieldname.'_period" '.($thistype == "recently" ? 'class="over"' : '').' title="最近">最近</a>
					<input type="text" name="'.$fieldname.'_startdate" id="'.$mod.$fieldname.'_startdate" value="'.$startdate.'" readonly data-toggle="datepicker" data-rule="date" size="11">
					-
					<input type="text" name="'.$fieldname.'_enddate" id="'.$mod.$fieldname.'_enddate" value="'.$enddate.'" readonly data-toggle="datepicker" data-rule="date" size="11">
					<input value="'.$thistype.'" type="hidden" id="'.$mod.$fieldname.'_thistype" name="'.$mod.$fieldname.'_thistype" />
					<script type="text/javascript">
						$(document).ready(function()
						{
							$(\'a[for="'.$mod.$fieldname.'_period"]\').each(function(){
								$(this).click('.$mod.$fieldname.'_period_onclick);
								});
						});
						$("#'.$mod.$fieldname.'_startdate").on("afterchange.bjui.datepicker", function(e, data) {
							$("#'.$mod.$fieldname.'_thistype").val("custom");
							$(\'a[for="'.$mod.$fieldname.'_period"]\').toggleClass("over",false);
						});
						$("#'.$mod.$fieldname.'_enddate").on("afterchange.bjui.datepicker", function(e, data) {
							$("#'.$mod.$fieldname.'_thistype").val("custom");
							$(\'a[for="'.$mod.$fieldname.'_period"]\').toggleClass("over",false);
						});
						function '.$mod.$fieldname.'_period_onclick() {
							$(\'a[for="'.$mod.$fieldname.'_period"]\').toggleClass("over",false);
							$(this).addClass("over");	
							var dt = new Date();
		                    if ($(this).attr("id")=="'.$mod.$fieldname.'_all"){
								var start = "";
								var end = "";
		                        $("#'.$mod.$fieldname.'_thistype").val("all");
							}else if ($(this).attr("id")=="'.$mod.$fieldname.'_thisyear")
							{
								var start = dt.getFullYear() + "-01-01";
								var end = dt.getFullYear() + "-12-31";
								$("#'.$mod.$fieldname.'_thistype").val("thisyear");
							}
							else if ($(this).attr("id")=="'.$mod.$fieldname.'_thisquater")
							{
								var nowMonth = dt.getMonth()+1; 
								if (nowMonth<=3) 
								{    
									var start = dt.getFullYear() + "-01-01";
									var end = dt.getFullYear() + "-03-31";   
								}
								else if(3<nowMonth && nowMonth<7)
								{     
									var start = dt.getFullYear() + "-04-01";
									var end = dt.getFullYear() + "-06-30";     
								}
								else if(6<nowMonth && nowMonth<10)
								{    
									var start = dt.getFullYear() + "-07-01";
									var end = dt.getFullYear() + "-09-30";     
							    }     
							    else
							   {   
							      var start = dt.getFullYear() + "-10-01";
								  var end = dt.getFullYear() + "-12-31";     
							   }
							   $("#'.$mod.$fieldname.'_thistype").val("thisquater");
							}
							else if ($(this).attr("id")=="'.$mod.$fieldname.'_recently")
							{
						      var start = "'.date("Y-m-d", strtotime('-1 month', strtotime("today"))).'";
							  var end = "'.date("Y-m-d").'";
							  $("#'.$mod.$fieldname.'_thistype").val("recently");
							}
							else 
							{
								var nowMonth = dt.getMonth()+1; 
								if(nowMonth < 10){
									nowMonth = "0" + nowMonth;
								}
								var nowDay = dt.getDate();
								if(nowDay < 10){
									nowDay = "0" + nowDay;
								}
								var start = dt.getFullYear() + "-" + nowMonth + "-01";
								var end = dt.getFullYear() + "-" + nowMonth + "-" + nowDay;
								$("#'.$mod.$fieldname.'_thistype").val("thismonth");
							}
							$("#'.$mod.$fieldname.'_startdate").val(start);
							$("#'.$mod.$fieldname.'_enddate").val(end);
						}
					</script>
				';
			return $searchpaneHtml;
		}

        private function searchPanelHtml($searchColumn, $module, $moduleFields, $hideFields = array ())
        {
            $searchpanel = array ();
            $fields      = array_keys($moduleFields);
            foreach ($searchColumn as $info)
            {
                $newline = $info->my->newline;
                if (in_array($info->my->fieldname, $hideFields))
                {
                    continue;
                }
                $options                       = array ();
                $fieldname                     = $info->my->fieldname;
                $this->searchField[$fieldname] = $fieldname;
                if ($info->my->type == 'hidden')
                {
                    continue;
                }
                $translatedString = getTranslatedString($info->my->fieldlabel);
                if ($info->my->type == 'multi_input')
                {
                    if ($info->my->unit)
                    {
                        $unit = $info->my->unit;
                    }
                    if ($info->my->width)
                    {
                        $width = $info->my->width;
                    }
                    $columnname = "";
                    if ($info->my->columnname)
                    {
                        $columnname = $info->my->columnname;
                    }
                    $tip            = getTranslatedString($info->my->tip);
                    $value          = $_REQUEST['multi_'.$columnname];
                    $searchpaneHtml = '<input type="text" name="multi_'.$columnname.'" id="'.$module.'_'.$columnname.'_multi_input" value="'.$value.'" '.($width > 0 ? "style=width:".$width."px;" : "size=20").' placeholder="'.$tip.'">'.$unit;
                    if ($newline == 'true')
                    {
                        $searchpanel[$translatedString] = array ('search' => $searchpaneHtml, 'newline' => 'true');
                    }
                    else
                    {
                        $searchpanel[$translatedString] = $searchpaneHtml;
                    }
                    continue;
                }
                elseif ($info->my->type == 'input')
                {
                    if ($info->my->unit)
                    {
                        $unit = $info->my->unit;
                    }
                    if ($info->my->width)
                    {
                        $width = $info->my->width;
                    }
                    $tip            = getTranslatedString($info->my->tip);
                    $value          = $_REQUEST[$fieldname];
                    $searchpaneHtml = '<input type="text" name="'.$fieldname.'" id="'.$module.$fieldname.'_search_input" value="'.$value.'" '.($width > 0 ? "style=width:".$width."px;" : "size=20").' placeholder="'.$tip.'">'.$unit;
                    if ($newline == 'true')
                    {
                        $searchpanel[$translatedString] = array ('search' => $searchpaneHtml, 'newline' => 'true');
                    }
                    else
                    {
                        $searchpanel[$translatedString] = $searchpaneHtml;
                    }
                    continue;
                }
                elseif ($info->my->type == 'search_input' || $info->my->type == 'vague_input')
                {
                    if ($info->my->unit)
                    {
                        $unit = $info->my->unit;
                    }
                    if ($info->my->width)
                    {
                        $width = $info->my->width;
                    }
                    $tip            = getTranslatedString($info->my->tip);
                    $value          = $_REQUEST[$fieldname];
                    $searchpaneHtml = '<input type="text" name="'.$fieldname.'" id="'.$module.$fieldname.'_search_input" value="'.$value.'" '.($width > 0 ? "style=width:".$width."px;" : "size=20").' placeholder="'.$tip.'">'.$unit;
                    if ($newline == 'true')
                    {
                        $searchpanel[$translatedString] = array ('search' => $searchpaneHtml, 'newline' => 'true');
                    }
                    else
                    {
                        $searchpanel[$translatedString] = $searchpaneHtml;
                    }
                    continue;
                }
                elseif ($info->my->type == 'calendar')
                {
                    $mod       = strtolower($module);
                    $startdate = "";
                    $enddate   = "";
                    $thistype  = "";
                    if ($fieldname == "published")
                    {
                        switch ($this->focus->default_published_section)
                        {
                            case 'day':
                                $time = strtotime("today");
		                        $startdate = date("Y-m-d", $time);
		                        $enddate   = date("Y-m-d"); 
                                break;
                            case 'year':
                                $time = strtotime('-1 year', strtotime("today"));
		                        $startdate = date("Y-m-d", $time);
		                        $enddate   = date("Y-m-d");
		                        $thistype  = "thisyear";
                                break;
                            case 'month':
                                $time = strtotime('-1 month', strtotime("today"));
		                        $startdate = date("Y-m-d", $time);
		                        $enddate   = date("Y-m-d");
		                        $thistype  = "recently";
                                break;
							default: 
								$thistypekey = strtolower($this->module).'published_thistype';
								if ($_SESSION['PUBLISHED_THISTYPE'] == "all")
								{
									$startdate = "";
									$enddate = ""; 
								}
								else if (!isset($_REQUEST[$thistypekey]) &&  !isset($_REQUEST['published_startdate']) && !isset($_REQUEST['published_enddate']) &&
									isset($_SESSION['PUBLISHED_STARTDATE']) && $_SESSION['PUBLISHED_STARTDATE'] != '' && 
									isset($_SESSION['PUBLISHED_ENDDATE']) && $_SESSION['PUBLISHED_ENDDATE'] != '')
								{
									$startdate = $_SESSION['PUBLISHED_STARTDATE'];
									$enddate = $_SESSION['PUBLISHED_ENDDATE'];
									$thistype = $_SESSION['PUBLISHED_THISTYPE'];
									$startdate = date('Y-m-d', strtotime($startdate));
									$enddate = date('Y-m-d', strtotime($enddate)); 
								}
								else
								{
//		                            $time = strtotime('-1 month', strtotime("today"));
//			                        $startdate = date("Y-m-d", $time);
//			                        $enddate   = date("Y-m-d");
//			                        $thistype  = "recently";
									//默认本季 
									$time =  strtotime("today");
									$newmonth = date('m', $time);
									if ($newmonth<=3)
									{
										$startdate = date("Y", $time) . "-01-01";
										$enddate = date("Y", $time) . "-03-31";
									}
									else if(3<$newmonth && $newmonth<7)
									{
										$startdate = date("Y", $time) . "-04-01";
										$enddate = date("Y", $time) . "-06-30";
									}
									else if(6<$newmonth && $newmonth<10)
									{
										$startdate = date("Y", $time) . "-07-01";
										$enddate = date("Y", $time) . "-09-30";
									}
									else
									{
										$startdate = date("Y", $time) . "-10-01";
										$enddate = date("Y", $time) . "-12-31";
									}
									$thistype  = "thisquater";
								}
								break;
                        }
                       
                    }
                    if (isset($_REQUEST[$fieldname.'_startdate']) && isset($_REQUEST[$fieldname.'_enddate']))
                    {
                        $startdate = $_REQUEST[$fieldname.'_startdate'];
                        $enddate   = $_REQUEST[$fieldname.'_enddate'];
                    }
                    if (isset($_REQUEST[$mod.$fieldname.'_thistype']))
                    {
                        $thistype = $_REQUEST[$mod.$fieldname.'_thistype'];
                    }
					
                    $searchpaneHtml = '<a href="javascript:;" id="'.$mod.$fieldname.'_all" for="'.$mod.$fieldname.'_period" '.($thistype == "all" ? 'class="over"' : '').' title="全部">全部</a>
					<a href="javascript:;" id="'.$mod.$fieldname.'_thisyear" for="'.$mod.$fieldname.'_period" '.($thistype == "thisyear" ? 'class="over"' : '').' title="本年">本年</a>
					<a href="javascript:;" id="'.$mod.$fieldname.'_thisquater" for="'.$mod.$fieldname.'_period" '.($thistype == "thisquater" ? 'class="over"' : '').' title="本季">本季</a>
					<a href="javascript:;" id="'.$mod.$fieldname.'_thismonth" for="'.$mod.$fieldname.'_period" '.($thistype == "thismonth" ? 'class="over"' : '').' title="本月">本月</a>
					<a href="javascript:;" id="'.$mod.$fieldname.'_recently" for="'.$mod.$fieldname.'_period" '.($thistype == "recently" ? 'class="over"' : '').' title="最近">最近</a>
					<input type="text" name="'.$fieldname.'_startdate" id="'.$mod.$fieldname.'_startdate" value="'.$startdate.'" readonly data-toggle="datepicker" data-rule="date" size="11">
					-
					<input type="text" name="'.$fieldname.'_enddate" id="'.$mod.$fieldname.'_enddate" value="'.$enddate.'" readonly data-toggle="datepicker" data-rule="date" size="11">
					<input value="'.$thistype.'" type="hidden" id="'.$mod.$fieldname.'_thistype" name="'.$mod.$fieldname.'_thistype" />
					<script type="text/javascript">
						$(document).ready(function()
						{
							$(\'a[for="'.$mod.$fieldname.'_period"]\').each(function(){
								$(this).click('.$mod.$fieldname.'_period_onclick);
								});
						});
						$("#'.$mod.$fieldname.'_startdate").on("afterchange.bjui.datepicker", function(e, data) {
							$("#'.$mod.$fieldname.'_thistype").val("custom");
							$(\'a[for="'.$mod.$fieldname.'_period"]\').toggleClass("over",false);
						});
						$("#'.$mod.$fieldname.'_enddate").on("afterchange.bjui.datepicker", function(e, data) {
							$("#'.$mod.$fieldname.'_thistype").val("custom");
							$(\'a[for="'.$mod.$fieldname.'_period"]\').toggleClass("over",false);
						});
						function '.$mod.$fieldname.'_period_onclick() {
							$(\'a[for="'.$mod.$fieldname.'_period"]\').toggleClass("over",false);
							$(this).addClass("over");	
							var dt = new Date();
		                    if ($(this).attr("id")=="'.$mod.$fieldname.'_all"){
								var start = "";
								var end = "";
		                        $("#'.$mod.$fieldname.'_thistype").val("all");
							}else if ($(this).attr("id")=="'.$mod.$fieldname.'_thisyear")
							{
								var start = dt.getFullYear() + "-01-01";
								var end = dt.getFullYear() + "-12-31";
								$("#'.$mod.$fieldname.'_thistype").val("thisyear");
							}
							else if ($(this).attr("id")=="'.$mod.$fieldname.'_thisquater")
							{
								var nowMonth = dt.getMonth()+1; 
								if (nowMonth<=3) 
								{    
									var start = dt.getFullYear() + "-01-01";
									var end = dt.getFullYear() + "-03-31";   
								}
								else if(3<nowMonth && nowMonth<7)
								{     
									var start = dt.getFullYear() + "-04-01";
									var end = dt.getFullYear() + "-06-30";     
								}
								else if(6<nowMonth && nowMonth<10)
								{    
									var start = dt.getFullYear() + "-07-01";
									var end = dt.getFullYear() + "-09-30";     
							    }     
							    else
							   {   
							      var start = dt.getFullYear() + "-10-01";
								  var end = dt.getFullYear() + "-12-31";     
							   }
							   $("#'.$mod.$fieldname.'_thistype").val("thisquater");
							}
							else if ($(this).attr("id")=="'.$mod.$fieldname.'_recently")
							{
						      var start = "'.date("Y-m-d", strtotime('-1 month', strtotime("today"))).'";
							  var end = "'.date("Y-m-d").'";
							  $("#'.$mod.$fieldname.'_thistype").val("recently");
							}
							else 
							{
								var nowMonth = dt.getMonth()+1; 
								if(nowMonth < 10){
									nowMonth = "0" + nowMonth;
								}
								var nowDay = dt.getDate();
								if(nowDay < 10){
									nowDay = "0" + nowDay;
								}
								var start = dt.getFullYear() + "-" + nowMonth + "-01";
								var end = dt.getFullYear() + "-" + nowMonth + "-" + nowDay;
								$("#'.$mod.$fieldname.'_thistype").val("thismonth");
							}
							$("#'.$mod.$fieldname.'_startdate").val(start);
							$("#'.$mod.$fieldname.'_enddate").val(end);
						}
					</script>
				';
                    if ($newline == 'true')
                    {
                        $searchpanel[$translatedString] = array ('search' => $searchpaneHtml, 'newline' => 'true');
                    }
                    else
                    {
                        $searchpanel[$translatedString] = $searchpaneHtml;
                    }
                    continue;
                }
                elseif (in_array($fieldname, $fields))
                {
                    $fielddatatype = $moduleFields[$fieldname]->getFieldDataType();
					
                    if (count($this->specialSearchField) > 0 && array_key_exists($fieldname, $this->specialSearchField))
                    {
                        $fieldInfoArr = $this->specialSearchField[$fieldname];
                        foreach ($fieldInfoArr as $key => $fieldInfo)
                        {
                            $options[$key] = getTranslatedString($fieldInfo["label"]);
                        }
                    }
                    elseif ($fielddatatype == "picklist")
                    {
                        require_once "modules/PickList/PickListUtils.php";
						if($moduleFields[$fieldname]->getUIType() == '116'){
							$options = getAssignedPicklistValues($info->my->fieldname);
						}else
						{
							$options = getTranslatePicklistByName($info->my->fieldname);
						}
                        //$options = getPicklistByName($info->my->fieldname);
                    }
                    elseif ($fielddatatype == "owner")
                    {
                        $users = XN_Query::create("Content")->tag("users")
                            ->filter("type", "eic", "users")
                            ->filter("my.deleted", "=", "0")
                            ->execute();
                        foreach ($users as $user)
                        {
                            $profileid = $user->my->profileid;
                            $givename  = $user->my->givename;
                            if (isset($givename) && $givename != "")
                            {
                                $options[$profileid] = $user->my->givename;
                            }
                            else
                            {
                                $options[$profileid] = $user->my->last_name;
                            }
                        }
                    }
                    elseif ($fielddatatype == "reference")
                    { 
                        /*  BUG 不可能取出所有的数据进行筛选
						$referenceFieldInfoList = $this->queryGenerator->getReferenceFieldInfoList();
                        $module                 = $referenceFieldInfoList[$fieldname][0];
                        $options                = getEntityNameAllValues($module);*/
                    }
                }
                if ($info->my->type == 'select')
                {
                    $searchpaneHtml = "<select data-toggle=\"selectpicker\" id=\"search_".$fieldname."\" name=\"search_".$fieldname."\">";
                    if (empty($options))
                    {
                        require_once 'modules/PickList/PickListUtils.php';
                        $options = getAssignedPicklistValues($fieldname);
                    }

                    $searchpaneHtml .= "<option value=''>".getTranslatedString('All')."</option>";
                    if (count($options) > 0)
                    {
                        foreach ($options as $key => $value)
                        {
                            if ($key == $_REQUEST["search_".$fieldname])
                                $searchpaneHtml .= "<option selected value='$key'>$value</option>";
                            else $searchpaneHtml .= "<option value='$key'>$value</option>";
                        }
                    }
                    $searchpaneHtml .= '</select>';
                    if ($newline == 'true')
                    {
                        $searchpanel[$translatedString] = array ('search' => $searchpaneHtml, 'newline' => 'true');
                    }
                    else
                    {
                        $searchpanel[$translatedString] = $searchpaneHtml;
                    }
                }
                elseif ($info->my->type == 'profile')
                {
                    echo 'profile';
                    die();
                }
                elseif ($info->my->type == 'text')
                {
                    $mod            = strtolower($module);
                    $searchpaneHtml = '';
                    if (is_array($options) && count($options) > 0)
                    {
                        foreach ($options as $key => $value)
                        {
                            $over = "";
                            if ($key == $_REQUEST[$fieldname])
                            {
                                $over = 'class="over"';
                            }
                            $searchpaneHtml .= '<a href="javascript:;" '.$over.' for="'.$mod.$fieldname.'_period" data-key="'.$key.'" title="'.$value.'" style="margin:auto 1px;">'.$value.'</a>&nbsp;';
                        }
                        $searchpaneHtml .= '<input value="'.$_REQUEST[$fieldname].'" type="hidden" id="search_'.$mod.$fieldname.'" name="'.$fieldname.'" />
						<script type="text/javascript">
							$(document).ready(function()
							{
								$(\'a[for="'.$mod.$fieldname.'_period"]\').each(function(){
									$(this).click('.$mod.$fieldname.'_period_onclick);
									});
							});
							function '.$mod.$fieldname.'_period_onclick() {
								var hasClass = true;
								if ($(this).hasClass("over")){
									hasClass = false;
								}
								$(\'a[for="'.$mod.$fieldname.'_period"]\').toggleClass("over",false);
								if (hasClass){
									$(this).addClass("over");
									$(\'#search_'.$mod.$fieldname.'\').val($(this).data("key"));
								}else{
									$(\'#search_'.$mod.$fieldname.'\').val("");
								}
							}
						</script>
					';
                    }
                    if ($newline == 'true')
                    {
                        $searchpanel[$translatedString] = array ('search' => $searchpaneHtml, 'newline' => 'true');
                    }
                    else
                    {
                        $searchpanel[$translatedString] = $searchpaneHtml;
                    }
                }
                elseif ($info->my->type == 'multitree')
                {
                    if ($info->my->fieldname == 'roleid')
                    {
                        $defvalue = "全部";
                        if (isset($_REQUEST[$fieldname.'_name']) && $_REQUEST[$fieldname.'_name'] != "")
                        {
                            $defvalue = $_REQUEST[$fieldname.'_name'];
                        }
                        $mod = strtolower($module);
                        require_once('include/utils/UserInfoUtil.php');
                        $roleout = '';
                        createGenericRoleTree($roleout, getGenericRoleTree(), $_REQUEST[$fieldname.'_id'], null, false, false, false);
                        $roleout        = '<ul id="searchbar_'.$fieldname.'_ztree" class="ztree hide"
									data-toggle="ztree" 
									data-check-enable="true" 
									data-chk-style="checkbox"
									data-setting="{check:{chkboxType:{\'Y\':\'\',\'N\':\'\'}}}"
									data-on-check="searchbar_'.$fieldname.'_ztree_nodecheck" 
									data-on-click="searchbar_'.$fieldname.'_ztree_nodeclick"
									data-expand-all="true">'.$roleout.'</ul>';
                        $searchpaneHtml = '<input type="hidden" value="'.$_REQUEST[$fieldname.'_id'].'" name="'.$fieldname.'.id" id="'.$fieldname.'_id">
						<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;">
							<input type="text" name="'.$fieldname.'.name" id="'.$fieldname.'_name" value="'.$defvalue.'" data-toggle="selectztree" data-tree="#searchbar_'.$fieldname.'_ztree" data-value="#'.$fieldname.'_id" size="20" style="padding-right: 25px;cursor: pointer;" readonly>
							<a class="bjui-lookup" href="javascript:;" onclick="javascript:searchbar_'.$fieldname.'_lookupclick(this);" style="height: 22px; line-height: 22px;">
								<i class="fa fa-search"></i>
							</a>
						</span>
						'.$roleout.'
						<script language="javascript" type="text/javascript">
							function searchbar_'.$fieldname.'_lookupclick(obj){
								var valueObj = $(obj).parent().find("input[id='.$fieldname.'_name]");
								valueObj.focus();
								valueObj.trigger("click");
							}
							function searchbar_'.$fieldname.'_ztree_nodecheck(event, treeId, treeNode) {
								var zTree = $.fn.zTree.getZTreeObj(treeId),
									nodes = zTree.getCheckedNodes(true)
								var ids = "", names = ""
								for (var i = 0; i < nodes.length; i++) {
									ids   += ";"+ nodes[i].id
									names += ";"+ nodes[i].name
								}
								if (ids.length > 0) {
									ids = ids.substr(1), names = names.substr(1)
								}
								if (names == "") {
									names = "全部"
								}
								var $from = $("#"+ treeId).data("fromObj")
								if ($from && $from.length) {
									$from.val(names).trigger("validate")
									var $fromvalue = $($("#"+ treeId).data("fromObj").data("value"));
									if ($fromvalue && $fromvalue.length) {
										$fromvalue.val(ids).trigger("validate")
									}
								}
							}
			
							function searchbar_'.$fieldname.'_ztree_nodeclick(event, treeId, treeNode) {
								var zTree = $.fn.zTree.getZTreeObj(treeId)
								zTree.checkNode(treeNode, !treeNode.checked, true, true)
								event.preventDefault()
							}
						</script>
					';
                        if ($newline == 'true')
                        {
                            $searchpanel[$translatedString] = array ('search' => $searchpaneHtml, 'newline' => 'true');
                        }
                        else
                        {
                            $searchpanel[$translatedString] = $searchpaneHtml;
                        }
                    }
                }
                elseif ($info->my->type == 'radiotree')
                {
                    if ($info->my->fieldname == 'roleid')
                    {
                        $defvalue = "全部";
                        if (isset($_REQUEST[$fieldname.'_name']) && $_REQUEST[$fieldname.'_name'] != "")
                        {
                            $defvalue = $_REQUEST[$fieldname.'_name'];
                        }
                        $mod = strtolower($module);
                        require_once('include/utils/UserInfoUtil.php');
                        $roleout = '';
                        createGenericRoleTree($roleout, getGenericRoleTree(), $_REQUEST[$fieldname.'_id'], null, false, false, false);
                        $roleout        = '<ul id="searchbar_'.$fieldname.'_ztree" class="ztree hide"
									data-toggle="ztree" 
									data-check-enable="true" 
									data-chk-style="radio"
									data-radio-type="all"
									data-on-check="searchbar_'.$fieldname.'_ztree_nodecheck" 
									data-on-click="searchbar_'.$fieldname.'_ztree_nodeclick"
									data-expand-all="true">'.$roleout.'</ul>';
                        $searchpaneHtml = '<input type="hidden" value="'.$_REQUEST[$fieldname.'_id'].'" name="'.$fieldname.'.id" id="'.$fieldname.'_id">
						<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;">
							<input type="text" name="'.$fieldname.'.name" id="'.$fieldname.'_name" value="'.$defvalue.'" data-toggle="selectztree" data-tree="#searchbar_'.$fieldname.'_ztree" data-value="#'.$fieldname.'_id" size="20" style="padding-right: 25px;" readonly>
							<a class="bjui-lookup" href="javascript:;" onclick="javascript:searchbar_'.$fieldname.'_lookupclick(this);" style="height: 22px; line-height: 22px;">
								<i class="fa fa-search"></i>
							</a>
						</span>
						'.$roleout.'
						<script language="javascript" type="text/javascript">
							function searchbar_'.$fieldname.'_lookupclick(){
								var valueObj = $(obj).parent().find("input[id='.$fieldname.'_name]");
								valueObj.focus();
								valueObj.trigger("click");
							}
							function searchbar_'.$fieldname.'_ztree_nodecheck(event, treeId, treeNode) {
								var zTree = $.fn.zTree.getZTreeObj(treeId),
									nodes = zTree.getCheckedNodes(true)
								var ids = "", names = ""
								for (var i = 0; i < nodes.length; i++) {
									ids   += ";"+ nodes[i].id
									names += ";"+ nodes[i].name
								}
								if (ids.length > 0) {
									ids = ids.substr(1), names = names.substr(1)
								}
								if (names == "") {
									names = "全部"
								}
								var $from = $("#"+ treeId).data("fromObj")
								if ($from && $from.length) {
									$from.val(names).trigger("validate")
									var $fromvalue = $($("#"+ treeId).data("fromObj").data("value"));
									if ($fromvalue && $fromvalue.length) {
										$fromvalue.val(ids).trigger("validate")
									}
								}
							}
			
							function searchbar_'.$fieldname.'_ztree_nodeclick(event, treeId, treeNode) {
								var zTree = $.fn.zTree.getZTreeObj(treeId)
								zTree.checkNode(treeNode, !treeNode.checked, true, true)
								event.preventDefault()
							}
						</script>
					';
                        if ($newline == 'true')
                        {
                            $searchpanel[$translatedString] = array ('search' => $searchpaneHtml, 'newline' => 'true');
                        }
                        else
                        {
                            $searchpanel[$translatedString] = $searchpaneHtml;
                        }
                    }
                }
            }

            return $searchpanel;
        }

    }