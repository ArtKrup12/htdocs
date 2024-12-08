<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "../../config/connect.php";

$action = $_POST['action'];

date_default_timezone_set('Asia/Bangkok');
$currentDateTime = date('Y-m-d H:i:s');

if ($action == 'checkOutSo') {
    $sub_action = $_POST['sub_action'];
    if ($sub_action == 'end') {
        $type_action = $_POST['type_action'];
        if ($type_action == 'pick') {
            $so_no = $_POST['so_id'];
            $remark_list_id = $_POST['remark_list_id'];
            $remark_list_des = $_POST['remark_list_des'];
//            $remarks = $_POST['remarks'] ;
            $emp_id = $_POST['emp_id'];
            $assign_no = $_POST['assign_no'];

            if (isset($_POST['remarks'])) {
                $remarks = $_POST['remarks'];
                for ($i = 0; $i < sizeof($remarks); $i++) {
//                            echo $remarks[$i]['prod_id'] ;
                    $select_item = "SELECT * FROM `tb_pick` WHERE so_detail_no = '" . $remarks[$i]['prod_id'] . "'  AND assign_no = '$assign_no' ORDER BY create_dt DESC LIMIT 1;";
                    $query_select_item = mysqli_query($mysqli, $select_item);
                    $obj_select = mysqli_fetch_object($query_select_item);

                    $sql_insert_tb_remarks = "INSERT INTO `tb_pick_remark`(`pick_no`, `emp_id`,`emp_type`, `remark`, `create_dt`) 
                VALUES ('" . $obj_select->pick_no . "','$emp_id',2,'" . $remarks[$i]['remark'] . "','$currentDateTime')";
                    $mysqli->query($sql_insert_tb_remarks);
                }
            } else {

            }

            $sql30 = "INSERT INTO `tb_approval`(`assign_no`, `assign_round`, `delegator_id`, `approve_status`, `approve_dt`, `remark_id`, `remark`)
                VALUES ('$assign_no','1','$emp_id',61,'$currentDateTime','$remark_list_id','$remark_list_des');";
            $query30 = $mysqli->query($sql30);

            $sql3 = "UPDATE `tb_sale_order` SET `pick_status`= 61 ,`modify_dt`='$currentDateTime' WHERE so_id = '$so_no';";
            $query3 = $mysqli->query($sql3);
        }

        if ($type_action == 'pack') {

            $so_no = $_POST['so_id'];
            $remark_list_id = $_POST['remark_list_id'];
            $remark_list_des = $_POST['remark_list_des'];
//            $remarks = $_POST['remarks'] ;
            $emp_id = $_POST['emp_id'];
            $assign_no = $_POST['assign_no'];

            if (isset($_POST['remarks'])) {
                $remarks = $_POST['remarks'];
                for ($i = 0; $i < sizeof($remarks); $i++) {
//                            echo $remarks[$i]['prod_id'] ;
                    $select_item = "SELECT * FROM `tb_pack` WHERE so_detail_no = '" . $remarks[$i]['prod_id'] . "'  AND assign_no = '$assign_no' ORDER BY create_dt DESC LIMIT 1;";
                    $query_select_item = mysqli_query($mysqli, $select_item);
                    $obj_select = mysqli_fetch_object($query_select_item);

                    $sql_insert_tb_remarks = "INSERT INTO `tb_pack_remark`(`pick_no`, `emp_id`,`emp_type`, `remark`, `create_dt`) 
                VALUES ('" . $obj_select->pick_no . "','$emp_id',2,'" . $remarks[$i]['remark'] . "','$currentDateTime')";
                    $mysqli->query($sql_insert_tb_remarks);
                }
            } else {

            }

            $sql30 = "INSERT INTO `tb_approval`(`assign_no`, `assign_round`, `delegator_id`, `approve_status`, `approve_dt`, `remark_id`, `remark`)
                VALUES ('$assign_no','1','$emp_id',62,'$currentDateTime','$remark_list_id','$remark_list_des');";
            $query30 = $mysqli->query($sql30);

            $sql3 = "UPDATE `tb_sale_order` SET `pack_status`= 62 ,`modify_dt`='$currentDateTime' WHERE so_id = '$so_no';";
            $query3 = $mysqli->query($sql3);

        }
    }

    if ($sub_action == 'new') {
        $type_action = $_POST['type_action'];
        if ($type_action == 'pick') {
            $so_no = $_POST['so_id'];
            $remark_list_id = $_POST['remark_list_id'];
            $remark_list_des = $_POST['remark_list_des'];
            $assign_no = $_POST['assign_no'];
            $emp_id = $_POST['emp_id'];

            if (isset($_POST['remarks'])) {
                $remarks = $_POST['remarks'];
                for ($i = 0; $i < sizeof($remarks); $i++) {
//                            echo $remarks[$i]['prod_id'] ;
                    $select_item = "SELECT * FROM `tb_pick` WHERE so_detail_no = '" . $remarks[$i]['prod_id'] . "'  AND assign_no = '$assign_no' ORDER BY create_dt DESC LIMIT 1;";
                    $query_select_item = mysqli_query($mysqli, $select_item);
                    $obj_select = mysqli_fetch_object($query_select_item);

                    $sql_insert_tb_remarks = "INSERT INTO `tb_pick_remark`(`pack_no`, `emp_id`,`emp_type`, `remark`, `create_dt`) 
                VALUES ('" . $obj_select->pick_no . "','$emp_id',2,'" . $remarks[$i]['remark'] . "','$currentDateTime')";
                    $mysqli->query($sql_insert_tb_remarks);

                }
            } else {

            }

            $sql30 = "INSERT INTO `tb_approval`(`assign_no`, `assign_round`, `delegator_id`, `approve_status`, `approve_dt`, `remark_id`, `remark`)
                VALUES ('$assign_no','1','$emp_id',12,'$currentDateTime','$remark_list_id','$remark_list_des');";
            $query30 = $mysqli->query($sql30);

            $sql3 = "UPDATE `tb_sale_order` SET `pick_status`= 12,`modify_dt`='$currentDateTime' WHERE so_id = '$so_no';";
            $query3 = $mysqli->query($sql3);
        }
        if ($type_action == 'pack') {

            $so_no = $_POST['so_id'];
            $remark_list_id = $_POST['remark_list_id'];
            $remark_list_des = $_POST['remark_list_des'];
            $assign_no = $_POST['assign_no'];
            $emp_id = $_POST['emp_id'];

            if (isset($_POST['remarks'])) {
                $remarks = $_POST['remarks'];
                for ($i = 0; $i < sizeof($remarks); $i++) {
//                            echo $remarks[$i]['prod_id'] ;
                    $select_item = "SELECT * FROM `tb_pack` WHERE so_detail_no = '" . $remarks[$i]['prod_id'] . "'  AND assign_no = '$assign_no' ORDER BY create_dt DESC LIMIT 1;";
                    $query_select_item = mysqli_query($mysqli, $select_item);
                    $obj_select = mysqli_fetch_object($query_select_item);

                    $sql_insert_tb_remarks = "INSERT INTO `tb_pack_remark`(`pack_no`, `emp_id`,`emp_type`, `remark`, `create_dt`) 
                VALUES ('" . $obj_select->pack_no . "','$emp_id',2,'" . $remarks[$i]['remark'] . "','$currentDateTime')";
                    $mysqli->query($sql_insert_tb_remarks);

                }
            } else {

            }

            $sql30 = "INSERT INTO `tb_approval`(`assign_no`, `assign_round`, `delegator_id`, `approve_status`, `approve_dt`, `remark_id`, `remark`)
                VALUES ('$assign_no','1','$emp_id',13,'$currentDateTime','$remark_list_id','$remark_list_des');";
            $query30 = $mysqli->query($sql30);

            $sql3 = "UPDATE `tb_sale_order` SET `pack_status`= 13,`modify_dt`='$currentDateTime' WHERE so_id = '$so_no';";
            $query3 = $mysqli->query($sql3);
        }
    }
    echo json_encode(['success' => true, 'message' => 'username นี้มีอยู่ในระบบแล้ว']);
} else {
    echo json_encode(['success' => false, 'message' => 'การส่งค่ามาไม่ถูกต้อง']);
}

?>