<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "../../config/connect.php" ;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $barcode = trim($_POST['barcode']);
    $sale_id = $_REQUEST['so_id'];
    $assign_id = $_REQUEST['assign_id'];
    $currentDateTime = date("Y-m-d H:i:s");
    $sql15 = "SELECT * FROM `tb_assign` WHERE so_id = '$sale_id' AND assign_task = 'pick';";
    $query_check_row = $mysqli->query($sql15);
    $round_n = mysqli_num_rows($query_check_row);

//    if ($round_n == 1) {
        $sql11 = "SELECT prod_location as ware_house FROM tb_sale_order_detail
              JOIN tb_assign ON tb_assign.so_id = tb_sale_order_detail.so_id 
              AND tb_assign.assign_no = ? 
              WHERE  prod_id = ? AND tb_sale_order_detail.so_id = ?";

//        $sql11 = "SELECT prod_location as ware_house FROM tb_sale_order_detail
//              JOIN tb_assign ON tb_assign.so_id = tb_sale_order_detail.so_id
//              AND tb_assign.assign_no = ?
//              WHERE flag_pick <> 'N' AND flag_pick <> 'Y'
//              AND prod_id = ? AND tb_sale_order_detail.so_id = ?";
//    }
//    if ($round_n == 2) {
//        $sql11 = "SELECT prod_location as ware_house FROM tb_sale_order_detail
//              JOIN tb_assign ON tb_assign.so_id = tb_sale_order_detail.so_id
//              AND tb_assign.assign_no = ?
//              WHERE  prod_id = ? AND tb_sale_order_detail.so_id = ?";
//    }
//    if ($round_n == 3) {
//        $sql11 = "SELECT prod_location as ware_house FROM tb_sale_order_detail
//              JOIN tb_assign ON tb_assign.so_id = tb_sale_order_detail.so_id
//              AND tb_assign.assign_no = ?
//              WHERE  prod_id = ? AND tb_sale_order_detail.so_id = ?";
//    }


    $stmt = $mysqli->prepare($sql11);
    $stmt->bind_param("sss", $assign_id, $barcode, $sale_id);
    $stmt->execute();
    $query11 = $stmt->get_result();
    $row11 = $query11->num_rows;

//    echo "SELECT prod_location as ware_house FROM tb_sale_order_detail
//              JOIN tb_assign ON tb_assign.so_id = tb_sale_order_detail.so_id
//              AND tb_assign.assign_no = '$assign_id'
//              WHERE flag_pick <> 'N' AND flag_pick <> 'Y'
//              AND prod_id = '$barcode' AND tb_sale_order_detail.so_id = '$sale_id'" ;

    if ($row11 > 0) {
        $list = array();
        while ($row = $query11->fetch_assoc()) {
            $list[] = $row['ware_house'];
        }
//        echo '<br>'.$row11.'<br>' ;
        if ($row11 == 1) {
            $res_data = array(
                "status" => '1',
                "message" => 'error',
                "datetime" => $currentDateTime, // ส่งวันเวลาออกไปด้วย
                "listData" => $list
            );
        } else {
            $res_data = array(
                "status" => 'success',
                "message" => 'more warehouse',
                "datetime" => $currentDateTime, // ส่งวันเวลาออกไปด้วย
                "listData" => $list
            );
        }
        echo json_encode($res_data);
    } else {
        $res_data = array(
            "status" => 'no',
            "message" => 'ไม่พบข้อมูลบาร์โค้ดที่คุณค้นหา'
        );
        echo json_encode($res_data);
    }

    $stmt->close();
}
?>