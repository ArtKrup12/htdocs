<?php
session_start();
include "../../config/connect.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//print_r($_SESSION);
function formatThaiDate($datetime)
{
    if ($datetime === '0000-00-00 00:00:00') {
        return '-';
    }
    $timestamp = strtotime($datetime);
    $day = date("d", $timestamp);
    $month = date("m", $timestamp);
    $year = date("Y", $timestamp) + 543;
    return $day . "/" . $month . "/" . $year;
}

function calculateTimeDifference($start, $end)
{
    if (empty($start) || empty($end) || $start == '0000-00-00 00:00:00' || $end == '0000-00-00 00:00:00') {
        return '-';
    }
    $start_time = strtotime($start);
    $end_time = strtotime($end);
    $diff = $end_time - $start_time;
    $hours = floor($diff / 3600);
    $minutes = floor(($diff % 3600) / 60);
    $seconds = $diff % 60;
    return sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
}

function calWorkTime($start_dt, $stop_dt)
{
    if (empty($start_dt) || empty($stop_dt) || $start_dt === '0000-00-00 00:00:00' || $stop_dt === '0000-00-00 00:00:00') {
        return '-';
    }
    try {
        $startdate = new DateTime($start_dt);
        $stopdate = new DateTime($stop_dt);
    } catch (Exception $e) {
        return 'Error: ' . $e->getMessage();
    }

    $interval = $startdate->diff($stopdate);
    $hours = ($interval->days * 24) + $interval->h;
    $minutes = $interval->i;
    $seconds = $interval->s;

    return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
}

$tab_select = $_POST['case'];

if ($tab_select == 'waiting') {
    $where_status = "HAVING last_status IS NULL OR pick_status = 43 OR pack_status = 63";
} elseif ($tab_select == 'assign') {
    $where_status = "HAVING last_status IN (2) ";
} elseif ($tab_select == 'onprocess') {
    $where_status = "HAVING last_status IN (3,5)";
} elseif ($tab_select == 'success') {
    $where_status = "HAVING last_status IN (41,61)";
} elseif ($tab_select == 'unsuccess') {
    $where_status = "HAVING last_status IN (4,42,6,62)";
} elseif ($tab_select == 'all') {
    $where_status = ''; // ไม่มีการกรอง
}


$checkQuery = "SELECT 
    tb_sale_order.so_id,
    tb_sale_order.so_date,
    tb_sale_order.cust_id,
    tb_customer.cust_name,
    COUNT(tb_sale_order_detail.so_id) AS list_count,
    tb_sale_order.pick_status,
    tb_sale_order.pack_status
FROM 
    tb_sale_order
LEFT JOIN 
    tb_customer ON tb_customer.cust_id = tb_sale_order.cust_id
LEFT JOIN 
    tb_sale_order_detail ON tb_sale_order_detail.so_id = tb_sale_order.so_id
GROUP BY 
    tb_sale_order.so_id, 
    tb_sale_order.so_date, 
    tb_sale_order.cust_id, 
    tb_customer.cust_name
ORDER BY 
    tb_sale_order.create_dt DESC;
";

$result = mysqli_query($mysqli, $checkQuery);

while ($row = mysqli_fetch_assoc($result)) {
    $so_id = $row['so_id'];

    // Query สำหรับ pick
    $pickQuery = "SELECT 
                        tb_assign.assign_no, 
                        tb_assign.so_id, 
                        tb_assign.assign_task, 
                         tb_assign.delegatee_id,
                        IFNULL(tb_approval.approve_status, tb_assign.assign_status) AS status,  
                        IFNULL(tb_approval.approve_dt, tb_assign.modify_dt) AS modify_dt 
                      FROM 
                        tb_assign 
                      LEFT JOIN 
                        tb_approval 
                      ON 
                        tb_approval.assign_no = tb_assign.assign_no 
                      WHERE 
                        tb_assign.so_id = '$so_id' 
                        AND tb_assign.assign_task = 'pick' ORDER BY tb_assign.assign_round DESC LIMIT 1";
    $pickResult = mysqli_query($mysqli, $pickQuery);
    $pickData = mysqli_fetch_assoc($pickResult);

    // Query สำหรับ pack
    $packQuery = "SELECT 
                        tb_assign.assign_no, 
                        tb_assign.so_id, 
                        tb_assign.assign_task, 
                         tb_assign.delegatee_id,
                        IFNULL(tb_approval.approve_status, tb_assign.assign_status) AS status,  
                        IFNULL(tb_approval.approve_dt, tb_assign.modify_dt) AS modify_dt 
                      FROM 
                        tb_assign 
                      LEFT JOIN 
                        tb_approval 
                      ON 
                        tb_approval.assign_no = tb_assign.assign_no 
                      WHERE 
                        tb_assign.so_id = '$so_id' 
                        AND tb_assign.assign_task = 'pack' ORDER BY tb_assign.assign_round DESC LIMIT 1";
    $packResult = mysqli_query($mysqli, $packQuery);
    $packData = mysqli_fetch_assoc($packResult);

    // ตรวจสอบข้อมูล pick และ pack
    $row['pick_status'] = $pickData ? $pickData['status'] : $row['pick_status'];
    $row['pick_delegatee_id'] = $pickData ? $pickData['delegatee_id'] : null;
    $row['pick_modify_dt'] = $pickData ? $pickData['modify_dt'] : null;

    $row['pack_status'] = $packData ? $packData['status'] : $row['pack_status'];
    $row['pack_delegatee_id'] = $packData ? $packData['delegatee_id'] : null;
    $row['pack_modify_dt'] = $packData ? $packData['modify_dt'] : null;

    // ตรวจสอบสถานะล่าสุดระหว่าง pick และ pack
    if (!$row['pick_modify_dt'] || ($row['pack_modify_dt'] && $row['pack_modify_dt'] > $row['pick_modify_dt'])) {
        $row['status_last'] = $row['pack_status'];
        $row['status_last_id'] = $packData ? $packData['assign_no'] : 'pack_status';
    } else {
        $row['status_last'] = $row['pick_status'];
        $row['status_last_id'] = $pickData ? $pickData['assign_no'] : 'pick_status';
    }

    // เก็บผลลัพธ์ใน array
    $data[] = $row;
}

if (sizeof($data) > 0) {
    foreach ($data as $row_Data) { ?>
        <tr>
            <td align='left'>
                <input name="items[]"
                    <?php
                    $valid_status = ['', '11', '13', '21', '22'];
                    if (in_array($row_Data['pick_status'], $valid_status) || in_array($row_Data['pack_status'], $valid_status)) {
                    } else {
                        echo 'disabled';
                    }
                    ?>
                       type="checkbox" class="select-checkbox"
                       data-soid="<?php echo htmlspecialchars($row_Data['so_id'], ENT_QUOTES, 'UTF-8'); ?>"
                       data-name="<?php echo htmlspecialchars($row_Data['cust_name'], ENT_QUOTES, 'UTF-8'); ?>"
                       data-status_pick="<?php echo htmlspecialchars($row_Data['pick_status'], ENT_QUOTES, 'UTF-8'); ?>"
                       data-status_pack="<?php echo htmlspecialchars($row_Data['pack_status'], ENT_QUOTES, 'UTF-8'); ?>"
                >
            </td>
            <td>
                <a
                        class="btn btn-info btn-sm text-white open_detail" id="<?php echo $row_Data['so_id']; ?>"
                        style="background-color: #273746;border-color: #273746;cursor: pointer"><?php echo $row_Data['so_id']; ?></a>
            </td>
            <td align='center'><?php echo $row_Data['so_date']; ?></td>
            <td align='center'><?php echo $row_Data['cust_id']; ?></td>
            <td align='center'><?php echo $row_Data['cust_name']; ?></td>
            <td align='right'><?php
                $sql13 = "SELECT so_num FROM `tb_sale_order_detail` WHERE so_id = '" . $row_Data['so_id'] . "'";
                $query13 = $mysqli->query($sql13);
                $check_row = mysqli_num_rows($query13);
                echo $check_row;
                ?></td>
            <td align='left'>-</td>
            <td align='left'>
                <?php
                $pick_emp_name = '-'; // กำหนดค่าเริ่มต้นเป็น "-"
                if (!empty($row_Data['pick_delegatee_id'])) { // ตรวจสอบว่า pick_delegatee_id ไม่เป็น null หรือว่าง
                    $sql16 = "SELECT * FROM `tb_employee` WHERE emp_id = '" . $row_Data['pick_delegatee_id'] . "'";
                    $query16 = $mysqli->query($sql16);
                    $pick_ep = mysqli_fetch_object($query16);
                    if ($pick_ep) {
                        $pick_emp_name = $pick_ep->emp_name . ' ' . $pick_ep->emp_surname; // ถ้ามีข้อมูล ให้ใช้ชื่อพนักงาน
                    }
                }
                echo $pick_emp_name; // แสดงชื่อพนักงาน หรือ "-"
                ?>
            </td>
            <td align='left'>
                <?php
                $pack_emp_name = '-'; // กำหนดค่าเริ่มต้นเป็น "-"
                if (!empty($row_Data['pack_delegatee_id'])) { // ตรวจสอบว่า pack_delegatee_id ไม่เป็น null หรือว่าง
                    $sql17 = "SELECT * FROM `tb_employee` WHERE emp_id = '" . $row_Data['pack_delegatee_id'] . "'";
                    $query17 = $mysqli->query($sql17);
                    $pack_ep = mysqli_fetch_object($query17);
                    if ($pack_ep) {
                        $pack_emp_name = $pack_ep->emp_name . ' ' . $pack_ep->emp_surname; // ถ้ามีข้อมูล ให้ใช้ชื่อพนักงาน
                    }
                }
                echo $pack_emp_name; // แสดงชื่อพนักงาน หรือ "-"
                ?>
            </td>
            <td align='center'>
                <?php
                $sql50 = "SELECT * FROM `tb_assign` WHERE so_id = '" . $row_Data['so_id'] . "' AND assign_task = 'pick' ORDER BY assign_round DESC LIMIT 1";
                $query50 = $mysqli->query($sql50);
                $assign_no_data = mysqli_fetch_object($query50);
                //                echo $assign_no_data->assign_no ?? '-' ;
                if (isset($assign_no_data->assign_no)) {
                    $sql52 = "SELECT * FROM `tb_result` WHERE assign_no = '" . $assign_no_data->assign_no . "'";
                    $query52 = $mysqli->query($sql52);
                    $data_result = mysqli_fetch_object($query52);
                    if (isset($data_result->assign_no)) {
                         if ($data_result->stop_dt == '0000-00-00 00:00:00') {
                             echo '-';
                         }else{
                             $start = new DateTime($data_result->start_dt);
                             $stop = new DateTime($data_result->stop_dt);

                             $interval = $start->diff($stop);

                             $hours = sprintf('%02d', $interval->h);
                             $minutes = sprintf('%02d', $interval->i);
                             $seconds = sprintf('%02d', $interval->s);

                             echo $hours . ':' . $minutes . ':' . $seconds;
                         }

//                        $totalMinutes = ($hours * 60) + $minutes + ($seconds / 60);
//                        echo round($totalMinutes, 0) . ' นาที';
                    } else {
                        echo '-';
                    }
                } else {
                    echo '-';
                }
                ?>
            </td>
            <td align='left'>
                <?php
                $sql51 = "SELECT * FROM `tb_assign` WHERE so_id = '" . $row_Data['so_id'] . "' AND assign_task = 'pack'";
                $query51 = $mysqli->query($sql51);
                $assign_no_data2 = mysqli_fetch_object($query51);
                //                echo $assign_no_data2->assign_no ?? '-';
                if (isset($assign_no_data2->assign_no)) {
                    $sql52 = "SELECT * FROM `tb_result` WHERE assign_no = '" . $assign_no_data2->assign_no . "'";
                    $query52 = $mysqli->query($sql52);
                    $data_result = mysqli_fetch_object($query52);
                    if (isset($data_result->assign_no)) {
                          if ($data_result->stop_dt == '0000-00-00 00:00:00') {
                             echo '-';
                         }else{
                              $start = new DateTime($data_result->start_dt);
                              $stop = new DateTime($data_result->stop_dt);

                              $interval = $start->diff($stop);

                              $hours = sprintf('%02d', $interval->h);
                              $minutes = sprintf('%02d', $interval->i);
                              $seconds = sprintf('%02d', $interval->s);
                              echo $hours . ':' . $minutes . ':' . $seconds;
                          }

//                        $totalMinutes = ($hours * 60) + $minutes + ($seconds / 60);
//                        echo round($totalMinutes, 0) . ' นาที';
                    } else {
                        echo '-';
                    }
                } else {
                    echo '-';
                }
                ?>

            </td>
            <td>
                <?php echo $row_Data['status_last']; ?>
            </td>
        </tr>
    <?php } ?>
<?php } else { ?>
    <tr>
        <td align="center" width="100%" colspan="12">--- ไม่พบข้อมูล ---</td>
    </tr>
<?php } ?>
<script>
    $(document).ready(function () {
        let selectedSoIds
        $(document).on('click', '.open_detail', function () {
            let data_arr = $(this).attr('id')
            console.log(data_arr)
            $.ajax({
                url: 'pages/sup/order_detail.php',
                method: 'POST',
                data: {
                    so_id: data_arr
                },
                success: function (response) {
                    $('#main-stage').html(response);
                },
                error: function (xhr, status, error) {
                    console.error("Error loading content: " + status + " " + error);
                }
            });
        })

        $('#submitBtn').click(function () {
            console.log('test show :' + selectedSoIds)
            $.ajax({
                url: `component/sup/modal_assign.php`,
                method: 'POST',
                data: {
                    list: selectedSoIds
                },
                success: function (data) {
                    $('#show-descript').html(data);

                    $("#assign_modal").DataTable({
                        // scrollX: false,
                        // scrollY: '200',
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
                        responsive: false,
                    });
                }
            });
        })

        $(document).on('change', '.select-checkbox', function () {
            getSelectedSoIds();
        });

        $('#select-all').on('click', function () {
            $('.select-checkbox:not(:disabled)').prop('checked', $(this).prop('checked'));
            getSelectedSoIds();
        });
        checkEnabledCheckboxes();


        function getSelectedSoIds() {
            selectedSoIds = [];
            $('.select-checkbox:checked').each(function () {
                let soId = $(this).data('soid');
                let name = $(this).data('name');
                let status_pick = $(this).data('status_pick');
                let status_pack = $(this).data('status_pack');

                selectedSoIds.push({
                    soid: soId,
                    name: name,
                    status_pick,
                    status_pack
                });
            });
            console.log("Selected soIds:", selectedSoIds);
            if (selectedSoIds.length === 0) {
                $('#submitBtn').attr('disabled', true);
            } else {
                $('#submitBtn').removeAttr('disabled');
            }
        }

        function checkEnabledCheckboxes() {
            const hasEnabledCheckbox = $('.select-checkbox:not(:disabled)').length > 0;
            $('#select-all').prop('disabled', !hasEnabledCheckbox);
            // อัปเดตสถานะของ checkbox "เลือกทั้งหมด"
            const checkedCount = $('.select-checkbox:checked').length;
            $('#select-all').prop('checked', checkedCount === $('.select-checkbox:not(:disabled)').length);
        }

        // });
    })
</script>
