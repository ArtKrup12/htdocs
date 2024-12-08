<?php

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
include "../../config/connect.php";
$action = $_POST['action'];
date_default_timezone_set('Asia/Bangkok');
$currentDateTime = date('Y-m-d H:i:s');

if ($action == 'updateStartPack') {
    $so_no = $_POST['so_no'];
    $assign_no = $_POST['assign_no'];
//    UPDATE `tb_assign` SET `assign_status`='[value-10]',`modify_dt`='[value-11]' WHERE assign_no = '' AND so_id = '' AND assign_task = 'pick' ANS assign_status = 11
    $update_assign = "UPDATE `tb_assign` SET `assign_status`=32,`modify_dt`='$currentDateTime' WHERE assign_no = '$assign_no' AND so_id = '$so_no' AND assign_task = 'pack' AND assign_status = 22";
    mysqli_query($mysqli, $update_assign);

    $update_sale_order = "UPDATE `tb_sale_order` SET `modify_dt`='$currentDateTime',`pack_status`=32 WHERE so_id = '$so_no'";
    mysqli_query($mysqli, $update_sale_order);

    $insert_result = "INSERT INTO `tb_result`(`assign_no`, `start_dt`,`stop_dt`) VALUES ('$assign_no','$currentDateTime','0000-00-00 00:00:00')";
    mysqli_query($mysqli, $insert_result);

    echo json_encode(['success' => true, 'message' => '']);
}

if ($action == 'count_scanner') {
    $so_no = $_POST['so_id'];
    $assign_no = $_POST['assign_id'];
    $ware_house = $_POST['ware_house'];
    $product_code = $_POST['barcode'];
    $sql_select_data_all = "SELECT *, tb_product.prod_name AS p_name, tb_product.prod_id AS p_code 
                        FROM tb_sale_order_detail
                        JOIN tb_assign ON tb_assign.so_id = tb_sale_order_detail.so_id AND tb_assign.assign_no = '$assign_no' 
                        JOIN tb_product ON tb_product.prod_id = tb_sale_order_detail.prod_id
                        WHERE  tb_sale_order_detail.prod_id = '$product_code' 
                        AND tb_sale_order_detail.so_id = '$so_no' 
                        AND tb_sale_order_detail.prod_location = '$ware_house';";

    $query_sql_select_data_all = $mysqli->query($sql_select_data_all);
    $num_data_row = $query_sql_select_data_all->num_rows;

    if ($num_data_row > 0) {
        $result_select_data_all = $query_sql_select_data_all->fetch_array(MYSQLI_ASSOC);
        $sql_select_tb_temp_scan_chk = "SELECT * FROM tb_temp_scan WHERE assign_no = '" . $assign_no . "' AND so_detail_no = '" . $result_select_data_all['so_detail_no'] . "';";
        $query_select_chk_tb_temp = $mysqli->query($sql_select_tb_temp_scan_chk);
        $num_data_tb_assign_row = $query_select_chk_tb_temp->num_rows;

        if ($num_data_tb_assign_row > 0) {

            $sql_select_check = "SELECT sum(scan_qty) as sum_qty FROM tb_temp_scan 
                                           WHERE assign_no = '" . $assign_no . "'
                                            AND `so_detail_no` = '" . $result_select_data_all['so_detail_no'] . "'";
            $query_check_qty = $mysqli->query($sql_select_check);

            $on_qty = $query_check_qty->fetch_array();
            if (($on_qty['sum_qty'] + 1) > $result_select_data_all['prod_qty']) {
                $res_last_qty = $on_qty['sum_qty'];
                $isCheck = 'over';
            } else {
                $sql_update_tb_temp_scan = "UPDATE `tb_temp_scan` SET `time_stamp_dt` = '$currentDateTime' ,`scan_qty` = `scan_qty` + 1
                                            WHERE `assign_no` = '" . $assign_no . "'
                                            AND `so_detail_no` = '" . $result_select_data_all['so_detail_no'] . "';";
                $mysqli->query($sql_update_tb_temp_scan);

                $sql_select_tb_temp_qty = "SELECT sum(scan_qty) as sum_qty FROM tb_temp_scan 
                                           WHERE assign_no = '" . $assign_no . "'
                                            AND `so_detail_no` = '" . $result_select_data_all['so_detail_no'] . "'";
                $query_result_qty = $mysqli->query($sql_select_tb_temp_qty);

                $last_qty = $query_result_qty->fetch_array();
                $res_last_qty = $last_qty['sum_qty'];
            }
            // check <= db.scan_qty
        } else {
            $sql_insert_tb_temp_scan = "INSERT INTO `tb_temp_scan`(`assign_no`, `so_detail_no`, `scan_qty`) 
                                            VALUES ('" . $assign_no . "', '" . $result_select_data_all['so_detail_no'] . "', 1);";
            $mysqli->query($sql_insert_tb_temp_scan);
        }

        $res_data = array(
            "status" => 'success',
            "message" => 'พบข้อมูลบาร์โค้ดที่คุณค้นหา',
            "data" => $result_select_data_all,
            "lastQty" => $res_last_qty,
            "isCheckScanOver" => $isCheck,
        );
        echo json_encode($res_data);
    } else {
        $res_data = array(
            "status" => 'no',
            "message" => 'ไม่พบข้อมูลบาร์โค้ดที่คุณค้นหา'
        );
        echo json_encode($res_data);

    }


}

if ($action == 'update_temp_count') {

    $so_no = $_POST['so_id'];
    $assign_no = $_POST['assign_id'];
    $val = $_POST['val'];
    $pro_id = $_POST['prod_code'];
    $location = $_POST['ware_house'];
    $sql_select_so_detail = "SELECT * FROM tb_sale_order_detail 
                                           WHERE so_id = '" . $so_no . "' AND prod_location = '" . $location . "'
                                            AND `prod_id` = '" . $pro_id . "'";
    $query_so_detail = $mysqli->query($sql_select_so_detail);
    $so_detail_data = mysqli_fetch_object($query_so_detail);

    $sql_update_tb_temp_scan = "UPDATE `tb_temp_scan` SET `time_stamp_dt` = '$currentDateTime', `scan_qty`='$val' WHERE assign_no = '$assign_no' AND so_detail_no = '" . $so_detail_data->so_detail_no . "'";
    $mysqli->query($sql_update_tb_temp_scan);
}

if ($action == 'save_list_so_detail') {
    $sub_action = $_POST['sub_action'];
    if ($sub_action == 'Y') {
        $so_no = $_POST['so_id'];
        $assign_no = $_POST['assign_no'];
        $prod_id = $_POST['prod_id'];
        $prod_location = $_POST['prod_location'];
        $count_scan = $_POST['count_scan'];

        $sql_select_so_detail = "SELECT * FROM tb_sale_order_detail 
                                           WHERE so_id = '" . $so_no . "' AND prod_location = '" . $prod_location . "'
                                            AND `prod_id` = '" . $prod_id . "'";
        $query_so_detail = $mysqli->query($sql_select_so_detail);
        $so_detail_data = mysqli_fetch_object($query_so_detail);

        $sql_select_so = "SELECT * FROM tb_assign  WHERE assign_no = '" . $assign_no . "'";
        $query_so = $mysqli->query($sql_select_so);
        $so_data = mysqli_fetch_object($query_so);

        $sql_insert_pick = "INSERT INTO `tb_pack`(`assign_no`, `so_detail_no`, `assign_round`, `pack_qty`, `flag_pack`, `create_dt`) 
                        VALUES ('$assign_no','" . $so_detail_data->so_detail_no . "','" . $so_data->assign_round . "','$count_scan','Y','$currentDateTime')";
        $mysqli->query($sql_insert_pick);

        $sql_update_so_detail = "UPDATE `tb_sale_order_detail` SET `modify_dt`='$currentDateTime',`flag_pack`='Y' WHERE so_id = '" . $so_no . "' AND prod_location = '" . $prod_location . "'
                                            AND `prod_id` = '" . $prod_id . "'";
        $mysqli->query($sql_update_so_detail);

        $sql_delete_detail = "DELETE FROM `tb_temp_scan` WHERE so_detail_no = '" . $so_detail_data->so_detail_no . "' AND assign_no = '$assign_no'";
        $mysqli->query($sql_delete_detail);
    }

    if ($sub_action == 'N') {

        $so_no = $_POST['so_id'];
        $assign_no = $_POST['assign_no'];
        $prod_id = $_POST['prod_id'];
        $prod_location = $_POST['prod_location'];
        $count_scan = $_POST['count_scan'];
        $remark_type = $_POST['remark_type'];
        $remark_text = $_POST['remark_text'];

        $sql_select_so_detail = "SELECT * FROM tb_sale_order_detail 
                                           WHERE so_id = '" . $so_no . "' AND prod_location = '" . $prod_location . "'
                                            AND `prod_id` = '" . $prod_id . "'";
        $query_so_detail = $mysqli->query($sql_select_so_detail);
        $so_detail_data = mysqli_fetch_object($query_so_detail);

        $sql_select_so = "SELECT * FROM tb_assign  WHERE assign_no = '" . $assign_no . "'";
        $query_so = $mysqli->query($sql_select_so);
        $so_data = mysqli_fetch_object($query_so);

        $sql_insert_pick = "INSERT INTO `tb_pack`(`assign_no`, `so_detail_no`, `assign_round`, `pack_qty`, `flag_pack`, `create_dt`) 
                        VALUES ('$assign_no','" . $so_detail_data->so_detail_no . "','" . $so_data->assign_round . "','$count_scan','N','$currentDateTime')";
        $mysqli->query($sql_insert_pick);

        $pick_no = $mysqli->insert_id;
        $sql_insert_remark_pick = "INSERT INTO `tb_pack_remark`(`pack_no`, `emp_id`,`emp_type`, `remark_id`, `remark`, `create_dt`) 
                        VALUES ('$pick_no','" . $so_data->delegatee_id . "',1,'$remark_type','$remark_text','$currentDateTime')";
        $mysqli->query($sql_insert_remark_pick);

        $sql_update_so_detail = "UPDATE `tb_sale_order_detail` SET `modify_dt`='$currentDateTime',`flag_pack`='N' WHERE so_id = '" . $so_no . "' AND prod_location = '" . $prod_location . "'
                                            AND `prod_id` = '" . $prod_id . "'";
        $mysqli->query($sql_update_so_detail);

        $sql_delete_detail = "DELETE FROM `tb_temp_scan` WHERE so_detail_no = '" . $so_detail_data->so_detail_no . "' AND assign_no = '$assign_no'";
        $mysqli->query($sql_delete_detail);

    }
}

if ($action == 'save_so') {
    $sub_action = $_POST['sub_action'];
    if ($sub_action == 'N') {
        $so_no = $_POST['so_id'];
        $assign_no = $_POST['assign_no'];
        $emp_id = $_POST['emp_id'];
        $stopTime = $_POST['stopTime'];
        $remark_note = $_POST['remark_text'];
        $remark_id   = $_POST['remark_note'];

        // pack no
        $sql_select_assign = "SELECT * FROM `tb_assign` WHERE so_id = '" . $so_no . "' AND assign_task = 'pack'" ;
        $query_assign = $mysqli->query($sql_select_assign);
        $data_result_assign = mysqli_num_rows($query_assign);
        if($data_result_assign == 1){
            $current_date = date('Y-m-d');
            $thai_year = (date('Y') + 543) % 100;
            $month = date('m');
            $day = date('d');
            $result = $thai_year . $month . $day;
            $parts = explode('/', $so_no);
            $after_slash = $parts[1];

            $p_no = $result.'-'.$after_slash ;
            $sql_insert_tb_packing = "INSERT INTO `tb_packing_number`(`packing_number`,`assign_no`,`so_id`, `create_dt`) 
                                      VALUES ('$p_no','$assign_no','$so_no','$currentDateTime')" ;
            $query_insert = $mysqli->query($sql_insert_tb_packing);
        }
        // pack no

        $sql_select_result = "SELECT * FROM tb_result 
                                           WHERE assign_no = '" . $assign_no . "'";
        $query_result = $mysqli->query($sql_select_result);
        $data_result = mysqli_fetch_object($query_result);


        $date_1 = $data_result->start_dt;
        $date1Obj = new DateTime($date_1);
        $timeParts = explode(':', $stopTime);
        $interval = new DateInterval('PT' . $timeParts[0] . 'H' . $timeParts[1] . 'M' . $timeParts[2] . 'S');
        $date1Obj->add($interval);
        $stop_dt = $date1Obj->format('Y-m-d H:i:s');

        $sql_update_as = "UPDATE `tb_assign` SET `assign_status`='52',`modify_dt`='$currentDateTime' WHERE  so_id = '" . $so_no . "' AND assign_no = '" . $assign_no . "'
                                            AND `assign_task` = 'pack'";
        $mysqli->query($sql_update_as);

        $sql_update_result = "UPDATE `tb_result` SET `stop_dt`='$stop_dt',`remark_id`='$remark_id',`remark`='$remark_note',`flag_assign`='N',`flag_print`='X' WHERE assign_no = '$assign_no'";
        $mysqli->query($sql_update_result);

        $sql_update_so = "UPDATE `tb_sale_order` SET `modify_dt`='$currentDateTime',`pack_status`='52' WHERE so_id = '$so_no'";
        $mysqli->query($sql_update_so);

        $sql_delete_detail = "DELETE FROM `tb_temp_scan` WHERE  assign_no = '$assign_no'";
        $mysqli->query($sql_delete_detail);
    }

    if ($sub_action == 'Y') {
        $so_no = $_POST['so_id'];
        $assign_no = $_POST['assign_no'];
        $emp_id = $_POST['emp_id'];
        $stopTime = $_POST['stopTime'];

        // pack no
        $sql_select_assign = "SELECT * FROM `tb_assign` WHERE so_id = '" . $so_no . "' AND assign_task = 'pack'" ;
        $query_assign = $mysqli->query($sql_select_assign);
        $data_result_assign = mysqli_num_rows($query_assign);
        if($data_result_assign == 1){
            $current_date = date('Y-m-d');
            $thai_year = (date('Y') + 543) % 100;
            $month = date('m');
            $day = date('d');
            $result = $thai_year . $month . $day;
            $parts = explode('/', $so_no);
            $after_slash = $parts[1];
            $p_no = $result.'-'.$after_slash ;
            $sql_insert_tb_packing = "INSERT INTO `tb_packing_number`(`packing_number`,`assign_no`,`so_id`, `create_dt`) 
                                      VALUES ('$p_no','$assign_no','$so_no','$currentDateTime')" ;
            $query_insert = $mysqli->query($sql_insert_tb_packing);
        }
        // pack no

        $sql_select_result = "SELECT * FROM tb_result 
                                           WHERE assign_no = '" . $assign_no . "'";
        $query_result = $mysqli->query($sql_select_result);
        $data_result = mysqli_fetch_object($query_result);


        $date_1 = $data_result->start_dt;
        $date1Obj = new DateTime($date_1);
        $timeParts = explode(':', $stopTime);
        $interval = new DateInterval('PT' . $timeParts[0] . 'H' . $timeParts[1] . 'M' . $timeParts[2] . 'S');
        $date1Obj->add($interval);
        $stop_dt = $date1Obj->format('Y-m-d H:i:s');


        $sql_update_as = "UPDATE `tb_assign` SET `assign_status`='42',`modify_dt`='$currentDateTime' WHERE  so_id = '" . $so_no . "' AND assign_no = '" . $assign_no . "'
                                            AND `assign_task` = 'pack'";
        $mysqli->query($sql_update_as);

        $sql_update_result = "UPDATE `tb_result` SET `stop_dt`='$stop_dt',`flag_assign`='Y',`flag_print`='X' WHERE assign_no = '$assign_no'";
        $mysqli->query($sql_update_result);

        $sql_update_so = "UPDATE `tb_sale_order` SET `modify_dt`='$currentDateTime',`pack_status`='42' WHERE so_id = '$so_no'";
        $mysqli->query($sql_update_so);

        $sql_delete_detail = "DELETE FROM `tb_temp_scan` WHERE  assign_no = '$assign_no'";
        $mysqli->query($sql_delete_detail);
    }



}

?>