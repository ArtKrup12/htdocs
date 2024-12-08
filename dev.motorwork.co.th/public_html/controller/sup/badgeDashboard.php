<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
session_start();
include "../../config/connect.php";

// Query หลัก
$checkQuery = "SELECT 
    tb_sale_order.so_id,
    tb_sale_order.so_date,
    tb_sale_order.cust_id,
    tb_customer.cust_name,
    COUNT(tb_sale_order_detail.so_id) AS list_count,
    tb_sale_order.pick_status,
    tb_sale_order.pack_status
FROM 
    tb_sale_order
LEFT JOIN 
    tb_customer ON tb_customer.cust_id = tb_sale_order.cust_id
LEFT JOIN 
    tb_sale_order_detail ON tb_sale_order_detail.so_id = tb_sale_order.so_id
GROUP BY 
    tb_sale_order.so_id, 
    tb_sale_order.so_date, 
    tb_sale_order.cust_id, 
    tb_customer.cust_name
ORDER BY 
    tb_sale_order.create_dt DESC";

$result = mysqli_query($mysqli, $checkQuery);

// ตัวนับสถานะ
$all = 0;
$wait = 0;
$assign = 0;
$onprocess = 0;
$success = 0;
$unsuccess = 0;

$data = []; // สำหรับเก็บข้อมูลทั้งหมด

while ($row = mysqli_fetch_assoc($result)) {
    $all++; // นับทุกแถวใน Query

    $so_id = $row['so_id'];

    // Query สำหรับ pick
    $pickQuery = "SELECT 
                        tb_assign.assign_no, 
                        tb_assign.so_id, 
                        tb_assign.assign_task, 
                        tb_assign.delegatee_id,
                        IFNULL(tb_approval.approve_status, tb_assign.assign_status) AS status,  
                        IFNULL(tb_approval.approve_dt, tb_assign.modify_dt) AS modify_dt 
                      FROM 
                        tb_assign 
                      LEFT JOIN 
                        tb_approval 
                      ON 
                        tb_approval.assign_no = tb_assign.assign_no 
                      WHERE 
                        tb_assign.so_id = '$so_id' 
                        AND tb_assign.assign_task = 'pick'";
    $pickResult = mysqli_query($mysqli, $pickQuery);
    $pickData = mysqli_fetch_assoc($pickResult);

    // Query สำหรับ pack
    $packQuery = "SELECT 
                        tb_assign.assign_no, 
                        tb_assign.so_id, 
                        tb_assign.assign_task, 
                        tb_assign.delegatee_id,
                        IFNULL(tb_approval.approve_status, tb_assign.assign_status) AS status,  
                        IFNULL(tb_approval.approve_dt, tb_assign.modify_dt) AS modify_dt 
                      FROM 
                        tb_assign 
                      LEFT JOIN 
                        tb_approval 
                      ON 
                        tb_approval.assign_no = tb_assign.assign_no 
                      WHERE 
                        tb_assign.so_id = '$so_id' 
                        AND tb_assign.assign_task = 'pack'";
    $packResult = mysqli_query($mysqli, $packQuery);
    $packData = mysqli_fetch_assoc($packResult);

    // ตรวจสอบข้อมูล pick และ pack
    $row['pick_status'] = $pickData ? $pickData['status'] : $row['pick_status'];
    $row['pick_delegatee_id'] = $pickData ? $pickData['delegatee_id'] : null;
    $row['pick_modify_dt'] = $pickData ? $pickData['modify_dt'] : null;

    $row['pack_status'] = $packData ? $packData['status'] : $row['pack_status'];
    $row['pack_delegatee_id'] = $packData ? $packData['delegatee_id'] : null;
    $row['pack_modify_dt'] = $packData ? $packData['modify_dt'] : null;

    // ตรวจสอบสถานะล่าสุดระหว่าง pick และ pack
    if (!$row['pick_modify_dt'] || ($row['pack_modify_dt'] && $row['pack_modify_dt'] > $row['pick_modify_dt'])) {
        $row['status_last'] = $row['pack_status'];
        $row['status_last_id'] = $packData ? $packData['assign_no'] : 'pack_status';
    } else {
        $row['status_last'] = $row['pick_status'];
        $row['status_last_id'] = $pickData ? $pickData['assign_no'] : 'pick_status';
    }

    // นับสถานะ
    if (in_array($row['status_last'], [11, null])) {
        $wait++;
    } elseif (in_array($row['status_last'], [21, 22, 12, 13])) {
        $assign++;
    } elseif (in_array($row['status_last'], [31, 32])) {
        $onprocess++;
    } elseif (in_array($row['status_last'], [41, 42, 61, 62])) {
        $success++;
    } elseif (in_array($row['status_last'], [51, 52])) {
        $unsuccess++;
    }

    // เก็บผลลัพธ์ใน array
    $data[] = $row;
}

// สร้าง response JSON
$result = array(
    'all' => $all,
    'wait' => $wait,
    'assign' => $assign,
    'onprocess' => $onprocess,
    'success' => $success,
    'unsuccess' => $unsuccess,
    'data' => $data,
);

// ส่งข้อมูล JSON
echo json_encode($result);
?>
