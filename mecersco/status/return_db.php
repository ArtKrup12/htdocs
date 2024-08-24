<?php

include('../auth/auth_login.php');
include('../database_connect/conn.php') ;
include('../database_connect/conn_log.php') ;


    if(isset($_POST['return'])){
       $note = $_POST['note'] ;
    
       print_r($note) ;
       
     //  print_r($note) ;
        $i=0 ;
        $List_id = $_POST['return'] ;
        $query_tool_list_detail = $conn->query("SELECT * FROM list_detail  WHERE List_id =  $List_id " );
        while($data_tool = mysqli_fetch_assoc( $query_tool_list_detail)) { 

            $tool_id = $data_tool['Tool_id'] ;
            $query_tool_id_list_detail = $conn->query("SELECT * FROM list_detail  WHERE Tool_id =  $tool_id " );
            while($data_tool_id = mysqli_fetch_assoc( $query_tool_id_list_detail)) { 

             $Note = $note[$i] ;
             $id = $data_tool_id['Tool_id'] ;

                $update_note =  "UPDATE list_detail
                SET `note_listdetail`=  '$Note'
                WHERE Tool_id = ' $id' " ;
                $result = mysqli_query($conn,$update_note) ;
        
            $Note = '' ;
            $i++ ;
           // echo $i ;
        }
    }


        $update =  "UPDATE list 
        SET `List_status`= 'app_return' 
        WHERE List_id = ' $List_id' " ;
        $result = mysqli_query($conn,$update) ;

        $id = $_SESSION['Emp_id'] ;
        $insert_log = "INSERT INTO log_in_mecers(Who,Action) VALUES ('$id','ขอคืนเครื่องมือ')";
        $log = mysqli_query($conn_log, $insert_log) ;

        header("location:../userpage/status") ;
    }else{

        header("location:../userpage/status") ;

    }



?>