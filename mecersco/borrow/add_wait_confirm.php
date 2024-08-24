<?php
    include('../auth/auth_login.php') ;
    include('../database_connect/conn.php') ;
    include('../database_connect/conn_log.php') ;

    $date1 =  $_POST['dateborrow'] ;
    $date2 = $_POST['datereturn'] ;

    if($date1>$date2){
        $_SESSION['datewrong'] = 'date ไม่ถูกต้อง' ;
        header("location:../userpage/borrow") ;
    }else{
        if(empty($_POST['location'])){
  
            header("location:../userpage/borrow") ;
        
           }else{

            $check = 0 ;
            $id =  $_SESSION['Emp_id'] ;
            $query_tool_id = $conn->query ( "SELECT ToolId FROM tooldata WHERE Stock = 0"); 
            $query_tool_id_temp = $conn->query ( "SELECT Tool_id FROM temp_list WHERE Emp_id = '$id'");
            while($tool_id = mysqli_fetch_assoc($query_tool_id)){

                $tool_id_check = mysqli_fetch_assoc($query_tool_id_temp) ;
                if(empty($tool_id_check)){

                }else{
                    if($tool_id['ToolId'] == $tool_id_check['Tool_id']){
                        $check++ ;
    
                        $T_id = $tool_id['ToolId'] ;
                        $delete_temp_list = "DELETE FROM temp_list WHERE Emp_id = $id AND Tool_id = '$T_id'" ;
                        $delete = mysqli_query($conn, $delete_temp_list) ;
                    }
                }
                
            }
            if($check > 0){


                header("location:../userpage/borrow") ;
            }else{

                if(isset($_POST['add_list'])){
                
                    $date_use =  $_POST['dateborrow'] ;
                    $date_return = $_POST['datereturn'] ;
                
                    $location_id = $_POST['location'] ;
                    $Hospital_name = implode(" ",$location_id) ;
                
                    $Emp_id =  $_SESSION['Emp_id'] ;
                        
                    $insert = "INSERT INTO list(Date_use, Date_return, List_status, Emp_id, Hospital) /*  insert to list  */
                    VALUES ('$date_use','$date_return','wait_app',$Emp_id,'$Hospital_name')";
                    $insertprocess = mysqli_query($conn, $insert) ;

                      
                    $id = $_SESSION['Emp_id'] ;
                    $insert_log = "INSERT INTO log_in_mecers(Who,Action) VALUES ('$id','สร้ายรายการขอใช้')";
                    $log = mysqli_query($conn_log, $insert_log) ;
                            
                
                    $query_list_id = $conn->query ( "SELECT List_id FROM list ORDER BY List_id DESC LIMIT 1"); /*  select List_no  */
                    $list_id = mysqli_fetch_assoc($query_list_id) ;
                    $List_id = $list_id['List_id'] ;
                
                    $count_tool_id = 0 ;
                    $do_loop = 0 ;
                    $i = 0 ;
                
                    $query_tool_id = $conn->query ( "SELECT Tool_id FROM temp_list WHERE Emp_id = $Emp_id"); /* insert to list_detail */
                    while($row_tool_id = mysqli_fetch_assoc($query_tool_id)){
                
                        $Tool_id = $row_tool_id['Tool_id'] ;
                        echo $Tool_id ;
                        $result = $conn->query ( "SELECT ToolId FROM tooldata WHERE ToolId = $Tool_id ");
                        while($resultid = mysqli_fetch_assoc($result)){
                            $i++ ;
                            $id =  $resultid['ToolId'] ;
                            $Stock_toolid[$i] = ($id) ;
                        }
                
                    } /* insert to list_detail */
                
                
                    foreach ($Stock_toolid as $el) {
                        $count_tool_id++ ;
                    }
                
                    do{
                        $do_loop++ ;
                        $ToolId = $Stock_toolid[$do_loop] ;
                         $insert_list_detail = "INSERT INTO list_detail(List_id,Tool_id) VALUES('$List_id','$ToolId') " ;
                         $insertprocess_detailwaitconfirm = mysqli_query($conn,  $insert_list_detail) ;  
                         
                        $update =  "UPDATE tooldata 
                        SET `Stock`= 0 
                        WHERE ToolId = '$ToolId'  " ;
                        $result = mysqli_query($conn,$update) ;
                
                    }while($do_loop < $count_tool_id) ; 
                
                    $delete_temp_list = "DELETE FROM temp_list WHERE Emp_id = $Emp_id " ;
                    $delete = mysqli_query($conn, $delete_temp_list) ;
                
                    print_r( $Stock_toolid) ;
                
                
                    header("location:../userpage/status") ;
                    }else{
                        echo 'no submit' ;
                    }
                
            }
                
           
           }
        
           
    }

   


?>