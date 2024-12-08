<?php

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
session_start();
include '../../config/connect.php';
$so_no = $_POST['soNo'];
$assign_no = $_POST['assignNo'];
$empId = $_SESSION['Member_IdLogin'];
$sql_select_head = "SELECT COUNT(CASE WHEN tb_sale_order.pack_status IS NOT NULL THEN 1 END) AS total_with_status,
                    COUNT(CASE WHEN tb_sale_order_detail.flag_pack = 'Y' THEN 1 END) AS count_Y,
                    COUNT(CASE WHEN tb_sale_order_detail.flag_pack = 'N' THEN 1 END) AS count_N,
                    COUNT(CASE WHEN tb_sale_order_detail.flag_pack = 'X' THEN 1 END) AS count_X, 
                    SUM(prod_qty) as sumQty,
                    SUM(CASE WHEN tb_sale_order_detail.flag_pack = 'X' THEN prod_qty ELSE 0 END) AS sumQty_noneX,
                    SUM(CASE WHEN tb_sale_order_detail.flag_pack = 'N' THEN prod_qty ELSE 0 END) AS sumQty_N,
                    SUM(CASE WHEN tb_sale_order_detail.flag_pack = 'Y' THEN prod_qty ELSE 0 END) AS sumQty_Y,
                    COUNT(so_detail_no) as listQty,tb_customer.cust_id as cust_id,tb_customer.cust_name as cust_name 
                    FROM `tb_sale_order_detail` 
                    JOIN tb_sale_order ON tb_sale_order_detail.so_id = tb_sale_order.so_id
                    LEFT JOIN tb_customer ON tb_customer.cust_id = tb_sale_order.cust_id
                    WHERE tb_sale_order_detail.so_id = '" . $so_no . "';";
$query_select_head = $mysqli->query($sql_select_head);
$data_head = $query_select_head->fetch_object();
?>
<style>
    th {
        text-align: center;
        vertical-align: middle;
    }

    #barcode:focus {
        border-color: #9B111E;
    }

    .nav-tabs .nav-link.active {
        border-top: 3px solid #9B111E !important;
        color: #9B111E !important;
    }


    .dataTables_paginate ul.pagination {
        padding-bottom: 10px;
    }

    @media (max-width: 767px) {
        .dataTables_wrapper .dataTables_info {
            text-align: center !important;
            padding-left: 7.5px !important;
            margin-bottom: 15px !important;
            margin-top: 15px !important;
        }

        .dataTables_wrapper .dataTables_paginate ul.pagination {
            /*display: inline-block;*/
            /*display: flex;*/
            margin-bottom: 15px !important;
            justify-content: center !important;
            /*margin: 0 5px; !* ระยะห่างระหว่างปุ่ม *!*/
            /*width: auto;*/
        }
    }

    .btn-app {

    }

    #product_qty, #product_count {
        font-size: 60px !important;
        height: 80px; /* เพิ่มความสูงของช่อง input */
        padding: 15px; /* เพิ่ม padding ภายใน */
        line-height: 1.5; /* ปรับความสูงของข้อความภายใน */
        text-align: right;
    }

    .search_bar:focus {
        outline: none; /* ปิดขอบเดิม */
        box-shadow: 0 0 5px rgba(155, 17, 30, 0.7); /* เพิ่มเงาเมื่อโฟกัส */
    }

    @media (min-width: 1000px) and

    @media (max-height: 933px) {
        .card-resp {
            overflow-y: auto;
            height: calc(60vh - 40px);
            overflow-x: hidden;
        }
    }

    @media (min-width: 800px) {
        .text-header {
            font-size: 13px !important;
        }

        .btn-app .number-icon {
            font-size: 20px !important;
        }

        .btn-app .text-ico {
            font-size: 16px;
        }
    }

    @media (min-width: 700px) {

        .btn-app .number-icon {
            font-size: 15px; /* ขนาดฟอนต์ลดลง */
        }

        .btn-app {
            font-size: 6px; /* ปรับขนาดฟอนต์ของข้อความทั้งหมด */
        }

        .text-ico {
            font-size: 12px;
        }
    }

    @media (max-width: 600px) {
        .card-resp {
            overflow-y: auto;
            height: calc(60vh - 80px);
            overflow-x: hidden;
        }

        .text-sm .btn .text-but-st {
            font-size: 11px !important;
        }

        /*.text-header span{*/
        /*    font-size: 16px!important;*/
        /*}*/
    }

    @media (max-width: 554px) {
        .text-sm .btn .text-but-st {
            font-size: 11px !important;
            display: none;
        }

    }

    /* สำหรับหน้าจอที่มีขนาดความกว้างไม่เกิน 480px (หน้าจอโทรศัพท์มือถือ) */
    @media (max-width: 480px) {

        .text-header {
            font-size: 13px !important;
        }

        .btn-app .number-icon {
            font-size: 14px;
        }

        .btn-app .text-ico {
            font-size: 8px;
        }
    }

    @media (max-width: 412px) {
        .text-clock {
            font-size: 16px !important;
        }

        .text-header {
            font-size: 10px !important;
        }

        .btn-app .number-icon {
            font-size: 14px;
        }

        .btn-app .text-ico {
            font-size: 8px;
        }
    }


    @media (max-width: 361px) {
        .btn-app .number-icon {
            font-size: 14px;
        }

        .btn-app .text-ico {
            font-size: 8px;
        }
    }
</style>
<input type="hidden" id="so_no" value="<?php echo $so_no; ?>">
<input type="hidden" id="assign_no" value="<?php echo $assign_no; ?>">
<input type="hidden" id="emp_id" value="<?php echo $empId; ?>">
<section class="content">
    <div class="row pr-1 pl-1">
        <div class="card card-header-bg card-outline direct-chat direct-chat-success col-12 mt-2 mb-2">
            <div class="card-header d-flex justify-content-between p-1 m-1 pb-2 mb-0">
                <div class="w-75 d-flex justify-content-start align-items-center">
                    <h2 class="card-title pl-2" style="font-size: 20px"><strong>นับสินค้า(งานแพ็ค)</strong></h2>
                </div>
                <div class="w-25 d-flex justify-content-end align-items-center">
                    <button class="btn btn-sm p-0 m-0 px-2 mr-1 back_to_app_manage_pick text-white align-items-center d-flex justify-content-center"
                            style="background-color: #9B111E; height: 30px; width: 30px;">
                        <i class="nav-icon fas fa-store-alt"></i>
                    </button>
                    <button class="btn btn-sm p-0 m-0 refresh_page align-items-center d-flex justify-content-center"
                            style="background-color: #9B111E; height: 30px; width: 30px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                            <g fill="white" fill-rule="evenodd" clip-rule="evenodd">
                                <path d="M6.64 9.788a.75.75 0 0 1 .53.918a5 5 0 0 0 7.33 5.624a.75.75 0 1 1 .75 1.3a6.501 6.501 0 0 1-9.529-7.312a.75.75 0 0 1 .919-.53M8.75 6.37a6.5 6.5 0 0 1 9.529 7.312a.75.75 0 1 1-1.45-.388A5.001 5.001 0 0 0 9.5 7.67a.75.75 0 1 1-.75-1.3"/>
                                <path d="M5.72 9.47a.75.75 0 0 1 1.06 0l2.5 2.5a.75.75 0 1 1-1.06 1.06l-1.97-1.97l-1.97 1.97a.75.75 0 0 1-1.06-1.06zm9 1.5a.75.75 0 0 1 1.06 0l1.97 1.97l1.97-1.97a.75.75 0 1 1 1.06 1.06l-2.5 2.5a.75.75 0 0 1-1.06 0l-2.5-2.5a.75.75 0 0 1 0-1.06"/>
                            </g>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="card-body d-flex flex-column mb-1">
                <div class="d-flex justify-content-between pt-3" style="height: 200px">
                    <div class="w-50 pl-4" style="padding-left: 0px">
                        <div class="h-25">
                            <div class="pull-left col-md-12  col-xs-12 text-header" style="padding-left: 0px">
                                <span>ใบขาย : <?php echo $_POST['soNo']; ?></span>
                            </div>
                            <div class="pull-left  col-md-12 col-xs-12 text-header" style="padding-left: 0px">
                                <span>ลูกค้า
                                    : <?php echo $data_head->cust_id . ' <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ' . 'บริษัท เอ็ม ดับเบิ้ลยู อิมพอร์ต แอนด์  เอ็กซ์พอร์ต (ประเทศไทย) จำกัด'; ?></span>
                            </div>
                        </div>
                        <div class="h-25 mt-5">
                            <div class="card card-primary w-75">
                                <div class="row p-2 text-center"
                                     style="box-shadow: 0 0 0; border-bottom: 1px solid white;">
                                    <div class="col-12">
                                        <span class="text-but-st" style="font-size: 21px">เวลาที่ใช้ในการนับ</span>
                                    </div>
                                </div>
                                <div class="row justify-content-center align-items-center p-2 pb-1 mb-1 mb-0">
                                    <h4 class="text-clock font-weight-bold mb-0" style="color: #9B111E;">
                                        <?php

                                        $sql_select_result = "SELECT * FROM `tb_result` WHERE assign_no = '$assign_no';";
                                        $query_select_result = $mysqli->query($sql_select_result);
                                        $data_result = $query_select_result->fetch_object();
                                        $start = new DateTime($data_result->start_dt);
                                        $stop = new DateTime($data_result->stop_dt);

                                        // คำนวณความต่างระหว่าง start และ stop
                                        $interval = $start->diff($stop);

                                        // แปลงผลลัพธ์เป็นชั่วโมง นาที วินาที
                                        $hours = $interval->h;
                                        $minutes = $interval->i;
                                        $seconds = $interval->s;

                                        // แสดงผลลัพธ์
                                        //                                        echo "ระยะเวลาระหว่าง $start_dt และ $stop_dt:<br>";
                                        //                                        echo "$hours ชั่วโมง $minutes นาที $seconds วินาที";
                                        ?>
                                        <span style="font-size: 20px;color: <?php if($data_result->flag_assign == 'Y'){ echo "#07A14E" ;  }else{ echo "#A4111E" ; } ?>"><?php echo "$hours ชั่วโมง $minutes นาที $seconds วินาที";?></span>

                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-50">
                        <div class="row col-12 packageInFoStatus">
                            <span>รายการ</span>
                        </div>
                        <div class="col-12 row d-flex justify-content-between">
                            <a class="btn btn-app pt-2 col-md-3 col"
                               style="background-color:#0364BE;color:#FFFFFF;min-width: 40px">
                                <span class="number-icon"><?php echo $data_head->total_with_status; ?></span><br><span
                                    class="text-ico">ทั้งหมด</span>
                            </a>
                            <a class="btn btn-app pt-2 col-md-3 col"
                               style="background-color:#07A14E;color:#FFFFFF;min-width: 40px">
                                <span class="number-icon"><?php echo $data_head->count_Y; ?></span><br><span
                                    class="text-ico">สำเร็จ</span>
                            </a>
                            <a class="btn btn-app pt-2 col-md-3 col"
                               style="background-color:#A10303;color:#FFFFFF;min-width: 40px">
                                <span class="number-icon"><?php echo $data_head->count_N; ?></span><br><span
                                    class="text-ico">ไม่สำเร็จ</span>
                            </a>
                        </div>
                        <div class="row col-12 packageinfostatus mt-4">
                            <span>จำนวน</span>
                        </div>
                        <div class="col-12 row d-flex justify-content-between">
                            <a class="btn btn-app pt-2 col-md-3 col"
                               style="background-color:#0364BE;color:#FFFFFF;min-width: 40px"> <span
                                    class="number-icon"><?php

                                    $sql_select_result_pack = "SELECT SUM(pack_qty) as count_pack FROM `tb_pack` WHERE assign_no = '$assign_no' AND flag_pack = 'N';";
                                    $query_select_result_pack = $mysqli->query($sql_select_result_pack);
                                    $data_result_pack = $query_select_result_pack->fetch_object();

                                    echo $data_head->sumQty; ?></span><br><span
                                    class="text-ico">ทั้งหมด</span></a>
                            <a class="btn btn-app pt-2 col-md-3 col"
                               style="background-color:#07A14E;color:#FFFFFF;min-width: 40px"> <span
                                    class="number-icon"><?php echo $data_head->sumQty_Y + $data_result_pack->count_pack; ?></span><br><span
                                    class="text-ico">สำเร็จ</span></a>
                            <a class="btn btn-app pt-2 col-md-3 col"
                               style="background-color:#A10303;color:#FFFFFF;min-width: 40px"> <span
                                    class="number-icon"><?php


                                    echo $data_head->sumQty_N - $data_result_pack->count_pack ; ?></span><br><span
                                    class="text-ico">ไม่สำเร็จ</span></a>
                        </div>

                    </div>
                </div>
                <div class="w-100 pl-3 mt-5 card-resp">
                    <div class="row">
                        <div class="row col-12 w-100">
                            <div class="card card-primary card-outline card-outline-tabs col-md-12">
                                <div class="card-header d-flex flex-wrap justify-content-between align-items-center p-0 border-bottom-0 py-2">
                                    <ul class="nav nav-tabs w-100 w-md-50 d-flex justify-content-start mb-2 mb-md-0"
                                        id="custom-tabs-four-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active text-dark selectTab" id="wait_process"
                                               data-toggle="pill" role="tab"
                                               style="cursor: pointer" aria-controls="custom-tabs-four-home"
                                               aria-selected="true"><span class="float-left text-white badge"
                                                                          style="border-color: #696969;background-color: #696969;font-size: 12px"><?php echo $data_head->count_X; ?></span>&nbsp;รอนับ</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-dark selectTab" id="success" data-toggle="pill"
                                               role="tab"
                                               style="cursor: pointer" aria-controls="custom-tabs-four-profile"
                                               aria-selected="false">สำเร็จ</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-dark selectTab" id="unsuccess" data-toggle="pill"
                                               role="tab"
                                               style="cursor: pointer" aria-controls="custom-tabs-four-messages"
                                               aria-selected="false">ไม่สำเร็จ</a>
                                        </li>
                                    </ul>
                                    <div class="w-100 w-md-50 d-flex justify-content-end mt-1">
                                        <div class="w-100 d-flex justify-content-end">
                                            <div class="w-25 d-flex justify-content-start align-items-center">
                                            </div>
                                            <div class="w-75 d-flex justify-content-end">
                                                <div class="input-group input-group-sm" style="width: 250px">
                                                    <input type="text" id="customSearchInput"
                                                           class="form-control float-right" placeholder="ค้นหา....">
                                                    <div class="input-group-append">
                                                        <button type="button" id="customSearchBtn"
                                                                class="btn btn-default">
                                                            <i class="fas fa-search"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body h-50">
                                    <!--                                    <div class="tab-content" id="custom-tabs-four-tabContent" style="overflow-x: scroll">-->
                                    <!--                                    <div class="tab-content" id="custom-tabs-four-tabContent" style="height: calc(100vh - 550px)">-->
                                    <div class="tab-content" id="custom-tabs-four-tabContent">
                                        <table class="w-100 table nowrap table-hover table-bordered table-striped rounded"
                                               id="show-table-tb">
                                            <thead>
                                            <tr>
                                                <th align="center" width="5%">ลำดับ</th>
                                                <th align="center" width="18%">รหัสสินค้า</th>
                                                <th align="center">ชื่อสินค้า</th>
                                                <th align="center" width="10%">ตำแหน่ง</th>
                                                <th align="center" width="10%">ต้องนับ</th>
                                                <th align="center" width="10%">นับได้</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>

    $(document).ready(function () {
        $('.refresh_page').click(function () {
            // location.reload()
            let soNo = $('#so_no').val()
            let assignNo = $('#assign_no').val()
            $.ajax({
                url: 'pages/emp/history_pack.php',
                method: 'POST',
                data: {
                    soNo,
                    assignNo
                },
                success: function (response) {
                    $('#main-stage').html(response)

                    $.ajax({
                        url: `component/emp/form_scanner_pack.php`,
                        method: 'POST',
                        data: {},
                        success: function (data) {
                            $('#form_scan').html(data)

                        }
                    })

                }
            });
        })

        let sale_order_id = $('#so_no').val()
        let assign_id_show = $('#assign_no').val()

        if ($.fn.DataTable.isDataTable("#show-table-tb")) {
            let table = $("#show-table-tb").DataTable();
            table.clear().destroy();
        }
        var bottomMargin = 720;
        $.ajax({
            url: `component/emp/table_manage_pack.php`,
            method: 'POST',
            data: {tab: 'wait_process', so_id: sale_order_id, assign_id: assign_id_show},
            success: function (data) {
                $('#show-table-tb tbody').html(data);

                table = $("#show-table-tb").DataTable({
                    retrieve: false,
                    destroy: true,
                    scrollX: true,
                    scrollY: `${window.innerHeight - bottomMargin}px`,
                    language: {
                        search: "ค้นหา:",
                        searchPlaceholder: "พิมพ์คำที่ต้องการค้นหา",
                        info: 'แสดงหน้าที่ _PAGE_ จาก _PAGES_ ( จำนวน _MAX_ รายการ )',
                        infoEmpty: '',
                        infoFiltered: '(กรองข้อมูลจากทั้งหมด _MAX_ รายการ)',
                        lengthMenu: 'แสดงข้อมูล _MENU_ รายการต่อหน้า',
                        zeroRecords: 'ไม่พบข้อมูล',
                        paginate: {
                            first: "หน้าแรก",
                            last: "หน้าสุดท้าย",
                            next: "ถัดไป",
                            previous: "ก่อนหน้า"
                        }
                    },
                    searching: true,
                    responsive: true,
                    pageLength: 15,
                    drawCallback: function (settings) {
                        var api = this.api();
                        var pageInfo = api.page.info();
                        var currentPage = pageInfo.page;
                        var totalPages = pageInfo.pages;

                        // ซ่อนและแสดงเฉพาะปุ่มที่เกี่ยวข้อง
                        $('.dataTables_paginate .paginate_button').hide(); // ซ่อนทุกปุ่ม

                        if (currentPage > 0) {
                            // แสดงปุ่ม "ย้อนกลับ" และหน้าแรก
                            $('.dataTables_paginate .paginate_button.previous').show();
                            $(`.dataTables_paginate .paginate_button:contains(${currentPage})`).show();
                        }

                        if (currentPage < totalPages - 1) {
                            // แสดงปุ่ม "ถัดไป" และหน้าถัดไป
                            $('.dataTables_paginate .paginate_button.next').show();
                            $(`.dataTables_paginate .paginate_button:contains(${currentPage + 2})`).show();
                        }

                        // แสดงปุ่มหน้าปัจจุบันเสมอ
                        $(`.dataTables_paginate .paginate_button:contains(${currentPage + 1})`).show();
                    }
                });

            }
        })

        $('.selectTab').click(function () {
            let tab = $(this).attr('id')
            let sale_order_id = $('#so_no').val()
            let assign_id_show = $('#assign_no').val()
            $('.selectTab').removeClass('active')
            $('#' + tab).addClass('active')
            console.log(tab)
            if ($.fn.DataTable.isDataTable("#show-table-tb")) {
                let table = $("#show-table-tb").DataTable();
                table.clear().destroy();
                // console.log('เคลีย')
            }
            $.ajax({
                url: `component/emp/table_manage_pack.php`,
                method: 'POST',
                data: {tab, so_id: sale_order_id, assign_id: assign_id_show},
                success: function (data) {
                    // $('#show-table').html('')
                    // console.log(data)
                    // $('#show-table').html(data)
                    $('#show-table-tb tbody').html(data);
                    table = $("#show-table-tb").DataTable({
                        retrieve: true,
                        destroy: true,
                        scrollX: true,
                        scrollY: `${window.innerHeight - bottomMargin}px`,
                        language: {
                            search: "ค้นหา:",
                            searchPlaceholder: "พิมพ์คำที่ต้องการค้นหา",
                            info: 'แสดงหน้าที่ _PAGE_ จาก _PAGES_ ( จำนวน _MAX_ รายการ )',
                            infoEmpty: '',
                            infoFiltered: '(กรองข้อมูลจากทั้งหมด _MAX_ รายการ)',
                            lengthMenu: 'แสดงข้อมูล _MENU_ รายการต่อหน้า',
                            zeroRecords: 'ไม่มีข้อมูล',
                            paginate: {
                                first: "หน้าแรก",
                                last: "หน้าสุดท้าย",
                                next: "ถัดไป",
                                previous: "ก่อนหน้า"
                            }
                        },
                        searching: true,
                        responsive: true,
                        pageLength: 15,
                        drawCallback: function (settings) {
                            var api = this.api();
                            var pageInfo = api.page.info();
                            var currentPage = pageInfo.page;
                            var totalPages = pageInfo.pages;

                            // ซ่อนและแสดงเฉพาะปุ่มที่เกี่ยวข้อง
                            $('.dataTables_paginate .paginate_button').hide(); // ซ่อนทุกปุ่ม

                            if (currentPage > 0) {
                                // แสดงปุ่ม "ย้อนกลับ" และหน้าแรก
                                $('.dataTables_paginate .paginate_button.previous').show();
                                $(`.dataTables_paginate .paginate_button:contains(${currentPage})`).show();
                            }

                            if (currentPage < totalPages - 1) {
                                // แสดงปุ่ม "ถัดไป" และหน้าถัดไป
                                $('.dataTables_paginate .paginate_button.next').show();
                                $(`.dataTables_paginate .paginate_button:contains(${currentPage + 2})`).show();
                            }

                            // แสดงปุ่มหน้าปัจจุบันเสมอ
                            $(`.dataTables_paginate .paginate_button:contains(${currentPage + 1})`).show();
                        }
                    });

                }
            });
        })


        $(".back_to_app_manage_pick").on("click", function () {
            // window.history.back();
            // window.location.replace("https://dev.motorwork.co.th/app");
            Swal.fire({
                title: 'กำลังโหลดข้อมูล...',
                text: 'กรุณารอสักครู่...',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            })
            $.ajax({
                url: 'pages/emp/dashboard.php',
                method: 'POST',
                success: function (response) {
                    $('#main-stage').html(response);

                    setTimeout(function () {
                        Swal.close()
                    }, 500)

                },
                error: function (xhr, status, error) {
                    console.error("Error loading content: " + status + " " + error);
                }
            });
        })

        $("#customSearchInput").on("keyup", function () {
            const searchValue = $(this).val();
            if (table) {
                console.log("Searching for:", searchValue);
                table.search(searchValue).draw();
            }
        });

        window.addEventListener('resize', () => {
            const newHeight = `${window.innerHeight - bottomMargin}px`;
            table.settings()[0].oScroll.sY = newHeight; // ปรับค่า scrollY
            table.draw(); // วาดใหม่
        });

        $('[data-widget="pushmenu"]').on("click", function () {
            setTimeout(function () {
                if (typeof table !== "undefined") {
                    table.columns.adjust();
                }
            }, 300);
        });
    });
</script>