<?php

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
session_start();
include '../../config/connect.php';
$so_no = $_POST['soNo'];
$assign_no = $_POST['assignNo'];
$empId = $_SESSION['Member_IdLogin'] ;
$sql_select_head = "SELECT COUNT(CASE WHEN tb_sale_order.pick_status IS NOT NULL THEN 1 END) AS total_with_status,
                    COUNT(CASE WHEN tb_sale_order_detail.flag_pick = 'Y' THEN 1 END) AS count_Y,
                    COUNT(CASE WHEN tb_sale_order_detail.flag_pick = 'N' THEN 1 END) AS count_N,
                    COUNT(CASE WHEN tb_sale_order_detail.flag_pick = 'X' THEN 1 END) AS count_X, 
                    SUM(prod_qty) as sumQty,
                    SUM(CASE WHEN tb_sale_order_detail.flag_pick = 'X' THEN prod_qty ELSE 0 END) AS sumQty_noneX,
                    SUM(CASE WHEN tb_sale_order_detail.flag_pick = 'N' THEN prod_qty ELSE 0 END) AS sumQty_N,
                    SUM(CASE WHEN tb_sale_order_detail.flag_pick = 'Y' THEN prod_qty ELSE 0 END) AS sumQty_Y,
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
                    <h2 class="card-title pl-2" style="font-size: 20px"><strong>นับสินค้า(งานหยิบ)</strong></h2>
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
                            <?php
                            $sql_select_action = "SELECT * FROM `tb_assign` 
                                                LEFT JOIN tb_result ON tb_result.assign_no = tb_assign.assign_no
                                                WHERE tb_assign.assign_no = '$assign_no' AND so_id = '$so_no';";
                            $query_select_action = $mysqli->query($sql_select_action);
                            $data_action = $query_select_action->fetch_object();
                            if ($data_action->assign_status == 31) {
                                ?>
                                <input type="hidden" id="start_dt" value="<?php echo $data_action->start_dt; ?>">
                                <div class="card card-primary w-75">
                                    <div class="row p-2 text-center"
                                         style="box-shadow: 0 0 0; border-bottom: 1px solid white;">
                                        <div class="col-12">
                                            <button class="btn btn-danger  mr-2"
                                                    style="background-color:#696969;border-color:#696969;cursor:not-allowed;">
                                                <i class="fa fa-play"></i>
                                                <span class="text-but-st">เริ่มนับ</span>
                                            </button>
                                            <button id="stopBtn"
                                                    class="btn btn-danger text-but-st ml-2"
                                                    style=" background-color:#9b111e; border-color:#9b111e;">
                                                <i class="fa fa-stop"></i>
                                                <span class="text-but-st">หยุดนับ</span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center align-items-center p-2 pb-1 mb-1 mb-0">
                                        <h4 class="text-clock font-weight-bold mb-0" style="color: #9B111E;">
                                        <span id="hours"
                                              style="box-shadow: 0 0 0; border-bottom: 3px solid #222D32;">00</span>
                                            :
                                            <span id="minutes"
                                                  style="box-shadow: 0 0 0; border-bottom: 3px solid #222D32;">00</span>
                                            :
                                            <span id="seconds"
                                                  style="box-shadow: 0 0 0; border-bottom: 3px solid #222D32;">00</span>
                                        </h4>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <input type="hidden" id="start_dt" value="0000-00-00 00:00:00">
                                <div class="card card-primary w-75">
                                    <div class="row p-2 text-center"
                                         style="box-shadow: 0 0 0; border-bottom: 1px solid white;">
                                        <div class="col-12">
                                            <button class="btn btn-danger  mr-2 startAndGoBtn"
                                                    style="background-color:#9b111e;border-color:#9b111e;">
                                                <i class="fa fa-play"></i>
                                                <span class="text-but-st">เริ่มนับ</span>
                                            </button>
                                            <button id=""
                                                    class="btn btn-danger text-but-st ml-2"
                                                    style=" background-color:#696969; border-color:#696969;cursor:not-allowed;">
                                                <i class="fa fa-stop"></i>
                                                <span class="text-but-st">หยุดนับ</span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center align-items-center p-2 pb-1 mb-1 mb-0">
                                        <h4 class="text-clock font-weight-bold mb-0" style="color: #9B111E;">
                                        <span id=""
                                              style="box-shadow: 0 0 0; border-bottom: 3px solid #222D32;">00</span>
                                            :
                                            <span id=""
                                                  style="box-shadow: 0 0 0; border-bottom: 3px solid #222D32;">00</span>
                                            :
                                            <span id=""
                                                  style="box-shadow: 0 0 0; border-bottom: 3px solid #222D32;">00</span>
                                        </h4>
                                    </div>
                                </div>
                            <?php } ?>
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
                                <span class="number-icon"><?php echo $data_head->count_N; ?></span><br><span class="text-ico">ไม่สำเร็จ</span>
                            </a>
                        </div>
                        <div class="row col-12 packageinfostatus mt-4">
                            <span>จำนวน</span>
                        </div>
                        <div class="col-12 row d-flex justify-content-between">
                            <a class="btn btn-app pt-2 col-md-3 col"
                               style="background-color:#0364BE;color:#FFFFFF;min-width: 40px"> <span
                                        class="number-icon"><?php echo $data_head->sumQty; ?></span><br><span
                                        class="text-ico">ทั้งหมด</span></a>
                            <a class="btn btn-app pt-2 col-md-3 col"
                               style="background-color:#07A14E;color:#FFFFFF;min-width: 40px"> <span class="number-icon"><?php echo $data_head->sumQty_Y ; ?></span><br><span class="text-ico">สำเร็จ</span></a>
                            <a class="btn btn-app pt-2 col-md-3 col"
                               style="background-color:#A10303;color:#FFFFFF;min-width: 40px"> <span class="number-icon"><?php echo $data_head->sumQty_N ; ?></span><br><span class="text-ico">ไม่สำเร็จ</span></a>
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
                                               aria-selected="true"><span class="float-left text-white badge" style="border-color: #696969;background-color: #696969;font-size: 12px"><?php echo $data_head->count_X ; ?></span>&nbsp;รอนับ</a>
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
<!--                                            <tbody id="show-table"> -->
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row col-12 w-100 pt-3 pb-2 barcode_form"
                             style="<?php if ($data_action->assign_status == 31) {
                                 echo '';
                             } else {
                                 echo 'display:none';
                             } ?> ">
                            <div class="card card-primary card-outline card-outline-tabs col-md-12 pt-2 pb-2">
                                <!--                           <div style="height: calc(46vh - 80px)">-->
                                <div class="card-body pt-1">
                                    <div class="col-md-12" id="form_scan">
                                    </div>
                                </div>
                                <div class="overlay dark scan_barcode text-center">
                                    <h2 class="text-white">สแกนบาร์โค้ด หรือ กดที่นี่<br>&quot;เพื่อนับสินค้า&quot;</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">สแกนสินค้า</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Recipient:</label>
                            <input type="text" class="form-control" id="recipient-name">
                        </div>
                        <div class="form-group">
                            <div id="reader"></div>
                            <div id="result"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary"
                            style="background-color:#9b111e;border-color:#A10303">บันทึก
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                </div>
            </div>
        </div>
</section>
<script>

    if (typeof lastClickTime === 'undefined') {
        var lastClickTime = Date.now(); // ใช้ var หรือ let ประกาศครั้งเดียว
    }

    $(document).on('click', function (e) {
        const overlay = $('.scan_barcode');
        if (!$(e.target).closest('.swal2-container').length) {
            if (!$(e.target).closest('.barcode_form').length) {
                overlay.show();
            }
        }
        lastClickTime = Date.now();
    });

    setInterval(function () {
        const currentTime = Date.now();
        const timeSinceLastClick = currentTime - lastClickTime;
        const activeElement = document.activeElement;
        const isInSweetAlert = $(activeElement).closest('.swal2-container').length > 0;

        if (timeSinceLastClick >= 3000 && !isInSweetAlert) {
            $('#barcode').focus();
        }
    }, 1000);

    $(document).ready(function () {

        $('#barcode').focus();
        let pagLength = 1
        let table
        $('.scan_barcode').click(function () {
            $(this).css('display', 'none');
            $('#barcode').focus();
        })


        // let timerInterval = null;
        //
        // function formatTimeComponent(value) {
        //     return String(value).padStart(2, '0');
        // }
        //
        // function updateTimer(startDate) {
        //     if (!startDate) {
        //         clearInterval(timerInterval); // Stop the timer if no start date is provided
        //         return;
        //     }
        //     const currentDate = new Date();
        //     const elapsedSeconds = Math.floor((currentDate - startDate) / 1000);
        //     const hrs = Math.floor(elapsedSeconds / 3600);
        //     const mins = Math.floor((elapsedSeconds % 3600) / 60);
        //     const secs = elapsedSeconds % 60;
        //     if(secs < 0){
        //         $('#hours').text(formatTimeComponent(0));
        //         $('#minutes').text(formatTimeComponent(0));
        //         $('#seconds').text(formatTimeComponent(0));
        //     }else{
        //         $('#hours').text(formatTimeComponent(hrs));
        //         $('#minutes').text(formatTimeComponent(mins));
        //         $('#seconds').text(formatTimeComponent(secs));
        //     }
        //
        // }
        //
        // function initializeTimer(startDate) {
        //     clearInterval(timerInterval); // Clear any existing timer
        //     if (!startDate) {
        //         console.error("Invalid start date. Timer not initialized.");
        //         return;
        //     }
        //     updateTimer(startDate); // Update the display immediately
        //     timerInterval = setInterval(() => updateTimer(startDate), 1000); // Start the timer
        // }

        $('.refresh_page').click(function () {
            let soNo = $('#so_no').val();
            let assignNo = $('#assign_no').val();

            $.ajax({
                url: 'pages/emp/manage_pick.php',
                method: 'POST',
                data: {
                    soNo,
                    assignNo
                },
                success: function (response) {
                    $('#main-stage').html(response);


                    // const startTime = $('#start_dt').val();
                    // let startDate = Date.parse(startTime) ? new Date(startTime) : null;
                    // initializeTimer(startDate);


                    $.ajax({
                        url: 'component/emp/form_scanner_pick.php',
                        method: 'POST',
                        success: function (data) {
                            $('#form_scan').html(data);
                        }
                    });
                }
            });
        });

        // Get the new start time
        // const startTime = $('#start_dt').val();
        // let startDate = Date.parse(startTime) ? new Date(startTime) : null;
        //
        // // Initialize the timer with the new start date
        // initializeTimer(startDate);

        // $('.refresh_page').click(function () {
        //     // clearTimer();
        //     // location.reload()
        //     let soNo = $('#so_no').val()
        //     let assignNo = $('#assign_no').val()
        //     $.ajax({
        //         url: 'pages/emp/manage_pick.php',
        //         method: 'POST',
        //         data: {
        //             soNo,
        //             assignNo
        //         },
        //         success: function (response) {
        //             $('#main-stage').html(response)
        //
        //             $.ajax({
        //                 url: `component/emp/form_scanner_pick.php`,
        //                 method: 'POST',
        //                 data: {},
        //                 success: function (data) {
        //                     $('#form_scan').html(data)
        //
        //                 }
        //             })
        //
        //         }
        //     });
        // })

// count time
        let timerInterval = null;


        // function clearTimer() {
        //     if (timerInterval) {
        //         clearInterval(timerInterval);
        //         timerInterval = null;
        //     }
        // }

        function formatTimeComponent(value) {
            return String(value).padStart(2, '0');
        }
        function updateTimer(startDate) {
            if (!startDate) {
                // console.error("Invalid start date. Timer stopped.");
                clearInterval(timerInterval); // หยุดการทำงานหาก startDate ไม่มีค่า
                return;
            }
            const currentDate = new Date();
            const elapsedSeconds = Math.floor((currentDate - startDate) / 1000);
            const hrs = Math.floor(elapsedSeconds / 3600);
            const mins = Math.floor((elapsedSeconds % 3600) / 60);
            const secs = elapsedSeconds % 60;
            $('#hours').text(formatTimeComponent(hrs));
            $('#minutes').text(formatTimeComponent(mins));
            $('#seconds').text(formatTimeComponent(secs));
        }
        function initializeTimer(startDate) {
            if (!startDate) {
                // console.error("Invalid start date. Timer not initialized.");
                return;
            }
            const currentDate = new Date();
            const elapsedSeconds = Math.floor((currentDate - startDate) / 1000);
            const hrs = Math.floor(elapsedSeconds / 3600);
            const mins = Math.floor((elapsedSeconds % 3600) / 60);
            const secs = elapsedSeconds % 60;
            $('#hours').text(formatTimeComponent(hrs));
            $('#minutes').text(formatTimeComponent(mins));
            $('#seconds').text(formatTimeComponent(secs));
        }
        const startTime = $('#start_dt').val();
        let startDate = null;
        if (startTime) {
            startDate = Date.parse(startTime) ? new Date(startTime) : null;
            if (!startDate) {
            }
        } else {
            // startDate = new Date()
        }
        initializeTimer(startDate);
        if (startDate) {
            timerInterval = setInterval(() => updateTimer(startDate), 1000);
        }
// count time

        let sale_order_id = $('#so_no').val()
        let assign_id_show = $('#assign_no').val()

        $.ajax({
            url: `component/emp/form_scanner_pick.php`,
            method: 'POST',
            data: {},
            success: function (data) {
                $('#form_scan').html(data)
            }
        })


        if ($.fn.DataTable.isDataTable("#show-table-tb")) {
            let table = $("#show-table-tb").DataTable();
            table.clear().destroy();
        }
        var bottomMargin = 720;
        $.ajax({
            url: `component/emp/table_manage_pick.php`,
            method: 'POST',
            data: {tab: 'wait_process', so_id: sale_order_id, assign_id: assign_id_show},
            success: function (data) {
                $('#show-table-tb tbody').html(data);

                table = $("#show-table-tb").DataTable({
                    retrieve: false,
                    destroy: true,
                    scrollX: true,
                    // scrollY: '20vh',
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
                    pageLength: 5,
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
                url: `component/emp/table_manage_pick.php`,
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
                            // scrollY: '20vh',
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
                            pageLength: 5,
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

        //$('.clearTbTemp').click(function () {
        //    localStorage.removeItem('selectWarehouse')
        //    let data_arr = $(this).attr('id').split('_')
        //    console.log(data_arr[0])
        //    let soNO = $('#so_no').val()
        //    let assignNo = $('#assign_no').val()
        //    //href="order_scanner_pick.php?so_id=<?php ////echo $so_id ;  ?>////&assign_id=<?php ////echo $assign_no ?>////"
        //    $.ajax({
        //        url: `pages/emp/scanner_pick.php`,
        //        method: 'POST',
        //        data: {
        //            soNO,
        //            assignNo
        //        },
        //        success: function (response) {
        //            $('#main-stage').html(response);
        //        },
        //        error: function (xhr, status, error) {
        //            console.error("Error loading content: " + status + " " + error);
        //        }
        //    });
        //    // $.ajax({
        //    //     url: `api/pick_scanner/deleteTbTemp.php`,
        //    //     method: 'POST',
        //    //     data: {
        //    //         so_id: data_arr[0],
        //    //         assign_no: data_arr[1]
        //    //     },
        //    //     success: function (data) {
        //    //         console.log(data)
        //    //         window.location.href = 'order_scanner_pick.php?so_id=' + data_arr[0] + '&assign_id=' + data_arr[1]
        //    //     }
        //    // });
        //})

        $('.startAndGoBtn').click(function () {

            function getCurrentDateTime() {
                const now = new Date();

                // Get year, month, and day
                const year = now.getFullYear();
                const month = String(now.getMonth() + 1).padStart(2, '0'); // Months are 0-based
                const day = String(now.getDate()).padStart(2, '0');

                // Get hours, minutes, and seconds
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const seconds = String(now.getSeconds()).padStart(2, '0');

                // Combine into desired format
                return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
            }
            // display
            $('.barcode_form').css('display', '');
            $(this).prop('disabled', true).css({
                'background-color': '#696969',
                'border-color': '#696969',
                'cursor': 'not-allowed'
            });
            $('#stopBtn').prop('disabled', false).css({
                'background-color': '#9b111e',
                'border-color': '#9b111e',
                'cursor': 'pointer'
            });
            // display

            //action
            let soId = $('#so_no').val()
            let assId = $('#assign_no').val()
            $.ajax({
                url: `controller/emp/post_scan_pick.php`,
                method: 'POST',
                data: {
                    action: 'updateStartPick',
                    so_no: soId,
                    assign_no: assId,
                },
                success: function (data) {
                    // location.reload()
                    $('.refresh_page').click()
                    // setTimeout(function (){
                    //     $('#start_dt').val(getCurrentDateTime());
                    // })
                }
            });
            //action
        })

        $('#stopBtn').click(function () {
            $(this).prop('disabled', true).css({
                'background-color': '#696969',
                'border-color': '#696969',
                'cursor': 'not-allowed'
            });

            $('#stopBtn').prop('disabled', false).css({
                'background-color': '#9b111e',
                'border-color': '#9b111e',
                'cursor': 'pointer'
            });

            let soId = $('#so_no').val()
            let assId = $('#assign_no').val()
            let empId = $('#emp_id').val()

            const hours = document.getElementById("hours").textContent;
            const minutes = document.getElementById("minutes").textContent;
            const seconds = document.getElementById("seconds").textContent;

            Swal.fire({
                title: "ยืนยันการหยุดทำงาน?",
                text: "คุณต้องการหยุดนับสินค้าและส่งให้หัวหน้า?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#00A65A",
                allowOutsideClick: false,
                cancelButtonColor: "#808080",
                confirmButtonText: "ยีนยัน",
                cancelButtonText: "ปิด"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'controller/emp/getCheckFlagList.php',
                        method: 'POST',
                        data: {
                            so_id: soId,
                        },
                        success: async function (data) {
                            let res_data = JSON.parse(data)
                            console.log(res_data)
                            if (res_data.count_N > 0 || res_data.count_X > 0) {
                                console.log('เข้า N')
                                const {value: formValues} = await Swal.fire({
                                    title: `<span style="font-weight: normal">เวลาที่ใช้ในการนับ</span><br><br><span style="color: #a4111e;font-size: 24px">${hours} ชั่วโมง ${minutes} นาที ${seconds} วินาที</span>`,
                                    confirmButtonColor: "#a4111e",
                                    cancelButtonColor: "#808080",
                                    confirmButtonText: "ส่งหัวหน้า",
                                    cancelButtonText: "ย้อนกลับ",
                                    allowOutsideClick: false,
                                    html:
                                        `
                                         <select style="width: 100%;font-size: large"  id="remarkSelect" class="swal2-input">
                                               <option disabled selected >กรุณาเลือกประเภทหมายเหตุ</option>
                                              <option value="1">สินค้าชำรุด</option>
                                              <option value="2">หาสินค้าไม่เจอ</option>
                                              <option value="3">สินค้าไม่มีในสต็อค</option>
                                              <option value="4">ทำงานไม่ทัน</option>
                                              <option value="5">ขอสลับหน้าที่</option>
                                              <option value="6">ลาป่วย/ลากิจ</option>
                                              <option value="7">ลืมออกจากระบบ</option>
                                              <option value="8">อื่นๆ</option>
                                         </select>
                                         <label style="float: left;margin-top: 12px;font-size: 20px" for="remarkText" >คำอธิบาย</label>
                                         <br>
                                         <textarea style="margin-top: 0px;width: 70%;font-size: large" id="remarkText" class="swal2-textarea" placeholder=""></textarea>`,
                                    showCancelButton: true,
                                    preConfirm: () => {
                                        const stopTime = hours+':'+minutes+':'+seconds
                                        const selectedOption = document.getElementById("remarkSelect").value;
                                        const text = document.getElementById("remarkText").value;
                                        if (selectedOption === 'กรุณาเลือกประเภทหมายเหตุ') {
                                            Swal.showValidationMessage("กรุณาเลือกประเภทหมายเหตุ");
                                            return false;
                                        }
                                        if (!text) {
                                            Swal.showValidationMessage("กรุณาป้อนคำอธิบาย");
                                            return false;
                                        }
                                        return {selectedOption,stopTime, text};
                                        // console.log(selectedOption)
                                    }
                                });
                                if (formValues) {
                                    const {stopTime, text, selectedOption} = formValues;
                                    // Swal.fire(`You Time: ${stopTime}`, `Your message: ${text}`,`You Select:${selectedOption}`);
                                    let stop_time = stopTime
                                    let remark_text = text
                                    let remark_note = selectedOption
                                    console.log(stop_time)
                                    $.ajax({
                                        url: `controller/emp/post_scan_pick.php`,
                                        method: 'POST',
                                        data: {
                                            action: 'save_so',
                                            sub_action: 'N',
                                            so_id: soId,
                                            assign_no: assId,
                                            emp_id: empId,
                                            stopTime:stop_time,
                                            remark_text,
                                            remark_note
                                        },
                                        success: function (data) {
                                            // let response = JSON.parse(data)
                                            // console.log(response)
                                            // alert('บันทึกข้อมูลเรียบร้อย')
                                            Swal.fire({
                                                position: "center",
                                                icon: "success",
                                                title: "บันทึกข้อมูลเรียบร้อย",
                                                showConfirmButton: false,
                                                timer: 1500
                                            });
                                            setTimeout(function () {
                                                location.reload()
                                                // window.location.href = 'index_emp.php'
                                            }, 1500)
                                        }
                                    });
                                }
                            } else if ((res_data.wait_process == 0) && (res_data.count_N == 0)) {
                                console.log('Y ทั้งหมด')
                                Swal.fire({
                                    title: `<span style="font-weight: normal">เวลาที่ใช้ในการนับ</span><br><br><span style="color: #00A65A;font-size: 24px">${hours} ชั่วโมง ${minutes} นาที ${seconds} วินาที</span>`,
                                    showCancelButton: false,
                                    confirmButtonColor: "#00A65A",
                                    allowOutsideClick: false,
                                    // cancelButtonColor: "#808080",
                                    confirmButtonText: "ส่งหัวหน้า",
                                    // cancelButtonText: "ปิด"
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        let stopTime = hours+':'+minutes+':'+seconds
                                        $.ajax({
                                            url: `controller/emp/post_scan_pick.php`,
                                            method: 'POST',
                                            data: {
                                                action: 'save_so',
                                                sub_action: 'Y',
                                                so_id: soId,
                                                assign_no: assId,
                                                emp_id: empId,
                                                stopTime:stopTime,
                                            },
                                            success: function (data) {
                                                // let response = JSON.parse(data)
                                                // console.log(response)
                                                // $('#show-table').html(data)
                                                // location.reload()
                                                // alert('บันทึกข้อมูลเรียบร้อย')
                                                Swal.fire({
                                                    position: "center",
                                                    icon: "success",
                                                    title: "บันทึกข้อมูลเรียบร้อย",
                                                    showConfirmButton: false,
                                                    timer: 1500
                                                });
                                                setTimeout(function () {
                                                    location.reload()
                                                    // window.location.href = 'index_emp.php'
                                                }, 1500)
                                            }
                                        });
                                    }
                                })
                            }
                        }
                    });
                    // save condition Y
                }
            })
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
            location.reload()
            // $.ajax({
            //     url: 'pages/emp/dashboard.php',
            //     method: 'POST',
            //     success: function (response) {
            //         $('#main-stage').html(response);
            //
            //         setTimeout(function () {
            //             Swal.close()
            //         }, 500)
            //
            //     },
            //     error: function (xhr, status, error) {
            //         console.error("Error loading content: " + status + " " + error);
            //     }
            // });
        })

//         $('.save_scan').on('click', async function () {
//             event.preventDefault();
//             let saleId = $('#sale_id_get').val();
//             let assignId = $('#assign_id_get').val();
//             let productCode = $('#product_code').val();
//             let productName = $('#product_name').val();
//             let wareHouse = $('#ware_house').val();
//             // let productQty = $('#product_qty').val();
//             let productQty = 10;
//             let productCount = 9;
//
//             // console.log("Sale ID:", saleId);
//             // console.log("Assign ID:", assignId);
//             // console.log("Product Code:", productCode);
//             // console.log("Warehouse:", wareHouse);
//             // console.log("Product Quantity:", productQty);
//             // console.log("Product Count:", productCount);
//
//             if ((productQty - productCount) === 0) {
//                 Swal.fire({
//                     title: "ยืนยันการบันทึก?",
//                     text: "คุณต้องการบันทึกข้อมูลนี้ใช่หรือไม่!",
//                     icon: "question",
//                     showCancelButton: true,
//                     confirmButtonColor: "#00A65A",
//                     allowOutsideClick: false,
//                     cancelButtonColor: "#808080",
//                     confirmButtonText: "บันทึก",
//                     cancelButtonText: "ย้อนกลับ"
//                 }).then((result) => {
//                     if (result.isConfirmed) {
//                         // save condition Y
//                         $.ajax({
//                             url: 'api/pick_scanner/saveScan.php',
//                             method: 'POST',
//                             data: {
//                                 so_id: saleId,
//                                 assign_no: assignId,
//                                 prod_id: productCode,
//                                 prod_location: wareHouse,
//                                 count_scan: productCount,
//                                 type_assign: 'pick',
//                                 case: 'Y'
//
//                             },
//                             success: function (data) {
//                                 let res_data = JSON.parse(data)
//                                 // if(res_data.status === 200){
//                                 //     console.log('update success')
//                                 // }else{
//                                 //     console.log('update field')
//                                 // }
//                                 localStorage.removeItem('selectWarehouse')
//                                 reloadFrom(productCode, productName, wareHouse, productQty, productCount)
//                                 checkLastList('no_show')
//                             }
//                         });
//                     } else {
//                         reloadFromEdit(productCode, productName, wareHouse, productQty, productCount)
//                     }
//                 });
//             } else if ((productQty - productCount) > 0) {
//                 console.log('else if <')
//                 const {value: formValues} = await Swal.fire({
//                     title: "บันทึกหมายเหตุ",
//                     confirmButtonColor: "#00A65A",
//                     cancelButtonColor: "#808080",
//                     confirmButtonText: "บันทึก",
//                     cancelButtonText: "ย้อนกลับ",
//                     allowOutsideClick: false,
//                     html:
//                         `
// <!--                        <label style="float: right;" for="remarkSelect">ประเภท remark: </label>-->
//                          <select style="width: 100%;font-size: large"  id="remarkSelect" class="swal2-input">
//                                <option disabled selected>กรุณาเลือกประเภทหมายเหตุ</option>
//                               <option value="1">หาสินค้าไม่เจอ</option>
//                               <option value="2">เวลาในการจัดไม่เพียงพอ</option>
//                          </select>
//                         <br>
//                          <label style="float: left;margin-top: 12px;font-size: 20px" for="remarkText" >คำอธิบาย</label>
//                             <br>
//                          <textarea style="margin-top: 0px;width: 70%;font-size: large" id="remarkText" class="swal2-textarea" placeholder=""></textarea>`,
//                     showCancelButton: true,
//                     preConfirm: () => {
//                         const selectedOption = document.getElementById("remarkSelect").value;
//                         const text = document.getElementById("remarkText").value;
//                         // console.log(text)
//                         if (selectedOption === 'กรุณาเลือกประเภทหมายเหตุ') {
//                             Swal.showValidationMessage("กรุณาเลือกประเภทหมายเหตุ");
//                             return false;
//                         }
//                         if (!text) {
//                             Swal.showValidationMessage("กรุณาป้อนคำอธิบาย");
//                             return false;
//                         }
//                         return {selectedOption, text};
//                     }
//                 });
//                 if (formValues) {
//                     const {selectedOption, text} = formValues;
//                     // Swal.fire(`You selected: ${selectedOption}`, `Your message: ${text}`);
//                     let remark_type = selectedOption
//                     let remark_text = text
//                     $.ajax({
//                         url: 'api/pick_scanner/saveScan.php',
//                         method: 'POST',
//                         data: {
//                             so_id: saleId,
//                             assign_no: assignId,
//                             prod_id: productCode,
//                             prod_location: wareHouse,
//                             count_scan: productCount,
//                             type_assign: 'pick',
//                             remark_type,
//                             remark_text,
//                             case: 'N'
//
//                         },
//                         success: function (data) {
//                             // let res_data = JSON.parse(data)
//                             // if(res_data.status === 200){
//                             //     console.log('update success N')
//                             // }else{
//                             //     console.log('update field')
//                             // }
//                             localStorage.removeItem('selectWarehouse')
//                             reloadFrom(productCode, productName, wareHouse, productQty, productCount)
//                             checkLastList('no_show')
//                         }
//                     });
//                 } else {
//                     reloadFromEdit(productCode, productName, wareHouse, productQty, productCount)
//                 }
//             } else {
//                 Swal.fire({
//                     title: "พบข้อผิดพลาด?",
//                     text: "จำนวนที่นับได้มากกว่าจำนวนที่ต้องการ กรุณานับใหม่",
//                     icon: "error",
//                     // showCancelButton: true,
//                     confirmButtonColor: "#808080",
//                     allowOutsideClick: false,
//                     // cancelButtonColor: "#808080",
//                     confirmButtonText: "ปิด",
//                     // cancelButtonText: "ย้อนกลับ"
//                 }).then((result) => {
//                     if (result.isConfirmed) {
//                         console.log('ยืนยันการบันทึก')
//                         reloadFromEdit(productCode, productName, wareHouse, productQty, productCount)
//                     } else {
//                         reloadFromEdit(productCode, productName, wareHouse, productQty, productCount)
//                     }
//                 });
//             }
//         })

        $("#customSearchInput").on("keyup", function () {
            const searchValue = $(this).val();
            if (table) {
                console.log("Searching for:", searchValue);
                table.search(searchValue).draw();
            }
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