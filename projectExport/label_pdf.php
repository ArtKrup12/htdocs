<?php


include('../setting/connect_database.php');
//$List_id = $_GET['list_id'];
ob_end_clean();
require('plugins/fpdf/fpdf.php');

date_default_timezone_set('Asia/Bangkok');

$currentDate = date('d/m/Y');
$currentTime = date('H:i:s');
//echo "วันที่ปัจจุบัน: " . $currentDate;

$pdf = new FPDF();

//$count_all = $conn->query("SELECT count(*) as all_count  FROM dd_employee WHERE emp_status = '1'");
//$data_count = mysqli_fetch_object($count_all);

$pdf = new FPDF('P', 'mm', array(101.6, 101.6));
for ($i=1;$i<4;$i++) {
    $pdf->AddPage();
    $pdf->AddFont('THSarabunNew', '', 'THSarabunNew.php');
    $pdf->AddFont('THSarabunNew', 'B', 'THSarabunNew_b.php');
    $text = 'ทดสอบการคอมเม้นหมายเหตุเพื่อดูว่าข้อความที่ยาวเกิน 50 ตัวอักษรจะถูกแบ่งเป็นบรรทัดใหม่อย่างถูกต้องหรือไม่';
//$pdf->SetFont('THSarabunNew', 'B', 10);
    $pdf->SetFont('THSarabunNew', 'B', 32);
    $pdf->SetXY(5, 5);
    $pdf->Cell(0, 5, iconv('utf-8', 'cp874', 'customer1'), 0, 1, 'L');
    $pdf->SetX(5);
    $pdf->SetFont('THSarabunNew', '', 18);
    $pdf->Cell(0, 10, iconv('utf-8', 'cp874', 'หมายเหตุ'), 0, 1, 'L');
    $pdf->SetX(8);
    $pdf->SetFont('THSarabunNew', '', 16);
    $pdf->Cell(0, 5, iconv('utf-8', 'cp874', 'ทดสอบการคอมเม้นหมายเหตุ'), 0, 1, 'L');

    $pdf->SetXY(0, 6);
    $pdf->SetFont('THSarabunNew', '', 18);
    $pdf->Cell(0, 5, iconv('utf-8', 'cp874', 'บริษัท มอเตอร์เวิร์ค จำกัด'), 0, 1, 'R');
    $pdf->Cell(0, 5, iconv('utf-8', 'cp874', $currentDate), 0, 1, 'R');
    $pdf->Cell(0, 5, iconv('utf-8', 'cp874', $currentTime), 0, 1, 'R');

    $pdf->SetXY(5, 25);
    $pdf->SetFont('THSarabunNew', '', 18);
    $pdf->Cell(0, 8, iconv('utf-8', 'cp874', 'จำนวนรายการ 8 รายการ'), 0, 1, 'L');
    $pdf->SetX(5);
    $pdf->Cell(0, 8, iconv('utf-8', 'cp874', 'จำนวนชิ้น 16 ชิ้น'), 0, 1, 'L');
    $pdf->SetX(5);
    $pdf->Cell(0, 8, iconv('utf-8', 'cp874', 'เลขที่ใบขาย 67WHSL/0009427'), 0, 1, 'L');
    $pdf->SetX(5);
    $pdf->Cell(0, 8, iconv('utf-8', 'cp874', 'Packing Number 2024001'), 0, 1, 'L');

    $pdf->SetXY(5, 50);
    $pdf->Cell(0, 6, iconv('utf-8', 'cp874', 'เลขที่ลัง'), 0, 1, 'R');
    $pdf->Cell(0, 6, iconv('utf-8', 'cp874', $i.'/4'), 0, 1, 'R');
}
$pdf->Output();


