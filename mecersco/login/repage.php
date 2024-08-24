<?php
session_start() ;
if(empty($_GET['check'])){
    header("location:../loginmecers") ;
}else{
    $wrong = $_GET['check'] ;
    if($wrong =='err_password'){
        $_SESSION['err_password'] = 'err_password' ;
        header("location:../loginmecers") ;
    }else{
        exit ;
        header("location:../loginmecers") ;
    }
    
}


?>