<?php
include 'condb.php';

$ids=$_GET['id'];
$sql="DELETE FROM tb_document_list WHERE id='$ids' ";
if(mysqli_query($conn,$sql)){
    echo "<script>alert('ลบรายการ เรียบร้อย');</script>";
    echo "<script>window.location='document_list.php';</script>";
} else {
    echo "<script>alert('ไม่สามารถลบรายการได้');</script>";   
}
mysqli_close($conn);

?>
