<?php

include "../../config/connect.php";

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
    tb_sale_order.create_dt DESC;
";

$result = mysqli_query($mysqli, $checkQuery);

if ($result) {
    // เก็บผลลัพธ์ทั้งหมดเป็น array
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $so_id = $row['so_id'];

        // Query สำหรับ pick
        $pickQuery = "SELECT 
                        tb_assign.assign_no, 
                        tb_assign.so_id, 
                        tb_assign.assign_task, 
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

        // เปรียบเทียบ modify_dt ระหว่าง pick และ pack
        if ($pickData || $packData) {
            $pickStatus = $pickData ? $pickData['status'] : $row['pick_status'];
            $pickModifyDt = $pickData ? $pickData['modify_dt'] : null;

            $packStatus = $packData ? $packData['status'] : $row['pack_status'];
            $packModifyDt = $packData ? $packData['modify_dt'] : null;

            if (!$pickModifyDt || ($packModifyDt && $packModifyDt > $pickModifyDt)) {
                $row['status_last'] = $packStatus;
                $row['status_last_id'] = $packData ? $packData['assign_no'] : 'pack_status';
            } else {
                $row['status_last'] = $pickStatus;
                $row['status_last_id'] = $pickData ? $pickData['assign_no'] : 'pick_status';
            }
        } else {
            $row['status_last'] = null;
            $row['status_last_id'] = null;
        }

        // เก็บผลลัพธ์ใน array
        $data[] = $row;
    }

    // แปลงข้อมูลเป็น JSON และส่งกลับ
    echo json_encode($data);
} else {
    // ส่ง error message ถ้าการ query ผิดพลาด
    echo json_encode(['error' => 'Error: ' . mysqli_error($mysqli)]);
}

?>
