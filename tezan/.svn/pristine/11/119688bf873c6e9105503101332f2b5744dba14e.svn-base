<?php
require_once('include/utils/utils.php');
include_once('config.func.php');
include_once('payment.func.php');
class Mall_OfficialShiduOrders extends CRMEntity {
	
	public $table_name = 'mall_officialshiduorders';
	public $table_index= 'id';
	public $tab_name = Array('mall_officialshiduorders');
	public $tab_name_index = Array('mall_officialshiduorders'=>'id');
	public $customFieldTable = Array('mall_officialshiduorders', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array('supplierid','pro_supplierid','profileid','orderid','orderdatetime','sumorderstotal','mall_officialshiduordersstatus','published');
	public $list_link_field= 'activityname';
	public $default_order_by = 'published';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(
	); 
	
	var $popup_fields = Array('supplierid','pro_supplierid','profileid','orderid','orderdatetime','sumorderstotal','mall_officialshiduordersstatus');
	var $filter_fields = Array('activityname');
	
	public $search_fields_name = Array(
	);
	public $mandatory_fields = Array('activityname');
    public $special_search_fields = array(
        'status' => array(
			'' => array('value'=>'','label'=>'全部','operator'=>'='),
            '0' => array('value'=>'0','label'=>'启用','operator'=>'='),
            '1' => array('value'=>'1','label'=>'停用','operator'=>'='),
        ),
    );
	var $sortby_number_fields = Array('submitdatetime','mall_officialordersstatus','published');
	
    function __construct() {
		
		$this->column_fields = getColumnFields('Mall_OfficialShiduOrders');
	}

    public function approval_check($id,$event)
    {
        if ($event == 'Agree'){
            $officialorder_info=XN_Content::load($id,"mall_officialshiduorders");
            $orderid=$officialorder_info->my->orderid;
            $profileid=$officialorder_info->my->profileid;
            $order_info = XN_Content::load($orderid,"mall_orders_".$profileid,7);
            $paymentamount=$order_info->my->paymentamount;

            $supplier_profile = XN_Query::create('MainContent')
                ->tag("supplier_profile_" . $profileid)
                ->filter('type', 'eic', 'supplier_profile')
                ->filter('my.deleted', '=', '0')
                ->filter('my.official', '=', '0')
                ->filter('my.profileid', '=', $profileid)
                ->end(1)
                ->execute();
            if (count($supplier_profile) > 0) {
                $supplier_profile_info = $supplier_profile[0];
                $official_supplierid = $supplier_profile_info->my->supplierid;

                $mall_officialshidubills = XN_Query::create('MainContent')
                    ->tag("mall_officialshidubills")
                    ->filter('type', 'eic', 'mall_officialshidubills')
                    ->filter('my.deleted', '=', '0')
                    ->filter('my.status', '=', '0')
                    ->filter('my.supplierid', '=', $official_supplierid)
                    ->end(1)
                    ->execute();
                if(count($mall_officialshidubills))
                {
                    $mall_officialshidu_info = $mall_officialshidubills[0];
                    $shidu_money = $mall_officialshidu_info->my->shidu_money;//史嘟通宝可用余额
                    $shidu_credit = $mall_officialshidu_info->my->credit_level - $mall_officialshidu_info->my->consume_credit;
                    $shidu_amount=$shidu_money+$shidu_credit;
                    if($shidu_amount<$paymentamount){
                        echo '{"statusCode":300,"message":"史嘟通宝余额不足，充值后才能确认审批并支付!"}';
                        die();
                    }
                }
                else
                {
                    echo '{"statusCode":300,"message":"您所在的企业还没有获得史嘟通宝使用授权!"}';
                    die();
                }
            }
            else
            {
                echo '{"statusCode":300,"message":"此用户还不是本企业授权用户!"}';
                die();
            }
        }
    }
	public function approval_event($id,$event) 
	{
        $officialorder_info=XN_Content::load($id,"mall_officialshiduorders");
        $supplierid=$officialorder_info->my->supplierid;
        $orderid=$officialorder_info->my->orderid;
        $profileid=$officialorder_info->my->profileid;
        $order_info = XN_Content::load($orderid,"mall_orders_".$profileid,7);
        $paymentamount=$order_info->my->paymentamount;
        $amount=$paymentamount*100;
        if ($id > 0 && $event == 'Agree')
		{

            official_sdtb_notify($order_info,round(floatval($amount)/100, 2));//与mall_orders订单相关的支付成功回调操作
            $supplier_profile = XN_Query::create('MainContent')->tag("supplier_profile_" . $profileid)
                ->filter('type', 'eic', 'supplier_profile')
                ->filter('my.deleted', '=', '0')
                ->filter('my.official', '=', '0')
                ->filter('my.profileid', '=', $profileid)
                ->end(1)
                ->execute();
            if (count($supplier_profile) > 0) {
                $supplier_profile_info = $supplier_profile[0];
                $official_supplierid = $supplier_profile_info->my->supplierid;

                $mall_officialshidubills = XN_Query::create('MainContent')
                    ->tag("mall_officialshidubills")
                    ->filter('type', 'eic', 'mall_officialshidubills')
                    ->filter('my.deleted', '=', '0')
                    ->filter('my.status', '=', '0')
                    ->filter('my.supplierid', '=', $official_supplierid)
                    ->end(1)
                    ->execute();
                $mall_officialshidu_info=$mall_officialshidubills[0];
                $shidu_money=$mall_officialshidu_info->my->shidu_money;//史嘟通宝可用余额
                $shidu_credit=$mall_officialshidu_info->my->credit_level-$mall_officialshidu_info->my->consume_credit;

                $shidu_usemoney=$shidu_money>$amount?$amount:$shidu_money;
                $credit_usemoney=$shidu_money>$amount?0:$amount-$shidu_money;

                $mall_officialshidu_info->my->shidu_money = $shidu_money-$shidu_usemoney;
                $mall_officialshidu_info->my->shidu_consume += $shidu_usemoney;
                $mall_officialshidu_info->my->consume_credit += $credit_usemoney;
                $mall_officialshidu_info->my->consume_space-=$amount;
                $mall_officialshidu_info->save('mall_officialshidubills,mall_officialshidubills_'.$official_supplierid);

                //史嘟通宝日志
                $newcontent = XN_Content::create('mall_officialshidulogs','',false,7);
                $newcontent->my->deleted = '0';
                $newcontent->my->profileid = $profileid;
                $newcontent->my->supplierid = $official_supplierid;
                $newcontent->my->operator = $profileid;
                $newcontent->my->orderid = $order_info->id;
                $newcontent->my->shidu_beforemoney = number_format($shidu_money,2,".","");
                if($shidu_usemoney>0){
                    $newcontent->my->shidu_changemoney = '-'.number_format($shidu_usemoney,2,".","");
                }
                else
                {
                    $newcontent->my->shidu_changemoney = 0;
                }
                $newcontent->my->shidu_aftermoney =number_format($shidu_money-$shidu_usemoney,2,".","");
                $newcontent->my->credit_beforemoney = number_format($shidu_credit,2,".","");
                if($credit_usemoney>0){
                    $newcontent->my->credit_changemoney = '-'.number_format($credit_usemoney,2,".","");
                }
                else
                {
                    $newcontent->my->credit_changemoney = 0;
                }
                $newcontent->my->credit_aftermoney =number_format($shidu_credit-$credit_usemoney,2,".","");
                $newcontent->my->submitdatetime = date('Y-m-d H:i:s');
                $newcontent->save('mall_officialshidulogs,mall_officialshidulogs_'.$official_supplierid);

            }
		}
		else if ($id > 0 && $event == 'Disagree')  
		{
            $supplier_wxsettings = XN_Query::create('MainContent')->tag('supplier_wxsettings')
                ->filter('type', 'eic', 'supplier_wxsettings')
                ->filter('my.deleted', '=', '0')
                ->filter('my.supplierid', '=', $supplierid)
                ->end(1)
                ->execute();
            if (count($supplier_wxsettings) > 0)
            {
                $supplier_wxsetting_info = $supplier_wxsettings[0];
                $appid = $supplier_wxsetting_info->my->appid;
                require_once(XN_INCLUDE_PREFIX . "/XN/Message.php");
                XN_Message::sendmessage($profileid, '您的订单' . $order_info->my->mall_orders_no . '审核不通过，请仔细审查后重新提交!', $appid);
            }

		}
	}

	function save_module($module){} 

	function getSortOrder() {
		
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['MALL_OFFICIALORDERS_SORT_ORDER'] != '')?($_SESSION['MALL_OFFICIALORDERS_SORT_ORDER']):($this->default_sort_order));
		return $sorder;
	}
	
	function getOrderBy() {
		
		$use_default_order_by = $this->default_order_by;
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['MALL_OFFICIALORDERS_ORDER_BY'] != '')?($_SESSION['MALL_OFFICIALORDERS_ORDER_BY']):($use_default_order_by));
		return $order_by;
	}
}?>