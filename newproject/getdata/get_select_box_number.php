<?php include '../condb.php';
if($_REQUEST['case'] == "noSelect"){ ?>
<input type="text" name="box_number" id="box_number" class="form-control"
       placeholder="หมายเลขกล่อง" disabled>
    <?php }else{ ?>
    <?php
    $sql2 = "SELECT box_number FROM tb_carton WHERE box_code = '".$_REQUEST['subData']."' GROUP BY box_number";
    $result2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_object($result2)
    ?>
        <input type="text" name="box_number" id="box_number" class="form-control" value="<?php echo $row2->box_number; ?>"
               placeholder="หมายเลขกล่อง" disabled>
<!--    <select id="box_number" name="box_number" placeholder="รหัสกล่อง . . .">-->
<!--        <option value="">รหัสกล่อง</option>-->
<!--        --><?php //while ($row2 = mysqli_fetch_array($result2)) { ?>
<!--            <option value="--><?php //echo $row2['box_number']; ?><!--">--><?php //echo $row2['box_number']; ?><!-- </option>-->
<!--        --><?php //} ?>
<!--    </select>-->
    <?php } ?>