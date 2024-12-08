<?php
include "../../config/connect.php";
//opcache_reset();

header("Content-Type: application/json");
$current_time = date('Y-m-d H:i:s');
$body = file_get_contents("php://input");
$data = json_decode($body, true);

if (!$data) {
    $insert_log = "INSERT INTO `tb_logs_sale_order`(`so_id`, `type`, `status_code`, `status`, `message`) VALUES ('','','400','error','Invalid JSON data')";
    $mysqli->query($insert_log);
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Invalid JSON data"]);
    exit;
}

$expectedToken = "SM37VShEQaPGAFOakpcr8ZTYPgRgmsdGG40qMUjOgpB0e4gzDZrlec9Pm016cFbr";

$headers = apache_request_headers();
$authHeader = isset($headers['Authorization']) ? $headers['Authorization'] : '';

if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
    $token = $matches[1];
    if ($token !== $expectedToken) {
        $insert_log = "INSERT INTO `tb_logs_sale_order`(`so_id`, `type`, `status_code`, `status`, `message`) VALUES ('','','400','error','Unauthorized')";
        $mysqli->query($insert_log);
        http_response_code(401);
        echo json_encode(["status" => "error", "message" => "Unauthorized"]);
        exit;
    }
} else {
    $insert_log = "INSERT INTO `tb_logs_sale_order`(`so_id`, `type`, `status_code`, `status`, `message`) VALUES ('','','400','error','Authorization header missing or invalid')";
    $mysqli->query($insert_log);
    http_response_code(401);
    echo json_encode(["status" => "error", "message" => "Authorization header missing or invalid"]);
    exit;
}

if (isset($data['so_id'], $data['so_date'], $data['cust_id']) &&
    $data['so_id'] !== "" && $data['so_date'] !== "" && $data['cust_id'] !== "" && $data['prod_id'] !== "") {

    $action_row = $data['transaction_row'];
    list($part1, $part2) = explode("/", $action_row);
    $part1 = (int)$part1;
    $part2 = (int)$part2;
    $result_tran = $part2 - $part1;

    $upDateCus = '' ;
    $select_cust = "SELECT * FROM `tb_customer` WHERE `cust_id` = '" . $data['cust_id'] . "'";
    $result_cust = $mysqli->query($select_cust);
    if ($result_cust->num_rows > 0) {
        $update_cust = "UPDATE `tb_customer` SET `cust_name` = '" . $data['cust_name'] . "', `modify_dt` = '" . $current_time . "' WHERE `cust_id` = '" . $data['cust_id'] . "'";
        $mysqli->query($update_cust);
        $upDateCus = ',update customer' ;
    } else {
        $insert_cust = "INSERT INTO `tb_customer`(`cust_id`, `cust_name`, `modify_dt`) VALUES ('" . $data['cust_id'] . "', '" . $data['cust_name'] . "', '" . $current_time . "')";
        $mysqli->query($insert_cust);
    }

    $upDatePrd = '' ;
    $select_prod = "SELECT * FROM `tb_product` WHERE `prod_id` = '" . $data['prod_id'] . "'";
    $result = $mysqli->query($select_prod);
    if ($result->num_rows > 0) {

        $update_prod = "UPDATE `tb_product` SET `prod_name` = '" . $data['prod_name'] . "', `modify_dt` = '" . $current_time . "' WHERE `prod_id` = '" . $data['prod_id'] . "'";
        $mysqli->query($update_prod);
        $upDatePrd = ',update product' ;

    } else {
        $insert_prod = "INSERT INTO `tb_product`(`prod_id`, `prod_name`, `modify_dt`) VALUES ('" . $data['prod_id'] . "', '" . $data['prod_name'] . "', '" . $current_time . "')";
        $mysqli->query($insert_prod);
    }
$updateAny = $upDateCus.$upDatePrd ;
    if ($result_tran == 0) {
        $insert_so = "INSERT INTO `tb_temp_sale_order_list`(`so_id`, `so_date`, `create_dt`, `cust_id`, `cust_name`, `so_num`, `prod_id`, `prod_name`, `prod_location`, `prod_qty`, `transaction_row`, `create_date`, `status`)
        VALUES ('" . $data['so_id'] . "','" . $data['so_date'] . "','" . $data['create_dt'] . "','" . $data['cust_id'] . "','" . $data['cust_name'] . "','" . $data['so_num'] . "','" . $data['prod_id'] . "','" . $data['prod_name'] . "','" . $data['prod_location'] . "','" . $data['prod_qty'] . "','" . $data['transaction_row'] . "','" . $current_time . "','N')";
        if ($mysqli->query($insert_so) === true) {
            $insert_so2 = "INSERT INTO `tb_sale_order`(`so_id`, `so_date`, `cust_id`,`create_dt`)
        VALUES ('" . $data['so_id'] . "','" . $data['so_date'] . "','" . $data['cust_id'] . "','" . $current_time . "')";
            if ($mysqli->query($insert_so2) === true) {

                $select_so = "SELECT * FROM `tb_temp_sale_order_list` WHERE `so_id` = '" . $data['so_id'] . "'";
                $result_so = $mysqli->query($select_so);

                $select_so_stat = "UPDATE `tb_temp_sale_order_list` SET `status`='Y' WHERE so_id = '" . $data['so_id'] . "'";
                $result_sostt = $mysqli->query($select_so_stat);

                while ($row_list = mysqli_fetch_assoc($result_so)) {
                    $insert_so_detail = "INSERT INTO `tb_sale_order_detail`(`so_id`, `so_num`, `prod_id`, `prod_location`, `prod_qty`,`create_dt`)
                VALUES ('" . $row_list['so_id'] . "','" . $row_list['so_num'] . "','" . $row_list['prod_id'] . "','" . $row_list['prod_location'] . "'," . $row_list['prod_qty'] . ",'" . $current_time . "');";
                    $mysqli->query($insert_so_detail);
                }
                $insert_log = "INSERT INTO `tb_logs_sale_order`(`so_id`, `type`, `status_code`, `status`, `message`) VALUES ('" . $data['so_id'] . "','new".$updateAny."','200','success','Data inserted successfully/Insert sale order Complete')";
                $mysqli->query($insert_log);

                $select_so_stat = "DELETE FROM `tb_temp_sale_order_list` WHERE so_id = '" . $data['so_id'] . "' AND status = 'Y' ";
                $result_sostt = $mysqli->query($select_so_stat);

                $mess = "Data inserted successfully/Insert sale order Complete:" . $data['transaction_row'];
                http_response_code(200);
                echo json_encode(["status" => "success", "message" => $mess]);
            } else {
                $insert_log = "INSERT INTO `tb_logs_sale_order`(`so_id`, `type`, `status_code`, `status`, `message`) VALUES ('" . $data['so_id'] . "','dupicate so','500','ErrorDup','Failed to insert data')";
                $mysqli->query($insert_log);
                http_response_code(500);
                echo json_encode([
                    "status" => "ErrorDup",
                    "message" => "Failed to insert sale_order",
                    "error" => $mysqli->error // แสดงข้อความข้อผิดพลาดของ MySQL
                ]);
            }
//            $trans_so2 = $mysqli->query($insert_so2) ;
        } else {
            $insert_log = "INSERT INTO `tb_logs_sale_order`(`so_id`, `type`, `status_code`, `status`, `message`) VALUES ('" . $data['so_id'] . "','dupicate so','500','ErrorDup','Failed to insert data')";
            $mysqli->query($insert_log);
            http_response_code(500);
            echo json_encode(["status" => "ErrorDup", "message" => "Failed to insert data"]);
        }
    } else {
//        echo "เงื่อนไขเป็นเท็จ: ผลลัพธ์การลบไม่เท่ากับ 0";
        $insert_so = "INSERT INTO `tb_temp_sale_order_list`(`so_id`, `so_date`, `create_dt`, `cust_id`, `cust_name`, `so_num`, `prod_id`, `prod_name`, `prod_location`, `prod_qty`, `transaction_row`, `create_date`, `status`)
        VALUES ('" . $data['so_id'] . "','" . $data['so_date'] . "','" . $data['create_dt'] . "','" . $data['cust_id'] . "','" . $data['cust_name'] . "','" . $data['so_num'] . "','" . $data['prod_id'] . "','" . $data['prod_name'] . "','" . $data['prod_location'] . "','" . $data['prod_qty'] . "','" . $data['transaction_row'] . "','" . $current_time . "','N')";
        if ($mysqli->query($insert_so) === true) {
            $insert_log = "INSERT INTO `tb_logs_sale_order`(`so_id`, `type`, `status_code`, `status`, `message`) VALUES ('" . $data['so_id'] . "','new','200','success','Data inserted successfully " . $data['transaction_row'] . "')";
            $mysqli->query($insert_log);
            http_response_code(200);
            echo json_encode(["status" => "success", "message" => "Data inserted successfully " . $data['transaction_row']]);
        } else {
            $insert_log = "INSERT INTO `tb_logs_sale_order`(`so_id`, `type`, `status_code`, `status`, `message`) VALUES ('" . $data['so_id'] . "','new','500','ErrorDup','Failed to insert data " . $data['transaction_row'] . "')";
            $mysqli->query($insert_log);
            http_response_code(500);
            echo json_encode(["status" => "ErrorDup", "message" => "Failed to insert data"]);
        }
    }

} else {
    $insert_log = "INSERT INTO `tb_logs_sale_order`(`so_id`, `type`, `status_code`, `status`, `message`) VALUES ('" . $data['so_id'] . "','new','400','ErrorData','Missing or empty required fields: so_id, so_date, cust_id, or list')";
    $mysqli->query($insert_log);
    http_response_code(400);
    echo json_encode(["status" => "ErrorData", "message" => "Missing or empty required fields: so_id, so_date, cust_id, or list"]);
}
?>

