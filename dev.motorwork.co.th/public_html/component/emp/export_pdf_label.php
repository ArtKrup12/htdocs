<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../../config/connect.php' ;
ob_end_clean();
require('../../assets/plugins/fpdf/fpdf.php');
date_default_timezone_set('Asia/Bangkok');
$currentDate = date('d/m/Y');
$currentTime = date('H:i:s');
$pdf = new FPDF('P', 'mm', array(101.6, 101.6));
$pdf->SetMargins(5, 5, 5, 0);
$pdf->SetAutoPageBreak(false);
//echo "วันที่ปัจจุบัน: " . $currentDate;
$sql = "SELECT *,COUNT(tb_sale_order_detail.so_detail_no) as count_row,sum(tb_sale_order_detail.prod_qty) as sum_qty 
        FROM `tb_sale_order` 
        JOIN tb_sale_order_detail ON tb_sale_order_detail.so_id=tb_sale_order.so_id 
        JOIN tb_customer ON tb_customer.cust_id=tb_sale_order.cust_id 
         WHERE (tb_sale_order.so_id = '" . $_GET['so_id'] . "' ) GROUP BY tb_sale_order.so_id;";
$query = $mysqli->query($sql);

$sql2 = "SELECT *,COUNT(tb_sale_order_detail.so_detail_no) as count_row,sum(tb_sale_order_detail.prod_qty) as sum_qty 
        FROM `tb_sale_order` 
        JOIN tb_sale_order_detail ON tb_sale_order_detail.so_id=tb_sale_order.so_id 
        JOIN tb_customer ON tb_customer.cust_id=tb_sale_order.cust_id 
         WHERE (tb_sale_order.so_id = '" . $_GET['so_id'] . "' ) GROUP BY tb_sale_order.so_id;";
$query2 = $mysqli->query($sql2);

$row_show = mysqli_num_rows($query);


if ($row_show > 0) {
    $num = 0;
    while ($data = mysqli_fetch_assoc($query)) {
        $num = $num + 1;
        $pdf->AddPage();
        $pdf->AddFont('THSarabunNew', '', 'THSarabunNew.php');
        $pdf->AddFont('THSarabunNew', 'B', 'THSarabunNew_b.php');
        $text = 'ทดสอบการคอมเม้นหมายเหตุเพื่อดูว่าข้อความที่ยาวเกิน 50 ตัวอักษรจะถูกแบ่งเป็นบรรทัดใหม่อย่างถูกต้องหรือไม่';
        $pdf->SetFont('THSarabunNew', 'B', 22);
// section 1
        $pdf->SetX(7);
        $text = iconv('UTF-8', 'cp874', $data['cust_name']);
        $textWidth = $pdf->GetStringWidth($text);
        $cellWidth = 80;
        $x = ($cellWidth - $textWidth) / 2;
        $pdf->MultiCell(90, 7, $text, 0, 'C');
// section 1
// section 2 L
        $pdf->SetXY(5, 35);
        $pdf->SetFont('THSarabunNew', 'B', 20);
        $pdf->Cell(5, 5, iconv('utf-8', 'cp874', 'บริษัท มอเตอร์เวิร์ค จำกัด'), 0, 1, 'L');
// section 2 L
// section 2 R
        $pdf->SetXY(75, 32);
        $pdf->SetFont('THSarabunNew', '', 14);
        $pdf->Cell(0, 5, iconv('utf-8', 'cp874', $currentDate), 0, 1, 'L');
        $pdf->SetX(80);
        $pdf->Cell(0, 5, iconv('utf-8', 'cp874', $currentTime), 0, 1, 'L');
// section 2 R
// section 3
        $pdf->SetXY(5, 48);
        $pdf->SetFont('THSarabunNew', 'B', 14);
        $pdf->Cell(50, 3, iconv('utf-8', 'cp874', 'หมายเหตุ : '), 0, 0, 'L');
        $pdf->SetX(24);
        $pdf->SetFont('THSarabunNew', '', 14);
        $pdf->Cell(0, 3, iconv('utf-8', 'cp874', $data['remark']), 0, 1, 'L');
// section 3


// section 4 R
        $pdf->SetXY(5, 58);
        $pdf->SetFont('THSarabunNew', 'B', 14);
        $pdf->Cell(0, 6, iconv('utf-8', 'cp874', 'อะไหล่ทั้งหมด'), 0, 1, 'L');
        $pdf->SetX(5);
        $pdf->SetFont('THSarabunNew', '', 16);
        $pdf->Cell(0, 7, iconv('utf-8', 'cp874', '  - จำนวน '), 0, 0, 'L');
        $pdf->SetX(23);
        $pdf->SetFont('THSarabunNew', 'B', 18);
        $pdf->Cell(0, 7, iconv('utf-8', 'cp874', $data['count_row']), 0, 0, 'L');
        $pdf->SetFont('THSarabunNew', '', 16);
        $pdf->SetX(28);
        $pdf->Cell(0, 7, iconv('utf-8', 'cp874', ' รายการ'), 0, 1, 'L');

        $pdf->SetX(5);
        $pdf->SetFont('THSarabunNew', '', 16);
        $pdf->Cell(0, 7, iconv('utf-8', 'cp874', '  - จำนวน '), 0, 0, 'L');
        $pdf->SetX(23);
        $pdf->SetFont('THSarabunNew', 'B', 18);
        $pdf->Cell(0, 7, iconv('utf-8', 'cp874', $data['sum_qty']), 0, 0, 'L');
        $pdf->SetFont('THSarabunNew', '', 16);
        $pdf->SetX(28);
        $pdf->Cell(0, 7, iconv('utf-8', 'cp874', ' ชิ้น'), 0, 1, 'L');
// section 4 L
// section 4 R
        $pdf->SetXY(70, 58);
        $pdf->SetFont('THSarabunNew', '', 16);
        $pdf->Cell(0, 6, iconv('utf-8', 'cp874', 'เลขที่ลัง'), 0, 1, 'L');
        $pdf->SetX(71);
        $pdf->SetFont('THSarabunNew', 'B', 26);
        $pdf->Cell(0, 13, iconv('utf-8', 'cp874', $num . '/' .$data['count_row']), 0, 1, 'L');
// section 4 R

        // section 5
        $pdf->SetXY(5, -16);
        $pdf->SetFont('THSarabunNew', '', 20);
        $pdf->Cell(0, 6, iconv('utf-8', 'cp874', 'เลขที่ใบขาย : '), 0, 1, 'L');
        $pdf->SetXY(31, -16);
        $pdf->SetFont('THSarabunNew', 'B', 20);
        $pdf->Cell(0, 6, iconv('utf-8', 'cp874', $data['so_id']), 0, 1, 'L');
        $pdf->SetXY(5, -10);
        $pdf->Cell(0, 6, iconv('utf-8', 'cp874', 'Packing Number : PCxxxxxx'), 0, 1, 'L');
        // section 5
    }

    while ($data = mysqli_fetch_assoc($query2)) {
        $num = $num + 1;
        $pdf->AddPage();
        $pdf->AddFont('THSarabunNew', '', 'THSarabunNew.php');
        $pdf->AddFont('THSarabunNew', 'B', 'THSarabunNew_b.php');
        $text = 'ทดสอบการคอมเม้นหมายเหตุเพื่อดูว่าข้อความที่ยาวเกิน 50 ตัวอักษรจะถูกแบ่งเป็นบรรทัดใหม่อย่างถูกต้องหรือไม่';
        $pdf->SetFont('THSarabunNew', 'B', 22);
// section 1
        $pdf->SetX(7);
        $text = iconv('UTF-8', 'cp874', $data['cust_name']);
        $textWidth = $pdf->GetStringWidth($text);
        $cellWidth = 80;
        $x = ($cellWidth - $textWidth) / 2;
        $pdf->MultiCell(90, 7, $text, 0, 'C');
// section 1
// section 2 L
        $pdf->SetXY(5, 35);
        $pdf->SetFont('THSarabunNew', 'B', 20);
        $pdf->Cell(5, 5, iconv('utf-8', 'cp874', 'บริษัท มอเตอร์เวิร์ค จำกัด'), 0, 1, 'L');
// section 2 L
// section 2 R
        $pdf->SetXY(75, 32);
        $pdf->SetFont('THSarabunNew', '', 14);
        $pdf->Cell(0, 5, iconv('utf-8', 'cp874', $currentDate), 0, 1, 'L');
        $pdf->SetX(80);
        $pdf->Cell(0, 5, iconv('utf-8', 'cp874', $currentTime), 0, 1, 'L');
// section 2 R
// section 3
        $pdf->SetXY(5, 48);
        $pdf->SetFont('THSarabunNew', 'B', 14);
        $pdf->Cell(50, 3, iconv('utf-8', 'cp874', 'หมายเหตุ : '), 0, 0, 'L');
        $pdf->SetX(24);
        $pdf->SetFont('THSarabunNew', '', 14);
        $pdf->Cell(0, 3, iconv('utf-8', 'cp874', $data['remark']), 0, 1, 'L');
// section 3


// section 4 R
        $pdf->SetXY(5, 58);
        $pdf->SetFont('THSarabunNew', 'B', 14);
        $pdf->Cell(0, 6, iconv('utf-8', 'cp874', 'อะไหล่ทั้งหมด'), 0, 1, 'L');
        $pdf->SetX(5);
        $pdf->SetFont('THSarabunNew', '', 16);
        $pdf->Cell(0, 7, iconv('utf-8', 'cp874', '  - จำนวน '), 0, 0, 'L');
        $pdf->SetX(23);
        $pdf->SetFont('THSarabunNew', 'B', 18);
        $pdf->Cell(0, 7, iconv('utf-8', 'cp874', $data['count_row']), 0, 0, 'L');
        $pdf->SetFont('THSarabunNew', '', 16);
        $pdf->SetX(28);
        $pdf->Cell(0, 7, iconv('utf-8', 'cp874', ' รายการ'), 0, 1, 'L');

        $pdf->SetX(5);
        $pdf->SetFont('THSarabunNew', '', 16);
        $pdf->Cell(0, 7, iconv('utf-8', 'cp874', '  - จำนวน '), 0, 0, 'L');
        $pdf->SetX(23);
        $pdf->SetFont('THSarabunNew', 'B', 18);
        $pdf->Cell(0, 7, iconv('utf-8', 'cp874', $data['sum_qty']), 0, 0, 'L');
        $pdf->SetFont('THSarabunNew', '', 16);
        $pdf->SetX(28);
        $pdf->Cell(0, 7, iconv('utf-8', 'cp874', ' ชิ้น'), 0, 1, 'L');
// section 4 L
// section 4 R
        $pdf->SetXY(70, 58);
        $pdf->SetFont('THSarabunNew', '', 16);
        $pdf->Cell(0, 6, iconv('utf-8', 'cp874', 'เลขที่ลัง'), 0, 1, 'L');
        $pdf->SetX(71);
        $pdf->SetFont('THSarabunNew', 'B', 26);
        $pdf->Cell(0, 13, iconv('utf-8', 'cp874', $num . '/' .$data['count_row']), 0, 1, 'L');
// section 4 R

        // section 5
        $pdf->SetXY(5, -16);
        $pdf->SetFont('THSarabunNew', '', 20);
        $pdf->Cell(0, 6, iconv('utf-8', 'cp874', 'เลขที่ใบขาย : '), 0, 1, 'L');
        $pdf->SetXY(31, -16);
        $pdf->SetFont('THSarabunNew', 'B', 20);
        $pdf->Cell(0, 6, iconv('utf-8', 'cp874', $data['so_id']), 0, 1, 'L');
        $pdf->SetXY(5, -10);
        $pdf->Cell(0, 6, iconv('utf-8', 'cp874', 'Packing Number : PCxxxxxx'), 0, 1, 'L');
        // section 5
    }

}




$fileName = '671207-0021617_' . date('Ymd_His') . '.pdf';
$pdf->SetTitle($fileName);
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="' . $fileName . '"');
header('Cache-Control: private, max-age=0, must-revalidate');
header('Pragma: public');

// ส่งชื่อไฟล์เข้าไปใน Output()
$pdf->Output('I', $fileName);


