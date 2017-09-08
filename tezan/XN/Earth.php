<?php

// Package transform coordinate between earth(WGS-84) and mars in china(GCJ-02).
class XN_Earth
{ 
	// 经度,纬度
	//112.992145,28.147377
	
	//http://api.map.baidu.com/geoconv/v1/?coords=112.992145,28.147377&from=1&to=6&ak=8tz6qyjPPVAwqq5FMy24sXrg
	//{"status":0,"result":[{"x":12579719.105353,"y":3247531.4625465}]}
	//http://api.map.baidu.com/geoconv/v1/?coords=12579719.105353,3247531.4625465&from=6&to=5&ak=8tz6qyjPPVAwqq5FMy24sXrg
	//{"status":0,"result":[{"x":113.0043098289,"y":28.149803246969}]}
	
	static public function near_range($near,$lat, $lng = 0)
	{
		if(is_array($lat))
		{
			$lng = isset($lat['lng']) ? $lat['lng'] : 0;
			$lat = isset($lat['lat']) ? $lat['lat'] : 0;
		}  
		$range = 180 / pi() * $near / 6372797;     //里面的 $near 就代表搜索 1km 之内，单位km   
		$lngR = $range / cos($lat * pi() / 180);  
		$maxLat = $lat + $range;//最大纬度  
		$minLat = $lat - $range;//最小纬度  
		$maxLng = $lng + $lngR;//最大经度  
		$minLng = $lng - $lngR;//最小经度  
		return array('min'=>array('lan'=>$minLng,'lat'=>$minLat),
					 'max'=>array('lan'=>$maxLng,'lat'=>$maxLat));
		
	}
	public static function Distance($lat1,$lng1,$lat2,$lng2)
	{
	        //将角度转为狐度
	 	    $radLat1=deg2rad($lat1);//deg2rad()函数将角度转换为弧度
		    $radLat2=deg2rad($lat2);
		    $radLng1=deg2rad($lng1);
		    $radLng2=deg2rad($lng2); 
		    $a=$radLat1-$radLat2;
		    $b=$radLng1-$radLng2;
		    $s=2*asin(sqrt(pow(sin($a/2),2)+cos($radLat1)*cos($radLat2)*pow(sin($b/2),2)))*6372797;
		    return round($s);
	}
    /*public static function Distance($latA, $lngA, $latB, $lngB)
    {
        $earthR = 6372797;
        $x = cos($latA * pi() / 180) * cos($latB * pi() / 180) * cos(($lngA - $lngB) * pi() / 180);
        $y = sin($latA * pi() / 180) * sin($latB * pi() / 180);
        $s = $x + $y;
        if ($s > 1) {
            $s = 1;
        }
        if ($s < -1) {
            $s = -1;
        }
        $alpha = acos($s);
        $distance = $alpha * $earthR;
		
        return round($distance);
    }*/
	
	//http://api.map.baidu.com/geoconv/v1/?coords=112.9863,28.14282&from=3&to=5&ak=8tz6qyjPPVAwqq5FMy24sXrg
	static public function weixin_to_baidu($lat, $lng = 0)
	{
		if(is_array($lat))
		{
			$lng = isset($lat['lng']) ? $lat['lng'] : 0;
			$lat = isset($lat['lat']) ? $lat['lat'] : 0;
		} 
		$Baidu_Server = "http://api.map.baidu.com/geoconv/v1/?coords={$lng},{$lat}&from=3&to=5&ak=8tz6qyjPPVAwqq5FMy24sXrg";
		$result = @file_get_contents($Baidu_Server);
		$json = json_decode($result);  
		
		if($json->error == 0)
		{
			$lng = $json->result[0]->x;	
			$lat = $json->result[0]->y;  
			return array(
				'lng' => $lng,
				'lat' => $lat,
			);
		} 
		return array();
	} 
	static public function bd09mc_conv_bd09ll($lat, $lng = 0)
	{
		if(is_array($lat))
		{
			$lng = isset($lat['lng']) ? $lat['lng'] : 0;
			$lat = isset($lat['lat']) ? $lat['lat'] : 0;
		} 
		$Baidu_Server = "http://api.map.baidu.com/geoconv/v1/?coords={$lng},{$lat}&from=6&to=5&ak=8tz6qyjPPVAwqq5FMy24sXrg";
		$result = @file_get_contents($Baidu_Server);
		$json = json_decode($result); 
		
		
		if($json->error == 0)
		{
			$lng = $json->result[0]->x;	
			$lat = $json->result[0]->y;  
			return array(
				'lng' => $lng,
				'lat' => $lat,
			);
		} 
		return array();
	} 
	
	// 经度,纬度
	static public function bd09mc_conv_wgs04($lat, $lng = 0)
	{
		if(is_array($lat))
		{
			$lng = isset($lat['lng']) ? $lat['lng'] : 0;
			$lat = isset($lat['lat']) ? $lat['lat'] : 0;
		} 
		$Baidu_Server = "http://api.map.baidu.com/geoconv/v1/?coords={$lng},{$lat}&from=6&to=5&ak=8tz6qyjPPVAwqq5FMy24sXrg";
		$result = @file_get_contents($Baidu_Server);
		$json = json_decode($result);
		if($json->error == 0)
		{
			$lng = $json->result[0]->x;	
			$lat = $json->result[0]->y; 
			
			$gcj02 = XN_Earth::bd09_conv_gcj02($lat,$lng); 

			$gcjLat = $gcj02['lat'];
			$gcjLng = $gcj02['lng'];

			$wgs = XN_Earth::GCJtoWGS($gcjLat, $gcjLng);
			
			return $wgs;
		} 
		return array();
	} 
	
    private static function outOfChina($lat, $lng)
    {
        if ($lng < 72.004 || $lng > 137.8347) {
            return true;
        }
        if ($lat < 0.8293 || $lat > 55.8271) {
            return true;
        }
        return false;
    }

    private static function transform($x, $y)
    {
        $xy = $x * $y;
        $absX = sqrt(abs($x));
        $d = (20.0 * sin(6.0 * $x * pi()) + 20.0 * sin(2.0 * $x * pi())) * 2.0 / 3.0;

        $lat = -100.0 + 2.0 * $x + 3.0 * $y + 0.2 * $y * $y + 0.1 * $xy + 0.2 * $absX;
        $lng = 300.0 + $x + 2.0 * $y + 0.1 * $x * $x + 0.1 * $xy + 0.1 * $absX;

        $lat += $d;
        $lng += $d;

        $lat += (20.0 * sin($y * pi()) + 40.0 * sin($y / 3.0 * pi())) * 2.0 / 3.0;
        $lng += (20.0 * sin($x * pi()) + 40.0 * sin($x / 3.0 * pi())) * 2.0 / 3.0;

        $lat += (160.0 * sin($y / 12.0 * pi()) + 320 * sin($y / 30.0 * pi())) * 2.0 / 3.0;
        $lng += (150.0 * sin($x / 12.0 * pi()) + 300.0 * sin($x / 30.0 * pi())) * 2.0 / 3.0;

        return array($lat, $lng);
    }
	
	

    private static function delta($lat, $lng)
    {
        /*const */$a = 6378245.0;
        /*const */$ee = 0.00669342162296594323;
        list($dLat, $dLng) = self::transform($lng - 105.0, $lat - 35.0);
        $radLat = $lat / 180.0 * pi();
        $magic = sin($radLat);
        $magic = 1 - $ee * $magic * $magic;
        $sqrtMagic = sqrt($magic);
        $dLat = ($dLat * 180.0) / (($a * (1 - $ee)) / ($magic * $sqrtMagic) * pi());
        $dLng = ($dLng * 180.0) / ($a / $sqrtMagic * cos($radLat) * pi());
        return array($dLat, $dLng);
    }
	

    // WGStoGCJ convert WGS-84 coordinate(wgsLat, wgsLng) to GCJ-02 coordinate(gcjLat, gcjLng).
    public static function WGStoGCJ($wgsLat, $wgsLng)
    {
        if (self::outOfChina($wgsLat, $wgsLng)) {
            list($gcjLat, $gcjLng) = array($wgsLat, $wgsLng);
            return array($gcjLat, $gcjLng);
        }
        list($dLat, $dLng) = self::delta($wgsLat, $wgsLng);
        list($gcjLat, $gcjLng) = array($wgsLat + $dLat, $wgsLng + $dLng);
        return array($gcjLat, $gcjLng);
    }

    // GCJtoWGS convert GCJ-02 coordinate(gcjLat, gcjLng) to WGS-84 coordinate(wgsLat, wgsLng).
    // The output WGS-84 coordinate's accuracy is 1m to 2m. If you want more exactly result, use GCJtoWGSExact/gcj2wgs_exact.
    public static function GCJtoWGS($gcjLat, $gcjLng)
    {
        if (self::outOfChina($gcjLat, $gcjLng)) {
            list($wgsLat, $wgsLng) = array($gcjLat, $gcjLng);
            return array($wgsLat, $wgsLng);
        }
        list($dLat, $dLng) = self::delta($gcjLat, $gcjLng);
        list($wgsLat, $wgsLng) = array($gcjLat - $dLat, $gcjLng - $dLng);
        return array($wgsLat, $wgsLng);
    }

    // GCJtoWGSExact convert GCJ-02 coordinate(gcjLat, gcjLng) to WGS-84 coordinate(wgsLat, wgsLng).
    // The output WGS-84 coordinate's accuracy is less than 0.5m, but much slower than GCJtoWGS/gcj2wgs.
    public static function GCJtoWGSExact($gcjLat, $gcjLng)
    {
        /*const */$initDelta = 0.01;
        /*const */$threshold = 0.000001;
        // list($tmpLat, $tmpLng) = self::GCJtoWGS($gcjLat, $gcjLng);
        // list($tryLat, $tryLng) = self::WGStoGCJ($tmpLat, $tmpLng);
        // list($dLat, $dLng) = array(abs($tmpLat-$tryLat), abs($tmpLng-$tryLng));
        list($dLat, $dLng) = array($initDelta, $initDelta);
        list($mLat, $mLng) = array($gcjLat - $dLat, $gcjLng - $dLng);
        list($pLat, $pLng) = array($gcjLat + $dLat, $gcjLng + $dLng);
        for ($i = 0; $i < 30; $i++) {
            list($wgsLat, $wgsLng) = array(($mLat + $pLat) / 2, ($mLng + $pLng) / 2);
            list($tmpLat, $tmpLng) = self::WGStoGCJ($wgsLat, $wgsLng);
            list($dLat, $dLng) = array($tmpLat - $gcjLat, $tmpLng - $gcjLng);
            if (abs($dLat) < $threshold && abs($dLng) < $threshold) {
                // echo("i:", $i);
                return array($wgsLat, $wgsLng);
            }
            if ($dLat > 0) {
                $pLat = $wgsLat;
            } else {
                $mLat = $wgsLat;
            }
            if ($dLng > 0) {
                $pLng = $wgsLng;
            } else {
                $mLng = $wgsLng;
            }
        }
        return array($wgsLat, $wgsLng);
    }

    // Distance calculate the distance between point(latA, lngA) and point(latB, lngB), unit in meter.
   
    public static function DistanceInfo($distance)
    {
        if ($distance < 50)
		{
			return "50M";
		}
        elseif ($distance < 100)
		{
			return "100M";
		}
        elseif ($distance < 200)
		{
			return "200M";
		}
        elseif ($distance < 300)
		{
			return "300M";
		}
        elseif ($distance < 400)
		{
			return "400M";
		}
        elseif ($distance < 500)
		{
			return "500M";
		}
        elseif ($distance < 600)
		{
			return "600M";
		}
        elseif ($distance < 700)
		{
			return "700M";
		}
        elseif ($distance < 800)
		{
			return "800M";
		}
        elseif ($distance < 900)
		{
			return "900M";
		}
        elseif ($distance < 1000)
		{
			return "1KM";
		}
        elseif ($distance < 1100)
		{
			return "1.1KM";
		}
        elseif ($distance < 1200)
		{
			return "1.2KM";
		}
        elseif ($distance < 1300)
		{
			return "1.3KM";
		}
        elseif ($distance < 1400)
		{
			return "1.4KM";
		}
        elseif ($distance < 1500)
		{
			return "1.5KM";
		}
        elseif ($distance < 1600)
		{
			return "1.6KM";
		}
        elseif ($distance < 1700)
		{
			return "1.7KM";
		}
        elseif ($distance < 1800)
		{
			return "1.8KM";
		}
        elseif ($distance < 1900)
		{
			return "1.9KM";
		}
        elseif ($distance < 2000)
		{
			return "2KM";
		}
        elseif ($distance < 2100)
		{
			return "2.1KM";
		}
        elseif ($distance < 2200)
		{
			return "2.2KM";
		}
        elseif ($distance < 2300)
		{
			return "2.3KM";
		}
        elseif ($distance < 2400)
		{
			return "2.4KM";
		}
        elseif ($distance < 2500)
		{
			return "2.5KM";
		} 
        elseif ($distance < 3000)
		{
			return "3KM";
		}  
        elseif ($distance < 4000)
		{
			return "4KM";
		} 
        elseif ($distance < 5000)
		{
			return "5KM";
		} 
        elseif ($distance < 6000)
		{
			return "6KM";
		} 
        elseif ($distance < 7000)
		{
			return "7KM";
		} 
        elseif ($distance < 8000)
		{
			return "8KM";
		} 
        elseif ($distance < 9000)
		{
			return "9KM";
		} 
        elseif ($distance < 10000)
		{
			return "10KM";
		}
		else
		{
			return ">10KM";
		} 
        return round($distance);
    }
	
	
	
	/**
	* 转换接口
	* @param float|array $lat 百度坐标系的纬度、或者array('lat'=>lat, 'lng'=>lng)
	* @param float $lng 百度坐标系的经度
	* @return array 转换后的gcj02坐标(高德坐标系)。格式array('lat'=>lat, 'lng'=>lng)
	*/
	static public function bd09_conv_gcj02($lat, $lng = 0)
	{
		if(is_array($lat))
		{
			$lng = isset($lat['lng']) ? $lat['lng'] : 0;
			$lat = isset($lat['lat']) ? $lat['lat'] : 0;
		}
		$x = $lng - 0.0065;
		$y = $lat - 0.006;
		$z = sqrt($x*$x+$y*$y) - 0.00002 * sin($y * self::const_x_pi());
		$theta = atan2($y, $x) - 0.000003 * cos($x * self::const_x_pi());
		return array(
			'lat' => $z * sin($theta),
			'lng' => $z * cos($theta),
		);
	}
	/**
	* 转换接口
	* @param float|array $lat gcj02坐标的纬度、或者array('lat'=>lat, 'lng'=>lng)
	* @param float $lng gcj02坐标的经度
	* @return array 转换后的百度坐标系。格式array('lat'=>lat, 'lng'=>lng)
	*/
	static public function gcj02_conv_bd09($lat, $lng = 0){
		if(is_array($lat))
		{
			$lng = isset($lat['lng']) ? $lat['lng'] : 0;
			$lat = isset($lat['lat']) ? $lat['lat'] : 0;
		}
		$z = sqrt($lng * $lng + $lat * $lat) + 0.00002 * sin($lat * self::const_x_pi());
		$theta = atan2($lat, $lng) + 0.000003 * cos($lng * self::const_x_pi());
		return array(
			'lat' => $z * sin($theta) + 0.006,
			'lng' => $z * cos($theta) + 0.0065,
		);
	}
	/**
	* const_x_pi
	* @return float
	*/
	static public function const_x_pi()
	{
		static $x_pi = 0;
		if(0 == $x_pi)
		{
			$x_pi = M_PI * 3000.0 / 180.0;
		}
		return $x_pi;
	}

}
