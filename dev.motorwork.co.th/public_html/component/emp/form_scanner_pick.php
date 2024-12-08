<div class="row pl-0">
    <div class="form-group col-md-12 col-xs-12">
        <label for="product name">สแกนบาร์โค้ด</label>
        <div class="input-group">
            <input type="text" id="barcode" name="barcode"
                   class="form-control search_bar"
                   placeholder="สแกน/ป้อนบาร์โค้ด" aria-label="Search"
                   aria-describedby="button-search" autocomplete="off">
            <button class="btn btn-primary"
                    style="background-color: #9b111e; border-color: #961011;border-bottom-left-radius: 0;border-top-left-radius: 0;"
                    type="button" id="manualSubmit">
                <i class="fa fa-search"></i>
            </button>
        </div>
    </div>
    <div class="form-group col-md-4 col-xs-12 mb-1 pb-1">
        <label for="product name">รหัสสินค้า : <span id="prod_code"></span> </label>
                                                            <input type="hidden" class="form-control" id="product_code"
                                                                   name="product_code"
                                                                   placeholder="" value=""
                                                                   disabled>

    </div>
    <div class="form-group col-md-4 col-xs-12 mb-1 pb-1">
        <label for="product name">ชื่อสินค้า : <span id="product_name"></span></label>
                                                            <input type="hidden" class="form-control" id="prod_name"
                                                                   name="product_name"
                                                                   placeholder="" value=""
                                                                   disabled>
    </div>
    <div class="form-group col-md-4 col-xs-12 mb-1 pb-1">
        <label for="product location">ตำแหน่ง : <span id="ware_house"></span></label>
                                                            <input type="hidden" class="form-control" id="location_pro"
                                                                   name="ware_house"
                                                                   placeholder="" value=""
                                                                   >
    </div>
</div>
<div class="card">
    <div class=" card-header  py-3">
        <div class="row col-12 d-flex justify-content-center">
            <span><b>จำนวนอะไหล่</b></span>
        </div>
    </div>
    <div class="card-body">
        <div class="row pl-0 p-1">
            <div class="form-group col-md-4 col-xs-6 col-6">
                                                            <span class="mb-2"
                                                                  style="display: block; text-align: right; font-weight: bold;">ต้องนับ</span>
                <input type="text" class="form-control text-end  input-lg"
                       id="product_qty"
                       name="product_qty"
                       placeholder="0" style="font-size:30px"
                       value="" disabled>

            </div>
            <div class="form-group col-md-4 col-xs-6 col-6">
                                                            <span class="mb-2"
                                                                  style="display: block; text-align: right; font-weight: bold;">นับได้</span>
                <input type="number" class="form-control  input-lg"
                       id="product_count"
                       name="product_count"
                       placeholder="0" style="color:blue;font-size:30px"
                       value="" required autocomplete="off">
            </div>
        </div>
    </div>

</div>

<div class="row pl-2 pt-3 d-flex justify-content-end">


    <button class="btn btn-primary  btn-sm clear_form mr-2 d-flex align-items-center justify-content-center"
            type="button" disabled
            style="background-color: #696969; border-color: #696969"
    >
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
             viewBox="0 0 24 24" class="me-1">
            <path fill="white"
                  d="M17.65 6.35a7.95 7.95 0 0 0-6.48-2.31c-3.67.37-6.69 3.35-7.1 7.02C3.52 15.91 7.27 20 12 20a7.98 7.98 0 0 0 7.21-4.56c.32-.67-.16-1.44-.9-1.44c-.37 0-.72.2-.88.53a5.994 5.994 0 0 1-6.8 3.31c-2.22-.49-4.01-2.3-4.48-4.52A6.002 6.002 0 0 1 12 6c1.66 0 3.14.69 4.22 1.78l-1.51 1.51c-.63.63-.19 1.71.7 1.71H19c.55 0 1-.45 1-1V6.41c0-.89-1.08-1.34-1.71-.71z"/>
        </svg>
        <span style="font-size: 16px">เคลียร์</span>
    </button>
    <button class="btn btn-primary btn-sm save_scan d-flex align-items-center justify-content-center"
            type="button" disabled
            style="background-color: #9b111e; border-color: #961011"
    >
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
             viewBox="0 0 24 24" class="me-1">
            <path fill="white"
                  d="M17 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14c1.1 0 2-.9 2-2V7zm2 16H5V5h11.17L19 7.83zm-7-7c-1.66 0-3 1.34-3 3s1.34 3 3 3s3-1.34 3-3s-1.34-3-3-3M6 6h9v4H6z"/>
        </svg>
        <span style="font-size: 16px">บันทึก</span>
    </button>

</div>

<script>
    // ฟังก์ชันสำหรับส่งข้อมูล POST
    function sendPostRequest(url, data, onSuccess) {
        $.ajax({
            url: url,
            method: 'POST',
            data: data,
            cache: false,
            success: function (response) {
                const res = JSON.parse(response);
                onSuccess(res);
            }
        });
    }

    function resetScannerForm() {

        let soNo = $('#so_no').val();
        let assignNo = $('#assign_no').val();
        $.ajax({
            url: 'pages/emp/manage_pick.php',
            method: 'POST',
            data: {
                soNo,
                assignNo
            },
            success: function (response) {
                $('#main-stage').html(response);


                // const startTime = $('#start_dt').val();
                // let startDate = Date.parse(startTime) ? new Date(startTime) : null;
                // initializeTimer(startDate);


                // $.ajax({
                //     url: 'component/emp/form_scanner_pick.php',
                //     method: 'POST',
                //     success: function (data) {
                //         $('#form_scan').html(data);
                //     }
                // });
            }
        });
        // $('.refresh_page').click() ;
        // $.ajax({
        //     url: 'component/emp/form_scanner_pick.php', // ใช้ URL เดิมเพื่อตั้งค่า UI
        //     method: 'POST',
        //     success: function (data) {
        //         $('#form_scan').html(data);
        //         $('#prod_code').text(''); // ล้างค่า
        //         $('#product_name').text(''); // ล้างค่า
        //         $('#ware_house').text(''); // ล้างค่า
        //         $('#product_qty').val(''); // ล้างค่า
        //         $('#product_count').val(''); // ล้างค่า
        //         // $('.scan_barcode').css('display', ''); // แสดงปุ่มหรือองค์ประกอบที่เกี่ยวข้อง
        //         setTimeout(() => {
        //             $('#barcode').focus(); // ตั้งโฟกัสกลับที่ input
        //         }, 100);
        //     }
        // });
    }

    // ฟังก์ชันสำหรับการอัพเดท UI
    function updateScannerForm(data_p_code, data_p_name, data_p_qty, data_p_count, data_p_location) {
        $.ajax({
            url: 'component/emp/form_scanner_pick.php',
            method: 'POST',
            success: function (data) {
                $('#form_scan').html(data);
                $('#prod_code').text(data_p_code);
                $('#product_code').val(data_p_code);
                $('#product_name').text(data_p_name);
                $('#prod_name').text(data_p_name);
                $('#ware_house').text(data_p_location);
                $('#location_pro').val(data_p_location);
                $('#product_qty').val(data_p_qty);
                $('#product_count').val(data_p_count);
                $('.save_scan').prop('disabled', false);
                $('.clear_form').prop('disabled', false);
                setTimeout(() => {
                    $('#barcode').focus();
                }, 100);

                $('.scan_barcode').css('display', 'none');
            }
        });
    }

    // ฟังก์ชันหลักที่ใช้ในหลายจุด
    function handleBarcodeScan(barcode, so_id, assign_id, warehouse) {
        sendPostRequest('controller/emp/post_scan_pick.php', {
            action: 'count_scanner',
            barcode: barcode,
            so_id: so_id,
            assign_id: assign_id,
            ware_house: warehouse
        }, function (res_data) {
            if (res_data.status === 'no' || !res_data.data) {
                // ถ้าไม่มีข้อมูลหรือเกิดข้อผิดพลาด ให้รีเซ็ตฟอร์ม
                resetScannerForm();
            } else {

                if(res_data.isCheckScanOver == 'over'){
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        }
                    });
                    Toast.fire({
                        icon: 'error',
                        title: 'จำนวนที่นับได้มากกว่าจำนวนที่ต้องการ กรุณานับใหม่!'
                    });
                }

                const data_p_code = res_data.data.p_code;
                const data_p_name = res_data.data.p_name;
                const data_p_qty = res_data.data.prod_qty;
                const data_p_count = res_data.lastQty || 1;
                const data_p_location = warehouse;

                updateScannerForm(data_p_code, data_p_name, data_p_qty, data_p_count, data_p_location);
            }
        });
    }

    // ฟังก์ชันสำหรับเลือกสถานที่จาก Swal
    async function selectWarehouseFromSwal(listData, barcode, so_id, assign_id) {
        const inputOptions = listData.reduce((acc, value) => {
            acc[value] = value;
            return acc;
        }, {});

        const result = await Swal.fire({
            title: "กรุณาเลือกสถานที่ของสินค้า",
            input: "select",
            inputOptions: inputOptions,
            inputPlaceholder: "--กรุณาเลือก--",
            showCancelButton: true,
            allowOutsideClick: false,
            confirmButtonText: "เลือก",
            cancelButtonText: "ยกเลิก",
            confirmButtonColor: "#00A65A",
            cancelButtonColor: "#808080",
            inputValidator: (value) => {
                return new Promise((resolve) => {
                    if (!value) {
                        Swal.fire({
                            icon: "error",
                            title: "กรุณาเลือกสถานที่!",
                            timer: 3000,
                            showConfirmButton: false
                        });
                    } else {
                        resolve();
                    }
                });
            }
        });

        if (result.isConfirmed && result.value) {
            localStorage.setItem('selectWarehouse', result.value);
            handleBarcodeScan(barcode, so_id, assign_id, result.value);
        }
    }

    $(document).ready(function () {
        $('#barcode').focus();
        $('#product_count').on('keyup',function (){
            let so_no = $('#so_no').val();
            let assign_no = $('#assign_no').val();
            let prod_code = $('#product_code').val();
            let ware_house = $('#location_pro').val();
            let val = $('#product_count').val()
            val = val.trim() === '' ? '0' : val;
            if(val){
                console.log(val)
                $.ajax({
                    url: 'controller/emp/post_scan_pick.php',
                    method: 'POST',
                    data: {
                        action:"update_temp_count",
                        so_id: so_no,
                        assign_id: assign_no,
                        prod_code,
                        ware_house,
                        val
                    },
                    success: function (data) {}
                });
            }
        })

        let $barcodeInput = $('#barcode');
        let lastInputTime = 0;
        let inputIntervalThreshold = 30;
        let isPasted = false;
        let minBarcodeLength = 13;

        $barcodeInput.on('input', function () {
            let currentTime = new Date().getTime();
            let timeDiff = currentTime - lastInputTime;

            if (lastInputTime === 0 || (!isPasted && timeDiff < inputIntervalThreshold)) {
                if ($barcodeInput.val().length >= minBarcodeLength) {
                    let bar_data = $barcodeInput.val().trim()
                    let so_no = $('#so_no').val();
                    let assign_no = $('#assign_no').val();
                    let wareHouseData = localStorage.getItem('selectWarehouse');

                    // if (wareHouseData) {
                    //     handleBarcodeScan(bar_data, so_no, assign_no, wareHouseData);
                    // } else {
                        sendPostRequest('controller/emp/getLocationProduct.php', {
                            barcode: bar_data,
                            so_id: so_no,
                            assign_id: assign_no
                        }, function (res_check) {
                            if (res_check.status === '1') {
                                console.log('เข้าเงื่อนไข คลังเดียว');
                                handleBarcodeScan(bar_data, so_no, assign_no, res_check.listData[0]);
                            } else if (res_check.status === 'success') {
                                console.log('เข้าเงื่อนไข มีหลายคลัง');
                                selectWarehouseFromSwal(res_check.listData, bar_data, so_no, assign_no);
                            }
                        });
                    // }
                    lastInputTime = currentTime;
                    isPasted = false;
                }
            }
        });

        $(document).on('paste', '#barcode', function () {
            isPasted = true;
        });

        $('.clear_form').on('click', function () {
            resetScannerForm()
        })

        $('.save_scan').on('click', async function () {
            let saleId = $('#so_no').val();
            let assignId = $('#assign_no').val();
            let productCode = $('#product_code').val();
            let productName = $('#prod_name').val();
            let wareHouse = $('#location_pro').val();
            let product_qty = $('#product_qty').val();
            let product_count = $('#product_count').val();

            if ((product_qty - product_count) === 0) {
                Swal.fire({
                    title: "ยืนยันการบันทึก?",
                    text: "คุณต้องการบันทึกข้อมูลนี้ใช่หรือไม่!",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#00A65A",
                    allowOutsideClick: false,
                    cancelButtonColor: "#808080",
                    confirmButtonText: "บันทึก",
                    cancelButtonText: "ย้อนกลับ"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // save condition Y
                        $.ajax({
                            url: 'controller/emp/post_scan_pick.php',
                            method: 'POST',
                            data: {
                                action:"save_list_so_detail",
                                so_id: saleId,
                                assign_no: assignId,
                                prod_id: productCode,
                                prod_location: wareHouse,
                                count_scan: product_count,
                                sub_action: 'Y'

                            },
                            success: function (data) {
                                // let res_data = JSON.parse(data)

                                // if(res_data.status === 200){
                                //     console.log('update success')
                                // }else{
                                //     console.log('update field')
                                // }
                                localStorage.removeItem('selectWarehouse')
                                resetScannerForm()

                               // reload
                            }
                        });
                    } else {
                        resetScannerForm()
                    }
                });
            } else if ((product_qty - product_count) > 0) {
                console.log('else if <')
                const {value: formValues} = await Swal.fire({
                    title: "บันทึกหมายเหตุ",
                    confirmButtonColor: "#00A65A",
                    cancelButtonColor: "#808080",
                    confirmButtonText: "บันทึก",
                    cancelButtonText: "ย้อนกลับ",
                    allowOutsideClick: false,
                    html:
                        `
<!--                        <label style="float: right;" for="remarkSelect">ประเภท remark: </label>-->
                         <select style="width: 100%;font-size: large;border-radius: 10px"  id="remarkSelect" class="swal2-input">
                               <option disabled selected>กรุณาเลือกประเภทหมายเหตุ</option>
                              <option value="1">สินค้าชำรุด</option>
                              <option value="2">หาสินค้าไม่เจอ</option>
                              <option value="3">สินค้าไม่มีในสต</option>
                              <option value="4">ทำงานไม่ทัน</option>
                              <option value="5">ขอสลับหน้าที่</option>
                              <option value="6">ลาป่วย/ลากิจ</option>
                              <option value="7">อื่นๆ</option>
                         </select>
                        <br>
                         <label style="float: left;margin-top: 12px;font-size: 20px" for="remarkText" >คำอธิบาย</label>
                            <br>
                         <textarea style="margin-top: 0px;width: 70%;font-size: large" id="remarkText" class="swal2-textarea" placeholder=""></textarea>`,
                    showCancelButton: true,
                    preConfirm: () => {
                        const selectedOption = document.getElementById("remarkSelect").value;
                        const text = document.getElementById("remarkText").value;
                        // console.log(text)
                        if (selectedOption === 'กรุณาเลือกประเภทหมายเหตุ') {
                            Swal.showValidationMessage("กรุณาเลือกประเภทหมายเหตุ");
                            return false;
                        }
                        if (!text) {
                            Swal.showValidationMessage("กรุณาป้อนคำอธิบาย");
                            return false;
                        }
                        return {selectedOption, text};
                    }
                });
                if (formValues) {
                    const {selectedOption, text} = formValues;
                    // Swal.fire(`You selected: ${selectedOption}`, `Your message: ${text}`);
                    let remark_type = selectedOption
                    let remark_text = text
                    $.ajax({
                        url: 'controller/emp/post_scan_pick.php',
                        method: 'POST',
                        data: {
                            action:"save_list_so_detail",
                            so_id: saleId,
                            assign_no: assignId,
                            prod_id: productCode,
                            prod_location: wareHouse,
                            count_scan: product_count,
                            remark_type,
                            remark_text,
                            sub_action: 'N'

                        },
                        success: function (data) {
                            localStorage.removeItem('selectWarehouse')
                            resetScannerForm()
                        }
                    });
                    // $.ajax({
                    //     url: 'api/pick_scanner/saveScan.php',
                    //     method: 'POST',
                    //     data: {
                    //         so_id: saleId,
                    //         assign_no: assignId,
                    //         prod_id: productCode,
                    //         prod_location: wareHouse,
                    //         count_scan: productCount,
                    //         type_assign: 'pick',
                    //         remark_type,
                    //         remark_text,
                    //         case: 'N'
                    //
                    //     },
                    //     success: function (data) {
                    //         // let res_data = JSON.parse(data)
                    //         // if(res_data.status === 200){
                    //         //     console.log('update success N')
                    //         // }else{
                    //         //     console.log('update field')
                    //         // }
                    //         localStorage.removeItem('selectWarehouse')
                    //         reloadFrom(productCode, productName, wareHouse, productQty, productCount)
                    //         checkLastList('no_show')
                    //     }
                    // });
                } else {
                    resetScannerForm()
                    // reloadFromEdit(productCode, productName, wareHouse, productQty, productCount)
                }
            } else {
                Swal.fire({
                    title: "พบข้อผิดพลาด?",
                    text: "จำนวนที่นับได้มากกว่าจำนวนที่ต้องการ กรุณานับใหม่",
                    icon: "error",
                    // showCancelButton: true,
                    confirmButtonColor: "#808080",
                    allowOutsideClick: false,
                    // cancelButtonColor: "#808080",
                    confirmButtonText: "ปิด",
                    // cancelButtonText: "ย้อนกลับ"
                }).then((result) => {
                    if (result.isConfirmed) {
                        console.log('ยืนยันการบันทึก จำนวนสินค้ามากเกิน')
                        $('.scan_barcode').css('display', 'none');
                        resetScannerForm()
                        // $('#form_scan').click();
                        // updateScannerForm(productCode, data_p_name, data_p_qty, data_p_count, data_p_location);
                        // rloadFromEdit(productCode, productName, wareHouse, productQty, productCount)
                    } else {
                        $('.scan_barcode').css('display', 'none');
                        resetScannerForm()
                        // reloadFromEdit(productCode, productName, wareHouse, productQty, productCount)
                    }
                });
            }
        })
    });

</script>