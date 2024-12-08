<?php

//session_start();
//include"chksession.php";//ตรวจสอบเวลาในการเข้าระบบ ให้ล็อกเอาท์อัตโนมัติหากไม่มีการใช้งานระบบ
include"config.php";
include"datethai.php";

$statusQ=$_GET['statusQ'];
$alert=$_GET['alert'];


    $member_id=$_SESSION['Member_IdLogin'];
    //$member_id=1;

    $frompage='order_scanner2.php';
    $nextpage='order_detail.php';
    $order_id=$_POST['order_id'];
    $order_detail_id=$_POST['order_detail_id'];
    $assign_id=$_POST['assign_id'];
    
    $product_code=$_POST['product_code'];
    $product_qty=$_POST['product_qty'];
    $product_count_cur=$_POST['product_count'];
    $product_count_old=$_POST['product_count_old'];

    $product_count_total=$product_count_cur+$product_count_old;  //จำนวนนับครั้งนี้+จำนวนนับก่อนหน้า
    $product_count_total=$product_count_cur;

    



    $order_detail_submit_date=date(format: 'Y-m-d H:i:s');

    if(($product_count_total<$product_qty)||($product_count_total==$product_qty)){

        
        if($product_count_total<$product_qty){ //ถ้าจำนวนนับรวม ไม่เท่ากับจำนวนในใบหยิบ

            //$order_detail_status='N';
            $alert="จำนวนที่นับได้ น้อยกว่าจำนวนในใบหยิบ";
            //$statusQ="no";
            $isSuccess="false";
            $nextpage="order_adjust_remark.php";



        }else{
            //$order_detail_status='Y';
            $alert="จำนวนที่นับได้ ครบตามจำนวนในใบหยิบ";
            $isSuccess="warn";
            //$statusQ="yes";
        }
 
    
    }else{
        //$alert="จำนวนที่นับได้เกินจำนวนในใบหยิบ";
        //$order_detail_status='N';
            $alert="จำนวนที่นับได้ เกินจำนวนในใบหยิบ";
            //$statusQ="no";
            $isSuccess="false";
            $nextpage="order_adjust_remark.php";
    }

    $query=$mysqli->query("UPDATE order_picking_detail SET product_count = '$product_count_cur',order_detail_submit_date='$order_detail_submit_date',member_id='$member_id' WHERE order_detail_id = '$order_detail_id' AND  order_id='$order_id'");



//    $query=$mysqli->query("UPDATE assign_detail SET pick_product_count = '$product_count_cur' WHERE assign_id = '$assign_id' AND  order_id='$order_id' AND order_detail_id='$order_detail_id'");

    //echo "UPDATE assign_detail SET pick_product_count = '$product_count_cur', pick_detail_status='$order_detail_status' WHERE assign_id = '$assign_id' AND  order_id='$order_id' AND order_detail_id='$order_detail_id'";


    //echo "UPDATE order_picking_detail SET product_count = '$product_count_cur', order_detail_status='$order_detail_status',order_detail_submit_date='$order_detail_submit_date',member_id='$member_id' WHERE product_code = '$product_code' AND  order_id='$order_id'"; 

	
    if($query){
       
        //$alert="บันทึกข้อมูลแล้ว";
       // print"<meta http-equiv='refresh' content='0;url=$nextpage?order_id=$order_id&assign_id=$assign_id&order_detail_id=$order_detail_id&alert=$alert&isSuccess=$isSuccess'/>";
    
    }else{ 

        //$alert="ไม่ได้บันทึกข้อมูล ! ".$alert2;
        //print"<meta http-equiv='refresh' content='0;url=order_scanner2.php?order_id=$order_id&assign_id=$assign_id&alert=$alert&isSuccess=$isSuccess'/>";

    }
?>