<?php

include "../../config/connect.php";

$so_no = $_POST['so_no'] ;
$assign_round = $_POST['ass_round'] ;
 $checkQuery = "SELECT * FROM `tb_assign` WHERE so_id = '".$so_no."' AND assign_task = 'pick' AND assign_round = '$assign_round' AND assign_status = '51';";
$result = mysqli_query($mysqli, $checkQuery);
$data = mysqli_fetch_object($result) ;
echo json_encode($data);

?>
