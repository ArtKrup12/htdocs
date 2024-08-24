<?php
include ('../condb.php') ;
$sql ="SELECT 
	(SELECT COUNT(*) FROM tb_carton WHERE cotton = 'ฝ่ายการเงิน') AS finnace ,
	(SELECT COUNT(*) FROM tb_carton WHERE cotton = 'ฝ่ายสารสนเทศ') AS information_tech,
	(SELECT COUNT(*) FROM tb_carton WHERE cotton = 'ฝ่ายสำนักงาน') AS information, 
	(SELECT COUNT(*) FROM tb_carton WHERE cotton = 'ฝ่ายสวัสดิการ') AS benefit,
	(SELECT COUNT(*) FROM tb_carton WHERE cotton = 'ฝ่ายบัญชี') AS account, 
	(SELECT COUNT(*) FROM tb_carton WHERE cotton = 'ฝ่ายทะเบียน') AS register,
	(SELECT COUNT(*) FROM tb_carton WHERE cotton = 'ฝ่ายสินเชื่อ') AS loan,
	(SELECT COUNT(*) FROM tb_carton WHERE cotton = 'ฝ่ายนโยบาย') AS policy";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_object($result);
$id = array("ฝ่ายการเงิน","ฝ่ายสารสนเทศ","ฝ่ายสำนักงาน","ฝ่ายสวัสดิการ","ฝ่ายบัญชี","ฝ่ายทะเบียน","ฝ่ายสินเชื่อ","ฝ่ายนโยบาย");
$dataSelect = array($row->finnace,$row->information_tech,$row->information,$row->benefit,$row->account,$row->register,$row->loan,$row->policy);
$data = array(
    "labelName" => $id,
    "dataShow" => $dataSelect
);

echo json_encode($data);