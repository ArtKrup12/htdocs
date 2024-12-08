<?php
include '../../config/connect.php';
session_start();
$role_user_login = $_SESSION['member_type'];

if (isset($_POST['employee'])) {
    $employee = $_POST['employee'];
    $title = "แก้ไขพนักงาน";
    $empName = $employee['name'];
    $empId = $employee['id'];
    $empSurname = $employee['surname'];
    $username = $employee['username'];
    $role = $employee['role'];
    $sta = $employee['status'];

    if ($role_user_login == '1' || $role_user_login == 1) {
        $pass = $employee['password'];
    } else {
        $pass = $employee['password'];
    }

    $status = $employee['status'];
    $pic = $employee['pic'];
} else {
}

if ($role_user_login == '1') {
    $dis_class = '';
    $dis_class_but = '';
} else {
    $dis_class = 'readonly';
    $dis_class_but = 'disabled' ;
}

?>
<style>
    .form-control.is-invalid{
        background-image: none!important;
    }
</style>
<input type="hidden" id="role_noo" value="<?php echo  $role_user_login ;?>">
<div class="modal-content">
    <div class="modal-header p-0">
        <h5 class="modal-title p-2 ml-3"><?php echo $title ; ?></h5>
    </div>
    <div class="modal-body">
        <div class="d-flex justify-content-between">
            <div class="w-25 pr-1">
                <!-- รูปพนักงาน (คงเดิม) -->
                <div class="card card-success card-outline direct-chat direct-chat-success col-12">
                    <div class="card-header sticky-header d-flex justify-content-between p-1 m-1">
                        <h2 class="card-title pl-1">รูปพนักงาน</h2>
                    </div>
                    <div class="card-body pt-1" style="height:252px;overflow-y: hidden">
                        <div class="form-group col-md-12 col-xs-12 text-center">
                            <div id="preview" class="mb-2">
                                <img src="../assets/uploads/member_pic/<?php if ($pic != '') {
                                    echo $pic;
                                } else {
                                    echo 'Default_Pic_Profile.png';
                                }; ?>" alt="Default Image" style="max-width: 100%; max-height: 150px;">
                            </div>
                            <div class="input-group">
                                <div class="input-group-btn w-100">
                                    <button type="button" class="btn btn-default w-100" id="selectFileButton" <?php echo $dis_class_but; ?> >
                                        เลือกไฟล์
                                    </button>
                                </div>
                                <input type="file" id="fileInput" name="file" accept=".jpg,.jpeg,.png"
                                       style="display: none;">
                            </div>
                            <br>
                            <span style="color: gray">ไฟล์ *.jpg, *.png (ขนาดไม่เกิน 5 MB)</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-75 pl-1">
                <!-- ฟอร์ม (แก้ไขชื่อ, นามสกุล, Username, Role และสถานะ) -->
                <div class="card card-success card-outline direct-chat direct-chat-success col-12">
                    <div class="card-header sticky-header d-flex justify-content-between p-1 m-1">
                        <h2 class="card-title pl-1"><?php echo $title; ?></h2>
                    </div>
                    <div class="card-body pt-1" style="height:252px;overflow-y: hidden">
                        <form id="" method="post">
                            <div class="box-body">
                                <div class="row">
                                    <input type="hidden" class="form-control" id="emp_id_e" name="emp_id_e"
                                           value="<?php echo $empId; ?>" >
                                    <div class="form-group col-md-6 col-xs-12">
                                        <label for="member_name">ชื่อ</label>
                                        <input type="text" class="form-control" id="member_name_e" name="member_name"
                                               value="<?php echo $empName; ?>" placeholder=""  <?php echo $dis_class ;?>>
                                    </div>
                                    <div class="form-group col-md-6 col-xs-12">
                                        <label for="member_surname">นามสกุล</label>
                                        <input type="text" class="form-control" id="member_surname_e"
                                               name="member_surname" <?php echo $dis_class ;?>
                                               value="<?php echo $empSurname; ?>" placeholder="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 col-xs-12">
                                        <label for="userlogin">ชื่อผู้ใช้</label>
                                        <input type="text" class="form-control" id="userlogin_e" name="userlogin"
                                               value="<?php echo $username; ?>" <?php echo $dis_class ;?> placeholder="">
                                    </div>
                                    <div class="form-group col-md-6 col-xs-12">
                                        <label for="passlogin">รหัสผ่าน</label>
                                        <input type="text" class="form-control" id="passlogin_e" name="passlogin"
                                               value="<?php echo $pass; ?>" placeholder="">
                                        <input type="hidden" id="real_pass" name="real_pass" value="<?php echo $pass; ?>" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 col-xs-12">
                                        <label for="role">ระดับสิทธิ์การใช้งาน</label>
                                        <select class="form-control" id="member_type_e" <?php echo $dis_class_but ;?>
                                                name="member_type">
                                            <?php
                                            $query41 = $mysqli->query("SELECT * FROM tb_role ORDER BY role_no ASC");
                                            while ($member_type = $query41->fetch_array()) { ?>
                                                <option  value='<?php echo $member_type['role_no']; ?>' <?php if($member_type['role_no'] == $role){ echo 'selected';}else{} ?> ><?php echo $member_type['role_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6 col-xs-12">
                                        <label for="status">สถานะ</label>
                                        <select class="form-control" id="status_e" name="status" <?php echo $dis_class_but ;?> >
                                            <option value="1" <?php echo $sta == 1 ? "selected" : ""; ?> >
                                                ใช้งาน
                                            </option>
                                            <option value="0" <?php echo $sta == 0 ? "selected" : ""; ?> >
                                                ไม่ใช้งาน
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer justify-content-end ">
        <button type="button" class="btn btn-primary edit_employee" style="background-color: #9B111E;border-color:#9B111E "
                id="">บันทึก
        </button>
        <button type="button" class="btn btn-default close-modal">ยกเลิก</button>
    </div>
</div>

<script>
    let rle = $('#role_noo').val()
    if(rle == 1){

    }else{
        var passwordField = $('#passlogin_e');
        passwordField.val('*'.repeat(8));
    }


    $('#selectFileButton').on('click', function () {
        $('#fileInput').click(); // เปิด dialog ให้เลือกไฟล์
    });

    $('#fileInput').on('change', function (event) {
        let reader = new FileReader(); // สร้าง FileReader
        let file = event.target.files[0]; // รับไฟล์ที่เลือก

        if (file) {
            let validExtensions = ['image/jpeg', 'image/png']; // กำหนดประเภทไฟล์ที่อนุญาต
            let maxSize = 5 * 1024 * 1024; // กำหนดขนาดไฟล์สูงสุด 5MB
            if (!validExtensions.includes(file.type)) {
                Swal.fire({
                    icon: 'error',
                    title: 'ไฟล์ไม่ถูกต้อง',
                    customClass: {
                        confirmButton: 'no-border-button' // เพิ่มคลาสนี้
                    },
                    text: 'โปรดอัปโหลดไฟล์รูปภาพที่เป็น .jpg หรือ .png เท่านั้น',
                    confirmButtonText: 'ลองอีกครั้ง',
                    confirmButtonColor: '#9B111E',
                });
                $('#fileInput').val(''); // ล้างค่า input
                return;
            }
            if (file.size > maxSize) {
                Swal.fire({
                    icon: 'error',
                    title: 'ไฟล์มีขนาดใหญ่เกินไป',
                    customClass: {
                        confirmButton: 'no-border-button' // เพิ่มคลาสนี้
                    },
                    text: 'โปรดอัปโหลดไฟล์ที่มีขนาดไม่เกิน 5MB',
                    confirmButtonText: 'ลองอีกครั้ง',
                    confirmButtonColor: '#9B111E',
                });
                $('#fileInput').val(''); // ล้างค่า input
                return;
            }
            reader.onload = function (e) {
                $('#preview').html('<img src="' + e.target.result + '" alt="Image Preview" style="max-width: 100%; max-height: 150px;">');
            };
            reader.readAsDataURL(file);
        }
    });

    $(document).on('click', '.close-modal', function () {
        location.reload()
    })

</script>