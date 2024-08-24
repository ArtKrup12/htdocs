<?php

    include('../mecersco/database_connect/conn.php') ;
    include('query_database/query_login.php') ;
    include('auth/auth_login.php') ;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ระบบขอใช้เครื่องมือมาตรฐานสอบเทียบทางการแพทย์ ศบส.7</title>
    <link rel="shortcut icon" type="image/x-icon" href="assets/favicon.ico" />

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

    <!-- SweatAlert2 -->
    <script src="node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="node_modules/sweetalert2/dist/sweetalert2.min.css">

    <!-- <script src="../js/bootstrap.bundle.min.js" ></script> -->


    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="fontawesome-free-6.2.1-web/css/all.min.css">

    <!-- Styles -->
    <link href="bootstrap_css/bootstrap.css" rel="stylesheet">
    <link href="css/login.css" rel="stylesheet">
</head>

<body>

    <?php
    include('notification/noti.php');
    ?>
    <nav class="navbar navbar-expand-md navbar-light bg-hss7 shadow-sm">
        <div class="">
            <a class="logohss7" href="login.html">
                <img src="assets/logohss7.png" alt="Logo_HSS7" class="logo_logohss7">
            </a>
        </div>
    </nav>
    <main class="mt-5">
        <div class="my_container">
            <div>
                <img src="assets/logo_mecers.png" alt="Logo_mecers" class="login_logo">
                <div class="mecers_name">
                    <h3><b>ระบบขอใช้เครื่องมือมาตรฐานสอบเทียบทางการแพทย์ ศบส.7</b></h3>
                    <h4 class="eng_name">Medical Calibration Standard Equipment Request System Health Service Support
                        Center 7</h4>
                    <p>(MeCERS : เวอร์ชั่น 2.0 Build : 10072565)</p>
                </div>
            </div>
            <form  method="POST" class="card">
                <div class="login_text">เข้าสู่ระบบ</div>
                <div class="login_form">
                    <i class="fa-solid fa-user" id="logo-input"></i>
                    <select type="text" class="input" id="username" name="Emp_id" placeholder="Username">
                        <option disabled selected>เลือกชื่อผู้ใช้งาน</option>
                        <?php

                            while($row = mysqli_fetch_assoc($query_emphss7)){
                            echo  '<option value="'.$row['Emp_id'].'">'.$row['Prefix_name'].$row['Emp_name']." ".$row['Emp_lastname'].'</option>' ; 

                        }?>
                    </select>
                </div>
                <div class="login_form">
                    <i class="fa-solid fa-lock" id="logo-input"></i>
                    <input type="password" class="input" id="password" placeholder="Password" name="Emp_pass">
                </div>
                <div class="login_btn">
                    <button type="submit" name="login" class="btn btn-success" >ล็อคอิน</button>
                    <button class="btn btn-danger">เคลียร์</button>
                </div>
            </form>
            <?php
            if(empty($_POST['Emp_id'])){ ?>

            <?php }else{ 

                
                $Emp_id = $_POST['Emp_id'] ;
                $Emp_pass = $_POST['Emp_pass'] ;
                $query_Role = $conn->query ( "SELECT * FROM emphss7 WHERE Emp_id = '$Emp_id'");
                $Role = mysqli_fetch_assoc($query_Role) ;

                $role = $Role['Role'] ;
                if($role == 'user' || $role == 'app' ){ 
                    header("location:login/login_db.php?Emp_id=$Emp_id&&Emp_pass=$Emp_pass") ;
                  } else{    
                    if($Emp_pass != $Role['Emp_pass']){ 
                        $wrong = 'err_password' ;
                        header("location:login/repage.php?check=$wrong") ;
                         }else{ ?>
                        <script>
                    $(document).ready(function(){
                    $("#modeModal").modal('show');
                    
                     });
                    </script>

                    <!-- Modal Detail-->
        <div class="modal fade" id="modeModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-di alog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">ADMIN</h5>
                        <form action="login/repage.php">
                        <button type="submit"  class="btn-close" data-bs-dismiss="modal"></button>
                        </form>
                    </div>
                    <div class="modal-body px-4">
                        <span class="d-flex justify-content-center">
                            <h3>คุณเข้าสู่ระบบในฐานะ "ผู้ดูแลระบบ"
                                กรุณาเลือกโหมดที่ต้องการเข้าใช้งาน
                            </h3>
                        </span>

                        <div class="modeContainer row">
                            <!-- <form action="login/loginmode_db.php" method="POST">
                            <input type="hidden" name="Emp_id" value="<?php echo $Emp_id ;?>" >
                            <input type="hidden" name="Emp_pass" value="<?php echo $Emp_pass ;?>" >
                            <button class="col-12 col-sm-12 col-md-12 col-lg-4 modeBtn" value="user_mode" type="submit" name="mode">
                                <div class="modeBox modeUser">
                                    <i class="fa-solid fa-user-plus modeIcon" id="fix1"></i>
                                    <div class="modeText">
                                        <span>หน้า USER</span>
                                    </div>
                                </div>
                            </button>
                            </form> -->
                            <form action="login/loginmode_db.php" method="POST">
                            <input type="hidden" name="Emp_id" value="<?php echo $Emp_id ;?>" >
                            <input type="hidden" name="Emp_pass" value="<?php echo $Emp_pass ;?>" >
                            <button class="col-12 col-sm-12 col-md-12 col-lg-4 modeBtn" value="admin_mode" type="submit" name="mode">
                                <div class="modeBox modeAdmin">
                                    <i class="fa-solid fa-user-gear modeIcon" id="fix2"></i>
                                    <div class="modeText">
                                        <span>หน้า ADMIN</span>
                                    </div>
                                </div>
                            </button>
                            </form>

                            <form action="login/loginmode_db.php" method="POST">
                            <input type="hidden" name="Emp_id" value="<?php echo $Emp_id ;?>" >
                            <input type="hidden" name="Emp_pass" value="<?php echo $Emp_pass ;?>" >
                            <button class="col-12 col-sm-12 col-md-12 col-lg-4 modeBtn" value="phpMyadmin_mode" type="submit" name="mode">
                                <div class="modeBox modeDatabase">
                                    <i class="fa-brands fa-php modeIcon" id="fix3"></i>
                                    <div class="modeText">
                                        <span>หน้า DATABASE</span>
                                    </div>
                                </div>
                            </button>
                            </form>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <form action="login/repage.php">
                        <button type="submit"  class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
                        <?php } ?>
              <?php  } ?>
                
                
        
            <?php } ?>
                
            
        </div>
    </main>
</body>

</html>

<?php

include('notification/unset.php') ;

?>