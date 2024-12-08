<?php
session_start();
include"chksession.php";//ตรวจสอบเวลาในการเข้าระบบ ให้ล็อกเอาท์อัตโนมัตหากไม่มีการใช้งานระบบ
include"config.php";
include"datethai.php";

$statusQ=$_GET['statusQ'];
$alert=$_GET['alert'];


?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ระบบคลังสินค้า หจก.ละงูปิโตรเลียม :: <? echo $_SESSION['MenuType']?></title>
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

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  
		<link rel="stylesheet" type="text/css" href="server_side/css/jquery.dataTables.css">
		<script type="text/javascript" language="javascript" src="server_side/js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="server_side/js/jquery.dataTables.js"></script>
		<script type="text/javascript" language="javascript" >
			$(document).ready(function() {
				var dataTable = $('#bank_account-grid').DataTable( {
					"processing": true,
					"serverSide": true,
					"ajax":{
						url :"server_side/bank_account-grid-data.php", // json datasource
						type: "post",  // method  , by default get
						error: function(){  // error handling
							$(".bank_account-grid-error").html("");
							$("#bank_account-grid").append('<tbody class="bank_account-grid-error"><tr><th colspan="4">No data found in the server</th></tr></tbody>');
							$("#bank_account-grid_processing").css("display","none");
							
						}
					}
				} );
			} );
		</script>
		<style>
			div.container {
			    margin: 0 auto;
			    max-width:760px;
			}
			div.header {
			    margin: 100px auto;
			    line-height:30px;
			    max-width:760px;
			}
			body {
			    background: #f7f7f7;
			    color: #333;
			    font: 90%/1.45em "Helvetica Neue",HelveticaNeue,Verdana,Arial,Helvetica,sans-serif;
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
   $b = 'active';
   $bank_account = 'active';
   $bank_account_list = 'active';
   include('menu.php');
  ?> 
  <!-- /.sidebar -->
  </aside>
  
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1> ข้อมูลบัญชีธนาคาร <small></small></h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="bank_account_list.php">Bank Account</a></li>
      </ol>
    </section>
    <!-- Content Header (Page header) -->
	
    <!----------------------------------------------- Main content----------------------------------------------------->
    <section class="content">

			<!-- Content -->
			<!-- about -->
        	<div class="col-lg-12 col-md-12 col-sm-12">
			 <div class="col-lg-12 col-sm-12 panel panel-default">
			 
		<br> 				<a href="bank_account_form.php"  class="btn btn-info">
								<span class="fa  fa-plus-circle"></span> เพิ่มบัญชีธนาคาร
								</a>	
								<a href="bank_account_list_excel.php?txtSearch=<?php echo $txtSearch;?>"
								 target="_blank"  class="btn btn-success">
								<span class="glyphicon glyphicon-list-alt"></span> ออกรายงาน
								</a>						
			 
	    <br>    <br>      	
			<table id="bank_account-grid"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
					<thead>
						<tr>
									<th>ID</th>
									<th>ชื่อ - สกุล</th>
									<th>ประเภทลูกค้า</th>
									<th>เบอร์โทรศัพท์</th>
								    <th>สถานะ</th>                     
									<th>แก้ไข</th>
						</tr>
					</thead>
			</table>
		<br>  <br>  
		      </div>
        	</div>
        	<!-- End about-->
			<!-- Content -->	

    </section>
    <!------------------------------------------------ /.content ------------------------------------------------------->
	
  </div>
  <!-- /.content-wrapper -->
  
  <footer class="main-footer">
   <?php include('footer.php'); ?>
  </footer>




  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<!-- jQuery UI 1.11.4 -->
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<!-- Bootstrap WYSIHTML5 -->
<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
