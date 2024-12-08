<?php
 //session_start();
$timeout =30; // Set timeout minutes
$logout_redirect_url = "login.php"; // Set logout URL

$timeout = $timeout * 60; // Converts minutes to seconds
if (isset($_SESSION['start_time'])) {
    $elapsed_time = time() - $_SESSION['start_time'];
    if ($elapsed_time >= $timeout) {
        session_destroy();
       // header("Location: $logout_redirect_url");
	   header("location:login.php");
    }
}
$_SESSION['start_time'] = time();

 
 if(($_SESSION["logpass"]!=101) or ($_SESSION["logpass"]==0)){
       header("location:login.php");
 }else;
?>