<?php
include "../../config/connect.php";
$action = $_POST['tab'];
?>

<?php

if ($action == 'wait_process') {
    $where_status = "AND tb_sale_order_detail.flag_pack = 'X' GROUP BY so_num ";
} else if ($action == 'success') {
    $where_status = "AND tb_sale_order_detail.flag_pack = 'Y' GROUP BY so_num  ";
} else if ($action == 'unsuccess') {
    $where_status = "AND tb_sale_order_detail.flag_pack = 'N' GROUP BY so_num  ";
}
//$sql12 = "SELECT * FROM `tb_assign`
//    JOIN tb_sale_order_detail ON tb_sale_order_detail.so_id = tb_assign.so_id
//   LEFT JOIN tb_pick ON tb_pick.assign_no = tb_assign.assign_no AND tb_sale_order_detail.so_detail_no = tb_pick.so_detail_no
//    LEFT JOIN tb_product ON tb_product.prod_id = tb_sale_order_detail.prod_id
//    WHERE tb_assign.so_id = '" . $_POST['so_id'] . "' AND tb_assign.assign_no = '" . $_POST['assign_id'] . "' " . $where_status;
//echo $sql12 ;

$sql12 = "
SELECT 
    tb_assign.*, 
    tb_sale_order_detail.*, 
    tb_product.*, 
    recent_pack.pack_qty 
FROM 
    tb_assign
JOIN 
    tb_sale_order_detail ON tb_sale_order_detail.so_id = tb_assign.so_id
LEFT JOIN 
    tb_product ON tb_product.prod_id = tb_sale_order_detail.prod_id
LEFT JOIN (
    SELECT 
        tb_pack.so_detail_no, 
        tb_pack.pack_qty, 
        tb_pack.assign_no 
    FROM 
        tb_pack
    WHERE 
        tb_pack.create_dt = (
            SELECT 
                MAX(create_dt) 
            FROM 
                tb_pack AS sub_pack
            WHERE 
                sub_pack.so_detail_no = tb_pack.so_detail_no
        )
) AS recent_pack ON 
    recent_pack.so_detail_no = tb_sale_order_detail.so_detail_no 
    AND recent_pack.assign_no = tb_assign.assign_no
WHERE 
    tb_assign.so_id = '" . $_POST['so_id'] . "' 
    AND tb_assign.assign_no = '" . $_POST['assign_id'] . "' 
    " . $where_status;

$query12 = $mysqli->query($sql12);
$num_row = mysqli_num_rows($query12);
if ($num_row > 0) {
    while ($row_Data = mysqli_fetch_assoc($query12)) {
        ?>
        <tr>
            <td align='center'><?php echo $row_Data['so_num']; ?></td>
            <td align='left'><?php echo $row_Data['prod_id']; ?></td>
            <td align='left'><?php echo $row_Data['prod_name']; ?></td>
            <td align='left'><?php echo $row_Data['prod_location']; ?></td>
            <td align='right'><?php echo $row_Data['prod_qty']; ?></td>
            <?php if ($action == 'wait_process') { ?>
                <td align='right'>-</td>
            <?php } else if ($action == 'success') { ?>
                <td align='right'><?php echo $row_Data['pack_qty']; ?></td>
            <?php } else if ($action == 'unsuccess') { ?>
                <td align='right'><?php echo $row_Data['pack_qty']; ?></td>
            <?php } ?>
        </tr>
    <?php } ?>
<?php } else { ?>
    <!--    <tr>-->
    <!--        <td align='center' colspan="6">--ไม่มีข้อมูล--</td>-->
    <!--    </tr>-->
<?php } ?>
