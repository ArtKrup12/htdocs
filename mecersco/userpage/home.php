<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
    include('../auth/auth_login.php') ;
    include('../database_connect/conn.php') ;

    $Emp_id = $_SESSION['Emp_id'] ;
    $query_Emp_name = $conn->query ( "SELECT * FROM emphss7 INNER JOIN prefix ON prefix.Prefix_id = emphss7.Prefix_id WHERE Emp_id = $Emp_id " ) ;
    $query_Emp = mysqli_fetch_assoc($query_Emp_name) ;


    ?>

<?php $_SESSION['auth_user'] =  $query_Emp['Prefix_name'].$query_Emp['Emp_name'].' '.$query_Emp['Emp_lastname'] ;

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
    <link href="../bootstrap_css/bootstrap.css" rel="stylesheet">
    <link href="../css/user.css" rel="stylesheet">
</head>

<body>
    
<?php  include('../notification/noti.php'); ?>
    <?php  //เข้าสู่ระบบสำเร็จ  
    if(isset($_SESSION['login_complete'])) : ?>
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
        title: 'เข้าสู่ระบบสำเร็จ'
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
                <li class="active"><i class="fa-solid fa-house"></i><button class="menu_list"
                        onclick="location.href='home'">หน้าหลัก</button></li>
                <li><i class="fa-solid fa-toolbox"></i><button class="menu_list"
                        onclick="location.href='borrow'">ยืมเครื่องมือ</button></li>
                <li><i class="fa-solid fa-file"></i><button class="menu_list"
                        onclick="location.href='status'">ติดตามสถานะ</button></li>
                <?php
                   if($_SESSION['Role']== 'app'){  ?>
                <li><i class="fa-solid fa-clipboard-check"></i><button class="menu_list"
                        onclick="location.href='confirm'">คำขอรอยืนยัน</button></li>
                <?php include('../query_database/query_noti.php') ; ?>
                <div class="notification"><span><?php echo $noticount ;  ?></span></div>
                <?php }else{  ?>

                <?php  }  ?>

                <li><i class="fa-solid fa-folder-open"></i><button class="menu_list"
                        onclick="location.href='history'">ประวัติ</button></li>
                <li><i class="fa-solid fa-user-gear"></i><button class="menu_list"
                        onclick="location.href='setting'">ข้อมูลส่วนตัว</button></li>
            </ul>
        </div>
        <div class="sbottom">
            <div class="username_group">
                <img class="user_pic" src="../uploads/hss7.png"></img>
                <p class="logout_active">
                    <?php  echo $query_Emp['Prefix_name'].$query_Emp['Emp_name'].' '.$query_Emp['Emp_lastname']?><i
                        class="fa-solid fa-caret-down mx-2"></i></p>
            </div>
            <a class="logout_btn" href="../logout">ออกจากระบบ</a>
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
                <li><i class="fa-solid fa-house"></i><button class="menu_list"
                        onclick="location.href='home'">หน้าหลัก</button></li>
                <li><i class="fa-solid fa-toolbox"></i><button class="menu_list"
                        onclick="location.href='borrow'">ยืมเครื่องมือ</button></li>
                <li><i class="fa-solid fa-file"></i><button class="menu_list"
                        onclick="location.href='status'">ติดตามสถานะ</button></li>
                <?php
                   if($_SESSION['Role']== 'app'){  ?>
                <li><i class="fa-solid fa-clipboard-check"></i><button class="menu_list"
                        onclick="location.href='confirm'">คำขอรอยืนยัน</button></li>
                <?php include('../query_database/query_noti.php') ; ?>
                <div class="notification"><span><?php echo $noticount ;  ?></span></div>
                <?php }else{  ?>

                <?php  }  ?>
                <li><i class="fa-solid fa-folder-open"></i><button class="menu_list"
                        onclick="location.href='history'">ประวัติ</button></li>
                <li id="info_toggle"><i class="fa-solid fa-user"></i><button
                        class="menu_list"><?php echo $_SESSION['auth_user'] ; ?><i
                            class="fa-solid fa-caret-down mx-2"></i></button>
                </li>
                <ul class="info_menu_list">
                    <li><i class="fa-solid fa-user-gear"></i><button class="menu_list"
                            onclick="location.href='setting'">ข้อมูลผู้ใช้</button></li>
                    <li><i class="fa-solid fa-door-open"></i><a class="logout_btn" href="../logout">ออกจากระบบ</a></li>
                </ul>
            </ul>
        </div>
        <script src="../js/user.js"></script>
    </nav>

    <main>
        <div class="chartsBox">
            <canvas id="myChart"></canvas>
        </div>


    </main>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
    const ctx = document.getElementById('myChart');


    // const longLabels = ['Electrical Safety Analyzer', 'Digital Thermometer', '50 Mg- 200 G Weights', '50 Mg- 500 Mg Weights', 'Optical Techometer', 'Flow Meter Tester'];
    // const labsAdjusted = longLabels.map(label => label.split(' '));
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['DATA', 'DATA', 'DATA', 'DATA', 'DATA', 'DATA'],
            datasets: [{
                label: 'ความถี่การใช้งาน',
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 205, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(201, 203, 207, 0.2)'
                ],
                borderColor: [
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(54, 162, 235)',
                    'rgb(153, 102, 255)',
                    'rgb(201, 203, 207)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    </script>


</body>

</html>
<?php include('../notification/unset.php') ;?>