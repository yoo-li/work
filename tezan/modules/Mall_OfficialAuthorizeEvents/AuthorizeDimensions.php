<?php
require_once('include/utils/utils.php');
global $currentModule;
global $supplierid;

$readonly = $_REQUEST['readonly'];

if (isset($supplierid) && $supplierid != "0" )
{
    $tag = "mall_officialauthorizedimensions_".$supplierid;
}
else
{
    $tag = "mall_officialauthorizedimensions";
}
$query=XN_Query::create("Content")->tag($tag)
    ->filter("type","eic","mall_officialauthorizedimensions_details")
    ->filter("my.record","=",$record)
    ->filter("my.deleted","=","0")
    ->order('published',XN_Order::ASC)
    ->end(-1);
$list_result = $query->execute();
$noofrows    = $query->getTotalCount();


$dimensiontypename = array(
    array("key"=>"消费商户类别","value"=>array("茶厂","超市","会所","咖啡茶座","酒楼","餐饮公司","外卖","办公用品店","超市")),
    array("key"=>"消费品类","value"=>array("餐饮","茶","酒","办公用品","外卖")),
    array("key"=>"人均","value"=>"number"),
    array("key"=>"单价","value"=>"number"),
    array("key"=>"单次额度","value"=>"number"),
    array("key"=>"累计额度","value"=>"number"),
    array("key"=>"授权次数","value"=>"number"),
    //array("key"=>"有效期起","value"=>"date"),
    //array("key"=>"有效期止","value"=>"date"),
);
$comparisonoperators = array("=",">",">=","<","<=","小于等于","介于","包含");

$panel = strtolower(basename(__FILE__, ".php"));

$table_index = '1';
echo '
    <script type="text/javascript">  
	    var dimensiontypename = ('.json_encode($dimensiontypename,JSON_UNESCAPED_UNICODE).');
		var comparisonoperators = ('.json_encode($comparisonoperators).');
 
        function addrow(obj){ 
            var index=parseInt($("#'.$panel.'_datagrid_' .$table_index.'").find("tr:last").prev().attr("tr-index"),10)+1;
            var html="<tr tr-index=\'"+index+"\' class=\'datagrid-add-tr datagrid-edit-tr nice-validator n-red datagrid-hover\' novalidate=\'novalidate\'>"+
                "<td class=\'datagrid-linenumber-td\' align=\'center\'>"+index+"</td>"+ 
                "<td align=\'center\' class=\'datagrid-edit-td\'>"+get_dimensiontypename_html(index)+"</td>"+
                "<td align=\'center\' class=\'datagrid-edit-td\'><span id=\'dimensionvalue_span_new"+index+"\'>"+get_dimensionvalues_htm(0,index)+"</span></td>"+
                "<td align=\'center\' class=\'datagrid-edit-td\'><span id=\'dimensionvalue_span_"+index+"\'>"+get_dimensionvalues_html(0,index)+"</span></td>"+
                "<td align=\'center\' class=\'datagrid-edit-td\'><input type=\'text\' class=\'form-control\'  name=\'memo["+index+"]\' value=\'\'</td>"+ 
                "<td align=\'center\'>"+
                    "<button type=\'button\' onclick=\'removerow(this);\' class=\'btn btn-red\' data-icon=\'times\'><i class=\'fa fa-times\'></i></button>"+
                "</td>"+
            "</tr>";
            $(html).insertBefore($(obj).parent().parent()).initui();
		    $(".dimensiontypename").on("change", function(){ dimensiontypename_onchange(this); }); 
		    $(".dimensiontypename").on("change", function(){ dimensiontypename_onchange_new(this); }); 
        }
        function get_dimensiontypename_html(index){
			var html =  "<select data-width=\'150px\' data-index=\'"+index+"\' class=\'dimensiontypename\' data-toggle=\'selectpicker\' name=\'dimensiontypename["+index+"]\'>";
			for(var i=0;i<dimensiontypename.length;i++){
			   html += "<option value=\'"+dimensiontypename[i].key+"\'>"+dimensiontypename[i].key+"</option>";
			} 
			html += "</select>";
			return html;
        }
        function get_dimensionvalues_html(pos,index){
			if (pos > dimensiontypename.length)
			{
				pos = dimensiontypename.length-1;
			} 
			if (dimensiontypename[pos].value == "number")
			{
				return "<input data-width=\'120px\' type=\'text\' class=\'form-control required\' data-rule=\'number;required;\'  name=\'dimensionvalue["+index+"]\'  value=\'\'>";
			}
			else if (dimensiontypename[pos].value == "date")
			{
				return "<input data-width=\'120px\' data-toggle=\'datepicker\' type=\'text\' class=\'form-control required\' data-rule=\'date;required;\' data-pattern=\'yyyy-MM-dd\' name=\'dimensionvalue["+index+"]\'  value=\'\'>";
			}
			else
			{
				var options = dimensiontypename[pos].value;
//				var html =  "<select data-width=\'110px\' data-toggle=\'selectpicker\' name=\'dimensionvalue["+index+"]\' >";
				var html = "<b data-width=\'110px\'   name=\'dimensionvalue["+index+"]\'>";
				 var arr = new Array();  
				for(var i=0;i<options.length;i++){
//				   html += "<option value=\'"+options[i]+"\'>"+options[i]+"</option>";
				   html += "<input type=checkbox value=\'"+options[i]+"\' name = arr[]>"+options[i]+"</input>";
//				   console.log(html);
				} 
//				console.log(html);
				html += "</b>";
				return html;
			}
			  
        }
//        
function dimensiontypename_onchange(obj){
			var typename = $(obj).val();  			
			check_typename = typename;		
			var index = $(obj).attr("data-index");  
			for(var i=0;i<dimensiontypename.length;i++)
			{ 
			   if (dimensiontypename[i].key == typename)
			   {
				    var html = get_dimensionvalues_html(i,index); 
					$("#dimensionvalue_span_"+index).html(html).initui();
			   		break;
			   }
			}  
		}
         function get_dimensionvalues_htm(pos,index){
			if (pos > dimensiontypename.length)
			{
				pos = dimensiontypename.length-1;
			} 
			if (dimensiontypename[pos].value == "number")
			{    
 		        if ( check_typename == "人均" ){
 		            var html =  "<select  data-toggle=\'selectpicker\' name=\'comparisonoperator["+index+"]\' >";
			        for(var i=0;i<comparisonoperators.length-1;i++){
			            html += "<option value=\'"+comparisonoperators[i]+"\'>"+comparisonoperators[i]+"</option>";
			                  } 
		    	        html += "</select>";
			            return html;
 		        }
//			    console.log(check_typename);
				 var html =  "<select  data-toggle=\'selectpicker\' name=\'comparisonoperator["+index+"]\' >";
			        for(var i=0;i<comparisonoperators.length-2;i++){
			            html += "<option value=\'"+comparisonoperators[i]+"\'>"+comparisonoperators[i]+"</option>";
			                  } 
		    	        html += "</select>";
			            return html;
			}
			else
			{           
				    var html =  "<select  data-toggle=\'selectpicker\' name=\'comparisonoperator["+index+"]\' >";
//			        for(var i=0;i<comparisonoperators.length;i++){
//			            html += "<option value=\'"+comparisonoperators[i]+"\'>"+comparisonoperators[i]+"</option>";
//			                  } 
			               html += "<option value=\'"+comparisonoperators[7]+"\'>"+comparisonoperators[7]+"</option>";    
		    	        html += "</select>";
			            return html;
			}
			  
        }
        
//        
		
	
	 function dimensiontypename_onchange_new(obj){
			var typename = $(obj).val();  
			var index = $(obj).attr("data-index");  
			for(var i=0;i<dimensiontypename.length;i++)
			{ 
			   if (dimensiontypename[i].key == typename)
			   {
				    var htm = get_dimensionvalues_htm(i,index); 
					$("#dimensionvalue_span_new"+index).html(htm).initui();
			   		break;
			   }
			}  
		}
		
        function removerow(obj){
            $(obj).parent().parent().remove();
        }
        function remove_row(obj,recordid){
            $(obj).parent().parent().remove();
			var details_delete_ids = $("#'.$panel.'_details_delete_ids").val();
			if (details_delete_ids == "")
			{
				$("#'.$panel.'_details_delete_ids").val(recordid);
			}   
			else
			{
				$("#'.$panel.'_details_delete_ids").val(details_delete_ids+","+recordid);
			}
        }
    </script>';
echo ' 
	<input type="hidden" id="'.$panel.'_details_delete_ids" name="details_delete_ids" value="">
    <table id="'.$panel.'_datagrid_'.$table_index.'" data-width="100%" class="table table-bordered">
    <tr tr-index="-1" style="height:25px;">
        <th width="30" align="center"  class="datagrid-linenumber-td">No.</th>
        <th width="120" align="center" class="single-row">维度类别</th>
		<th width="80" align="center" class="single-row">比较符</th>
        <th width="120" align="center" class="single-row">维度值</th>
        <th width="120" align="center" class="single-row">备注</th>';
if ($readonly != "true")
{
    echo '<th width="30" align="center" class="single-row">操作</th>';
}
echo '</tr>';


if(count($list_result)){
    $num = 1;
    foreach($list_result as $index=>$info){
        if ( $info->my->comparisonoperator == '包含'){
           if($info->my->dimensiontypename == '消费商户类别'){
               $dimensionvalue1.= $info->my->dimensionvalue.'-';
               $memo1= $info->my->memo.'-';

//
           }
            if($info->my->dimensiontypename == '消费品类'){
                $dimensionvalue2.= $info->my->dimensionvalue.'-';
                $memo2= $info->my->memo.'-';
//
            }

        }elseif ($info->my->dimensiontypename == '人均'){

            $dimensionvalue3.= $info->my->dimensionvalue.'-';
//            var_dump($dimensionvalue3);
            $memo3= $info->my->memo.'-';
        }

        else{
            $str =  '<tr tr-index="'.$index.'" class="datagrid-add-tr datagrid-edit-tr nice-validator n-red datagrid-hover" novalidate="novalidate">
                 <td class="datagrid-linenumber-td" align="center">'.($num++).'</td>
                 <td align="center" class="datagrid-edit-td"><span>'.$info->my->dimensiontypename.'</span></td> 
                 <td align="center" class="datagrid-edit-td"><span>'.$info->my->comparisonoperator.'</span></td> ';
             $str .=	'<td align="center" class="datagrid-edit-td"><span>'.$info->my->dimensionvalue . '</span></td>';
//            $str .=	'<td align="center" class="datagrid-edit-td"><span>'.$aa . '</span></td>';
            $str.=  '<td align="center" class="datagrid-edit-td"><span>'.$info->my->memo.'</span> </td>';
            echo $str;
            if ($readonly != "true")
            {
                echo '<td align="center">
	                    <button type="button" onclick="remove_row(this,\''.$info->id.'\');" class="btn btn-red" data-icon="times"><i class="fa fa-times"></i></button>
	                </td>';
            }
            echo '</tr>';
        }
    }


//==========
    if ($dimensionvalue1){
        $str =  '<tr tr-index="'.$index.'" class="datagrid-add-tr datagrid-edit-tr nice-validator n-red datagrid-hover" novalidate="novalidate">
                 <td class="datagrid-linenumber-td" align="center">'.($num++).'</td>
                 <td align="center" class="datagrid-edit-td"><span>'.'消费商户类型'.'</span></td> 
                 <td align="center" class="datagrid-edit-td"><span>'.'包含'.'</span></td> ';
        $str .=	'<td align="center" class="datagrid-edit-td"><span>'.$dimensionvalue1 . '</span></td>';
        $str.=  '<td align="center" class="datagrid-edit-td"><span>'.$memo1.'</span> </td>';
        echo $str;
        if ($readonly != "true")
        {
            echo '<td align="center">
	                    <button type="button" onclick="remove_row(this,\''.$info->id.'\');" class="btn btn-red" data-icon="times"><i class="fa fa-times"></i></button>
	                </td>';
        }
        echo '</tr>';
    }

//    ===========
    if ($dimensionvalue2){
        $str =  '<tr tr-index="'.$index.'" class="datagrid-add-tr datagrid-edit-tr nice-validator n-red datagrid-hover" novalidate="novalidate">
                 <td class="datagrid-linenumber-td" align="center">'.($num++).'</td>
                 <td align="center" class="datagrid-edit-td"><span>'.'消费品类'.'</span></td> 
                 <td align="center" class="datagrid-edit-td"><span>'.'包含'.'</span></td> ';
        $str .=	'<td align="center" class="datagrid-edit-td"><span>'.$dimensionvalue2 . '</span></td>';
        $str.=  '<td align="center" class="datagrid-edit-td"><span>'.$memo2.'</span> </td>';
        echo $str;
        if ($readonly != "true")
        {
            echo '<td align="center">
	                    <button type="button" onclick="remove_row(this,\''.$info->id.'\');" class="btn btn-red" data-icon="times"><i class="fa fa-times"></i></button>
	                </td>';
        }
        echo '</tr>';
    }


    if ($dimensionvalue3){
        $str =  '<tr tr-index="'.$index.'" class="datagrid-add-tr datagrid-edit-tr nice-validator n-red datagrid-hover" novalidate="novalidate">
                 <td class="datagrid-linenumber-td" align="center">'.($num++).'</td>
                 <td align="center" class="datagrid-edit-td"><span>'.'人均'.'</span></td> ';
        if(  substr_count($dimensionvalue3,'-')== 1){
            $str .=  ' <td align="center" class="datagrid-edit-td"><span>'.$info->my->comparisonoperator.'</span></td> ';
        }else{
            $str.=' <td align="center" class="datagrid-edit-td"><span>'.'介于'.'</span></td> ';
        }
        $str .=	'<td align="center" class="datagrid-edit-td"><span>'.$dimensionvalue3 . '</span></td>';
        $str.=  '<td align="center" class="datagrid-edit-td"><span>'.$memo3.'</span> </td>';
        echo $str;
        if ($readonly != "true")
        {
            echo '<td align="center">
	                    <button type="button" onclick="remove_row(this,\''.$info->id.'\');" class="btn btn-red" data-icon="times"><i class="fa fa-times"></i></button>
	                </td>';
        }
        echo '</tr>';
    }

    //    ===========
}
if ($readonly != "true")
{
    echo '<tr>
	        <td align="center" colspan="5"></td>
	        <td align="center">
	            <button type="button" onclick="addrow(this);" class="btn btn-red" data-icon="plus">
	                <i class="fa fa-plus"></i>
	            </button>
	        </td>
	    </tr>';
}
echo '</table>';

?>