<?php
require 'config/connect.php';
?>
<!DOCTYPE html>
<html data-wf-page="667eb20fe3437181e725d375" data-wf-site="667e887820adad2c42339951">

<head>
    <meta charset="utf-8">
    <title>recoard</title>
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta content="Webflow" name="generator">
    <link href="css/normalize.css" rel="stylesheet" type="text/css">
    <link href="css/webflow.css" rel="stylesheet" type="text/css">
    <link href="css/test-fe43ff.webflow.css" rel="stylesheet" type="text/css">
    <script type="text/javascript">
        !function(o, c) {
            var n = c.documentElement,
                t = " w-mod-";
            n.className += t + "js", ("ontouchstart" in o || o.DocumentTouch && c instanceof DocumentTouch) && (n.className += t + "touch")
        }(window, document);
    </script>
    <link href="images/favicon.ico" rel="shortcut icon" type="image/x-icon">
    <link href="images/webclip.png" rel="apple-touch-icon">
    <link href="./node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="./node_modules/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
</head>

<body>
<div class="div-block-2">
    <div class="text-block"><i class="fa-brands fa-youtube"></i> Record</div>
</div>
<?php
$msg = '';
if (isset($_POST['submit'])) {
    $messagebox = mysqli_real_escape_string($conn, $_POST['messageBox']);
    $messageboxen = mysqli_real_escape_string($conn, $_POST['messageBoxEn']);
    // video
    $video = '';
    if (isset($_FILES['video']['name'])) {
        $video = $_FILES['video']['name'];
        if ($video != "") {
            $tmp = explode('.', $video);
            $ext = end($tmp);
            $video = "video_" . rand(000000, 999999) . "_" . date('dmYHis') . "." . $ext;
            $source_path = $_FILES['video']['tmp_name'];
            $destination_path = "./uploads/video/" . $video;
            $upload = move_uploaded_file($source_path, $destination_path);
            if ($upload == false) {
                $msg = "<div class='alert alert-danger'>เกิดข้อผิดพลาดในการอัปโหลดไฟล์ </div>";
                die();
            }
        }
    }
    $sql_ins = " INSERT INTO tbl_record SET id = NULL, 
                                            video      = '$video',
                                            subtitle_1 = '$messagebox',
                                            subtitle_2 = '$messageboxen' ";
    $result_ins = mysqli_query($conn, $sql_ins);
    if($result_ins){
        $msg = "<div class='alert alert-success'>บันทึกข้อมูลสำเร็จ </div>";
    }
}
?>
<div class="col-11 mt-2 mx-auto"><?= $msg ?></div>
<form action="" method="POST" enctype="multipart/form-data">
    <div class="div-block-copy">
        <div class="w-form">
            <div class="text-center">
                <video id="videoPreview" controls width="95%"></video>
            </div>
            <div class="text-center">
                <button type="button" onclick="document.getElementById('videoUpload').click()" id="w-node-e4cfc3e5-c062-c22f-d586-e67768160d81-e725d375" class="submit-button-2 w-button"><i class="fa-solid fa-cloud-arrow-up"></i> Upload video</button>
                <input class="d-none" name="video" type="file" id="videoUpload" accept="video/mp4,video/x-m4v,video/*">
            </div>
        </div>
        <div id="w-node-_1870a732-3602-21ae-988f-2475c8e0bdf4-e725d375" class="w-form">
            <div id="email-form-2" name="email-form-2" data-name="Email Form 2" method="get" class="form-2" data-wf-page-id="667eb20fe3437181e725d375" data-wf-element-id="1870a732-3602-21ae-988f-2475c8e0bdf5">
                <div class="col-12 d-grid">
                    <button class="submit-button w-button" type="button"><i class="fa-solid fa-earth-americas"></i> Generate
                        text
                        time &amp; script</button>
                </div>
                <div class="col-12 text-center mb-1" id="google_translate_element"></div>
                <textarea placeholder="ข้อความพร้อมเวลา..." rows="10" id="messageBox" name="messageBox" data-name="messageBox" class="textarea w-input"></textarea>
                <div class="col-lg-8 mx-auto gap-2 d-inline text-center">
                    <button class="btn btn-light" type="button" onclick="showText()"><i class="fa-solid fa-repeat"></i>
                        Translate
                        English</button>
                    <button class="btn btn-warning" type="button" onclick="showText2()"><i class="fa-regular fa-copy"></i>
                        Copy</button>
                </div>
                <div id="show-text"></div>
                <textarea placeholder="Put the English message here...." rows="10" id="messageBoxEn" name="messageBoxEn" data-name="messageBoxEn" class="textarea w-input"></textarea>
            </div>
        </div>
    </div>
    <div class="col-lg-4 mx-auto d-grid py-3"><button type="submit" class="btn btn-lg btn-success" name="submit">Save</button></div>
</form>
<script src="https://d3e54v103j8qbb.cloudfront.net/js/jquery-3.5.1.min.dc5e7f18c8.js?site=667e887820adad2c42339951" type="text/javascript" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="js/webflow.js" type="text/javascript"></script>
<script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js" type="text/javascript"></script>
<script>
    document.getElementById('videoUpload').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const videoPreview = document.getElementById('videoPreview');
            const url = URL.createObjectURL(file);
            videoPreview.src = url;
            videoPreview.load();
        }
    });

    document.getElementById('videoPreview').addEventListener('play', function() {
        const video = document.getElementById('videoPreview');
        const messageBox = document.getElementById('messageBox');

        // ตรวจสอบว่า Web Speech API รองรับหรือไม่
        if (!('webkitSpeechRecognition' in window)) {
            alert('Web Speech API is not supported by this browser.');
            return;
        }

        const recognition = new webkitSpeechRecognition();
        recognition.lang = 'th-TH'; // ตั้งค่าภาษาเป็นภาษาไทย
        recognition.continuous = true; // ทำงานอย่างต่อเนื่อง
        recognition.interimResults = true;

        recognition.onresult = function(event) {
            for (let i = event.resultIndex; i < event.results.length; ++i) {
                if (event.results[i].isFinal) {
                    const currentTime = video.currentTime;
                    const minutes = Math.floor(currentTime / 60);
                    const seconds = Math.floor(currentTime % 60);
                    const seconds_out = String(seconds).padStart(2, '0');
                    const transcript = event.results[i][0].transcript;

                    // แสดงข้อความพร้อมเวลาในกล่องข้อความ
                    const message = `(${minutes}:${seconds_out}) ${transcript}\n`;
                    messageBox.value += message;
                }
            }
        };

        recognition.onerror = function(event) {
            console.error('Speech recognition error', event);
        };

        recognition.onend = function() {
            console.log('Speech recognition ended.');
        };

        recognition.start();

        video.onpause = function() {
            recognition.stop();
        };


