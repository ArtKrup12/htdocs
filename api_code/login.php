<?php
// รวมไฟล์เชื่อมต่อฐานข้อมูล
require_once 'config.php';

// เพิ่มหัวข้อ CORS
header('Access-Control-Allow-Origin: *'); // สามารถระบุเป็น URL ของ frontend ที่ต้องการให้อนุญาต เช่น 'http://localhost:8080'
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// ถ้าคำขอเป็น OPTIONS ให้คืนค่าทันที (กรณีที่เบราว์เซอร์ทำการ pre-flight request)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// กำหนดประเภทการตอบกลับเป็น JSON
header('Content-Type: application/json');

// รับข้อมูลจาก POST request
$data = json_decode(file_get_contents("php://input"));

// รับค่า username และ password
$userName = isset($data->userName) ? $data->userName : '';
$passWord = isset($data->passWord) ? $data->passWord : '';

// ตรวจสอบว่า userName และ passWord ถูกส่งมาหรือไม่
if (empty($userName) || empty($passWord)) {
    echo json_encode(["message" => "กรุณากรอกชื่อผู้ใช้และรหัสผ่าน", "status" => false]);
    exit;
}

// เตรียมคำสั่ง SQL สำหรับค้นหาผู้ใช้ในฐานข้อมูล
$sql = "SELECT * FROM employee WHERE user_name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $userName); // ใช้ "s" สำหรับ string
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    if ($passWord == $user['pass_word']) {
        echo json_encode(["message" => "เข้าสู่ระบบสำเร็จ", "status" => true, "user" => $user]);
    } else {
        echo json_encode(["message" => "รหัสผ่านผิด", "status" => false]);
    }

} else {
    // ถ้าไม่พบผู้ใช้
    echo json_encode(["message" => "ชื่อผู้ใช้ไม่ถูกต้อง", "status" => false]);
}

// ปิดการเชื่อมต่อฐานข้อมูล
$stmt->close();
$conn->close();
?>
