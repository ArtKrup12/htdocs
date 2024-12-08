<?php
	
	function DateThai($strDate){ 
	 //if(($strDate!='') or ($strDate!=0)){
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strHour= date("H",strtotime($strDate));
		$strMinute= date("i",strtotime($strDate));
		$strSeconds= date("s",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
		//return "$strDay $strMonthThai $strYear, $strHour:$strMinute";
		return "$strDay/$strMonth/$strYear $strHour:$strMinute";
		//}else{
		//return"";
		//}
	}

	//$strDate = "2008-08-14 13:42:44";
	//echo "ThaiCreate.Com Time now : ".DateThai($strDate);
	
	
function datethai2($T){   
$t=strtotime($T);
         $day=date('d',$t);  $month=date('m',$t);  $year=date('Y',$t)+543; $timenow=date('H:i',$t);
         $dateth=$day."/".$month."/".$year." ".$timenow;
          return $dateth; 
   //print"$t";
 ///   $str_date = date("Y-m-d",strtotime(str_replace('/', '-',$t))); 
///	$str_date =date("d/m/",strtotime($t)).date("Y",strtotime($t))+543.date("H:i",strtotime($t)); 
       ///    return $str_date; 
    }   
	
//$t="11/6/2550 09:09";

function DateEng($strDate)
	{ 
	 if(($strDate!='') or ($strDate!=0)){
		list($dates,$times) = split(" ", $strDate);//แยกวันกับเวลาออก
		list($day, $month,$year) = split("/",$dates,4);
		$year=$year-543;
		$str_date=$year."-".$month."-".$day." ".$times;
		return "$str_date";
	  }else{
		return"";
		}
//print"$str_date";
}	
function DateTh2En($strDate)
	{ 
	 if(($strDate!='') or ($strDate!=0)){
		list($dates,$times) = explode(" ", $strDate);//แยกวันกับเวลาออก
		list($day,$month,$year)=explode("/",$dates,4);
		
		if(strlen($day)==1){  (string)$day="0".$day;}else;  //strlen($str);
		if(strlen($month)==1){  (string)$month="0".$month;}else;
		
		$year=$year-543;
		$str_date=$year."-".$month."-".$day." ".$times;
		return "$str_date";
	  }else{
		return"";
		}
//print"$str_date";
}	
	function DateEn2Th($strDate)
	{ 
	 if(($strDate!='') or ($strDate!=0)){
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("m",strtotime($strDate));
		$strDay= date("d",strtotime($strDate));
		$strHour= date("H",strtotime($strDate));
		$strMinute= date("i",strtotime($strDate));
		$strSeconds= date("s",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
		//return "$strDay $strMonthThai $strYear, $strHour:$strMinute";
		//return "$strDay/$strMonth/$strYear $strHour:$strMinute";
		return "$strDay/$strMonth/$strYear";
		}else{
		return"";
		}
	}

function DateEng2($strDate)
	{ 
	 if(($strDate!='') or ($strDate!=0)){
		list($dates,$times) = split(" ", $strDate);//แยกวันกับเวลาออก
		list($month,$day ,$year) = split("/",$dates,4);
		//$year=$year;
		$str_date=$year."-".$month."-".$day." ".$times;
		return "$str_date";
	  }else{
		return"";
		}
//print"$str_date";
}	

function DateEng3($strDate)
	{ 
	 if(($strDate!='') or ($strDate!=0)){
		list($dates,$times) = split(" ", $strDate);//แยกวันกับเวลาออก
		list($month,$day ,$year) = split("/",$dates,4);
		//$year=$year;
		$times = '00:00:00';
		$str_date=$year."-".$month."-".$day." ".$times;
		return "$str_date";
	  }else{
		return"";
		}
//print"$str_date";
}	

function DateEng4($strDate)
	{ 
	 if(($strDate!='') or ($strDate!=0)){
		list($dates,$times) = split(" ", $strDate);//แยกวันกับเวลาออก
		list($month,$day ,$year) = split("/",$dates,4);
		//$year=$year;
		$times = '23:59:00';
		$str_date=$year."-".$month."-".$day." ".$times;
		return "$str_date";
	  }else{
		return"";
		}
//print"$str_date";
}	



 function  dateyearth($mydate){
//  $mydate = '10-02-2555';
	  $date = substr($mydate,3,2);
      $month = substr($mydate,0,2);
      $year = substr($mydate,6,4)+543;
	  $str_date = $date."/".$month."/".$year;
		return	 $str_date;	
	}

 function  dateyearth2($mydate){
//  $mydate = '10-02-2555';
	  $date = substr($mydate,3,2);
      $month = substr($mydate,0,2);
      $year = substr($mydate,6,4);
	  $str_date = $date."/".$month."/".$year;
		return	 $str_date;	
	}
	
 function  dateEng5($mydate){
//  $mydate = '10-02-2555';
      $date = substr($mydate,0,2);
	  $month = substr($mydate,3,2);
      $year = substr($mydate,6,4);
	  $str_date = $year . "-" . $month . "-". $date;
		return	 $str_date;	
	}
	
	function bathformat($number) {
		$numberstr = array('ศูนย์','หนึ่ง','สอง','สาม','สี่','ห้า','หก','เจ็ด','แปด','เก้า','สิบ');
		$digitstr = array('','สิบ','ร้อย','พัน','หมื่น','แสน','ล้าน');
	  
		$number = str_replace(",","",$number); // ลบ comma
		$number = explode(".",$number); // แยกจุดทศนิยมออก
	  
		// เลขจำนวนเต็ม
		$strlen = strlen($number[0]);
		$result = '';
		for($i=0;$i<$strlen;$i++) {
		  $n = substr($number[0], $i,1);
		  if($n!=0) {
			if($i==($strlen-1) AND $n==1){ $result .= 'เอ็ด'; }
			elseif($i==($strlen-2) AND $n==2){ $result .= 'ยี่'; }
			elseif($i==($strlen-2) AND $n==1){ $result .= ''; }
			else{ $result .= $numberstr[$n]; }
			$result .= $digitstr[$strlen-$i-1];
		  }
		}
		
		// จุดทศนิยม
		$strlen = strlen($number[1]);
		if ($strlen>2) { // ทศนิยมมากกว่า 2 ตำแหน่ง คืนค่าเป็นตัวเลข
		  $result .= 'จุด';
		  for($i=0;$i<$strlen;$i++) {
			$result .= $numberstr[(int)$number[1][$i]];
		  }
		} else { // คืนค่าเป็นจำนวนเงิน (บาท)
		  $result .= 'บาท';
		  if ($number[1]=='0' OR $number[1]=='00' OR $number[1]=='') {
			$result .= 'ถ้วน';
		  } else {
			// จุดทศนิยม (สตางค์)
			for($i=0;$i<$strlen;$i++) {
			  $n = substr($number[1], $i,1);
			  if($n!=0){
				if($i==($strlen-1) AND $n==1){$result .= 'เอ็ด';}
				elseif($i==($strlen-2) AND $n==2){$result .= 'ยี่';}
				elseif($i==($strlen-2) AND $n==1){$result .= '';}
				else{ $result .= $numberstr[$n];}
				$result .= $digitstr[$strlen-$i-1];
			  }
			}
			$result .= 'สตางค์';
		  }
		}
		return $result;
	  }


?>
