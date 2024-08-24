<?php
include 'condb.php';

$ids=$_GET['id'];
$sql="DELETE FROM tb_carton WHERE id='$ids' ";
if(mysqli_query($conn,$sql)){
    echo "<script>alert('ลบกล่อง เรียบร้อย');</script>";
    echo "<script>window.location='carton.php';</script>";
} else {
    echo "<script>alert('ไม่สามารถลบกล่องได้');</script>";   
}
mysqli_close($conn);

?>
