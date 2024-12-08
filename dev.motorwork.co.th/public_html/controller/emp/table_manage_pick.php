<?php
include "../../config/connect.php";
$action = $_POST['tab'];
?>
<thead>
<tr class="active">
    <th align="center">ลำดับ</th>
    <th>รหัสสินค้า</th>
    <th>ชื่อสินค้า</th>
    <th width="10%">ตำแหน่ง</th>
    <th width="10%">จำนวนรวม</th>
    <?php if ($action == 'wait_process') { ?>

    <?php } else if ($action == 'success') { ?>
        <th width="10%">จำนวนนับได้</th>
    <?php } else if ($action == 'unsuccess') { ?>
        <th width="10%">จำนวนนับได้</th>
    <?php } ?>

</tr>
</thead>
<tbody>
<?php

if ($action == 'wait_process') {
    $where_status = "AND tb_sale_order_detail.flag_pick = 'X'";
} else if ($action == 'success') {
    $where_status = "AND tb_sale_order_detail.flag_pick = 'Y'";
} else if ($action == 'unsuccess') {
    $where_status = "AND tb_sale_order_detail.flag_pick = 'N'";
}
$sql12 = "SELECT * FROM `tb_assign` 
    JOIN tb_sale_order_detail ON tb_sale_order_detail.so_id = tb_assign.so_id 
    LEFT JOIN tb_product ON tb_product.prod_id = tb_sale_order_detail.prod_id
    WHERE tb_assign.so_id = '" . $_POST['so_id'] . "' AND tb_assign.assign_no = '" . $_POST['assign_id'] . "' " . $where_status;
//echo $sql12 ;

$query12 = $mysqli->query($sql12);
$num_row = mysqli_num_rows($query12);
if ($num_row > 0) {
    while ($row_Data = mysqli_fetch_assoc($query12)) { ?>
        <tr>
            <td align='center'><?php echo $row_Data['so_num']; ?></td>
            <td align='left'><?php echo $row_Data['prod_id']; ?></td>
            <td align='left'><?php echo $row_Data['prod_name']; ?></td>
            <td align='left'><?php echo $row_Data['prod_location']; ?></td>
            <td align='right'><?php echo $row_Data['prod_qty']; ?></td>
<!--            --><?php //if ($action == 'wait_process') { ?>
<!---->
<!--            --><?php //} else if ($action == 'success') { ?>
<!--                --><?php //if ($row_Data['assign_round'] == 1) { ?>
<!--                    <td align='right'>--><?php //echo $row_Data['pick_r1']; ?><!--</td>-->
<!--                --><?php //} else if ($row_Data['assign_round'] == 2) { ?>
<!--                    <td align='right'>--><?php //echo $row_Data['pick_r2']; ?><!--</td>-->
<!--                --><?php //} else { ?>
<!--                    <td align='right'>--><?php //echo $row_Data['pick_r3']; ?><!--</td>-->
<!--                --><?php //} ?>
<!--            --><?php //} else if ($action == 'unsuccess') { ?>
<!--                --><?php //if ($row_Data['assign_round'] == 1) { ?>
<!--                    <td align='right'>--><?php //echo $row_Data['pick_r1']; ?><!--</td>-->
<!--                --><?php //} else if ($row_Data['assign_round'] == 2) { ?>
<!--                    <td align='right'>--><?php //echo $row_Data['pick_r2']; ?><!--</td>-->
<!--                --><?php //} else { ?>
<!--                    <td align='right'>--><?php //echo $row_Data['pick_r3']; ?><!--</td>-->
<!--                --><?php //} ?>
<!--            --><?php //} ?>
        </tr>
    <?php } ?>
<?php } else { ?>
    <tr>
        <td align="center" colspan="5">-- ไม่มีรายการที่ <?php if ($action == 'wait_process') {
                echo "รอนับ";
            } else if ($action == 'success') {
                echo "เสร็จสิ้น";
            } else if ($action == 'unsuccess') {
                echo "ไม่สำเร็จ";
            } ?> --
        </td>
    </tr>
<?php } ?>
</tbody>