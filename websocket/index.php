<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>กรอกคะแนนแบบเรียลไทม์</title>
    <!-- ใช้ Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.socket.io/socket.io-1.7.0.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h3>ตารางกรอกคะแนน</h3>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ชื่อ</th>
            <th>A</th>
            <th>B</th>
            <th>C</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>name A</td>
            <td><input type="number" class="form-control score-input" data-name="nameA" data-field="A" placeholder="คะแนน"></td>
            <td><input type="number" class="form-control score-input" data-name="nameA" data-field="B" placeholder="คะแนน"></td>
            <td><input type="number" class="form-control score-input" data-name="nameA" data-field="C" placeholder="คะแนน"></td>
        </tr>
        <tr>
            <td>name B</td>
            <td><input type="number" class="form-control score-input" data-name="nameB" data-field="A" placeholder="คะแนน"></td>
            <td><input type="number" class="form-control score-input" data-name="nameB" data-field="B" placeholder="คะแนน"></td>
            <td><input type="number" class="form-control score-input" data-name="nameB" data-field="C" placeholder="คะแนน"></td>
        </tr>
        </tbody>
    </table>

    <div class="mb-3">
        <label for="roomInput" class="form-label">ชื่อห้อง</label>
        <input type="text" class="form-control" id="roomInput" placeholder="Enter Room Name">
        <button id="joinRoomBtn" class="btn btn-primary mt-2">Join Room</button>
    </div>
</div>

<!-- ใช้ Bootstrap 5 JS และ Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

<script>
    const socket = io('http://localhost:3003');  // เชื่อมต่อกับ server
    let room = '';

    // เมื่อเชื่อมต่อกับ server
    socket.on('connect', function() {
        console.log('Connected to server');
    });

    // เมื่อผู้ใช้คลิกปุ่ม Join Room
    $('#joinRoomBtn').on('click', function() {
        room = $('#roomInput').val();  // รับชื่อห้องจาก input
        if (room) {
            socket.emit('joinRoom', room);  // เข้าร่วมห้อง
            console.log('Joining room:', room);
        } else {
            alert('กรุณากรอกชื่อห้อง');
        }
    });

    // ฟัง event เมื่อมีการกรอกคะแนน
    $('.score-input').on('input', function() {
        const name = $(this).data('name');
        const field = $(this).data('field');
        const score = $(this).val();
        if (room) {
            // ส่งข้อมูลคะแนนไปยัง server
            socket.emit('scoreUpdate', { name, field, score, room });
        }
    });

    // เมื่อได้รับข้อมูลคะแนนจาก server
    socket.on('updateScore', function(data) {
        // อัปเดตข้อมูลในตารางสำหรับทุกคนในห้อง
        console.log(data)
        if (data.room === room) {
            $(`input[data-name="${data.name}"][data-field="${data.field}"]`).val(data.score);
        }
    });
</script>
</body>
</html>
