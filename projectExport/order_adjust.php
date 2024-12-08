<?php
//session_start();
//include"chksession.php";//ตรวจสอบเวลาในการเข้าระบบ ให้ล็อกเอาท์อัตโนมัติหากไม่มีการใช้งานระบบ
include"config.php";
include"datethai.php";

//$frompage=$_GET['frompage'];
$frompage="order_detail.php";
$action=$_GET['action'];
$sale_id=$_GET['sale_id'];
$assign_id=$_GET['assign_id'];
$order_update=date('Y-m-d H:i:s');
$action_datetime=date('Y-m-d H:i:s');
$member_id=$_SESSION['Member_IdLogin'];


    if($action=='start'){
        $dt_start=date('Y-m-d H:i:s');    
        $action_type='start';

        $query=$mysqli->query("UPDATE assign SET dt_start = '$dt_start',dt_stop = '0000-00-00 00:00:00', assign_status='3' WHERE sale_id='$sale_id' AND assign_id='$assign_id' AND operation_member='$member_id' LIMIT 1"); //อัพเดทข้อมูล time stamp ลงตารางการมอบหมายงาน (assign)
        //echo "UPDATE assign SET dt_start = '$dt_start',dt_stop = '0000-00-00 00:00:00', assign_status='3' WHERE sale_id='$sale_id' AND assign_id='$assign_id' AND operation_member='$member_id' LIMIT 1";
    
    }else{
        $dt_stop=date('Y-m-d H:i:s'); 
        $action_type='stop';     



        //เช็ครายการอะไหล่ที่นับไม่ครบและไม่ได้นับ
           $sqlChk="SELECT * FROM master_sale_detail WHERE  (flag_count ='N' or flag_count='' or flag_count =null) AND sale_id='$sale_id'";  
        $queryChk=$mysqli->query($sqlChk); // ทำการ query คำสั่ง sql 
		$findChk=$queryChk->num_rows;  // นับจำนวนถวที่แสดง ทั้งหมด

        if($findChk==0){ //นับครบทั้งหมด
            $isSuccess="true";
            $assign_status="41"; //หยิบสำเร็จ
            $title="สำเร็จ !";

            $query=$mysqli->query("UPDATE assign_detail SET dt_stop = '$dt_stop', assign_status='$assign_status' WHERE sale_id='$sale_id' and assign_id='$assign_id'");


            
        }else{ // มีบางรายการที่ไม่ครบหรือไม่ได้นับ
            $isSuccess="false";
            $alert2=$findChk;
            $icon="error";
            $title="แจ้งเตือน !";
            $assign_status="3"; //อยู่สถานะกำลังหยิบก่อน


            $query_ass=$mysqli->query("UPDATE assign SET dt_stop = '$dt_stop', assign_status='$assign_status' WHERE sale_id='$sale_id' AND assign_id='$assign_id' ORDER BY assign_id DESC LIMIT 1"); //อัพเดทข้อมูล time stamp ลงตารางการมอบหมายงาน (assign)


        }
        ///--------------------------------



        $sql31="SELECT * FROM  assign  WHERE sale_id='$sale_id' and assign_id='$assign_id'";
        $query31=$mysqli->query($sql31); 
        $date=$query31->fetch_array();
        $datetime1=new DateTime($date['dt_start']);
        $datetime2=new DateTime($date['dt_stop']);

         // หาผลต่าง
         $interval = $datetime1->diff($datetime2);

         // แสดงผลต่าง
        //$alert="คุณใช้เวลาทั้งหมด " . $interval->format('%h ชั่วโมง %i นาที %s วินาที') ;
        $alert=$interval->format('%h ชั่วโมง %i นาที %s วินาที') ;

        
    }


    if($query_ass){

        /*$sql31="SELECT * FROM  order_adjust_transaction  ORDER BY  transaction_id  desc LIMIT 1";
        $query31=$mysqli->query($sql31); 
        $transaction=$query31->fetch_array();
        $transaction_id=$transaction['transaction_id']+1;
     
        $query5=$mysqli->query("INSERT INTO order_adjust_transaction(transaction_id,order_id,action_type,action_datetime,member_id) VALUES('$transaction_id','$order_id','$action_type','$action_datetime','$member_id')");
       */


        //$alert="บันทึกข้อมูลแล้ว";
        print"<meta http-equiv='refresh' content='0;url=$frompage?sale_id=$sale_id&assign_id=$assign_id&alert=$alert&alert2=$alert2&isSuccess=$isSuccess&icon=$icon&title=$title'/>";
    
    }else{ 

        //$alert="ไม่ได้บันทึกข้อมูล ! ".$alert2;
       print"<meta http-equiv='refresh' content='0;url=order_detail.php?sale_id=$sale_id&assign_id=$assign_id&alert=$alert&isSuccess=$isSuccess&icon=$icon&title=$title'/>";

    }

?>