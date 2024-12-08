<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebSocket Test</title>
</head>
<body>
<h1>WebSocket Communication</h1>
<button id="sendMessageBtn">ส่งข้อความ</button>
<div id="receivedMessage"></div>
<input type="text" id="roomInput" placeholder="Enter Room Name">
<button id="joinRoomBtn">Join Room</button>

<script src="https://cdn.socket.io/4.6.0/socket.io.min.js"></script>

<script>
    const socket = io('http://localhost:3000');

    socket.on('connect', () => {
        console.log('Connected to server');
    });

    socket.on('updateScore', (data) => {
        document.getElementById('receivedMessage').innerText = `Received: ${JSON.stringify(data)}`;
    });

    document.getElementById('sendMessageBtn').addEventListener('click', () => {
        const message = 'Hello Server';
        socket.emit('scoreUpdate', {
            name: 'John',
            field: 'Math',
            value: 90,
            room: 'classroom1'  // ส่งข้อมูลไปที่ห้อง
        });
        console.log('Message sent:', message);
    });

    document.getElementById('joinRoomBtn').addEventListener('click', () => {
        const room = document.getElementById('roomInput').value;
        if (room) {
            socket.emit('joinRoom', room);
            console.log(`Joining room: ${room}`);
        }
    });
</script>
</body>
</html>
