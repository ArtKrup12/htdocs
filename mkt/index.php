<?php
$host = "www.jsgroup1973.com";
$username = "mazdabur";
$password = "PswPGe48";
$dbname = "mazdabur_siamjs";

$conn = mysqli_connect($host, $username, $password, $dbname);
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}else{
    echo $conn;
}
?>