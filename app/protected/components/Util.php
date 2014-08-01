<?php

class Util {

    public static function thaiToMySQLDate($date) {
        if (!empty($date)) {
            $arr = explode("/", $date);
            
            if (count($arr) > 0) {
            		if (!empty($arr[2])) {
		            $y = $arr[2];
		            $m = $arr[1];
		            $d = $arr[0];
		
		            return "{$y}-{$m}-{$d}";
	            }
            }
        }
    }
    
    public static function mysqlToThaiDate($date) {
        if ($date == '0000-00-00') {
            return '-';
        }
        if ($date == '0000-00-00 00:00:00') {
            return '-';
        }
        
        if (!empty($date)) {
            $arr = explode(" ", $date);
            $arr2 = explode("-", $arr[0]);
            
            $y = $arr2[0];
            $m = $arr2[1];
            $d = $arr2[2];
            
            return "$d/$m/$y";
        }
    }

    public static function nowThai() {
        return date("d/m/Y");
    }
    
    public static function DateThai($strDate) {
        $strYear = date("Y", strtotime($strDate)) + 543;
        $strMonth = date("n", strtotime($strDate));
        $strDay = date("j", strtotime($strDate));
        $strMonthCut = Util::monthRange();
        $strMonthThai = $strMonthCut[$strMonth];

        return "$strDay $strMonthThai $strYear";
    }
    
    public static function monthRange() {
        $monthRange = array(
            '1' => 'มกราคม',
            '2' => 'กุมภาพันธ์',
            '3' => 'มีนาคม',
            '4' => 'เมษายน',
            '5' => 'พฤษภาคม',
            '6' => 'มิถุนายน',
            '7' => 'กรกฏาคม',
            '8' => 'สิงหาคม',
            '9' => 'กันยายน',
            '10' => 'ตุลาคม',
            '11' => 'พฤศจิกายน',
            '12' => 'ธันวาคม',
        );
        
        return $monthRange;
    }
    
    public static function yearRange() {
        $yStart = date('Y') - 5;
        $yEnd = date('Y') + 10;
        
        for($i = $yStart; $i <= $yEnd; $i++) {
            $years[$i] = $i + 543;
        }
        
        return $years;
    }
    
    public static function MonthThai($month) {
        $monthYear = Util::monthRange();
        
        foreach($monthYear as $keys => $value) {
            if($month == $keys) {
                return $value;
            }
        }
    }
    
    public static function YearThai($year) {
        return $year + 543;
    }
    
    public static function MonthYearThai($strDate) {
        $strYear = date("Y", strtotime($strDate)) + 543;
        $strMonth = date("n", strtotime($strDate));
        $strMonthCut = Util::monthRange();
        $strMonthThai = $strMonthCut[$strMonth];

        return "$strMonthThai $strYear";
    }
}

?>
