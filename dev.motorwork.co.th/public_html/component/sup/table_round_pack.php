<?php
session_start();
include "../../config/connect.php";
$so_id = $_REQUEST['so_id'];
$assign_no = $_POST['assign_no'];
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$sql_checkApprove = "SELECT * FROM `tb_approval` WHERE assign_no = '" . $assign_no . "' ;";
$query_checkApprove = $mysqli->query($sql_checkApprove);
$checkApprove = mysqli_num_rows($query_checkApprove);
?>
<style>

    /* สำหรับหน้าจอปกติ (Desktop) */
    .responsive-group {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 2px; /* ระยะห่างระหว่างปุ่ม */
    }

    .responsive-group .divider {
        display: inline-block; /* แสดง | */
    }

    /* สำหรับหน้าจอเล็ก (เช่น Mobile) */
    @media (max-width: 768px) {
        .responsive-group {
            display: flex;
            flex-direction: column; /* จัดเรียงปุ่มในแนวตั้ง */
            align-items: center;    /* จัดกึ่งกลางในแนวตั้ง */
            gap: 5px;               /* ลดช่องว่างระหว่างปุ่ม */
        }

        .responsive-group .divider {
            display: none; /* ซ่อน | */
        }
    }


    /*#list_round_pick_first th:nth-child(1){*/
    /*    !*width: 100px !important;*!*/
    /*    width:auto;*/
    /*    !*padding-right: 5px !important;*!*/
    /*    !*margin: 2px;*!*/
    /*    !*padding: 2px;*!*/
    /*}*/

    /*#list_round_pick_first th:nth-child(2),*/
    /*#list_round_pick_first td:nth-child(2) {*/
    /*    width: 30px !important;*/
    /*    padding-right: 15px !important;*/
    /*}*/

    /*#list_round_pick_first th:nth-child(3),*/
    /*#list_round_pick_first td:nth-child(3) {*/
    /*    width: 20px !important;*/
    /*}*/

    /*#list_round_pick_first th:nth-child(4),*/
    /*#list_round_pick_first td:nth-child(4) {*/
    /*    width: 10px !important;*/
    /*    padding-right: 15px !important;*/
    /*}*/

    /*#list_round_pick_first th:nth-child(5),*/
    /*#list_round_pick_first td:nth-child(5) {*/
    /*    width: 40px !important;*/
    /*    padding-right: 15px !important;*/
    /*    padding-left: 0;*/
    /*    margin-left: 0;*/
    /*    margin-right: 0;*/
    /*}*/

    /*#list_round_pick_first th:nth-child(6),*/
    /*#list_round_pick_first td:nth-child(6) {*/
    /*    width: 30px !important;*/
    /*    padding-right: 15px !important;*/
    /*}*/

    .custom-btn {
        width: 35px;
        font-size: 12px; /* ขนาดตัวอักษรเล็กลง */
        padding: 0px /* ลดขนาด Padding */
        border: none; /* ลบเส้นขอบ (ถ้าต้องการ) */
        opacity: 1; /* ทำให้สีทึบ */
    }

    .custom-btn.btn-success {
        /*border-bottom-left-radius: 5px;*/
        /*border-top-left-radius: 5px;*/
        border-radius: 5px;
        background-color: #FDF6B2; /* สีทึบสำหรับ Success */
        color: #723B2D; /* สีข้อความ */
        margin-right: 5px;
    }

    .custom-btn.btn-primary {
        background-color: #DEF7EC; /* สีทึบสำหรับ Primary */
        color: #03574A;
        border-radius: 5px;
        margin-left: 5px;
        margin-right: 5px;
        /*border-right: 1px solid black;*/
        /*border-left: 1px solid black;*/
    }

    .custom-btn.btn-warning {
        /*border-bottom-right-radius: 5px;*/
        /*border-top-right-radius: 5px;*/
        margin-left: 5px;
        border-radius: 5px;
        background-color: #FDE8E8;
        color: #A1201C;
    }

    .custom-btn:hover {
        cursor: default;
    }

    #list_round_pick_first {
        table-layout: fixed;
        width: 100%;
    }

    .remark-text {
        line-height: 1;      /* กำหนดระยะห่างระหว่างบรรทัด */
        margin-left: 10px;
    }
</style>
<input type="hidden" id="so_id" value="<?php echo $so_id; ?>">
<input type="hidden" id="assign_no" value="<?php echo $assign_no; ?>">
<input type="hidden" id="emp_id" value="<?php echo $_SESSION['Member_IdLogin']; ?>">
<div class="form-group col-md-12 pt-1" style="overflow: auto; height: calc(100vh - 280px);">
    <div class="form-group col-md-12 col-xs-12">
        <table id="list_round_pick_first" class="table table-hover table-bordered table-striped">
            <thead>
            <tr>
                <th width="7%">ลำดับ</th>
                <th width="20%">รหัสสินค้า</th>
                <th width="25%">ชื่อสินค้า</th>
                <th width="9%">ตำแหน่ง</th>
                <th width="20%">ต้องนับ | นับได้ | รอนับ</th>
                <th width="20%">ประเภทหมายเหตุ</th>
                <th width="20%">หมายเหตุ (พนักงาน)</th>
                <th width="20%">หมายเหตุ (หัวหน้า)</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $sql_select_pk = "SELECT * FROM `tb_sale_order`  WHERE so_id = '$so_id';";
            $query_select_pk = $mysqli->query($sql_select_pk);
            $data_pk = mysqli_fetch_object($query_select_pk);

            $sql_select_ass_pk = "SELECT * FROM `tb_assign` WHERE assign_no = '$assign_no';";
            $query_select_ass_pk = $mysqli->query($sql_select_ass_pk);
            $data_ass_pk = mysqli_fetch_object($query_select_ass_pk);
            $sql_select = "SELECT * FROM `tb_pack` 
                                LEFT JOIN  tb_sale_order_detail ON tb_sale_order_detail.so_detail_no = tb_pack.so_detail_no
                                LEFT JOIN tb_product ON tb_product.prod_id = tb_sale_order_detail.prod_id 
                                WHERE tb_pack.flag_pack = 'N' AND tb_pack.assign_no = '$assign_no'";
            $query_select = $mysqli->query($sql_select);

            $sql_select3 = "SELECT * FROM `tb_assign`
                                    LEFT JOIN tb_employee ON tb_employee.emp_id = tb_assign.delegatee_id
                                    LEFT JOIN tb_result ON tb_result.assign_no = tb_assign.assign_no
                                    WHERE tb_assign.so_id = '$so_id' AND tb_assign.assign_task = 'pack' AND tb_assign.assign_no = '$assign_no'  ;";
            //                AND tb_assign.assign_round = 1
            $query_select3 = $mysqli->query($sql_select3);
            $data_body = mysqli_fetch_object($query_select3);
            while ($rowData = mysqli_fetch_assoc($query_select)) {


                $sql_select31 = "SELECT * FROM `tb_pack`
                        LEFT JOIN tb_pack_remark ON tb_pack_remark.pack_no = tb_pack.pack_no
                         LEFT JOIN  tb_remark ON tb_pack_remark.remark_id = tb_remark.remark_id
                         WHERE so_detail_no = '" . $rowData['so_detail_no'] . "' AND assign_no = '" . $assign_no . "' AND tb_pack_remark.emp_type = '1' ;";
//WHERE so_detail_no = '" . $rowData['so_detail_no'] . "' AND assign_no = '" . $data_body->assign_no . "' ;";
//                echo $sql_select31 ;
                $query_select31 = $mysqli->query($sql_select31);
                $data_body31 = mysqli_fetch_object($query_select31);


                ?>
                <tr>
                    <td align="center"><?php echo $rowData['so_num']; ?></td>
                    <td align="center"><?php echo $rowData['prod_id']; ?></td>
                    <td><?php echo $rowData['prod_name']; ?></td>
                    <td align="center"><?php echo $rowData['prod_location']; ?></td>
                    <td align="center" class="text-center">
                        <div class="btn-group responsive-group">
        <span class="custom-btn btn-success">
            <?php echo $rowData['prod_qty']; ?>
        </span>
                            <span class="divider">|</span>
                            <span class="custom-btn btn-primary start">
            <?php echo $data_body31->pack_qty; ?>
        </span>
                            <span class="divider">|</span>
                            <span class="custom-btn btn-warning cancel">
            <?php
            $diff = $rowData['prod_qty'] - $data_body31->pack_qty;
            echo $diff;
            ?>
        </span>
                        </div>
                    </td>
                    <td align="left"><?php echo $data_body31->remark_name ?? '-'; ?></td>
                    <td align="left"><?php echo nl2br($data_body31->remark) ?? '-'; ?></td>
                    <td>
                        <?php
                        if (($data_body->assign_status == 51 || $data_body->assign_status == 52) && $checkApprove > 0){
                        $sql_select_rm_show = "SELECT * FROM `tb_pack`
                                                LEFT JOIN tb_pack_remark ON tb_pack_remark.pack_no = tb_pack.pack_no
                                                WHERE tb_pack.so_detail_no = '" . $rowData['so_detail_no'] . "' AND assign_no = " . $assign_no . " AND tb_pack_remark.emp_type = '2' ;";
                        $query_select_rm_show = $mysqli->query($sql_select_rm_show);
                        $data_rm_show = mysqli_fetch_object($query_select_rm_show); ?>
                        <?php echo nl2br($data_rm_show->remark) ?? '-'; ?>
                    </td>
                    <?php } else { ?>
                        <!--                        <input type="text" class="form-control remark-input"-->
                        <!--                               name="mng_remark[]" value=""-->
                        <!--                               data-prod-id="--><?php //echo $rowData['so_detail_no']; ?><!--"></td>-->
                        <textarea class="form-control remark-input"
                                  name="mng_remark[]"
                                  data-prod-id="<?php echo $rowData['so_detail_no']; ?>"
                                  rows="3"></textarea></td>
                    <?php } ?>
                </tr>
            <?php }
            //            $sql_select_ass_id = "SELECT * FROM `tb_assign` WHERE tb_assign.so_id = '$so_id' AND assign_task = 'pick' AND assign_round = 1;";
            //            $query_select_ass_id = $mysqli->query($sql_select_ass_id);
            //            $data_ass_id = mysqli_fetch_object($query_select_ass_id);
            ?>
            <!--            <input type="text" id="assign_no" value="-->
            <?php //echo $data_ass_id->assign_no; ?><!--">-->

            </tbody>
        </table>
    </div>
    <?php

    $sql_select2 = "SELECT * FROM `tb_result`
        LEFT JOIN tb_remark ON tb_remark.remark_id  = tb_result.remark_id
        LEFT JOIN tb_assign ON tb_assign.assign_no = tb_result.assign_no
        LEFT JOIN tb_employee ON tb_assign.delegatee_id = tb_employee.emp_id 
       WHERE  tb_result.assign_no = '$assign_no'";
    //    echo "$sql_select2";
    $query_select2 = $mysqli->query($sql_select2);
    $data_footer = mysqli_fetch_object($query_select2)

    ?>
    <div class="d-flex justify-content-between">
        <div class="w-50 card card-success card-outline mr-1">
            <div class="card-header p-0 m-1">
                <div class="col-md-12">
                    <h5 style="color: #9B111E">พนักงานระบุหมายเหตุ</h5>
                </div>
            </div>
            <div class="card-body px-5">
                <div class="row">
                    <div class="form-group col-md-6 col-6 ">
                        <label for="member pack">พนักงานหยิบ</label><br>
                        &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $data_footer->emp_name . ' ' . $data_footer->emp_surname; ?>
                        <div class="row mt-4">
                            <div class="form-group col-6">
                                <label for="member pack">ประเภทหมายเหตุ</label><br>
                                &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $data_footer->remark_name; ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-6 col-6">
                        <label for="remark">หมายเหตุการหยิบ</label><br>
                        <span class="pl-2">   <?php echo $data_footer->remark; ?></span>
                    </div>
                </div>

            </div>
        </div>
        <div class="w-50 card card-success card-outline ml-1">
            <div class="card-header p-0 m-1">
                <div class="col-md-12">
                    <h5 style="color: #9B111E">หัวหน้าระบุหมายเหตุ</h5>
                    <!--        <label for="remark">หัวหน้าระบุหมายเหตุ</label>-->
                </div>
            </div>
            <div class="card-body px-5">
                <?php

                if (($data_body->assign_status == 51 || $data_body->assign_status == 52) && $checkApprove > 0) {
                    $sql_select_remark_list = "SELECT * FROM `tb_approval` 
                            LEFT JOIN tb_employee ON tb_employee.emp_id = tb_approval.delegator_id
                            LEFT JOIN tb_remark ON tb_remark.remark_id = tb_approval.remark_id
                            WHERE  tb_approval.assign_no = '$assign_no'";

                    $query_select_remark_list = $mysqli->query($sql_select_remark_list);
                    $data_remark_id = mysqli_fetch_object($query_select_remark_list);
                    ?>
                    <div class="row">
                        <div class="form-group col-6 col-md-6 col-xs-6">
                            <?php
                            $sql_select_option_se = "SELECT * FROM `tb_remark` WHERE remark_id = '" . $data_remark_id->remark_id . "';";
                            $query_select_option_se = $mysqli->query($sql_select_option_se);
                            $rowData_obj1 = mysqli_fetch_object($query_select_option_se);
                            ?>
                            <label for="stock insert">ประเภทหมายเหตุ</label><br>
                            &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $rowData_obj1->remark_name; ?>
                        </div>
                        <div class="form-group col-md-6 col-xs-6 col-6">
                            <label for="stock insert">หมายเหตุ</label><br>
                            <div class="remark-text">
                                <?php echo nl2br($data_remark_id->remark); ?>
                            </div>
                        </div>
                    </div>

                <?php } else { ?>
                    <div class="row">
                        <div class="form-group col-md-6 col-6 col-xs-6">
                            <?php
                            $sql_select_option = "SELECT * FROM `tb_remark`";
                            $query_select_option = $mysqli->query($sql_select_option);
                            ?>
                            <label for="stock insert">ประเภทหมายเหตุ</label>
                            <select class="form-control" name="pick_remark_type_mng" id="pick_remark_type_mng">
                                <option selected disabled style="background-color: gray;color: white">
                                    กรุณาเลือกประเภทหมายเหตุ
                                </option>
                                <?php
                                while ($rowData1 = mysqli_fetch_assoc($query_select_option)) {
                                    ?>
                                    <option value="<?php echo $rowData1['remark_id']; ?>"><?php echo $rowData1['remark_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6 col-6 col-xs-6">
                            <label for="stock insert">หมายเหตุ</label>
                            <textarea class="form-control" id="pick_remark_mng" name="pick_remark_mng"
                                      rows="3"></textarea>
                        </div>
                    </div>
                <?php } ?>
            </div>

        </div>
    </div>

</div>
<div class="pb-1 pt-1" style="border-top: 1px solid lightgray">
    <?php

    //    echo $data_body->assign_round ;
    if (($data_body->assign_status == 51 || $data_body->assign_status == 52) && $checkApprove > 0) {
        ?>
        <div class="box-footer">
            <button type="button" class="btn btn-primary" disabled
                    style="background-color:#9b111e;border-color: #961011;cursor: not-allowed">จบงาน
            </button>
            <?php if ($data_body->assign_round == 3) { ?>

            <?php } else { ?>
                <button name="action" value="wait" type="submit" class="btn btn-primary"
                        style="background-color:#3A3B3C;border-color:#3A3B3C;cursor: not-allowed" disabled>รอมอบหมายใหม่
                </button>
            <?php } ?>
            <!--            <button class="btn btn-warning" disabled-->
            <!--                    style="background-color:#FFF;border-color:#3A3B3C;color:#3A3B3C">ย้อนกลับ-->
            <!--            </button>-->
        </div>
    <?php } else { ?>
        <div class="box-footer">
            <button type="button" class="btn btn-primary checkOut"
                    style="background-color:#9b111e;border-color: #961011">จบงาน
            </button>
            <?php if ($data_body->assign_round == 3) { ?>
                <!--                <button name="action" value="wait" type="button" class="btn btn-primary" disabled-->
                <!--                        style="background-color:#3A3B3C;border-color:#3A3B3C;cursor: not-allowed">รอมอบหมายใหม่-->
                <!--                </button>-->
            <?php } else { ?>
                <button name="action" value="wait" type="button" class="btn btn-primary newPick"
                        style="background-color:#3A3B3C;border-color:#3A3B3C">รอมอบหมายใหม่
                </button>
            <?php } ?>
        </div>
    <?php } ?>
</div>

<script>

    $(document).ready(function () {
        if ($.fn.DataTable.isDataTable('#list_round_pick_first')) {
            $('#list_round_pick_first').DataTable().destroy(); // ลบ DataTable เดิม
        }

        $("#list_round_pick_first").DataTable({
            destroy: true,
            autoWidth: false,
            language: {
                search: "ค้นหา:",
                searchPlaceholder: "พิมพ์คำที่ต้องการค้นหา",
                info: 'แสดงหน้าที่ _PAGE_ จาก _PAGES_',
                infoEmpty: '',
                infoFiltered: '(กรองข้อมูลจากทั้งหมด _MAX_ รายการ)',
                lengthMenu: 'แสดงข้อมูล _MENU_ รายการต่อหน้า',
                zeroRecords: '--ไม่พบข้อมูล--',
                paginate: {
                    first: "หน้าแรก",
                    last: "หน้าสุดท้าย",
                    next: "ถัดไป",
                    previous: "ก่อนหน้า"
                }
            },
            pageLength: 5,
            searching: true,
            responsive: false,
        });
    })

    $('.checkOut').click(function () {
        let assign_no = $('#assign_no').val();
        Swal.fire({
            title: "ยืนยันการจบงาน?",
            text: "คุณต้องการจบงานนี้ใช่หรือไม่!",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#00A65A",
            allowOutsideClick: false,
            cancelButtonColor: "#808080",
            confirmButtonText: "บันทึก",
            cancelButtonText: "ย้อนกลับ"
        }).then((result) => {
            if (result.isConfirmed) {
                let so_id = $('#so_id').val();
                let emp_id = $('#emp_id').val();
                console.log('assign_no:', assign_no)
                console.log("SO ID:", so_id);
                let remark_list_id = $('#pick_remark_type_mng').val();
                console.log("remark_list_id:", remark_list_id);
                let remark_list_des = $('#pick_remark_mng').val();
                console.log("remark_list_des:", remark_list_des);
                // remark product
                let remarks = [];
                $('.remark-input').each(function () {
                    let prodId = $(this).data('prod-id'); // ดึงค่า prod_id
                    let remarkValue = $(this).val(); // ดึงค่าที่กรอกใน input
                    remarks.push({prod_id: prodId, remark: remarkValue});
                });
                console.log(remarks);
                // remark product
                $.ajax({
                    url: 'controller/sup/post_order.php',
                    method: 'POST',
                    data: {
                        action: "checkOutSo",
                        sub_action: 'end',
                        type_action: 'pack',
                        so_id: so_id,
                        remark_list_id,
                        remark_list_des,
                        remarks: remarks,
                        emp_id,
                        assign_no
                    },
                    success: function (response) {
                        console.log("Response:", response);
                        // location.reload()
                    }
                });
            }
        })
    });

    $('.newPick').click(function () {
        let assign_no = $('#assign_no').val()
        Swal.fire({
            title: "ยืนยันการบันทึกข้อมูล?",
            text: "คุณต้องการมอบหมายงานนี้ใหม่ใช่หรือไม่ !",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#00A65A",
            allowOutsideClick: false,
            cancelButtonColor: "#808080",
            confirmButtonText: "บันทึก",
            cancelButtonText: "ย้อนกลับ"
        }).then((result) => {
            if (result.isConfirmed) {
                let so_id = $('#so_id').val();
                let emp_id = $('#emp_id').val();
                console.log("SO ID:", so_id);
                let remark_list_id = $('#pick_remark_type_mng').val();
                console.log("remark_list_id:", remark_list_id);
                let remark_list_des = $('#pick_remark_mng').val();
                console.log("remark_list_des:", remark_list_des);
                // remark product
                let remarks = [];
                $('.remark-input').each(function () {
                    let prodId = $(this).data('prod-id'); // ดึงค่า prod_id
                    let remarkValue = $(this).val(); // ดึงค่าที่กรอกใน input
                    remarks.push({prod_id: prodId, remark: remarkValue});
                });
                console.log(remarks);
                $.ajax({
                    url: 'controller/sup/post_order.php',
                    method: 'POST',
                    data: {
                        action: "checkOutSo",
                        sub_action: 'new',
                        type_action: 'pack',
                        so_id: so_id,
                        remark_list_id,
                        remark_list_des,
                        remarks: remarks,
                        emp_id,
                        assign_no
                    },
                    success: function (response) {
                        console.log("Response:", response);
                        // location.reload()
                    },
                    error: function (error) {
                        console.log("Error:", error);
                    }
                });
            }
        })
    })

</script>

