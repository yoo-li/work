<?php 
$mod_strings = Array(
    'LBL_BASE_INFORMATION' => '基本信息',
    'LBL_SEARCHTITLE'=>'商品编号、名称',
    'Adjust Type'=>'调整类型',
    'Money' => '新余额',
    'Amount' => '增加金额',
    'Old Money' => '历史余额',
    'SupplierID'=>'商家名称',
    'Mall_Product No'=>'商品编号',
    'Product Name'=>'商品名称',
    'Source'=>'来源',
    'Oper User'=>'操作人',
    'published'=>'创建时间',
    'updated'=>'最后操作时间',
    'Old Rate'=>'原提成',
    'New Rate'=>'新提成', 
    'LBL_SEARCHSUPPLIER'=>'输入供应商名称',
    'Old Merge Postage'=>'原邮费',
    'New Merge Postage'=>'新邮费',
    'Old Physical distribution type'=>'指定物流前',
    'New Physical distribution type'=>'指定物流后',
    'Old Postage'=>'原邮费',
    'New Postage'=>'新邮费',
    'Property Desc'=>'属性', 
    'Old Shop Price'=>'原销售价',
    'New Shop Price'=>'新销售价',
	'Old Commission Switch'=>'原佣金',
	'New Commission Switch'=>'新佣金',

);
 if($_SESSION['supplierid'] == '12352')
 {
   $mod_strings['Old Commission Switch']='原结算价';
   $mod_strings['New Commission Switch']='新结算价';
 }
?>