<?php

include "../../config/connect.php";

$action = $_POST['action'] ;

date_default_timezone_set('Asia/Bangkok');
$currentDateTime = date('Y-m-d H:i:s');

if ($action == 'assign') {
    $sub_action = $_POST['sub_action'] ;
    if($sub_action == 'pick'){
        $status = $_POST['status_pick'] ;
        $delegatee_id = $_POST['member_pick'] ;
        $so_id = $_POST['so_id'] ;
        if($status == 11 || $status == 12){
            if($status == 11){
                $select_item = "SELECT count(*) as total_item,SUM(prod_qty) as total_qty FROM `tb_sale_order_detail` WHERE so_id = '".$so_id."'";
                $query_select_item =   mysqli_query($mysqli,$select_item) ;
                $obj_select = mysqli_fetch_object($query_select_item) ;

                $insert_assign = "INSERT INTO `tb_assign`(`assign_task`, `so_id`, `total_item`, `total_qty`, `assign_round`,`delegatee_id`, `assign_status`) 
            VALUES ('pick','$so_id','".$obj_select->total_item."','".$obj_select->total_qty."',1,'$delegatee_id',21)";
                mysqli_query($mysqli,$insert_assign) ;

                $update_sale_order = "UPDATE `tb_sale_order` SET `pick_status`='21',`modify_dt`='$currentDateTime' WHERE so_id = '$so_id'";
                mysqli_query($mysqli,$update_sale_order) ;
            }

            if($status == 12){
                $select_item = "SELECT count(*) as total_item,SUM(prod_qty) as total_qty FROM `tb_sale_order_detail` WHERE so_id = '".$so_id."'";
                $query_select_item =   mysqli_query($mysqli,$select_item) ;
                $obj_select = mysqli_fetch_object($query_select_item) ;

                $select_so = "SELECT * FROM `tb_assign` WHERE so_id = '$so_id' AND assign_task = 'pick';";
                $query_select_so =   mysqli_query($mysqli,$select_so) ;
                $num_round = mysqli_num_rows($query_select_so) ;
                $cur_round = $num_round + 1 ;

                $insert_assign = "INSERT INTO `tb_assign`(`assign_task`, `so_id`, `total_item`, `total_qty`, `assign_round`,`delegatee_id`, `assign_status`) 
            VALUES ('pick','$so_id','".$obj_select->total_item."','".$obj_select->total_qty."','$cur_round','$delegatee_id',21)";
                mysqli_query($mysqli,$insert_assign) ;

                $update_sale_order = "UPDATE `tb_sale_order` SET `pick_status`='21',`modify_dt`='$currentDateTime' WHERE so_id = '$so_id'";
                mysqli_query($mysqli,$update_sale_order) ;
            }

        }else{
            if($status == 21){
                $select_assign = "SELECT * FROM `tb_assign` WHERE so_id = '".$so_id."' AND assign_task = 'pick' ORDER BY assign_round DESC LIMIT 1";
                $query_select_assign =   mysqli_query($mysqli,$select_assign) ;
                $obj_select_assign = mysqli_fetch_object($query_select_assign) ;

                $update_assign = "UPDATE `tb_assign` SET `assign_status`=21,`delegatee_id`='$delegatee_id',`modify_dt`='$currentDateTime' WHERE so_id = '".$so_id."' AND assign_task = 'pick' AND assign_no = '".$obj_select_assign->assign_no."'";
                mysqli_query($mysqli,$update_assign) ;
            }else{

            }

//            $update_sale_order = "UPDATE `tb_sale_order` SET `pick_status`='21',`modify_dt`='$currentDateTime' WHERE so_id = '$so_id'";
//            mysqli_query($mysqli,$update_sale_order) ;
        }
    }

    if($sub_action == 'pack'){
        $status = $_POST['status_pack'] ;
        $delegatee_id = $_POST['member_pack'] ;
        $so_id = $_POST['so_id'] ;
        if($status == 11 || $status == 13){
            if($status == 11){
                $select_item = "SELECT count(*) as total_item,SUM(prod_qty) as total_qty FROM `tb_sale_order_detail` WHERE so_id = '".$so_id."'";
                $query_select_item =   mysqli_query($mysqli,$select_item) ;
                $obj_select = mysqli_fetch_object($query_select_item) ;

                $insert_assign = "INSERT INTO `tb_assign`(`assign_task`, `so_id`, `total_item`, `total_qty`, `assign_round`,`delegatee_id`, `assign_status`) 
            VALUES ('pack','$so_id','".$obj_select->total_item."','".$obj_select->total_qty."',1,'$delegatee_id',22)";
                mysqli_query($mysqli,$insert_assign) ;

                $update_sale_order = "UPDATE `tb_sale_order` SET `pack_status`='22',`modify_dt`='$currentDateTime' WHERE so_id = '$so_id'";
                mysqli_query($mysqli,$update_sale_order) ;
            }

            if($status == 13){
                $select_item = "SELECT count(*) as total_item,SUM(prod_qty) as total_qty FROM `tb_sale_order_detail` WHERE so_id = '".$so_id."'";
                $query_select_item =   mysqli_query($mysqli,$select_item) ;
                $obj_select = mysqli_fetch_object($query_select_item) ;

                $select_so = "SELECT * FROM `tb_assign` WHERE so_id = '$so_id' AND assign_task = 'pack';";
                $query_select_so =   mysqli_query($mysqli,$select_so) ;
                $num_round = mysqli_num_rows($query_select_so) ;
                $cur_round = $num_round + 1 ;

                $insert_assign = "INSERT INTO `tb_assign`(`assign_task`, `so_id`, `total_item`, `total_qty`, `assign_round`,`delegatee_id`, `assign_status`) 
            VALUES ('pack','$so_id','".$obj_select->total_item."','".$obj_select->total_qty."','$cur_round','$delegatee_id',22)";
                mysqli_query($mysqli,$insert_assign) ;

                $update_sale_order = "UPDATE `tb_sale_order` SET `pick_status`='22',`modify_dt`='$currentDateTime' WHERE so_id = '$so_id'";
                mysqli_query($mysqli,$update_sale_order) ;
            }

        }else{
            if($status == 22) {
                $select_assign = "SELECT * FROM `tb_assign` WHERE so_id = '" . $so_id . "' AND assign_task = 'pack' ORDER BY assign_round DESC LIMIT 1";
                $query_select_assign = mysqli_query($mysqli, $select_assign);
                $obj_select_assign = mysqli_fetch_object($query_select_assign);

                $update_assign = "UPDATE `tb_assign` SET `assign_status`=22,`delegatee_id`='$delegatee_id',`modify_dt`='$currentDateTime' WHERE so_id = '" . $so_id . "' AND assign_task = 'pack' AND assign_no = '" . $obj_select_assign->assign_no . "'";
                mysqli_query($mysqli, $update_assign);
            }else{}
        }
    }
    echo json_encode(['success' => true, 'message' => 'username นี้มีอยู่ในระบบแล้ว']);
}

?>