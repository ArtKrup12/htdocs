<?php

echo 'success' ;
include "../config.php";

$data = $_POST['data_id'] ;
$exploded_data = explode("-", $data);
$sqlIns = $mysqli->query("INSERT INTO draft_head(sale_id,assign_id,sale_detail_id) VALUES('$exploded_data[0]','$exploded_data[1]','$exploded_data[2]')");

?>