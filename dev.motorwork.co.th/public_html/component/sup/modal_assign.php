<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "../../config/connect.php";
$list = $_POST['list'];
//print_r($list) ;
?>
<div class="row">
    <div class="col-md-12">
        <div class="tab-content">
            <div class="active tab-pane" id="general">
                <div class="box-body">
                    <div class="form-group col-md-12">
                        <div
                            <?php if (sizeof($list) > 9) {
                                $h = 'max-height:400px;';
                            } else {
                                echo "";
                            } ?>
                                style="<?php echo $h; ?> overflow-y: auto;overflow-x: hidden">
                            <table class="table table-bordered table-striped rounded" id="assign_modal">
                                <thead>
                                <tr>
                                    <th width="5%">ลำดับ</th>
                                    <th width="5%">เลขที่ใบขาย</th>
                                    <th width="50%">ชื่อลูกค้า</th>
                                    <th width="20%">สถานะหยิบ</th>
                                    <th width="20%">สถานะแพ็ค</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $statusDataArray = [];
                                for ($i = 0; $i < sizeof($list); $i++) {
                                    ?>
                                    <tr>
                                        <td width="5%"><?php echo $i + 1; ?></td>
                                        <td width="5%"><?php echo $list[$i]['soid']; ?></td>
                                        <td width="50%"><?php echo $list[$i]['name']; ?></td>
                                        <td width="20%"><?php
                                            $pickQuery = "SELECT * FROM `tb_status` WHERE status_id = '".$list[$i]['status_pick']."'";
                                            $pickResult = mysqli_query($mysqli, $pickQuery);
                                            $pickData = mysqli_fetch_object($pickResult);
                                            echo $pickData->status_name;
                                            ?></td>
                                        <td width="20%"><?php
                                            $packQuery = "SELECT * FROM `tb_status` WHERE status_id = '".$list[$i]['status_pack']."'";
                                            $packResult = mysqli_query($mysqli, $packQuery);
                                            $packData = mysqli_fetch_object($packResult);
                                            echo $packData->status_name;
                                            ?></td>
                                    </tr>
                               <?php
                                    $statusDataArray[] =  $list[$i] ;
                                } ?>
                                </tbody>
                                <?php
                                $statusJson = json_encode($statusDataArray); ?>
                                <input type="hidden" class="list_data"
                                       data-list='<?php echo $statusJson; ?>'>
                            </table>
                        </div>
                    </div>
                    <?php
                    $option_list = array();
                    $sqloption = "SELECT emp_id, CONCAT(emp_name, ' ', emp_surname) as name FROM `tb_employee` WHERE emp_status = 1 AND role_no = 3;";
                    $queryoption = $mysqli->query($sqloption);

                    while ($row_Data = mysqli_fetch_assoc($queryoption)) {
                        $option_list[] = $row_Data;
                    } ?>

                    <div class="d-flex justify-content-between">
                        <div class="form-group w-50 pr-2">
                            <label for="member_pick">พนักงานหยิบ</label>
                            <select class="form-control" id="member_pick">
                                <option style="background-color: gray;color: white" value="" disabled selected>
                                    กรุณาเลือกพนักงาน
                                </option>
                                <option style="background-color: gray;color: white" value="">ไม่มอบหมายงานหยิบ</option>
                                <?php foreach ($option_list as $option) { ?>
                                    <option value="<?php echo $option['emp_id']; ?>"><?php echo $option['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group w-50 pl-2">
                            <label for="member_pack">พนักงานแพ็ค</label>
                            <select class="form-control" id="member_pack">
                                <option style="background-color: gray;color: white" value="" disabled selected>
                                    กรุณาเลือกพนักงาน
                                </option>
                                <option style="background-color: gray;color: white" value="">ไม่มอบหมายงานแพ็ค</option>
                                <?php foreach ($option_list as $option) { ?>
                                    <option value="<?php echo $option['emp_id']; ?>"><?php echo $option['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        const $select = $('#member_pick');
        const $placeholder = $select.find('option[disabled][selected]');

        $select.on('focus', function () {
            $placeholder.hide();
        });

        $select.on('blur', function () {
            if (!$select.val()) {
                $placeholder.show();
            }
        });

        const $select2 = $('#member_pack');
        const $placeholder2 = $select2.find('option[disabled][selected]');

        $select2.on('focus', function () {
            $placeholder2.hide();
        });

        $select2.on('blur', function () {
            if (!$select2.val()) {
                $placeholder2.show();
            }
        });
    });

    $(document).on('click', '.removeSelect', function () {
        $('#member_pick').val(''); // ตั้งค่ากลับเป็น default (value="")
        $('#member_pack').val(''); // ตั้งค่ากลับเป็น default (value="")
        $('.addAssign').prop('disabled', true);
        // $('.addAssign').addCss('cursor', 'not-allowed');
    });

    $(document).on('click', '.addAssign', function () {
        let list = $('.list_data').data('list');
        let member_pick = $('#member_pick').val();
        let member_pack = $('#member_pack').val();
        console.log(list)
        console.log(member_pick + ' : ' + member_pack)

        if (member_pick && !member_pack) {
                console.log('pick')
                for (let i = 0; i < list.length; i++) {
                    console.log(list[i].soid, list[i].status_pick)
                    $.ajax({
                        url: `controller/sup/post_assign.php`,
                        method: 'POST',
                        data: {
                            action: 'assign',
                            sub_action: 'pick',
                            so_id: list[i].soid,
                            status_pick:list[i].status_pick,
                            member_pick
                        },
                        success: function (data) {
                            console.log(data)
                            // location.reload()
                        }
                    });
                }
                setTimeout(() => {
                    location.reload();
                }, 100);
            }

        if (!member_pick && member_pack) {
                console.log('pack')
                for (let i = 0; i < list.length; i++) {
                    console.log(list[i].soid, list[i].status_pack,i)
                    $.ajax({
                        url: `controller/sup/post_assign.php`,
                        method: 'POST',
                        data: {
                            action: 'assign',
                            sub_action: 'pack',
                            so_id: list[i].soid,
                            status_pack:list[i].status_pack,
                            member_pack
                        },
                        success: function (data) {
                            // console.log(data)
                            // location.reload()
                        }
                    });
                }
                setTimeout(() => {
                    location.reload();
                }, 100);
            }

        if (member_pick && member_pack) {
                console.log('pack and pack')
                for (let i = 0; i < list.length; i++) {
                    console.log(list[i].soid, list[i].status_pick)
                    $.ajax({
                        url: `controller/sup/post_assign.php`,
                        method: 'POST',
                        data: {
                            action: 'assign',
                            sub_action: 'pick',
                            so_id: list[i].soid,
                            status_pick:list[i].status_pick,
                            member_pick
                        },
                        success: function (data) {
                            console.log(data)
                            location.reload()
                        }
                    });
                }

                for (let i = 0; i < list.length; i++) {
                    console.log(list[i].soid, list[i].status_pack)
                    $.ajax({
                        url: `controller/sup/post_assign.php`,
                        method: 'POST',
                        data: {
                            action: 'assign',
                            sub_action: 'pack',
                            so_id: list[i].soid,
                            status_pack:list[i].status_pack,
                            member_pack
                        },
                        success: function (data) {
                            console.log(data)
                            location.reload()
                        }
                    });
                }

                setTimeout(() => {
                    location.reload();
                }, 200);
            }

    })

    $(document).ready(function () {
        $('#member_pick').on('change', function () {
            let member_pick = $('#member_pick').val();
            let member_pack = $('#member_pack').val();
            if (!member_pick && !member_pack){
                $('.addAssign').prop('disabled', true);
            }else{
                $('.addAssign').prop('disabled', false);
            }


        })
        $('#member_pack').on('change', function () {
            let member_pick = $('#member_pick').val();
            let member_pack = $('#member_pack').val();
            if (!member_pick && !member_pack){
                $('.addAssign').prop('disabled', true);
            }else{
                $('.addAssign').prop('disabled', false);
            }
        })
    })

</script>