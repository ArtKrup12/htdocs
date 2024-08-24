<?php

    include('auth/auth_login.php') ;
    include('database_connect/conn.php') ;
    include('database_connect/conn_log.php') ;



        $List_id = $_GET['list_id'] ;
        ob_end_clean();
        require('fpdf185/fpdf.php') ;

        $pdf = new FPDF() ;

        $result_wait = $conn->query ( "SELECT *  FROM list WHERE List_id = '$List_id'" );
         $row_wait = mysqli_fetch_assoc($result_wait) ; 

         $pdf = new FPDF('L') ;
         $pdf->AddPage() ;
         $pdf->AddFont('THSarabunNew','','THSarabunNew.php');
         $pdf->AddFont('THSarabunNew','B','THSarabunNew_b.php');

         $pdf->SetFont('THSarabunNew','B',10) ;
         $pdf->SetFont('THSarabunNew','B',18) ;
         $pdf->SetY(20) ;
         $pdf->Cell(0,10,iconv('utf-8','cp874','รายการเบิกเครื่องมือมาตรฐานสอบเทียบเครื่องมือแพทย์ ออกปฏิบัติราชการ ศูนย์สนับสนุนบริการสุขภาพที่7'),0,1,'C') ;
         
         $pdf->SetFont('THSarabunNew','',10);
         $pdf->SetFont('THSarabunNew','',16);

         $pdf->Cell(0,10,iconv('utf-8','cp874','รายการที่ :'.' '.$_GET['list_id'].'        '.'วันที่ : '.$row_wait['List_time']),0,1,'C') ;
         $pdf->Cell(0,10,iconv('utf-8','cp874','สถานที่ : '.$row_wait['Hospital']),0,0,'C') ;
         $result = $conn->query ( "SELECT Tool_id FROM list_detail WHERE List_id = '$List_id'" );
         $row = mysqli_fetch_assoc($result) ; 
         $i=0 ;
         $h = 7 ;

         $pdf->SetFont('THSarabunNew','B',10) ;
         $pdf->SetFont('THSarabunNew','B',14) ;

         $pdf->SetY(50) ;

         $pdf->Cell(10,5,iconv('utf-8','cp874','ลำดับ'),1,0,'C') ;
         $pdf->Cell(30,5,iconv('utf-8','cp874','เลขครุภัณฑ์'),1,0,'C') ;
         $pdf->Cell(150,5,iconv('utf-8','cp874','รายการ'),1,0,'C') ;
         $pdf->Cell(18,5,iconv('utf-8','cp874','ยี่ห้อ'),1,0,'C') ;
         $pdf->Cell(30,5,iconv('utf-8','cp874','รุ่น'),1,0,'C') ;
         $pdf->Cell(0,5,iconv('utf-8','cp874','SN'),1,1,'C') ;

         $pdf->SetFont('THSarabunNew','',10);
         $pdf->SetFont('THSarabunNew','',14);

        do{
            $ToolId = $row['Tool_id'] ;
            $result_tool = $conn->query ( "SELECT code,ToolName,Brand,Model,SN  FROM tooldata WHERE ToolId = '$ToolId'" );
            $row_tool = mysqli_fetch_assoc($result_tool) ; 
            $i++ ;
         

            $pdf->Cell(10,$h,iconv('utf-8','cp874',$i),1,0,'C') ;
         $pdf->Cell(30,$h,iconv('utf-8','cp874',$row_tool['code']),1,0,'C') ;


          $r = 500 ;
          $pdf->SetFont('THSarabunNew','',13);
        $pdf->Cell(150,$h,substr(iconv('utf-8','cp874', $row_tool['ToolName']),0,$r) ,1,0,'C') ;
        $pdf->SetFont('THSarabunNew','',14);
       
           
        

          $pdf->Cell(18,$h,iconv('utf-8','cp874',$row_tool['Brand']),1,0,'C') ;
         $pdf->Cell(30,$h,iconv('utf-8','cp874',$row_tool['Model']),1,0,'C') ;
         $pdf->Cell(0,$h,substr(iconv('utf-8','cp874',$row_tool['SN']),0,20) ,1,1,'C') ;

        }while($row = mysqli_fetch_assoc($result)) ;
        
        $pdf->Cell(10,$h,iconv('utf-8','cp874','-'),1,0,'C') ;
        $pdf->Cell(30,$h,iconv('utf-8','cp874','0'),1,0,'C') ;
        $pdf->Cell(150,$h,iconv('utf-8','cp874','labtop'),1,0,'C') ;
        $pdf->Cell(18,$h,iconv('utf-8','cp874','-'),1,0,'C') ;
        $pdf->Cell(30,$h,iconv('utf-8','cp874','-'),1,0,'C') ;
        $pdf->Cell(0,$h,iconv('utf-8','cp874','-'),1,1,'C') ;

        $pdf->Cell(10,$h,iconv('utf-8','cp874','-'),1,0,'C') ;
        $pdf->Cell(30,$h,iconv('utf-8','cp874','0'),1,0,'C') ;
        $pdf->Cell(150,$h,iconv('utf-8','cp874','ปริ๊นเตอร์'),1,0,'C') ;
        $pdf->Cell(18,$h,iconv('utf-8','cp874','-'),1,0,'C') ;
        $pdf->Cell(30,$h,iconv('utf-8','cp874','-'),1,0,'C') ;
        $pdf->Cell(0,$h,iconv('utf-8','cp874','-'),1,1,'C') ;

        $pdf->Cell(10,$h,iconv('utf-8','cp874','-'),1,0,'C') ;
        $pdf->Cell(30,$h,iconv('utf-8','cp874','0'),1,0,'C') ;
        $pdf->Cell(150,$h,iconv('utf-8','cp874','กระเป๋าเครื่องมือ'),1,0,'C') ;
        $pdf->Cell(18,$h,iconv('utf-8','cp874','-'),1,0,'C') ;
        $pdf->Cell(30,$h,iconv('utf-8','cp874','-'),1,0,'C') ;
        $pdf->Cell(0,$h,iconv('utf-8','cp874','-'),1,1,'C') ;



        $pdf->SetFont('THSarabunNew','B',10) ;
        $pdf->SetFont('THSarabunNew','B',16) ;

     
            

            $EmpId = $row_wait['Emp_id'] ;
            $result_emp = $conn->query ( "SELECT *  FROM emphss7 INNER JOIN prefix ON prefix.Prefix_id = emphss7.Prefix_id WHERE Emp_id = '$EmpId'" );
            $row_emp = mysqli_fetch_assoc($result_emp) ; 

            $ap = $row_wait['app_id'] ;

            $result_ap = $conn->query ( "SELECT *  FROM emphss7 INNER JOIN prefix ON prefix.Prefix_id = emphss7.Prefix_id  WHERE Emp_id = '$ap'" );
            $row_ap = mysqli_fetch_assoc($result_ap) ; 

          
      
        $pdf->Cell(50,30,iconv('utf-8','cp874',''),0,1,'C') ;
        $pdf->Cell(50,$h,iconv('utf-8','cp874','วันที่ยืม '),1,0,'C') ;
        $pdf->Cell(100,$h,iconv('utf-8','cp874','ผู้ยืม '),1,0,'C') ;
        $pdf->Cell(0,$h,iconv('utf-8','cp874','ผู้อนุมัติ '),1,1,'C') ;

        $pdf->SetFont('THSarabunNew','',10);
        $pdf->SetFont('THSarabunNew','',16);

        $pdf->Cell(50,$h+3,iconv('utf-8','cp874',$row_wait['Date_use']),1,0,'C') ;
        $pdf->Cell(100,$h+3,iconv('utf-8','cp874',$row_emp['Prefix_name'].$row_emp['Emp_name'].' '.$row_emp['Emp_lastname']),1,0,'C') ;
        $pdf->Cell(0,$h+3,iconv('utf-8','cp874',$row_ap['Prefix_name'].$row_ap['Emp_name'].' '.$row_ap['Emp_lastname']),1,1,'C') ;

        $pdf->SetFont('THSarabunNew','B',10) ;
        $pdf->SetFont('THSarabunNew','B',16) ;

        $pdf->Cell(50,-1,iconv('utf-8','cp874',''),0,1,'C') ;
        $pdf->Cell(50,$h,iconv('utf-8','cp874',''),0,1,'C') ;
        $pdf->Cell(50,$h,iconv('utf-8','cp874','วันที่คืน '),1,0,'C') ;
        $pdf->Cell(100,$h,iconv('utf-8','cp874','ผู้คืน '),1,0,'C') ;
        $pdf->Cell(0,$h,iconv('utf-8','cp874','ผู้อนุมัติ '),1,1,'C') ;

        $pdf->SetFont('THSarabunNew','',10);
        $pdf->SetFont('THSarabunNew','',16);

        $pdf->Cell(50,$h+3,iconv('utf-8','cp874',$row_wait['Date_return']),1,0,'C') ;
        
        $pdf->Cell(100,$h+3,iconv('utf-8','cp874',$row_emp['Prefix_name'].$row_emp['Emp_name'].' '.$row_emp['Emp_lastname']),1,0,'C') ;
        $pdf->Cell(0,$h+3,iconv('utf-8','cp874',$row_ap['Prefix_name'].$row_ap['Emp_name'].' '.$row_ap['Emp_lastname']),1,1,'C') ;
        
        // $x = $pdf->GetY();
        // $pdf->Image('./uploads/'.$row_ap['imagename'],150,$x+20,30);
        // $pdf->Cell(310,$x-10,iconv('utf-8','cp874','ผู้อนุมัติ '),0,1,'C') ;

        $pdf->SetFont('THSarabunNew','',10);
        $pdf->SetFont('THSarabunNew','',16);

        
         $pdf->Output() ;

         $id = $_SESSION['Emp_id'] ;
         $insert_log = "INSERT INTO log_in_mecers(Who,Action) VALUES ('$id','มีการเรียกดู หรือดาวน์โหลด PDF')";
         $log = mysqli_query($conn_log, $insert_log) ;



?>