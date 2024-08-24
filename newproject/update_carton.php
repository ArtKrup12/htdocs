<?php
include 'condb.php';

$id = $_POST['id'];
$box_code = $_POST['box_code'];
$box_number = $_POST['box_number'];
$cotton = $_POST['cotton'];
$detaile = $_POST['detaile'];

$sql="UPDATE tb_carton set box_code='$box_code', box_number='$box_number', cotton='$cotton', detaile='$detaile' WHERE id='$id'";
$result=mysqli_query($conn,$sql);
if($result){
    echo "<script>alert('แก้ไขกล่อง เรียบร้อย');</script>";
    echo "<script>window.location='carton.php';</script>";
} else {
    echo "<script>alert('ไม่สามารถแก้ไขกล่องได้');</script>";   
}


mysqli_close($conn);
?>