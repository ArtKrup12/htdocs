<?php
include '../condb.php';

$id =$_POST['id'];
$name = $_POST['name'];
$DateNow = $_POST['date'];


//$now = new DateTime(); // Creates a DateTime object representing the current date and time
//$DateNow = $now->format('Y-m-d H:i:s');
for($i=0 ;$i < count($id) ;$i++) {
    $sqlSelect = "SELECT * FROM tb_document_list WHERE id =" . $id[$i];
    $resultSelect = mysqli_query($conn, $sqlSelect);
    $dataDoc = mysqli_fetch_object($resultSelect);

    $sql = "INSERT INTO tb_history_destroy(list,cotton,date_withdraw,box_code,box_number,name_withdraw,create_date,id_ref,date_destroy,name_destroy
) VALUES('$dataDoc->list','$dataDoc->cotton','$dataDoc->date_document_withdraw','$dataDoc->box_code','$dataDoc->box_number','$dataDoc->name_withdraw','$DateNow','$id[$i]','$DateNow','$name')";
    $result = mysqli_query($conn, $sql);

    $sql2 = "UPDATE tb_history_withdraw SET status_destroy = 'ทำลาย' WHERE box_code = '$dataDoc->box_code' AND box_number = '$dataDoc->box_number' AND name_return is null AND id_ref = '$id[$i]'";
    $result = mysqli_query($conn, $sql2);

    $sql3 = "DELETE FROM tb_document_list WHERE id='$id[$i]' ";
    $result3 = mysqli_query($conn, $sql3);
}
    $data = array(
        "status" => "200",
        "message" => "บันทึกรายการ เรียบร้อย"
    );
    echo json_encode($data);
mysqli_close($conn);

?>
