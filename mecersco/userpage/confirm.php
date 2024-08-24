<?php


include('../auth/auth_login.php') ;
include('../database_connect/conn.php') ;


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
    <div class="sidebar p-3">
        <div class="shead">
            <img class="logo_mecser" src="../assets/logo_mecers.png" alt="logo_mecser">
            <h4 class="mecser" id="mecser_th_name">ระบบขอใช้เครื่องมือมาตรฐานสอบเทียบทางการแพทย์</h4>
            <span class="mecser" id="hss7_name">ศูนย์สนับสนุนบริการสุขภาพที่ 7</span>
        </div>
        <div class="sbody">
            <ul>
                <li><i class="fa-solid fa-house"></i><button class="menu_list" onclick="location.href='home'">หน้าหลัก</button></li>
                <li><i class="fa-solid fa-toolbox"></i><button class="menu_list" onclick="location.href='borrow'">ยืมเครื่องมือ</button></li>
                <li><i class="fa-solid fa-file"></i><button class="menu_list" onclick="location.href='status'">ติดตามสถานะ</button></li>
                <?php
                   if($_SESSION['Role']== 'app'){  ?>
                         <li  class="active" ><i class="fa-solid fa-clipboard-check"></i><button class="menu_list" onclick="location.href='confirm'">คำขอรอยืนยัน</button></li>
                <?php }else{  ?>

                <?php  }  ?>
                <li><i class="fa-solid fa-folder-open"></i><button class="menu_list" onclick="location.href='history'">ประวัติ</button></li>
                <li><i class="fa-solid fa-user-gear"></i><button class="menu_list" onclick="location.href='setting'">ข้อมูลส่วนตัว</button></li>
            </ul>
        </div>
        <div class="sbottom">
            <div class="username_group">
            <img class="user_pic" src="../uploads/hss7.png"></img>
                <p class="logout_active"><?php echo $_SESSION['auth_user'] ; ?><i class="fa-solid fa-caret-right mx-2"></i></p>
            </div>
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
                         <li><i class="fa-solid fa-file"></i><button class="menu_list" onclick="location.href='confirm'">คำขอรอยืนยัน</button></li>
                <?php }else{  ?>

                <?php  }  ?>
                <li><i class="fa-solid fa-folder-open"></i><button class="menu_list" onclick="location.href='history'">ประวัติ</button></li>
                <li id="info_toggle"><i class="fa-solid fa-user"></i><button class="menu_list"><?php echo $_SESSION['auth_user'] ; ?><i
                            class="fa-solid fa-caret-down mx-2"></i></button>
                </li>
                <ul class="info_menu_list">
                    <li><i class="fa-solid fa-user-gear"></i><button class="menu_list"  onclick="location.href='setting'">ข้อมูลผู้ใช้</button></li>
                    <li><i class="fa-solid fa-door-open"></i> <a  class="logout_btn" href="../logout">ออกจากระบบ</a></li>
                </ul>
            </ul>
        </div>
        <script src="../js/user.js"></script>
    </nav>

    <main>
        <div class="historyBox">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5>คำขอรออนุมัติ</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive-lg">
                        <?php
                         $query_list_table = $conn->query("SELECT List_id FROM list WHERE List_status != 'return_complete'  ");
                         $no_data= mysqli_fetch_assoc($query_list_table) ;  
                           if(!empty($no_data['List_id'])) {  ?>
                            <table class="table table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">No.</th>
                                        <th scope="col">สถานที่</th>
                                        <th scope="col">วันที่ยืม</th>
                                        <th scope="col">วันที่คืน</th>
                                        <th scope="col">ผู้ขอใช้</th>
                                        <th scope="col">ผู้อนุมัติ</th>
                                        <th scope="col">สถานะ</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php  

                                        $query_list = $conn->query("SELECT * FROM list INNER JOIN  emphss7 ON emphss7.Emp_id = list.Emp_id WHERE List_status = 'wait_app' OR List_status = 'app_return'");
                                        $Num_Rows = mysqli_num_rows($query_list) ;

                                        $Per_Page = 5;
                                        if(empty($_GET['Page'])){
                                            $Page = 1 ;
                                        }else{

                                            $Page = $_GET["Page"];
                                        }
                                       

                                        if(empty($_GET['Page'])){
                                            $Page=1;
                                        }

                                        $Prev_Page = $Page-1;
                                        $Next_Page = $Page+1;

                                        $Page_Start = (($Per_Page*$Page)-$Per_Page);

                                        if($Num_Rows<=$Per_Page){
                                            $Num_Pages =1;

                                        } else if(($Num_Rows % $Per_Page)==0){

                                            $Num_Pages =($Num_Rows/$Per_Page) ;
                                        } else {
                                            
                                            $Num_Pages =($Num_Rows/$Per_Page)+1;
                                            $Num_Pages = (int)$Num_Pages;
                                        }
                                    
                                        $query_list_page = $conn->query("SELECT * FROM list INNER JOIN  emphss7 ON emphss7.Emp_id = list.Emp_id WHERE List_status = 'wait_app' OR List_status = 'app_return' order  by List_id ASC LIMIT $Page_Start , $Per_Page " );
                                    ?>
                                    <?php 
                                    $i = 0 ;
                                    while($list = mysqli_fetch_assoc($query_list_page) ) { $i++ ;?>
                                    <tr>
                                        <th scope="row"><?php echo $i ; ?></th>
                                        <td><?php echo $list['Hospital'] ?></td>
                                        <td>
                                        <?php
                                                    $orgDate = $list['Date_use'];
                                                    $newDate = date("d/m/Y", strtotime($orgDate));
                                                    echo $newDate ;
                                        ?>  
                                        </td>
                                        <td>
                                        <?php
                                                    $orgDate = $list['Date_return'];
                                                    $newDate = date("d/m/Y", strtotime($orgDate));
                                                    echo $newDate ;
                                        ?>  
                                        </td>
                                        <td><?php echo $list['Emp_name'].' '.$list['Emp_lastname'] ?></td>
                                        <td>
                                        <?php
                                        if($list['app_id'] == 0){ ?>

                                           -

                                        <?php   }else if($list['app_id'] != 0){ ?>

                                            <?php  
                                            $App = $list['app_id'] ;
                                                 $query_app = $conn->query("SELECT * FROM emphss7 WHERE Emp_id =  $App" );
                                                 $Appname = mysqli_fetch_assoc($query_app) ;

                                                 echo $Appname['Emp_name'].' '.$Appname['Emp_lastname'] ;
                                            ?>

                                        <?php } ?>
                                        </td>
                                        <?php
                                        if($list['List_status'] == 'wait_app'){ ?>

                                            <td class="status_yellow">ยืม - รอการอนุมัติ</td>

                                        <?php   }else if($list['List_status'] == 'wait_app_return'){ ?>

                                            <td class="status_green">ยืม - อนุมัติแล้ว</td>

                                        <?php }else if($list['List_status'] == 'app_return'){ ?>

                                             <td class="status_red">
                                                 คืน - รอการอนุมัติ
                                            </td>

                                        <?php } ?>
                                        <td>
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#detailModal<?php echo $list['List_id']?>"><i class="fa-solid fa-eye"></i></button>
                                        <!-- Modal Detail-->
        <div class="modal fade" id="detailModal<?php echo $list['List_id']?>" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">รายละเอียดการขอใช้เครื่องมือ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-4">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 py-2 mb-3 copyCard colorWhite">
                            <div class="mb-1">
                                <span class="colorBlack">เลขที่ :</span>
                                <span><?php echo $list['List_id']?></span>
                            </div>
                            <div class="mb-1">
                                <span class="colorBlack">วันที่ขอใช้ :</span>
                                <span> <?php
                                                    $orgDate = $list['Date_use'];
                                                    $newDate = date("d/m/Y", strtotime($orgDate));
                                                    echo $newDate ;
                                        ?>  </span>
                            </div>
                            <div class="mb-1">
                                <span class="colorBlack">วันที่ต้องคืน :</span>
                                <span> <?php
                                                    $orgDate = $list['Date_return'];
                                                    $newDate = date("d/m/Y", strtotime($orgDate));
                                                    echo $newDate ;
                                        ?>  </span>
                            </div>
                            <div class="mb-1">
                                <span class="colorBlack">สถานที่ :</span>
                                <span><?php echo $list['Hospital'] ?></span>
                            
                            </div>
                            <div class="mb-1">
                                <span class="colorBlack">ผู้ขอใช้ :</span>
                                <span><?php echo $list['Emp_name'].' '.$list['Emp_lastname'] ?></span>
                            </div>
                            <div class="mb-1">
                                <span class="colorBlack">ผู้อนุมัติ :</span>
                                <span> <?php
                                        if($list['app_id'] == 0){ ?>

                                           -

                                        <?php   }else if($list['app_id'] != 0){ ?>

                                            <?php  
                                            $App = $list['app_id'] ;
                                                 $query_app = $conn->query("SELECT * FROM emphss7 WHERE Emp_id =  $App" );
                                                 $Appname = mysqli_fetch_assoc($query_app) ;

                                                 echo $Appname['Emp_name'].' '.$Appname['Emp_lastname'] ;
                                            ?>

                                        <?php } ?></span>
                            </div>
                           
                            <?php
                                        if($list['List_status'] == 'wait_app'){ ?>

                                            <div class="mb-1">
                                <span class="colorBlack">สถานะ :</span>
                                <span class="status_yellow">ยืม - รอการอนุมัติ</span>
                            </div>

                                        <?php   }else if($list['List_status'] == 'wait_app_return'){ ?>
                                            <div class="mb-1">
                                            <span class="colorBlack">สถานะ :</span>
                                <span class="status_green">ยืม - อนุมัติแล้ว</span>
                            </div>

                                        <?php }else if($list['List_status'] == 'app_return'){ ?>

                                            <div class="mb-1">
                                <span class="colorBlack">สถานะ :</span>
                                <span class="status_red">คืน - รอการอนุมัติ</span>
                            </div>

                                        <?php } ?>
                               
                           
                           
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                            <div class="card">
                                <div class="card-header">
                                    <span>รายการเครื่องมือที่ขอใช้</span>
                                </div>
                                <div class="card-body p-0">
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
                                                    <th scope="col">หมายเหตุ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php  
                                                $i_loop = 0 ;
                                                $listid = $list['List_id'] ;
                                                    $query_tool_list_detail = $conn->query("SELECT * FROM list_detail INNER JOIN tooldata ON list_detail.Tool_id = tooldata.ToolId WHERE List_id =  $listid " );
                                                    while($data_tool = mysqli_fetch_assoc( $query_tool_list_detail)) { 
                                                        $i_loop++ ;
                                                ?>
                                                <tr>
                                                    <th scope="row"><?php echo $i_loop; ?></th>
                                                    <td><img src="../uploads/<?php echo $data_tool['tool_photo'] ; ?>" alt="Tool picture"></td>
                                                    <td><?php echo $data_tool['ToolName'] ; ?></td>
                                                    <td><?php echo $data_tool['Brand'] ; ?></td>
                                                    <td><?php echo $data_tool['Model'] ; ?></td>
                                                    <td><?php echo $data_tool['SN'] ; ?></td>
                                                    <td><?php echo $data_tool['note_listdetail'] ; ?></td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    </div>
                </div>
            </div>
        </div>
                                            <!-- modal 249 - 387 -->
                                        <?php
                                        if($list['List_status'] == 'wait_app'){ ?>

                                           <?php
                                             if($_SESSION['Emp_id'] == $list['Emp_id']){ ?>
                                                  <button class="btn btn-secondary">ยืนยัน</button>
                                            <?php }else{ ?>
                                                <form action="../confirm/confirm_borow.php" method="POST">
                                                  <button type="submit" name="app_borrow" value="<?php echo $list['List_id'] ?>" class="btn btn-success">ยืนยัน</button>
                                                </form>
                                            <?php } ?>
                                        <?php }else if($list['List_status'] == 'app_return'){ ?>

                                            <?php
                                             if($_SESSION['Emp_id'] == $list['Emp_id']){ ?>
                                                  <button class="btn btn-secondary">ยืนยัน</button>
                                            <?php }else{ ?>
                                                <form action="../confirm/return_app.php" method="POST">
                                                  <button type="submit" name="return_app" value="<?php echo $list['List_id'] ?>" class="btn btn-success">ยืนยัน</button>
                                                </form>
                                            <?php } ?>

                                        <?php } ?>

                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>

                        <?php }else{  ?>

                            <i>
                                    <center>
                                        <font color="red">
                                            *ไม่มีรายการขออนุมัติใช้เครื่องมือในขณะนี้*
                                        </font>
                                    </center>
                           </i>

                        <?php  }  ?>
                          
                        </div>
                        <div class="gobackBox">
                        <!-- Total <?php echo $Num_Rows;?> Record : <?php echo $Num_Pages;?> Page : -->
                        <?php

                        if(!empty($no_data['List_id'])){
                            $class = 'class="btn btn-primary btn-sm"' ;
                            $class_number = 'class="btn btn-secondary btn-sm"' ;
                            $back = '<i class="fa-solid fa-angle-left"></i>' ;
                            $next = '<i class="fa-solid fa-angle-right"></i>' ;
 
                            if($Prev_Page){
                                echo " <a $class href='$_SERVER[SCRIPT_NAME]?Page=$Prev_Page' >$back</a> ";
                            }
                            for($i=1; $i<=$Num_Pages; $i++){
                                if($i != $Page){ 
                                     echo "<a  $class_number href='$_SERVER[SCRIPT_NAME]?Page=$i'>$i</a> ";  
                                }else{
                                    echo "<b  $class > $i </b>";
                                }
                            }
       
                            if($Page!=$Num_Pages){
                                echo " <a $class href ='$_SERVER[SCRIPT_NAME]?Page=$Next_Page'>$next</a> ";
                            }

                        }else{

                        }   
                        ?>
                            
                            <!-- <button class="btn btn-primary btn-sm" title="ย้อนกลับ"><i class="fa-solid fa-angle-left"></i></button>
                            <button class="btn btn-secondary btn-sm" title="หน้า 1">1</button>
                            <button class="btn btn-secondary btn-sm" title="หน้า 2">2</button>
                            <button class="btn btn-secondary btn-sm" title="หน้า 3">3</button>
                            <button class="btn btn-primary btn-sm" title="ถัดไป"><i class="fa-solid fa-angle-right"></i></button> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>