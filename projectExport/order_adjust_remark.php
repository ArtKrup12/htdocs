<?php
//session_start();
//include"chksession.php";//ตรวจสอบเวลาในการเข้าระบบ ให้ล็อกเอาท์อัตโนมัติหากไม่มีการใช้งานระบบ
include"config.php";
include"datethai.php";

//$statusQ=$_GET['statusQ'];
$alert=$_GET['alert'];
$isSuccess=$_GET['isSuccess'];

if ($isSuccess) {
    // กรณี success
    $alertTitle = "แจ้งเตือน!";
    $alertMessage = "<span style='font-size: 16px;'>".$alert."</span>";
    $alertIcon = "warning"; // ใช้ไอคอน success
    $redirectUrl = ""; // ไม่ต้องการ redirect ในกรณี success
} else {
    // กรณี error
    $alertTitle = "ไม่สำเร็จ!";
    $alertMessage = "<span style='font-size: 16px;'>".$alert."</span>";
    $alertIcon = "error"; // ใช้ไอคอน error
}

if($_GET['order_id']){
  $order_id=$_GET['order_id'];
}else{
  $order_id=$_POST['order_id'];
}

$member_type=$_SESSION['member_type'];
$member_id=$_SESSION['Member_IdLogin'];
$assign_id=$_GET['assign_id'];
$order_detail_id=$_GET['order_detail_id'];





    				 
		    $sql1="SELECT * FROM  order_picking_detail  WHERE  order_id='$order_id' AND order_detail_id='$order_detail_id' ";
				$query1=$mysqli->query($sql1); 
				$order=$query1->fetch_array();	
        $product_code=$order["product_code"]; 			
        $product_name=$order["product_name"]; 			
				$product_qty=$order["product_qty"]; 
        $product_count=$order["product_count"]; 

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ระบบนับสินค้า - มอเตอร์เวิร์ค | <? echo $_SESSION['MenuType']?></title>
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
  <!-- Date Picker -->
  <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

	<!-- Auto Complete -->
	  <link type="text/css" rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/pepper-grinder/jquery-ui.css" />
	    
		<link rel="stylesheet" type="text/css" href="stock/css/jquery.dataTables.css">
		<script type="text/javascript" language="javascript" src="stock/js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="stock/js/jquery.dataTables.js"></script>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* เว้นวรรคระหว่างปุ่ม */
        .swal2-confirm {
            margin-right: 10px; /* กำหนดระยะห่างด้านขวาของปุ่ม confirm */
        }

        /* กำหนดขนาดกล่อง SweetAlert */
        .swal2-popup {
            width: 500px !important; /* ขนาดความกว้าง */
            height: auto !important; /* ขนาดความสูง (อัตโนมัติตามเนื้อหา) */
            max-width: 90% !important; /* จำกัดความกว้างสูงสุด */
        }
    </style>

 
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
    $customer='active';	
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
      <h1> ข้อมูลหยิบสินค้า <small></small></h1>
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
            <ul class="nav nav-tabs">
              		<li class="active" style="border-color:#9b111e"><a href="#general" data-toggle="tab">ระบุหมายเหตุ</a></li>
              		
              
			  					
            </ul>
       
            <div class="tab-content">
              <div class="active tab-pane" id="general">

				<div class="form-group col-md-12">
				<?php 
							/*  if($statusQ=='yes'){
                                print"";
								   print"<h3><div id=\"alert\"  class=\"alert alert-success\" role=\"alert\"> <span class=\"glyphicon glyphicon-ok-sign\" aria-hidden=\"\"></span> <a href=\"#\" 
								   class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
									$alert</div></h3>";
							  }elseif($statusQ=='no'){
                                //print "<div id=\"alert\" class=\"alert alert-danger\"> 
                                //        $alert
                                //        </div>";
								   print"<h3> <div id=\"alert\" class=\"alert alert-danger\" role=\"alert\"> <span class=\"glyphicon glyphicon-remove-sign\" aria-hidden=\"\"></span> <a href=\"#\" 
								   class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>$alert
									</div>";
                                }elseif($statusQ=='warn'){
                                    
                                       print" <h3><div id=\"alert\" class=\"alert alert-warning\" role=\"alert\"><span class=\"glyphicon glyphicon-info-sign\" aria-hidden=\"\"></span> <a href=\"#\" 
                                       class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>$alert
                                        </div></h3>";
                                  }else  print"<h4></h4>";*/
							  
				?>  
				</div>

            <!-- form start -->

            <form role="form" method="post" action="order_adjust_remark_add.php" id="barcodeForm" >
              <div class="box-body">
               

				<div class="form-group col-md-4 col-xs-12">
					<label for="product name">รหัสสินค้า</label>
					<input type="text" class="form-control" id="product_code"  name="product_code" 
					placeholder="รหัสสินค้า" value="<?php echo $product_code;?>" readonly>
                    <input type="hidden" name="barcode_prev" value="<?php echo $barcode_prev?>">
				</div>	
                
					
				<div class="form-group col-md-8 col-xs-12">
					<label for="product name">ชื่อสินค้า</label>
					<input type="text" class="form-control" id="product_name"  name="product_name" 
					placeholder="ชื่อสินค้า" value="<?php echo $product_name;?>" readonly>
				</div>	
	
				<div class="form-group col-md-3 col-xs-6">
					<label for="stock insert">จำนวนในใบหยิบ</label>
					<input type="text" class="form-control" id="product_qty"  name="product_qty" 
					placeholder="จำนวนในใบหยิบ" value="<?php echo $product_qty;?>" readonly >
					
				</div>
                <div class="form-group col-md-3 col-xs-6">
					<label for="stock insert">จำนวนที่นับได้</label>
					<input type="number" class="form-control" id="product_count"  name="product_count" 
					placeholder="0"  style="color:blue" value="<?php echo $product_count;?>" readonly autocomplete="off" >
                </div>

                <div class="form-group col-md-3 col-xs-6">
					<label for="stock insert">จำนวนที่ขาด</label>
					<input type="number" class="form-control" id="product_count"  name="product_count" 
					placeholder="0"  style="color:red" value="<?php echo ($product_qty-$product_count);?>" readonly autocomplete="off" >
				</div>	
                <div class="form-group col-md-3 col-xs-6">
					<label for="stock insert">ประเภทหมายเหตุ</label>
					<select class="form-control"  name="order_detail_remark_type" autofocus required oninvalid="this.setCustomValidity('กรุณาเลือกประเภทหมายเหตุ')"
          oninput="setCustomValidity('')">
                        <option value=""></option>
                        <?php
                            $sql11="SELECT * FROM  remark_type ORDER BY  remark_type_name";
                            $query11=$mysqli->query($sql11); // ทำการ query คำสั่ง sql 
						    $find11=$query11->num_rows;  // นับจำนวนถวที่แสดง ทั้งหมด
                            if($find11>0){
                                while($type=$query11->fetch_array()){ // วนลูปแสดงข้อมูล	
                                    $remark_type_id=$type['remark_type_id'];	
                                    $remark_type_name=$type['remark_type_name'];	
						?>
                        <option value="<?php echo $remark_type_id?>"><?php echo $remark_type_name?></option>
                        <?php }} ?>
                    </select>
				</div>	
                <div class="form-group col-md-12 col-xs-12">
					<label for="stock insert">หมายเหตุ</label>
					<textarea class="form-control" name="order_detail_remark"  rows="3" required oninvalid="this.setCustomValidity('กรุณาระบุหมายเหตุ')"
          oninput="setCustomValidity('')"></textarea>
				</div>		
				
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
              <button type="submit" class="btn btn-primary" style="background-color:#9b111e;border-color: #961011" onclick="handleRedirect()" <?php if($product_code==''){ echo "disabled"; }else{ echo "";}?>><i class="fa fa-save"></i> บันทึก</button>
                <a href="order_scanner.php?order_id=<?php echo $order_id ?>&product_code=<?php echo $product_code?>&assign_id=<?php echo $assign_id?>" class="btn btn-warning" style="background-color:#3A3B3C;border-color:#3A3B3C"><i class="fa fa-undo"></i> ย้อนกลับ</a>

				<input type="hidden" name="order_id" value="<?php echo $order_id;?>">
				<input type="hidden" name="assign_id" value="<?php echo $assign_id;?>">
				<input type="hidden" name="order_detail_id" value="<?php echo $order_detail_id;?>">
				<input type="hidden" name="frompage" value="order_scanner.php">
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
  <!-- /.content-wrapper -->
  
  <footer class="main-footer">
   <?php include('footer.php'); ?>
  </footer>

 
  <script>
        // รับค่าจาก PHP และนำไปใช้ใน SweetAlert
        let alertTitle = "<?php echo $alertTitle; ?>";
        let alertMessage = "<?php echo $alertMessage; ?>";
        let alertIcon = "<?php echo $alertIcon; ?>";
        let redirectUrl = "<?php echo $redirectUrl; ?>"; // URL สำหรับ redirect

        // แสดง SweetAlert ด้วยค่าจาก PHP และใช้สไตล์ Bootstrap
        Swal.fire({
            title: alertTitle,
            html: alertMessage, // ใช้ 'html' แทน 'text' 
            icon: alertIcon,
            confirmButtonText: 'ระบุหมายเหตุ',
            customClass: {
                confirmButton: 'btn btn-danger', // ใช้สไตล์ปุ่มของ Bootstrap
            },
            buttonsStyling: false // ปิดการใช้งานสไตล์ปุ่มของ SweetAlert2 เพื่อใช้ Bootstrap แทน
        });
    </script>

    <!-- Bootstrap JavaScript (สำหรับฟังก์ชันเพิ่มเติมของ Bootstrap) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>


<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- Select2 -->
<script src="plugins/select2/select2.full.min.js"></script>
<!-- InputMask -->
<script src="plugins/input-mask/jquery.inputmask.js"></script>
<script src="plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- date-range-picker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- bootstrap color picker -->
<script src="plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
<!-- bootstrap time picker -->
<script src="plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- SlimScroll 1.3.0 -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- iCheck 1.0.1 -->
<script src="plugins/iCheck/icheck.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->

<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>


</body>
</html>
