<?php
    include('../auth/auth_login.php');
    include('../database_connect/conn.php') ;
    include('../database_connect/conn_log.php') ;

    if(isset($_POST['delete_sheet'])){

        $list_id = $_POST['delete_sheet'] ;
        $i = 0 ;

        $query_list_detail = $conn->query ( "SELECT * FROM list_detail WHERE List_id = $list_id"); 
        while($list_detail_id = mysqli_fetch_assoc( $query_list_detail) ){
            $Tool_id = $list_detail_id['Tool_id'] ;
            $result = $conn->query ( "SELECT ToolId FROM tooldata WHERE ToolId = $Tool_id ");
                    while($resultid = mysqli_fetch_assoc($result)){
                        $i++ ;
                        $id =  $resultid['ToolId'] ;
                        $Stock_toolid[$i] = ($id) ;
                    }
                    
        }
        print_r($Stock_toolid) ;

        $count_tool_id = 0 ;
        $do_loop = 0 ;
        foreach ($Stock_toolid as $el) {
            $count_tool_id++ ;
        }

        do{
            $do_loop++ ;
            $ToolId = $Stock_toolid[$do_loop] ;
              
             $update =  "UPDATE tooldata 
            SET `Stock`= 1 
            WHERE ToolId = '$ToolId' " ;
            $result = mysqli_query($conn,$update) ;
    
        }while($do_loop < $count_tool_id) ; 

         $delete_list = "DELETE FROM list WHERE List_id = $list_id " ;
         $delete = mysqli_query($conn, $delete_list) ;

         $id = $_SESSION['Emp_id'] ;
         $insert_log = "INSERT INTO log_in_mecers(Who,Action) VALUES ('$id','ลบรายการขอใช้')";
         $log = mysqli_query($conn_log, $insert_log) ;
         
        header("location:../userpage/status") ;

    }else{
        header("location:../userpage/status") ;
    }

?>