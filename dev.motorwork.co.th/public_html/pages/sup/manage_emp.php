<style>
    .small-box .icon svg {
        position: absolute;
        right: 15px;
        top: 15px;
        transition: all .3s linear;
        opacity: 60%;
    }

    .small-box .icon svg:hover {
        width: 75px;
        height: 75px;
    }

    .card-success.card-outline {
        border-top: 3px solid #9B111E;
    }

    .nav-tabs .nav-link.active {
        border-top: 3px solid #9B111E !important;
    }

    .custom-control-input:checked ~ .custom-control-label {
        background-color: #36C65A; /* สีพื้นหลัง */
        border-color: #36C65A; /* สีขอบ */
        color: white; /* สีข้อความ */
    }

    .custom-control-input:checked ~ .custom-control-label::before {
        background-color: #36C65A; /* สีวงกลมเมื่อเปิด */
        border-color: #36C65A;
    }

    .custom-control-input:checked:disabled ~ .custom-control-label {
        background-color: #36C65A !important; /* สีพื้นหลัง */
        border-color: #36C65A !important; /* สีขอบ */
        color: white; /* สีข้อความ */
    }

    .custom-control-input:checked:disabled ~ .custom-control-label::before {
        background-color: #36C65A !important; /* สีวงกลมเมื่อเปิด */
        border-color: #36C65A !important;
    }

    .custom-control-input:checked ~ .custom-control-label::after {
        background-color: white; /* สีของวงกลมด้านใน */
        transform: translateX(1.5rem); /* ระยะเลื่อนเมื่อเปิด */
    }


    .dataTables_wrapper .dataTables_paginate ul.pagination {
        margin-top: 6px !important;
        /*margin-bottom: 2px!important;*/
    }

    .dataTables_wrapper .dataTables_info {
        margin-top: 6px !important;
        /*margin-bottom: 2px!important;*/

    }

    th {
        text-align: center;
        vertical-align: middle;
    }

</style>
<?php

//header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
//header("Cache-Control: post-check=0, pre-check=0", false);
//header("Pragma: no-cache");

include '../../config/connect.php';
session_start(); ?>
<section class="content pt-2">
    <div class="row pb-0 mb-0">
        <div class="col-lg-2 col-6">
            <div class="small-box " style="background-color:whitesmoke ">
                <div class="inner">
                    <h3 style="color:#6C757D" id="st_all"></h3>
                    <p>&nbsp;</p>
                </div>
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" viewBox="0 0 16 16">
                        <path fill="black"
                              d="M8 8a2.5 2.5 0 1 0 0-5a2.5 2.5 0 0 0 0 5m-4.844 3.763c.16-.629.44-1.21.813-1.72a2.5 2.5 0 0 0-2.725 1.377c-.136.287.102.58.418.58h1.449q.015-.116.045-.237m9.691 0q.03.12.046.237h1.446c.316 0 .554-.293.417-.579a2.5 2.5 0 0 0-2.722-1.378c.374.51.653 1.09.813 1.72M14 7.5a1.5 1.5 0 1 1-3 0a1.5 1.5 0 0 1 3 0M3.5 9a1.5 1.5 0 1 0 0-3a1.5 1.5 0 0 0 0 3M5 13c-.552 0-1.013-.455-.876-.99a4.002 4.002 0 0 1 7.753 0c.136.535-.324.99-.877.99z"/>
                    </svg>
                </div>
                <a class="small-box-footer tab_search" id="all"
                   style="background-color: #6C757D;color:whitesmoke">
                    ทั้งหมด
                </a>
            </div>
        </div>
        <div class="col-lg-2 col-6">
            <!-- small box -->
            <div class="small-box " style="background-color:whitesmoke ">
                <div class="inner">
                    <h3 style="color:#6C757D" id="st_assign"></h3>
                    <p>&nbsp;</p>
                </div>
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" viewBox="0 0 36 36">
                        <ellipse cx="18" cy="11.28" fill="black" rx="4.76" ry="4.7"/>
                        <path fill="black"
                              d="M10.78 11.75h.48v-.43a6.7 6.7 0 0 1 3.75-6a4.62 4.62 0 1 0-4.21 6.46Zm13.98-.47v.43h.48A4.58 4.58 0 1 0 21 5.29a6.7 6.7 0 0 1 3.76 5.99m-2.47 5.17a21.5 21.5 0 0 1 5.71 2a2.7 2.7 0 0 1 .68.53H34v-3.42a.72.72 0 0 0-.38-.64a18 18 0 0 0-8.4-2.05h-.66a6.66 6.66 0 0 1-2.27 3.58M6.53 20.92A2.76 2.76 0 0 1 8 18.47a21.5 21.5 0 0 1 5.71-2a6.66 6.66 0 0 1-2.27-3.55h-.66a18 18 0 0 0-8.4 2.05a.72.72 0 0 0-.38.64V22h4.53Zm14.93 5.77h5.96v1.4h-5.96z"/>
                        <path fill="black"
                              d="M32.81 21.26h-6.87v-1a1 1 0 0 0-2 0v1H22v-2.83a20 20 0 0 0-4-.43a19.3 19.3 0 0 0-9.06 2.22a.76.76 0 0 0-.41.68v5.61h7.11v6.09a1 1 0 0 0 1 1h16.17a1 1 0 0 0 1-1V22.26a1 1 0 0 0-1-1m-1 10.36H17.64v-8.36h6.3v.91a1 1 0 0 0 2 0v-.91h5.87Z"/>
                    </svg>
                </div>
                <a class="small-box-footer tab_search text-white" id="assign"
                   style="background-color: #6C757D;color:whitesmoke">
                    พนักงาน
                </a>
            </div>
        </div>
        <div class="col-lg-2 col-6">
            <!-- small box -->
            <div class="small-box " style="background-color:whitesmoke ">
                <div class="inner">
                    <h3 style="color:#6C757D" id="st_success"></h3>
                    <p>&nbsp;</p>
                </div>
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" viewBox="0 0 24 24">
                        <path fill="black"
                              d="m21.1 12.5l1.4 1.41l-6.53 6.59L12.5 17l1.4-1.41l2.07 2.08zM10 17l3 3H3v-2c0-2.21 3.58-4 8-4l1.89.11zm1-13a4 4 0 0 1 4 4a4 4 0 0 1-4 4a4 4 0 0 1-4-4a4 4 0 0 1 4-4"/>
                    </svg>
                </div>
                <a class="small-box-footer  tab_search" id="success"
                   style="background-color: #6C757D;color:whitesmoke">
                    หัวหน้า
                </a>
            </div>
        </div>
        <div class="col-lg-2 col-6">
            <!-- small box -->
            <div class="small-box " style="background-color:whitesmoke ">
                <div class="inner">
                    <h3 style="color:#6C757D" id="st_onprocess"></h3>
                    <p>&nbsp;</p>
                </div>
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" viewBox="0 0 36 36">
                        <circle cx="14.67" cy="8.3" r="6" fill="black" class="clr-i-solid clr-i-solid-path-1"/>
                        <path fill="black"
                              d="M16.44 31.82a2.15 2.15 0 0 1-.38-2.55l.53-1l-1.09-.33a2.14 2.14 0 0 1-1.5-2.1v-2.05a2.16 2.16 0 0 1 1.53-2.07l1.09-.33l-.52-1a2.17 2.17 0 0 1 .35-2.52a19 19 0 0 0-2.32-.16A15.58 15.58 0 0 0 2 23.07v7.75a1 1 0 0 0 1 1z"
                              class="clr-i-solid clr-i-solid-path-2"/>
                        <path fill="black"
                              d="m33.7 23.46l-2-.6a6.7 6.7 0 0 0-.58-1.42l1-1.86a.35.35 0 0 0-.07-.43l-1.45-1.46a.38.38 0 0 0-.43-.07l-1.85 1a7.7 7.7 0 0 0-1.43-.6l-.61-2a.38.38 0 0 0-.36-.25h-2.08a.38.38 0 0 0-.35.26l-.6 2a7 7 0 0 0-1.45.61l-1.81-1a.38.38 0 0 0-.44.06l-1.47 1.44a.37.37 0 0 0-.07.44l1 1.82a7.2 7.2 0 0 0-.65 1.43l-2 .61a.36.36 0 0 0-.26.35v2.05a.36.36 0 0 0 .26.35l2 .61a7.3 7.3 0 0 0 .6 1.41l-1 1.9a.37.37 0 0 0 .07.44L19.16 32a.38.38 0 0 0 .44.06l1.87-1a7 7 0 0 0 1.4.57l.6 2.05a.38.38 0 0 0 .36.26h2.05a.38.38 0 0 0 .35-.26l.6-2.05a6.7 6.7 0 0 0 1.38-.57l1.89 1a.38.38 0 0 0 .44-.06L32 30.55a.38.38 0 0 0 .06-.44l-1-1.88a7 7 0 0 0 .57-1.38l2-.61a.39.39 0 0 0 .27-.35v-2.07a.4.4 0 0 0-.2-.36m-8.83 4.72a3.34 3.34 0 1 1 3.33-3.34a3.34 3.34 0 0 1-3.33 3.34"
                              class="clr-i-solid clr-i-solid-path-3"/>
                        <path fill="none" d="M0 0h36v36H0z"/>
                    </svg>
                </div>
                <a class="small-box-footer tab_search text-white" id="onprocess"
                   style="background-color: #6C757D;color:whitesmoke">
                    ผู้ดูแลระบบ
                </a>
            </div>
        </div>
    </div>
    <div class="card card-success card-outline pt-0">
        <div class="card-header w-100 d-flex justify-content-between align-items-center m-0 p-1 p-0">
            <div class="w-50">
                <h1 class="card-title px-2 "><strong>ข้อมูลพนักงาน</strong></h1>
            </div>
            <div class="w-50 d-flex justify-content-end">
                <div class="input-group input-group-sm" style="width: 250px;">
                    <input type="text" id="customSearchInput" class="form-control float-right" placeholder="ค้นหา">
                    <div class="input-group-append">
                        <button type="button" id="customSearchBtn" class="btn btn-default">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                <button class="btn btn-danger open_modal_add btn-sm  mx-2"
                        id="add_emp" <?php
                if ($_SESSION['member_type'] == '1') {
                    ?> style="background-color: #9B111E;border-color: #9B111E" <?php
                } else {
                    echo 'disabled';
                    ?> style="background-color: #9B111E;border-color: #9B111E;cursor: not-allowed" <?php
                } ?>
                >
                    เพิ่มพนักงาน
                </button>
            </div>
        </div>
        <div class="card-body p-1">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-12" style="overflow-y: hidden;height: calc(100vh - 312px);">
                        <table id="list_emp" class="w-100 table table-hover  table-bordered table-striped rounded"
                               role="grid"
                               aria-describedby="example1_info">
                            <thead>
                            <tr>
                                <th tabindex="0" rowspan="1" colspan="1" class="col-1">ลำดับ</th>
                                <th tabindex="0" rowspan="1" colspan="1" class="col-1">รูป</th>
                                <th tabindex="0" rowspan="1" colspan="1" class="col-4" align="center">ชื่อ</th>
                                <th tabindex="0" rowspan="1" colspan="1" class="col-4" align="center">นามสกุล</th>
                                <th tabindex="0" rowspan="1" colspan="1" class="col-4">ระดับสิทธิ์การใช้งาน</th>
                                <th tabindex="0" rowspan="1" colspan="1" class="col-1">สถานะ</th>
                                <th align="center">แก้ไข/ลบ</th>
                            </tr>
                            </thead>
                            <tbody id="show-list-emp" style="border-top-left-radius: 0;border-top-right-radius: 0">
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-1">
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-xl">
            <div class="modal-dialog modal-xl" id="modal-form">
            </div>
        </div>

        <div class="modal fade" id="modal-add">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header p-0">
                        <h5 class="modal-title p-2 ml-3">เพิ่มพนักงาน</h5>
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
                                                <img src="../assets/uploads/member_pic/Default_Pic_Profile.png"
                                                     alt="Default Image" style="max-width: 100%; max-height: 150px;">
                                            </div>
                                            <div class="input-group">
                                                <div class="input-group-btn w-100">
                                                    <button type="button" class="btn btn-default w-100"
                                                            id="selectFileButton">
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
                                        <h2 class="card-title pl-1">เพิ่มพนักงาน</h2>
                                    </div>
                                    <div class="card-body pt-1" style="height:252px;overflow-y: hidden">
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="form-group col-md-6 col-xs-12">
                                                    <label for="member_name">ชื่อ</label>
                                                    <input type="text" class="form-control " id="member_name"
                                                           name="member_name"
                                                           value="" placeholder="">
                                                </div>
                                                <div class="form-group col-md-6 col-xs-12">
                                                    <label for="member_surname">นามสกุล</label>
                                                    <input type="text" class="form-control" id="member_surname"
                                                           name="member_surname"
                                                           value="" placeholder="">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6 col-xs-12">
                                                    <label for="userlogin">ชื่อผู้ใช้</label>
                                                    <input type="text" class="form-control" id="userlogin"
                                                           name="userlogin"
                                                           value="" placeholder="">
                                                </div>
                                                <div class="form-group col-md-6 col-xs-12">
                                                    <label for="passlogin">รหัสผ่าน</label>
                                                    <input type="text" class="form-control" id="passlogin"
                                                           name="passlogin"
                                                           value="" placeholder="">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6 col-xs-12">
                                                    <label for="role">ระดับสิทธิ์การใช้งาน</label>
                                                    <select class="form-control" id="member_type"
                                                            name="member_type">
                                                        <?php
                                                        $query41 = $mysqli->query("SELECT * FROM tb_role ORDER BY role_no");
                                                        while ($member_type = $query41->fetch_array()) { ?>
                                                            <option value='<?php echo $member_type['role_no']; ?>' <?php if ($member_type['role_no'] == '3') {
                                                                echo 'selected';
                                                            } else {
                                                            } ?>><?php echo $member_type['role_name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6 col-xs-12">
                                                    <label for="status">สถานะ</label>
                                                    <select class="form-control" id="status" name="status">
                                                        <option value="1" selected>ใช้งาน</option>
                                                        <option value="0">ไม่ใช้งาน</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-end">
                        <button type="button" class="btn btn-primary add_employee"
                                style="background-color: #9B111E;border-color:#9B111E "
                                id="">บันทึก
                        </button>
                        <button type="button" class="btn btn-default close-modal-add">ยกเลิก</button>
                    </div>
                </div>
            </div>
        </div>


</section>
<script>
    $(document).ready(function () {

        $.ajax({
            url: 'controller/sup/badgeEmp.php',
            method: 'POST',
            data: {},
            success: function (response) {
                let dataRes = JSON.parse(response)
                let all = parseInt(dataRes.admin)+parseInt(dataRes.super)+parseInt(dataRes.emp)
                console.log(dataRes)
                $('#st_all').html(all)
                $('#st_assign').html(dataRes.emp)
                $('#st_success').html(dataRes.super)
                $('#st_onprocess').html(dataRes.admin)
            }
        })


    let table
    $.ajax({
        url: 'component/sup/table_list_emp.php',
        method: 'POST',
        data: {},
        success: function (response) {
            $('#show-list-emp').html(response);
            $('#modal-form').html('');

            table = $("#list_emp").DataTable({
                scrollX: true,
                // scrollY: '43vh',
                language: {
                    search: "ค้นหา:",
                    searchPlaceholder: "พิมพ์คำที่ต้องการค้นหา",
                    info: 'แสดงหน้าที่ _PAGE_ จาก _PAGES_ ( จำนวน _MAX_ รายการ )',
                    infoEmpty: 'ไม่มีข้อมูล',
                    infoFiltered: '(กรองข้อมูลจากทั้งหมด _MAX_ รายการ)',
                    lengthMenu: 'แสดงข้อมูล _MENU_ รายการต่อหน้า',
                    zeroRecords: 'ไม่พบข้อมูลที่ค้นหา',
                    paginate: {
                        first: "หน้าแรก",
                        last: "หน้าสุดท้าย",
                        next: "ถัดไป",
                        previous: "ก่อนหน้า"
                    }
                },
                pageLength: 5,
                searching: true,
                responsive: false
            });
        }
    });

    $('[data-widget="pushmenu"]').on("click", function () {
        setTimeout(function () {
            if (typeof table !== "undefined") {
                table.columns.adjust();
            }
        }, 300);
    });

    $("#customSearchInput").on("keyup", function () {
        const searchValue = $(this).val();
        if (table) {
            console.log("Searching for:", searchValue);
            table.search(searchValue).draw();
        }
    });

    // add employee
    $('.open_modal_add').on('click', function () {
        $('#modal-add').modal('show');
    })
    $(document).on('click', '.close-modal-add', function () {
        $('#modal-add').modal('hide');
    })
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
                    text: 'โปรดอัปโหลดไฟล์รูปภาพที่เป็น .jpg หรือ .png เท่านั้น',
                    customClass: {
                        confirmButton: 'no-border-button' // เพิ่มคลาสนี้
                    },
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
                    text: 'โปรดอัปโหลดไฟล์ที่มีขนาดไม่เกิน 5MB',
                    customClass: {
                        confirmButton: 'no-border-button' // เพิ่มคลาสนี้
                    },
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

    $(document).off('click', '.add_employee').on('click', '.add_employee', function () {
        let isValid = true;
        let fileInput = $('#fileInput')[0].files[0];
        let formData = new FormData();

        let emp_name = $('#member_name').val()
        let emp_surname = $('#member_surname').val()
        let user_name = $('#userlogin').val().trim();
        let password = $('#passlogin').val().trim();
        let status = $('#status').val()
        let role_no = $('#member_type').val()

        if (!emp_name) {
            $('#member_name').addClass('is-invalid');
            isValid = false;
        } else {
            $('#member_name').removeClass('is-invalid');
        }

        if (!emp_surname) {
            $('#member_surname').addClass('is-invalid');
            isValid = false;
        } else {
            $('#member_surname').removeClass('is-invalid');
        }

        if (!user_name) {
            $('#userlogin').addClass('is-invalid');
            isValid = false;
        } else {
            $('#userlogin').removeClass('is-invalid');
        }

        if (!password) {
            $('#passlogin').addClass('is-invalid');
            isValid = false;
        } else {
            $('#passlogin').removeClass('is-invalid');
        }

        if (!isValid) {
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 1500,
                customClass: {
                    confirmButton: 'no-border-button' // เพิ่มคลาสนี้
                },
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "warning",
                title: "กรุณากรอกข้อมูลให้ครบถ้วน"
            });
            return;
        }


        $.ajax({
            url: 'controller/sup/checkUserName.php',
            method: 'POST',
            data: {user: user_name},
            success: function (response) {
                let rePlUser = JSON.parse(response);
                if (rePlUser.success) {
                    if (fileInput) {
                        formData.append('file', fileInput); // เพิ่มไฟล์ลงใน FormData
                    }
                    formData.append('emp_name', emp_name);
                    formData.append('emp_surname', emp_surname);
                    formData.append('user_name', user_name);
                    formData.append('password', password);
                    formData.append('status', status);
                    formData.append('role_no', role_no);
                    formData.append('action', 'addEmployee');
                    console.log(formData)
                    $.ajax({
                        url: 'controller/sup/manageEmp.php',
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 1500,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.onmouseenter = Swal.stopTimer;
                                    toast.onmouseleave = Swal.resumeTimer;
                                }
                            });
                            Toast.fire({
                                icon: "success",
                                title: "ข้อมูลพนักงานถูกบันทึกแล้ว"
                            });
                            setTimeout(function () {
                                location.reload()
                            }, 1800)
                        }
                    });
                } else {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 1500,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        }
                    });
                    Toast.fire({
                        icon: "warning",
                        title: `พบชื่อ "ผู้ใช้ซ้ำ" กรุณาแก้ไข`
                    });

                    return;
                }
            }
        });
        // $('#userlogin').addClass('is-invalid');


    });

    // add employee
    })

    //edit employee
    $(document).off('click', '.edit_employee').on('click', '.edit_employee', function () {
        let isValid = true;
        let fileInput = $('#fileInput')[0].files[0];
        let formData = new FormData();
        let emp_id = $('#emp_id_e').val()
        console.log(emp_id)
        let emp_name = $('#member_name_e').val()
        let emp_surname = $('#member_surname_e').val()
        let user_name = $('#userlogin_e').val().trim();
        let password
        let password_fake = $('#passlogin_e').val().trim();
        if (password_fake == '********') {
            password = $('#real_pass').val().trim();
        } else {
            password = $('#passlogin_e').val().trim();
        }

        let sta = $('#status_e').val()
        let role_no = $('#member_type_e').val()

        if (!emp_name) {
            $('#member_name_e').addClass('is-invalid');
            isValid = false;
        } else {
            $('#member_name_e').removeClass('is-invalid');
        }

        if (!emp_surname) {
            $('#member_surname_e').addClass('is-invalid');
            isValid = false;
        } else {
            $('#member_surname_e').removeClass('is-invalid');
        }

        if (!user_name) {
            $('#userlogin_e').addClass('is-invalid');
            isValid = false;
        } else {
            $('#userlogin_e').removeClass('is-invalid');
        }

        if (!password) {
            $('#passlogin_e').addClass('is-invalid');
            isValid = false;
        } else {
            $('#passlogin_e').removeClass('is-invalid');
        }

        if (!isValid) {
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "warning",
                title: "กรุณากรอกข้อมูลให้ครบถ้วน"
            });
            return;
        }

        console.log('รูปภาพ', fileInput)

        $.ajax({
            url: 'controller/sup/checkUserName.php',
            method: 'POST',
            data: {user: user_name, emp_id},
            success: function (response) {
                let rePlUser = JSON.parse(response)
                if (rePlUser.success) {
                    if (fileInput) {
                        formData.append('file', fileInput);
                    }
                    formData.append('emp_id', emp_id);
                    formData.append('emp_name', emp_name);
                    formData.append('emp_surname', emp_surname);
                    formData.append('user_name', user_name);
                    formData.append('password', password);
                    formData.append('status', sta);
                    formData.append('role_no', role_no);
                    formData.append('action', 'updateEmployee');
                    console.log(formData)
                    $.ajax({
                        url: 'controller/sup/manageEmp.php',
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 1500,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.onmouseenter = Swal.stopTimer;
                                    toast.onmouseleave = Swal.resumeTimer;
                                }
                            });
                            Toast.fire({
                                icon: "success",
                                title: "ข้อมูลพนักงานถูกอัพเดตแล้ว"
                            });
                            setTimeout(function () {
                                location.reload()
                            }, 1800)
                        }
                    });
                } else {

                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 1500,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        }
                    });
                    Toast.fire({
                        icon: "warning",
                        title: `พบชื่อ "ผู้ใช้ซ้ำ" กรุณาแก้ไข`
                    });

                    return;
                }
            }
        })
        // $('#userlogin').addClass('is-invalid');
    })

    $(document).on('click', '.open_modal', function () {
        let caseOper = $(this).attr('id')
        console.log(caseOper)
        const empId = $(this).data('id');
        const empName = $(this).data('name');
        const empSurname = $(this).data('surname');
        const userName = $(this).data('username');
        const passWord = $(this).data('password');
        const status = $(this).data('statusemp');
        const empRole = $(this).data('role');
        const empPic = $(this).data('pictureemp');

        // สร้าง array ข้อมูลที่ต้องการส่ง
        const employeeData = {
            case: caseOper,
            id: empId,
            name: empName,
            surname: empSurname,
            username: userName,
            password: passWord,
            role: empRole,
            pic: empPic,
            status
        };

        console.log(employeeData)
        $.ajax({
            url: 'component/sup/modal_control_emp.php',
            method: 'POST',
            data: {employee: employeeData},
            success: function (response) {
                $('#modal-form').html(response);
                setTimeout(function () {
                    Swal.close()
                }, 250)
            },
            error: function (xhr, status, error) {
                console.error("Error loading content: " + status + " " + error);
            }
        });
        $('#modal-xl').modal('show');
    });
    //edit employee
</script>

