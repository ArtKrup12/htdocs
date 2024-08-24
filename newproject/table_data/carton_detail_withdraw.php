<?php include ('../condb.php'); ?>
<style>
    .showButton2 {
        display: none;
    }
    .showButton3 {
        display: none;
    }
</style>
<div class="table-responsive">

    <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
        <thead>
        <tr>
            <th><div class="form-check2"><input class="form-check-input2  position-static check-all2" type="checkbox"
                                               id="checkAll2"> ลำดับ
                </div></th>
            <th>รายการ</th>
            <th>ผู้เบิก</th>
            <th>วันที่เบิก</th>
            <th class="text-center">
                <div class="d-flex justify-content-center"><button class="btn btn-success text-white withdraw-multilist2 mr-1 showButton2">
                </button>
                <button class="btn btn-danger text-white destroy-multilist2 showButton3">
                </button>
                </div>
            </th>

        </tr>
        </thead>
        <tbody>

        <?php
        function thai_date($date_str) {
            if ($date_str == '0000-00-00') {
                return '0000-00-00';
            }
            $date = date_create($date_str);
            $thai_date = date_format($date, 'j F Y');
            $thai_date = str_replace(
                ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
                $thai_date
            );
            $thai_year = date_format($date, 'Y') + 543;
            $thai_date = str_replace(date_format($date, 'Y'), $thai_year, $thai_date);
            return $thai_date;
        }

        $sql2 = "SELECT * FROM tb_document_list WHERE box_code = '" . $_REQUEST['id'] . "' AND status = 20";
        $result2 = mysqli_query($conn, $sql2);
        while ($row2 = mysqli_fetch_array($result2)) {
            ?>

            <tr>
                <td>  <div class="form-check2">
                        <input class="form-check-input2 position-static" type="checkbox" id="blankCheckbox2"
                               value="<?php echo $row2["id"] ?>" aria-label="...">
                    <?php echo $row2["id"] ?></td>
                <td><?php echo $row2["list"] ?></td>
                <td><?php echo $row2["name_withdraw"] ?></td>
                <td><?php echo thai_date($row2["date_document_withdraw"]) ?></td>
                <td class="text-center">
                    <button class="btn btn-success withdraw-list2" data-id="<?= $row2["id"]."?".$row2["list"] ?>">
                        <!--                                                        <i class="fas fa-arrow-left"></i>-->
                        คืน
                    </button>

                    <button class="btn btn-danger destroy-list2" data-id="<?= $row2["id"]."?".$row2["list"] ?>">
                        <!--                                                        <i class="fas fa-arrow-left"></i>-->
                        ทำลาย
                    </button>

                </td>
            </tr>
            <?php
        }
        mysqli_close($conn);
        ?>

        </tbody>
    </table>
</div>

<!--<script src="../vendor/datatables/jquery.dataTables.min.js"></script>-->
<!--<script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

    $('.form-check-input2').change(function () {
        // รวบรวมค่าของ checkboxes ที่ถูกเลือก
        var selectedValues = [];
        $('.form-check-input2:checked').each(function () {
            selectedValues.push($(this).val());
        });

        // อัปเดตข้อความและคลาสของปุ่ม withdraw-multilist
        console.log(selectedValues)
        if (selectedValues.length > 0) {
            if (selectedValues[0] === 'on') {
                $('.withdraw-multilist2')
                    .text('คืน  ' + (selectedValues.length - 1))
                    .removeClass('showButton2')
                    .val(selectedValues.join(','));
                $('.destroy-multilist2')
                    .text('ทำลาย ' + (selectedValues.length - 1))
                    .removeClass('showButton3')
                    .val(selectedValues.join(','));
            } else {
                $('.withdraw-multilist2')
                    .text('คืน' + (selectedValues.length) + 'รายการ')
                    .removeClass('showButton2')
                    .val(selectedValues.join(','));
                $('.destroy-multilist2')
                    .text('ทำลาย' + (selectedValues.length) + 'รายการ')
                    .removeClass('showButton3')
                    .val(selectedValues.join(','));
            }


        } else {
            $('.withdraw-multilist2')
                .text('เบิก 0 รายการ')
                .addClass('showButton2')
                .val('');

            $('.destroy-multilist2')
                .text('คืน 0 รายการ')
                .addClass('showButton3')
                .val('');
        }
    });

    $('#checkAll2').click(function () {
        if ($(this).prop('checked')) {
            // เลือกทุก checkbox ในตาราง
            $('.table tbody input[type="checkbox"]').prop('checked', true);
        } else {
            // ยกเลิกการเลือกทุก checkbox ในตาราง
            $('.table tbody input[type="checkbox"]').prop('checked', false);
        }
        $('.form-check-input2').change();
    });

    $('.withdraw-list2').on('click', async function (event,idFrom) {
        // let data = $('.withdraw-list').val()
        const clickedButton = $(this);
        var id
        if(idFrom === undefined){
             id = clickedButton.data('id');
        }else{
             id = idFrom
        }

        // Get the data-id attribute value

        let splittedSentence = id.split("?"); // ตัดประโยคด้วย "?"
        let idList = splittedSentence[0]; // เลือกประโยคที่ต้องการ
        let nameList = splittedSentence[1]; // เลือกประโยคที่ต้องการ console.log('Clicked button with id:', id);
        console.log(idList)
        var statusCheck
        const {value, isConfirmed} = await Swal.fire({
            title: "กรอกชื่อผู้คืนรายการและวันที่",
            html:
                `รายการ : ` + nameList +
                `<input id="swal-input1" class="swal2-input" placeholder="ชื่อผู้คืน" maxlength="255" autocapitalize="off" autocorrect="off">` +
                `<input id="swal-input2" class="swal2-input" type="date">`,
            showDenyButton: true,
            confirmButtonColor: "#17A673",
            confirmButtonText: "คืน",
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
                    url: "getdata/return_withdraw.php",
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
                    text: "กรุณากรอกชื่อและวันที่คืน",
                    icon: "warning",
                    confirmButtonText: "ตกลง",
                    confirmButtonColor: "#17A673"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('.withdraw-list2').trigger('click', [id]);
                    }
                });


            }
        } else {

        }
    });

    $('.withdraw-multilist2').click(async function () {
        var valueAttribute = $('.withdraw-multilist2').val();
        var valueArray = valueAttribute.split(',')
        if (valueArray[0] === 'on') {
            valueArray.splice(0, 1)
        } else {
        }
        console.log(valueArray);

        // alert(valueArray)
        var statusCheckMulti
        const {value, isConfirmed} = await Swal.fire({
            title: "กรอกชื่อผู้คืนรายการและวันที่",
            html:
                `รายการ : ` + valueArray +
                `<input id="swal-input1" class="swal2-input" placeholder="ชื่อผู้คืน" maxlength="255" autocapitalize="off" autocorrect="off">` +
                `<input id="swal-input2" class="swal2-input" type="date">`,
            showDenyButton: true,
            confirmButtonColor: "#17A673",
            confirmButtonText: "คืน",
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
                    url: "getdata/return_withdraw_Multi.php",
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
                    text: "กรุณากรอกชื่อและวันที่คืน",
                    icon: "warning",
                    confirmButtonText: "ตกลง",
                    confirmButtonColor: "#17A673"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('.withdraw-multilist2').click();
                    }
                });


            }
        } else {

        }
    });

    $('.destroy-multilist2').click(async function () {
        var valueAttribute = $('.destroy-multilist2').val();
        var valueArray = valueAttribute.split(',')
        if (valueArray[0] === 'on') {
            valueArray.splice(0, 1)
        } else {
        }
        console.log(valueArray);

        // alert(valueArray)
        var statusCheckMulti
        const {value, isConfirmed} = await Swal.fire({
            title: "กรอกชื่อผู้ทำลายรายการและวันที่",
            html:
                `รายการ : ` + valueArray +
                `<input id="swal-input1" class="swal2-input" placeholder="ชื่อผู้ทำลาย" maxlength="255" autocapitalize="off" autocorrect="off">` +
                `<input id="swal-input2" class="swal2-input" type="date">`,
            showDenyButton: true,
            confirmButtonColor: "red",
            confirmButtonText: "ทำลาย",
            denyButtonText: "ปิด",
            denyButtonColor: "gray",
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
                // Swal.fire(`Entered password: ${name}`+
                Swal.fire({
                    title: "ยืนยันการทำลายรายการ",
                    text: "กดตกลงเพื่อดำเนินการต่อ",
                    icon: "question",
                    showDenyButton: true,
                    denyButtonText: "ปิด",
                    confirmButtonText: "ตกลง",
                    confirmButtonColor: "#17A673",
                    allowOutsideClick: false,
                    showCloseButton: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "getdata/destroy_withdraw_Multi.php",
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
                    }
                })


            } else {
                Swal.fire({
                    title: "พบข้อผิดพลาด",
                    text: "กรุณากรอกชื่อและวันที่ทำลาย",
                    icon: "warning",
                    confirmButtonText: "ตกลง",
                    confirmButtonColor: "#17A673"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('.destroy-multilist2').click();
                    }
                });


            }
        } else {

        }
    });

    $('.destroy-list2').on('click', async function (event,idFrom) {
        // let data = $('.withdraw-list').val()
        const clickedButton = $(this);
        var id
        if(idFrom === undefined){
             id = clickedButton.data('id');
        }else{
             id = idFrom
        }

        let splittedSentence = id.split("?"); // ตัดประโยคด้วย "?"
        let idList = splittedSentence[0]; // เลือกประโยคที่ต้องการ
        let nameList = splittedSentence[1]; // เลือกประโยคที่ต้องการ console.log('Clicked button with id:', id);
        console.log(idList)
        var statusCheck
        const {value, isConfirmed} = await Swal.fire({
            title: "กรอกชื่อผู้ทำลายรายการและวันที่",
            html:
                `รายการ : ` + nameList +`                        `+
                `<input id="swal-input1" class="swal2-input" placeholder="ชื่อผู้ทำลาย" maxlength="255" autocapitalize="off" autocorrect="off">` +
                `<input id="swal-input2" class="swal2-input" type="date">`,
            showDenyButton: true,
            confirmButtonColor: "red",
            confirmButtonText: "ทำลาย",
            denyButtonText: "ปิด",
            denyButtonColor: "gray",
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
                Swal.fire({
                    title: "ยืนยันการทำลายรายการ",
                    text: "กดตกลงเพื่อดำเนินการต่อ",
                    icon: "question",
                    showDenyButton: true,
                    denyButtonText: "ปิด",
                    confirmButtonText: "ตกลง",
                    confirmButtonColor: "#17A673",
                    allowOutsideClick: false,
                    showCloseButton: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "getdata/destroy_list.php",
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
                    }
                });


            } else {
                Swal.fire({
                    title: "พบข้อผิดพลาด",
                    text: "กรุณากรอกชื่อและวันที่ทำลาย",
                    icon: "warning",
                    confirmButtonText: "ตกลง",
                    confirmButtonColor: "#17A673"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('.destroy-list2').trigger('click', [id]);
                    }
                });


            }
        } else {

        }
    });

    $('#dataTable2').DataTable();
</script>