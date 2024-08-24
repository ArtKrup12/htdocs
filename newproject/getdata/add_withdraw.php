<?php
include '../condb.php';

$id =$_POST['id'];
$name = $_POST['name'];
$DateNow = $_POST['date'];


//$now = new DateTime(); // Creates a DateTime object representing the current date and time
//$DateNow = $now->format('Y-m-d H:i:s');

$sqlSelect ="SELECT * FROM tb_document_list WHERE id =".$id;
$resultSelect =mysqli_query($conn,$sqlSelect);
$dataDoc = mysqli_fetch_object($resultSelect) ;


$sql="INSERT INTO tb_history_withdraw(list,cotton,date_withdraw,box_code,box_number,name_withdraw,create_date,id_ref
) VALUES('$dataDoc->list','$dataDoc->cotton','$DateNow','$dataDoc->box_code','$dataDoc->box_number','$name','$DateNow','$id')";
$result=mysqli_query($conn,$sql);

$sql2="UPDATE tb_document_list SET name_withdraw = '$name',date_document_withdraw='$DateNow',status = '20' WHERE box_code = '$dataDoc->box_code' AND box_number = '$dataDoc->box_number' AND id = '$id' ";
$result2=mysqli_query($conn,$sql2);

if($result2){
    $data = array(
        "status" => "200",
        "message" => "บันทึกรายการ เรียบร้อย"
    );
    echo json_encode($data);
} else {
    $data = array(
        "status" => "500",
        "message" => $result
    );
    echo json_encode($data);
}
//$data = array(
//        "id" => $id,
//        "name" => $name
//    );
//echo json_encode($data);

mysqli_close($conn);

?>
