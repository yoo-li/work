<?php
/**
 * Created by PhpStorm.
 * User: lihongfei
 * Date: 17/7/29
 * Time: 上午11:43
 */
if (! class_exists('tboxApi')) {
    class tboxApi {
        private $supplierid;
        private $post_url;
        private $key='4c35458e913efbcf86ef621d22387b10';
        private $header=array("Content-Type: application/json;charset=utf-8");
        //车机系统错误码
        private $errorCodes=array(
            0=>'保留',
            1=>'OBD开门无响应',
            2=>'线控开门无响应',
            3=>'速度不为0',
            4=>'车门未关',
            5=>'后备箱未关',
            6=>'ACC没熄火',
            7=>'大灯未关',
            8=>'钥匙不在车上',
            9=>'示宽灯未关',
            10=>'不是N档',
            11=>'手刹未放下',
            12=>'保留',
            13=>'保留'
        );
        //下发订单返回错误码
        private $sendorder_errorCodes=array(
            0=>'成功/确认',
            1=>'时间格式或长度/延迟时间等格式出错',
            2=>'开始时间大于结束时间或结束时间小于当前时间',
            3=>'身份证不合法',
            4=>'身份证有效期不合法',
            5=>'已存在订单和现在冲突',
            6=>'有订单正在删除，返回失败'
        );
        //结束订单返回错误码
        private $finishorder_errorCodes=array(
            0=>'',
            1=>'格式错误',
            2=>'订单ID格式不正确',
            3=>'订单ID与删除ID不一致',
            4=>'车门未关闭',
            5=>'后备箱未关闭',
            6=>'ACC点火；未熄火',
            7=>'车灯未关',
            8=>'未能识别钥匙卡',
            9=>'车锁未上锁',
            10=>'速度非0'
        );
        //系统返回码
        private $sysCodes=array(
            'suc'=>'成功',
            'carIdIllegal'=>'车辆 ID 非法',
            'carIdNotFound'=>'没有收到车辆 ID',
            'cmdNotFound'=>'没有收到命令字',
            'cmdUnknown'=>'命令字未知',
            'signFail'=>'验签失败',
            'exception'=>'系统异常'
        );
        //返回码
        private $rtCodes=array(
            '0'=>'成功',
            '1'=>'失败',
            '2'=>'签名验证失败',
            '3'=>'设备断开连接',
            '4'=>'车辆在线，但无信息返回',
            '6'=>'命令重复'
        );
        private $set_param_fields=array(
            'heartBeat','sleepTimeInterval','sleepDistanceInterval','workTimeInterval',
            'workDistanceInterval','waitMaxTime','maxDistance','settleAccountInterval',
            'driveRange'
        );
        private $status_fields=array(
            'acc_status','location_status','latitude_status','longitude_status','order_status',
            'location_isencrypt_status','incharge_status','relay_status','rs_status','oilway_status',
            'electric_status','doorlock_status','dooropen_status','centerdoor_status','taildoor_status',
            'frontdoor_status','trunk_status','isgprs_status','isbeidou_status','glonass_status',
            'galileo_status','brake_status','istimeout_status','swipcard_status','timegt24_status',
            'leftturnlamp_status','rightturnlamp_status','remotelamp_status','nearlamp_status',
            'clearancelamp_status','iskeyin_status'

        );
        private $alarm_fields=array(
            'emergency_alarm','overspeed_alarm','fatiguedriving_alarm','dangeralarm_alarm','GNSSmodule_alarm',
            'GNSSwire_alarm','GNSSshort_alarm','lowervolt_alarm','novolt_alarm','LED_alarm','TTSmodule_alarm',
            'camera_alarm','IDcard_alarm','preoverspeed_alarm','prefatiguedriving_alarm','OBD_alarm','remainfield1',
            'remainfield2','fatiguetoday_alarm','timeoutstop_alarm','passinoutarea_alarm','passinoutline_alarm',
            'linetimeerror_alarm','lineerror_alarm','VSS_alarm','electric_alarm','bestolen_alarm','illegalfire_alarm',
            'illegalmove_alarm','collision_alarm','cartwheeled_alarm','illegalopen_alarm'

        );
        //传入当前supplierid
        function __construct($supplierid,$url)
        {
            $this->supplierid=$supplierid;
            $this->post_url=$url;//测试地址：http://123.57.211.33:8080/netgear1/operator/service
            $this->supplierid=$supplierid;
        }

        /*上报鉴权信息
         * @data:上报数据
         * @$type:"upload":上报数据；"auto":根据地理位置信息自动新增鉴权信息
         * */
        public function upload_authenticate($data,$authtype="upload"){
            try{
                $authContent=XN_Content::create("dev_authenticate","",false,"9");
                foreach($data as $field=>$value){
                    $fieldname=strtolower($field);
                    $authContent->my->$fieldname=$value;
                }
                $authContent->my->authtype=$authtype;
                $authContent->my->supplierid=$this->supplierid;
                $authContent->my->deleted='0';
                $authContent->save("dev_authenticate,dev_authenticate_".$this->supplierid);
                //检查是否有这个设备，如果没有则新建
                $carId=$data['carId'];
                $ccid=$data['ccid'];
                $equipments=XN_Query::create("Content")
                    ->tag("dev_equipments_".$this->supplierid)
                    ->filter("type","eic","dev_equipments")
                    ->filter("my.carid","=",$carId)
                    ->filter("my.ccid","=",$ccid)
                    ->filter("my.deleted",'=','0')
                    ->filter('my.apitype','=','tbox')
                    ->end(1)
                    ->execute();
                if(!count($equipments)){
                    $eqipment_id=$this->create_equipment($data);
                }
            }
            catch (XN_Exception $e){
                throw $e;
            }
            return true;
        }

        /*上报实时位置信息
         * @data:上报数据
        {
          "carId" : "170302170000",
          "cmd" : "status",
          "sign" : "127ec44bd6cab91998d13846907575bc",
          "status" : "00000001000000000000000000000001",
          "latitude" : "39956072",
          "longitude" : "116315959",
          "elevation" : "0",
          "speed" : "0",
          "direction" : "0",
          "voltage" : "119",
          "time" : "1501231441000",
          "areaId" : "0",
          "alarmId" : "00000000000000000000000000000000",
          "distance" : "0",
          "surplusPercent" : "0",
          "surplusDistance" : "0",
          "rssi" : "24",
          "surplusOil" : "0"
        }
         * */
        public function upload_locationInfo($data){
            try{
                $carstatus=$data['status'];
                unset($data['status']);
                $data['latitude']=substr($data['latitude'],0,strlen($data['latitude'])-6).'.'.substr($data['latitude'],strlen($data['latitude'])-6);
                $data['longitude']=substr($data['longitude'],0,strlen($data['longitude'])-6).'.'.substr($data['longitude'],strlen($data['longitude'])-6);
                //状态码转换为系统状态
                $carstatus=$this->transfter_carstatus($carstatus);
                //查询系统中是否已有此设备记录，没有则新增设备记录
                $equipments=XN_Query::create("Content")
                    ->tag("dev_equipments_".$this->supplierid)
                    ->filter("type","eic","dev_equipments")
                    ->filter("my.carid","=",$data['carId'])
                    ->filter("my.deleted",'=','0')
                    ->filter('my.apitype','=','tbox')
                    ->end(1)
                    ->execute();
                if(!count($equipments)){
                    $eqipment_id=$this->create_equipment($data);
                }
                else{
                    $equipmentInfo=$equipments[0];
                    $eqipment_id=$equipmentInfo->id;
                    $this->update_equipment($data,$eqipment_id);
                }

                $locationContent=XN_Content::create("dev_locations","",false,"9");
                foreach($data as $field=>$value){
                    $fieldname=strtolower($field);
                    $locationContent->my->$fieldname=$value;
                }
                $locationContent->my->carstatus=$carstatus;
                $locationContent->my->supplierid=$this->supplierid;
                $locationContent->my->dev_equipments=$eqipment_id;
                $locationContent->my->deleted='0';
                $locationContent->save("dev_locations,dev_locations_".$this->supplierid);
            }
            catch (XN_Exception $e){
                throw $e;
            }
            return true;
        }
        public function upload_offlineInfo($data){

            return true;
        }
        public function upload_keycardInfo($data){

            return true;
        }
        //创建系统设备列表记录
        public function create_equipment($data){
            $dev_equipments_no=XN_ModentityNum::get("Dev_Equipments");
            $equipmentContent=XN_Content::create("dev_equipments","",false)
                ->my->add('dev_equipments_no',$dev_equipments_no)
                ->my->add("carid",$data["carId"])//车辆 ID
                ->my->add("ccid",$data["ccid"])//Sim 卡 ccid
                ->my->add("version",$data["version"])//当前固件版本
                ->my->add("latitude",$data["latitude"])//纬度(以度为单位的纬度值乘以10的6次方，精确到百万分之一度。)
                ->my->add("longitude",$data["longitude"])//经度(以度为单位的纬度值乘以10的6次方，精确到百万分之一度。)
                ->my->add("elevation",$data["elevation"])//海拔
                ->my->add("surpluspercent",$data["surplusPercent"])//剩余电量百分比
                ->my->add("surplusoil",$data["surplusOil"])//剩余油量
                ->my->add("surplusdistance",$data["surplusDistance"])//剩余续航里程
                ->my->add("distance",$data["distance"])//总行驶里程
                ->my->add("voltage",$data["voltage"])//小电瓶电压
                ->my->add("areaid",intval($data["areaId"]))//区域编号
                ->my->add("apitype",'tbox')
                ->my->add("deleted",'0')
                ->my->add("status",'0')
                ->my->add("supplierid",$this->supplierid)
                ->save("dev_equipments,dev_equipments_".$this->supplierid);

            return $equipmentContent->id;
        }
        //更新车辆实时信息
        public function update_equipment($data,$id){
            try{
                $equipmentContent=XN_Content::load($id,"dev_equipments");
                $equipmentContent->my->latitude=$data["latitude"];
                $equipmentContent->my->longitude=$data["longitude"];
                $equipmentContent->my->elevation=$data["elevation"];
                $equipmentContent->my->surpluspercent=$data["surplusPercent"];
                $equipmentContent->my->surplusoil=$data["surplusOil"];
                $equipmentContent->my->surplusdistance=$data["surplusDistance"];
                $equipmentContent->my->distance=$data["distance"];
                $equipmentContent->my->voltage=$data["voltage"];
                $equipmentContent->my->areaid=$data["areaId"];
                $equipmentContent->save("dev_equipments,dev_equipments_".$this->supplierid);
            }
            catch(XN_Exception $e){
                return '{"status":"error","msg":"'.$e->getMessage().'"}';
            }
            return true;
        }

        /*
         * 车辆控制
         * cmd:doorControl:车门控制；electricControl：电路控制；findCar：鸣笛、闪灯；
         */
        public function control_car($carId,$cmd='doorControl',$type=''){
            if(!isset($type) || $type=='')
            {
                return '{"statusCode":"300","message":"控制类型必须"}';
                die();
            }
            $url=$this->post_url;
            $sign=$this->getSign($carId,$cmd,$type);
            $post_data=array(
                'carId'=>$carId,
                'cmd'=>$cmd,
                'type'=>$type,
                'sign'=>$sign
            );
            $header=array();
            $header[]="Content-Type: application/json;charset=utf-8";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
            $output = curl_exec($ch);
            curl_close($ch);
            $re_data=json_decode($output,true);

            $getsign=$re_data['sign'];//签名
            $sysCode=$re_data['sysCode'];//系统返回码
            $rtCode=$re_data['rtCode'];//返回码
            $errorCode=$re_data['errorCode'];//错误码
            if($sysCode=='suc')
            {
                if($this->checkSign($carId,$cmd,$type,$getsign))
                {
                    if($errorCode!=="" || !isset($this->errorCodes[$errorCode]))
                    {
                        if($rtCode==0){
                            return '{"statusCode":"1","message":"ok"}';
                            die();
                        }
                    }
                    else
                    {
                        return '{"statusCode":"300","message":"错误:'.$this->errorCodes[$errorCode].'"}';
                        die();
                    }
                }
                else
                {
                    return '{"statusCode":"300","message":"签名验证失败"}';
                    die();
                }
            }
            else
            {
                return '{"statusCode":"300","message":系统错误："'.$sysCode.':'.$this->sysCodes[$sysCode].$rtCode.':'.$this->rtCodes[$rtCode].$errorCode.':'.$this->errorCodes[$errorCode].'"}';
                die();
            }
        }
        /*
         * 车机查询
         * cmd:statusQuery:查询状态；attributeQuery：查询属性；onLineQuery ：查询设备是否在线
         */
        public function query_car($carId,$cmd='statusQuery'){
            $url=$this->post_url;
            $sign=$this->getSign($carId,$cmd,'query');
            $post_data=array(
                'carId'=>$carId,
                'cmd'=>$cmd,
                'sign'=>$sign
            );
            $header=array();
            $header[]="Content-Type: application/json;charset=utf-8";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
            $output = curl_exec($ch);
            curl_close($ch);

            $re_data=json_decode($output,true);
            $getsign=$re_data['sign'];//签名
            $sysCode=$re_data['sysCode'];//系统返回码
            $rtCode=$re_data['rtCode'];//返回码
            if($sysCode=='suc' && $rtCode=='0')
            {
                $re_data['statusCode']='1';
                $result=$this->dealData($re_data);
                if($this->checkSign($carId,$cmd,'query',$getsign))
                {
                    $result['statusCode']='1';
                    return json_encode($result);
                    die();
                }
                else
                {
                    return '{"statusCode":"300","message":"签名验证失败"}';
                    die();
                }

            }
            else
            {
                return '{"statusCode":"300","message":"'.$this->sysCodes[$sysCode].','.$this->rtCodes[$rtCode].'"}';
                die();
            }
        }
        /*
         *设置车机属性
         * */
        public function set_carparams($carId,$cmd='paramSet',$paramData){
            $url=$this->post_url;
            $sign=$this->getSign($carId,$cmd,'set');
            $post_data=array(
                'carId'=>$carId,
                'cmd'=>$cmd,
                'sign'=>$sign
            );
            foreach ($this->set_param_fields as $set_fieldname){
                if(isset($paramData[$set_fieldname]) && $paramData[$set_fieldname]!='')
                    $post_data[$set_fieldname]=$paramData[$set_fieldname];
            }
            $header=array();
            $header[]="Content-Type: application/json;charset=utf-8";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
            $output = curl_exec($ch);
            curl_close($ch);

            $re_data=json_decode($output,true);
            $getsign=$re_data['sign'];//签名
            $sysCode=$re_data['sysCode'];//系统返回码
            $rtCode=$re_data['rtCode'];//返回码
            if($sysCode=='suc' && $rtCode=='0')
            {
                if($this->checkSign($carId,$cmd,'query',$getsign))
                {
                    $re_data['statusCode']='1';
                    return json_encode($re_data);
                    die();
                }
                else
                {
                    return '{"statusCode":"300","message":"签名验证失败"}';
                    die();
                }
            }
            else
            {
                return '{"statusCode":"300","message":"'.$this->sysCodes[$sysCode].$this->rtCodes[$rtCode].'"}';
                die();
            }
        }
        /*
         *下发用车订单,同步返回
         * */
        public function sendOrder($carId,$orderId,$cmd='sendOrder'){
            $url=$this->post_url;
            $sign=$this->getSign($carId,$cmd,$orderId);
            $post_data=array(
                'carId'=>$carId,
                'OrderId'=>$orderId,
                'cmd'=>$cmd,
                'sign'=>$sign
            );

            $header=array();
            $header[]="Content-Type: application/json;charset=utf-8";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
            $output = curl_exec($ch);
            curl_close($ch);

            $re_data=json_decode($output,true);
            $getsign=$re_data['sign'];//签名
            $sysCode=$re_data['sysCode'];//系统返回码
            $rtCode=$re_data['rtCode'];//返回码
            $errorCode=$re_data['errorCode'];//错误码
            if($sysCode=='suc' && $rtCode=='0' && $errorCode=='0')
            {
                if($this->checkSign($carId,$cmd,$orderId,$getsign))
                {
                    $re_data['statusCode']='1';
                    return json_encode($re_data);
                    die();
                }
                else
                {
                    return '{"statusCode":"300","message":"签名验证失败"}';
                    die();
                }
            }
            else
            {
                return '{"statusCode":"300","message":"'.$this->sysCodes[$sysCode].$this->rtCodes[$rtCode].$this->sendorder_errorCodes[$errorCode].'"}';
                die();
            }
        }
        /*
         *结束用车订单,无返回
         * */
        public function finishOrder($carId,$orderId,$cmd='finishOrder'){
            $url=$this->post_url;
            $sign=$this->getSign($carId,$cmd,$orderId);
            $post_data=array(
                'carId'=>$carId,
                'OrderId'=>$orderId,
                'cmd'=>$cmd,
                'sign'=>$sign
            );

            $header=array();
            $header[]="Content-Type: application/json;charset=utf-8";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
            $output = curl_exec($ch);
            curl_close($ch);

            $re_data=json_decode($output,true);
            $getsign=$re_data['sign'];//签名
            $sysCode=$re_data['sysCode'];//系统返回码
            $rtCode=$re_data['rtCode'];//返回码
            $errorCode=$re_data['errorCode'];//错误码
            if($sysCode=='suc' && $rtCode==0)
            {
                if($this->checkSign($carId,$cmd,$orderId,$getsign))
                {
                    $re_data['statusCode']='1';
                    return json_encode($re_data);
                    die();
                }
                else
                {
                    return '{"statusCode":"300","message":"签名验证失败"}';
                    die();
                }
            }
            else
            {
                return '{"statusCode":"300","message":"'.$this->sysCodes[$sysCode].$this->rtCodes[$rtCode].$this->finishorder_errorCodes[$errorCode].'"}';
                die();
            }
        }

        /*
         * 清空未上报的信息
         * */
        public function clearInfo($carId,$cmd,$type='clear'){
            $url=$this->post_url;
            $sign=$this->getSign($carId,$cmd,$type);
            $post_data=array(
                'carId'=>$carId,
                'cmd'=>$cmd,
                'sign'=>$sign
            );
            $header=array();
            $header[]="Content-Type: application/json;charset=utf-8";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
            $output = curl_exec($ch);
            curl_close($ch);

            $re_data=json_decode($output,true);
            $getsign=$re_data['sign'];//签名
            $sysCode=$re_data['sysCode'];//系统返回码
            $rtCode=$re_data['rtCode'];//返回码

            if($sysCode=='suc' && $rtCode==0)
            {
                if($this->checkSign($carId,$cmd,$type,$getsign))
                {
                    $re_data['statusCode']='1';
                    return json_encode($re_data);
                    die();
                }
                else
                {
                    return '{"statusCode":"300","message":"签名验证失败"}';
                    die();
                }
            }
            else
            {
                return '{"statusCode":"300","message":"'.$this->sysCodes[$sysCode].$this->rtCodes[$rtCode].'"}';
                die();
            }
        }

        /*
         * 获取签名数字
         * */
        public function getSign($carId,$cmd,$type){
            $Parameter = $carId.$cmd.$type.$this->key;
            $uuid=md5($Parameter);
            return $uuid;
        }


        /*
         * 验证签名数字
         * */
        public function checkSign($carId,$cmd,$type,$sign){
            $Parameter = $carId.$cmd.$type.$this->key;
            $uuid=md5($Parameter);
            return true;
            if($uuid==$sign){
                return true;
            }
            else{
                return false;
            }
        }

        /*
         *返回状态的处理程序
         * */
        private function dealData($re_data){
            $result=$re_data;
            //状态码解析
            if(isset($re_data['status']) && $re_data['status']!==''){
                $status_arr=$this->transfter_carstatus($re_data['status']);
                $result=array_merge($result,$status_arr);
            }
            //报警码解析
            if(isset($re_data['alarmId']) && $re_data['alarmId']!==''){
                $alarm_arr=$this->transfter_alarmcode($re_data['alarmId']);
                $result=array_merge($result,$alarm_arr);
            }
            $result['voltage']=$result['voltage']/10;
            $result['latitude']=$result['latitude']/1000000;
            $result['longitude']=$result['longitude']/1000000;
            $result['speed']=$result['speed']/10;
            $result['surplusDistance']=$result['surplusDistance']/10;
            $result['distance']=$result['distance']/10;
            $result['time']=$result['time']/1000;
            $result['hour']=$this->getHourBySecond($result['time']/1000);
            return $result;
        }

        //车辆状态码二进制转换为十进制，并将ACC开关状态（底位）和是否定位状态（高位）拼接成字符串返回
        private function transfter_carstatus($carstatus){
            $result=array();
            for($i=0;$i<strlen($carstatus);$i++){
                if($i<8){
                    $code=$carstatus[$i];
                    $result[$this->status_fields[$i]]=$code;
                }
                if($i==8){
                    $code=$carstatus[$i].$carstatus[$i+1];
                    $result[$this->status_fields[$i]]=$code;
                }
                if($i>9){
                    $code=$carstatus[$i];
                    $result[$this->status_fields[$i-1]]=$code;
                }
                if($i==9){
                    continue;
                }

            }
            return $result;
        }

        private function transfter_alarmcode($alarmId){
            $result=array();
            for($i=0;$i<strlen($alarmId);$i++){
                $code=$alarmId[$i];
                $result[$this->alarm_fields[$i]]=$code;
            }
            return $result;
        }

        private function getHourBySecond($time){
            if(is_numeric($time)){
                $value = array(
                   "days"=>0,"hours" => 0, "minutes" => 0, "seconds" => 0,
                );
                $label=array(
                    "days"=>"天","hours" => "小时", "minutes" => "分", "seconds" => "秒",
                );
                if($time >= 86400){
                    $value["days"] = floor($time/86400);
                    $time = ($time%86400);
                }
                if($time >= 3600){
                    $value["hours"] = floor($time/3600);
                    $time = ($time%3600);
                }
                if($time >= 60){
                    $value["minutes"] = floor($time/60);
                    $time = ($time%60);
                }
                $value["seconds"] = floor($time);
                $t='';
                foreach($value as $type=>$number){
                    if($number>0){
                        $t.=$number.$label[$type];
                    }
                }
                return $t;

            }else{
                return false;
            }
        }
    }
}