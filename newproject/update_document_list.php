<?php
include 'condb.php';

$id = $_POST['id'];
$list = $_POST['list'];
$box_code = $_POST['box_code'];
$box_number = $_POST['box_number'];
$cotton = $_POST['cotton'];


$sql="UPDATE tb_document_list set list='$list', box_code='$box_code', box_number='$box_number', cotton='$cotton' WHERE id='$id'";
$result=mysqli_query($conn,$sql);
if($result){
    echo "<script>alert('แก้ไขรายการ เรียบร้อย');</script>";
    echo "<script>window.location='document_list.php';</script>";
} else {
    echo "<script>alert('ไม่สามารถแก้ไขรายการได้');</script>";   
}


mysqli_close($conn);
?>