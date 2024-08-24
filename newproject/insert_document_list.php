<?php
include 'condb.php';

$list =$_POST['list'];
$box_code = $_POST['box_code'];
$box_number = $_POST['box_number'];
$cotton = $_POST['cotton'];

$sqlSelect ="SELECT cotton FROM tb_carton WHERE box_code = '".$box_code."' AND box_number = '".$box_number."'";
$resultSelect =mysqli_query($conn,$sqlSelect);
$dataDoc = mysqli_fetch_object($resultSelect) ;


$sql="INSERT INTO tb_document_list(list,box_code,box_number	,cotton,status) 
      VALUES('$list','$box_code','$box_number','$dataDoc->cotton','10')";
$result=mysqli_query($conn,$sql);

if($result){
    $data = array(
        "status" => "200",
        "message" => "บันทึกรายการ เรียบร้อย"
    );
    echo json_encode($data);
//    echo "<script>alert('บันทึกกล่อง เรียบร้อย');</script>";
//    echo "<script>window.location='document_list.php';</script>";
} else {
//    echo "<script>alert('ไม่สามารถบันทึกกล่องได้');</script>";
    $data = array(
        "status" => "500",
        "message" => "พบข้อผิดพลาด"
    );
    echo json_encode($data);
}

mysqli_close($conn);

?>
