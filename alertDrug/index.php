<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบแจ้งเตือนยาหมดอายุ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>
<div class="d-flex justify-content-center align-items-center">
    <div class="container d-flex flex-column align-items-center w-25">
        <div class="logo d-flex text-center flex-column">
            <img src="images/logo.png" alt="logo" class="align-self-center">
            <span class="name my-2">ป.2 พัน 102 รอ</span>
        </div>
        <div class="login d-flex flex-column align-items-center">
            <input type="text" class="form-control username my-2" id="userName" name="userName" placeholder="ชื่อผู้ใช้"></input>
            <input type="text" class="form-control password my-2" id="passWord" name="passWord" placeholder="รหัสผ่าน"></input>
            <button class="btn btn-success my-2 w-50 login_check">login</button>
        </div>
    </div>
</div>
</body>

</html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js" integrity="sha512-+k1pnlgt4F1H8L7t3z95o3/KO+o78INEcXTbnoJQ/F2VqDVhWoaiVml/OEHv9HsVgxUaVW+IbiZPUJQfF/YxZw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    // jquery
    $(document).ready(function() {
        $('.login_check').click(function () {
            let userName = $('#userName').val()
            let passWord = $('#passWord').val()
            // console.log(userName,passWord)
            $.ajax({
                url: 'controller/login_check.php',
                method: 'POST',
                data:{
                    userName,passWord
                },
                success: function(data) {
                    let res = JSON.parse(data)
                    console.log(res);
                    if(res.status === 200){
                        location.href = 'MilitaryWorkHard'
                    }else {
                        alert(res.message)
                    }
                }
            })
        })
    })
</script>