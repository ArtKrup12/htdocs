<?php

    $conn = mysqli_connect('localhost','root','','mecers') ;
    
    if(!$conn){
        die("FAILED TO CONNECT" . mysqli_connect_error()) ;
    }


?>