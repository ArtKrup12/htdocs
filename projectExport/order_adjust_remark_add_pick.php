<?php

//session_start();
//include"chksession.php";//ตรวจสอบเวลาในการเข้าระบบ ให้ล็อกเอาท์อัตโนมัติหากไม่มีการใช้งานระบบ
include"config.php";
include"datethai.php";

$statusQ=$_GET['statusQ'];
$alert=$_GET['alert'];


    $member_id=$_SESSION['Member_IdLogin'];
   // $member_id=1;

    $frompage='order_adjust_remark_pick.php';
    $nextpage='order_detail.php';
    $sale_id=$_POST['sale_id'];
    $assign_id=$_POST['assign_id'];
    $sale_detail_id=$_POST['sale_detail_id'];
    $detail_remark_type_emp=$_POST['order_detail_remark_type'];
    $detail_comment_emp=$_POST['order_detail_remark'];
    $product_count=$_POST['product_count'];


        $query=$mysqli->query("UPDATE assign_detail SET product_count='$product_count', detail_remark_type_emp = '$detail_remark_type_emp', detail_comment_emp='$detail_comment_emp' WHERE sale_detail_id = '$sale_detail_id' AND  sale_id='$sale_id' AND assign_id='$assign_id'");


        //echo "UPDATE order_picking_detail SET order_detail_status_pick='N', order_detail_remark_type = '$detail_remark_type_user', order_detail_remark='$detail_comment_user' WHERE order_detail_id = '$order_detail_id' AND  order_id='$order_id'";

    /*    $query=$mysqli->query("UPDATE assign_detail SET pick_detail_status='N', pick_detail_remark_type = '$order_detail_remark_type', pick_detail_remark='$order_detail_remark' WHERE order_id='$order_id' AND assign_id='$assign_id' AND order_detail_id='$order_detail_id'");
    */

	
    if($query){
        $isSuccess="warn";
        $alert="บันทึกหมายเหตุเรียบร้อยแล้ว";
        print"<meta http-equiv='refresh' content='0;url=order_detail.php?sale_id=$sale_id&assign_id=$assign_id&alert=$alert&isSuccess=$isSuccess'/>";
        print"<meta http-equiv='refresh' content='5;url=order_detail.php>";
    
    }else{ 
        $isSuccess="false";
        $alert="ไม่ได้บันทึกข้อมูล ! ";
        print"<meta http-equiv='refresh' content='0;url=$frompage?sale_id=$sale_id&assign_id='$assign_id''&alert=$alert&order_detail_id=$order_detail_id&isSuccess=$isSuccess'/>";

    }
?>