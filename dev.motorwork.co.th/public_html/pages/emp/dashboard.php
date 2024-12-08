<?php

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

session_start();

include '../../config/connect.php';
?>
<style>

    @media (max-height: 700px) {
        #table_dashboard_emp_wrapper .dataTables_scrollBody {
            height: 32vh !important;
        }
    }

    @media (min-height: 701px) and (max-height: 800px) {
        #table_dashboard_emp_wrapper .dataTables_scrollBody {
            height: 40vh !important;
        }
    }

    @media (min-height: 801px) and (max-height: 900px) {
        #table_dashboard_emp_wrapper .dataTables_scrollBody {
            height: 50vh !important;
        }
    }

    @media (min-height: 901px) and (max-height: 1078px) {
        #table_dashboard_emp_wrapper .dataTables_scrollBody {
            height: 50vh !important;
        }
    }

    @media (min-height: 1079px) {
        #table_dashboard_emp_wrapper .dataTables_scrollBody {
            height: 60vh !important;

        }
        .dataTables_wrapper .dataTables_paginate ul.pagination {
            margin-top: 10px!important;
            margin-bottom: 15px!important;
        }
        .dataTables_wrapper .dataTables_info {
            margin-top: 80px!important;
            /*margin-bottom: 10px!important;*/

        }
        .main-footer {
            position: fixed;  /* ทำให้ footer ลอย */
            bottom: 0;        /* ให้มันอยู่ที่ด้านล่างสุด */
            width: 100%;      /* ทำให้ footer ขยายเต็มความกว้าง */
            height: 60px;
            padding-top: 20px; /* ปรับ padding เพื่อไม่ให้ติดกับขอบล่าง */
            text-align: left; /* จัดตำแหน่งข้อความให้อยู่กลาง */
        }
        .content {
            padding-top: 15px!important;
        }

    }

    /* ปิดการคำนวณความกว้างอัตโนมัติ */

    /*table.dataTable {*/
    /*    overflow-x: auto;*/
    /*    table-layout: fixed; !* ใช้ table-layout: fixed เพื่อควบคุมความกว้างคอลัมน์ *!*/
    /*    width: 200% !important;*/
    /*}*/


    /* กำหนดขนาดคอลัมน์ที่ต้องการ */
    /*table.dataTable th:nth-child(1), table.dataTable td:nth-child(1) {*/
    /*    width: 8% !important; !* คอลัมน์งาน *!*/
    /*}*/
    /*table.dataTable th:nth-child(2), table.dataTable td:nth-child(2) {*/
    /*    width: 10% !important; !* คอลัมน์สถานะ *!*/
    /*}*/
    /*table.dataTable th:nth-child(3), table.dataTable td:nth-child(3) {*/
    /*    width: 10% !important; !* คอลัมน์เลขที่ใบขาย *!*/
    /*}*/
    /*table.dataTable th:nth-child(4), table.dataTable td:nth-child(4) {*/
    /*    width: 10% !important; !* คอลัมน์วันที่มอบหมาย *!*/
    /*}*/
    /*table.dataTable th:nth-child(5), table.dataTable td:nth-child(5) {*/
    /*    width: 10% !important; !* คอลัมน์วันที่ใบขาย *!*/
    /*}*/
    /*table.dataTable th:nth-child(6), table.dataTable td:nth-child(6) {*/
    /*    width: 10% !important; !* คอลัมน์รหัสลูกค้า *!*/
    }

    /*table.dataTable th:nth-child(7), table.dataTable td:nth-child(7) {*/
    /*    width: 250px !important; !* คอลัมน์ลูกค้า *!*/
    /*}*/
    /*table.dataTable th:nth-child(8), table.dataTable td:nth-child(8) {*/
    /*    width: 10% !important; !* คอลัมน์จำนวน *!*/
    /*}*/
    /*table.dataTable th:nth-child(9), table.dataTable td:nth-child(9) {*/
    /*    width: 10% !important; !* คอลัมน์ Packing Number *!*/
    /*}*/
    /*table.dataTable th:nth-child(10), table.dataTable td:nth-child(10) {*/
    /*    width: 12% !important; !* คอลัมน์เวลาที่ใช้ *!*/
    /*}*/
    /*table.dataTable th:nth-child(11), table.dataTable td:nth-child(11) {*/
    /*    width: 8% !important; !* คอลัมน์พิมพ์ *!*/
    /*}*/


    /*table.dataTable th:nth-child(8), table.dataTable td:nth-child(8) {*/
    /*    width: 10% !important; !* คอลัมน์จำนวน *!*/
    /*}*/

    /*table.dataTable th:nth-child(9), table.dataTable td:nth-child(9) {*/
    /*    width: 10% !important; !* คอลัมน์ Packing Number *!*/
    /*}*/

    /*!* Sticky columns *!*/
    /*td {*/
    /*    text-align: left;*/
    /*    overflow: hidden;*/
    /*}*/
    
    /* td:nth-child(1),*/
    /* td:nth-child(2) {*/
    /*    position: sticky;*/
    /*    background-color: white;*/
    /*    z-index: 10; !* Ensure the sticky columns are above the other columns *!*/
    /*}*/
    
    /*td:nth-child(1) {*/
    /*    left: 0;*/
    /*    background-color: white; !* Sticky column 2 will have white background *!*/
    /*}*/
    /*td:nth-child(2) {*/
    /*    left: 68px;*/
    /*    background-color: white; !* Sticky column 2 will have white background *!*/
    /*}*/
    
    
    /*!* Optionally, adjust background color of even/odd rows or columns in the table *!*/
    /*table tbody tr:nth-child(even) td {*/
    /*    background-color: #f2f2f2; !* Alternating row background *!*/
    /*}*/
    
    /*table tbody tr:nth-child(odd) td {*/
    /*    background-color: white; !* Alternating row background *!*/
    /*}*/

    /*.dataTables_wrapper .dataTables_paginate {*/
    /*    text-align: left; !* ชิดซ้าย *!*/
    /*}*/





    .daterangepicker {
        border: 2px solid #9B111E;
    }

    .daterangepicker .ranges li.active {
        color: white; /* เปลี่ยนสีของตัวอักษรเป็นสีแดง */
        background-color: #9B111E; /* เปลี่ยนสีพื้นหลังเป็นสีแดงอ่อน */
    }

    .daterangepicker .drp-calendar .calendar-table td.in-range {
        background-color: rgba(211, 105, 114, 0.08); /* สีพื้นหลังของวันที่อยู่ระหว่าง */

    }

    .daterangepicker .drp-calendar .calendar-table td.active.end-date {
        color: white;
        background-color: #9B111E; /* สีพื้นหลังของวันสุดท้าย */
    }

    /* เปลี่ยนสีพื้นหลังของปุ่มยกเลิก */
    .daterangepicker .cancelBtn {
        background-color: #333; /* สีพื้นหลังปุ่มยกเลิก (สีแดง) */
        color: white; /* สีข้อความในปุ่ม */
    }

    /* เปลี่ยนสีของปุ่มยกเลิกเมื่อ hover */
    .daterangepicker .cancelBtn:hover {
        background-color: #333; /* เปลี่ยนสีพื้นหลังเมื่อ hover */
    }

    /* เปลี่ยนสีของปุ่มยกเลิกเมื่อถูกคลิก */
    .daterangepicker .cancelBtn:active {
        background-color: #333; /* สีพื้นหลังเมื่อคลิกปุ่ม */
    }


    /* เปลี่ยนสีปุ่มของ daterangepicker */
    .daterangepicker .ranges li {
        background-color: #f0f0f0; /* สีพื้นหลังของรายการ */
        color: #333; /* สีข้อความ */
    }

    /* เปลี่ยนสีของปุ่มเลือกวันที่ */
    .daterangepicker .applyBtn {
        background-color: #9B111E; /* สีพื้นหลังปุ่ม "Apply" */
        color: white; /* สีข้อความในปุ่ม */
        border-color: #9B111E;
    }

    .daterangepicker .applyBtn:hover {
        background-color: #9B111E; /* เปลี่ยนสีเมื่อ hover */
    }

    /* เปลี่ยนสีของวันที่ในปฏิทิน */
    .daterangepicker .calendar-table td.active {
        background-color: #9B111E; /* สีพื้นหลังของวันที่ที่เลือก */
        color: white; /* สีข้อความ */
    }

    table.dataTable thead tr th {
        /*word-wrap: break-word;*/
        /*word-break: break-all;*/
    }

    table.dataTable tbody tr td {
        font-size: 16px;
        /*word-wrap: break-word;*/
        /*word-break: break-all;*/
    }

    .custom-dropdown {
        width: 400px;
        max-width: 80%;
        margin: 0 auto;
        left: 10%;
        right: 10%;
    }

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

    @media (max-width: 400px) {
        .small-box {

        }
        .tab_search{
            font-size: 14px;
        }
    }

    .nav-tabs .nav-link.active {
        border-top: 3px solid #9B111E !important;
    }

    @media (max-width: 768px) {
        .custom-dropdown {
            width: 100%;
            left: 0;
            right: 0;
        }
    }

    @media (max-width: 576px) {
        .small-box .inner {
            height: 60px;
        }
        .tab_search{
            font-size: 12px;
        }
    }

    @media (max-width: 400px) {
        .small-box-footer.tab_search {
            flex-direction: column; /* เปลี่ยน Flex ให้เรียงจากบนลงล่าง */
            height: auto; /* ปล่อยความสูงตามเนื้อหา */
        }
        .small-box-footer.tab_search i {
            margin-top: 5px; /* เพิ่มระยะห่างระหว่างข้อความกับไอคอน */
        }
    }

    @media (max-width: 767px) {
        .dataTables_paginate {
            text-align: center; /* จัดตำแหน่ง pagination ชิดซ้าย */
            display: flex;    /* ใช้ flexbox เพื่อควบคุมตำแหน่ง */
            justify-content: center;
            /*padding-left: 0; !* ลบระยะห่าง *!*/
        }

        .dataTables_wrapper .dataTables_info {
            text-align: center!important;
            padding-left: 7.5px!important;
        }

        .dataTables_wrapper .dataTables_paginate ul.pagination {
            /*display: inline-block;*/
            /*display: flex;*/
            justify-content: center!important;
            /*margin: 0 5px; !* ระยะห่างระหว่างปุ่ม *!*/
            /*width: auto;*/
        }

        .small-box .inner {
            height: 60px; /* กำหนดความสูงที่ต้องการ */
        }

    }

    .small-box-footer.tab_search {
        display: flex; /* ใช้ Flexbox เพื่อให้เนื้อหาชิดซ้ายหรือกลาง */
        justify-content: center; /* จัดเนื้อหาให้อยู่กลางปุ่ม */
        align-items: center; /* จัดแนวในแนวตั้งให้อยู่กลาง */
        width: 100%; /* ทำให้ปุ่มกว้างเต็มพื้นที่ */
        /*height: 60px; !* ควบคุมความสูงของปุ่ม *!*/
        text-align: center;
    }

    .dataTables_info{
        margin-bottom: 5px;
        padding-bottom: 5px;
    }

</style>

<!--<section class="content-header">-->
<!--    <h1> Dashboard </h1>-->
<!--</section>-->
<section class="content pt-2">
    <div class="row" style="display: flex; justify-content: space-between;">
        <div class="p-1 text-card" style="flex: 0 0 18%;">
            <div class="small-box " style="background-color:whitesmoke ">
                <div class="inner">
                    <h3 style="color:#6C757D" id="st_all"></h3>
                    <p>&nbsp;</p>
                </div>
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="70px" height="70px" viewBox="0 0 32 32">
                        <rect width="32" height="32" fill="none"/>
                        <path fill="#6C757D"
                              d="m25.7 9.3l-7-7c-.2-.2-.4-.3-.7-.3H8c-1.1 0-2 .9-2 2v24c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V10c0-.3-.1-.5-.3-.7M18 4.4l5.6 5.6H18zM24 28H8V4h8v6c0 1.1.9 2 2 2h6z"/>
                        <path fill="#6C757D" d="M10 22h12v2H10zm0-6h12v2H10z"/>
                    </svg>
                </div>
                <a class="small-box-footer tab_search text-white" id="all"
                   style="cursor: pointer;background-color: #6C757D;color:whitesmoke;">
                    ทั้งหมด&nbsp; <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="p-1 text-card" style="flex: 0 0 18%;">
            <!-- small box -->
            <div class="small-box " style="background-color:#1e90ff ">
                <div class="inner">
                    <h3 style="color:#fff" id="st_assign"></h3>
                    <p>&nbsp;</p>
                </div>
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="82" height="82" viewBox="0 0 32 32">
                        <g fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                            <path d="M2 21a8 8 0 0 1 13.292-6"/>
                            <circle cx="10" cy="8" r="5"/>
                            <path d="m16 19l2 2l4-4"/>
                        </g>
                    </svg>
                </div>
                <a class="small-box-footer tab_search text-white" id="assign" style="cursor: pointer;">
                    มอบหมาย&nbsp; <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="p-1 text-card" style="flex: 0 0 18%;">
            <!-- small box -->
            <!--            <div class="small-box " style="background-color:#ffdf00">-->
            <div class="small-box bg-yellow text-white">
                <div class="inner">
                    <h3 style="color:#fff" id="st_onprocess"></h3>
                    <p>&nbsp;</p>
                </div>
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" viewBox="0 0 24 24">
                        <g fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                            <path d="M12 22v-9m3.17-10.79a1.67 1.67 0 0 1 1.63 0L21 4.57a1.93 1.93 0 0 1 0 3.36L8.82 14.79a1.66 1.66 0 0 1-1.64 0L3 12.43a1.93 1.93 0 0 1 0-3.36z"/>
                            <path d="M20 13v3.87a2.06 2.06 0 0 1-1.11 1.83l-6 3.08a1.93 1.93 0 0 1-1.78 0l-6-3.08A2.06 2.06 0 0 1 4 16.87V13"/>
                            <path d="M21 12.43a1.93 1.93 0 0 0 0-3.36L8.83 2.2a1.64 1.64 0 0 0-1.63 0L3 4.57a1.93 1.93 0 0 0 0 3.36l12.18 6.86a1.64 1.64 0 0 0 1.63 0z"/>
                        </g>
                    </svg>
                </div>
                <a class="small-box-footer tab_search text-white" id="onprocess"
                   style="cursor: pointer;color: white!important;">
                    กำลังทำ&nbsp; <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="p-1 text-card" style="flex: 0 0 18%;">
            <!-- small box -->
            <div class="small-box  bg-green">
                <div class="inner">
                    <h3 id="st_success"></h3>
                    <p>&nbsp;</p>
                </div>
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" viewBox="0 0 24 24">
                        <path fill="white"
                              d="M10.591 2.513a3.75 3.75 0 0 1 2.818 0l7.498 3.04A1.75 1.75 0 0 1 22 7.175v5.635a6.5 6.5 0 0 0-1.5-1.077v-3.96l-7.75 2.992v2.298a6.5 6.5 0 0 0-1.5 2.645v-4.944L3.5 7.75v9.078a.25.25 0 0 0 .156.231l7.499 3.04q.047.02.095.036l.189.076q.088.036.179.06c.248.526.565 1.014.94 1.451a3.75 3.75 0 0 1-1.967-.233l-7.498-3.04A1.75 1.75 0 0 1 2 16.827V7.176a1.75 1.75 0 0 1 1.093-1.622zm2.254 1.39a2.25 2.25 0 0 0-1.69 0L9.24 4.68l7.527 2.927l2.67-1.03zM4.59 6.564l7.411 2.883l2.69-1.04L7.216 5.5zM17.5 23.001a5.5 5.5 0 1 0 0-11a5.5 5.5 0 0 0 0 11m-1-4.207l3.646-3.647a.5.5 0 0 1 .708.707l-4 4a.5.5 0 0 1-.708 0l-2-2a.5.5 0 0 1 .708-.707z"/>
                    </svg>
                </div>
                <a class="small-box-footer  tab_search" id="success" style="cursor: pointer">
                    สำเร็จ&nbsp; <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="p-1 text-card" style="flex: 0 0 18%;">
            <!-- small box -->
            <div class="small-box  bg-red">
                <div class="inner">
                    <h3 style="color:#fff" id="st_unsuccess"></h3>
                    <p>&nbsp;</p>
                </div>
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" viewBox="0 0 24 24">
                        <path fill="white"
                              d="M10.591 2.513a3.75 3.75 0 0 1 2.818 0l7.498 3.04A1.75 1.75 0 0 1 22 7.175v5.635a6.5 6.5 0 0 0-1.5-1.077v-3.96l-7.75 2.992v2.298a6.5 6.5 0 0 0-1.5 2.645v-4.944L3.5 7.75v9.078a.25.25 0 0 0 .156.231l7.499 3.04q.047.02.095.036v-.841a6.5 6.5 0 0 0 1.307 2.428a3.75 3.75 0 0 1-1.966-.233l-7.498-3.04A1.75 1.75 0 0 1 2 16.827V7.176a1.75 1.75 0 0 1 1.093-1.622zm2.254 1.39a2.25 2.25 0 0 0-1.69 0L9.24 4.68l7.527 2.927l2.669-1.03zm1.846 4.505L7.215 5.5L4.59 6.564l7.411 2.882zM23 17.5a5.5 5.5 0 1 1-11 0a5.5 5.5 0 0 1 11 0m-7.146-2.354a.5.5 0 0 0-.708.707l1.647 1.647l-1.647 1.646a.5.5 0 0 0 .708.708l1.646-1.647l1.646 1.647a.5.5 0 0 0 .708-.708L18.207 17.5l1.647-1.647a.5.5 0 0 0-.708-.707L17.5 16.794z"/>
                    </svg>
                </div>
                <a class="small-box-footer tab_search" id="unsuccess" style="cursor: pointer;">
                    ไม่สำเร็จ&nbsp; <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="card mt-2" >
        <div class="card-header d-flex justify-content-between align-items-center card-header-bg card-outline pt-4">
            <h3 class="card-title w-50 d-flex justify-content-start ">งานที่ได้รับมอบหมาย</h3>
            <div class="card-tools w-50 d-flex justify-content-end">
                <div class="input-group input-group-sm" style="width: 250px;">
                    <input type="text" id="customSearchInput" class="form-control float-right" placeholder="ค้นหา....">
                    <div class="input-group-append">
                        <button type="button" id="customSearchBtn" class="btn btn-default">
                            <i class="fas fa-search"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-default nav-link dropdown-toggle"
                                data-toggle="modal" data-target="#modal-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24">
                                <path fill="black"
                                      d="M21 3H5a1 1 0 0 0-1 1v2.59c0 .523.213 1.037.583 1.407L10 13.414V21a1 1 0 0 0 1.447.895l4-2c.339-.17.553-.516.553-.895v-5.586l5.417-5.417c.37-.37.583-.884.583-1.407V4a1 1 0 0 0-1-1m-6.707 9.293A1 1 0 0 0 14 13v5.382l-2 1V13a1 1 0 0 0-.293-.707L6 6.59V5h14.001l.002 1.583z"/>
                            </svg>
                        </button>
                        <div class="modal fade" id="modal-lg">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header p-2">
                                        <h5 class="modal-title">ค้นหาละเอียด</h5>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group" style="margin-bottom: 1rem;">
                                                    <label>วันที่ใบขาย</label>
                                                    <div class="input-group pt-1">
                                                        <div class="input-group-prepend">
                                                          <span class="input-group-text">
                                                            <i class="far fa-calendar-alt"></i>
                                                          </span>
                                                        </div>
                                                        <button type="button" style="border-radius: 0"
                                                                class="btn btn-default float-right" id="daterange-btn">
                                                            วันนี้
                                                            <i class="fas fa-caret-down"></i>
                                                        </button>
                                                        <input type="text" class="form-control float-right"
                                                               id="reservation">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group" style="margin-bottom: 1rem;">
                                                    <label>วันที่มอบหมาย</label>
                                                    <div class="input-group pt-1">
                                                        <div class="input-group-prepend">
                                                          <span class="input-group-text">
                                                            <i class="far fa-calendar-alt"></i>
                                                          </span>
                                                        </div>
                                                        <button type="button" style="border-radius: 0"
                                                                class="btn btn-default float-right" id="daterange-btn2">
                                                            วันนี้
                                                            <i class="fas fa-caret-down"></i>
                                                        </button>
                                                        <input type="text" class="form-control float-right"
                                                               id="reservation2">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="order_code">Packing Number</label>
                                                    <input type="text" id="order_code" class="form-control"
                                                           name="order_code" placeholder="ป้อน Packing Number">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="order_code">เลขที่ใบขาย</label>
                                                    <input type="text" id="order_code" class="form-control"
                                                           name="order_code" placeholder="ป้อนเลขที่ใบขาย">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="customer_code">รหัสลูกค้า</label>
                                                    <input type="text" id="customer_code" class="form-control"
                                                           name="customer_code" placeholder="ป้อนรหัสลูกค้า">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="customer_name">ชื่อลูกค้า</label>
                                                    <input type="text" id="customer_name" class="form-control"
                                                           name="customer_name" placeholder="ป้อนชื่อลูกค้า">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="member_pick">พนักงานหยิบ</label>
                                                    <select class="form-control" name="member_pick">
                                                        <option value="">--ตัวเลือก--</option>
                                                        <?php
                                                        $sql11 = "SELECT * FROM  tb_employee WHERE role_no='3' AND emp_status='1' ORDER BY  emp_name";
                                                        $query11 = $mysqli->query($sql11); // ทำการ query คำสั่ง sql
                                                        $find11 = $query11->num_rows;  // นับจำนวนถวที่แสดง ทั้งหมด
                                                        if ($find11 > 0) {
                                                            while ($mem1 = $query11->fetch_array()) { // วนลูปแสดงข้อมูล
                                                                $member_id = $mem1['emp_id'];
                                                                $member_name = $mem1['emp_name'] . '&nbsp;' . $mem1['emp_surname'];
                                                                ?>
                                                                <option value="<?php echo $member_id ?>"><?php echo $member_name ?></option>
                                                            <?php }
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="member_pack">พนักงานแพ็ค</label>
                                                    <select class="form-control" name="member_pack">
                                                        <option value="">--ตัวเลือก--</option>
                                                        <?php
                                                        $sql11 = "SELECT * FROM  tb_employee WHERE role_no='3' AND emp_status='1' ORDER BY  emp_name";
                                                        $query11 = $mysqli->query($sql11); // ทำการ query คำสั่ง sql
                                                        $find11 = $query11->num_rows;  // นับจำนวนถวที่แสดง ทั้งหมด
                                                        if ($find11 > 0) {
                                                            while ($mem1 = $query11->fetch_array()) { // วนลูปแสดงข้อมูล
                                                                $member_id = $mem1['emp_id'];
                                                                $member_name = $mem1['emp_name'] . '&nbsp;' . $mem1['emp_surname'];
                                                                ?>
                                                                <option value="<?php echo $member_id ?>"><?php echo $member_name ?></option>
                                                            <?php }
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <!-- สถานะ -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="order_status">สถานะ</label>
                                                    <select class="form-control" name="order_status">
                                                        <option value="">--ตัวเลือก--</option>
                                                        <option value="1">รอมอบหมาย</option>
                                                        <option value="2">มอบหมายงาน</option>
                                                        <option value="3">กำลังหยิบ</option>
                                                        <option value="41">หยิบสำเร็จ</option>
                                                        <option value="4">หยิบไม่สำเร็จ</option>
                                                        <option value="42">จบงานหยิบ</option>
                                                        <option value="43">รอมอบหมายใหม่ (หยิบ)</option>
                                                        <option value="5">กำลังแพ็ค</option>
                                                        <option value="61">แพ็คสำเร็จ</option>
                                                        <option value="6">แพ็คไม่สำเร็จ</option>
                                                        <option value="62">รอมอบหมายใหม่ (แพ็ค)</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- สถานะ -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="order_status">งานที่ถูกมอบหมาย</label>
                                                    <select class="form-control" name="order_status">
                                                        <option value="">--ตัวเลือก--</option>
                                                        <option value="1">หยิบ</option>
                                                        <option value="1">แพ็ค</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-end">
                                        <button type="button" class="btn btn-primary"
                                                style="background-color: #9B111E;border-color: #9B111E">ค้นหา
                                        </button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">เคลียร์
                                        </button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

<!--        <div class="card-body table-responsive p-2 " style="height: calc(100vh - 300px);">-->
        <div class="card-body table-responsive p-2 ">
            <table id="table_dashboard_emp" class="w-100 table nowrap table-hover table-bordered table-striped rounded" >
                <thead>
                <tr>
                    <th style="text-align: center; font-size: 16px;">งาน</th>
                    <th style="text-align: center; font-size: 16px;">สถานะ</th>
                    <th style="text-align: center; font-size: 16px;">เลขที่ใบขาย</th>
                    <th style="text-align: center; font-size: 16px;">วันที่มอบหมาย</th>
                    <th style="text-align: center; font-size: 16px">วันที่ใบขาย</th>
                    <th style="text-align: center; font-size: 16px;">รหัสลูกค้า</th>
                    <th style="text-align: center; font-size: 16px;width: 150px">ลูกค้า</th>
                    <th style="text-align: center; font-size: 16px;">จำนวน</th>
                    <th style="text-align: center; font-size: 16px;">Packing Number</th>
                    <th style="text-align: center; font-size: 16px;">เวลาที่ใช้</th>
                    <th style="text-align: center; font-size: 16px;">พิมพ์</th>
                </tr>
                </thead>
                <tbody id="show-list">
                </tbody>
            </table>
        </div>
    </div>
</section>
<script>

    $('#daterange-btn2').daterangepicker({
            ranges: {
                'วันนี้': [moment(), moment()],
                'เมื่อวาน': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                '7 วันย้อนหลัง': [moment().subtract(6, 'days'), moment()],
                'เดือนนี้': [moment().startOf('month'), moment().endOf('month')]
            },
            startDate: moment().subtract(29, 'days'),
            endDate: moment(),
            showCustomRangeLabel: false,
            locale: {
                format: 'DD/MM/YYYY', // รูปแบบวันที่
                applyLabel: "ตกลง", // ป้ายปุ่มตกลง
                cancelLabel: "ยกเลิก", // ป้ายปุ่มยกเลิก
                fromLabel: "จาก", // ป้าย "จาก"
                toLabel: "ถึง", // ป้าย "ถึง"
                customRangeLabel: "กำหนดเอง", // ป้าย "กำหนดเอง"
                weekLabel: "สัปดาห์", // ป้าย "สัปดาห์"
                daysOfWeek: ["อา", "จ", "อ", "พ", "พฤ", "ศ", "ส"], // วันในสัปดาห์
                monthNames: [
                    "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน",
                    "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
                ], // ชื่อเดือน
                firstDay: 0 // เริ่มต้นสัปดาห์จากวันอาทิตย์
            }
        },
        function (start, end) {
            $('#reportrange span').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'))
        });


    $('#reservation2').daterangepicker({
        locale: {
            format: 'DD/MM/YYYY', // รูปแบบวันที่
            applyLabel: "ตกลง",
            cancelLabel: "ยกเลิก",
            fromLabel: "จาก",
            toLabel: "ถึง",
            customRangeLabel: "กำหนดเอง",
            weekLabel: "สัปดาห์",
            daysOfWeek: ["อา", "จ", "อ", "พ", "พฤ", "ศ", "ส"],
            monthNames: [
                "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน",
                "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
            ],
            firstDay: 0
        }
    })

    $('#reservation').daterangepicker({
        locale: {
            format: 'DD/MM/YYYY', // รูปแบบวันที่
            applyLabel: "ตกลง",
            cancelLabel: "ยกเลิก",
            fromLabel: "จาก",
            toLabel: "ถึง",
            customRangeLabel: "กำหนดเอง",
            weekLabel: "สัปดาห์",
            daysOfWeek: ["อา", "จ", "อ", "พ", "พฤ", "ศ", "ส"],
            monthNames: [
                "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน",
                "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
            ],
            firstDay: 0
        }
    })

    $(document).ready(function () {
        // let pagLength = $('#pgLength').val()
        let table
        $.ajax({
            url: `controller/emp/badge.php`,
            method: 'POST',
            data: {},
            success: function (data) {
                let res_data = JSON.parse(data)
                console.log(res_data.data)
                list_of_status = res_data.data
                $('#st_all').html(res_data.all)
                $('#st_assign').html(res_data.assign)
                $('#st_onprocess').html(res_data.onprocess)
                $('#st_success').html(res_data.success)
                $('#st_unsuccess').html(res_data.unsuccess)
                // let list = filterData('all', res_data.data)
                $.ajax({
                    url: `component/emp/table_dashboard.php`,
                    method: 'POST',
                    data: {
                        case: 'all'
                    },
                    success: function (data) {
                        $('#show-list').html(data)
                        // table.destroy();
                        table = $("#table_dashboard_emp").DataTable({
                            scrollX: true,
                            scrollY: '60vh-80px',
                            language: {
                                search: "ค้นหา:",
                                searchPlaceholder: "พิมพ์คำที่ต้องการค้นหา",
                                info: 'แสดงหน้าที่ _PAGE_ จาก _PAGES_ ( จำนวน _MAX_ รายการ )',
                                infoEmpty: 'ไม่มีข้อมูล',
                                infoFiltered: '(กรองข้อมูลจากทั้งหมด _MAX_ รายการ)',
                                lengthMenu: 'แสดงข้อมูล _MENU_ รายการต่อหน้า',
                                zeroRecords: 'ไม่พบข้อมูลที่ค้นหา',
                                paginate: {
                                    // first: "หน้าแรก",
                                    // last: "หน้าสุดท้าย",
                                    next: "ถัดไป",
                                    previous: "ก่อนหน้า"
                                }
                            },
                            order: [],
                            searching: true,
                            responsive: true,
                            pagingType: "simple_numbers",
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
            }


        });
        // function adjustDataTableHeight() {
        //     // คำนวณความสูงที่เหมาะสมโดยหักพื้นที่ส่วนอื่นออกจากหน้าจอ
        //     const tableHeight = $(window).height() - 500;
        //     console.log('ความสูง : ', tableHeight)
        //     return `${tableHeight}px`;
        // }
        $('.tab_search').click(function () {
            Swal.fire({
                title: 'กำลังโหลดข้อมูล...',
                text: 'กรุณารอสักครู่...',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            })
            let slectTab = $(this).attr('id')
            console.log(slectTab)

            $.ajax({
                url: `component/emp/table_dashboard.php`,
                method: 'POST',
                data: {
                    case: slectTab
                },
                success: function (data) {
                    $('#show-list').html(data)

                    $("#table_dashboard_emp").DataTable().destroy();

                    table = $("#table_dashboard_emp").DataTable({
                        scrollX: true,
                        scrollY: '20vh',
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
                        searching: true,
                        responsive: true,
                        pageLength: 3,
                        // fixedColumns: true,
                        // fixedColumns: {
                        //     leftColumns: 2, // คงที่คอลัมน์ 1 และ 2
                        // },
                        autoWidth: false,
                        columnDefs: [{ width: '30%', targets: 2 }],
                    });

                    setTimeout(function () {
                        Swal.close()
                    }, 500);
                }
            });
        })

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

    })


</script>

