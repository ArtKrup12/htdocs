<?php

session_start();
if (!isset($_SESSION['user_login'])) {
    header("Location: login");
    exit();
}

include("layout/head.php"); ?>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed text-sm" style="overflow-y: hidden">
<!--<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed text-sm" >-->
<div class="wrapper">
    <?php include("layout/navbar.php"); ?>
    <?php include("layout/menu_l.php"); ?>
    <div class="content-wrapper" id="main-stage">
        <?php include('layout/footer.php'); ?>
        <script>
            $(document).ready(function () {
                let table
              let onPage =  localStorage.getItem('page')
                if (onPage){
                    // Swal.fire({
                    //     title: 'กำลังโหลดข้อมูล...',
                    //     text: 'กรุณารอสักครู่...',
                    //     allowOutsideClick: false,
                    //     showConfirmButton: false,
                    //     didOpen: () => {
                    //         Swal.showLoading();
                    //     }
                    // })
                    $.ajax({
                        url: `pages/emp/${onPage}.php`,
                        method: 'POST',
                        success: function (response) {
                            $('#main-stage').html(response);

                            setTimeout(function () {
                                Swal.close()
                            }, 500)

                            $(`.select-menu .nav-link`).removeClass('active').css({
                                'background-color': 'transparent',
                                'color': 'white'
                            });

                            $(`.select-menu[data-id='${onPage}'] .nav-link`).addClass('active').css({
                                'background-color': '#9B111E',
                                'color': 'white'
                            });
                        },
                        error: function (xhr, status, error) {
                            console.error("Error loading content: " + status + " " + error);
                        }
                    });
                }else{
                    // Swal.fire({
                    //     title: 'กำลังโหลดข้อมูล...',
                    //     text: 'กรุณารอสักครู่...',
                    //     allowOutsideClick: false,
                    //     showConfirmButton: false,
                    //     didOpen: () => {
                    //         Swal.showLoading();
                    //     }
                    // })
                    $.ajax({
                        url: 'pages/emp/dashboard.php',
                        method: 'POST',
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
                }

            });

            // $('.tab_search').click(function () {
            //     Swal.fire({
            //         title: 'กำลังโหลดข้อมูล...',
            //         text: 'กรุณารอสักครู่...',
            //         allowOutsideClick: false,
            //         showConfirmButton: false,
            //         didOpen: () => {
            //             Swal.showLoading();
            //         }
            //     })
            //     let slectTab = $(this).attr('id')
            //     console.log(slectTab)
            //     $.ajax({
            //         url: `component/emp/table_dashboard.php`,
            //         method: 'POST',
            //         data: {
            //             case: slectTab
            //         },
            //         success: function (data) {
            //             $('#show-list').html(data)
            //             setTimeout(function () {
            //                 Swal.close()
            //             }, 500);
            //
            //             table = $("#table_dashboard_emp").DataTable({
            //                 searching: true,
            //                 responsive: true,
            //                 pageLength: 5
            //             });
            //         }
            //     });
            // })

            $('.select-menu').click(function () {
                // Swal.fire({
                //     title: 'กำลังโหลดข้อมูล...',
                //     text: 'กรุณารอสักครู่...',
                //     allowOutsideClick: false,
                //     showConfirmButton: false,
                //     didOpen: () => {
                //         Swal.showLoading();
                //     }
                // })
                let menuId = $(this).data('id');
                localStorage.setItem('page',menuId)
                $('.nav-link').removeClass('active').css({
                    'background-color': 'transparent',
                    'color': 'white'
                });

                $(this).find('.nav-link').addClass('active').css({
                    'background-color': '#9B111E',
                    'color': 'white'
                });

                if(menuId === 'dashboard'){
                    location.reload()

                }else {
                    $.ajax({
                        url: `pages/emp/${menuId}.php`,
                        method: 'POST',
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
                }

                // console.log('Clicked menu with ID:', menuId);
            })
        </script>

