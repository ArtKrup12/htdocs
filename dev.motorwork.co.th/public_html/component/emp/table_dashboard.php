<?php
session_start();
include "../../config/connect.php";
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

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

//print_r($_SESSION);
$tab_select = $_POST['case'];
if ($tab_select == 'assign') {
//    $where_status = 2 ;
    $where_status = " AND tb_assign.assign_status IN (2)";
} else if ($tab_select == 'onprocess') {
//    $where_status = 3 ;
    $where_status = " AND tb_assign.assign_status IN (3)";
} else if ($tab_select == 'success') {
//    $where_status = 41 ;
    $where_status = " AND tb_assign.assign_status IN (41)";
} else if ($tab_select == 'unsuccess') {
//    $where_status = 4 ;
    $where_status = " AND tb_assign.assign_status IN (4)";
} else if ($tab_select == 'all') {
    $where_status = '';
}
//echo $where_status ;
//print_r($_SESSION) ;
$sql12 = "SELECT *,tb_assign.assign_no as ass_no,COUNT(tb_sale_order_detail.so_detail_no) as count_list ,
                    tb_status.status_name as span_status,tb_result.start_dt as startDate,
                    tb_result.stop_dt as stopDate,tb_assign.so_id FROM `tb_assign` 
    LEFT JOIN tb_sale_order_detail ON tb_sale_order_detail.so_id = tb_assign.so_id 
    LEFT JOIN tb_result ON tb_result.assign_no = tb_assign.assign_no 
    LEFT JOIN tb_sale_order ON tb_sale_order.so_id = tb_sale_order_detail.so_id 
    LEFT JOIN tb_product ON tb_product.prod_id = tb_sale_order_detail.prod_id
    LEFT JOIN tb_status ON tb_status.status_id = tb_assign.assign_status
    LEFT JOIN tb_customer ON tb_customer.cust_id = tb_sale_order.cust_id 
    WHERE tb_assign.delegatee_id = '" . $_SESSION['Member_IdLogin'] . "' " . $where_status . "  
    GROUP BY tb_assign.assign_no ORDER BY tb_assign.assign_dt DESC,tb_assign.so_id ASC";
//echo $sql12 ;
$query12 = $mysqli->query($sql12);
$check_row = mysqli_num_rows($query12);
if ($check_row > 0) {
    while ($row_Data = mysqli_fetch_assoc($query12)) {
        ?>
        <tr>
            <?php if (in_array($row_Data['assign_status'], ['41', '42', '51', '52'])) { ?>
                <td>
                    <a style="border-color: #696969;background-color: #696969;cursor: not-allowed"
                       class="btn btn-info btn-sm text-white ">
                        <?= $row_Data['assign_task'] == 'pick' ? 'หยิบ' : 'แพ็ค'; ?>
                    </a>
                </td>
                <td><?php echo $row_Data['span_status']; ?></td>
                <td>
                    <a id="<?php echo $row_Data['so_id'] . '#' . $row_Data['ass_no']; ?>"
                       class="<?= $row_Data['assign_task'] == 'pick' ? 'historyPick' : 'historyPack'; ?>"
                       style="text-decoration: underline;color:#1E90FF;cursor: pointer"><?php echo $row_Data['so_id']; ?>
                    </a>
                </td>
            <?php } else { ?>
                <td>
                    <a id="<?php echo $row_Data['so_id'] . '#' . $row_Data['ass_no']; ?>"
                       style="border-color: #9B111E;background-color: #9B111E;cursor: pointer"
                       class="btn btn-info btn-sm text-white  <?= $row_Data['assign_task'] == 'pick' ? 'managePick' : 'managePack'; ?>">
                        <?= $row_Data['assign_task'] == 'pick' ? 'หยิบ' : 'แพ็ค'; ?>
                    </a>
                </td>
                <td><?php echo $row_Data['span_status']; ?></td>
                <td>
                    <?php echo $row_Data['so_id']; ?>
                </td>
            <?php } ?>
            <td><?php $row_date = $row_Data['assign_dt'];
                echo formatThaiDate($row_date); ?></td>
            <td><?php echo $row_Data['so_date']; ?>
            <td><?php echo $row_Data['cust_id']; ?>
            <td style="width: 250px"><?php echo $row_Data['cust_name']; ?>
            </td>
            <td><?php echo $row_Data['count_list']; ?></td>
            <td><?php
                if($row_Data['assign_task'] == 'pack'){
                    $sql_select_result = "SELECT * FROM `tb_packing_number` WHERE so_id = '".$row_Data['so_id']."';";
                    $query_select_result = $mysqli->query($sql_select_result);
                    $data_result = $query_select_result->fetch_object();
                    echo $data_result->packing_number ?? '-' ;
                }else{
                    echo '-' ;
                }

                ?></td>
            <td><?php
                echo calculateTimeDifference($row_Data['startDate'], $row_Data['stopDate']); ?></td>
            <td>
                <?php
                if($row_Data['assign_status'] == '42' || $row_Data['assign_status'] == '62'){

                ?>
                <button
                        class="btn btn-danger btn-sm preview-pdf-btn"
                        data-so-id="<?= $row_Data['so_id'] ?>"
                        data-assign-no="<?= $row_Data['ass_no'] ?>"
                >
                    <i class="fas fa-print"></i>
                </button>
                <?php }else{ ?>
                <?php } ?>
            </td>
        </tr>
    <?php } ?>
<?php } else { ?>
    <tr>
        <td align="center" width="100%" colspan="12">
            --- ไม่พบข้อมูล ---
        </td>
    </tr>

<?php } ?>
<script>

    $(document).on('click', '.preview-pdf-btn', function() {
        var soId = $(this).data('so-id');
        var assignNo = $(this).data('assign-no');

        var pdfPath = 'component/emp/export_pdf_label.php?so_id=' + soId + '&assign_no=' + assignNo ;
        var isMobile = /Android|iPhone|iPad|iPod/i.test(navigator.userAgent);
        if (isMobile) {
            // ในกรณีมือถือที่ iframe อาจไม่รองรับ ให้เปิดในแท็บใหม่
            window.open(pdfPath, '_blank');
        } else {

            // สร้าง modal ใน AdminLTE 2 style
        $('#pdf-preview-modal').remove(); // ลบ modal เก่า

        var modalHtml = `
    <div class="modal fade" id="pdf-preview-modal" tabindex="-1" role="dialog">
<!--        <div class="modal-dialog modal-lg" role="document">-->
<div class="modal-dialog" role="document" style="width: 95%; max-width: 95%;">
            <div class="modal-content">
                <div class="modal-header">
<!--                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
<!--                        <span aria-hidden="true">&times;</span>-->
<!--                    </button>-->
                    <h4 class="modal-title">Preview Pdf</h4>
                </div>
                <div class="modal-body">
                    <iframe
                        src="${pdfPath}"
                        width="100%"
                        height="600"
                        frameborder="0">
                    </iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" style="background-color:#222D32;color: white " data-dismiss="modal">ปิด</button>
<!--                    <a href="${pdfPath}" class="btn btn-primary" download>ดาวน์โหลด</a>-->
                </div>
            </div>
        </div>
    </div>
    `;

        // เพิ่ม modal เข้าไปใน body
        $('body').append(modalHtml);

        // เปิด modal
        $('#pdf-preview-modal').modal('show');
        }
    });


    $('.managePick').click(function () {
        Swal.fire({
            title: 'กำลังโหลดข้อมูล...',
            text: 'กรุณารอสักครู่...',
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            }
        })
        let data_id = $(this).attr('id').split('#')
        let soNo = data_id[0]
        let assignNo = data_id[1]

        console.log(data_id)
        // localStorage.setItem('page','manage_pick')
        $.ajax({
            url: 'pages/emp/manage_pick.php',
            method: 'POST',
            data: {
                soNo,
                assignNo
            },
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

    $('.managePack').click(function () {
        Swal.fire({
            title: 'กำลังโหลดข้อมูล...',
            text: 'กรุณารอสักครู่...',
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            }
        })
        let data_id = $(this).attr('id').split('#')
        let soNo = data_id[0]
        let assignNo = data_id[1]

        console.log(data_id)
        // localStorage.setItem('page','manage_pick')
        $.ajax({
            url: 'pages/emp/manage_pack.php',
            method: 'POST',
            data: {
                soNo,
                assignNo
            },
            success: function (response) {
                $('#main-stage').html(response);
                setTimeout(function () {
                    Swal.close()
                }, 500)
            }
        });
    })

    $('.historyPick').click(function () {
        Swal.fire({
            title: 'กำลังโหลดข้อมูล...',
            text: 'กรุณารอสักครู่...',
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            }
        })
        let data_id = $(this).attr('id').split('#')
        let soNo = data_id[0]
        let assignNo = data_id[1]

        console.log(data_id)
        localStorage.setItem('page','manage_pick')
        $.ajax({
            url: 'pages/emp/history_pick.php',
            method: 'POST',
            data: {
                soNo,
                assignNo
            },
            success: function (response) {
                $('#main-stage').html(response);
                setTimeout(function () {
                    Swal.close()
                }, 500)
            },
            error: function (xhr, status, error) {
                console.error("Error loading content: " + status + " " + error);
            }
        })
    })

    $('.historyPack').click(function () {
        Swal.fire({
            title: 'กำลังโหลดข้อมูล...',
            text: 'กรุณารอสักครู่...',
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            }
        })
        let data_id = $(this).attr('id').split('#')
        let soNo = data_id[0]
        let assignNo = data_id[1]

        console.log(data_id)
        localStorage.setItem('page','manage_pack')
        $.ajax({
            url: 'pages/emp/history_pack.php',
            method: 'POST',
            data: {
                soNo,
                assignNo
            },
            success: function (response) {
                $('#main-stage').html(response);
                setTimeout(function () {
                    Swal.close()
                }, 500)
            },
            error: function (xhr, status, error) {
                console.error("Error loading content: " + status + " " + error);
            }
        })
    })
</script>
