<?php
session_start();
include "../../config/connect.php";
$role_user_login = $_SESSION['member_type'] ;
$sql_check_all = "SELECT * FROM tb_employee 
LEFT JOIN tb_role ON tb_role.role_no = tb_employee.role_no WHERE  emp_status != 99 ORDER BY tb_employee.emp_name ASC";
$query_check_all = $mysqli->query($sql_check_all);
$count = 0;
while ($row_Data = mysqli_fetch_assoc($query_check_all)) {
    $count++;
    if ($row_Data['emp_status'] == 1) {
        $status_text = 'ใช้งาน';
    } else {
        $status_text = 'ปิดใช้งาน';
    } ?>
    <tr>
        <td style="text-align: center; vertical-align: middle;" align="center"><?php echo $count; ?></td>
        <td align="center">
<!--            --><?php //echo $row_Data['pic_name'] ;?>
            <img src="../assets/uploads/member_pic/<?php if($row_Data['pic_name'] != '' ){ echo $row_Data['pic_name'];}else{ echo 'Default_Pic_Profile.png';} ; ?>"
                 alt="no image"
                 style="width: auto; height: 36px; object-fit: contain;">

        </td>
        <td style="text-align: center; vertical-align: middle;"><?php echo $row_Data["emp_name"] ?></td>
        <td style="text-align: center; vertical-align: middle;"><?php echo $row_Data["emp_surname"] ?></td>
        <td style="text-align: center; vertical-align: middle;" align="center"><?php echo $row_Data["role_name"] ?></td>
        <td align="center" class="d-flex justify-content-center">
            <div class="form-group">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" data-emp-id="<?php echo $row_Data["emp_id"]; ?>"  id="<?php echo $row_Data["emp_id"]; ?>"
                        <?php if ($row_Data["emp_status"] == 1) echo 'checked'; ?>
                        <?php if ($role_user_login != 1) echo 'disabled'; ?>>
                    <label class="custom-control-label" for="<?php echo $row_Data["emp_id"]; ?>"></label>
                </div>
            </div>
        </td>


        <td width="12%" align="center" style="vertical-align: middle; text-align: center;">
            <?php if($role_user_login == '1'){ ?>
                <a class="btn btn-info btn-sm open_modal" id="edit_emp" style="background-color:#222D32;border-color:#222D32;cursor: pointer"
                   data-id="<?php echo $row_Data["emp_id"]; ?>"
                   data-pictureemp="<?php echo $row_Data["pic_name"]; ?>"
                   data-name="<?php echo $row_Data["emp_name"]; ?>"
                   data-password="<?php echo $row_Data["password"]; ?>"
                   data-surname="<?php echo $row_Data["emp_surname"]; ?>"
                   data-username="<?php echo $row_Data["username"]; ?>"
                   data-statusemp="<?php echo $row_Data["emp_status"]; ?>"
                   data-role="<?php echo $row_Data["role_no"]; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="27.5" height="22" viewBox="0 0 640 512">
                        <path fill="white"
                              d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0S96 57.3 96 128s57.3 128 128 128m89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h274.9c-2.4-6.8-3.4-14-2.6-21.3l6.8-60.9l1.2-11.1l7.9-7.9l77.3-77.3c-24.5-27.7-60-45.5-99.9-45.5m45.3 145.3l-6.8 61c-1.1 10.2 7.5 18.8 17.6 17.6l60.9-6.8l137.9-137.9l-71.7-71.7zM633 268.9L595.1 231c-9.3-9.3-24.5-9.3-33.8 0l-37.8 37.8l-4.1 4.1l71.8 71.7l41.8-41.8c9.3-9.4 9.3-24.5 0-33.9"/>
                    </svg>
                </a>
            <?php }else{
                if($row_Data["role_no"] == '3'){ ?>
                    <a class="btn btn-info btn-sm open_modal" id="edit_emp" style="background-color:#222D32;border-color:#222D32;cursor: pointer"
                       data-id="<?php echo $row_Data["emp_id"]; ?>"
                       data-pictureemp="<?php echo $row_Data["pic_name"]; ?>"
                       data-name="<?php echo $row_Data["emp_name"]; ?>"
                       data-password="<?php echo $row_Data["password"]; ?>"
                       data-surname="<?php echo $row_Data["emp_surname"]; ?>"
                       data-statusemp="<?php echo $row_Data["emp_status"]; ?>"
                       data-username="<?php echo $row_Data["username"]; ?>"
                       data-role="<?php echo $row_Data["role_no"]; ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="27.5" height="22" viewBox="0 0 640 512">
                            <path fill="white"
                                  d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0S96 57.3 96 128s57.3 128 128 128m89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h274.9c-2.4-6.8-3.4-14-2.6-21.3l6.8-60.9l1.2-11.1l7.9-7.9l77.3-77.3c-24.5-27.7-60-45.5-99.9-45.5m45.3 145.3l-6.8 61c-1.1 10.2 7.5 18.8 17.6 17.6l60.9-6.8l137.9-137.9l-71.7-71.7zM633 268.9L595.1 231c-9.3-9.3-24.5-9.3-33.8 0l-37.8 37.8l-4.1 4.1l71.8 71.7l41.8-41.8c9.3-9.4 9.3-24.5 0-33.9"/>
                        </svg>
                    </a>
                <?php }else{ ?>
                    <a class="btn btn-info btn-sm open_modal" style="background-color:#6C757D;border-color:#6C757D;cursor: not-allowed" >
                        <svg xmlns="http://www.w3.org/2000/svg" width="27.5" height="22" viewBox="0 0 640 512">
                            <path fill="white"
                                  d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0S96 57.3 96 128s57.3 128 128 128m89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h274.9c-2.4-6.8-3.4-14-2.6-21.3l6.8-60.9l1.2-11.1l7.9-7.9l77.3-77.3c-24.5-27.7-60-45.5-99.9-45.5m45.3 145.3l-6.8 61c-1.1 10.2 7.5 18.8 17.6 17.6l60.9-6.8l137.9-137.9l-71.7-71.7zM633 268.9L595.1 231c-9.3-9.3-24.5-9.3-33.8 0l-37.8 37.8l-4.1 4.1l71.8 71.7l41.8-41.8c9.3-9.4 9.3-24.5 0-33.9"/>
                        </svg>
                    </a>
               <?php  } ?>
            <?php }?>


            <?php if($role_user_login == '2'){ ?>
            <a class="btn btn-danger btn-sm" style="background-color:#BE646D;border-color:#BE646D;cursor: not-allowed">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 48 48">
                    <g fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="4">
                        <path fill="white" d="M19 20a7 7 0 1 0 0-14a7 7 0 0 0 0 14"/>
                        <path d="m42 15l-8 8m0-8l8 8"/>
                        <path fill="white"
                              d="M4 40.8V42h30v-1.2c0-4.48 0-6.72-.872-8.432a8 8 0 0 0-3.496-3.496C27.92 28 25.68 28 21.2 28h-4.4c-4.48 0-6.72 0-8.432.872a8 8 0 0 0-3.496 3.496C4 34.08 4 36.32 4 40.8"/>
                    </g>
                </svg>
            </a>
            <?php }else{ ?>
                <a class="btn btn-danger btn-sm delete_emp" style="background-color:#9B111E;border-color:#9B111E;cursor: pointer" data-emp-id="<?php echo $row_Data["emp_id"]; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 48 48">
                        <g fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="4">
                            <path fill="white" d="M19 20a7 7 0 1 0 0-14a7 7 0 0 0 0 14"/>
                            <path d="m42 15l-8 8m0-8l8 8"/>
                            <path fill="white"
                                  d="M4 40.8V42h30v-1.2c0-4.48 0-6.72-.872-8.432a8 8 0 0 0-3.496-3.496C27.92 28 25.68 28 21.2 28h-4.4c-4.48 0-6.72 0-8.432.872a8 8 0 0 0-3.496 3.496C4 34.08 4 36.32 4 40.8"/>
                        </g>
                    </svg>
                </a>
            <?php }?>
        </td>
    </tr>

<?php } ?>
<script>
    $(document).ready(function () {

        $(document).on('change', '.custom-control-input', function () {
        // $('.custom-control-input').on('change', function () {
            let empId = $(this).data('emp-id');
            let status = $(this).prop('checked') ? 1 : 0;
            console.log(empId,status)
            $.ajax({
                url: 'controller/sup/manageEmp.php',
                method: 'POST',
                data: {
                    emp_id: empId,
                    status: status,
                    action:'update_status_emp'
                },
                success: function (response) {
                    let check = JSON.parse(response)
                    if (check.success) {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 700,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.onmouseenter = Swal.stopTimer;
                                toast.onmouseleave = Swal.resumeTimer;
                            }
                        });
                        Toast.fire({
                            icon: "success",
                            title: "สถานะของพนักงานถูกอัพเดตแล้ว"
                        });
                        setTimeout(function () {
                            $.ajax({
                                url: 'pages/sup/manage_emp.php',
                                method: 'POST',
                                success: function (response) {
                                    $('#main-stage').html(response);
                                }
                            });
                        },800)
                    } else {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.onmouseenter = Swal.stopTimer;
                                toast.onmouseleave = Swal.resumeTimer;
                            }
                        });
                        Toast.fire({
                            icon: "error",
                            title: "ไม่สามารถอัพเดตสถานะได้"
                        });
                        $(this).prop('checked', !status);
                    }
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด',
                        text: 'ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้'
                    });

                    $(this).prop('checked', !status);
                }
            });
        });

        $(document).on('click', '.delete_emp', function () {
            let empId = $(this).data('emp-id');
            let status = 99;
            console.log(empId,status)

            Swal.fire({
                title: "ยืนยันการลบพนักงาน?",
                // text: "คุณต้องการที่จะลบพนักงาน!",
                icon: "warning",
                iconColor: "#A51005",
                customClass: {
                    confirmButton: 'no-border-button' // เพิ่มคลาสนี้
                },
                showCancelButton: true,
                confirmButtonColor: "#9B111E",
                cancelButtonColor: "#222D32",
                confirmButtonText: "ลบ",
                cancelButtonText:'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'controller/sup/manageEmp.php',
                        method: 'POST',
                        data: {
                            emp_id: empId,
                            status: status,
                            action:'update_status_emp'
                        },
                        success: function (response) {
                            let check = JSON.parse(response)
                            if (check.success) {
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: "top-end",
                                    showConfirmButton: false,
                                    timer: 1000,
                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        toast.onmouseenter = Swal.stopTimer;
                                        toast.onmouseleave = Swal.resumeTimer;
                                    }
                                });
                                Toast.fire({
                                    icon: "success",
                                    title: "ลบพนักงานสำเร็จ"
                                });

                                setTimeout(function () {
                                    $.ajax({
                                        url: 'pages/sup/manage_emp.php',
                                        method: 'POST',
                                        success: function (response) {
                                            $('#main-stage').html(response);
                                        }
                                    });
                                },1060)
                            } else {
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: "top-end",
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        toast.onmouseenter = Swal.stopTimer;
                                        toast.onmouseleave = Swal.resumeTimer;
                                    }
                                });
                                Toast.fire({
                                    icon: "error",
                                    title: "ไม่สามารถลบพนักงานได้"
                                });
                            }
                        },
                        error: function () {
                            Swal.fire({
                                icon: 'error',
                                title: 'เกิดข้อผิดพลาด',
                                text: 'ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้'
                            });

                            $(this).prop('checked', !status);
                        }
                    });
                }
            });

        });
    })

</script>

