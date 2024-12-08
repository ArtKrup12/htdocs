<?php
session_start();
include "config.php";
include "datethai.php";
$sale_detail_id = $_REQUEST['sale_detail_id'];
//$statusQ = $_GET['statusQ'];
//$alert = $_GET['alert'];
$member_type = $_SESSION['member_type'];
$member_id = $_SESSION['Member_IdLogin'];

?>


<style>
    .form-control:focus {
        border-color: #9b111e;
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
    }
</style>
<input type="hidden" id="sale_id_get" value="<?php echo $_POST['soNO']; ?>">
<input type="hidden" id="assign_id_get" value="<?php echo $_POST['assignNo']; ?>">
<!--        <section class="content-header">-->
<!--            <h1> ข้อมูลแพ็คสินค้า <small></small></h1>-->
<!--            <button class="btn refresh_sub_page">รีเฟรช</button>-->
<!--        </section>-->

<section class="content">
    <div class="row col-12">
        <div class="card card-success card-outline card-header-bg direct-chat direct-chat-success col-12 mt-2"
             style="overflow: auto; height: calc(100vh - 110px);">
            <div class="card-header sticky-header d-flex justify-content-between p-1 m-1">
                <div class="w-75 d-flex justify-content-start align-items-center">
                    <button class="btn btn-sm p-0 m-0 px-2 back_to_mng_pick" style="background-color:#9B111E ">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="24" viewBox="0 0 12 24">
                            <path fill="white" fill-rule="evenodd"
                                  d="m3.343 12l7.071 7.071L9 20.485l-7.778-7.778a1 1 0 0 1 0-1.414L9 3.515l1.414 1.414z"/>
                        </svg>
                    </button>
                    <button class="btn btn-sm p-0 m-0 px-2  ml-2 refresh_sub_page" style="background-color:#9B111E ">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <g fill="white" fill-rule="evenodd" clip-rule="evenodd">
                                <path d="M6.64 9.788a.75.75 0 0 1 .53.918a5 5 0 0 0 7.33 5.624a.75.75 0 1 1 .75 1.3a6.501 6.501 0 0 1-9.529-7.312a.75.75 0 0 1 .919-.53M8.75 6.37a6.5 6.5 0 0 1 9.529 7.312a.75.75 0 1 1-1.45-.388A5.001 5.001 0 0 0 9.5 7.67a.75.75 0 1 1-.75-1.3"/>
                                <path d="M5.72 9.47a.75.75 0 0 1 1.06 0l2.5 2.5a.75.75 0 1 1-1.06 1.06l-1.97-1.97l-1.97 1.97a.75.75 0 0 1-1.06-1.06zm9 1.5a.75.75 0 0 1 1.06 0l1.97 1.97l1.97-1.97a.75.75 0 1 1 1.06 1.06l-2.5 2.5a.75.75 0 0 1-1.06 0l-2.5-2.5a.75.75 0 0 1 0-1.06"/>
                            </g>
                        </svg>
                    </button>
                    <h2 class="card-title pl-2">รายละเอียดรายการ</h2>
                </div>
                <div class="w-25 d-flex justify-content-end align-items-center">
                    <button class="btn btn-sm p-0 m-0 refresh_sub_page" style="background-color:#9B111E ">
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
                <div class="col-md-12">
                    <form id="barcodeForm">
                    </form>
                </div>
            </div>
        </div>

    </div>
</section>

<script>
    $(document).ready(function () {

        let sale_id_get = $('#sale_id_get').val()
        let assign_id_get = $('#assign_id_get').val()

        $('.refresh_sub_page').click(function () {
            let soNO = $('#sale_id_get').val()
            let assignNo = $('#assign_id_get').val()
            $.ajax({
                url: `pages/emp/scanner_pick.php`,
                method: 'POST',
                data: {
                    soNO,
                    assignNo
                },
                success: function (response) {
                    $('#main-stage').html(response);
                },
                error: function (xhr, status, error) {
                    console.error("Error loading content: " + status + " " + error);
                }
            });
        })

        $('.back_to_mng_pick').click(function () {
            $.ajax({
                url: 'pages/emp/manage_pick.php',
                method: 'POST',
                data:{
                    soNo:sale_id_get,
                    assignNo:assign_id_get
                },
                success: function (response) {
                    $('#main-stage').html(response);
                },
                error: function (xhr, status, error) {
                    console.error("Error loading content: " + status + " " + error);
                }
            });
        })

        // $.ajax({
        //     url: `api/pick_scanner/pagination.php`,
        //     method: 'POST',
        //     data: {carton:1},
        //     success: function (data) {
        //         $('#show_pagination').html(data)
        //     }
        // });

        $.ajax({
            url: 'component/emp/form_scanner_pick.php',
            method: 'POST',
            data: {
                so_id: sale_id_get,
                assign_id: assign_id_get
            },
            success: function (data) {
                $('#barcodeForm').html(data)
                $('#barcode').focus();
            }
        });


    })
</script>

