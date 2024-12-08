<?php
session_start();
// connect.php
$_SESSION["Title"]='ST webservice';
date_default_timezone_set("Asia/Bangkok");

$db_config=array(
    "host"=>"localhost",  // กำหนด host
    /*
       "user"=>"motorwor_order", // กำหนดชื่อ user
        "pass"=>"GqmVGEHaEhEWsP8eunru",   // กำหนดรหัสผ่าน
        "dbname"=>"motorwor_order",  // กำหนดชื่อฐานข้อมูล
    */
    "user"=>"root",
    "pass"=>'',
    "dbname"=>"motorwor_dev",

    "charset"=>"utf8"  // กำหนด charset
);
$mysqli=@new mysqli($db_config["host"], $db_config["user"], $db_config["pass"], $db_config["dbname"]);

if(mysqli_connect_error()) {
    die('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
    exit;
}

if(!$mysqli->set_charset($db_config["charset"])) {
}else{

}

?>