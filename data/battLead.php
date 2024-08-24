<?php include('../connect.php');

$sql = "SELECT * FROM battery";
$result = $conn->query($sql);
$id = array();
$values = array();
$row = mysqli_fetch_object($result);
//while ($row = ) {
//    array_push($id, $row['percent_sersor']);
//    array_push($values, $row['percent_monitor']);
//}
//$data = array(
//    "monitor" => $id,
//    "lead" => $values
//);
if ($row->percent_sersor >= 80) { ?>
    <div class="battery-icon_wrapper lvl5">
        <div class="battery-icon_ind"></div>
        <div class="battery-icon_ind"></div>
        <div class="battery-icon_ind"></div>
        <div class="battery-icon_ind"></div>
        <div class="battery-icon_ind"></div>
    </div>

<?php } else if ($row->percent_sersor >= 60 && $row->percent_sersor <= 79) { ?>

    <div class="battery-icon_wrapper lvl4">
        <div class="battery-icon_ind"></div>
        <div class="battery-icon_ind"></div>
        <div class="battery-icon_ind"></div>
        <div class="battery-icon_ind"></div>
        <div class="battery-icon_ind"></div>
    </div>
<?php } else if ($row->percent_sersor >= 40 && $row->percent_sersor <= 59) { ?>

    <div class="battery-icon_wrapper lvl3">
        <div class="battery-icon_ind"></div>
        <div class="battery-icon_ind"></div>
        <div class="battery-icon_ind"></div>
        <div class="battery-icon_ind"></div>
        <div class="battery-icon_ind"></div>
    </div>
<?php } else if ($row->percent_sersor >= 20 && $row->percent_sersor <= 39) { ?>

    <div class="battery-icon_wrapper lvl2">
        <div class="battery-icon_ind"></div>
        <div class="battery-icon_ind"></div>
        <div class="battery-icon_ind"></div>
        <div class="battery-icon_ind"></div>
        <div class="battery-icon_ind"></div>
    </div>
<?php } else if ($row->percent_sersor >= 0 && $row->percent_sersor <= 19) { ?>

    <div class="battery-icon_wrapper lvl1">
        <div class="battery-icon_ind"></div>
        <div class="battery-icon_ind"></div>
        <div class="battery-icon_ind"></div>
        <div class="battery-icon_ind"></div>
        <div class="battery-icon_ind"></div>
    </div>
<?php } ?>

<!--            <div class="procent-wrapper">-->
<!--                <p class="lvl1">0-20%</p>-->
<!--                <p class="lvl2">20-40%</p>-->
<!--                <p class="lvl3">40-60%</p>-->
<!--                <p class="lvl4">60-80%</p>-->
<!--                <p class="lvl5">80-100%</p>-->
<!--            </div>-->


