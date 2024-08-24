<?php include('../condb.php'); ?>
<style>
    .showButton {
        display: none;
    }
</style>
<div class="table-responsive">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>

        <tr>

            <th>
                <div class="form-check"><input class="form-check-input position-static check-all" type="checkbox"
                                               id="checkAll"> ลำดับ
                </div>
            </th>
            <th>รายการ</th>
            <th class="text-center">
                <button class="btn btn-warning text-dark withdraw-multilist showButton">
                    เบิก 0 รายการ
                </button>
            </th>

        </tr>
        </thead>
        <tbody>
        <?php
        $sql = "SELECT * FROM tb_document_list WHERE box_code = '" . $_REQUEST['id'] . "' AND status = '10'";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($result)) {
        ?>

        <tr>
            <td>
                <div class="form-check">
                    <input class="form-check-input position-static" type="checkbox" id="blankCheckbox"
                           value="<?php echo $row["id"] ?>" aria-label="...">
                <?php echo $row["id"] ?></td>
</div>
    <td><?php echo $row["list"] ?></td>
    <td class="text-center">
        <button class="btn btn-warning text-dark withdraw-list"
                data-id="<?= $row["id"] . "?" . $row["list"] ?>">
            <!--                                                        <i class="fas fa-arrow-right"></i>-->
            เบิก
        </button>
    </td>
    </tr>

<?php
}
//                                            mysqli_close($conn);
?>

</tbody>
</table>
</div>
<!--<script src="../vendor/datatables/jquery.dataTables.min.js"></script>-->
<!--<script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $('.form-check-input').change(function () {
        // รวบรวมค่าของ checkboxes ที่ถูกเลือก
        var selectedValues = [];
        $('.form-check-input:checked').each(function () {
            selectedValues.push($(this).val());
        });

        // อัปเดตข้อความและคลาสของปุ่ม withdraw-multilist
        console.log(selectedValues)
        if (selectedValues.length > 0) {
            if (selectedValues[0] === 'on') {
                $('.withdraw-multilist')
                    .text('เบิก' + (selectedValues.length - 1) + 'รายการ')
                    .removeClass('showButton')
                    .val(selectedValues.join(','));
            } else {
                $('.withdraw-multilist')
                    .text('เบิก' + (selectedValues.length) + 'รายการ')
                    .removeClass('showButton')
                    .val(selectedValues.join(','));
            }


        } else {
            $('.withdraw-multilist')
                .text('เบิก 0 รายการ')
                .addClass('showButton')
                .val('');
        }
    });
    $('#checkAll').click(function () {
        if ($(this).prop('checked')) {
            // เลือกทุก checkbox ในตาราง
            $('.table tbody input[type="checkbox"]').prop('checked', true);
        } else {
            // ยกเลิกการเลือกทุก checkbox ในตาราง
            $('.table tbody input[type="checkbox"]').prop('checked', false);
        }
        $('.form-check-input').change();
    });

    $('.withdraw-multilist').click(async function () {
        var valueAttribute = $('.withdraw-multilist').val();
        var valueArray = valueAttribute.split(',')
        if (valueArray[0] === 'on') {
            valueArray.splice(0, 1)
        } else {
        }


        console.log(valueArray);

        // alert(valueArray)
        var statusCheckMulti
        const {value, isConfirmed} = await Swal.fire({
            title: "กรุณากรอกชื่อผู้เบิกและวันที่",
            html:
                `รายการ : ` + valueArray +
                `<input id="swal-input1" class="swal2-input" placeholder="ชื่อผู้เบิก" maxlength="255" autocapitalize="off" autocorrect="off">` +
                `<input id="swal-input2" class="swal2-input" type="date">`,
            showDenyButton: true,
            confirmButtonColor: "#17A673",
            confirmButtonText: "เบิก",
            denyButtonText: "ปิด",
            preConfirm: () => {
                return {
                    name: document.getElementById('swal-input1').value,
                    date: document.getElementById('swal-input2').value
                };
            },
            allowOutsideClick: false,
            showCloseButton: true,
        });

        let nameData
        let dateData
        if (isConfirmed) { // Use the isConfirmed property from Swal response
            statusCheckMulti = 'confirm';
            const {name, date} = value;
            nameData = name
            dateData = date
            console.log("Name:", name);
            console.log("Date:", date);
        } else {
            statusCheckMulti = 'cancel';
        }


        if (statusCheckMulti === 'confirm') {

            if (nameData && dateData) {
                var id_box = '<?= $_REQUEST['id']; ?>';
                // Swal.fire(`Entered password: ${name}`+idList);
                $.ajax({
                    url: "getdata/add_withdraw_Multi.php",
                    method: "POST",
                    data: {
                        id: valueArray,
                        name: nameData,
                        date: dateData
                    },
                    success: function (result) {
                        let res = JSON.parse(result)
                        console.log(res.status)
                        if (res.status === '200') {
                            $.ajax({
                                url: "table_data/carton_detail_in.php",
                                data: {
                                    id: id_box
                                },
                                success: function (result) {
                                    $("#list_in").html(result);

                                }
                            });
                            $.ajax({
                                url: "table_data/carton_detail_withdraw.php",
                                data: {
                                    id: id_box
                                },
                                success: function (result) {
                                    $("#list_withdraw").html(result);

                                }
                            });
                        } else {

                        }

                    }
                });

            } else {
                Swal.fire({
                    title: "พบข้อผิดพลาด",
                    text: "กรุณากรอกชื่อและวันที่เบิก",
                    icon: "warning",
                    confirmButtonText: "ตกลง",
                    confirmButtonColor: "#17A673"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('.withdraw-multilist').click();
                    }
                });


            }
        } else {

        }
    });

    $('.withdraw-list').on('click', async function (event,idFrom) {
        // let data = $('.withdraw-list').val()
        const clickedButton = $(this);
        console.log(idFrom)
        var id
        if(idFrom === undefined){
             id = clickedButton.data('id');
        }else{
             id = idFrom;
        }
        // Get the data-id attribute value

        let splittedSentence = id.split("?"); // ตัดประโยคด้วย "?"
        let idList = splittedSentence[0]; // เลือกประโยคที่ต้องการ
        let nameList = splittedSentence[1]; // เลือกประโยคที่ต้องการ console.log('Clicked button with id:', id);

        var statusCheck
        const {value, isConfirmed} = await Swal.fire({
            title: "กรุณากรอกชื่อผู้เบิกรายและวันที่",
            html:
                `รายการ : ` + nameList +
                `<input id="swal-input1" class="swal2-input" placeholder="ชื่อผู้เบิก" maxlength="255" autocapitalize="off" autocorrect="off">` +
                `<input id="swal-input2" class="swal2-input" type="date">`,
            showDenyButton: true,
            confirmButtonColor: "#17A673",
            confirmButtonText: "เบิก",
            denyButtonText: "ปิด",
            preConfirm: () => {
                return {
                    name: document.getElementById('swal-input1').value,
                    date: document.getElementById('swal-input2').value
                };
            },
            allowOutsideClick: false,
            showCloseButton: true,
        });
        let nameData
        let dateData
        if (isConfirmed) { // Use the isConfirmed property from Swal response
            statusCheck = 'confirm';
            const {name, date} = value;
            nameData = name
            dateData = date
            console.log("Name:", name);
            console.log("Date:", date);
        } else {
            statusCheck = 'cancel';
        }


        if (statusCheck === 'confirm') {

            if (nameData && dateData) {
                var id_box = '<?= $_REQUEST['id']; ?>';
                // Swal.fire(`Entered password: ${name}`+idList);
                $.ajax({
                    url: "getdata/add_withdraw.php",
                    method: "POST",
                    data: {
                        id: idList,
                        name: nameData,
                        date: dateData
                    },
                    success: function (result) {
                        let res = JSON.parse(result)
                        console.log(res.status)
                        if (res.status === '200') {
                            $.ajax({
                                url: "table_data/carton_detail_in.php",
                                data: {
                                    id: id_box
                                },
                                success: function (result) {
                                    $("#list_in").html(result);
                                }
                            });
                            $.ajax({
                                url: "table_data/carton_detail_withdraw.php",
                                data: {
                                    id: id_box
                                },
                                success: function (result) {
                                    $("#list_withdraw").html(result);
                                }
                            });
                        } else {

                        }

                    }
                });

            } else {
                Swal.fire({
                    title: "พบข้อผิดพลาด",
                    text: "กรุณากรอกชื่อและวันที่เบิก",
                    icon: "warning",
                    confirmButtonText: "ตกลง",
                    confirmButtonColor: "#17A673"
                }).then((result) => {
                    if (result.isConfirmed) {
                        console.log(id)
                        $('.withdraw-list').trigger('click', [id]);
                    }
                });


            }
        } else {

        }
        // ส่งค่า id ไปยังฟังก์ชัน JavaScript ที่คุณต้องการ
    });


    $('#dataTable').DataTable();
</script>