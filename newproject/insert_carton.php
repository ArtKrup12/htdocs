<?php
include 'condb.php';

$box_code = $_POST['box_code'];
$box_number = $_POST['box_number'];
$cotton = $_POST['cotton'];
$detaile = $_POST['detaile'];

$sql="INSERT INTO tb_carton(box_code,box_number	,cotton,detaile) 
      VALUES('$box_code','$box_number','$cotton','$detaile')";
$result=mysqli_query($conn,$sql);
if($result){
    echo "<script>alert('บันทึกกล่อง เรียบร้อย');</script>";
    echo "<script>window.location='carton.php';</script>";
} else {
    echo "<script>alert('ไม่สามารถบันทึกกล่องได้');</script>";   
}

mysqli_close($conn);

?>
