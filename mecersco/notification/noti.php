   <!-- SweatAlert2 -->
   <script src="node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="node_modules/sweetalert2/dist/sweetalert2.min.css">


   
    <?php  //รหัสผ่านไม่ถูกต้อง  
    if(isset($_SESSION['err_password'])) : ?>
    <script>
    Swal.fire({
        title: 'รหัสผ่านไม่ถูกต้อง',
        text: 'กรุณากรอกรหัสผ่าน หรือ เลือกชื่อผู้ใช้งาน',
        icon: 'warning',
        iconColor : 'red',
        confirmButtonText: 'ok',
    }, function() {
        location.reload(true);
        tr.hide();
    })
    </script>
    <?php endif ; ?>

   










    


