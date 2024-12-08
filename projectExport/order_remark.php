<?php
//session_start();
//include"chksession.php";//ตรวจสอบเวลาในการเข้าระบบ ให้ล็อกเอาท์อัตโนมัติหากไม่มีการใช้งานระบบ
include"config.php";
include"datethai.php";



//$statusQ=$_GET['statusQ'];
$alert=$_GET['alert'];
$isSuccess=$_GET['isSuccess'];

/*if ($isSuccess) {
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
}*/


$member_type=$_SESSION['member_type'];
$member_id=$_SESSION['Member_IdLogin'];




    if($_GET['sale_id']){
        $sale_id=$_GET['sale_id'];
    }else{
        $sale_id=$_POST['sale_id'];
    }

    if($_GET['assign_id']){
      $assign_id=$_GET['assign_id'];
    }else{
        $assign_id=$_POST['assign_id'];
    }


    $sql1="SELECT * FROM  v_sale_latest  WHERE  sale_id='$sale_id'  ";
    $query1=$mysqli->query($sql1); 
    $sale=$query1->fetch_array();	

                $sale_code=$sale["sale_code"]; 			
                $sale_date=$sale["sale_date"]; 			
                $customer_code=$sale["customer_code"]; 			
				        $customer_name=$sale["customer_name"];  

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
      <h1> ระบุหมายเหตุ <small></small></h1>
      <ol class="breadcrumb">
        <li><a href="index_emp.php"><i class="fa fa-dashboard"></i> Home</a></li>
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
              		<li class="active" style="border-color:#9b111e"><a href="#general" data-toggle="tab">ข้อมูลใบขาย</a></li>
            </ul>
       
            <div class="tab-content">
              <div class="active tab-pane" id="general">

            <!-- form start -->

            <form role="form" method="post" action="order_remark_add.php" id="barcodeForm" >
              <div class="box-body">
			  
                <!--<div class="form-group col-md-6">
					<label for="quantity" >เลขที่ใบหยิบ</label>
					<input type="text" class="form-control" id="order_code" name="order_code" 
					placeholder="order_code" value="<?php echo $order_code;?>" readonly>
				</div>

                <div class="form-group col-md-6">
					<label for="quantity" >ชื่อลูกค้า</label>
					<input type="text" class="form-control" id="customer_name" name="customer_name" 
					placeholder="customer_name" value="<?php echo $customer_name;?>" readonly>
				</div>-->
				
                <!--<div class="form-group col-md-12">
					<label for="barcode" >สแกนบาร์โค้ด</label>
					<input type="text" class="form-control" id="barcode" class="barcode"  name="barcode" placeholder="สแกนบาร์โค้ด" value="" autofocus>
                </div>-->
        <div class="form-group col-md-4 col-xs-12">
					<label for="order date">วันที่ขาย</label>
					<input type="text" class="form-control" id="sale_date"  name="sale_date" placeholder="วันที่ขาย" value="<?php echo $sale_date;?>" readonly>
				</div>	

				<div class="form-group col-md-8 col-xs-12">
					<label for="order code">เลขที่ใบขาย</label>
					<input type="text" class="form-control" id="sale_code"  name="sale_code" 
					placeholder="เลขที่ใบหยิบ" value="<?php echo $sale_code;?>" readonly>
				</div>
        <div class="form-group col-md-4 col-xs-12">
					<label for="customer_code">รหัสลูกค้า</label>
					<input type="text" class="form-control" id="customer_code"  name="customer_code" placeholder="รหัสลูกค้า" value="<?php echo $customer_code;?>" readonly>
				</div>	

					
				<div class="form-group col-md-8 col-xs-12">
					<label for="customer name">ลูกค้า</label>
					<input type="text" class="form-control" id="customer_name"  name="customer_name" 
					placeholder="ลูกค้า" value="<?php echo $customer_name;?>" readonly>
				</div>	

						
                <?php 
$sql3="SELECT * FROM v_sale_detail_control  WHERE  (sale_id='$sale_id') ORDER BY sale_detail_num";	//เช็คการเพิ่มรายการสินค้าในใบเสนอราคา
$query3=$mysqli->query($sql3); // ทำการ query คำสั่ง sql 
$find3=$query3->num_rows;  // นับจำนวนแถวที่แสดงทั้งหมด                
                if($find3>0){?>
				
                <div class="col-md-12 col-xs-12">
                    <h3>รายการสินค้า</h3>
                    <div class="table-responsive" style="background-color:#FFFFFF">

                    <table class="table table-hover table-bordered">
                        <tr>
                            <td width="5%">ลำดับ</td>
                            <td width="12%">รหัสสินค้า</td>
                            <td width="33%">ชื่อสินค้า</td>
                            <td width="10%">ตำแหน่ง</td>
                            <td width="10%">จำนวน</td>
                            <td width="5%">นับได้</td>
                            <td width="25%">หมายเหตุ</td>
                        </tr>
                        <?php
                               
                            while($ord=$query3->fetch_array()){ // วนลูปแสดงข้อมูล									
                                $num=$num+1;
                                $sale_detail_num=$ord['sale_detail_num'];
                                $product_id=$ord['product_id'];
                                $product_code=$ord['product_code'];
								                $product_name=$ord['product_name']; 
                                $product_qty=$ord['product_qty'];
                                $product_count=$ord['product_count'];
                                $product_location=$ord['product_location']; 
                                $sale_detail_remark=$ord['sale_detail_remark']; 

                                $sql2="SELECT * FROM assign_detail WHERE sale_detail_id='$sale_detail_id' AND assign_id='$assign_id' AND product_id='$product_id'";
                                $query2=$mysqli->query($sql2); 
                                $sale2=$query2->fetch_array();	
                        
                        
                                $product_count=$sale2["product_count"];                               
                                $detail_comment_emp=$sale2["detail_comment_emp"];                               
                                                                    
                                                     
                        ?>
                            <tr>
                                <td><?php echo $sale_detail_num?></td>
                                <td><?php echo $product_code?></td>
                                <td><?php echo $product_name?></td>
                                <td align="right"><?php echo $product_location?></td>
                                <td align="right"><?php echo number_format($product_qty)?></td>
                                <td align="center"><?php echo $product_count?></td>
                                <td align="left"><span style="color:red"><?php echo $detail_comment_emp?></span></td>
                                
                            </tr>
                            <?php	}//while ?>

                            <?php 	} // if $find?>
                    </table>
                    </div>
                </div>

                <div class="form-group col-md-12 col-xs-12">
					<label for="stock insert">ประเภทหมายเหตุ</label>
					<select class="form-control"  name="remark_type_emp" required autofocus oninvalid="this.setCustomValidity('กรุณาเลือกประเภทหมายเหตุ')"
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
					<textarea class="form-control" name="comment_emp"  rows="3" required oninvalid="this.setCustomValidity('กรุณาระบุหมายเหตุ')"
          oninput="setCustomValidity('')" ></textarea>
				</div>		
				
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
              <button type="submit" class="btn btn-primary" style="background-color:#9b111e;border-color: #961011" onclick="handleRedirect()" <?php if($product_code==''){ echo "disabled"; }else{ echo "";}?>><i class="fa fa-save"></i> บันทึก</button>
                <!--<a href="order_detail.php?order_id=<?php echo $order_id ?>" class="btn btn-warning" style="background-color:#3A3B3C;border-color:#3A3B3C"><i class="fa fa-undo"></i> ย้อนกลับ</a>-->

				<input type="hidden" name="sale_id" value="<?php echo $sale_id;?>">
				<input type="hidden" name="assign_id" value="<?php echo $assign_id;?>">
				<input type="hidden" name="frompage" value="order_remark.php">
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
    //    let alertTitle = "<?php echo $alertTitle; ?>";
    //    let alertMessage = "<?php echo $alertMessage; ?>";
    //    let alertIcon = "<?php echo $alertIcon; ?>";
    //    let redirectUrl = "<?php echo $redirectUrl; ?>"; // URL สำหรับ redirect

        // แสดง SweetAlert ด้วยค่าจาก PHP และใช้สไตล์ Bootstrap
    //    Swal.fire({
    //        title: alertTitle,
    //        html: alertMessage, // ใช้ 'html' แทน 'text' 
    //        icon: alertIcon,
    //        confirmButtonText: 'ระบุหมายเหตุ',
    //        customClass: {
    //            confirmButton: 'btn btn-danger', // ใช้สไตล์ปุ่มของ Bootstrap
    //        },
    //        buttonsStyling: false // ปิดการใช้งานสไตล์ปุ่มของ SweetAlert2 เพื่อใช้ Bootstrap แทน
    //    });
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
