<?php
//世纪万年历 
//#农历每月的天数 
$everymonth=array( 
0=>array(8,0,0,0,0,0,0,0,0,0,0,0,29,30,7,1), 
1=>array(0,29,30,29,29,30,29,30,29,30,30,30,29,0,8,2), 
2=>array(0,30,29,30,29,29,30,29,30,29,30,30,30,0,9,3), 
3=>array(5,29,30,29,30,29,29,30,29,29,30,30,29,30,10,4), 
4=>array(0,30,30,29,30,29,29,30,29,29,30,30,29,0,1,5), 
5=>array(0,30,30,29,30,30,29,29,30,29,30,29,30,0,2,6), 
6=>array(4,29,30,30,29,30,29,30,29,30,29,30,29,30,3,7), 
7=>array(0,29,30,29,30,29,30,30,29,30,29,30,29,0,4,8), 
8=>array(0,30,29,29,30,30,29,30,29,30,30,29,30,0,5,9), 
9=>array(2,29,30,29,29,30,29,30,29,30,30,30,29,30,6,10), 
10=>array(0,29,30,29,29,30,29,30,29,30,30,30,29,0,7,11), 
11=>array(6,30,29,30,29,29,30,29,29,30,30,29,30,30,8,12), 
12=>array(0,30,29,30,29,29,30,29,29,30,30,29,30,0,9,1), 
13=>array(0,30,30,29,30,29,29,30,29,29,30,29,30,0,10,2), 
14=>array(5,30,30,29,30,29,30,29,30,29,30,29,29,30,1,3), 
15=>array(0,30,29,30,30,29,30,29,30,29,30,29,30,0,2,4), 
16=>array(0,29,30,29,30,29,30,30,29,30,29,30,29,0,3,5), 
17=>array(2,30,29,29,30,29,30,30,29,30,30,29,30,29,4,6), 
18=>array(0,30,29,29,30,29,30,29,30,30,29,30,30,0,5,7), 
19=>array(7,29,30,29,29,30,29,29,30,30,29,30,30,30,6,8), 
20=>array(0,29,30,29,29,30,29,29,30,30,29,30,30,0,7,9), 
21=>array(0,30,29,30,29,29,30,29,29,30,29,30,30,0,8,10), 
22=>array(5,30,29,30,30,29,29,30,29,29,30,29,30,30,9,11), 
23=>array(0,29,30,30,29,30,29,30,29,29,30,29,30,0,10,12), 
24=>array(0,29,30,30,29,30,30,29,30,29,30,29,29,0,1,1), 
25=>array(4,30,29,30,29,30,30,29,30,30,29,30,29,30,2,2), 
26=>array(0,29,29,30,29,30,29,30,30,29,30,30,29,0,3,3), 
27=>array(0,30,29,29,30,29,30,29,30,29,30,30,30,0,4,4), 
28=>array(2,29,30,29,29,30,29,29,30,29,30,30,30,30,5,5), 
29=>array(0,29,30,29,29,30,29,29,30,29,30,30,30,0,6,6), 
30=>array(6,29,30,30,29,29,30,29,29,30,29,30,30,29,7,7), 
31=>array(0,30,30,29,30,29,30,29,29,30,29,30,29,0,8,8), 
32=>array(0,30,30,30,29,30,29,30,29,29,30,29,30,0,9,9), 
33=>array(5,29,30,30,29,30,30,29,30,29,30,29,29,30,10,10), 
34=>array(0,29,30,29,30,30,29,30,29,30,30,29,30,0,1,11), 
35=>array(0,29,29,30,29,30,29,30,30,29,30,30,29,0,2,12), 
36=>array(3,30,29,29,30,29,29,30,30,29,30,30,30,29,3,1), 
37=>array(0,30,29,29,30,29,29,30,29,30,30,30,29,0,4,2), 
38=>array(7,30,30,29,29,30,29,29,30,29,30,30,29,30,5,3), 
39=>array(0,30,30,29,29,30,29,29,30,29,30,29,30,0,6,4), 
40=>array(0,30,30,29,30,29,30,29,29,30,29,30,29,0,7,5), 
41=>array(6,30,30,29,30,30,29,30,29,29,30,29,30,29,8,6), 
42=>array(0,30,29,30,30,29,30,29,30,29,30,29,30,0,9,7), 
43=>array(0,29,30,29,30,29,30,30,29,30,29,30,29,0,10,8), 
44=>array(4,30,29,30,29,30,29,30,29,30,30,29,30,30,1,9), 
45=>array(0,29,29,30,29,29,30,29,30,30,30,29,30,0,2,10), 
46=>array(0,30,29,29,30,29,29,30,29,30,30,29,30,0,3,11), 
47=>array(2,30,30,29,29,30,29,29,30,29,30,29,30,30,4,12), 
48=>array(0,30,29,30,29,30,29,29,30,29,30,29,30,0,5,1), 
49=>array(7,30,29,30,30,29,30,29,29,30,29,30,29,30,6,2), 
50=>array(0,29,30,30,29,30,30,29,29,30,29,30,29,0,7,3), 
51=>array(0,30,29,30,30,29,30,29,30,29,30,29,30,0,8,4), 
52=>array(5,29,30,29,30,29,30,29,30,30,29,30,29,30,9,5), 
53=>array(0,29,30,29,29,30,30,29,30,30,29,30,29,0,10,6), 
54=>array(0,30,29,30,29,29,30,29,30,30,29,30,30,0,1,7), 
55=>array(3,29,30,29,30,29,29,30,29,30,29,30,30,30,2,8), 
56=>array(0,29,30,29,30,29,29,30,29,30,29,30,30,0,3,9), 
57=>array(8,30,29,30,29,30,29,29,30,29,30,29,30,29,4,10), 
58=>array(0,30,30,30,29,30,29,29,30,29,30,29,30,0,5,11), 
59=>array(0,29,30,30,29,30,29,30,29,30,29,30,29,0,6,12), 
60=>array(6,30,29,30,29,30,30,29,30,29,30,29,30,29,7,1), 
61=>array(0,30,29,30,29,30,29,30,30,29,30,29,30,0,8,2), 
62=>array(0,29,30,29,29,30,29,30,30,29,30,30,29,0,9,3), 
63=>array(4,30,29,30,29,29,30,29,30,29,30,30,30,29,10,4), 
64=>array(0,30,29,30,29,29,30,29,30,29,30,30,30,0,1,5), 
65=>array(0,29,30,29,30,29,29,30,29,29,30,30,29,0,2,6), 
66=>array(3,30,30,30,29,30,29,29,30,29,29,30,30,29,3,7), 
67=>array(0,30,30,29,30,30,29,29,30,29,30,29,30,0,4,8), 
68=>array(7,29,30,29,30,30,29,30,29,30,29,30,29,30,5,9), 
69=>array(0,29,30,29,30,29,30,30,29,30,29,30,29,0,6,10), 
70=>array(0,30,29,29,30,29,30,30,29,30,30,29,30,0,7,11), 
71=>array(5,29,30,29,29,30,29,30,29,30,30,30,29,30,8,12), 
72=>array(0,29,30,29,29,30,29,30,29,30,30,29,30,0,9,1), 
73=>array(0,30,29,30,29,29,30,29,29,30,30,29,30,0,10,2), 
74=>array(4,30,30,29,30,29,29,30,29,29,30,30,29,30,1,3), 
75=>array(0,30,30,29,30,29,29,30,29,29,30,29,30,0,2,4), 
76=>array(8,30,30,29,30,29,30,29,30,29,29,30,29,30,3,5), 
77=>array(0,30,29,30,30,29,30,29,30,29,30,29,29,0,4,6), 
78=>array(0,30,29,30,30,29,30,30,29,30,29,30,29,0,5,7), 
79=>array(6,30,29,29,30,29,30,30,29,30,30,29,30,29,6,8), 
80=>array(0,30,29,29,30,29,30,29,30,30,29,30,30,0,7,9), 
81=>array(0,29,30,29,29,30,29,29,30,30,29,30,30,0,8,10), 
82=>array(4,30,29,30,29,29,30,29,29,30,29,30,30,30,9,11), 
83=>array(0,30,29,30,29,29,30,29,29,30,29,30,30,0,10,12), 
84=>array(10,30,29,30,30,29,29,30,29,29,30,29,30,30,1,1), 
85=>array(0,29,30,30,29,30,29,30,29,29,30,29,30,0,2,2), 
86=>array(0,29,30,30,29,30,30,29,30,29,30,29,29,0,3,3), 
87=>array(6,30,29,30,29,30,30,29,30,30,29,30,29,29,4,4), 
88=>array(0,30,29,30,29,30,29,30,30,29,30,30,29,0,5,5), 
89=>array(0,30,29,29,30,29,29,30,30,29,30,30,30,0,6,6), 
90=>array(5,29,30,29,29,30,29,29,30,29,30,30,30,30,7,7), 
91=>array(0,29,30,29,29,30,29,29,30,29,30,30,30,0,8,8), 
92=>array(0,29,30,30,29,29,30,29,29,30,29,30,30,0,9,9), 
93=>array(3,29,30,30,29,30,29,30,29,29,30,29,30,29,10,10), 
94=>array(0,30,30,30,29,30,29,30,29,29,30,29,30,0,1,11), 
95=>array(8,29,30,30,29,30,29,30,30,29,29,30,29,30,2,12), 
96=>array(0,29,30,29,30,30,29,30,29,30,30,29,29,0,3,1), 
97=>array(0,30,29,30,29,30,29,30,30,29,30,30,29,0,4,2), 
98=>array(5,30,29,29,30,29,29,30,30,29,30,30,29,30,5,3), 
99=>array(0,30,29,29,30,29,29,30,29,30,30,30,29,0,6,4), 
100=>array(0,30,30,29,29,30,29,29,30,29,30,30,29,0,7,5), 
101=>array(4,30,30,29,30,29,30,29,29,30,29,30,29,30,8,6), 
102=>array(0,30,30,29,30,29,30,29,29,30,29,30,29,0,9,7), 
103=>array(0,30,30,29,30,30,29,30,29,29,30,29,30,0,10,8), 
104=>array(2,29,30,29,30,30,29,30,29,30,29,30,29,30,1,9), 
105=>array(0,29,30,29,30,29,30,30,29,30,29,30,29,0,2,10), 
106=>array(7,30,29,30,29,30,29,30,29,30,30,29,30,30,3,11), 
107=>array(0,29,29,30,29,29,30,29,30,30,30,29,30,0,4,12), 
108=>array(0,30,29,29,30,29,29,30,29,30,30,29,30,0,5,1), 
109=>array(5,30,30,29,29,30,29,29,30,29,30,29,30,30,6,2), 
110=>array(0,30,29,30,29,30,29,29,30,29,30,29,30,0,7,3), 
111=>array(0,30,29,30,30,29,30,29,29,30,29,30,29,0,8,4), 
112=>array(4,30,29,30,30,29,30,29,30,29,30,29,30,29,9,5), 
113=>array(0,30,29,30,29,30,30,29,30,29,30,29,30,0,10,6), 
114=>array(9,29,30,29,30,29,30,29,30,30,29,30,29,30,1,7), 
115=>array(0,29,30,29,29,30,29,30,30,30,29,30,29,0,2,8), 
116=>array(0,30,29,30,29,29,30,29,30,30,29,30,30,0,3,9), 
117=>array(6,29,30,29,30,29,29,30,29,30,29,30,30,30,4,10), 
118=>array(0,29,30,29,30,29,29,30,29,30,29,30,30,0,5,11), 
119=>array(0,30,29,30,29,30,29,29,30,29,29,30,30,0,6,12), 
120=>array(4,29,30,30,30,29,30,29,29,30,29,30,29,30,7,1) 
); 
############################## 
#农历天干 
$mten=array("null","甲","乙","丙","丁","戊","己","庚","辛","壬","癸"); 
#农历地支 
$mtwelve=array("null","子（鼠）","丑（牛）","寅（虎）","卯（兔）","辰（龙）", 
               "巳（蛇）","午（马）","未（羊）","申（猴）","酉（鸡）","戌（狗）","亥（猪）"); 
#农历月份 
$mmonth=array("闰","正","二","三","四","五","六", 
              "七","八","九","十","十一","十二","月"); 
#农历日 
$mday=array("null","初一","初二","初三","初四","初五","初六","初七","初八","初九","初十", 
            "十一","十二","十三","十四","十五","十六","十七","十八","十九","二十", 
            "廿一","廿二","廿三","廿四","廿五","廿六","廿七","廿八","廿九","三十"); 
############################## 
#赋给初值 
#天干地支 
$ten=0; 
$twelve=0; 
#星期 
$week=5; 
#农历日 
$md=0; 
#农历月 
$mm=0; 
#阳历总天数 至1900年12月21日 
$total=11; 
#阴历总天数 
$mtotal=0; 
############################## 
#获得当日日期 
$today=getdate(); 

if(isset($_REQUEST['year']) && $_REQUEST['year'] != '')
{
	$year = $_REQUEST['year'];
}
if(isset($_REQUEST['month']) && $_REQUEST['month'] != '')
{
	$month = $_REQUEST['month'];
	$month = sprintf("%02d", $month);
}

#如果没有输入，设为当日日期 
if ($year=="" or $month=="" or ($year<1901 or $year>2020) 
    or ($month<1 or $month>12)){ 
     $year=$today[year]; 
     $month=$today[mon]; 
   } 
############################## 
#计算到所求日期阳历的总天数-自1900年12月21日始 
#先算年的和 
for ($y=1901;$y<$year;$y++){ 
      $total+=365; 
      if ($y%4==0) $total ++; 
    } 
#再加当年的几个月 
switch ($month){ 
         case 12: 
              $total+=30; 
         case 11: 
              $total+=31; 
         case 10: 
              $total+=30; 
         case 9: 
              $total+=31; 
         case 8: 
              $total+=31; 
         case 7: 
              $total+=30; 
         case 6: 
              $total+=31; 
         case 5: 
              $total+=30; 
         case 4: 
              $total+=31; 
         case 3: 
              $total+=28; 
         case 2: 
              $total+=31; 
       } 
#如果当年是闰年还要加一天 
if ($year%4==0 and $month>2){ 
     $total++; 
    } 
#顺便算出当月1日星期几 
$week=($total+$week)%7; 
############################## 
#用农历的天数累加来判断是否超过阳历的天数 
$flag1=0;#判断跳出循环的条件 
$j=0; 
while ($j<=120){ 
      $i=1; 
      while ($i<=13){ 
            $mtotal+=$everymonth[$j][$i]; 
            if ($mtotal>=$total){ 
                 $flag1=1; 
                 break; 
               } 
            $i++; 
          } 
      if ($flag1==1) break; 
      $j++; 
    }  



############################## 
#计算所求月份1号的农历日期 
$md=$everymonth[$j][$i]-($mtotal-$total); 
#月头空开的天数 
$k=$week; 
#是否跨越一年 
switch ($month){ 
         case 1: 
         case 3: 
         case 5: 
         case 7: 
         case 8: 
         case 10: 
         case 12: 
              $dd=31; 
              break; 
         case 4: 
         case 6: 
         case 9: 
         case 11: 
              $dd=30; 
              break; 
         case 2: 
              if ($year%4==0){ 
                  $dd=29; 
                 }else{ 
                  $dd=28; 
                 } 
              break; 
       } 
#是否跨越一年 
$ty=0; 
if ((($everymonth[$j][0]<>0 and $i==13) or ($everymonth[$j][0]==0 and $i==12)) 
       and $mtotal-$total<$dd) $ty=1; 


function curPageURL()
{
    return "index.php?module=".$_REQUEST['module']."&action=".$_REQUEST['action'];
}

?> 

<?php 
if(!isset($_REQUEST['mode']) || $_REQUEST['mode'] != 'ajax')
{
	echo '
	<link href="/modules/Calendar/css/all.css" rel="stylesheet" type="text/css"/>
    <link href="/modules/Calendar/css/skin.css" rel="stylesheet" type="text/css"/>
    <link href="/modules/Calendar/css/calendar.css" rel="stylesheet" type="text/css"/>
	<div id="ThousandCalendar" class="ThousandCalendar">
	';
}
?>

    <div id="myrl" style="width:98%;">
        <form name=CLD>
            <TABLE class="biao" width="100%">
                <TBODY>
                <TR>
                    <TD class="calTit" colSpan=7 style="height:30px;padding-top:3px;text-align:center;">

                        <a href="#" title="上一年" id="nianjian" class="ymNaviBtn lsArrow" onclick="prevyear();" ></a>
                        <a href="#" title="上一月" id="yuejian" class="ymNaviBtn lArrow" onclick="prevmonth();" ></a>
                        <div style="width:70%; float:left; padding-left:110px;">
                                            <span id="dateSelectionRili" class="dateSelectionRili"
                                                  style="cursor:hand;color: white; border-bottom: 1px solid white;"
                                                  onclick="dateSelection.show(this)">
											<span id="nian" class="topDateFont"><?php echo $year; ?></span><span
                                                    class="topDateFont">年</span><span id="yue"
                                                                                      class="topDateFont"><?php echo $month; ?></span><span
                                                    class="topDateFont">月</span>
											<span class="dateSelectionBtn cal_next"
                                                  onclick="dateSelection.show(this)">▼</span></span> &nbsp;&nbsp;<font id=GZ
                                                                                                                   class="topDateFont">农历
													<?php 
															if($ty==0) 
															{ 
																echo $mten[$everymonth[$j][14]].$mtwelve[$everymonth[$j][15]]."年"; 
															} 
															else 
															{ 
																echo $mten[$everymonth[$j][14]].$mtwelve[$everymonth[$j][15]]."/".$mten[$everymonth[$j+1][14]].$mtwelve[$everymonth[$j+1][15]]."年"; 
															} 
													?>															   
																												   </font>
                        </div>

                        <!--新加导航功能-->
                        <div style="left: 35%; display: none;margin-top:10px;" id="dateSelectionDiv">
                            <div id="dateSelectionHeader"></div>
                            <div id="dateSelectionBody">
                                <div id="yearList">
                                    <div id="yearListPrev" onclick="dateSelection.prevYearPage()">&lt;</div>
                                    <div id="yearListContent"></div>
                                    <div id="yearListNext" onclick="dateSelection.nextYearPage()">&gt;</div>
                                </div>
                                <div id="dateSeparator">
								</div>
                                <div id="monthList">
                                    <div id="monthListContent"><span id="SM0" class="month"
                                                                     onclick="dateSelection.setMonth(0)">1</span><span
                                            id="SM1" class="month" onclick="dateSelection.setMonth(1)">2</span><span
                                            id="SM2" class="month" onclick="dateSelection.setMonth(2)">3</span><span
                                            id="SM3" class="month" onclick="dateSelection.setMonth(3)">4</span><span
                                            id="SM4" class="month" onclick="dateSelection.setMonth(4)">5</span><span
                                            id="SM5" class="month" onclick="dateSelection.setMonth(5)">6</span><span
                                            id="SM6" class="month" onclick="dateSelection.setMonth(6)">7</span><span
                                            id="SM7" class="month" onclick="dateSelection.setMonth(7)">8</span><span
                                            id="SM8" class="month" onclick="dateSelection.setMonth(8)">9</span><span
                                            id="SM9" class="month" onclick="dateSelection.setMonth(9)">10</span><span
                                            id="SM10" class="month" onclick="dateSelection.setMonth(10)">11</span><span
                                            id="SM11" class="month curr" onclick="dateSelection.setMonth(11)">12</span>
                                    </div>
                                    <div style="clear: both;"></div>
                                </div>
                                <div id="dateSelectionBtn">
                                    <div id="dateSelectionTodayBtn" onclick="dateSelection.goToday()">今天</div>
                                    <div id="dateSelectionOkBtn" onclick="dateSelection.go()">确定</div>
                                    <div id="dateSelectionCancelBtn" onclick="dateSelection.hide()">取消</div>
                                </div>
                            </div>
                            <div id="dateSelectionFooter"></div>
                        </div>
                        <a href="#" id="nianjia" title="下一年" class="ymNaviBtn rsArrow" style="float:right;" onclick="nextyear();"></a>
                        <a href="#" id="yuejia" title="下一月" class="ymNaviBtn rArrow" style="float:right;" onclick="nextmonth();"></a>
                        <!--	<a id="jintian" href="#" title="今天" class="btn" style="float:right; margin-top:-2px; font-size:12px; text-align:center;">今天</a>-->

                    </TD>
                </TR>
                <TR class="calWeekTit" style="font-size:12px; height:20px;text-align:center;">
                    <TD width="80" class="red">星期日</TD>
                    <TD width="80">星期一</TD>
                    <TD width="80">星期二</TD>
                    <TD width="80">星期三</TD>
                    <TD width="80">星期四</TD>
                    <TD width="80">星期五</TD>
                    <TD width="80" class="red">星期六</TD>
                </TR>
				<?php
					global $calendardatas;
					$day=1; 
					$line=0; 
					while ($day<=$dd){ 
					   echo '<tr id="tt" height="44" align="center">'; 
					   for ($s=0;$s<=6;$s++){ 
							 if ($k<>0 or $day>$dd){ 
								  echo "<td width='14%' align='center'>&nbsp;</td>\n"; 
								  $k--; 
							 }else{ 
						//设置字符颜色 
								   switch ($s){ 
											case 1: 
											case 2: 
											case 3: 
											case 4: 
											case 5: 
												 $color="#000000"; 
												 break; 
											case 0: 
												 $color="#FF0000"; 
												 break; 
											case 6: 
												 $color="#008000"; 
												 break; 
										  } 
								#生成中文农历 
								   if ($md==1){#1日打印月份 
										if ($everymonth[$j][0]<>0 and $everymonth[$j][0]<$i){ 
											$mm=$i-1; 
										}else{ 
											$mm=$i; 
										} 
										if ($i==$everymonth[$j][0]+1 and $everymonth[$j][0]<>0) $chi=$mmonth[0].$mmonth[$mm];#闰月 
										else $chi=$mmonth[$mm].$mmonth[13]; 
								   }else{ 
										$chi=$mday[$md]; 
								   } 
								   if (date("Ymj") == $year.$month.$day)
								   {
										echo '<td valign="center" width="14%" class="jinri" align="center" style="overflow:hidden;cursor:default;"><font color="'.$color.'" title="" style="font-size: 15px;">'.$day.'('.$chi.')</font>';							   
								   }
								   else
								   {
										 echo '<td valign="center" width="14%" align="center" style="overflow:hidden;cursor:default;"><font color="'.$color.'" title="" style="font-size: 15px;">'.$day.'('.$chi.')</font>';
								   }
								   if (isset($calendardatas[$day]))
								   {
									  echo '<div class="calendardivider"></div>'.$calendardatas[$day];
								   }
								   echo '</td>';
								   $day++; 
								   $md++; 
								   if ($md>$everymonth[$j][$i]){ 
										$md=1; 
										$i++; 
									  } 
								   if (($i>12 and $everymonth[$j][0]==0) or ($i>13 and $everymonth[$j][0]<>0)){ 
										 $i=1; 
										 $j++; 
									  } 
							   } 
						   } 
					   echo "</tr>\n"; 
					   $line++; 
					} 
					?> 
               
                </tbody>
            </TABLE>
        </form>
    </div>
<?php
	$panel =  strtolower(basename(__FILE__,".php"));
?>
<script language="JavaScript">
var global = {
    currYear : -1, // 当前年
    currMonth : -1, // 当前月，0-11
    currDate : null, // 当前点选的日期
    uid : null,
    username : null,
    email : null,
    single : false
    // 是否为独立页调用，如果是值为日历id，使用时请注意对0的判断，使用 single !== false 或者 single === false
};
var dateSelection = {
    currYear : -1,
    currMonth : -1,

    minYear : 1901,
    maxYear : 2100,

    beginYear : 0,
    endYear : 0,

    tmpYear : -1,
    tmpMonth : -1,

    init : function(year, month) {
        if (typeof year == 'undefined' || typeof month == 'undefined') {
            year = global.currYear;
            month = global.currMonth;
        }
        this.setYear(year);
        this.setMonth(month);
        this.showYearContent();
        this.showMonthContent();
    },
    show : function(obj) {
        document.getElementById('dateSelectionDiv').style.display = 'block';
    },
    hide : function() {
        this.rollback();
        document.getElementById('dateSelectionDiv').style.display = 'none';
    },
    today : function() {
        var today = new Date();
        var year = today.getFullYear();
        var month = today.getMonth();
		var postBody = "<?php echo curPageURL()."&mode=ajax"; ?>"+"&year="+ year + "&month=" + (month +1);
		jQuery("#ThousandCalendar").loadUrl(postBody);
        
    },
    go : function() {
        if (this.currYear == this.tmpYear && this.currMonth == this.tmpMonth) {
            this.rollback();
        } else {
            this.commit();
        }
        this.hide();
    },
    goToday : function() {
        this.today();
        this.hide();
    },
    goPrevMonth : function() {
        this.prevMonth();
        this.commit();
    },
    goNextMonth : function() {
        this.nextMonth();
        this.commit();
    },
    goPrevYear : function() {
        this.prevYear();
        this.commit();
    },
    goNextYear : function() {
        this.nextYear();
        this.commit();
    },
    changeView : function() {
        global.currYear = this.currYear;
        global.currMonth = this.currMonth;
        clear();
        $("#nian").html(global.currYear);
        $("#yue").html(parseInt(global.currMonth) + 1);
        drawCld(global.currYear, global.currMonth);


    },
    commit : function() {
        if (this.tmpYear != -1 || this.tmpMonth != -1) {
            // 如果发生了变化
            if (this.currYear != this.tmpYear
                    || this.currMonth != this.tmpMonth) {
                // 执行某操作
				 var postBody = "<?php echo curPageURL()."&mode=ajax"; ?>"+"&year="+ this.currYear + "&month=" + (this.currMonth+1);
				 jQuery("#ThousandCalendar").loadUrl(postBody);
            }

            this.tmpYear = -1;
            this.tmpMonth = -1;
        }
    },
    rollback : function() {
        if (this.tmpYear != -1) {
            this.setYear(this.tmpYear);
        }
        if (this.tmpMonth != -1) {
            this.setMonth(this.tmpMonth);
        }
        this.tmpYear = -1;
        this.tmpMonth = -1;
        this.showYearContent();
        this.showMonthContent();
    },
    prevMonth : function() {
        var month = this.currMonth - 1;
        if (month == -1) {
            var year = this.currYear - 1;
            if (year >= this.minYear) {
                month = 11;
                this.setYear(year);
            } else {
                month = 0;
            }
        }
        this.setMonth(month);
    },
    nextMonth : function() {
        var month = this.currMonth + 1;
        if (month == 12) {
            var year = this.currYear + 1;
            if (year <= this.maxYear) {
                month = 0;
                this.setYear(year);
            } else {
                month = 11;
            }
        }
        this.setMonth(month);
    },
    prevYear : function() {
        var year = this.currYear - 1;
        if (year >= this.minYear) {
            this.setYear(year);
        }
    },
    nextYear : function() {
        var year = this.currYear + 1;
        if (year <= this.maxYear) {
            this.setYear(year);
        }
    },
    prevYearPage : function() {
        this.endYear = this.beginYear - 1;
        this.showYearContent(null, this.endYear);
    },
    nextYearPage : function() {
        this.beginYear = this.endYear + 1;
        this.showYearContent(this.beginYear, null);
    },
    selectYear : function() {//杨：select
        var selectY = $('select[@name="SY"] option[@selected]').text();
        this.setYear(selectY);
        this.commit();
    },
    selectMonth : function() {
        var selectM = $('select[@name="SM"] option[@selected]').text();
        this.setMonth(selectM - 1);
        this.commit();
    },
    setYear : function(value) {
        if (this.tmpYear == -1 && this.currYear != -1) {
            this.tmpYear = this.currYear;
        }
        $('#SY' + this.currYear).removeClass('curr');
        this.currYear = value;
        $('#SY' + this.currYear).addClass('curr');
    },
    setMonth : function(value) {
        if (this.tmpMonth == -1 && this.currMonth != -1) {
            this.tmpMonth = this.currMonth;
        }
        $('#SM' + this.currMonth).removeClass('curr');
        this.currMonth = value;
        $('#SM' + this.currMonth).addClass('curr');
    },
    showYearContent : function(beginYear, endYear) {
        if (!beginYear) {
            if (!endYear) {
                endYear = this.currYear + 1;
            }
            this.endYear = endYear;
            if (this.endYear > this.maxYear) {
                this.endYear = this.maxYear;
            }
            this.beginYear = this.endYear - 3;
            if (this.beginYear < this.minYear) {
                this.beginYear = this.minYear;
                this.endYear = this.beginYear + 3;
            }
        }
        if (!endYear) {
            if (!beginYear) {
                beginYear = this.currYear - 2;
            }
            this.beginYear = beginYear;
            if (this.beginYear < this.minYear) {
                this.beginYear = this.minYear;
            }
            this.endYear = this.beginYear + 3;
            if (this.endYear > this.maxYear) {
                this.endYear = this.maxYear;
                this.beginYear = this.endYear - 3;
            }
        }

        var s = '';
        for (var i = this.beginYear; i <= this.endYear; i++) {
            s += '<span id="SY' + i
                    + '" class="year" onclick="dateSelection.setYear(' + i
                    + ')">' + i + '</span>';
        }
        document.getElementById('yearListContent').innerHTML = s;
        $('#SY' + this.currYear).addClass('curr');
    },
    showMonthContent : function() {
        var s = '';
        for (var i = 0; i < 12; i++) {
            s += '<span id="SM' + i
                    + '" class="month" onclick="dateSelection.setMonth(' + i
                    + ')">' + (i + 1).toString() + '</span>';
        }
        document.getElementById('monthListContent').innerHTML = s;
        $('#SM' + this.currMonth).addClass('curr');
    }
};

function prevyear()
{ 
			var postBody = "<?php echo curPageURL()."&mode=ajax&year=".($year-1)."&month=".$month; ?>";
			jQuery("#ThousandCalendar").loadUrl(postBody);
}
function prevmonth()
{ 
			<?php 
				$temp = $month-1; 
			    if ( $temp < 1)
			    {
					$temp = 12;
					$year --;
			    }
			?>
			var postBody = "<?php echo curPageURL()."&mode=ajax&year=".$year."&month=".$temp; ?>";
			jQuery("#ThousandCalendar").loadUrl(postBody);
}
function nextyear()
{ 
			var postBody = "<?php echo curPageURL()."&mode=ajax&year=".($year+1)."&month=".$month; ?>";
			jQuery("#ThousandCalendar").loadUrl(postBody);
}
function nextmonth()
{ 
			<?php 
				$temp = $month+1; 
			    if ( $temp > 12)
			    {
					$temp = 1;
					$year ++;
			    }
			?>
			var postBody = "<?php echo curPageURL()."&mode=ajax&year=".$year."&month=".$temp; ?>";
			jQuery("#ThousandCalendar").loadUrl(postBody);
}

$(document).ready(function(){		
	var dateObj = new Date();
    global.currYear = dateObj.getFullYear();
    global.currMonth = dateObj.getMonth();
	dateSelection.init();
});

</script>

<?php
	if(!isset($_REQUEST['mode']) || $_REQUEST['mode'] != 'ajax')
	{
		echo '</div>';
	}
?>

