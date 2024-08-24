<?php

include('connect.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--    <link href="./node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"-->
    <!--          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">-->
    <!--    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">-->
    <link href="node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="node_modules/chart.js/dist/chart.umd.js"></script>
    <script src="node_modules/jquery/dist/jquery.min.js"></script>
    <!--    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>-->
    <title>ECG Monitor</title>
    <style>
        .grid-container {
            display: grid;
            grid-template-columns: repeat(4, 1fr); /* 4 columns */
            grid-auto-rows: auto;
            gap: 0; /* No gap between charts */
        }

        .chart-container canvas {
            width: 15px;
            height: 15px;
        }

        .chart-container {
            position: relative;
            /*border: 1px dotted black;*/
            border: 1px solid black;
        }

        .chart-container .label-text {
            position: absolute;
            top: 0;
            left: 0;
        }

        #grad1 {
            background-color: black; /* For browsers that do not support gradients */
            background-image: linear-gradient(black, #EF603E);
        }

        @import url("https://fonts.googleapis.com/css?family=Montserrat:400,400i,700");

        /*

        Battery indicator - HTML & CSS only. Fully scalable.
        To change, edit only "--width" parametr in class ==> ".battery-icon_wrapper".

        */
        .graphic-wrapper {
            display: flex;
            gap: 20px 10px;
            justify-content: center;
            flex-wrap: wrap;
            transform: rotate(90deg);
            margin-right: 30px ;
        }
        /* ==== START ==== */
        .battery-icon_wrapper {
            --bg-color: hotpink;
            --width: 20px; /* <==== change to scale all  */
            --gap: calc(var(--width) / 15);
            --border-r: calc(var(--width) / 22.5);

            width: var(--width);
            aspect-ratio: 0.55;
            border: var(--gap) solid var(--bg-color);
            border-radius: var(--border-r);
            padding: var(--gap);
            display: grid;
            grid-template-row: repeat(5, 1fr);
            gap: var(--gap);
            position: relative;
        }
        .battery-icon_wrapper:before {
            content: "";
            position: absolute;
            background: var(--bg-color);
            border-radius: var(--border-r);
            width: calc(var(--width) / 2);
            aspect-ratio: 3;
            top: calc((var(--width) / 6) * -1);
            left: 50%;
            transform: translateX(-50%);
        }
        .battery-icon_ind {
            background: transparent;
        }
        .lvl1 {
            height: 5vh;
            --bg-color: #df0012;
        }
        .lvl2 {
            --bg-color: #fb6100;
        }
        .lvl3 {
            --bg-color: #fbb103;
        }
        .lvl4 {
            --bg-color: #8ac419;
        }
        .lvl5 {
            --bg-color: #51af27;
        }

        .battery-icon_wrapper.lvl1 .battery-icon_ind:nth-child(n + 5) {
            background: var(--bg-color);
        }
        .battery-icon_wrapper.lvl2 .battery-icon_ind:nth-child(n + 4) {
            background: var(--bg-color);
        }
        .battery-icon_wrapper.lvl3 .battery-icon_ind:nth-child(n + 3) {
            background: var(--bg-color);
        }
        .battery-icon_wrapper.lvl4 .battery-icon_ind:nth-child(n + 2) {
            background: var(--bg-color);
        }
        .battery-icon_wrapper.lvl5 .battery-icon_ind:nth-child(n + 1) {
            background: var(--bg-color);
        }

        /* ==== END ==== */

        .procent-wrapper {
            margin-top: 50px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
        }

        .procent-wrapper p {
            display: flex;
            align-items: center;
            position: relative;
        }
        p:before {
            content: "";
            position: absolute;
            width: 10px;
            height: 10px;
            left: -15px;
        }
        p.lvl1:before,
        p.lvl2:before,
        p.lvl3:before,
        p.lvl4:before,
        p.lvl5:before {
            background: var(--bg-color);
        }
    </style>
</head>
<body>
<div class="card" id="grad1">
    <div class="card-header d-flex justify-content-between">
        <div><span class="text-light">BME KMUTNB X LEARDSIN @OPD</span></div>
        <div class="d-flex align-items-center ">
            <span style="margin-right: 20px;color: white" >monitor</span>
            <div class="graphic-wrapper" id="batt-show">
            </div>
            <span style="margin-right: 20px;color: white">pocket</span>
            <div class="graphic-wrapper" id="batt-lead">
            </div>
        </div>
    </div>
    <div class="card-body" style="height: fit-content;">
        <div class="d-flex justify-content-center mb-2">
            <span class="text-light">SMART ECG MONITORING</span>
        </div>
        <div class="container" style="background-color: #332B28">
            <div class="row">
                <div class="chart-container col selectChart1" id="lead1"></div>
                <div class="chart-container col selectChart2" id="avr">
                </div>
<!--                <div class="chart-container col" id="v1">-->
<!--                </div>-->
<!--                <div class="chart-container col" id="v4">-->
<!--                </div>-->
            </div>
            <div class="row">
                <div class="chart-container col-3 selectChart3" id="lead2">
                </div>
                <div class="chart-container col-3 selectChart4" id="avl">
                </div>
<!--                <div class="chart-container col" id="v2">-->
<!--                </div>-->
<!--                <div class="chart-container col" id="v5">-->
<!--                </div>-->
            </div>
            <div class="row">
                <div class="chart-container col selectChart5" id="lead3">
                </div>
                <div class="chart-container col selectChart6" id="avf">
                </div>
<!--                <div class="chart-container col" id="v3">-->
<!--                </div>-->
<!--                <div class="chart-container col" id="v6">-->
<!--                </div>-->
            </div>
            <div class="row">
                <div class="chart-container col" id="11">
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

<!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"-->
<!--        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"-->
<!--        crossorigin="anonymous"></script>-->
<!--<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>-->

<!--<script-->
<!--        src="https://code.jquery.com/jquery-3.7.1.min.js"-->
<!--        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="-->
<!--        crossorigin="anonymous"></script>-->
<script>

    $.ajax({
        url: "/chartData/lead1.php",
        data: {},
        success: function (result) {
            $("#lead1").html(result);
        }
    });

    $.ajax({
        url: "/data/batt.php",
        data: {},
        success: function (result) {
            $("#batt-show").html(result);
        }
    });

    $.ajax({
        url: "/data/battLead.php",
        data: {},
        success: function (result) {
            $("#batt-lead").html(result);
        }
    });

    function updateChart_batt() {
        $.ajax({
            url: "/data/batt.php",
            data: {},
            success: function (result) {
                $("#batt-show").html(result);
            }
        });
        $.ajax({
            url: "/data/battLead.php",
            data: {},
            success: function (result) {
                $("#batt-lead").html(result);
            }
        });
    }

    setInterval(updateChart_batt, 5000);

    $.ajax({
        url: "/chartData/avr.php",
        data: {},
        success: function (result) {
            $("#avr").html(result);
        }
    });

    $.ajax({
        url: "/chartData/v1.php",
        data: {},
        success: function (result) {
            $("#v1").html(result);
        }
    });

    $.ajax({
        url: "/chartData/v4.php",
        data: {},
        success: function (result) {
            $("#v4").html(result);
        }
    });

    $.ajax({
        url: "/chartData/lead2.php",
        data: {},
        success: function (result) {
            $("#lead2").html(result);
        }
    });

    $.ajax({
        url: "/chartData/avl.php",
        data: {},
        success: function (result) {
            $("#avl").html(result);
        }
    });

    $.ajax({
        url: "/chartData/v2.php",
        data: {},
        success: function (result) {
            $("#v2").html(result);
        }
    });

    $.ajax({
        url: "/chartData/v5.php",
        data: {},
        success: function (result) {
            $("#v5").html(result);
        }
    });

    $.ajax({
        url: "/chartData/lead3.php",
        data: {},
        success: function (result) {
            $("#lead3").html(result);
        }
    });

    $.ajax({
        url: "/chartData/avf.php",
        data: {},
        success: function (result) {
            $("#avf").html(result);
        }
    });

    $.ajax({
        url: "/chartData/v3.php",
        data: {},
        success: function (result) {
            $("#v3").html(result);
        }
    });

    $.ajax({
        url: "/chartData/v6.php",
        data: {},
        success: function (result) {
            $("#v6").html(result);
        }
    });

    $.ajax({
        url: "/chartData/select.php",
        method: "POST",
        data: {
            case: '11'
        },
        success: function (result) {
            $("#11").html(result);
        }
    });


    const borLineColor = '#BD242A'


    let updateInterval_select;
    let myChart_select;
    let selectData
    let updateIntervalSeconds_select
    let ctx13

    $(".selectChart1").on("click", function (event) {
        $.ajax({
            url: "/chartData/select.php",
            method: "POST",
            data: {
                case: 'lead1'
            },
            success: function (result) {
                $("#11").html(result);
            }
        });
    });

    $(".selectChart2").on("click", function (event) {
        $.ajax({
            url: "/chartData/select.php",
            method: "POST",
            data: {
                case: 'avr'
            },
            success: function (result) {
                $("#11").html(result);
            }
        });
    });

    $(".selectChart3").on("click", function (event) {
        $.ajax({
            url: "/chartData/select.php",
            method: "POST",
            data: {
                case: 'lead2'
            },
            success: function (result) {
                $("#11").html(result);
            }
        });
    });

    $(".selectChart4").on("click", function (event) {
        $.ajax({
            url: "/chartData/select.php",
            method: "POST",
            data: {
                case: 'avl'
            },
            success: function (result) {
                $("#11").html(result);
            }
        });
    });

    $(".selectChart5").on("click", function (event) {
        // alert('LEAD III')
        $.ajax({
            url: "/chartData/select.php",
            method: "POST",
            data: {
                case: 'lead3'
            },
            success: function (result) {
                // console.log(result)
                $("#11").html(result);
            }
        });
    });

    $(".selectChart6").on("click", function (event) {
        $.ajax({
            url: "/chartData/select.php",
            method: "POST",
            data: {
                case: 'avf'
            },
            success: function (result) {
                $("#11").html(result);
            }
        });
    });

</script>
