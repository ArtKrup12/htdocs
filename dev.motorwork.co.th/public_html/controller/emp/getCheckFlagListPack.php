<?php

include "../../config/connect.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sale_id = $_REQUEST['so_id'];
//    $barcode = trim($_POST['barcode']);
//    $assign_id = $_REQUEST['assign_id'];

    $sql_select = "SELECT  flag_pack
            FROM tb_sale_order_detail
            WHERE so_id = '$sale_id'";

    $query_select = $mysqli->query($sql_select);
    $num_data = mysqli_num_rows($query_select) ;
//    $row_data = $query_select->fetch_assoc();
    $wait_process = 0 ;
    $count_Y = 0 ;
    $count_N = 0 ;
    $count_X = 0 ;
    while ($row_data = mysqli_fetch_assoc($query_select)){
        if($row_data['flag_pack'] == 'X'){
            $wait_process = $wait_process + 1 ;
            $count_X = $count_X + 1 ;
        }
        if($row_data['flag_pack'] == 'Y'){
            $count_Y = $count_Y + 1 ;
        }
        if($row_data['flag_pack'] == 'N'){
            $count_N = $count_N + 1 ;
        }

    }
    $res_data = array(
        "status" => 200,
        "progress" => $num_data,
        "wait_process" => $wait_process,
        "count_Y"=>$count_Y,
        "count_N"=>$count_N,
        "count_X"=>$count_X,
    );
    echo json_encode($res_data);

}

?>
