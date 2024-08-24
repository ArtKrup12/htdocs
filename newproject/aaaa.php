<?php
include 'condb.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ระบบฝากเบิกเอกสาร</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ลำดับ</th>
                                            <th>รหัสกล่อง</th>
                                            <th>หมายเลขกล่อง</th>
                                            <th>ฝ่าย</th>
                                            <th>รายละเอียด</th>
                                        </tr>
                                    </thead>
                                    <tbody>

<?php
    $sql ="SELECT * FROM tb_carton ORDER BY box_code DESC" ;
    $result=mysqli_query($conn,$sql);
    while($row=mysqli_fetch_array($result)){
?>

                                        <tr>
                                            <td><?=$row["id"]?></td>
                                            <td><?=$row["box_code"]?></td>
                                            <td><?=$row["box_number"]?></td>
                                            <td><?=$row["cotton"]?></td>
                                            <td><?=$row["detaile"]?></td>
                                        </tr>
                                        
<?php
}
    mysqli_close($conn);
?>

                                    </tbody>
                                </table>

</body>

</html>