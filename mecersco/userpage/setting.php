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
    <script src="node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="../node_modules/sweetalert2/dist/sweetalert2.min.css">

    <script src="../js/bootstrap.bundle.min.js" ></script>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../fontawesome-free-6.2.1-web/css/all.min.css">

    <!-- Styles -->
    <link href="../bootstrap_css/bootstrap.css" rel="stylesheet">
    <link href="../css/user.css" rel="stylesheet">
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
                         <li><i class="fa-solid fa-clipboard-check"></i><button class="menu_list" onclick="location.href='confirm'">คำขอรอยืนยัน</button></li>
                         <?php include('../query_database/query_noti.php') ; ?>
                         <div class="notification"><span><?php echo $noticount ;  ?></span></div>
                <?php }else{  ?>

                <?php  }  ?>
                <li><i class="fa-solid fa-folder-open"></i><button class="menu_list" onclick="location.href='history'">ประวัติ</button></li>
                <li class="active"><i class="fa-solid fa-user-gear"></i><button class="menu_list" onclick="location.href='setting'">ข้อมูลส่วนตัว</button></li>
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
                         <li><i class="fa-solid fa-clipboard-check"></i><button class="menu_list" onclick="location.href='confirm'">คำขอรอยืนยัน</button></li>
                         <?php include('../query_database/query_noti.php') ; ?>
                         <div class="notification"><span><?php echo $noticount ;  ?></span></div>
                <?php }else{  ?>

                <?php  }  ?>
                <li><i class="fa-solid fa-folder-open"></i><button class="menu_list" onclick="location.href='history'">ประวัติ</button></li>
                <li id="info_toggle"><i class="fa-solid fa-user"></i><button class="menu_list"><?php echo $_SESSION['auth_user'] ; ?><i
                            class="fa-solid fa-caret-down mx-2"></i></button>
                </li>
                <ul class="info_menu_list">
                    <li><i class="fa-solid fa-user-gear"></i><button class="menu_list" onclick="location.href='setting'">ข้อมูลผู้ใช้</button></li>
                    <li><i class="fa-solid fa-door-open"></i><a  class="logout_btn" href="../logout">ออกจากระบบ</a></li>
                </ul>
            </ul>
        </div>
        <script src="../js/user.js"></script>
    </nav>

    <main>
        <div class="profileBox">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5>ข้อมูลส่วนตัว</h5>
                    </div>

                    <?php 
                            $Emp_id = $_SESSION['Emp_id'] ;
                        $query_emphss7 = $conn->query ( "SELECT * FROM emphss7 INNER JOIN prefix ON prefix.Prefix_id = emphss7.Prefix_id WHERE Emp_id = '$Emp_id'" ) ;
                        $row = mysqli_fetch_assoc($query_emphss7) ;

                    ?>
                    <div class="card-body px-4">
            <form action="../setting/edit_profile.php" method="POST" >
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-2 mb-3 text-start">
                                <span>คำนำหน้า: </span>
                                <input type="text" class="form-control" placeholder="<?php echo $row['Prefix_name'] ?>" disabled>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-5 mb-3 text-start">
                                <span>ชื่อ: </span>
                                <input type="text" class="form-control" placeholder="<?php echo $row['Emp_name'] ?>" disabled>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-5 mb-3 text-start">
                                <span>นามสกุล: </span>
                                <input type="text" class="form-control" placeholder="<?php echo $row['Emp_lastname'] ?>" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-6 mb-3 text-start">
                                <span>โทรศัพท์: </span>
                                <input type="text" maxlength="10" class="form-control onlynumber" name="Tel" value="<?php echo $row['Tel'] ?>" placeholder="<?php echo $row['Tel'] ?>">
                                <script type="text/javascript">
                                                    function input(inputclass, filter) {
                                                        for (var i = 0; i < inputclass.length; i++) {
                                                            ["input"].forEach(function(event) {
                                                                inputclass[i].addEventListener(
                                                                    event,
                                                                    function() {
                                                                        if (!filter(this
                                                                                .value)) {
                                                                            this.value = "";
                                                                        }
                                                                    });
                                                            });
                                                        }
                                                    }
                                                    input(document.getElementsByClassName("onlynumber"),
                                                        function(value) {
                                                            return /^-?\d*$/.test(value);
                                                        });
                                                </script>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-6 mb-3 text-start">
                                <span>อีเมล: </span>
                                <input type="text" class="form-control" name="Email" value="<?php echo $row['Email'] ?>" placeholder="<?php echo $row['Email'] ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3 text-start">
                                <span>สิทธิ์ผู้ใช้งาน: </span>
                                <input type="text" class="form-control" placeholder="<?php if($row['Role'] == 'user'){
                                    echo 'ผู้ใช้งานระบบ';

                                }else{
                                    echo 'ผู้มีสิทธิ์อนุมัติ';
                                }
                                    ?>" disabled>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="btnBox mt-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#changePasswordModal">เปลี่ยนรหัสผ่าน</button>
                    <button type="submit" name="editprofile" class="btn btn-success mx-1">อัพเดต</button>
                </div>
            </form>
            </div>
        </div>
        <!--  -->
        <!-- Modal -->
        <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <form action="../setting/repass.php" method="POST">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">เปลี่ยนรหัสผ่าน</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-4">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                            <label for="newPass" class="mb-1">รหัสผ่านใหม่ : </label>
                            <input type="text" name="newPass" class="form-control" placeholder="ระบุรหัสผ่านใหม่" required>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                            <label for="newRePass" class="mb-1">ยืนยันรหัสผ่านใหม่ : </label>
                            <input type="text" name="newRePass" class="form-control" placeholder="ระบุรหัสผ่านใหม่อีกครั้ง" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                        <button type="submit" name="repass" class="btn btn-primary">บันทึก</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
            <!--  -->

    </main>
</body>

 
</html>