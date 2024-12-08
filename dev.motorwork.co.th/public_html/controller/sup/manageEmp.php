<?php
include "../../config/connect.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$modify_dt = date('Y-m-d H:i:s');
$create_dt_img = date('YmdHis');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ;
    if($action == 'update_status_emp'){
        $emp_id = $_POST['emp_id'];
        $emp_status = $_POST['status'];

        $stmt = $mysqli->prepare("CALL UpdateEmployeeStatus(?, ?, ?)");
        $stmt->bind_param("iis", $emp_id, $emp_status, $modify_dt);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }

        $stmt->close();
        $mysqli->close();
    }

    if($action == 'addEmployee'){
        $emp_name = $_POST['emp_name'];
        $emp_surname = $_POST['emp_surname'];
        $username = $_POST['user_name'];
        $status = $_POST['status'];
        $password = $_POST['password'];
        $role_no = $_POST['role_no'];

        $insert_ = "INSERT INTO `tb_employee`(`emp_name`, `emp_surname`, `username`, `password`, `role_no`, `emp_status`, `create_dt`) 
                    VALUES ('$emp_name','$emp_surname' ,'$username' ,'$password','$role_no','$status','$modify_dt')";

        if (mysqli_query($mysqli,$insert_)) {
            $emp_id = $mysqli->insert_id;

            if(isset($_FILES['file'])){
                $file = $_FILES['file'];
                $targetDir = "../../assets/uploads/member_pic/";
                $fileExtension = pathinfo($file["name"], PATHINFO_EXTENSION);
                $fileName = $emp_id.'_'.$create_dt_img. "." . $fileExtension;

//                $fileName = $emp_id. "_" . basename($file["name"]);
                $targetFile = $targetDir . $fileName;
                $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
                if(in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])){
                    if(move_uploaded_file($file["tmp_name"], $targetFile)){
                        $updateSql = "UPDATE tb_employee SET pic_name = '$fileName' WHERE emp_id = $emp_id";
                        if($mysqli->query($updateSql)){
                            echo json_encode(['success' => true, 'message' => 'เพิ่มพนักงานและอัพโหลดรูปสำเร็จ']);
                        } else {
                            echo json_encode(['success' => false, 'message' => 'อัพเดตชื่อไฟล์ในฐานข้อมูลล้มเหลว']);
                        }
                    } else {
                        echo json_encode(['success' => false, 'message' => 'การอัพโหลดไฟล์ล้มเหลว']);
                    }
                } else {
                    echo json_encode(['success' => false, 'message' => 'โปรดอัพโหลดไฟล์รูปภาพ']);
                }
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'ไม่สามารถเพิ่มข้อมูลพนักงานได้']);
        }
    }

    if ($action == 'updateEmployee') {

        $emp_id = $_POST['emp_id'];
        $emp_name = $_POST['emp_name'];
        $emp_surname = $_POST['emp_surname'];
        $username = $_POST['user_name'];
        $password = $_POST['password'];
        $role_no = $_POST['role_no'];
        $status = $_POST['status'];

        // อัปเดตข้อมูลในฐานข้อมูล
        $updateSql = "
        UPDATE tb_employee 
        SET emp_name = '$emp_name', 
            emp_surname = '$emp_surname', 
            username = '$username', 
            password = '$password', 
            role_no = '$role_no', 
            emp_status = '$status', 
            modify_dt = '$modify_dt'
        WHERE emp_id = $emp_id
    ";

        if (mysqli_query($mysqli, $updateSql)) {
            // หากมีการส่งไฟล์มา ให้จัดการอัปโหลดไฟล์
            if (isset($_FILES['file'])) {
                $file = $_FILES['file'];
                $targetDir = "../../assets/uploads/member_pic/";
                $fileExtension = pathinfo($file["name"], PATHINFO_EXTENSION);
                $fileName = $emp_id .'_'.$create_dt_img. "." . $fileExtension;
                $targetFile = $targetDir . $fileName;
                $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

                // ตรวจสอบชนิดของไฟล์
                if (in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
                    // ตรวจสอบและลบไฟล์เก่า (ถ้ามี)
                    $oldPicQuery = "SELECT pic_name FROM tb_employee WHERE emp_id = $emp_id";
                    $result = $mysqli->query($oldPicQuery);
                    if ($result && $result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $oldFile = $targetDir . $row['pic_name'];
                        if (file_exists($oldFile)) {
                            unlink($oldFile); // ลบไฟล์เก่า
                        }
                    }

                    // อัปโหลดไฟล์ไปยังโฟลเดอร์เป้าหมาย
                    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
                        $updatePicSql = "UPDATE tb_employee SET pic_name = '$fileName' WHERE emp_id = $emp_id";
                        if ($mysqli->query($updatePicSql)) {
                            echo json_encode(['success' => true, 'message' => 'อัปเดตข้อมูลพนักงานและอัปโหลดรูปสำเร็จ']);
                        } else {
                            echo json_encode(['success' => false, 'message' => 'อัปเดตชื่อไฟล์ในฐานข้อมูลล้มเหลว']);
                        }
                    } else {
                        echo json_encode(['success' => false, 'message' => 'การอัปโหลดไฟล์ล้มเหลว']);
                    }
                } else {
                    echo json_encode(['success' => false, 'message' => 'โปรดอัพโหลดไฟล์รูปภาพเท่านั้น']);
                }
            } else {
                // หากไม่มีไฟล์ส่งมา
                echo json_encode(['success' => true, 'message' => 'อัปเดตข้อมูลพนักงานสำเร็จ']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'ไม่สามารถอัปเดตข้อมูลพนักงานได้']);
        }
    }

}
?>
