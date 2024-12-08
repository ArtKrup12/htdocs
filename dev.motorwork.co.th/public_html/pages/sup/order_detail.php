<?php
include "../../config/connect.php";
//
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

$member_type = $_SESSION['member_type'];
$member_id = $_SESSION['Member_IdLogin'];

$so_no = $_REQUEST['so_id'];
//$assign_id = $_REQUEST['assign_id'];

function convertToBuddhistYear($date)
{
    if ($date === "0000-00-00 00:00:00") {
        return "-";
    }
    $dateTime = new DateTime($date);
    $yearBuddhist = $dateTime->format('Y') + 543;
    $timeBuddhist = $dateTime->format('H:i:s');
    $formattedDate = $dateTime->format('d/m/ ') . $yearBuddhist . ' ' . $timeBuddhist;
    return $formattedDate;
}

?>
<style>
    .card-success.card-outline {
        border-top: 3px solid #9B111E;
    }

    .nav-tabs .nav-link.active {
        border-top: 3px solid #9B111E !important;
        color: #9B111E !important;
    }

    /*.sticky-header {*/
    /*    position: sticky;*/
    /*    top: 0; !* ระยะห่างจากด้านบน *!*/
    /*    z-index: 10; !* เพื่อให้แสดงอยู่ด้านบนของเนื้อหาอื่น *!*/
    /*    background-color: #fff; !* เพื่อป้องกันการทับกับพื้นหลัง *!*/
    /*    padding: 10px;*/
    /*    border-bottom: 1px solid #ddd; !* เพิ่มเส้นแบ่งเพื่อความชัดเจน *!*/
    /*}*/
    th {
        text-align: center;
        vertical-align: middle;
    }
</style>
<input type="hidden" id="order_code" value="<?php echo $so_no; ?>">
<section class="content pr-0">
    <div class="row col-12 pr-0">
        <!--        <div class="card card-success card-outline direct-chat direct-chat-success col-12 mt-2"-->
        <!--             style="overflow: auto; height: calc(100vh - 110px);">-->
        <div class="card card-success card-outline direct-chat direct-chat-success col-12 mt-2 mb-0 pb-0">
            <div class="card-header sticky-header d-flex justify-content-between p-1 m-1">
                <div class="w-50 d-flex justify-content-start align-items-center">
                    <h4 class="pl-2">รายละเอียดรายการ</h4>
                </div>
                <div class="w-50 d-flex justify-content-end align-items-center">
                    <button class="btn btn-sm p-0 m-0 refresh_order_page" style="background-color:#9B111E "
                            id="<?php echo $so_no; ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <g fill="white" fill-rule="evenodd" clip-rule="evenodd">
                                <path d="M6.64 9.788a.75.75 0 0 1 .53.918a5 5 0 0 0 7.33 5.624a.75.75 0 1 1 .75 1.3a6.501 6.501 0 0 1-9.529-7.312a.75.75 0 0 1 .919-.53M8.75 6.37a6.5 6.5 0 0 1 9.529 7.312a.75.75 0 1 1-1.45-.388A5.001 5.001 0 0 0 9.5 7.67a.75.75 0 1 1-.75-1.3"/>
                                <path d="M5.72 9.47a.75.75 0 0 1 1.06 0l2.5 2.5a.75.75 0 1 1-1.06 1.06l-1.97-1.97l-1.97 1.97a.75.75 0 0 1-1.06-1.06zm9 1.5a.75.75 0 0 1 1.06 0l1.97 1.97l1.97-1.97a.75.75 0 1 1 1.06 1.06l-2.5 2.5a.75.75 0 0 1-1.06 0l-2.5-2.5a.75.75 0 0 1 0-1.06"/>
                            </g>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="card-body pt-1">
                <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist" style="border-top: transparent">
                    <li class="nav-item">
                        <a class="nav-link text-dark active" id="custom-content-below-home-tab" data-toggle="pill"
                           href="#custom-content-below-home" role="tab" aria-controls="custom-content-below-home"
                           aria-selected="true">รายละเอียด</a>
                    </li>
                    <?php
                    $sql_check_round = "SELECT * FROM `tb_assign` WHERE so_id = '$so_no' AND assign_round = 1 AND assign_task = 'pick';";
                    $query_check = $mysqli->query($sql_check_round);
                    $row_data_pick = mysqli_fetch_object($query_check);

                    $sql_check_round_pack = "SELECT * FROM `tb_assign` WHERE so_id = '$so_no' AND assign_round = 1 AND assign_task = 'pack';";
                    $query_check_pack = $mysqli->query($sql_check_round_pack);
                    $row_data_pack = mysqli_fetch_object($query_check_pack);
                    //echo $row_data_pick->assign_status ;
                    //echo $row_data_pack->assign_status ;
                    if ($row_data_pick->assign_status == 51) {
                        ?>
                        <li class="nav-item">
                            <a class="nav-link text-dark" id="custom-content-below-profile-tab" data-toggle="pill"
                               href="#custom-content-below-profile" role="tab"
                               aria-controls="custom-content-below-profile"
                               aria-selected="false">หมายเหตุการหยิบ</a>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item">
                            <a class="nav-link text-dark" id="custom-content-below-profile-tab" data-toggle="pill"
                               href="#custom-content-below-profile" role="tab"
                               aria-controls="custom-content-below-profile"
                               style="pointer-events: none;cursor: not-allowed!important;color: #6c757d !important;"
                               aria-selected="false" disabled>หมายเหตุการหยิบ</a>
                        </li>
                    <?php }
                    if ($row_data_pack->assign_status == 52) {
                        ?>
                        <li class="nav-item">
                            <a class="nav-link text-dark" id="custom-content-below-messages-tab" data-toggle="pill"
                               href="#custom-content-below-messages" role="tab"
                               aria-controls="custom-content-below-messages" aria-selected="false">หมายเหตุการแพ็ค</a>
                        </li>
                    <?php } else { ?>

                        <li class="nav-item">
                            <a class="nav-link text-dark" id="custom-content-below-messages-tab" data-toggle="pill"
                               style="pointer-events: none;cursor: not-allowed;color: #6c757d !important;"
                               href="#custom-content-below-messages" role="tab"
                               aria-controls="custom-content-below-messages" aria-selected="false" disabled>หมายเหตุการแพ็ค</a>
                        </li>
                    <?php } ?>
                </ul>
                <div class="tab-content" id="custom-content-below-tabContent">
                    <div class="tab-pane fade show active" id="custom-content-below-home" role="tabpanel"
                         style="overflow-y: auto;overflow-x: hidden; height: calc(100vh - 210px);"
                         aria-labelledby="custom-content-below-home-tab">
                        <?php
                        $query_select = "SELECT (SELECT CONCAT(tb_employee.emp_name,' ',tb_employee.emp_surname) as name FROM `tb_assign` 
                                            LEFT JOIN tb_employee ON tb_employee.emp_id = tb_assign.delegatee_id
                                            WHERE so_id = '$so_no' AND assign_task = 'pick' ORDER BY tb_assign.modify_dt DESC LIMIT 1) as emp_pick,
                                            (SELECT CONCAT(tb_employee.emp_name,' ',tb_employee.emp_surname) as name FROM `tb_assign` 
                                            LEFT JOIN tb_employee ON tb_employee.emp_id = tb_assign.delegatee_id
                                            WHERE so_id = '$so_no' AND assign_task = 'pack' ORDER BY tb_assign.modify_dt DESC LIMIT 1) as emp_pack,tb_sale_order.*,
                                            COUNT(tb_sale_order_detail.so_num) as count_list,SUM(tb_sale_order_detail.prod_qty) as sum_qty,tb_customer.cust_name,tb_customer.cust_id,tb_sale_order_detail.prod_qty 
                                            FROM `tb_sale_order` JOIN tb_sale_order_detail ON tb_sale_order_detail.so_id = tb_sale_order.so_id 
                                            LEFT JOIN tb_customer ON tb_customer.cust_id = tb_sale_order.cust_id 
                                               WHERE tb_sale_order.so_id = '$so_no' GROUP BY tb_sale_order.so_id ;";
                        $query12 = $mysqli->query($query_select);
                        $data_head_obj = mysqli_fetch_object($query12);
                        ?>
                        <div class="row mx-2 mt-4">
                            <div class="form-group col-md-12 mx-2 col-xs-12">
                                <span style="font-size: 1rem"><b>Packing Number :</b> <b class="text-center"
                                                                                         style="color: #9B111E;border-bottom: 2px solid #222D32;display: inline-block; width: 11%;padding-bottom: 4px"><?php
                                        $sql_select_result = "SELECT * FROM `tb_packing_number` WHERE so_id = '$so_no';";
                                        $query_select_result = $mysqli->query($sql_select_result);
                                        $data_result = $query_select_result->fetch_object();
                                        echo $data_result->packing_number ?? '-';
                                        ?></b></span>
                            </div>
                        </div>
                        <!--                        style="border-top: 3px solid #9B111E;"-->
                        <div class="d-flex justify-content-between mx-2">
                            <div class="card w-75 mx-2 mb-3">
                                <div class="card-header p2 pl-2 d-flex justify-content-start">
                                    <h4 class="card-title" style="color: #9B111E">สรุปข้อมูลใบขาย</h4>
                                </div>
                                <div class="card-body pt-1 px-4">
                                    <div class="row">
                                        <div class="form-group col-md-4 col-xs-12">
                                            <span>เลขที่ใบขาย</span>
                                            <br>
                                            <h6>
                                                <b><?php echo $so_no; ?></b>
                                            </h6>
                                        </div>
                                        <div class="form-group col-md-4 col-xs-12">
                                            <span>วันที่ขาย</span>
                                            <br>
                                            <h6>
                                                <b><?php echo $data_head_obj->so_date; ?></b>
                                            </h6>
                                        </div>
                                        <div class="form-group col-md-4 col-xs-12">
                                            <span>จำนวนรวม</span>
                                            <br>
                                            <h6>
                                                <b><?php echo $data_head_obj->count_list . ' ' . 'รายการ' . ' ' . $data_head_obj->sum_qty . ' ชิ้น'; ?></b>
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4 col-xs-12">
                                            <span>รหัสลูกค้า</span>
                                            <br>
                                            <h6>
                                                <b><?php echo $data_head_obj->cust_id; ?></b>
                                            </h6>
                                        </div>
                                        <div class="form-group col-md-8 col-xs-12">
                                            <span>ชื่อลูกค้า</span>
                                            <br>
                                            <h6>
                                                <b><?php echo $data_head_obj->cust_name; ?></b>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card w-25 mx-2 mb-3">
                                <div class="card-header p2 pl-2 d-flex justify-content-start">
                                    <h4 class="card-title" style="color: #9B111E">พนักงานหยิบ/แพ็ค (รอบล่าสุด)</h4>
                                </div>
                                <div class="card-body pt-1 px-4">
                                    <div class="row">
                                        <div class="form-group col-md-12 col-xs-12">
                                            <span>พนักงานหยิบ</span>
                                            <br>
                                            <h6>
                                                <b><?php echo $data_head_obj->emp_pick; ?></b>
                                            </h6>
                                        </div>
                                        <div class="form-group col-md-12 col-xs-12">
                                            <span>พนักงานแพ็ค</span>
                                            <h6>
                                                <b><?php echo $data_head_obj->emp_pack; ?></b>
                                            </h6>
                                            <!-- <input type="text" class="form-control" id="member_pack_name" name="member_pack_name"
                                               placeholder="พนักงานแพ็ค" value="<?php /*echo $data_head_obj->emp_pack; */ ?>"
                                               readonly>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="card card-warning mx-2 w-90 card-outline direct-chat direct-chat-success col-12"
                             style="border-top: 3px solid #222D32;">
                            <div class="card-header pt-1 pl-1 pb-1 d-flex justify-content-start">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                            class="fas fa-minus"></i>
                                </button>
                                <h4 class="card-title">รายการสินค้าในใบขาย</h4>
                            </div>
                            <div class="card-body pt-1 pb-2">
                                <table id="list_so" class="table table-hover table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>ลำดับ</th>
                                        <th>รหัสสินค้า</th>
                                        <th>ชื่อสินค้า</th>
                                        <th>ตำแหน่ง</th>
                                        <th>จำนวน</th>
                                        <th>หยิบได้</th>
                                        <th>สถานะหยิบ</th>
                                        <th>แพ็คได้</th>
                                        <th>สถานะแพ็ค</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $sql3 = "SELECT tb_sale_order_detail.*,tb_product.prod_name
                                                FROM tb_sale_order_detail
                                                LEFT JOIN tb_product ON tb_product.prod_id = tb_sale_order_detail.prod_id
                                                    WHERE tb_sale_order_detail.so_id='$so_no'";
                                    $query3 = $mysqli->query($sql3); // ทำการ query คำสั่ง sql
                                    $find3 = $query3->num_rows;  // นับจำนวนแถวที่แสดงทั้งหมด
                                    while ($row_data = mysqli_fetch_assoc($query3)) {
                                        ?>
                                        <tr>
                                            <td align="center"><?php echo $row_data['so_num']; ?></td>
                                            <td><?php echo $row_data['prod_id']; ?></td>
                                            <td><?php echo $row_data['prod_name']; ?></td>
                                            <td align="center"><?php echo $row_data['prod_location']; ?></td>
                                            <td align="right"><?php echo $row_data['prod_qty']; ?></td>
                                            <td align="right"><?php
                                                $sql4 = "SELECT  * FROM tb_assign
                                                        LEFT JOIN tb_pick ON tb_pick.assign_no = tb_assign.assign_no 
                                                        WHERE tb_assign.so_id = '$so_no' AND tb_assign.assign_task = 'pick' 
                                                          AND tb_pick.so_detail_no  = '" . $row_data['so_detail_no'] . "' 
                                                          ORDER BY tb_pick.create_dt DESC, tb_assign.assign_round DESC LIMIT 1 ;";
                                                //                                                echo $sql4 ;
                                                $query4 = $mysqli->query($sql4);
                                                $data_pick = mysqli_fetch_object($query4);
                                                echo $data_pick->pick_qty ?? '-';
                                                ?></td>
                                            <td align="center"><?php
                                                if ($data_pick->flag_pick == 'Y') {
                                                    echo '<span style="color: green" >สำเร็จ</span>';
                                                } else if ($data_pick->flag_pick == 'N') {
                                                    echo '<span style="color: red" >ไม่สำเร็จ</span>';
                                                } else {
                                                    echo '<span style="color: gray" >รอนับ</span>';
                                                }
                                                ?></td>
                                            <td align="right"><?php
                                                $sql6 = "SELECT  * FROM tb_assign
                                                                    LEFT JOIN tb_pack ON tb_pack.assign_no = tb_assign.assign_no 
                                                                    WHERE tb_assign.so_id = '$so_no' AND tb_assign.assign_task = 'pack' AND tb_pack.so_detail_no  = '" . $row_data['so_detail_no'] . "' ORDER BY tb_assign.assign_round DESC LIMIT 1 ;";
                                                $query6 = $mysqli->query($sql6);
                                                $data_pack = mysqli_fetch_object($query6);
                                                echo $data_pack->pick_qty ?? '-';
                                                ?></td>
                                            <td align="center"><?php
                                                if ($data_pack->flag_pack == 'Y') {
                                                    echo '<span style="color: green" >สำเร็จ</span>';
                                                } else if ($data_pack->flag_pack == 'N') {
                                                    echo '<span style="color: red" >ไม่สำเร็จ</span>';
                                                } else {
                                                    echo '<span style="color: gray" >รอนับ</span>';
                                                }
                                                ?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card card-warning mx-2 card-outline direct-chat direct-chat-success col-12"
                             style="border-top: 3px solid #222D32;">
                            <div class="card-header pt-1 pl-1 pb-1 d-flex justify-content-start">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                            class="fas fa-minus"></i></button>
                                <h4 class="card-title">ประวัติมอบหมายงานหยิบ</h4>
                            </div>
                            <div class="card-body pt-2 pb-2">
                                <table id="list_ass_pick" class="table table-hover table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>ลำดับ</th>
                                        <th>วันที่มอบหมาย</th>
                                        <th width="15%">พนักงาน</th>
                                        <th>วันที่นับเสร็จ</th>
                                        <th>เวลาที่ใช้</th>
                                        <th>สถานะ</th>
                                        <th>วันที่อนุมัติ</th>
                                        <th>ผู้อนุมัติ</th>
                                        <th>สถานะอนุมัติ</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $sql50 = "SELECT *,tb_assign.modify_dt FROM tb_assign 
                                            LEFT JOIN tb_employee ON tb_employee.emp_id = tb_assign.delegatee_id 
                                            LEFT JOIN tb_result ON tb_result.assign_no = tb_assign.assign_no 
                                            WHERE tb_assign.so_id='$so_no' AND tb_assign.assign_task = 'pick' ORDER BY  tb_assign.assign_round ASC";
                                    $query50 = $mysqli->query($sql50);
                                    $checkRowPick = mysqli_num_rows($query50);
                                    if ($checkRowPick > 0) {
                                        while ($row_data = mysqli_fetch_assoc($query50)) {
                                            ?>
                                            <tr>
                                                <td align="center"> <?php echo $row_data['assign_round']; ?></td>
                                                <td align="center"> <?php echo $row_data['assign_dt']; ?></td>
                                                <td align="left"> <?php echo $row_data['emp_name'] . ' ' . $row_data['emp_surname']; ?></td>
                                                <?php
                                                if ($row_data['stop_dt'] == '0000-00-00 00:00:00' || !isset($row_data['stop_dt'])) { ?>
                                                    <td align="center">-</td>
                                                    <td align="center">-</td>
                                                <?php } else { ?>
                                                    <td align="center"><?php echo $row_data['stop_dt']; ?></td>
                                                    <td align="center"><?php
                                                        $start = new DateTime($row_data['start_dt']);
                                                        $stop = new DateTime($row_data['stop_dt']);
                                                        $interval = $start->diff($stop);
                                                        $hours = sprintf('%02d', $interval->h);
                                                        $minutes = sprintf('%02d', $interval->i);
                                                        $seconds = sprintf('%02d', $interval->s);
                                                        echo $hours . ':' . $minutes . ':' . $seconds;
                                                        ?></td>
                                                <?php } ?>
                                                <td align="center"><?php echo $row_data['assign_status']; ?></td>
                                                <?php
                                                $sql66 = "SELECT * FROM tb_approval 
                                                     LEFT JOIN tb_employee ON tb_approval.delegator_id = tb_employee.emp_id
                                                     WHERE assign_no = '" . $row_data['assign_no'] . "';";
                                                $query66 = $mysqli->query($sql66);
                                                $data_approval = mysqli_fetch_object($query66);

                                                ?>
                                                <td align="center"><?php echo $data_approval->approve_dt ?? '-'; ?></td>
                                                <td align="left"> <?php
                                                    echo isset($data_approval->emp_name) && isset($data_approval->emp_surname)
                                                        ? $data_approval->emp_name . ' ' . $data_approval->emp_surname
                                                        : '-';
                                                    ?></td>
                                                <td align="center"><?php echo $data_approval->approve_status ?? '-'; ?></td>
                                            </tr>
                                        <?php }
                                    } else { ?>
                                        <tr>
                                            <td align="center" colspan="9">--ไม่พบข้อมูล--</td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card card-info mx-2 card-outline direct-chat direct-chat-success col-12"
                             style="border-top: 3px solid #222D32;">
                            <div class="card-header pt-1 pl-1 pb-1 d-flex justify-content-start">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                            class="fas fa-minus"></i>
                                </button>
                                <h4 class="card-title">ประวัติมอบหมายงานแพ็ค</h4>

                            </div>
                            <div class="card-body pt-2 pb-2">
                                <table id="list_ass_pack" class="table table-hover table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>ลำดับ</th>
                                        <th>วันที่มอบหมาย</th>
                                        <th width="15%">พนักงาน</th>
                                        <th>วันที่นับเสร็จ</th>
                                        <th>เวลาที่ใช้</th>
                                        <th>สถานะ</th>
                                        <th>วันที่อนุมัติ</th>
                                        <th>ผู้อนุมัติ</th>
                                        <th>สถานะอนุมัติ</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $sql501 = "SELECT *,tb_assign.modify_dt FROM tb_assign 
                                            LEFT JOIN tb_employee ON tb_employee.emp_id = tb_assign.delegatee_id 
                                            LEFT JOIN tb_result ON tb_result.assign_no = tb_assign.assign_no 
                                            WHERE tb_assign.so_id='$so_no' AND tb_assign.assign_task = 'pack' ORDER BY  tb_assign.assign_round ASC";
                                    $query501 = $mysqli->query($sql501);
                                    $checkRowPack = mysqli_num_rows($query501);
                                    if ($checkRowPack > 0) {
                                        while ($row_data2 = mysqli_fetch_assoc($query501)) {
                                            ?>
                                            <tr>
                                                <td align="center"> <?php echo $row_data2['assign_round']; ?></td>
                                                <td align="center"> <?php echo $row_data2['assign_dt']; ?></td>
                                                <td align="left"> <?php echo $row_data2['emp_name'] . ' ' . $row_data2['emp_surname']; ?></td>
                                                <?php
                                                if ($row_data2['stop_dt'] == '0000-00-00 00:00:00' || !isset($row_data2['stop_dt'])) { ?>
                                                    <td align="center">-</td>
                                                    <td align="center">-</td>
                                                <?php } else { ?>
                                                    <td align="center"><?php echo $row_data2['stop_dt']; ?></td>
                                                    <td align="center"><?php
                                                        $start = new DateTime($row_data2['start_dt']);
                                                        $stop = new DateTime($row_data2['stop_dt']);
                                                        $interval = $start->diff($stop);
                                                        $hours = sprintf('%02d', $interval->h);
                                                        $minutes = sprintf('%02d', $interval->i);
                                                        $seconds = sprintf('%02d', $interval->s);
                                                        echo $hours . ':' . $minutes . ':' . $seconds;
                                                        ?></td>
                                                <?php } ?>
                                                <td align="center"><?php echo $row_data2['assign_status']; ?></td>
                                                <?php
                                                $sql661 = "SELECT * FROM tb_approval 
                                                     LEFT JOIN tb_employee ON tb_approval.delegator_id = tb_employee.emp_id
                                                     WHERE assign_no = '" . $row_data2['assign_no'] . "';";
                                                $query661 = $mysqli->query($sql661);
                                                $data_approval_pack = mysqli_fetch_object($query661);

                                                ?>
                                                <td align="center"><?php echo $data_approval_pack->approve_dt ?? '-'; ?></td>
                                                <td align="left"> <?php
                                                    echo isset($data_approval_pack->emp_name) && isset($data_approval_pack->emp_surname)
                                                        ? $data_approval_pack->emp_name . ' ' . $data_approval_pack->emp_surname
                                                        : '-';
                                                    ?></td>
                                                <td align="center"><?php echo $data_approval_pack->approve_status ?? '-'; ?></td>
                                            </tr>
                                        <?php }
                                    } else { ?>
                                        <tr>
                                            <td align="center" colspan="9">--ไม่พบข้อมูล--</td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="custom-content-below-profile" role="tabpanel"
                         aria-labelledby="custom-content-below-profile-tab">
                        <div class="box-header">
                            <?php
                            //                            $sql_select_round = "SELECT assign_round FROM `tb_assign` WHERE assign_task = 'pick' AND so_id = '$so_no' ORDER BY assign_round DESC LIMIT 1;";
                            $sql_select_round = "SELECT assign_round FROM `tb_assign` WHERE assign_task = 'pick' AND so_id = '$so_no'  ";
                            $query_select_round = $mysqli->query($sql_select_round);
                            $num_round = mysqli_num_rows($query_select_round);
                            //                            echo 'รอบที่ : '.$num_round ;
                            //                            $data_round_check = mysqli_fetch_object($query_select_round)
                            ?>
                            <input type="hidden" id="round_current" value="<?php echo $num_round; ?>">
                            <?php
                            if ($num_round == 1) {
                                ?>
                                <ul class="nav nav-tabs">
                                    <li style="cursor: pointer" class=" nav-item" id="round_1">
                                        <a class="nav-link select_sub_tab text-dark active">ครั้งที่ 1</a>
                                    </li>
                                    <li style="cursor: not-allowed" class="nav-item" id="round_2">
                                        <a class="nav-link">ครั้งที่ 2</a>
                                    </li>
                                    <li style="cursor: not-allowed" class="nav-item" id="round_3">
                                        <a class="nav-link">ครั้งที่ 3</a>
                                    </li>
                                </ul>
                            <?php } else if ($num_round == 2) {
                                $sql_select_round2 = "SELECT * FROM `tb_assign` WHERE assign_task = 'pick' AND so_id = '$so_no' AND assign_round = 2 ";
                                $query_select_round2 = $mysqli->query($sql_select_round2);
                                $data_round2 = mysqli_fetch_object($query_select_round2);
                                if ($data_round2->assign_status == 51) {
                                    $show_active = 'active select_sub_tab';
                                    $show_cursor = 'pointer';
                                } else {
                                    $show_active = '';
                                    $show_cursor = 'not-allowed';
                                }

                                ?>
                                <ul class="nav nav-tabs">
                                    <li style="cursor: pointer" class=" nav-item">
                                        <a class="nav-link  select_sub_tab" id="round_1">ครั้งที่ 1
                                        </a>
                                    </li>
                                    <li style="cursor: <?php echo $show_cursor; ?>" class="nav-item">
                                        <a class="nav-link <?php echo $show_active; ?>" id="round_2">
                                            ครั้งที่ 2
                                        </a>
                                    </li>
                                    <li style="cursor: not-allowed" class=" nav-item" id="round_3">
                                        <a class="nav-link">
                                            ครั้งที่ 3
                                        </a>
                                    </li>
                                </ul>
                            <?php } else if ($num_round == 3) {
                                $sql_select_round3 = "SELECT * FROM `tb_assign` WHERE assign_task = 'pick' AND so_id = '$so_no' AND assign_round = 3 ";
                                $query_select_round3 = $mysqli->query($sql_select_round3);
                                $data_round3 = mysqli_fetch_object($query_select_round3);
                                if ($data_round3->assign_status == 51) {
                                    $show_active2 = 'active select_sub_tab';
                                    $show_cursor2 = 'pointer';
                                } else {
                                    $show_active2 = '';
                                    $show_cursor2 = 'not-allowed';
                                }

                                ?>
                                <ul class="nav nav-tabs">
                                    <li style="cursor: pointer" class=" nav-item">
                                        <a class="nav-link  select_sub_tab" id="round_1">ครั้งที่ 1
                                        </a>
                                    </li>
                                    <li style="cursor: pointer" class="nav-item">
                                        <a class="nav-link select_sub_tab" id="round_2">
                                            ครั้งที่ 2
                                        </a>
                                    </li>
                                    <li style="cursor: <?php echo $show_cursor2; ?>" class="nav-item">
                                        <a class="nav-link <?php echo $show_active2; ?> " id="round_3">
                                            ครั้งที่ 3
                                        </a>
                                    </li>
                                </ul>
                            <?php } else { ?>
                                <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active text-dark" id="round_1_li" data-toggle="pill"
                                           href="#round_1" role="tab"
                                           aria-controls="custom-content-below-home" aria-selected="true">ครั้งที่
                                            1</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-dark" id="round_2_li" data-toggle="pill"
                                           href="#round_2" role="tab"
                                           aria-controls="custom-content-below-profile" aria-selected="false">ครั้งที่
                                            2</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-dark" id="round_3_li" data-toggle="pill"
                                           href="#round_3" role="tab"
                                           aria-controls="custom-content-below-messages" aria-selected="false">ครั้งที่
                                            3</a>
                                    </li>
                                </ul>
                            <?php } ?>
                            <div class="tab-content">
                                <div class="tab-pane fade show active">
                                    <div id="show_round"></div>
                                </div>
                            </div>
                        </div>
                    </div>
<!--                    pack-->
                    <div class="tab-pane fade" id="custom-content-below-messages" role="tabpanel"
                         aria-labelledby="custom-content-below-messages-tab">
                        <div class="box-header">
                            <div class="box-header">
                                <?php
                                //                            $sql_select_round = "SELECT assign_round FROM `tb_assign` WHERE assign_task = 'pick' AND so_id = '$so_no' ORDER BY assign_round DESC LIMIT 1;";
                                $sql_select_round_pack = "SELECT assign_round FROM `tb_assign` WHERE assign_task = 'pack' AND so_id = '$so_no'  ";
                                $query_select_round_pack = $mysqli->query($sql_select_round_pack);
                                $num_round_pack = mysqli_num_rows($query_select_round_pack);
                                //                            echo 'รอบที่ : '.$num_round ;
                                //                            $data_round_check = mysqli_fetch_object($query_select_round)
                                ?>
                                <input type="hidden" id="round_current_pack" value="<?php echo $num_round_pack; ?>">
                                <?php
                                if ($num_round_pack == 1) {
                                    ?>
                                    <ul class="nav nav-tabs">
                                        <li style="cursor: pointer" class="nav-item">
                                            <a class="nav-link text-dark select_sub_tab active" id="pack_round_1">ครั้งที่ 1</a>
                                        </li>
                                        <li style="cursor: not-allowed" class="nav-item" id="">
                                            <a class="nav-link">ครั้งที่ 2</a>
                                        </li>
                                        <li style="cursor: not-allowed" class="nav-item" id="">
                                            <a class="nav-link">ครั้งที่ 3</a>
                                        </li>
                                    </ul>
                                <?php } else if ($num_round_pack == 2) {
                                    $sql_select_round2 = "SELECT * FROM `tb_assign` WHERE assign_task = 'pack' AND so_id = '$so_no' AND assign_round = 2 ";
                                    $query_select_round2 = $mysqli->query($sql_select_round2);
                                    $data_round2 = mysqli_fetch_object($query_select_round2);
                                    if ($data_round2->assign_status == 51) {
                                        $show_active2 = 'active select_sub_tab';
                                        $show_cursor2 = 'pointer';
                                    } else {
                                        $show_active2 = '';
                                        $show_cursor2 = 'not-allowed';
                                    }

                                    ?>
                                    <ul class="nav nav-tabs">
                                        <li style="cursor: pointer" class=" nav-item">
                                            <a class="nav-link select_sub_tab" id="pack_round_1">ครั้งที่ 1
                                            </a>
                                        </li>
                                        <li style="cursor: <?php echo $show_cursor2; ?>" class="nav-item">
                                            <a class="nav-link <?php echo $show_active2; ?>" id="pack_round_2">
                                                ครั้งที่ 2
                                            </a>
                                        </li>
                                        <li style="cursor: not-allowed" class=" nav-item" id="pack_round_3">
                                            <a class="nav-link">
                                                ครั้งที่ 3
                                            </a>
                                        </li>
                                    </ul>
                                <?php } else if ($num_round_pack == 3) {
                                    $sql_select_round3 = "SELECT * FROM `tb_assign` WHERE assign_task = 'pack' AND so_id = '$so_no' AND assign_round = 3 ";
                                    $query_select_round3 = $mysqli->query($sql_select_round3);
                                    $data_round3 = mysqli_fetch_object($query_select_round3);
                                    if ($data_round3->assign_status == 51) {
                                        $show_active2pack = 'active select_sub_tab';
                                        $show_cursor2pack = 'pointer';
                                    } else {
                                        $show_active2pack = '';
                                        $show_cursor2pack = 'not-allowed';
                                    }

                                    ?>
                                    <ul class="nav nav-tabs">
                                        <li style="cursor: pointer" class=" nav-item">
                                            <a class="nav-link  select_sub_tab" id="pack_round_1">ครั้งที่ 1
                                            </a>
                                        </li>
                                        <li style="cursor: pointer" class="nav-item">
                                            <a class="nav-link select_sub_tab" id="pack_round_2">
                                                ครั้งที่ 2
                                            </a>
                                        </li>
                                        <li style="cursor: <?php echo $show_cursor2pack; ?>" class="nav-item">
                                            <a class="nav-link <?php echo $show_active2pack; ?> " id="pack_round_3">
                                                ครั้งที่ 3
                                            </a>
                                        </li>
                                    </ul>
                                <?php } else { ?>
                                    <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active text-dark" id="round_1_li" data-toggle="pill"
                                               href="#round_1" role="tab"
                                               aria-controls="custom-content-below-home" aria-selected="true">ครั้งที่
                                                1</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-dark" id="round_2_li" data-toggle="pill"
                                               href="#round_2" role="tab"
                                               aria-controls="custom-content-below-profile" aria-selected="false">ครั้งที่
                                                2</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-dark" id="round_3_li" data-toggle="pill"
                                               href="#round_3" role="tab"
                                               aria-controls="custom-content-below-messages" aria-selected="false">ครั้งที่
                                                3</a>
                                        </li>
                                    </ul>
                                <?php } ?>
                                <div class="tab-content">
                                    <div class="tab-pane fade show active">
                                        <div id="show_round_pack"></div>
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
        let table
        let soNo = $('#order_code').val()
        // on-load
        let round_curr = $('#round_current').val()
        let round_curr_pack = $('#round_current_pack').val()
        console.log('รอบของหยิบ', round_curr)
        //pick
        $.ajax({
            url: `controller/sup/data_assignno.php`,
            method: 'POST',
            data: {
                so_no: soNo,
                ass_round: round_curr
            },
            success: function (response) {
                let pre_data = JSON.parse(response)
                console.log(pre_data)
                if (pre_data) {
                    if (pre_data.assign_status != 51) {
                        console.log('เข้า ไม่เท่า 51')
                        $.ajax({
                            url: `controller/sup/data_assignno.php`,
                            method: 'POST',
                            data: {
                                so_no: soNo,
                                ass_round: round_curr - 1
                            },
                            success: function (responseData) {
                                let pre_data2 = JSON.parse(responseData)
                                $.ajax({
                                    url: `component/sup/table_round_first.php`,
                                    method: 'POST',
                                    data: {
                                        so_id: soNo,
                                        assign_no: pre_data2.assign_no
                                    },
                                    success: function (response) {
                                        let ro_cur = round_curr - 1
                                        $(`#show_round`).html(response);
                                        $('#round_' + ro_cur).addClass('active')
                                    }
                                });
                            }
                        });
                    } else {
                        console.log('เข้า เท่า 51')
                        $.ajax({
                            url: `component/sup/table_round_first.php`,
                            method: 'POST',
                            data: {
                                so_id: soNo,
                                assign_no: pre_data.assign_no
                            },
                            success: function (response) {
                                $(`#show_round`).html(response);
                            }
                        });
                    }
                } else {
                    $.ajax({
                        url: `controller/sup/data_assignno.php`,
                        method: 'POST',
                        data: {
                            so_no: soNo,
                            ass_round: round_curr - 1
                        },
                        success: function (responseData) {
                            let pre_data2 = JSON.parse(responseData)
                            $.ajax({
                                url: `component/sup/table_round_first.php`,
                                method: 'POST',
                                data: {
                                    so_id: soNo,
                                    assign_no: pre_data2.assign_no
                                },
                                success: function (response) {
                                    let ro_cur = round_curr - 1
                                    $(`#show_round`).html(response);
                                    $('#round_' + ro_cur).addClass('active')
                                }
                            });
                        }
                    });
                }

            }
        });
        //pick
        //pack
        $.ajax({
            url: `controller/sup/data_assignno_pack.php`,
            method: 'POST',
            data: {
                so_no: soNo,
                ass_round: round_curr_pack
            },
            success: function (response) {
                let pre_data = JSON.parse(response)
                console.log(pre_data)
                if (pre_data) {
                    if (pre_data.assign_status != 52) {
                        console.log('เข้า ไม่เท่า 51')
                        $.ajax({
                            url: `controller/sup/data_assignno_pack.php`,
                            method: 'POST',
                            data: {
                                so_no: soNo,
                                ass_round: round_curr_pack - 1
                            },
                            success: function (responseData) {
                                let pre_data2 = JSON.parse(responseData)
                                $.ajax({
                                    url: `component/sup/table_round_pack.php`,
                                    method: 'POST',
                                    data: {
                                        so_id: soNo,
                                        assign_no: pre_data2.assign_no
                                    },
                                    success: function (response) {
                                        let ro_cur = round_curr - 1
                                        $(`#show_round_pack`).html(response);
                                        $('#pack_round_' + ro_cur).addClass('active')
                                    }
                                });
                            }
                        });
                    } else {
                        console.log('เข้า เท่า 51')
                        $.ajax({
                            url: `component/sup/table_round_pack.php`,
                            method: 'POST',
                            data: {
                                so_id: soNo,
                                assign_no: pre_data.assign_no
                            },
                            success: function (response) {
                                $(`#show_round_pack`).html(response);
                            }
                        });
                    }
                } else {

                }

            }
        });
        //pack
        // on-load

        $('.refresh_order_page').click(function () {
            let soid = $(this).attr('id')
            console.log(soid)
            // location.reload()
            $.ajax({
                url: 'pages/sup/order_detail.php',
                method: 'POST',
                data: {
                    so_id: soid
                },
                success: function (response) {
                    $('#main-stage').html(response);

                    if ($.fn.dataTable.isDataTable('#show-table')) {
                        $('#list_so').DataTable().clear().destroy();
                    }
                    table = $("#list_so").DataTable({
                        retrieve: false,
                        destroy: true,
                        language: {
                            search: "ค้นหา:",
                            searchPlaceholder: "พิมพ์คำที่ต้องการค้นหา",
                            info: 'แสดงหน้าที่ _PAGE_ จาก _PAGES_ ( จำนวน _MAX_ รายการ )',
                            infoEmpty: 'ไม่มีข้อมูล',
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
                        responsive: false
                    });
                }
            });
        })

        $('.back_to_app_aup').click(function () {
            $.ajax({
                url: 'pages/sup/dashboard.php',
                method: 'POST',
                success: function (response) {
                    $('#main-stage').html(response);
                },
                error: function (xhr, status, error) {
                    console.error("Error loading content: " + status + " " + error);
                }
            });
        })

        if ($.fn.dataTable.isDataTable('#show-table')) {
            $('#list_so').DataTable().clear().destroy();
        }
        table = $("#list_so").DataTable({
            retrieve: false,
            destroy: true,
            language: {
                search: "ค้นหา:",
                searchPlaceholder: "พิมพ์คำที่ต้องการค้นหา",
                info: 'แสดงหน้าที่ _PAGE_ จาก _PAGES_ ( จำนวน _MAX_ รายการ )',
                infoEmpty: 'ไม่มีข้อมูล',
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
            responsive: false
        });
    })

    $('.select_sub_tab').click(function () {
        let tab = $(this).attr('id')
        let soNo = $('#order_code').val()
        $('.select_sub_tab').removeClass('active');
        $('#' + tab).addClass('active');
        console.log(tab)
        let url_file
        let dom_data
        let ass_round
        if (tab === 'round_1') {
            url_file = 'table_round_first'
            dom_data = '#show_round_first'
            ass_round = 1
        } else if (tab === 'round_2') {
            url_file = 'table_round_second'
            dom_data = '#show_round_second'
            ass_round = 2
        } else if (tab === 'round_3') {
            ass_round = 3
        }

        $.ajax({
            url: `controller/sup/data_assignno.php`,
            method: 'POST',
            data: {
                so_no: soNo,
                ass_round
            },
            success: function (response) {
                let pre_data = JSON.parse(response)
                console.log(pre_data)
                $.ajax({
                    url: `component/sup/table_round_first.php`,
                    method: 'POST',
                    data: {
                        so_id: soNo,
                        assign_no: pre_data.assign_no
                    },
                    success: function (response) {
                        $(`#show_round`).html(response);
                    }
                });
            }
        });
    })
</script>
