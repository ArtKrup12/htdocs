<?php
include('../database_connect/conn.php');
include('../query_database/query_location.php') ;
include('../auth/auth_login.php') ;


$background_color_select_tool = 'style="background-color: grey;"' ; //ปรับสีเครื่องมือที่ถูกเลือก


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ระบบขอใช้เครื่องมือมาตรฐานสอบเทียบทางการแพทย์ ศบส.7</title>
    <link rel="shortcut icon" type="image/x-icon" href="../assets/favicon.ico" />

    <!-- SweatAlert2 -->
    <script src="../node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="../node_modules/sweetalert2/dist/sweetalert2.min.css">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../fontawesome-free-6.2.1-web/css/all.min.css">

    <!-- Styles -->
    <link href="../bootstrap_css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../dselect-main/dist/css/dselect.css">
    <link href="../css/user.css" rel="stylesheet">

    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../dselect-main/dist/js/dselect.js"></script>
</head>

<body>
    
        <?php  //แจ้งเตือนเพิ่มเครื่องมือ
            if(isset($_SESSION['add_tool'])) :  ?>
            <script>
            const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
            })

            Toast.fire({
            icon: 'success',
            title: 'เพิ่มเครื่องมือเรียบร้อย'
            })
            </script>
            <?php endif ; ?>

            <?php  //แจ้งเตือนลบเครื่องมือ
            if(isset($_SESSION['delete_tool'])) :  ?>
            <script>
            const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
            })

            Toast.fire({
            icon: 'success',
            title: 'ลบเครื่องมือเรียบร้อย'
            })
            </script>
            <?php endif ; ?>
    <div class="sidebar p-3">
        <div class="shead">
            <img class="logo_mecser" src="../assets/logo_mecers.png" alt="logo_mecser">
            <h4 class="mecser" id="mecser_th_name">ระบบขอใช้เครื่องมือมาตรฐานสอบเทียบทางการแพทย์</h4>
            <span class="mecser" id="hss7_name">ศูนย์สนับสนุนบริการสุขภาพที่ 7</span>
        </div>
        <div class="sbody">
            <ul>
                <li><i class="fa-solid fa-house"></i><button class="menu_list" onclick="location.href='home'">หน้าหลัก</button></li>
                <li class="active"><i class="fa-solid fa-toolbox"></i><button class="menu_list" onclick="location.href='borrow'">ยืมเครื่องมือ</button></li>
                <li><i class="fa-solid fa-file"></i><button onclick="location.href='status'" class="menu_list">ติดตามสถานะ</button></li>
                <?php
                   if($_SESSION['Role']== 'app'){  ?>
                         <li><i class="fa-solid fa-clipboard-check"></i><button class="menu_list" onclick="location.href='confirm'">คำขอรอยืนยัน</button></li>
                         <?php include('../query_database/query_noti.php') ; ?>
                         <div class="notification"><span><?php echo $noticount ;  ?></span></div>
                <?php }else{  ?>

                <?php  }  ?>
                <li><i class="fa-solid fa-folder-open"></i><button onclick="location.href='history'" class="menu_list">ประวัติ</button></li>
                <li><i class="fa-solid fa-user-gear"></i><button onclick="location.href='setting'" class="menu_list">ข้อมูลส่วนตัว</button></li>
            </ul>
        </div>
        <div class="sbottom">
            <div class="username_group">
                <img class="user_pic" src="../uploads/hss7.png"></img>
                <p class="logout_active"><?php echo $_SESSION['auth_user'] ; ?><i class="fa-solid fa-caret-right mx-2"></i></p>
            </div>
            <!-- <button class="logout_btn">ออกจากระบบ</button> -->
            <a  class="logout_btn" href="../logout">ออกจากระบบ</a>
        </div>
    </div>
    <nav class="navbar navbar-expand-md navbar-light bg-hss7 shadow-sm">
        <div class="navbar navbar-expand-md nav_bor"></div>
        <div class="hamburger_menu">
            <button href="#" class="nav_icon">
                <i class="fa-solid fa-bars"></i>
            </button>
            <div class="nav_text">
                <p><b>ศูนย์สนับสนุนบริการสุขภาพที่ 7</b></p>
                <p class="mecser_name">ระบบขอใช้เครื่องมือมาตรฐานสอบเทียบทางการแพทย์</p>
            </div>
        </div>
        <div class="role">
            <span>เข้าสู่ระบบในฐานะ : </span>
            <?php        
            if($_SESSION['Role'] == 'user'){
                echo ' <span class="role_user">ผู้ใช้งานระบบ</span>' ;

            }else if($_SESSION['Role'] == 'app'){
                echo ' <span class="role_user">ผู้มีสิทธิ์อนุมัติ</span>' ;
            }else{
                echo ' <span class="role_user">ผู้ใช้งานระบบ/ผู้ดูแลระบบ</span>' ;
            }
            
            ?>
        </div>
        <!-- <div class="user_info">
            <button href="#" class="nav_icon">
                <i class="fa-solid fa-gear"></i>
            </button>
            <ul class="hamburger_user_list">
                <li><i class="fa-solid fa-user"><button class="user_list">นายนพรัตน์ พรานันท์</button></i></li>
                <li><i class="fa-solid fa-door-open"></i><button class="user_list">ล็อคเอาท์</button></li>
            </ul>
        </div> -->
        <div class="hamburger_menu_list">
            <ul>
                <li><i class="fa-solid fa-house"></i><button class="menu_list" onclick="location.href='home'">หน้าหลัก</button></li>
                <li><i class="fa-solid fa-toolbox"></i><button class="menu_list" onclick="location.href='borrow'">ยืมเครื่องมือ</button></li>
                <li><i class="fa-solid fa-file"></i><button class="menu_list" onclick="location.href='status'">ติดตามสถานะ</button></li>
                <?php
                   if($_SESSION['Role']== 'app'){  ?>
                         <li><i class="fa-solid fa-clipboard-check"></i><button class="menu_list" onclick="location.href='confirm'">คำขอรอยืนยัน</button></li>
                         <?php include('../query_database/query_noti.php') ; ?>
                         <div class="notification"><span><?php echo $noticount ;  ?></span></div>
                <?php }else{  ?>

                <?php  }  ?>
                <li><i class="fa-solid fa-folder-open"></i><button class="menu_list" onclick="location.href='history'">ประวัติ</button></li>
                <li id="info_toggle"><i class="fa-solid fa-user"></i><button class="menu_list"><?php echo $_SESSION['auth_user'] ; ?><i class="fa-solid fa-caret-down mx-2"></i></button>
                </li>
                <ul class="info_menu_list">
                    <li><i class="fa-solid fa-user-gear"></i><button class="menu_list" onclick="location.href='setting'">ข้อมูลผู้ใช้</button></li>
                    <li><i class="fa-solid fa-door-open"></i> <a class="menu_list"  href="../logout" >ออกจากระบบ</a></li>
                </ul>
            </ul>
        </div>
        <script src="../js/user.js"></script>
    </nav>

    <main>
        <div class="borrowBox">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5>ขออนุมัติใช้เครื่องมือ</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-12 col-sm-12 col-md-5 col-lg-5 mb-3" style="flex-direction: column;
                                    display: flex;
                                    justify-content: space-around;">
                                    <font color="red">
                                     &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
                                    *กรุณาเพิ่มเครื่องมือก่อนใส่รายละเอียดของการขอใช้เครื่องมือ*

                                    <?php
                                     $query_stock = $conn->query("SELECT * FROM tooldata  WHERE Stock = 1 ");
                                     $row_stock = mysqli_fetch_assoc($query_stock) ;
                                     if(empty($row_stock)){
                                        echo '<br>' ;
                                        echo ' &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;' ;
                                        echo ' *ไม่มีเครื่องมือเหลือในหน่วยงาน*' ;

                                     }else
                                     // แสดงเลือก
                                     $Id = $_SESSION['Emp_id'] ;
                                     $query_temp = $conn->query("SELECT * FROM temp_list  WHERE Emp_id = '$Id' ");
                                     $Num_tooldata = mysqli_num_rows($query_stock) ;
                                     $Num_temp = mysqli_num_rows( $query_temp) ;
                                     echo '<br>' ;
                                     echo ' &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;' ;
                                     echo 'เลือกแล้ว ' ;
                                     echo $Num_temp ;
                                     echo '/' ;
                                     echo $Num_tooldata ;
                                     // แสดงเลือก
                                     
                                    ?>
                                    </font>
                                <form action="<?php
                                if(empty($_GET['risk'])){
                                   echo '' ;
                                }else{
                                    echo '../userpage/borrow.php' ;
                                }
                                
                                ?>" method="POST">
                                    <div class="select" style="padding: 1rem .5rem;">
                                        <select type="text" class="form-control" id="username"  name="RiskLevel" >
                                        <?php
                                            if(empty($_GET['risk'])){ ?>
                                                <option selected disabled >เลือกประเภทความเสี่ยง</option>
                                                <option value="3">ความเสี่ยงสูง</option>
                                                <option value="2">ความเสี่ยงกลาง</option>
                                                <option value="1">ความเสี่ยงต่ำ</option>
                                                <?php }else{ ?>

                                                <?php  if($_GET['risk']== '2') { ?>
                                                    <option value="2">ความเสี่ยงกลาง</option>
                                                     <option value="3">ความเสี่ยงสูง</option>
                                                     <option value="1">ความเสี่ยงต่ำ</option>
                                                     <?php } else if ($_GET['risk']== '1')  {?>
                                                        <option value="1">ความเสี่ยงต่ำ</option>
                                                        <option value="2">ความเสี่ยงกลาง</option>
                                                     <option value="3">ความเสี่ยงสูง</option>
                                                    
                                                     <?php  } else if ($_GET['risk']== '3')  {?>
                                                        <option value="3">ความเสี่ยงสูง</option>
                                                        <option value="1">ความเสี่ยงต่ำ</option>
                                                        <option value="2">ความเสี่ยงกลาง</option>
                                                     
                                                        <?php } ?>
                                               
                                                <?php  } ?>
                                            
                                        </select>
                                        <!-- <div class="btn btn-primary">ค้นหา</div> -->
                                        <button class="btn btn-primary" type="submit" name="searchtool">ค้นหา</button>
                                    </div>
                                </form>
                                <form action="../borrow/add_wait_confirm.php" id="form1" method="POST">
                                <div class="timeBox">
                                    <div class="dropdown dselect-wrapper">
                                        <select class="form-select select" id="select_box" name="location[]" multiple required oninvalid="this.setCustomValidity('กรุณากรอกข้อมูล')">
                                            <option value="" disabled selected>เลือกสถานที่ใช้เครื่องมือ</option>
                                            <?php
                                            while ($location = mysqli_fetch_assoc($query_hospital)) {
                                          
                                                echo  '<option value="' . $location['Hospital_name'] . '">' . $location['Hospital_name'] . '</option>';
                                            } ?>
                                        </select>
                                        <script>
                                            var select_box_element = document.querySelector('#select_box');
                                            dselect(select_box_element, {
                                                search: true
                                            });
                                        </script>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 disflex">
                                            <span class="w80">วันที่ : </span>
                                            <input class="form-control" type="date" min="<?php echo date('Y-m-d') ?>" name="dateborrow" id="" required oninvalid="this.setCustomValidity('กรุณาเลือกวันที่จะยืม')">
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 disflex" style="margin-bottom: 0;">
                                            <span class="w80">ถึงวันที่ : </span>
                                            <input class="form-control" type="date" min="<?php echo date('Y-m-d') ?>" name="datereturn" id="" required oninvalid="this.setCustomValidity('กรุณาเลือกวันที่จะคืน')">
                                        </div>
                                    </div>
                                </div>
                                </form>
                            </div>

                            <?php
                            if( isset($_SESSION['repeat_tool']) ){ ?>
                                <script>
                                Swal.fire({
                                    position: 'center',
                                    icon: 'warning',
                                    title: 'คุณเลือกเครื่องมือนี้แล้ว',
                                    showConfirmButton: false,
                                    timer: 1000
                                  })
                                  </script>
                                  <?php } ?>

                                  <?php
                            if( isset($_SESSION['datewrong']) ){ ?>
                                <script>
                                Swal.fire({
                                    position: 'center',
                                    icon: 'warning',
                                    title: 'กรุณาเลือกวันที่ยืมและคืนให้ถูกต้อง',
                                    showConfirmButton: false,
                                    timer: 2000
                                  })
                                  </script>
                                  <?php } ?>
      
                            <div class="col-12 col-sm-12 col-md-7 col-lg-7" style="height: 20rem; overflow: scroll;">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered">
                                        <thead class="table-info">
                                            <tr>
                                                <th scope="col">No.</th>
                                                <th scope="col">รูป</th>
                                                <th scope="col">ชื่อ</th>
                                                <th scope="col">ความเสี่ยง</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            if(empty($_GET['risk'])){ ?>
                                               <?php
                                            if (isset($_POST['searchtool'])) { ?>
                                            <form action="../borrow/add_tool.php" method="POST">
                                                <?php
                                                if(empty($_POST['RiskLevel'])){ 
                                                    $query_tool_inpage = $conn->query("SELECT * FROM tooldata WHERE Stock = 1 ");
                                                }else{
                                                    $RiskLevel = $_POST['RiskLevel']; 
                                                    $query_tool_inpage = $conn->query("SELECT * FROM tooldata WHERE RiskLevel = $RiskLevel AND Stock = 1");
                                                }
                                                ?>
                                                <?php $i = 0;
                                               
                                                while ($row = mysqli_fetch_assoc($query_tool_inpage)) { ?>
                                                    <?php $i++;
                                                    ?>
                                                    <tr class="toolSelect" <?php 
                                                        $ToolId =  $row['ToolId'] ;
                                                        $Emp_id = $_SESSION['Emp_id'] ;
                                                     $query_tool_temp_list = $conn->query("SELECT * FROM temp_list  WHERE Tool_id = $ToolId AND Emp_id = $Emp_id ");
                                                     $row_grey = mysqli_fetch_assoc($query_tool_temp_list) ;
                                                     if(empty($row_grey['Tool_id'])){
                                                            echo '' ;
                                                    }else{
                                                            echo $background_color_select_tool ;
                                                    } ?>>
                                                        <th scope="row"><?php echo $i ?></th>

                                                        <td><img src="../uploads/<?php echo $row['tool_photo'] ; ?>" alt="Tool picture"></td>


                                                        <td><?php echo $row['ToolName'] ?></td>
                                                        <?php
                                                        if ($row['RiskLevel'] == '1') {
                                                            echo '<td style="color: green;">ความเสี่ยงต่ำ</td>';
                                                        } else if ($row['RiskLevel'] == '2') {
                                                            echo '<td style="color: gray ;">ความเสี่ยงกลาง</td>';
                                                        } else if ($row['RiskLevel'] == '3') {
                                                            echo '<td style="color: red;">ความเสี่ยงสูง</td>';
                                                        } else {
                                                            echo '<td style="color: black;">-</td>';
                                                        }
                                                        ?>
                                                        <input type="hidden" value="<?php echo $row['RiskLevel'] ?>" name="test">
                                                        <input type="hidden" name="Emp_id" value="<?php echo $_SESSION['Emp_id'] ; ?>" >
                                                        <td><button type="submit" value="<?php echo $row['ToolId'] ?>" name="add_tool" class="btn btn-success btn-sm">เพิ่ม</button></td>

                                                    <?php  } ?>
                                            </form>
                                                <?php } else { ?>
                                             <form action="../borrow/add_tool.php" method="POST">
                                                        <?php $i = 0;
                                                        $query_tool_inpage = $conn->query("SELECT * FROM tooldata WHERE Stock = 1");
                                                        while ($row = mysqli_fetch_assoc($query_tool_inpage)) { ?>
                                                            <?php $i++;
                                                            ?>
                                                    <tr class="toolSelect" <?php 
                                                        $ToolId =  $row['ToolId'] ;
                                                        $Emp_id = $_SESSION['Emp_id'] ;
                                                     $query_tool_temp_list = $conn->query("SELECT * FROM temp_list  WHERE Tool_id = $ToolId AND Emp_id = $Emp_id ");
                                                     $row_grey = mysqli_fetch_assoc($query_tool_temp_list) ;
                                                     if(empty($row_grey['Tool_id'])){
                                                            echo '' ;
                                                    }else{
                                                            echo $background_color_select_tool ;
                                                    } ?>>
                                                        <th scope="row"><?php echo $i ?></th>
                                                        <td><img src="../uploads/<?php echo $row['tool_photo'] ; ?>" alt="Tool picture"></td>
                                                        <td><?php echo $row['ToolName'] ?></td>
                                                        <?php
                                                            if ($row['RiskLevel'] == '1') {
                                                                echo '<td style="color: green;">ความเสี่ยงต่ำ</td>';
                                                            } else if ($row['RiskLevel'] == '2') {
                                                                echo '<td style="color: gray ;">ความเสี่ยงกลาง</td>';
                                                            } else if ($row['RiskLevel'] == '3') {
                                                                echo '<td style="color: red;">ความเสี่ยงสูง</td>';
                                                            } else {
                                                                echo '<td style="color: black;">-</td>';
                                                            }
                                                        ?>
                                                        <input type="hidden" name="Emp_id" value="<?php echo $_SESSION['Emp_id'] ; ?>" >
                                                        <td><button type="submit" value="<?php echo $row['ToolId'] ?>" name="add_tool" class="btn btn-success btn-sm">เพิ่ม</button></td>

                                                    <?php  }
                                                    ?>
                                                <?php }  ?>
                                                </form>

                                                    </tr>
                                                <?php }else{ ?>

                                                    <form action="../borrow/add_tool.php?risk=<?php echo $_GET['risk'] ; ?>" method="POST">
                                                        <?php $i = 0; 
                                                        $Risk = $_GET['risk'] ;
                                                        $query_tool_inpage = $conn->query("SELECT * FROM tooldata  WHERE RiskLevel = $Risk AND Stock = 1 ");
                                                        while ($row = mysqli_fetch_assoc($query_tool_inpage)) { ?>
                                                            <?php $i++;
                                                            ?>
                                                    <tr class="toolSelect" <?php 
                                                        $ToolId =  $row['ToolId'] ;
                                                        $Emp_id = $_SESSION['Emp_id'] ;
                                                     $query_tool_temp_list = $conn->query("SELECT * FROM temp_list  WHERE Tool_id = $ToolId AND Emp_id = $Emp_id ");
                                                     $row_grey = mysqli_fetch_assoc($query_tool_temp_list) ;
                                                     if(empty($row_grey['Tool_id'])){
                                                            echo '' ;
                                                    }else{
                                                            echo $background_color_select_tool ;
                                                    } ?>>
                                                        <th scope="row"><?php echo $i ?></th>
                                                        <td><img src="../uploads/<?php echo $row['tool_photo'] ; ?>" alt="Tool picture"></td>
                                                        <td><?php echo $row['ToolName'] ?></td>
                                                        <?php
                                                            if ($row['RiskLevel'] == '1') {
                                                                echo '<td style="color: green;">ความเสี่ยงต่ำ</td>';
                                                            } else if ($row['RiskLevel'] == '2') {
                                                                echo '<td style="color: gray ;">ความเสี่ยงกลาง</td>';
                                                            } else if ($row['RiskLevel'] == '3') {
                                                                echo '<td style="color: red;">ความเสี่ยงสูง</td>';
                                                            } else {
                                                                echo '<td style="color: black;">-</td>';
                                                            }
                                                        ?>
                                                        <input type="hidden" name="Emp_id" value="<?php echo $_SESSION['Emp_id'] ; ?>" >
                                                        <td><button type="submit" value="<?php echo $row['ToolId'] ?>" name="add_tool" class="btn btn-success btn-sm">เพิ่ม</button></td>

                                                    <?php  }
                                                    ?>
                                                
                                                 </form>
                                               
                                                <?php  } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!--upper-->
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <?php

                            if(empty($Emp_id)){

                            }else{
                                $query_card = $conn->query("SELECT * FROM temp_list  WHERE  Emp_id = $Emp_id ");
                              $row_grey = mysqli_fetch_assoc($query_card) ;

                            }
                              
                            if(empty($row_grey['Temp_no'])){ ?>


                                <?php  }else{ ?>
                                    <div class="card">
                                <div class="card-header">
                                    รายการเครื่องมือที่เลือก
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle">
                                            <thead class="table-success">
                                                <tr>
                                                    <th scope="col">No.</th>
                                                    <th scope="col">รูป</th>
                                                    <th scope="col">ชื่อ</th>
                                                    <th scope="col">แบรนด์</th>
                                                    <th scope="col">โมเดล</th>
                                                    <th scope="col">SN</th>
                                                    <th scope="col">ความเสี่ยง</th>
                                                    <th scope="col"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                               
                                            <?php 
                                                    $i_wc = 0 ;
                                                    $Emp_id = $_SESSION['Emp_id'] ;
                                                     $query_tool_wc = $conn->query("SELECT * FROM temp_list INNER JOIN tooldata ON tooldata.ToolId = temp_list.Tool_id WHERE Emp_id =  $Emp_id ");
                                                    while($tool_wc = mysqli_fetch_assoc($query_tool_wc)) {   $i_wc++ ;?>
                                                     <tr >
                                                    <th scope="row"><?php  echo $i_wc ; ?></th>
                                                    <td><img src="../uploads/<?php echo $tool_wc['tool_photo'] ; ?>" alt="Tool picture"></td>
                                                    <td><?php echo $tool_wc['ToolName'] ?></td>
                                                    <td><?php echo $tool_wc['Brand'] ?></td>
                                                    <td><?php echo $tool_wc['Model'] ?></td>
                                                    <td><?php echo $tool_wc['SN'] ?></td>
                                                    <?php
                                                            if ($tool_wc['RiskLevel'] == '1') {
                                                                echo '<td style="color: green;">ความเสี่ยงต่ำ</td>';
                                                            } else if ($tool_wc['RiskLevel'] == '2') {
                                                                echo '<td style="color: gray ;">ความเสี่ยงกลาง</td>';
                                                            } else if ($tool_wc['RiskLevel'] == '3') {
                                                                echo '<td style="color: red;">ความเสี่ยงสูง</td>';
                                                            } else {
                                                                echo '<td style="color: black;">-</td>';
                                                            }
                                                        ?>
                                                        <?php
                                                        
                                                        if(empty($_GET['risk'])){ ?>
                                                            <?php if(empty($_POST['RiskLevel'])){ ?>
                                                               
                                                                <td class="px-3">
                                                                     <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal<?php  echo $tool_wc['Tool_id'] ; ?>" class="btn btn-danger btn-sm" >ลบ</button>
                                                                </td>
                                                                <form action="../borrow/delete_tool.php" method="POST" >
                                                                <div class="modal fade" id="exampleModal<?php  echo $tool_wc['Tool_id'] ; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="exampleModalLabel">ยืนยันการลบเครื่องมือ</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                            <?php echo $tool_wc['ToolName'] ;?>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">ปิด</button>
                                                                                <button type="submit" name="delete_toolid" value="<?php echo $tool_wc['Tool_id'] ;?>" class="btn btn-danger btn-sm">ยืนยันการลบ</button>
                                                                            </div>
                                                                            </div>
                                                                        </div>
                                                                        </div>
                                                            </form>
                                                            <?php } else{?>
                                                               
                                                                
                                                                <td class="px-3">
                                                                     <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal<?php  echo $tool_wc['Tool_id'] ; ?>" class="btn btn-danger btn-sm" >ลบ</button>
                                                                </td>
                                                            
                                                            <form action="../borrow/delete_tool.php?risk=<?php echo $_POST['RiskLevel'] ?>" method="POST" >
                                                            <div class="modal fade" id="exampleModal<?php  echo $tool_wc['Tool_id'] ; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="exampleModalLabel">ยืนยันการลบเครื่องมือ</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                            <?php echo $tool_wc['ToolName'] ;?>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">ปิด</button>
                                                                                <button type="submit" name="delete_toolid" value="<?php echo $tool_wc['Tool_id'] ;?>" class="btn btn-danger btn-sm">ยืนยันการลบ</button>
                                                                            </div>
                                                                            </div>
                                                                        </div>
                                                                        </div>
                                                            </form>
                                                                <?php } ?>
                                                            
                                                        <?php }else{  ?>
                                                          
                                                                 <td class="px-3">
                                                                     <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal<?php  echo $tool_wc['Tool_id'] ; ?>" class="btn btn-danger btn-sm" >ลบ</button>
                                                                </td>
                                                           
                                                            <form action="../borrow/delete_tool.php?risk=<?php echo $_GET['risk'] ; ?>" method="POST" >
                                                            <!-- Button trigger modal -->
                                        
                                                                        <!-- Modal -->
                                                                        <div class="modal fade" id="exampleModal<?php  echo $tool_wc['Tool_id'] ; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="exampleModalLabel">ยืนยันการลบเครื่องมือ</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                            <?php echo $tool_wc['ToolName'] ;?>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">ปิด</button>
                                                                                <button type="submit" name="delete_toolid" value="<?php echo $tool_wc['Tool_id'] ;?>" class="btn btn-danger btn-sm">ยืนยันการลบ</button>
                                                                            </div>
                                                                            </div>
                                                                        </div>
                                                                        </div>
                                                                </form>

                                                            <?php } ?>
                                                        
                                                    </tr>
                                                    <?php } ?>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="borrowBox">
                                        
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#create_list" class="btn btn-success" >ยืนยัน</button>
                                                                        <!-- Modal -->
                                                                        <div class="modal fade" id="create_list" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                
                                                                                <h5 class="modal-title" id="exampleModalLabel">ยืนยันการสร้างใบรายการ</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                    ยืนยันการสร้างใบรายการ
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">ปิด</button>
                                                                                <button type="submit" form="form1" name="add_list" class="btn btn-success" title="ยืนยันรายการขอใช้เครื่องมือ" >ยืนยัน</button>
                                                                            </div>
                                                                            </div>
                                                                        </div>
                                                                        </div>
                                                            

                                        
                                        <?php  if(empty($_GET['risk'])) {  ?>
                                            <?php if(empty($_POST['RiskLevel'])){ ?>

                                                <button type="button" data-bs-toggle="modal" data-bs-target="#deleteall" class="btn btn-danger" >เคลียร์ -1</button>
                                                <!-- <a href="../borrow/delete_tool.php?action=delete_all" class="btn btn-danger" title="ล้างรายการทั้งหมด">เคลียร์</a> -->
                                                <form action="../borrow/delete_tool.php?action=delete_all" method="POST" >
                                                            <!-- Button trigger modal -->
                                                                        <!-- Modal -->
                                                                        <div class="modal fade" id="deleteall" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                
                                                                                <h5 class="modal-title" id="exampleModalLabel">ยืนยันการเคลียร์รายการชั่วคร่าว</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                            <?php $Emp_id = $_SESSION['Emp_id'] ;
                                                                                    $query_tool_wc = $conn->query("SELECT * FROM temp_list INNER JOIN tooldata ON tooldata.ToolId = temp_list.Tool_id WHERE Emp_id =  $Emp_id ");
                                                                                     while($tool_wc = mysqli_fetch_assoc($query_tool_wc)) {   $i_wc++ ;
                                                                                     echo $tool_wc['ToolName'] ;
                                                                                     echo '<br>' ;
                                                                                    } ?>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">ปิด</button>
                                                                                <button type="submit" name="delete_toolid" value="<?php echo $tool_wc['Tool_id'] ;?>" class="btn btn-danger btn-sm">ยืนยันการเคลียร์</button>
                                                                            </div>
                                                                            </div>
                                                                        </div>
                                                                        </div>
                                                                </form>
                                          <?php  }else{ ?>
                                            <!-- <a href="../borrow/delete_tool.php?action=delete_all&risk=<?php  echo $_POST['RiskLevel'] ; ?>" class="btn btn-danger" title="ล้างรายการทั้งหมด"  >เคลียร์ -2</a> -->
                                            <button type="button" data-bs-toggle="modal" data-bs-target="#deleteall" class="btn btn-danger" >เคลียร์ -2</button>
                                            <form action="../borrow/delete_tool.php?action=delete_all&risk=<?php  echo $_POST['RiskLevel'] ; ?>" method="POST" >
                                                            <!-- Button trigger modal -->
                                                                        <!-- Modal -->
                                                                        <div class="modal fade" id="deleteall" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                
                                                                                <h5 class="modal-title" id="exampleModalLabel">ยืนยันการเคลียร์รายการชั่วคร่าว</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                            <?php $Emp_id = $_SESSION['Emp_id'] ;
                                                                                    $query_tool_wc = $conn->query("SELECT * FROM temp_list INNER JOIN tooldata ON tooldata.ToolId = temp_list.Tool_id WHERE Emp_id =  $Emp_id ");
                                                                                     while($tool_wc = mysqli_fetch_assoc($query_tool_wc)) {   $i_wc++ ;
                                                                                     echo $tool_wc['ToolName'] ;
                                                                                     echo '<br>' ;
                                                                                    } ?>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">ปิด</button>
                                                                                <button type="submit" name="delete_toolid" value="<?php echo $tool_wc['Tool_id'] ;?>" class="btn btn-danger btn-sm">ยืนยันการเคลียร์</button>
                                                                            </div>
                                                                            </div>
                                                                        </div>
                                                                        </div>
                                                                </form>
                                           <?php } ?>
                                            
                                            <?php }else{  ?>
                                            <!-- <a href="../borrow/delete_tool.php?action=delete_all&risk=<?php  echo $_GET['risk'] ; ?>" class="btn btn-danger" title="ล้างรายการทั้งหมด" >เคลียร์-3</a> -->
                                            <button type="button" data-bs-toggle="modal" data-bs-target="#deleteall" class="btn btn-danger" >เคลียร์ -3</button>
                                            <form action="../borrow/delete_tool.php?action=delete_all&risk=<?php  echo $_GET['risk'] ; ?>" method="POST" >
                                                            <!-- Button trigger modal -->
                                                                        <!-- Modal -->
                                                                        <div class="modal fade" id="deleteall" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                
                                                                                <h5 class="modal-title" id="exampleModalLabel">ยืนยันการเคลียร์รายการชั่วคร่าว</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                            <?php $Emp_id = $_SESSION['Emp_id'] ;
                                                                                    $query_tool_wc = $conn->query("SELECT * FROM temp_list INNER JOIN tooldata ON tooldata.ToolId = temp_list.Tool_id WHERE Emp_id =  $Emp_id ");
                                                                                     while($tool_wc = mysqli_fetch_assoc($query_tool_wc)) {   $i_wc++ ;
                                                                                     echo $tool_wc['ToolName'] ;
                                                                                     echo '<br>' ;
                                                                                    } ?>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">ปิด</button>
                                                                                <button type="submit" name="delete_toolid" value="<?php echo $tool_wc['Tool_id'] ;?>" class="btn btn-danger btn-sm">ยืนยันการเคลียร์</button>
                                                                            </div>
                                                                            </div>
                                                                        </div>
                                                                        </div>
                                                                </form>
                                            <?php  }  ?>
                                       
                                    </div>
                                </div>
                            </div>

                                     <?php  } ?> <!--card-hidden -->
                            
                            
                            


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>
<?php
if(isset($_SESSION['repeat_tool'])){
    unset($_SESSION['repeat_tool']) ;
}
if(isset($_SESSION['datewrong'])){
    unset($_SESSION['datewrong']) ;
}
if(isset($_SESSION['add_tool'])){
    unset($_SESSION['add_tool']) ;
}
if(isset($_SESSION['delete_tool'])){
    unset($_SESSION['delete_tool']) ;
}


?>