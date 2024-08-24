<?php

    $conn_log = mysqli_connect('localhost','root','','mecers_log') ;
    
    if(!$conn_log){
        die("FAILED TO CONNECT" . mysqli_connect_error()) ;
    }


?>