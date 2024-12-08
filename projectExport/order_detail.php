<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

//session_start();
//include"chksession.php"; //ตรวจสอบเวลาในการเข้าระบบ ให้ล็อกเอาท์อัตโนมัติหากไม่มีการใช้งานระบบ
include"config.php";
include"datethai.php";

$alert=$_GET['alert'];
$alert2=$_GET['alert2'];
$isSuccess=$_GET['isSuccess'];
$sale_id=$_GET['sale_id'];
$assign_id=$_GET['assign_id'];
$title=$_GET['title'];
$icon=$_GET['icon'];
$member_pick=$_SESSION['Member_IdLogin'];
if($alert){

    if ($isSuccess=='true') {
        // กรณี success
        $alertTitle = "<span style='font-size: 22px;'>สำเร็จ!</span>";
        if($title){
          $alertMessage = "<span style='font-size: 18px;'>คุณใช้เวลาทั้งหมด <span style='color:#C60808; font-weight:bold'>".$alert."</span></span>";
        }else{
          $alertMessage = "<span style='font-size: 18px;'>".$alert."</span>";
        }
        $alertIcon = "success"; // ใช้ไอคอน success
        $redirectUrl = "index_emp.php"; // ไม่ต้องการ redirect ในกรณี success
    } elseif($isSuccess=='false') {
        // กรณี error
        $alertTitle = "<span style='font-size: 30px;'>".$title."</span>";
        if($title){
          $alertMessage = "<span style='font-size: 18px;'>คุณใช้เวลาทั้งหมด <span style='color:#C60808; font-weight:bold'>".$alert."</span><br>รายการสินค้าที่ไม่สามารถหยิบได้ <span style='color:#C60808; font-weight:bold'>".$alert2."</span> รายการ</span>";
        }else{
          $alertMessage = "<span style='font-size: 18px;'>".$alert."</span>";
        }

        $alertIcon = $icon; // ใช้ไอคอน error
        $redirectUrl = "order_remark.php?order_id=$order_id&assign_id=$assign_id"; // ไม่ต้องการ redirect ในกรณี error
        $redirectUrl2 = "index_emp.php"; // ไม่ต้องการ redirect ในกรณี error
    } elseif($isSuccess=='warn') {
      // กรณี error
      $alertTitle = "<span style='font-size: 30px;'>".$title."</span>";
      if($title){
        $alertMessage = "<span style='font-size: 18px;'>คุณใช้เวลาทั้งหมด <span style='color:#C60808; font-weight:bold'>".$alert."</span><br>รายการสินค้าที่ไม่สามารถหยิบได้ <span style='color:#C60808; font-weight:bold'>".$alert2."</span> รายการ</span>";
      }else{
        $alertMessage = "<span style='font-size: 18px;'>".$alert."</span>";
      }

      $alertIcon = "warning"; // ใช้ไอคอน error
      $redirectUrl = ""; // ไม่ต้องการ redirect ในกรณี error
  }
}else;

$member_type=$_SESSION['member_type'];
$member_id=$_SESSION['Member_IdLogin'];


//echo $alertTitle;


        //$order_id=1;
				 
		    $sql1="SELECT * FROM  v_sale_test  WHERE  sale_id='$sale_id' ";
				$query1=$mysqli->query($sql1); 
				$sale=$query1->fetch_array();	
				$sale_code=$sale["sale_code"]; 			
				$customer_name=$sale["customer_name"]; 
				$product_qty_all=$sale["product_qty_all"]; 
        //$assign_status=$sale["assign_status"]; 
        //$pick_stop=$sale["pick_stop"]; 

        $sqlass2="SELECT * FROM  assign  WHERE sale_id='$sale_id' AND operation_member='$member_id' AND operation_type='pick' ORDER BY assign_no DESC LIMIT 1 ";
        $queryass2=$mysqli->query($sqlass2); 
        $findass2=$queryass2->num_rows;                   
        if($findass2){
          $ass2=$queryass2->fetch_array();
          $pick_assign_id=$ass2["assign_id"];
          $assign_status= $ass2["assign_status"];
          $pick_dt_start= $ass2["dt_start"];
          $pick_dt_stop= $ass2["dt_stop"];
        }              

        if($assign_status=='2'){
          $str_start="";
          $str_stop="disabled";
          $str_scan="disabled";
        }elseif($assign_status=='3'){
          $str_start="disabled";
          $str_stop="";
          $str_scan="";
        /*}elseif(($order_status=='4')||($order_status=='41')){
          $str_start="disabled";
          $str_stop="disabled";
          $str_scan="disabled";*/
        }else{

          if(isset($pick_stop)){  //หยุดจัดแล้ว
            $str_start="disabled";
            $str_stop="disabled";
            $str_scan="disabled";          
         
          }
        }
        $sql12="SELECT * from master_sale_detail WHERE sale_id='$sale_id'";
        $query12=$mysqli->query($sql12); // ทำการ query คำสั่ง sql 
        $row_product=$query12->num_rows;

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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/fontawesome.min.css" />  
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
    <!-- Bootstrap JavaScript (สำหรับฟังก์ชันเพิ่มเติมของ Bootstrap) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>


    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* เว้นวรรคระหว่างปุ่ม */
        .swal2-confirm {
            margin-right: 10px; /* กำหนดระยะห่างด้านขวาของปุ่ม confirm */
        }
/* กำหนดขนาดกล่อง SweetAlert และระยะห่าง */
.swal2-popup {
            width: 520px !important; /* กำหนดความกว้าง */
            height: auto !important; /* กำหนดความสูง */
            max-width: 90% !important; /* จำกัดความกว้างสูงสุด */
            padding: 20px !important; /* เพิ่มระยะห่างภายในกล่องทั้งหมด */
        }

        /* เพิ่ม padding ในเนื้อหาข้อความ */
        .swal2-html-container {
            padding: 20px !important; /* เพิ่มระยะห่างระหว่างข้อความและขอบ */
        }
        
    .btn-custom {
        background-color: #9b111e;
        color: white !important; /* เพิ่ม !important เพื่อบังคับใช้สีข้อความ */
    }
    .btn-custom2 {
        background-color: #07A14E;
        color: white !important; /* เพิ่ม !important เพื่อบังคับใช้สีข้อความ */
    }       

    .btn-warning_custom {
        background-color: #07A14E;
        color: white !important; /* เพิ่ม !important เพื่อบังคับใช้สีข้อความ */
    }       

    .btn-danger_custom {
        background-color: #9b111e;
        color: white !important; /* เพิ่ม !important เพื่อบังคับใช้สีข้อความ */
    }       

.btn-close{color:#fff;background-color:teal;border-color:#005a5a}

.btn-close:hover{color:#fff;background-color:#004d4d;border-color:#009a9a}
.btn-close:focus,.btn-close.focus{box-shadow:0 0 0 .2rem rgba(0,90,90,0.5)}

.btn-danger-motor{color:#fff;background-color:#9b111e;border-color:#DE3163}
.btn-danger-motor:hover{color:#fff;background-color:#9b111e;border-color:#DE3163}
.btn-danger-motor:focus,.btn-danger-motor.focus{box-shadow:0 0 0 .2rem rgba(0,90,90,0.5)}

    /* เปลี่ยนสีพื้นหลังของ ul (pagination) */
    ul.custom-pagination {
      background-color: #f8f9fa;
      padding: 10px;
      border-radius: 8px;
      list-style: none;
      display: flex;
      justify-content: center;
    }

    /* เปลี่ยนสีพื้นหลังและสีตัวอักษรของ li */
    ul.custom-pagination li {
      background-color: #696969;
      margin: 0 5px;
      border-radius: 4px;
    }

    /* ปรับสีของ a href ใน pagination */
    ul.custom-pagination li a {
      color: white;
      padding: 8px 16px;
      text-decoration: none;
      display: block;
    }

    /* เมื่อ hover ลิงก์ใน pagination */
    ul.custom-pagination li a:hover {
      background-color: #9b111e;
      color: #f8f9fa;
      border-radius: 4px;
    }

    /* เปลี่ยนสีของ li ที่ active */
    ul.custom-pagination li.active a {
      background-color: #9b111e;
      color: white;
      border-radius: 4px;
    }

    .callout-custom {
            background-color: #ccc; /* สีที่ต้องการเปลี่ยน */
            color: #333;
        }
        .custom-btn-app {
    line-height: 1.2;  /* ระยะห่างระหว่างบรรทัด */
    white-space: normal;  /* อนุญาตให้ข้อความขึ้นบรรทัดใหม่ */
    text-align: center;  /* จัดข้อความให้อยู่กึ่งกลาง */
    padding: 10px 10px;  /* เพิ่ม padding รอบๆ ข้อความ */
    min-height: 80px;  /* ตั้งค่าความสูงขั้นต่ำของปุ่ม */
    width: 90px;  /* เพิ่มความกว้างของปุ่ม */
}

.number-icon {
    display: block;  /* ทำให้ตัวเลขแสดงเป็นบรรทัดแยก */
    font-size: 24px;  /* ขนาดตัวเลข */
    font-weight: bold;  /* ทำให้ตัวเลขหนา */
    margin-bottom: 5px;  /* ระยะห่างระหว่างตัวเลขกับข้อความ */
}        


</style>



<script>

  //เคลียร์ parameter

window.onload = function() {
    // ดึง URL ปัจจุบัน
    const url = new URL(window.location.href);

    // สร้าง object เพื่อจัดการกับ query parameters
    const params = new URLSearchParams(url.search);

    // ลบพารามิเตอร์ที่ไม่ต้องการ เช่น 'param1' และ 'param2'
    params.delete('alert');
    params.delete('isSuccess');

    // อัปเดต URL ใหม่ถ้าพารามิเตอร์ถูกลบ
    if (url.search !== params.toString()) {
        // อัปเดต URL โดยไม่โหลดหน้าใหม่
        const newUrl = url.origin + url.pathname + '?' + params.toString();
        window.history.replaceState(null, null, newUrl);
    }
};

</script>
<script src="script.js"></script>
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
  
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1> ข้อมูลหยิบสินค้า <small></small></h1>
      <ol class="breadcrumb">
        <li><a href="index_emp.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="order_detail.php">PICKING</a></li>
      </ol>
    </section>
    <!-- Content Header (Page header) -->
	
    <!----------------------------------------------- Main content----------------------------------------------------->
    <section class="content">
	 <div class="row">
        <!-- left column -->
        <div class="col-md-12" style="background-color:#F8F8FF">

				<div class="form-group col-md-12">
				<?php 
							  if($statusQ=='yes'){
                               // print"";
								   print"<h3><div id=\"alert\" class=\"alert alert-success\" role=\"alert\"> <span class=\"glyphicon glyphicon-ok-sign\" aria-hidden=\"\"></span> <a href=\"#\" 
								   class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
									$alert</div></h3>";
							  }elseif($statusQ=='no'){

								   print"<h3> <div id=\"alert\" class=\"alert alert-danger\" role=\"alert\"> <span class=\"glyphicon glyphicon-remove-sign\" aria-hidden=\"\"></span> <a href=\"#\" 
								   class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>$alert
									</div>";
                }elseif($statusQ=='warn'){
                                    
                  print" <h3><div id=\"alert\" class=\"alert alert-warning\" role=\"alert\"><span class=\"glyphicon glyphicon-info-sign\" aria-hidden=\"\"></span> <a href=\"#\" 
                  class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>$alert
                  </div></h3>";
                }else  print"<h4></h4>";
							  
				?>  
				</div>
<script type="text/javascript"> 
        setTimeout(function () {   
            // Closing the alert 
            $('#alert').alert('close'); 
        }, 7000); 
</script>


<script>
    let timerInterval;
    let startTime = parseInt(localStorage.getItem('timerStartTime')) || null;
    let isRunning = localStorage.getItem('isRunning') === 'true';

    function formatTime(seconds) {
        const hrs = Math.floor(seconds / 3600);
        const mins = Math.floor((seconds % 3600) / 60);
        const secs = seconds % 60;
        return `${String(hrs).padStart(2, '0')}:${String(mins).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
    }

    function updateTimer() {
        const currentTime = Math.floor(Date.now() / 1000);
        const elapsedSeconds = currentTime - startTime;
        document.getElementById('timer').innerText = formatTime(elapsedSeconds);
    }

    function startTimer() {
        if (!isRunning) {
            startTime = Math.floor(Date.now() / 1000);
            localStorage.setItem('timerStartTime', startTime);
            localStorage.setItem('isRunning', 'true');
            isRunning = true;
        }

        if (!timerInterval) {
            timerInterval = setInterval(updateTimer, 1000);
        }
    }

    function startAndGo() {
        startTimer();
        window.location.href = 'order_adjust.php?sale_id=<?php echo $sale_id?>&assign_id=<?php echo $assign_id?>&action=start&frompage=order_detail.php';
    }

    function stopAndSend() {
        if (timerInterval) {
            clearInterval(timerInterval);
            timerInterval = null;
        }
        const currentTime = Math.floor(Date.now() / 1000);
        const elapsedSeconds = currentTime - startTime;
        localStorage.removeItem('timerStartTime');
        localStorage.setItem('isRunning', 'false');

        // ส่งพารามิเตอร์ไปยัง PHP และ redirect กลับมาหน้าหลัก
        window.location.href = 'order_adjust.php?sale_id=<?php echo $sale_id?>&assign_id=<?php echo $assign_id?>&action=stop&frompage=order_detail.php';
    }

    if (isRunning && startTime !== null) {
        startTimer();
    }
</script>

							<div class="form-group  col-md-6 col-xs-12" align="left">
              <div class="pull-left col-md-6  col-xs-12" ><h5>ใบหยิบ | <?php echo $sale_code?></h5></div>
                  <div class="pull  col-md-6 col-xs-12"><h6>รายการ | <?php echo $row_product?> รายการ</h6><!--<button type="submit" class="btn btn-danger" style="background-color:#9b111e;border-color:#A10303"><i class="fa fa-file-text-o"></i> มอบหมายงาน</button>  <input type="hidden" name="frompage" value="<? echo $frompage?>">-->
                  </div>
              
                  <div class="pull-left  col-md-6 col-xs-12" ><h5>ลูกค้า | <?php echo $customer_name?></h5></div>
                  <div class="pull-right col-md-6 col-xs-12" ><h5>จำนวน | <?php echo $product_qty_all?> ชิ้น</h5></div>
              

                  <div class="pull-left">

                  <button id="startAndGoBtn" class="btn btn-danger" style="background-color:#9b111e;border-color:#A10303" <?php echo $str_start?> onclick="startAndGo()"><i class="fa fa-play"></i> เริ่มจัด</button>
                  <button id="stopBtn" class="btn btn-danger"  style="background-color:#696969;border-color:#696969" <?php echo $str_stop?> onclick="stopAndSend()"><i class="fa fa-stop"></i> หยุดจัด </button> 
                  &nbsp;&nbsp;&nbsp;
                  <?php 


                    
                     $sql_time_prev="SELECT SUM(TIMESTAMPDIFF(SECOND, pick_start, pick_stop)) AS total_seconds FROM assign WHERE (sale_id='$sale_id') and (assign_id <> '$assign_id') and (dt_start is not null)"; // เวลาที่ทำครั้งก่อน (รวม)
                    $query_time_prev=$mysqli->query($sql_time_prev);

                    // ตัวแปรสำหรับเก็บผลรวมของเวลาทั้งหมด
                    $totalHours = 0;
                    $totalSeconds =0;
                    $totalMinutes = 0;
                    $totalSeconds =0;
                    $time_stamp=0;
                  if ($query_time_prev->num_rows > 0) {
                    
                      
                        $row = $query_time_prev->fetch_assoc();
                        $totalSeconds = $row['total_seconds'];
                    
                        // แปลงผลรวมวินาทีให้เป็น ชั่วโมง:นาที:วินาที
                        $totalHours = floor($totalSeconds / 3600);
                        $totalSeconds %= 3600;
                        $totalMinutes = floor($totalSeconds / 60);
                        $totalSeconds %= 60;
                            //echo " ".sprintf('%02d : %02d : %02d', $totalHours, $totalMinutes, $totalSeconds)."<br>";

                    }
                    $time_stamp = sprintf('%d ชั่วโมง %d นาที %d วินาที', $totalHours, $totalMinutes, $totalSeconds);


 
                  ?>
                  <div class="form-group  col-md-12 col-xs-12" align="left">
                    
                    <h1 id="timer" >00:00:00</h1>
                    
                  </div>  

                  <?php 

                      $show_time='';
                      $sql31="SELECT * FROM assign WHERE sale_id='$sale_id' AND assign_id = '$assign_id'";
                      $query31=$mysqli->query($sql31); 
                      $date=$query31->fetch_array();

                      $dt_stop=(int)$date['dt_stop'];


                      if($dt_stop!=0){

                        $datetime1=new DateTime($date['dt_start']);
                        $datetime2=new DateTime($date['dt_stop']);

                        // หาผลต่างเวลา
                        $interval = $datetime1->diff($datetime2);
                        $show_time=$interval->format('%h ชั่วโมง %i นาที %s วินาที') ;
                        //echo "<br><br>เวลาที่ทำครั้งนี้ <span style=color:red;font-weigth=bold;>".$show_time."</span>";
                                       ?>
                  <div class="form-group  col-md-6 col-xs-12" align="left">
                    <div class="callout callout-success">
                    <h4>เวลาที่ทำครั้งนี้</h4>
                    <p><?php echo $show_time?></p>
                    </div>                    
                  </div> 
                  <?php } ?>
                  <div class="form-group  col-md-6 col-xs-12" align="left">
                    <div class="callout callout" style="background-color:#696969; border-left:5px solid; border-color:#333; color:#F8F8FF">
                    <h4>เวลาที่ทำก่อนหน้านี้</h4> 
                    <p><?php echo $time_stamp?></p> 
                    </div>                     
                  </div>
                </div>
              </div>
              <?php
                              $sql14="SELECT * from master_sale_detail WHERE flag_count='Y' and sale_id='$sale_id'";
                              $query14=$mysqli->query($sql14); // ทำการ query คำสั่ง sql 
                              $row_success=$query14->num_rows;//
                              if(($assign_status=='4')||($assign_status=='41')){  //หยุดจัดสำเร็จและไม่สำเร็จ  
                                  $sql15="SELECT * from master_sale_detail WHERE (flag_count='N' OR flag_count='' OR flag_count=null )  and sale_id='$sale_id'";
                              }else{
                                $sql15="SELECT * from master_sale_detail WHERE (flag_count='N')  and sale_id='$sale_id'";

                              }

                                
                              $query15=$mysqli->query($sql15); // ทำการ query คำสั่ง sql 
                              $row_unsuccess=$query15->num_rows;//เสร็จสิ้น





                              $sql141="SELECT sum(product_qty) as cnt_y from master_sale_detail WHERE  sale_id='$sale_id' AND flag_count='Y'";
                              $query141=$mysqli->query($sql141); 
                              $row_cnt_y=$query141->num_rows;
                              $y=$query141->fetch_array();
                              $cnt_y=$y['cnt_y'];

                              $sum_product_c=(int)$cnt_y;


                              if($row_cnt_y>0){
                                while($y=$query141->fetch_array()){
                                    $product_count=(int)$y['product_count'];
                                    //$product_qty=$n['product_qty'];
                                    //$product_total=$product_qty - $product_count ; //จำนวนที่นับได้
                                    $sum_product_c=$sum_product_c+$product_count; //รวมจำนวนที่นับได้
                                }
                            }else{
                              $sum_product_c=0;
                            }
                              
                              $sql151 ="SELECT sum(product_qty) as qty from master_sale_detail WHERE sale_id='$sale_id' AND flag_count='N'";
                            //}
                              $query151=$mysqli->query($sql151); // ทำการ query คำสั่ง sql 
                              $row_cnt_n=$query151->num_rows;

                              if($row_cnt_n>0){
                                $n=$query151->fetch_array();
                                    $sum_product_c2 = $n['qty'];
                              }else{
                                $sum_product_c2=0;
                              }                              //$row_unsuccess=$query15->num_rows;//ไม่สำเร็จ
          
              ?>


<div class="form-group  col-md-6 col-xs-12" align="right">

<div class="col-3">รายการ
      <a class="btn btn-app custom-btn-app" style="background-color:#0364BE;color:#FFFFFF">    <span class="number-icon"><?php echo $row_product?></span>ทั้งหมด</a>
      <a class="btn btn-app custom-btn-app" style="background-color:#07A14E;color:#FFFFFF">    <span class="number-icon"><?php echo $row_success?></span>เสร็จสิ้น</a>
      <a class="btn btn-app custom-btn-app" style="background-color:#A10303;color:#FFFFFF">    <span class="number-icon"><?php echo $row_unsuccess?></span>ไม่สำเร็จ</a>
  </div>
  <div class="col-3">จำนวน
      <a class="btn btn-app custom-btn-app" style="background-color:#0364BE;color:#FFFFFF">    <span class="number-icon"><?php echo $product_qty_all?></span>ทั้งหมด</a>
      <a class="btn btn-app custom-btn-app" style="background-color:#07A14E;color:#FFFFFF">    <span class="number-icon"><?php echo $sum_product_c?></span>เสร็จสิ้น</a>
      <a class="btn btn-app custom-btn-app" style="background-color:#A10303;color:#FFFFFF">    <span class="number-icon"><?php echo $sum_product_c2?></span>ไม่สำเร็จ</a>
  
  </div>           

           
</div>




          <!-- general form elements -->

          <div class="row">
          	&nbsp;&nbsp;
            
          </div>


          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              	<li class="active"><a href="#general" data-toggle="tab">ทั้งหมด</a></li>
					      <li><a href="#success" data-toggle="tab">เสร็จสิ้น</a></li>
                <li><a href="#n_success" data-toggle="tab">ไม่สำเร็จ</a></li>

            </ul>


            <div class="tab-content">


      <div class="active tab-pane" id="general">
			 <div class="table-responsive" style="background-color:#FFFFFF">
					   <?php
						   $page =$_GET["page"];/////////////// item  for 1 page //////////////////////
               $per_page =5;
               //////////////////////////////////////////////////////////////////////////////////									
               if ( !$page ) $page = 1; 									
                     $prev_page = $page - 1; 
                     $next_page = $page + 1; 
                     
                     //if($member__type=='1'){
              $sql10="SELECT * FROM  v_sale_detail_control WHERE sale_id='$sale_id' AND (flag_count='' OR isnull(flag_count)) ORDER BY  sale_detail_num";
            
            
                $query10 = $mysqli->query($sql10); // ทำการ query คำสั่ง sql 
               $total=$query10->num_rows;  // นับจำนวนถวที่แสดง ทั้งหมด
               $page_start = ( $per_page * $page) - $per_page; 
               $num_rows=$query10->num_rows;  // นับจำนวนถวที่แสดง ทั้งหมด
               //print"num_rows $num_rows";
               //print"หน้า $page";
               //print" page_start => $page_start"; print" per_page => $per_page";	
               if ( $num_rows <= $per_page )
                     $num_pages = 1; 
               
               else if ( ( $num_rows % $per_page ) == 0 )	$num_pages = ( $num_rows / $per_page ); 
               else{
                     $num_pages = ( $num_rows / $per_page ) + 1; 
                     $num_pages = ( int ) $num_pages; 
                   }
               if ( ( $page > $num_pages ) || ( $page < 0 ) ) 
                     print " $page > ? $num_pages";
 


					$sql11="SELECT * FROM  v_sale_detail_control WHERE sale_id='$sale_id' AND (flag_count='' OR isnull(flag_count)) ORDER BY  sale_detail_num LIMIT $page_start,$per_page"; //รายการที่ยังไม่ได้นับ

					$query11=$mysqli->query($sql11); // ทำการ query คำสั่ง sql 
						$find11=$query11->num_rows;  // นับจำนวนถวที่แสดง ทั้งหมด
						if(($find11>0)&&($assign_status=='3')){ // มีรายการและสถานะ "กำลังหยิบ"แล้ว  
              $str_scan="";
            }else{
              //$str_scan="disabled";
              $str_scan="";
            }
							?>	
							 
								<div class="form-group  col-md-12">
              
              <?php //if($order_status < '4'){ ?>
                <a href="order_scanner_pick.php?sale_id=<?php echo $sale_id?>&assign_id=<?php echo $assign_id?>&sale_detail_id=<?php echo $sale_detail_id?>" class="btn btn-danger  <?php echo $str_scan?>"  style="background-color:#9b111e;border-color:#A10303">
                <span class="glyphicon glyphicon-camera"></span> สแกน
                </a>
              <?php //} ?>

								</div>
                		
							<?php 
						  if($find11>0)
						   {
							?>		
                    
          
            
							<table class="table table-hover table-bordered">
								<thead>
                <tr>
                  <td colspan="5" align="right">
                    หน้าที่ <span style="font-weight:bold;color:#A10303"><?php echo $page?></span> จาก <span style="font-weight:bold;color:#A10303"><?php echo $num_pages?></span> ( <span style="font-weight:bold;color:#A10303"><?php echo $num_rows?></span> รายการ )
                  </td>
                </tr>
								<tr class="active">
								   <!-- <th width="50">MemberID</th>-->
									<th align="center">ลำดับ</th>
									<th>รหัสสินค้า</th>
									<th>ชื่อสินค้า</th>
									<th width="10%">ตำแหน่ง</th>
									<th width="10%">จำนวนรวม</th>
								</tr>
								</thead>

						<?php 
						
						
								$num=$page_start;
								//while($news=mysql_fetch_array($query1))
						 while($ord=$query11->fetch_array()){ // วนลูปแสดงข้อมูล									 
								$num=$num+1;
								   
								$sale_detail_num=$ord['sale_detail_num'];
								$product_code=$ord['product_code'];
								$product_name=$ord['product_name']; 
                $product_qty=$ord['product_qty'];
								$product_location=$ord['product_location']; 
								
									//<td>$member_id</td>
							      	print"<tr>									
									<td align='center'>$sale_detail_num</td>
									<td align='left'>$product_code</td>
									<td align='left'>$product_name</td>
                  <td align='left'>$product_location</td>
                  <td align='right'>$product_qty</td>";
							
		
									
									     }//while
                       print"</tr>";
									 

									 
									?>
									<tr class="Odd" align="center">
										<td  colspan="5" >&nbsp;</td>
                  </tr>				
								</table>
                  <!-- Pagination -->
                  <div class="col-md-12  col-xs-12">
                    <ul class="custom-pagination"><input type="hidden" name="num" value="<? echo $num;?>">
									<?php
                                            //////////////////  prev page  ///////////////////////////////
                      if ( $prev_page ){
											print"<li>
													  <a href=\"$PHP_SELF?page=$prev_page&order_id=$order_id&assign_id=$assign_id\">&laquo;</a>
												  </li>";
                      }
                                            //////////////////  num page ////////////////////////////////
                      for ( $i=1; $i<=$num_pages; $i++ ) { 
												if ( $i != $page){ 
														 print"<li>
															 <a href=\"$PHP_SELF?page=$i&order_id=$order_id&assign_id=$assign_id\">$i</a>
														</li>";
												}else{ 
														print"<li class=active><a href=\"#\">$i</a></li>";
														}
                                                }
                                            
                        /////////////////// next page /////////////////////////////////////
                            if ( $page != $num_pages ){ 
                                print"<li>
                                  <a href=\"$PHP_SELF?page=$next_page&order_id=$order_id&assign_id=$assign_id\">&raquo;</a>
                                </li>";
                            }									
                                    ?>											
    
                              </ul>
                        </div> 
                        <!-- Pagination -->  

                <?php }else{ echo "--- ไม่มีข้อมูลรายการสินค้าที่ยังไม่ได้นับ ---";}?>
              
                
                             
           
                
                </div> <!-- table responsive-->
     				
              </div>  <!-- /.tab-pane -->


      <div class="tab-pane" id="success">
        <div class="table-responsive" style="background-color:#FFFFFF">
					   <?php
						   $page =$_GET["page"];/////////////// item  for 1 page //////////////////////
               $per_page =20;
               //////////////////////////////////////////////////////////////////////////////////									
               if ( !$page ) $page = 1; 									
                     $prev_page = $page - 1; 
                     $next_page = $page + 1; 
                     
                     //if($member__type=='1'){
              $sql10="SELECT * FROM  v_sale_detail_control WHERE sale_id='$sale_id' AND flag_status='Y' ORDER BY  sale_detail_num";
            
            
                $query10 = $mysqli->query($sql10); // ทำการ query คำสั่ง sql 
               $total=$query10->num_rows;  // นับจำนวนถวที่แสดง ทั้งหมด
               $page_start = ( $per_page * $page) - $per_page; 
               $num_rows=$query10->num_rows;  // นับจำนวนถวที่แสดง ทั้งหมด
               //print"num_rows $num_rows";
               //print"หน้า $page";
               //print" page_start => $page_start"; print" per_page => $per_page";	
               if ( $num_rows <= $per_page )
                     $num_pages = 1; 
               
               else if ( ( $num_rows % $per_page ) == 0 )	$num_pages = ( $num_rows / $per_page ); 
               else{
                     $num_pages = ( $num_rows / $per_page ) + 1; 
                     $num_pages = ( int ) $num_pages; 
                   }
               if ( ( $page > $num_pages ) || ( $page < 0 ) ) 
                     print " $page > ? $num_pages";
 


					$sql11="SELECT * FROM  v_sale_detail_control WHERE sale_id='$sale_id' AND flag_count='Y' ORDER BY  sale_detail_num LIMIT $page_start,$per_page";

					$query11=$mysqli->query($sql11); // ทำการ query คำสั่ง sql 
						$find11=$query11->num_rows;  // นับจำนวนถวที่แสดง ทั้งหมด
							
						  if($find11>0)
						   {
							?>										   
							<table class="table table-hover table-bordered">
								<thead>
								<tr class="active">
								   <!-- <th width="50">MemberID</th>-->
									<th align="center">ลำดับ</th>
									<th>รหัสสินค้า</th>
									<th>ชื่อสินค้า</th>
									<th width="10%">ตำแหน่ง</th>
                  <th width="12%">จำนวนในใบหยิบ</th>
                  <th width="12%">จำนวนนับได้</th>
								</tr>
								</thead>

						<?php 
						
						
								$num=$page_start;
								//while($news=mysql_fetch_array($query1))
						 while($ord=$query11->fetch_array()){ // วนลูปแสดงข้อมูล									 
								$num=$num+1;
								   
								$order_detail_num=$ord['order_detail_num'];
								$product_code=$ord['product_code'];
								$product_name=$ord['product_name']; 
                $product_qty=$ord['product_qty'];
                //$product_count=$ord['product_count'];
								$product_location=$ord['product_location']; 
								
									//<td>$member_id</td>
							      	print"<tr>									
									<td align='center'>$sale_detail_num</td>
									<td align='left'>$product_code</td>
									<td align='left'>$product_name</td>
                  <td align='left'>$product_location</td>
                  <td align='right'>$product_qty</td>
                  <td align='right'>$product_count</td>";
							
		
									
									     }//while
                       print"</tr>";
									 

									 
									?>
									<tr class="Odd" align="center">
										<td  colspan="12" >&nbsp; </td>
									</tr>		
                  				
								</table>
                <?php }else{ echo "--- ไม่มีข้อมูลรายการสินค้าที่เสร็จสิ้น ---"; }?>	

      </div>
	  </div>
	    <!-- /.tab-pane -->

      
      <div class="tab-pane" id="n_success">
      <div class="table-responsive" style="background-color:#FFFFFF">
					   <?php
						   $page =$_GET["page"];/////////////// item  for 1 page //////////////////////
               $per_page =20;
               //////////////////////////////////////////////////////////////////////////////////									
               if ( !$page ) $page = 1; 									
                     $prev_page = $page - 1; 
                     $next_page = $page + 1; 
                     
                     //if($member__type=='1'){
              $sql10="SELECT * FROM  v_sale_detail_control WHERE sale_id='$sale_id' AND flag_status='N' ORDER BY  sale_detail_num";
            
            
                $query10 = $mysqli->query($sql10); // ทำการ query คำสั่ง sql 
               $total=$query10->num_rows;  // นับจำนวนถวที่แสดง ทั้งหมด
               $page_start = ( $per_page * $page) - $per_page; 
               $num_rows=$query10->num_rows;  // นับจำนวนถวที่แสดง ทั้งหมด
               //print"num_rows $num_rows";
               //print"หน้า $page";
               //print" page_start => $page_start"; print" per_page => $per_page";	
               if ( $num_rows <= $per_page )
                     $num_pages = 1; 
               
               else if ( ( $num_rows % $per_page ) == 0 )	$num_pages = ( $num_rows / $per_page ); 
               else{
                     $num_pages = ( $num_rows / $per_page ) + 1; 
                     $num_pages = ( int ) $num_pages; 
                   }
               if ( ( $page > $num_pages ) || ( $page < 0 ) ) 
                     print " $page > ? $num_pages";
 


					$sql11="SELECT * FROM  v_sale_detail_control WHERE sale_id='$sale_id' AND flag_count='N' ORDER BY  sale_detail_num LIMIT $page_start,$per_page";

					$query11=$mysqli->query($sql11); // ทำการ query คำสั่ง sql 
						$find11=$query11->num_rows;  // นับจำนวนถวที่แสดง ทั้งหมด
							
						  if($find11>0)
						   {
							?>										   
							<table class="table table-hover table-bordered">
								<thead>
								<tr class="active">
								   <!-- <th width="50">MemberID</th>-->
									<th align="center">ลำดับ</th>
									<th>รหัสสินค้า</th>
									<th>ชื่อสินค้า</th>
									<th width="10%">ตำแหน่ง</th>
                  <th width="12%">จำนวนในใบหยิบ</th>
                  <th width="12%">จำนวนนับได้</th>
								</tr>
								</thead>

						<?php 
						
						
								$num=$page_start;
								//while($news=mysql_fetch_array($query1))
						 while($ord=$query11->fetch_array()){ // วนลูปแสดงข้อมูล									 
								$num=$num+1;
								   
								$sale_detail_num=$ord['sale_detail_num'];
                $product_id=$ord['product_id'];
								$product_code=$ord['product_code'];
								$product_name=$ord['product_name']; 
                $product_qty=$ord['product_qty'];
                //$product_count=$ord['product_count'];
								$product_location=$ord['product_location']; 

                $sql_ass="SELECT * FROM assign_detail WHERE sale_id='$sale_id' AND assign_id='$assign_id' AND product_id='$product_id'";
                $query_ass=$mysqli->query($sql_ass); 
                $find_ass=$query_ass->num_rows; 
                
                if($find_ass){
                  $ass=$query_ass->fetch_array();
                  $product_count=$ass['product_count'];
                }else{
                  $product_count='';
                }

                
								?>
							  <tr>									
									<td align='center'><?php echo $ord['sale_detail_num']; ?></td>
									<td align='left'><?php echo $product_code?></td>
									<td align='left'><?php echo $product_name?></td>
                  <td align='left'><?php echo $product_location?></td>
                  <td align='right'><?php echo $product_qty?></td>
                  <td align='right'><?php echo $product_count?></td>
							
		
								<?php	
									     }//while
                       print"</tr>";
									 

									 
									?>
									<tr class="Odd" align="center">
										<td  colspan="12" >&nbsp; </td>
									</tr>		
                  				
								</table>
                <?php }else{ echo "--- ไม่มีข้อมูลรายการสินค้าที่ไม่สำเร็จ ---"; }?>	

      </div>
	  </div>
	    <!-- /.tab-pane -->


            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
     
        </div>
        <!--/.col left column -->
      </div>
	  
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">สแกนสินค้า</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Recipient:</label>
            <input type="text" class="form-control" id="recipient-name">
          </div>
          <div class="form-group">
							<div id="reader"></div>
							<div id="result"></div>

          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" style="background-color:#9b111e;border-color:#A10303">บันทึก</button><button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
    </div>
  </div>
</div>


    </section>
    <!------------------------------------------------ /.content ------------------------------------------------------->
	
  </div>
  <!-- /.content-wrapper -->
  
  <footer class="main-footer">
   <?php include('footer.php'); ?>
  </footer>

<script>
const scanner = new Html5QrcodeScanner('reader', {
qrbox: {
width: 200,
height: 200,
},
fps: 10,
});
scanner.render(success, error);
function success(result) {
document.getElementById('result').innerHTML = `
<div id="reader"></div>
<h2>Success!</h2>
<p><a href="${result}">${result}</a></p>
<input type=text value="${result}">
`;
scanner.clear();
document.getElementById('reader').remove();
}
function error(err) {
console.error(err);
}
</script>


        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>

<?php if($alert){?>
    <script>
        // รับค่าจาก PHP และนำไปใช้ใน SweetAlert
        let alertTitle = "<?php echo $alertTitle; ?>";
        let alertMessage = "<?php echo nl2br($alertMessage); ?>";
        let alertIcon = "<?php echo $alertIcon; ?>";
        let redirectUrl = "<?php echo $redirectUrl; ?>"; // URL สำหรับ redirect

        // แสดง SweetAlert ด้วยค่าจาก PHP และใช้สไตล์ Bootstrap

        Swal.fire({
          title: alertTitle,
            html: alertMessage, 
            icon: alertIcon,
            showCancelButton: false, // ไม่แสดงปุ่ม close ในกรณี error
              confirmButtonText: //edit ข้อความบนปุ่มตรงนี้//
                alertIcon === "success" ? 'ส่งหัวหน้า' : //กรณี success icon
                alertIcon === "warning" ? 'ปิด' : 'ระบุหมายเหตุใบหยิบ', //กรณี warning icon และ error
            customClass: {
              confirmButton: //edit สีปุ่มตรงนี้//
                alertIcon === "success" ? 'btn btn-success' : //กรณี success icon
                alertIcon === "warning" ? 'btn btn-warning_custom' : 'btn btn-danger_custom', //กรณี warning icon และ error
            },
            buttonsStyling: false // ปิดสไตล์ปุ่มเริ่มต้นของ SweetAlert
        }).then((result) => {
            if (result.isConfirmed) {
                // กรณี success หรือ error ทำการ redirect
                if (alertIcon === "success" || alertIcon === "error") {
                    window.location.href = redirectUrl;
                }
                // กรณี warning ไม่ทำอะไรอยู่หน้าเดิม
                else if (alertIcon === "warning") {
                    Swal.close(); // ปิด SweetAlert และไม่ redirect
                }
            }
        });


    </script>
<?php } ?>


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

	   <script src="js/jquery.maskedinput.js" type="text/javascript"></script>
		<script type="text/javascript">
			jQuery(function($) {
			  $.mask.definitions['~']='[+-]';
			  $('#idcard').mask('9-9999-99999-9-99');
			  $('#DateRev2').mask('99/99/9999');
			});
		</script>


<script>
  $(function () {
  
    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    });

  });
  
$('#file_browser').click(function(e){
    e.preventDefault();
    $('#file').click();
});

$('#file').change(function(){
    $('#file_path').val($(this).val());
});

$('#file_path').click(function(){
    $('#file_browser').click();
});

</script>



</body>
</html>
