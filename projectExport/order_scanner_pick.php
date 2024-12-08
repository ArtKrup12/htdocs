<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

//session_start();
//include"chksession.php";
//ตรวจสอบเวลาในการเข้าระบบ ให้ล็อกเอาท์อัตโนมัติหากไม่มีการใช้งานระบบ

include "config.php";
include "datethai.php";
if ($_GET['sale_id']) {
    $sale_id = $_GET['sale_id'];
} else {
    $sale_id = $_POST['sale_id'];
}

if ($_GET['assign_id']) {
    $assign_id = $_GET['assign_id'];
} else {
    $assign_id = $_POST['assign_id'];
}

$statusQ = $_GET['statusQ'];
$alert = $_GET['alert'];

$member_type = $_SESSION['member_type'];
$member_id = $_SESSION['Member_IdLogin'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $barcode = trim($_POST['barcode']);
    $barcode_prev = $_POST['barcode_prev'];
    //$order_id = $_POST['order_id'];

    if (!empty($barcode)) {
        /*$stmt = $pdo->prepare("SELECT * FROM ชื่อตาราง WHERE barcode = :barcode");
        $stmt->bindParam(':barcode', $barcode, PDO::PARAM_STR);
        $stmt->execute();*/


        $barcode2 = $barcode;


        $sql11 = "SELECT * FROM  v_sale_detail_control  WHERE  (sale_id='$sale_id') and (flag_count<>'N' AND flag_count <> 'Y') and ((product_code = '$barcode') OR  (REPLACE(product_code, '-', '') = '$barcode')) ORDER BY product_location LIMIT 1;";
        $query11 = $mysqli->query($sql11);
        $row11 = $query11->num_rows;

        if ($row11 > 0) {

            $result = $query11->fetch_array();

            $status_pick = $result['flag_count'];
            if (!isset($status_pick)) {
                //if (isset($status_pick)) {
                //echo "ข้อมูลสินค้า:<br>";

                $statusQ = 'warn';
                $alert = "อะไหล่ชิ้นนี้สแกนไปแล้ว";
            } else {
                $sale_detail_id = $result['sale_detail_id'];
                $product_id = $result['product_id'];
                $product_code = $result['product_code'];
                $product_name = $result['product_name'];
                $product_qty = $result['product_qty'];
                $product_location = $result['product_location'];
                $sql_count = "SELECT * FROM flag_detail_count WHERE sale_detail_id='$sale_detail_id'";
                $query_count = $mysqli->query($sql_count);

                $row_count = $query_count->num_rows;

                if ($row_count > 0) {//ถ้ามีข้อมูล
                    $result_count = $query_count->fetch_array();

                    //$product_count_show=$result_count['product_count'] + 1;
                    $product_count = $result_count['product_count'] + 1;

                    if ($product_count > $product_qty) {
                        $product_count = $product_qty;
                        $statusQ = 'no';
                        $alert = "ไม่สามารถสแกนเกินจำนวนในใบขายได้";

                    } else {

                        $sqlUp = $mysqli->query("UPDATE flag_detail_count SET product_count= product_count+1 WHERE sale_detail_id='$sale_detail_id' AND assign_id='$assign_id' LIMIT 1");

                        $sale_id = $_GET['sale_id'];
                        $sale_detail_id = $_GET['sale_detail_id'];
                        $assign_id = $_GET['assign_id'];
//                        $sqlUpDateLine = $mysqli->query("UPDATE draft_line SET num = product_count+1 WHERE sale_id = ".$_GET['sale_id']." AND sale_detail_id='".$_GET['sale_detail_id']."' AND assign_id='".$_GET['assign_id']."'");
                        $sqlUpDateLine = $mysqli->query(" UPDATE draft_line SET num = num + 1 WHERE draft_head_id = (SELECT draft_head_id FROM draft_head WHERE sale_id = '$sale_id' AND sale_detail_id = '$sale_detail_id' AND assign_id = '$assign_id' LIMIT 1)");
//                        if(){
//                        }


                    }
                } else {
                    $sqlIns = $mysqli->query("INSERT INTO flag_detail_count(sale_detail_id,assign_id,product_count) VALUES('$sale_detail_id','$assign_id','1')");
                    $product_count = 1;
                    $sqlInsDraftHead = $mysqli->query("INSERT INTO draft_head(sale_id,assign_id,sale_detail_id) VALUES(".$_GET['sale_id'].",".$_GET['assign_id'].",".$_GET['sale_detail_id'].")");
                    $sqlSelectTop = $mysqli->query("SELECT * FROM draft_head ORDER BY draft_head_id DESC LIMIT 1");
                    $latestRecord = $sqlSelectTop->fetch_assoc();
                    $sqlInsDraftLine = $mysqli->query("INSERT INTO draft_line(draft_head_id,product_id,num) VALUES(".$latestRecord['draft_head_id'].",".$product_id.",'1')");

                }
                if ($barcode <> $barcode_prev) {
                    //$product_count=1;
                    //$product_count_show=1;
                    $barcode_prev = $barcode;
                }
            }

        } else {
            $statusQ = 'no';
            $alert = "ไม่พบข้อมูลบาร์โค้ดที่คุณค้นหา";

            if ($barcode <> $barcode_prev) {

                $product_count = 0;
                //$product_count_show=0;
                $barcode_prev = $barcode;

            }
        }
    } else {
        $statusQ = 'warn';
        $alert = "กรุณากรอกหรือสแกนบาร์โค้ด";
        //echo "กรุณากรอกหรือสแกนบาร์โค้ด";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ระบบนับสินค้า - มอเตอร์เวิร์ค | <? echo $_SESSION['MenuType'] ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/iCheck/flat/blue.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="plugins/morris/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<style>

</style>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var barcodeInput = document.getElementById('barcode');
            var lastInputTime = 0; // เริ่มต้นค่าเป็น 0
            var inputIntervalThreshold = 30; // เวลาคั่นระหว่างการกดแต่ละครั้ง (ms)
            var isPasted = false;
            var minBarcodeLength = 6; // กำหนดความยาวขั้นต่ำของบาร์โค้ดที่ต้องการ

            barcodeInput.addEventListener('input', function () {
                var currentTime = new Date().getTime();
                var timeDiff = currentTime - lastInputTime;

                if (lastInputTime === 0 || (!isPasted && timeDiff < inputIntervalThreshold)) {
                    // ตรวจสอบว่าบาร์โค้ดมีความยาวขั้นต่ำตามที่กำหนด
                    if (barcodeInput.value.length >= minBarcodeLength) {
                        console.log()
                        document.getElementById('barcodeForm').submit();
                    }
                }

                lastInputTime = currentTime;
                isPasted = false; // รีเซ็ตค่านี้หลังจากมีการเปลี่ยนแปลง input
                // triggerAddDraftLineFunction();
            });

            barcodeInput.addEventListener('paste', function () {
                isPasted = true; // ตรวจจับการวางข้อมูล
            });

            // กดปุ่ม submit เมื่อผู้ใช้ป้อนบาร์โค้ดด้วยตนเอง
            document.getElementById('manualSubmit').addEventListener('click', function () {
                document.getElementById('barcodeForm').action = '/order_scanner_pick.php';
                document.getElementById('barcodeForm').submit();

            });

            // function triggerAddDraftLineFunction() {
            //         let product_code = document.getElementById('product_code').value;
            //         let product_qty = document.getElementById('product_qty').value;
            //         let product_count = document.getElementById('product_count').value;
            //         alert("Product Code: " + product_code + "\nProduct Quantity: " + product_qty + "\nProduct Count: " + product_count);
            //
            // }

        });


        function handleRedirect() {
            // เปลี่ยน action ของฟอร์มเพื่อ redirect ไปหน้าอื่น
            document.getElementById('barcodeForm').action = '/order_adjust_add_pick.php';
            document.getElementById('barcodeForm').submit();
        }

    </script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        <?php include('header.php'); ?>
    </header>

    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <?php
        //$m='active';
        $customer = 'active';
        include('menu.php');
        ?>
        <!-- /.sidebar -->
    </aside>

    <style>


        .form-control:focus {
            border-color: #9b111e;
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
        }
    </style>

    <?php
    // PHP ส่วนนี้ยังคงเดิม

    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> ข้อมูลแพ็คสินค้า <small></small></h1>
            <ol class="breadcrumb">
                <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active"><a href="order_detail.php">PICKING/PACKING</a></li>
            </ol>
        </section>
        <!-- Content Header (Page header) -->
        <section class="content">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs" >
                            <li class="active" style="border-color:#9b111e"><a href="#general" data-toggle="tab">สแกนสินค้า</a>
                            </li>
                            <li class="pull-right" >
                                <input type="hidden" id="sale_id" value="<?php echo $_GET['sale_id'] ;?>">
                                <input type="hidden" id="assign_id" value="<?php echo $_GET['assign_id'] ;?>">
                                <input type="hidden" id="sale_detail_id" value="<?php echo $_GET['sale_detail_id'] ;?>">
                                <div id="show_pagination" >
                                </div>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="active tab-pane" id="general">

                                <div class="form-group col-md-12">
                                    <?php
                                    if ($statusQ == 'yes') {
                                        print"";
                                        print"<h3><div id=\"alert\"  class=\"alert alert-success\" role=\"alert\"> <span class=\"glyphicon glyphicon-ok-sign\" aria-hidden=\"\"></span> <a href=\"#\" 
								   class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
									$alert</div></h3>";
                                    } elseif ($statusQ == 'no') {
                                        //print "<div id=\"alert\" class=\"alert alert-danger\">
                                        //        $alert
                                        //        </div>";
                                        print"<h3> <div id=\"alert\" class=\"alert alert-danger\" role=\"alert\"> <span class=\"glyphicon glyphicon-remove-sign\" aria-hidden=\"\"></span> <a href=\"#\" 
								   class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>$alert
									</div>";
                                    } elseif ($statusQ == 'warn') {

                                        print" <h3><div id=\"alert\" class=\"alert alert-warning\" role=\"alert\"><span class=\"glyphicon glyphicon-info-sign\" aria-hidden=\"\"></span> <a href=\"#\" 
                                       class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>$alert
                                        </div></h3>";
                                    } else  print"<h4></h4>";

                                    ?>
                                </div>
                                <script type="text/javascript">
                                    setTimeout(function () {

                                        // Closing the alert
                                        $('#alert').alert('close');
                                    }, 7000);
                                </script>

                                <!-- form start -->

                                <form role="form" method="post" action="" id="barcodeForm">
                                    <div class="box-body">
<!--                                        <input type="hidden" id="d_head" name="d_head" value="--><?php //echo $row2['draft_head_id']; ?><!--">-->
                                        <div class="form-group col-md-12 col-xs-12">
                                            <label for="product name">สแกนบาร์โค้ด</label>
                                            <div class="input-group">
                                                <input type="text" id="barcode" name="barcode"
                                                       class="form-control addDraftLine"
                                                       placeholder="สแกน/ป้อนบาร์โค้ด" aria-label="Search"
                                                       aria-describedby="button-search" autofocus autocomplete="off">
                                                <div class="input-group-btn">
                                                    <button class="btn btn-primary"
                                                            style="background-color: #9b111e;border-color: #961011"
                                                            type="button" id="manualSubmit"><i class="fa fa-search"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4 col-xs-12">
                                            <label for="product name">รหัสสินค้า</label>
                                            <input type="text" class="form-control" id="product_code"
                                                   name="product_code"
                                                   placeholder="รหัสสินค้า" value="<?php echo $product_code; ?>"
                                                   readonly>
                                            <input type="hidden" name="barcode_prev"
                                                   value="<?php echo $barcode_prev ?>">
                                        </div>


                                        <div class="form-group col-md-8 col-xs-12">
                                            <label for="product name">ชื่อสินค้า</label>
                                            <input type="text" class="form-control" id="product_name"
                                                   name="product_name"
                                                   placeholder="ชื่อสินค้า" value="<?php echo $product_name; ?>"
                                                   readonly>
                                        </div>
                                        <div class="form-group col-md-4 col-xs-12">
                                            <label for="product location">ตำแหน่ง</label>
                                            <input type="text" class="form-control" id="place" name="place"
                                                   placeholder="ตำแหน่ง" value="<?php echo $product_location; ?>"
                                                   readonly>
                                        </div>

                                        <div class="form-group col-md-4 col-xs-6">
                                            <label for="stock insert">จำนวนในใบหยิบ</label>
                                            <input type="text" class="form-control  input-lg" id="product_qty"
                                                   name="product_qty"
                                                   placeholder="0" style="font-size:30px"
                                                   value="<?php echo $product_qty; ?>" readonly>

                                        </div>
                                        <div class="form-group col-md-4 col-xs-6">
                                            <label for="stock insert">จำนวนที่นับได้</label>
                                            <input type="number" class="form-control  input-lg" id="product_count"
                                                   name="product_count"
                                                   placeholder="0" style="color:blue;font-size:30px"
                                                   value="<?php echo $product_count; ?>" required autocomplete="off">
                                            <input type="hidden" name="product_count_old"
                                                   value="<?php echo $product_count; ?>">
                                        </div>
                                        <div class="form-group col-md-4 col-xs-6">
                                            <label for="stock insert">จำนวนที่แพ็คแล้ว</label>
                                            <input type="number" class="form-control  input-lg" id="product_count"
                                                   name="product_count"
                                                   placeholder="0" style="color:blue;font-size:30px"
                                                   value="<?php echo $product_count; ?>" required autocomplete="off" disabled>
                                            <input type="hidden" name="product_count_old"
                                                   value="<?php echo $product_count; ?>">
                                        </div>
                                        <div class="form-group col-md-4 col-xs-6" style="margin-top: 30px;">
                                            <button type="button"
                                                    id="<?php echo $_GET['sale_id'] . '-' . $_GET['assign_id'] . '-' . $_GET['sale_detail_id']; ?>"
                                                    class="btn btn-warning newCarton"><i class="fa fa-plus"></i>
                                                ขึ้นลังใหม่
                                            </button>
                                        </div>
                                        <!--
                                         <div class="form-group col-md-3">
                                            <label for="member_email">วันเกิด</label>
                                            <i class="fa fa-calendar"></i>
                                            <input type="text" class="form-control pull-right" id="datepicker">
                                        </div>
                                        -->

                                    </div>
                                    <!-- /.box-body -->

                                    <div class="box-footer" style="">
                                        <button type="submit" class="btn btn-primary"
                                                style="background-color:#9b111e;border-color: #961011"
                                                onclick="handleRedirect()" <?php if ($product_code == '') {
                                            echo "disabled";
                                        } else {
                                            echo "";
                                        } ?>><i class="fa fa-save"></i> บันทึก
                                        </button>
<!--                                        <button type="button"-->
<!--                                                id=""-->
<!--                                                onclick="printPDF()"-->
<!--                                                class="btn btn-danger"><i class="fa fa-plus"></i>-->
<!--                                            test print-->
<!--                                        </button>-->

                                        <a href="order_detail.php?sale_id=<?php echo $sale_id ?>&assign_id=<?php echo $assign_id ?>"
                                           class="btn btn-warning"
                                           style="background-color:#3A3B3C;border-color:#3A3B3C"><i
                                                    class="fa fa-undo"></i> ย้อนกลับ</a>

                                        <input type="hidden" name="sale_id" value="<?php echo $sale_id; ?>">
                                        <input type="hidden" name="sale_detail_id"
                                               value="<?php echo $sale_detail_id; ?>">
                                        <input type="hidden" name="assign_id" value="<?php echo $assign_id; ?>">
                                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                        <input type="hidden" name="frompage" value="order_scanner_pick.php">
                                    </div>
                                </form>
                                <!-- /form start -->
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div>
                    <!-- /.nav-tabs-custom -->
                </div>
                <!--/.col left column -->
            </div>
        </section>


        <!------------------------------------------------ /.content ------------------------------------------------------->

    </div>

    <div id="pdfPopup" class="alert alert-info alert-dismissible fade" role="alert" style="display: none;z-index: 9999;">
        <h5 class="alert-heading">แสดง PDF</h5>
<!--        <iframe id="pdfIframe" src="" width="80%" height="300px" style="border: none;"></iframe>-->
        <button type="button" class="close" onclick="closePDFPopup()" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
        <?php include('footer.php'); ?>
    </footer>

    <!-- jQuery 2.2.3 -->
    <script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>

    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <!-- Page script -->


</body>
</html>
<script>
    function printPDF() {
        // เปิดไฟล์ PDF ในแท็บใหม่และเรียกคำสั่งพิมพ์
        const pdfWindow = window.open('label_pdf.php', '_blank');
        pdfWindow.onload = function() {
            pdfWindow.print();
        };
    }
    $(document).ready(function () {


        let sale_detail_id = $('#sale_detail_id').val()
        let sale_id = $('#sale_id').val()
        let assign_id = $('#assign_id').val()

        $.ajax({
            url: `data_order_scanner_pick/pagination.php`,
            method: 'POST',
            data: {carton:1,sale_detail_id,sale_id,assign_id},
            success: function (data) {
                $('#show_pagination').html(data)
            }
        });

        $('.newCarton').click(function () {
            let data_id = $(this).attr('id')
            $.ajax({
                url: `data_order_scanner_pick/newCarton.php`,
                method: 'POST',
                data: {data_id},
                success: function (data) {
                    // $('#show-pages').html(data)
                }
            });
        })
    })
</script>
