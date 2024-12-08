<?php include 'layout/head.php' ?>
<style>
    input[type="password"]::-ms-reveal,
    input[type="password"]::-ms-clear {
        display: none;
    }

    body, html {
        margin: 0;
        padding: 0;
        height: 100%;
        overflow: auto; /* ป้องกันไม่ให้ SweetAlert เปลี่ยนพฤติกรรมการเลื่อน */
    }
    /*.login-logo {*/
    /*    width: 100%;*/
    /*    max-width: 300px;*/
    /*    height: auto;*/
    /*    display: flex;*/
    /*    justify-content: center;*/
    /*    align-items: center;*/
    /*    overflow: hidden;*/
    /*}*/

    /*.login-logo img {*/
    /*    max-width: 100%;*/
    /*    height: auto;*/
    /*    object-fit: contain;*/
    /*    image-rendering: -webkit-optimize-contrast;*/
    /*}*/
</style>
<body class="login-page">
<div class="login-box">
    <div class="login-box-body m-1" style="background-color: white;padding-right: 20px;padding-left: 20px;padding-top: 20px">
        <div class="login-logo">
            <img width="300px" src="images/Motowork_logo_300px.png">
        </div>
        <form id="loginForm">
            <div class="form-group has-feedback" style="position: relative;">
                <input type="text" name="username" id="username" class="form-control" placeholder="ชื่อผู้ใช้" required autofocus autocomplete="off"
                       style="padding-right: 30px;" />
                <span class="fa fa-user form-control-feedback" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); color: gray;"></span>
            </div>
            <div style="position: relative;">
                <input type="password" name="password" id="password" class="form-control" placeholder="รหัสผ่าน"
                       style="padding-right: 40px;" />
                <span class="fa fa-eye-slash toggle-password"
                      style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer; color: gray;"></span>
            </div>
            <div class="row form-group mt-3">
                <div class="col-xs-12 col-12">
                    <button type="submit" class=" form-control btn btn-danger text-white" style="width: 100%;background-color: #A51005;border-color: #A51005">เข้าสู่ระบบ</button>
                </div>
            </div>
        </form>
        <br/>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.min.js"></script>
<?php
session_start();
session_unset();
session_destroy();
?>
<script>
    localStorage.removeItem('page');
    localStorage.clear();
    // window.location.href = '/login';
</script>
<script>
    $('.toggle-password').on('click', function () {
        const passwordInput = $('#password');
        const isPassword = passwordInput.attr('type') === 'password';
        passwordInput.attr('type', isPassword ? 'text' : 'password');

        // เปลี่ยนไอคอน
        $(this).toggleClass('fa-eye fa-eye-slash');
    });

    $(function () {

        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%'
        });

        // Handle form submission with jQuery
        $('#loginForm').submit(function (e) {
            e.preventDefault();
            const formData = {
                username: $('#username').val(),
                password: $('#password').val()
            };

            // Send data via AJAX
            $.ajax({
                url: 'controller/authen/checklogin.php',
                type: 'POST',
                data: formData,
                success: function (response) {
                    let status = response.status;
                    let message = response.message;

                    if (status === 'success') {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: "เข้าสู่ระบบสำเร็จ",
                            showConfirmButton: false,
                            timer: 1000
                        });
                        setTimeout(function (){
                            window.location.href = response.redirect
                        },1500)
                    } else {
                        Swal.fire({
                            title: "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง",
                            // text: "โปรดตรวจสอบชื่อผู้ใช้และรหัสผ่าน !",
                            icon: "warning",
                            showCancelButton: false,
                            iconColor: "#A51005",
                            confirmButtonColor: "#A51005",
                            customClass: {
                                confirmButton: 'no-border-button' // เพิ่มคลาสนี้
                            },
                            // cancelButtonColor: "#d33",
                            confirmButtonText: "ดำเนินการต่อ"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload()
                            }
                        });
                        // $('#alert-error').removeClass('hidden');
                    }


                }
            });
        });
    });
</script>
</body>
</html>
