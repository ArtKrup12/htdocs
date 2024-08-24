<?php


$query_noti_list = $conn->query ( "SELECT * FROM list WHERE List_status = 'wait_app' OR List_status = 'app_return'  " ) ;
$noticount = mysqli_num_rows($query_noti_list) ;

?>